<template>
  <div class="max-w-6xl mx-auto p-6 space-y-8 relative" ref="scrollContainer">
    <!-- Header -->
    <div class="flex justify-between items-center">
      <h2 class="text-2xl font-bold text-green-700">📋 Manage Questions</h2>
      <button @click="formManager.toggle()" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 transition">
        <Plus class="inline w-4 h-4 mr-1" /> Add New Question
      </button>
    </div>

    <!-- Flash Message -->
    <div v-if="flashManager.message.value" :class="flashManager.getFlashClass()" class="px-4 py-3 rounded">
      {{ flashManager.message.value }}
    </div>

    <!-- Filter -->
    <div class="flex items-center gap-4">
      <select v-model="filterManager.selectedTestId.value" @change="dataManager.resetAndFetch()" class="border border-green-300 rounded px-3 py-2">
        <option value="">All Tests</option>
        <option v-for="test in dataManager.tests.value" :key="test.id" :value="test.id">{{ test.title }}</option>
      </select>
      <button @click="questionManager.deleteAll()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
        <Trash class="inline w-4 h-4 mr-1" /> Delete All
      </button>
    </div>

    <!-- Add Question Form -->
    <div v-if="formManager.showForm.value" class="bg-white p-6 border border-green-300 rounded-lg shadow space-y-6">
      <h2 class="text-xl font-semibold text-green-700">📝 New Question</h2>
      <input v-model="formManager.newQuestion.value.question_text" type="text" class="w-full border border-green-300 px-4 py-2 rounded" placeholder="Enter question text" />

      <select v-model="formManager.newQuestion.value.test_id" class="w-full border border-green-300 px-4 py-2 rounded">
        <option value="">Select Test</option>
        <option v-for="test in dataManager.tests.value" :key="test.id" :value="test.id">{{ test.title }}</option>
      </select>

      <div class="space-y-3">
        <div v-for="(answer, index) in formManager.newQuestion.value.answers" :key="answer.id" class="flex items-center gap-2">
          <input v-model="answer.answer_text" type="text" class="w-full border border-green-300 px-3 py-2 rounded" placeholder="Answer option" />
          <label class="flex items-center gap-1 text-sm text-green-700">
            <input type="radio" :checked="answer.is_correct" @change="formManager.setCorrect(index)" /> Correct
          </label>
          <button @click="formManager.removeAnswer(index)" class="text-red-500 hover:underline text-sm">
            <Trash class="inline w-4 h-4" />
          </button>
        </div>
        <button @click="formManager.addAnswer()" class="text-green-700 text-sm hover:underline">
          <Plus class="inline w-4 h-4 mr-1" /> Add Answer
        </button>
      </div>

      <div class="text-right">
        <button @click="questionManager.add()" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">
          <Folder class="inline w-4 h-4 mr-1" /> Save
        </button>
      </div>
    </div>

    <!-- Question List -->
    <div class="space-y-4">
      <div v-for="q in dataManager.questions.value" :key="q.id" class="bg-white border border-green-300 rounded-lg shadow-sm p-5 space-y-4">
        <div class="flex justify-between items-start flex-wrap md:flex-nowrap">
          <div class="space-y-1 w-full md:w-auto">
            <h3 class="text-lg font-semibold">{{ q.question_text }}</h3>
            <p class="text-sm">Section : <span class="font-semibold">{{ dataManager.getTestTitle(q.test_id) }}</span></p>
            <ul class="list-disc pl-6 text-sm">
              <li v-for="(a, i) in q.answers" :key="i" :class="{ 'text-green-600 font-bold': a.is_correct }">
                {{ a.answer_text }}
              </li>
            </ul>
          </div>

          <div class="flex gap-2 flex-wrap mt-4 md:mt-0">
            <button @click="questionManager.edit(q)" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 flex items-center gap-1">
              <Edit class="w-4 h-4" /> Edit
            </button>
            <button @click="questionManager.confirmDelete(q)" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 flex items-center gap-1">
              <Trash class="w-4 h-4" /> Delete
            </button>
          </div>
        </div>

        <!-- Inline Edit Form -->
        <div v-if="questionManager.editingQuestion.value === q.id" class="bg-green-50 border border-green-400 rounded-lg p-6 space-y-4">
          <h3 class="text-lg font-semibold text-green-700">✏️ Edit Question</h3>
          <input v-model="formManager.newQuestion.value.question_text" type="text" placeholder="Question text" class="w-full border border-green-300 rounded px-4 py-2" />

          <select v-model="formManager.newQuestion.value.test_id" class="w-full border border-green-300 rounded px-4 py-2">
            <option value="">Select Test</option>
            <option v-for="test in dataManager.tests.value" :key="test.id" :value="test.id">{{ test.title }}</option>
          </select>

          <div class="space-y-2">
            <div v-for="(answer, index) in formManager.newQuestion.value.answers" :key="answer.id" class="flex items-center gap-2">
              <input v-model="answer.answer_text" type="text" class="w-full border border-green-300 rounded px-3 py-2" placeholder="Answer option" />
              <label class="flex items-center gap-1 text-sm">
                <input type="radio" :checked="answer.is_correct" @change="formManager.setCorrect(index)" /> Correct
              </label>
              <button @click="formManager.removeAnswer(index)" class="text-red-600 hover:underline text-sm">
                <Trash class="inline w-4 h-4" />
              </button>
            </div>
            <button @click="formManager.addAnswer()" class="text-green-700 text-sm hover:underline">
              <Plus class="inline w-4 h-4 mr-1" /> Add Answer
            </button>
          </div>

          <div class="text-right space-x-2">
            <button @click="questionManager.cancelEdit()" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
              Cancel
            </button>
            <button @click="questionManager.update()" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">
              <Folder class="inline w-4 h-4 mr-1" /> Save
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Pagination Controls -->
    <div class="flex justify-center items-center gap-4 py-6" v-if="paginationManager.totalPages.value > 1">
      <button 
        @click="paginationManager.previousPage()" 
        :disabled="paginationManager.currentPage.value === 1"
        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 disabled:bg-gray-300 disabled:cursor-not-allowed flex items-center gap-2"
      >
        Previous
      </button>
      
      <div class="flex items-center gap-2">
        <span class="text-sm text-gray-600">Page</span>
        <span class="font-semibold text-green-700">{{ paginationManager.currentPage.value }}</span>
        <span class="text-sm text-gray-600">of</span>
        <span class="font-semibold text-green-700">{{ paginationManager.totalPages.value }}</span>
      </div>
      
      <button 
        @click="paginationManager.nextPage()" 
        :disabled="paginationManager.currentPage.value >= paginationManager.totalPages.value"
        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 disabled:bg-gray-300 disabled:cursor-not-allowed flex items-center gap-2"
      >
        Next
      </button>
    </div>

    <!-- Loading indicator -->
    <div v-if="paginationManager.loading.value" class="text-center text-gray-500 py-4">
      ⏳ Loading questions...
    </div>

    <!-- Confirm Delete Dialog -->
    <div v-if="questionManager.deletingQuestion.value" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center" @click.self="questionManager.deletingQuestion.value = null">
      <div class="bg-white rounded-lg p-6 shadow-lg w-full max-w-md space-y-4">
        <h2 class="text-lg font-bold text-red-600">Delete Question?</h2>
        <p class="text-green-800 text-sm">Are you sure you want to delete this question?</p>
        <div class="flex justify-end gap-3">
          <button @click="questionManager.deletingQuestion.value = null" class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">Cancel</button>
          <button @click="questionManager.deleteConfirmed()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
            <Trash class="inline w-4 h-4 mr-1" /> Confirm Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, onUnmounted } from 'vue'
