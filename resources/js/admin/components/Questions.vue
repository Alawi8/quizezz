<template>
    <div class="max-w-6xl mx-auto p-6 space-y-8 relative" ref="scrollContainer">
        <!-- Header -->
        <add-new-questions/>
        <!-- Question List -->
        <div class="space-y-4">
            <div v-for="q in questions" :key="q.id" class="bg-white border border-green-300 rounded-lg shadow-sm p-5 space-y-4">
                <div class="flex justify-between items-start flex-wrap md:flex-nowrap">
                    <div class="space-y-1 w-full md:w-auto">
                        <h3 class="text-lg font-semibold">{{ q.question_text }}</h3>
                        <p class="text-sm">Test: <span class="font-semibold">{{ getTestTitle(q.test_id) }}</span></p>
                        <ul class="list-disc pl-6 text-sm">
                            <li v-for="(a, i) in q.answers" :key="i" :class="{ 'text-green-600 font-bold': a.is_correct }">
                                {{ a.answer_text }}
                            </li>
                        </ul>
                    </div>

                    <div class="flex gap-2 flex-wrap mt-4 md:mt-0">
                        <button @click="edit(q)" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 flex items-center gap-1">
                            <Edit class="w-4 h-4" /> Edit
                        </button>
                        <button @click="confirmDelete(q)" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 flex items-center gap-1">
                            <Trash class="w-4 h-4" /> Delete
                        </button>
                    </div>
                </div>

                <!-- Inline Edit Form -->
                <div v-if="editingQuestion === q.id" class="bg-green-50 border border-green-400 rounded-lg p-6 space-y-4">
                    <h3 class="text-lg font-semibold text-green-700">✏️ Edit Question</h3>
                    <input v-model="newQuestion.question_text" type="text" placeholder="Question text"
                           class="w-full border border-green-300 rounded px-4 py-2">

                    <select v-model="newQuestion.test_id" class="w-full border border-green-300 rounded px-4 py-2">
                        <option value="">Select Test</option>
                        <option v-for="test in tests" :key="test.id" :value="test.id">{{ test.title }}</option>
                    </select>

                    <div class="space-y-2">
                        <div v-for="(answer, index) in newQuestion.answers" :key="answer.id" class="flex items-center gap-2">
                            <input v-model="answer.answer_text" type="text" class="w-full border border-green-300 rounded px-3 py-2" placeholder="Answer option">
                            <label class="flex items-center gap-1 text-sm">
                                <input type="radio" :checked="answer.is_correct" @change="setCorrect(index)" /> Correct
                            </label>
                            <button @click="removeAnswer(index)" class="text-red-600 hover:underline text-sm">
                                <Trash class="inline w-4 h-4" />
                            </button>
                        </div>
                        <button @click="addAnswer" class="text-green-700 text-sm hover:underline">
                            <Plus class="inline w-4 h-4 mr-1" /> Add Answer
                        </button>
                    </div>

                    <div class="text-right">
                        <button @click="updateQuestion" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">
                            <Folder class="inline w-4 h-4 mr-1" /> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div ref="loadMoreRef" class="text-center text-gray-500 py-4" v-if="hasMore">
            ⏳ Loading more questions...
        </div>

        <!-- Confirm Delete Dialog -->
        <div v-if="deletingQuestion" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center" @click.self="deletingQuestion = null">
            <div class="bg-white rounded-lg p-6 shadow-lg w-full max-w-md space-y-4">
                <h2 class="text-lg font-bold text-red-600">Delete Question?</h2>
                <p class="text-green-800 text-sm">Are you sure you want to delete this question?</p>
                <div class="flex justify-end gap-3">
                    <button @click="deletingQuestion = null" class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">Cancel</button>
                    <button @click="deleteConfirmed" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        <Trash class="inline w-4 h-4 mr-1" /> Confirm Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import axios from 'axios'
import { Plus, Trash, Edit, Folder } from 'lucide-vue-next'
import AddNewQuestions from "@/admin/components/questions/add-new-questions.vue";

const scrollContainer = ref(null)
const loadMoreRef = ref(null)
let observer = null

