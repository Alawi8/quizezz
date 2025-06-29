<template>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-green-50 dark:from-gray-900 dark:to-black">
        <!-- Loading State -->
        <div v-if="loading" class="flex items-center justify-center min-h-screen">
            <div class="text-center">
                <div
                    class="w-16 h-16 border-4 border-green-200 border-t-green-600 rounded-full animate-spin mx-auto mb-4">
                </div>
                <p class="text-gray-600 dark:text-gray-400">Loading quiz...</p>
            </div>
        </div>

        <!-- Error State -->
        <div v-else-if="error" class="flex items-center justify-center min-h-screen">
            <div
                class="text-center p-8 bg-red-50 dark:bg-red-900/20 rounded-xl border border-red-200 dark:border-red-800">
                <div
                    class="w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                        </path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-red-800 dark:text-red-200 mb-2">Error Loading Quiz</h2>
                <p class="text-red-600 dark:text-red-400 mb-4">{{ error }}</p>
                <button @click="retryLoading" class="btn-primary">
                    Try Again
                </button>
            </div>
        </div>

        <!-- Quiz Content -->
        <div v-else class="pb-24">
            <Header :quiz-data="test" :current-question="currentIndex + 1" :total-questions="questions.length"
                :answered-questions="answeredQuestionsCount" :test-ended="testEnded" :is-fullscreen="isFullscreen"
                @time-up="handleTestEnd" @exit-test="handleTestEnd" @toggle-fullscreen="toggleFullscreen" />

            <!-- Test Ended State -->
            <div v-if="testEnded" class="container mx-auto px-4 py-8">
                <div
                    class="max-w-2xl mx-auto text-center bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 border border-gray-200 dark:border-gray-700">
                    <div
                        class="w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Quiz Completed!</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">{{ endMessage }}</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button @click="viewResults" class="btn-primary">
                            View Results
                        </button>
                        <button @click="goHome" class="btn-secondary">
                            Back to Home
                        </button>
                    </div>
                </div>
            </div>

            <!-- Active Quiz -->
            <div v-else-if="questionsVisible && questions.length > 0" class="container mx-auto px-4 py-6">
                <div class="flex flex-row gap-4 h-full">
                    <!-- Questions Sidebar -->
                    <div class="w-20 flex-shrink-0">
                        <QuestionsList :questions="questions" :currentIndex="currentIndex" :userAnswers="userAnswers"
                            :bookmarkedQuestions="bookmarkedQuestions" @changeQuestion="changeQuestion" />
                    </div>

                    <!-- Main Question Area -->
                    <div class="flex-1 min-h-0">
                        <QuestionComponent v-if="currentQuestion" :question="currentQuestion"
                            :questionIndex="currentIndex" :selectedAnswer="selectedAnswer" :userAnswers="userAnswers"
                            :strikedAnswers="strikedAnswers" @selectAnswer="selectAnswer"
                            @strikeAnswer="strikeAnswer" />
                    </div>
                </div>

                <!-- Progress Indicator -->
                <div
                    class="fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-white dark:bg-gray-800 px-4 py-2 rounded-full shadow-lg border border-gray-200 dark:border-gray-700">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ currentIndex + 1 }} / {{ questions.length }}
                    </span>
                </div>
            </div>

            <Footer />
        </div>

        <!-- Flash Message -->
        <Transition name="flash">
            <div v-if="flashMessage" class="fixed top-20 right-4 z-50 p-4 rounded-lg shadow-lg border max-w-sm" :class="[
                flashError
                    ? 'bg-red-50 border-red-200 text-red-800 dark:bg-red-900/20 dark:border-red-800 dark:text-red-200'
                    : 'bg-green-50 border-green-200 text-green-800 dark:bg-green-900/20 dark:border-green-800 dark:text-green-200',
                isFullscreen ? 'fixed top-4 right-4' : 'fixed top-20 right-4'
            ]">
                <div class="flex items-center space-x-2">
                    <svg v-if="!flashError" class="w-5 h-5 text-green-600 dark:text-green-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <svg v-else class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                    <span class="text-sm font-medium">{{ flashMessage }}</span>
                </div>
            </div>
        </Transition>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, provide, watch, onUnmounted } from 'vue'
import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';
import useUserAuth from '@/composable/userAuth.js';
import Header from '../layouts/Header.vue'
import Footer from '../layouts/Footer.vue'
import QuestionsList from './quiz/QuestionsList.vue'
import QuestionComponent from './quiz/QuestionComponent.vue'