import axios from 'axios'
import { Plus, Trash, Edit, Folder } from 'lucide-vue-next'

// Data Management Class
class DataManager {
    constructor() {
        this.questions = ref([])
        this.tests = ref([])
    }

    async fetchTests() {
        try {
            const res = await axios.get('/api/admin/section')
            this.tests.value = res.data
        } catch (error) {
            console.error('Error fetching tests:', error)
        }
    }

    async fetchQuestions(page, testId) {
        try {
            const res = await axios.get('/api/admin/questions', {
                params: { page, test_id: testId || undefined }
            })
            return res.data
        } catch (error) {
            console.error('Error fetching questions:', error)
            return { data: [] }
        }
    }

    resetAndFetch() {
        this.questions.value = []
        paginationManager.reset()
        paginationManager.loadQuestions()
    }

    getTestTitle(id) {
        const found = this.tests.value.find(t => t.id === id)
        return found ? found.title : 'Unknown'
    }

    addQuestion(question) {
        this.questions.value.unshift(question)
    }

    updateQuestion(questionId, updatedQuestion) {
        const index = this.questions.value.findIndex(q => q.id === questionId)
        if (index !== -1) {
            this.questions.value[index] = updatedQuestion
        }
    }

    removeQuestion(questionId) {
        this.questions.value = this.questions.value.filter(q => q.id !== questionId)
        
        // إذا كانت الصفحة فارغة، انتقل للصفحة السابقة
        if (this.questions.value.length === 0 && paginationManager.currentPage.value > 1) {
            paginationManager.previousPage()
        }
    }