const questions = ref([])
const tests = ref([])
const selectedTestId = ref('')
const showForm = ref(false)
const editingQuestion = ref(null)
const deletingQuestion = ref(null)
const flashMessage = ref(null)
const flashType = ref('success')

const newQuestion = ref({
    question_text: '',
    test_id: '',
    answers: [
        { id: Date.now(), answer_text: '', is_correct: false },
        { id: Date.now() + 1, answer_text: '', is_correct: false }
    ]
})

let page = ref(1)
let loading = ref(false)
let hasMore = ref(true)

const fetchTests = async () => {
    const res = await axios.get('/api/admin/section')
    tests.value = res.data
}

const fetchQuestions = async () => {
    if (loading.value || !hasMore.value) return
    loading.value = true
    try {
        const res = await axios.get('/api/admin/questions', {
            params: { page: page.value, test_id: selectedTestId.value || undefined }
        })
        if (res.data.data.length === 0) {
            hasMore.value = false
        } else {
            questions.value.push(...res.data.data)
            page.value++
        }
    } catch (e) {
        console.error(e)
    } finally {
        loading.value = false
    }
}

const resetAndFetch = () => {
    questions.value = []
    page.value = 1
    hasMore.value = true
    fetchQuestions()
}

const setupObserver = () => {
    if (observer) observer.disconnect()
    observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting) {
            fetchQuestions()
        }
    }, {
        root: scrollContainer.value,
        threshold: 1.0
    })
    if (loadMoreRef.value) observer.observe(loadMoreRef.value)
}

onMounted(() => {
    fetchTests()
    fetchQuestions()
    setupObserver()
})

onUnmounted(() => {
    if (observer && loadMoreRef.value) {
        observer.unobserve(loadMoreRef.value)
    }
})



const updateQuestion = async () => {
    try {
        const res = await axios.put(`/api/admin/questions/${editingQuestion.value}`, newQuestion.value)
        const i = questions.value.findIndex(q => q.id === editingQuestion.value)
        if (i !== -1) questions.value[i] = res.data
        setFlash('✅ Question updated')
        resetForm()
    } catch (e) {
        setFlash('❌ Failed to update question', 'error')
    }
}

const deleteConfirmed = async () => {
    try {
        await axios.delete(`/api/admin/questions/${deletingQuestion.value.id}`)
        questions.value = questions.value.filter(q => q.id !== deletingQuestion.value.id)
        setFlash('✅ Question deleted')
        deletingQuestion.value = null
    } catch (e) {
        setFlash('❌ Failed to delete question', 'error')
    }
}

const deleteAllQuestions = async () => {
    if (!confirm('Are you sure? This cannot be undone.')) return
    try {
        await axios.delete('/api/admin/questions')
        questions.value = []
        setFlash('✅ All questions deleted')
    } catch (e) {
        setFlash('❌ Failed to delete all questions', 'error')
    }
}

const edit = (q) => {
    newQuestion.value = {
        question_text: q.question_text,
        test_id: q.test_id,
        answers: q.answers.map(a => ({
            id: Date.now() + Math.random(),
            answer_text: a.answer_text,
            is_correct: a.is_correct
        }))
    }
    editingQuestion.value = q.id
    showForm.value = false
}

const setCorrect = (index) => {
    newQuestion.value.answers.forEach((a, i) => a.is_correct = i === index)
}


const confirmDelete = (q) => {
    deletingQuestion.value = q
}

const setFlash = (msg, type = 'success') => {
    flashMessage.value = msg
    flashType.value = type
    setTimeout(() => flashMessage.value = null, 4000)
}

const resetForm = () => {
    newQuestion.value = {
        question_text: '',
        test_id: '',
        answers: [
            { id: Date.now(), answer_text: '', is_correct: false },
            { id: Date.now() + 1, answer_text: '', is_correct: false }
        ]
    }
    editingQuestion.value = null
    showForm.value = false
}

const getTestTitle = (id) => {
    const found = tests.value.find(t => t.id === id)
    return found ? found.title : 'Unknown'
}
</script>

<style scoped></style>