// Types
interface Question {
    id: number
    question_text: string
    answers: Answer[]
}

interface Answer {
    id: number
    answer_text: string
}

interface QuizApiData {
    id: string
    title: string
    description: string
    duration: number
    questions_count: number
}

interface QuizApiResponse {
    data: QuizApiData[]
}

interface Test {
    id: string
    duration: number
    title: string
    description: string
    questions_count: number
}

// Router and Auth
const router = useRouter()
const route = useRoute()
const { token } = useUserAuth()

// Reactive State
const loading = ref(true)
const error = ref('')
const currentIndex = ref(0)
const selectedAnswer = ref<number | null>(null)
const strikedAnswers = ref<number[]>([])
const flashMessage = ref<string | null>(null)
const flashError = ref(false)
const userAnswers = ref<Record<number, number>>({})
const answeredQuestionsCount = ref(0)
const bookmarkedQuestions = ref<Set<number>>(new Set())
const questions = ref<Question[]>([])
const test = ref<Test | null>(null)
const testEnded = ref(false)
const questionsVisible = ref(true)
const endMessage = ref('')
const isFullscreen = ref(false)

// Computed Properties
const currentQuestion = computed(() => questions.value[currentIndex.value] || null)
const testId = computed(() => route.params.test_id as string)

// Watchers
watch(currentIndex, () => {
    syncSelectedAnswer()
    strikedAnswers.value = []
    scrollToQuestion()
})

// Provide values for child components
provide('prevQuestion', prevQuestion)
provide('nextQuestion', nextQuestion)
provide('currentQuestionIndex', currentIndex)
provide('totalQuestions', computed(() => questions.value.length))

// Methods

/**
 * جلب بيانات الكويز من API
 */
async function fetchQuizData(): Promise<QuizApiData | null> {
    try {
        const response = await axios.get<QuizApiResponse>('/api/student/display', {
            headers: { Authorization: `Bearer ${token.value}` }
        })

        // البحث عن الكويز المطلوب
        const quiz = response.data.data?.find((item: QuizApiData) => item.id === testId.value)

        if (!quiz) {
            throw new Error('Quiz not found')
        }

        return quiz
    } catch (err: any) {
        console.error('Error fetching quiz data:', err)
        throw err
    }
}

async function fetchQuestions() {
    if (!testId.value) {
        error.value = 'No test ID provided'
        loading.value = false
        return
    }

    try {
        loading.value = true
        error.value = ''

        // جلب بيانات الكويز أولاً من API
        const quizData = await fetchQuizData()

        // ثم جلب الأسئلة والإجابات المحفوظة
        const [questionsRes, userAnswersRes] = await Promise.all([
            axios.get(`/api/student/question/${testId.value}`, {
                headers: { Authorization: `Bearer ${token.value}` }
            }),
            axios.get(`/api/student/user-answers`, {
                headers: { Authorization: `Bearer ${token.value}` }
            })
        ])

        // تحديث بيانات الكويز - المدة بالدقائق كما هي من API
        test.value = {
            id: quizData.id,
            title: quizData.title,
            description: quizData.description,
            duration: quizData.duration, // المدة بالدقائق
            questions_count: quizData.questions_count
        }

        questions.value = questionsRes.data.data || []
        userAnswers.value = userAnswersRes.data || {}

        // حساب عدد الأسئلة المجاب عليها للـ Progress Bar
        answeredQuestionsCount.value = Object.keys(userAnswers.value).length

        syncSelectedAnswer()
        loadBookmarks()

        console.log('Quiz loaded:', {
            title: test.value.title,
            duration: `${quizData.duration} minutes`,
            questionsCount: test.value.questions_count,
            actualQuestions: questions.value.length
        })

    } catch (err: any) {
        console.error('Fetch Error:', err)

        if (err.response?.status === 404) {
            error.value = 'Quiz not found. Please check the quiz ID.'
        } else if (err.response?.status === 401) {
            error.value = 'Authentication required. Please log in again.'
        } else {
            error.value = err.response?.data?.message || err.message || 'Failed to load quiz data'
        }
    } finally {
        loading.value = false
    }
}

function syncSelectedAnswer() {
    if (currentQuestion.value && userAnswers.value) {
        selectedAnswer.value = userAnswers.value[currentQuestion.value.id] ?? null
    } else {
        selectedAnswer.value = null
    }
}