    clearAllQuestions() {
        this.questions.value = []
        paginationManager.reset()
    }

    appendQuestions(newQuestions) {
        this.questions.value.push(...newQuestions)
    }
}

// Form Management Class
class FormManager {
    constructor() {
        this.showForm = ref(false)
        this.newQuestion = ref(this.getDefaultQuestion())
    }

    getDefaultQuestion() {
        return {
            question_text: '',
            test_id: '',
            answers: [
                { id: Date.now(), answer_text: '', is_correct: false },
                { id: Date.now() + 1, answer_text: '', is_correct: false }
            ]
        }
    }

    toggle() {
        this.showForm.value = !this.showForm.value
        if (!this.showForm.value) {
            this.reset()
        }
    }

    reset() {
        this.newQuestion.value = this.getDefaultQuestion()
        this.showForm.value = false
    }

    setCorrect(index) {
        this.newQuestion.value.answers.forEach((a, i) => {
            a.is_correct = i === index
        })
    }

    addAnswer() {
        this.newQuestion.value.answers.push({
            id: Date.now() + Math.random(),
            answer_text: '',
            is_correct: false
        })
    }

    removeAnswer(index) {
        if (this.newQuestion.value.answers.length > 1) {
            this.newQuestion.value.answers.splice(index, 1)
        }
    }

    populateForm(question) {
        this.newQuestion.value = {
            question_text: question.question_text,
            test_id: question.test_id,
            answers: question.answers.map(a => ({
                id: Date.now() + Math.random(),
                answer_text: a.answer_text,
                is_correct: a.is_correct
            }))
        }
    }
}

// Question Management Class
class QuestionManager {
    constructor(dataManager, formManager, flashManager) {
        this.dataManager = dataManager
        this.formManager = formManager
        this.flashManager = flashManager
        this.editingQuestion = ref(null)
        this.deletingQuestion = ref(null)
    }

    async add() {
        try {
            const res = await axios.post('/api/admin/questions', this.formManager.newQuestion.value)
            this.dataManager.addQuestion(res.data)
            this.flashManager.setFlash('✅ Question added successfully')
            this.formManager.reset()
        } catch (error) {
            this.flashManager.setFlash('❌ Failed to add question', 'error')
        }
    }

    async update() {
        try {
            const res = await axios.put(
                `/api/admin/questions/${this.editingQuestion.value}`,
                this.formManager.newQuestion.value
            )
            this.dataManager.updateQuestion(this.editingQuestion.value, res.data)
            this.flashManager.setFlash('✅ Question updated')
            this.formManager.reset()
            this.editingQuestion.value = null
        } catch (error) {
            this.flashManager.setFlash('❌ Failed to update question', 'error')
        }
    }

    async deleteConfirmed() {
        try {
            await axios.delete(`/api/admin/questions/${this.deletingQuestion.value.id}`)
            this.dataManager.removeQuestion(this.deletingQuestion.value.id)
            this.flashManager.setFlash('✅ Question deleted')
            this.deletingQuestion.value = null
        } catch (error) {
            this.flashManager.setFlash('❌ Failed to delete question', 'error')
        }
    }

