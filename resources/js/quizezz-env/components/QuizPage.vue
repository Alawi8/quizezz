<template>
    <div class="p-4 min-h-screen bg-white dark:bg-black">
        <Header :duration="test?.duration" @time-up="handleTestEnd" />

        <div v-if="!testEnded && questionsVisible" class="flex flex-row gap-4">
            <div class="question-scroll w-20 h-screen overflow-y-auto flex flex-col gap-2 p-2 items-center border rounded">
                <button
                    v-for="(q, i) in questions"
                    :key="q.id"
                    @click="currentIndex = i"
                    :class="[
                        'w-10 h-10 rounded-full border text-sm font-bold flex items-center justify-center shrink-0',
                        currentIndex === i
                            ? 'bg-green-600 text-white'
                            : userAnswers[q.id]
                            ? 'bg-blue-100 text-blue-800 border-blue-400'
                            : 'bg-white text-green-600 border-green-600'
                    ]"
                >
                    {{ i + 1 }}
                </button>
            </div>

            <div class="flex-1 w-full">
                <div v-if="currentQuestion" class="p-4 border rounded shadow">
                    <div v-if="flashMessage" class="mb-4">
                        <div
                            :class="flashError ? 'bg-red-100 text-red-800 border border-red-300' : 'bg-green-100 text-green-800 border border-green-300'"
                            class="px-4 py-2 rounded transition-opacity duration-300"
                        >
                            {{ flashMessage }}
                        </div>
                    </div>

                    <h2 class="text-lg md:text-xl font-semibold mb-4">
                        {{ currentIndex + 1 }}. {{ currentQuestion.question_text }}
                    </h2>

                    <ul class="space-y-4 w-full">
                        <li
                            v-for="(answer, index) in currentQuestion.answers"
                            :key="answer.id"
                            class="w-full"
                            @contextmenu.prevent="strikeAnswer(answer)"
                        >
                            <label
                                class="flex items-center space-x-4 w-full p-4 border rounded-lg cursor-pointer transition-all duration-300 text-lg"
                                :class="[
                                    strikedAnswers.includes(answer.id)
                                        ? 'line-through bg-red-500 text-white opacity-75 border-red-400'
                                        : userAnswers[currentQuestion.id] === answer.id
                                        ? 'bg-green-600 text-white border-green-700'
                                        : 'bg-white text-green-800 border-green-300 hover:bg-gray-100'
                                ]"
                                @click="selectAnswer(answer)"
                            >
                                <span class="font-bold text-lg">
                                    {{ String.fromCharCode(65 + index) }}.
                                </span>
                                <span class="flex-1">{{ answer.answer_text }}</span>
                            </label>
                        </li>
                    </ul>
                </div>

                <div v-else class="text-gray-500 mt-4">Loading...</div>
            </div>
        </div>

        <div v-if="testEnded" class="text-center mt-10 text-green-600 text-xl font-bold">
            {{ endMessage }}
        </div>

        <Footer />
    </div>
</template>

<script setup>
import { provide, ref, onMounted, computed, nextTick } from 'vue'
import axios from '@/auth/axios'
import useUserAuth from '@/composable/userAuth.js'
import Header from '@/quizezz-env/layouts/Header.vue'
import Footer from '@/quizezz-env/layouts/Footer.vue'

const currentIndex = ref(0)
const selectedAnswer = ref(null)
const strikedAnswers = ref([])
const flashMessage = ref(null)
const flashError = ref(false)
const userAnswers = ref({})

const { token } = useUserAuth()
const questions = ref([])
const error = ref(null)
const currentQuestion = computed(() => questions.value[currentIndex.value])

const test = ref(null)
const testEnded = ref(false)
const questionsVisible = ref(true)
const endMessage = ref('')

function handleTestEnd() {
    testEnded.value = true
    questionsVisible.value = false
    endMessage.value = '✅ The test has ended. Thank you for your participation.'
}

function getTestIdFromUrl() {
    const parts = window.location.pathname.split('/')
    return parts[parts.length - 1] || null
}

const testId = getTestIdFromUrl()

async function fetchQuestions() {
    try {
        if (!testId) throw new Error('Test ID not found in URL.')
        const res = await axios.get(`/api/student/question/${testId}`, {
            headers: { Authorization: `Bearer ${token.value}` }
        })
        const shuffled = res.data.data.sort(() => 0.5 - Math.random())
        questions.value = shuffled
        await fetchUserAnswers()
        await nextTick(() => {
            scrollToQuestion(currentIndex.value)
            syncSelectedAnswer()
        })

        const testRes = await axios.get(`/api/test`, {
            headers: { Authorization: `Bearer ${token.value}` }
        })
        test.value = testRes.data

    } catch (err) {
        error.value = err.response?.data?.message || err.message || 'Error loading questions'
        console.error('Fetch Error:', error.value)
    }
}

async function fetchUserAnswers() {
    try {
        const res = await axios.get(`/api/student/user-answers`, {
            headers: { Authorization: `Bearer ${token.value}` }
        })
        userAnswers.value = res.data || {}
    } catch (err) {
        console.error('Failed to fetch user answers')
    }
}

function syncSelectedAnswer() {
    const savedAnswer = userAnswers.value[currentQuestion.value?.id]
    selectedAnswer.value = savedAnswer || null
}

function resetSelections() {
    strikedAnswers.value = []
    flashMessage.value = null
    flashError.value = false
}

function selectAnswer(answer) {
    selectedAnswer.value = answer.id
    strikedAnswers.value = []
    submitAnswer(currentQuestion.value.id, answer.id)
}

function strikeAnswer(answer) {
    if (!strikedAnswers.value.includes(answer.id)) {
        strikedAnswers.value.push(answer.id)
    } else {
        strikedAnswers.value = strikedAnswers.value.filter(id => id !== answer.id)
    }
}

async function submitAnswer(questionId, answerId) {
    try {
        const res = await axios.post(
            `/api/student/submit-answer`,
            { question_id: questionId, answer_id: answerId },
            { headers: { Authorization: `Bearer ${token.value}` } }
        )
        flashMessage.value = res.data?.message || '✅ Answer submitted successfully'
        flashError.value = false
        userAnswers.value[questionId] = answerId
        selectedAnswer.value = answerId
    } catch (err) {
        flashMessage.value = err.response?.data?.message || '❌ Failed to submit answer'
        flashError.value = true
        console.error('Submit error:', err)
    }

    setTimeout(() => {
        flashMessage.value = null
    }, 3000)
}

function scrollToQuestion(index) {
    const buttons = document.querySelectorAll('.question-scroll button')
    if (buttons[index]) {
        buttons[index].scrollIntoView({ behavior: 'smooth', block: 'center' })
    }
}

provide('prevQuestion', () => {
    if (currentIndex.value > 0) {
        currentIndex.value--
        scrollToQuestion(currentIndex.value)
        resetSelections()
        syncSelectedAnswer()
    }
})

provide('nextQuestion', () => {
    if (currentIndex.value < questions.value.length - 1) {
        currentIndex.value++
        scrollToQuestion(currentIndex.value)
        resetSelections()
        syncSelectedAnswer()
    }
})

onMounted(fetchQuestions)
</script>

<style scoped>
::-webkit-scrollbar {
    display: none;
}
.line-through {
    text-decoration: line-through;
}
</style>