function loadBookmarks() {
    const saved = localStorage.getItem(`bookmarks_${testId.value}`)
    if (saved) {
        try {
            bookmarkedQuestions.value = new Set(JSON.parse(saved))
        } catch (e) {
            console.warn('Failed to load bookmarks:', e)
            bookmarkedQuestions.value = new Set()
        }
    }
}

function saveBookmarks() {
    try {
        localStorage.setItem(`bookmarks_${testId.value}`, JSON.stringify(Array.from(bookmarkedQuestions.value)))
    } catch (e) {
        console.warn('Failed to save bookmarks:', e)
    }
}

async function selectAnswer(answer: Answer) {
    if (!currentQuestion.value) return

    selectedAnswer.value = answer.id
    await submitAnswer(currentQuestion.value.id, answer.id)
    strikedAnswers.value = []
}

function strikeAnswer(answer: Answer) {
    const index = strikedAnswers.value.indexOf(answer.id)
    if (index === -1) {
        strikedAnswers.value.push(answer.id)
    } else {
        strikedAnswers.value.splice(index, 1)
    }
}

async function submitAnswer(questionId: number, answerId: number) {
    try {
        const res = await axios.post(
            `/api/student/submit-answer`,
            { question_id: questionId, answer_id: answerId },
            { headers: { Authorization: `Bearer ${token.value}` } }
        )

        userAnswers.value[questionId] = answerId
        // تحديث عدد الأسئلة المجاب عليها
        answeredQuestionsCount.value = Object.keys(userAnswers.value).length
        showFlashMessage(res.data?.message || 'Answer submitted successfully', false)
    } catch (err: any) {
        showFlashMessage(err.response?.data?.message || 'Failed to submit answer', true)
        console.error('Submit error:', err)
    }
}

function showFlashMessage(message: string, isError: boolean) {
    flashMessage.value = message
    flashError.value = isError

    setTimeout(() => {
        flashMessage.value = null
    }, 3000)
}

function scrollToQuestion() {
    setTimeout(() => {
        const questionButtons = document.querySelectorAll('.question-scroll button')
        const targetButton = questionButtons[currentIndex.value]
        if (targetButton) {
            targetButton.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            })
        }
    }, 100)
}

function changeQuestion(index: number) {
    if (index >= 0 && index < questions.value.length) {
        currentIndex.value = index
    }
}

function nextQuestion() {
    if (currentIndex.value < questions.value.length - 1) {
        currentIndex.value++
    }
}

function prevQuestion() {
    if (currentIndex.value > 0) {
        currentIndex.value--
    }
}

function handleTestEnd() {
    testEnded.value = true
    questionsVisible.value = false
    endMessage.value = `Thank you for completing "${test.value?.title || 'the quiz'}". Your answers have been saved.`

    // Exit fullscreen when test ends
    if (isFullscreen.value) {
        exitFullscreen()
    }

    // Save final state
    try {
        localStorage.setItem('userAnswers', JSON.stringify(userAnswers.value))
        localStorage.setItem('testId', testId.value)
    } catch (e) {
        console.warn('Failed to save final state:', e)
    }

    // Auto-redirect after 3 seconds
    setTimeout(() => {
        viewResults()
    }, 3000)
}

function viewResults() {
    router.push({ name: 'Result', params: { test_id: testId.value } })
}

function goHome() {
    router.push('/')
}

function retryLoading() {
    error.value = ''
    fetchQuestions()
}

// Fullscreen Functions
function isFullscreenSupported() {
    return !!(
        document.fullscreenEnabled ||
        document.webkitFullscreenEnabled ||
        document.mozFullScreenEnabled ||
        document.msFullscreenEnabled
    )
}

function getFullscreenElement() {
    return (
        document.fullscreenElement ||
        document.webkitFullscreenElement ||
        document.mozFullScreenElement ||
        document.msFullscreenElement
    )
}

function requestFullscreen(element: HTMLElement) {
    if (element.requestFullscreen) {
        return element.requestFullscreen()
    } else if (element.webkitRequestFullscreen) {
        return element.webkitRequestFullscreen()
    } else if (element.mozRequestFullScreen) {
        return element.mozRequestFullScreen()
    } else if (element.msRequestFullscreen) {
        return element.msRequestFullscreen()
    }
    return Promise.reject(new Error('Fullscreen not supported'))
}