    async deleteAll() {
        if (!confirm('Are you sure? This cannot be undone.')) return
        
        try {
            await axios.delete('/api/admin/questions')
            this.dataManager.clearAllQuestions()
            this.flashManager.setFlash('✅ All questions deleted')
        } catch (error) {
            this.flashManager.setFlash('❌ Failed to delete all questions', 'error')
        }
    }

    edit(question) {
        this.formManager.populateForm(question)
        this.editingQuestion.value = question.id
        this.formManager.showForm.value = false
    }

    cancelEdit() {
        this.editingQuestion.value = null
        this.formManager.reset()
    }

    confirmDelete(question) {
        this.deletingQuestion.value = question
    }
}

// Flash Message Management Class
class FlashManager {
    constructor() {
        this.message = ref(null)
        this.type = ref('success')
    }

    setFlash(msg, msgType = 'success') {
        this.message.value = msg
        this.type.value = msgType
        setTimeout(() => {
            this.message.value = null
        }, 4000)
    }

    getFlashClass() {
        return this.type.value === 'success' 
            ? 'bg-green-100 border border-green-400 text-green-700'
            : 'bg-red-100 border border-red-400 text-red-700'
    }
}

// Filter Management Class
class FilterManager {
    constructor() {
        this.selectedTestId = ref('')
    }

    getActiveTestId() {
        return this.selectedTestId.value || undefined
    }

    reset() {
        this.selectedTestId.value = ''
    }
}

// Pagination Management Class
class PaginationManager {
    constructor(dataManager, filterManager) {
        this.dataManager = dataManager
        this.filterManager = filterManager
        this.currentPage = ref(1)
        this.totalPages = ref(1)
        this.perPage = 10 // عدد الأسئلة في كل صفحة
        this.loading = ref(false)
    }

    async loadQuestions() {
        if (this.loading.value) return
        
        this.loading.value = true
        try {
            const result = await this.dataManager.fetchQuestions(
                this.currentPage.value,
                this.filterManager.getActiveTestId()
            )
            
            // تحديث البيانات بدلاً من إضافتها
            this.dataManager.questions.value = result.data || []
            
            // تحديث معلومات الصفحات
            if (result.pagination) {
                this.totalPages.value = result.pagination.total_pages || 1
                this.currentPage.value = result.pagination.current_page || 1
            } else {
                // إذا لم تكن هناك معلومات pagination من الخادم
                this.totalPages.value = result.data && result.data.length === this.perPage ? this.currentPage.value + 1 : this.currentPage.value
            }
        } catch (error) {
            console.error('Error loading questions:', error)
        } finally {
            this.loading.value = false
        }
    }

    async nextPage() {
        if (this.currentPage.value < this.totalPages.value && !this.loading.value) {
            this.currentPage.value++
            await this.loadQuestions()
        }
    }

    async previousPage() {
        if (this.currentPage.value > 1 && !this.loading.value) {
            this.currentPage.value--
            await this.loadQuestions()
        }
    }

    async goToPage(page) {
        if (page >= 1 && page <= this.totalPages.value && page !== this.currentPage.value && !this.loading.value) {
            this.currentPage.value = page
            await this.loadQuestions()
        }
    }

    reset() {
        this.currentPage.value = 1
        this.totalPages.value = 1
        this.loading.value = false
    }
}

// Initialize all managers
const dataManager = new DataManager()
const flashManager = new FlashManager()
const filterManager = new FilterManager()
const paginationManager = new PaginationManager(dataManager, filterManager)
const formManager = new FormManager()
const questionManager = new QuestionManager(dataManager, formManager, flashManager)

// Template refs
const scrollContainer = ref(null)

// Lifecycle hooks
onMounted(async () => {
    await dataManager.fetchTests()
    await paginationManager.loadQuestions()
})

onUnmounted(() => {
    // Cleanup if needed
})
</script>

<style scoped></style>