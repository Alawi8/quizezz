<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { Folder, Plus, Trash } from 'lucide-vue-next'



const questions = ref([])
const tests = ref([])
const selectedTestId = ref('')
const showForm = ref(false)
const flashMessage = ref('')
const flashType = ref('success')

const newQuestion = ref({
    question_text: '',
    test_id: '',
    answers: [
        { id: Date.now() + Math.random(), answer_text: '', is_correct: false }
    ]
})

const resetForm = () => {
    newQuestion.value = {
        question_text: '',
        test_id: '',
        answers: [
            { id: Date.now() + Math.random(), answer_text: '', is_correct: false }
        ]
    }
}

const setCorrect = (index: number) => {
    newQuestion.value.answers.forEach((a, i) => {
        a.is_correct = i === index
    })
}

const addQuestion = async () => {
    try {
        const res = await axios.post('/api/admin/questions', newQuestion.value, {
            headers: {
                Authorization: `Bearer ${token.value}`
            }
        })
        questions.value.unshift(res.data)
        flashMessage.value = '✅ Question added successfully'
        flashType.value = 'success'
        resetForm()
    } catch (e) {
        flashMessage.value = '❌ Failed to add question'
        flashType.value = 'error'
    }
}

const toggleForm = () => {
    showForm.value = !showForm.value
    if (!showForm.value) resetForm()
}

const addAnswer = () => {
    newQuestion.value.answers.push({ id: Date.now() + Math.random(), answer_text: '', is_correct: false })
}

const removeAnswer = (index: number) => {
    newQuestion.value.answers.splice(index, 1)
}

const resetAndFetch = async () => {
    try {
        const res = await axios.get('/api/admin/questions', {
            params: selectedTestId.value ? { test_id: selectedTestId.value } : {},
            headers: {
                Authorization: `Bearer ${token.value}`
            }
        })
        questions.value = res.data
    } catch (e) {
        flashMessage.value = '❌ Failed to load questions'
        flashType.value = 'error'
    }
}

const deleteAllQuestions = async () => {
    try {
        await axios.delete('/api/admin/questions', {
            headers: {
                Authorization: `Bearer ${token.value}`
            }
        })
        questions.value = []
        flashMessage.value = '🗑️ All questions deleted'
        flashType.value = 'success'
    } catch (e) {
        flashMessage.value = '❌ Failed to delete questions'
        flashType.value = 'error'
    }
}

onMounted(async () => {
    try {
        const res = await axios.get('/api/admin/tests', {
            headers: {
                Authorization: `Bearer ${token.value}`
            }
        })
        tests.value = res.data
        await resetAndFetch()
    } catch (e) {
        flashMessage.value = '❌ Failed to load tests'
        flashType.value = 'error'
    }
})
</script>

<template>
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-green-700">📋 Manage Questions</h2>
        <button @click="toggleForm" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 transition">
            <Plus class="inline w-4 h-4 mr-1" /> Add New Question
        </button>
    </div>

    <!-- Flash Message -->
    <div v-if="flashMessage" :class="flashType === 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700'" class="px-4 py-3 rounded">
        {{ flashMessage }}
    </div>

    <!-- Filter -->
    <div class="flex items-center gap-4">
        <select v-model="selectedTestId" @change="resetAndFetch()" class="border border-green-300 rounded px-3 py-2">
            <option value="">All Tests</option>
            <option v-for="test in tests" :key="test.id" :value="test.id">{{ test.title }}</option>
        </select>
        <button @click="deleteAllQuestions" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
            <Trash class="inline w-4 h-4 mr-1" /> Delete All
        </button>
    </div>

    <!-- Questions List -->
    <div class="mt-6 space-y-4">
        <div v-for="question in questions" :key="question.id" class="p-4 bg-white rounded shadow">
            <p class="font-bold text-green-800">Q: {{ question.question_text }}</p>
        </div>
    </div>

    <!-- Add Question Form -->
    <div v-if="showForm" class="bg-white p-6 border border-green-300 rounded-lg shadow space-y-6 mt-6">
        <h2 class="text-xl font-semibold text-green-700">📝 New Question</h2>
        <input v-model="newQuestion.question_text" type="text" class="w-full border border-green-300 px-4 py-2 rounded" placeholder="Enter question text">

        <select v-model="newQuestion.test_id" class="w-full border border-green-300 px-4 py-2 rounded">
            <option value="">Select Test</option>
            <option v-for="test in tests" :key="test.id" :value="test.id">{{ test.title }}</option>
        </select>

        <div class="space-y-3">
            <div v-for="(answer, index) in newQuestion.answers" :key="answer.id" class="flex items-center gap-2">
                <input v-model="answer.answer_text" type="text" class="w-full border border-green-300 px-3 py-2 rounded" placeholder="Answer option">
                <label class="flex items-center gap-1 text-sm text-green-700">
                    <input type="radio" :checked="answer.is_correct" @change="setCorrect(index)" /> Correct
                </label>
                <button @click="removeAnswer(index)" class="text-red-500 hover:underline text-sm">
                    <Trash class="inline w-4 h-4" />
                </button>
            </div>
            <button @click="addAnswer" class="text-green-700 text-sm hover:underline">
                <Plus class="inline w-4 h-4 mr-1" /> Add Answer
            </button>
        </div>

        <div class="text-right">
            <button @click="addQuestion" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">
                <Folder class="inline w-4 h-4 mr-1" /> Save
            </button>
        </div>
    </div>
</template>

<style scoped>

</style>