function exitFullscreenMode() {
    if (document.exitFullscreen) {
        return document.exitFullscreen()
    } else if (document.webkitExitFullscreen) {
        return document.webkitExitFullscreen()
    } else if (document.mozCancelFullScreen) {
        return document.mozCancelFullScreen()
    } else if (document.msExitFullscreen) {
        return document.msExitFullscreen()
    }
    return Promise.reject(new Error('Exit fullscreen not supported'))
}

function enterFullscreen() {
    if (!isFullscreenSupported()) {
        showFlashMessage('Fullscreen is not supported in this browser', true)
        return
    }

    if (!getFullscreenElement()) {
        requestFullscreen(document.documentElement)
            .then(() => {
                isFullscreen.value = true
                console.log('Entered fullscreen mode')
                showFlashMessage('Entered fullscreen mode - press ESC to exit', false)
            })
            .catch((err) => {
                console.warn('Could not enter fullscreen mode:', err)
                showFlashMessage('Could not enter fullscreen mode', true)
            })
    }
}

function exitFullscreen() {
    if (getFullscreenElement()) {
        exitFullscreenMode()
            .then(() => {
                isFullscreen.value = false
                console.log('Exited fullscreen mode')
                showFlashMessage('Exited fullscreen mode', false)
            })
            .catch((err) => {
                console.warn('Could not exit fullscreen mode:', err)
                showFlashMessage('Could not exit fullscreen mode', true)
            })
    }
}

function toggleFullscreen() {
    if (isFullscreen.value) {
        exitFullscreen()
    } else {
        enterFullscreen()
    }
}

// Listen for fullscreen changes (e.g., user presses ESC)
function handleFullscreenChange() {
    isFullscreen.value = !!getFullscreenElement()
}

function startFullscreenTimer() {
    if (!fullscreenTimerStarted.value && !testEnded.value) {
        fullscreenTimerStarted.value = true
        console.log('Fullscreen timer started - will activate in 1 minute')

        setTimeout(() => {
            if (!testEnded.value && !isFullscreen.value) {
                enterFullscreen()
                showFlashMessage('Entered fullscreen mode for better focus', false)
            }
        }, 60000) // 60 seconds = 1 minute
    }
}

// Keyboard Navigation
function handleKeydown(event: KeyboardEvent) {
    if (testEnded.value) return

    // Exit fullscreen with ESC key
    if (event.key === 'Escape' && isFullscreen.value) {
        event.preventDefault()
        exitFullscreen()
        return
    }

    // Toggle fullscreen with F11 (prevent default browser behavior)
    if (event.key === 'F11') {
        event.preventDefault()
        toggleFullscreen()
        return
    }

    switch (event.key) {
        case 'ArrowLeft':
            event.preventDefault()
            prevQuestion()
            break
        case 'ArrowRight':
            event.preventDefault()
            nextQuestion()
            break
        case '1':
        case '2':
        case '3':
        case '4':
            event.preventDefault()
            const answerIndex = parseInt(event.key) - 1
            if (currentQuestion.value?.answers[answerIndex]) {
                selectAnswer(currentQuestion.value.answers[answerIndex])
            }
            break
    }
}

// Lifecycle
onMounted(() => {
    fetchQuestions()
    document.addEventListener('keydown', handleKeydown)

    // Add event listeners for different browsers
    document.addEventListener('fullscreenchange', handleFullscreenChange)
    document.addEventListener('webkitfullscreenchange', handleFullscreenChange)
    document.addEventListener('mozfullscreenchange', handleFullscreenChange)
    document.addEventListener('MSFullscreenChange', handleFullscreenChange)
})

onUnmounted(() => {
    document.removeEventListener('keydown', handleKeydown)

    // Remove event listeners for different browsers
    document.removeEventListener('fullscreenchange', handleFullscreenChange)
    document.removeEventListener('webkitfullscreenchange', handleFullscreenChange)
    document.removeEventListener('mozfullscreenchange', handleFullscreenChange)
    document.removeEventListener('MSFullscreenChange', handleFullscreenChange)

    saveBookmarks()

    // Exit fullscreen when component unmounts
    if (isFullscreen.value) {
        exitFullscreen()
    }
})
</script>

<style scoped>
.flash-enter-active,
.flash-leave-active {
    transition: all 0.3s ease;
}

.flash-enter-from {
    opacity: 0;
    transform: translateX(100%);
}

.flash-leave-to {
    opacity: 0;
    transform: translateX(100%);
}

/* Hide scrollbar but keep functionality */
.question-scroll {
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.question-scroll::-webkit-scrollbar {
    display: none;
}
</style>