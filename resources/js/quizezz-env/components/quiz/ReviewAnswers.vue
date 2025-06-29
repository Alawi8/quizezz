<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-900 dark:to-black py-8">
    <div class="container mx-auto px-4">
      <!-- Header -->
      <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Answer Review</h1>
        <p class="text-gray-600 dark:text-gray-400">Review your answers and see the correct solutions</p>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex items-center justify-center min-h-[50vh]">
        <div class="text-center">
          <div class="w-16 h-16 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin mx-auto mb-4"></div>
          <p class="text-gray-600 dark:text-gray-400">Loading review data...</p>
        </div>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="max-w-md mx-auto">
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6 text-center">
          <AlertCircle class="w-12 h-12 text-red-600 dark:text-red-400 mx-auto mb-4" />
          <h2 class="text-xl font-semibold text-red-800 dark:text-red-200 mb-2">Error Loading Review</h2>
          <p class="text-red-600 dark:text-red-400 mb-4">{{ error }}</p>
          <button @click="fetchReviewData" class="btn-primary">
            Try Again
          </button>
        </div>
      </div>

      <!-- Review Content -->
      <div v-else class="max-w-4xl mx-auto space-y-6">
        <!-- Summary Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Summary</h2>
            <div class="flex items-center space-x-4">
              <!-- Filter Options -->
              <select 
                v-model="filterType" 
                class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm"
              >
                <option value="all">All Questions</option>
                <option value="correct">Correct Only</option>
                <option value="incorrect">Incorrect Only</option>
                <option value="unanswered">Unanswered</option>
              </select>
            </div>
          </div>

          <!-- Stats Grid -->
          <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
              <div class="text-2xl font-bold text-green-600 dark:text-green-400 mb-1">{{ correctCount }}</div>
              <div class="text-sm text-gray-600 dark:text-gray-400">Correct</div>
            </div>
            <div class="text-center p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
              <div class="text-2xl font-bold text-red-600 dark:text-red-400 mb-1">{{ incorrectCount }}</div>
              <div class="text-sm text-gray-600 dark:text-gray-400">Incorrect</div>
            </div>
            <div class="text-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
              <div class="text-2xl font-bold text-gray-600 dark:text-gray-400 mb-1">{{ unansweredCount }}</div>
              <div class="text-sm text-gray-600 dark:text-gray-400">Unanswered</div>
            </div>
            <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
              <div class="text-2xl font-bold text-blue-600 dark:text-blue-400 mb-1">{{ accuracyPercentage }}%</div>
              <div class="text-sm text-gray-600 dark:text-gray-400">Accuracy</div>
            </div>
          </div>
        </div>

        <!-- Questions Review -->
        <div class="space-y-6">
          <div 
            v-for="(question, index) in filteredQuestions" 
            :key="question.id"
            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden"
          >
            <!-- Question Header -->
            <div 
              class="p-6 border-b border-gray-200 dark:border-gray-700"
              :class="getQuestionHeaderClass(question)"
            >
              <div class="flex items-start justify-between">
                <div class="flex items-center space-x-3">
                  <div 
                    class="w-10 h-10 rounded-lg flex items-center justify-center text-white font-bold"
                    :class="getQuestionNumberClass(question)"
                  >
                    {{ getOriginalQuestionIndex(question) + 1 }}
                  </div>
                  <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                      Question {{ getOriginalQuestionIndex(question) + 1 }}
                    </h3>
                    <div class="flex items-center space-x-4 mt-1">
                      <div class="flex items-center space-x-2">
                        <component :is="getStatusIcon(question)" class="w-4 h-4" :class="getStatusIconClass(question)" />
                        <span class="text-sm font-medium" :class="getStatusTextClass(question)">
                          {{ getStatusText(question) }}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Quick Navigation -->
                <div class="flex items-center space-x-2">
                  <button
                    @click="scrollToQuestion(index - 1)"
                    :disabled="index === 0"
                    class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed"
                  >
                    <ChevronUp class="w-4 h-4" />
                  </button>
                  <button
                    @click="scrollToQuestion(index + 1)"
                    :disabled="index === filteredQuestions.length - 1"
                    class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed"
                  >
                    <ChevronDown class="w-4 h-4" />
                  </button>
                </div>
              </div>

              <!-- Question Text -->
              <div class="mt-4 prose dark:prose-invert max-w-none">
                <p class="text-gray-800 dark:text-gray-200 text-lg leading-relaxed">
                  {{ question.question_text }}
                </p>
              </div>
            </div>

            <!-- Answer Options -->
            <div class="p-6">
              <div class="space-y-3">
                <div
                  v-for="(answer, answerIndex) in question.answers"
                  :key="answer.id"
                  class="flex items-center p-4 rounded-xl border-2 transition-all duration-200"
                  :class="getAnswerClass(question, answer)"
                >
                  <!-- Answer Letter -->
                  <div 
                    class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center font-bold mr-4"
                    :class="getAnswerLetterClass(question, answer)"
                  >
                    {{ String.fromCharCode(65 + answerIndex) }}
                  </div>

                  <!-- Answer Text -->
                  <div class="flex-1">
                    <span :class="getAnswerTextClass(question, answer)">
                      {{ answer.answer_text }}
                    </span>
                  </div>

                  <!-- Status Icons -->
                  <div class="flex items-center space-x-2 ml-4">
                    <!-- User's Choice -->
                    <div v-if="isUserAnswer(question, answer)" class="flex items-center space-x-1">
                      <User class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                      <span class="text-xs text-blue-600 dark:text-blue-400">Your Answer</span>
                    </div>

                    <!-- Correct Answer -->
                    <div v-if="isCorrectAnswer(question, answer)" class="flex items-center space-x-1">
                      <CheckCircle class="w-5 h-5 text-green-600 dark:text-green-400" />
                      <span class="text-xs text-green-600 dark:text-green-400">Correct</span>
                    </div>

                    <!-- Incorrect Answer -->
                    <div v-if="isUserAnswer(question, answer) && !isCorrectAnswer(question, answer)" class="flex items-center space-x-1">
                      <XCircle class="w-5 h-5 text-red-600 dark:text-red-400" />
                      <span class="text-xs text-red-600 dark:text-red-400">Incorrect</span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Explanation Section -->
              <div v-if="question.explanation" class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                <div class="flex items-start space-x-3">
                  <Lightbulb class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" />
                  <div>
                    <h4 class="font-medium text-blue-800 dark:text-blue-200 mb-2">Explanation</h4>
                    <p class="text-blue-700 dark:text-blue-300 text-sm leading-relaxed">
                      {{ question.explanation }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- No Results Message -->
        <div v-if="filteredQuestions.length === 0" class="text-center py-12">
          <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
            <Search class="w-8 h-8 text-gray-400" />
          </div>
          <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Questions Found</h3>
          <p class="text-gray-600 dark:text-gray-400">Try adjusting your filter to see more results.</p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center pt-8">
          <button 
            @click="exportReview"
            class="flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all duration-200"
          >
            <Download class="w-5 h-5 mr-2" />
            Export Review
          </button>
          
          <button 
            @click="printReview"
            class="flex items-center justify-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-all duration-200"
          >
            <Printer class="w-5 h-5 mr-2" />
            Print Review
          </button>
          
          <button 
            @click="goToResults"
            class="flex items-center justify-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-all duration-200"
          >
            <BarChart class="w-5 h-5 mr-2" />
            View Results
          </button>
          
          <button 
            @click="goHome"
            class="flex items-center justify-center px-6 py-3 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition-all duration-200"
          >
            <Home class="w-5 h-5 mr-2" />
            Back to Home
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import {
  AlertCircle,
  CheckCircle,
  XCircle,
  ChevronUp,
  ChevronDown,
  User,
  Lightbulb,
  Search,
  Download,
  Printer,
  BarChart,
  Home
} from 'lucide-vue-next'

interface Answer {
  id: number
  answer_text: string
  is_correct?: boolean
}

interface Question {
  id: number
  question_text: string
  answers: Answer[]
  user_answer_id?: number
  correct_answer_id?: number
  explanation?: string
}

const route = useRoute()
const router = useRouter()

// State
const loading = ref(true)
const error = ref('')
const questions = ref<Question[]>([])
const filterType = ref('all')

// Mock data for demonstration
const mockQuestions: Question[] = [
  {
    id: 1,
    question_text: "What is the capital of France?",
    user_answer_id: 1,
    correct_answer_id: 1,
    explanation: "Paris has been the capital of France since 508 AD and is the largest city in the country.",
    answers: [
      { id: 1, answer_text: "Paris", is_correct: true },
      { id: 2, answer_text: "London", is_correct: false },
      { id: 3, answer_text: "Berlin", is_correct: false },
      { id: 4, answer_text: "Madrid", is_correct: false }
    ]
  },
  {
    id: 2,
    question_text: "What is the largest planet in our solar system?",
    user_answer_id: 6,
    correct_answer_id: 8,
    explanation: "Jupiter is the largest planet in our solar system, with a mass greater than all other planets combined.",
    answers: [
      { id: 5, answer_text: "Earth", is_correct: false },
      { id: 6, answer_text: "Mars", is_correct: false },
      { id: 7, answer_text: "Saturn", is_correct: false },
      { id: 8, answer_text: "Jupiter", is_correct: true }
    ]
  },
  {
    id: 3,
    question_text: "Who invented the telephone?",
    user_answer_id: null,
    correct_answer_id: 9,
    explanation: "Alexander Graham Bell is credited with inventing the first practical telephone in 1876.",
    answers: [
      { id: 9, answer_text: "Alexander Graham Bell", is_correct: true },
      { id: 10, answer_text: "Thomas Edison", is_correct: false },
      { id: 11, answer_text: "Nikola Tesla", is_correct: false },
      { id: 12, answer_text: "Benjamin Franklin", is_correct: false }
    ]
  }
]

// Computed properties
const correctCount = computed(() => 
  questions.value.filter(q => q.user_answer_id === q.correct_answer_id).length
)

const incorrectCount = computed(() => 
  questions.value.filter(q => q.user_answer_id && q.user_answer_id !== q.correct_answer_id).length
)

const unansweredCount = computed(() => 
  questions.value.filter(q => !q.user_answer_id).length
)

const accuracyPercentage = computed(() => {
  const answered = questions.value.filter(q => q.user_answer_id).length
  if (answered === 0) return 0
  return Math.round((correctCount.value / answered) * 100)
})

const filteredQuestions = computed(() => {
  switch (filterType.value) {
    case 'correct':
      return questions.value.filter(q => q.user_answer_id === q.correct_answer_id)
    case 'incorrect':
      return questions.value.filter(q => q.user_answer_id && q.user_answer_id !== q.correct_answer_id)
    case 'unanswered':
      return questions.value.filter(q => !q.user_answer_id)
    default:
      return questions.value
  }
})

// Methods
const fetchReviewData = async () => {
  loading.value = true
  error.value = ''
  
  try {
    // Simulate API call
    await new Promise(resolve => setTimeout(resolve, 1000))
    questions.value = mockQuestions
  } catch (e: any) {
    error.value = 'Failed to load review data.'
    console.error(e)
  } finally {
    loading.value = false
  }
}

const getOriginalQuestionIndex = (question: Question): number => {
  return mockQuestions.findIndex(q => q.id === question.id)
}

const getQuestionHeaderClass = (question: Question): string => {
  if (!question.user_answer_id) {
    return 'bg-gray-50 dark:bg-gray-700/50'
  }
  if (question.user_answer_id === question.correct_answer_id) {
    return 'bg-green-50 dark:bg-green-900/20'
  }
  return 'bg-red-50 dark:bg-red-900/20'
}

const getQuestionNumberClass = (question: Question): string => {
  if (!question.user_answer_id) {
    return 'bg-gray-500'
  }
  if (question.user_answer_id === question.correct_answer_id) {
    return 'bg-green-500'
  }
  return 'bg-red-500'
}

const getStatusIcon = (question: Question) => {
  if (!question.user_answer_id) return AlertCircle
  if (question.user_answer_id === question.correct_answer_id) return CheckCircle
  return XCircle
}

const getStatusIconClass = (question: Question): string => {
  if (!question.user_answer_id) return 'text-gray-500'
  if (question.user_answer_id === question.correct_answer_id) return 'text-green-600 dark:text-green-400'
  return 'text-red-600 dark:text-red-400'
}

const getStatusText = (question: Question): string => {
  if (!question.user_answer_id) return 'Not Answered'
  if (question.user_answer_id === question.correct_answer_id) return 'Correct'
  return 'Incorrect'
}

const getStatusTextClass = (question: Question): string => {
  if (!question.user_answer_id) return 'text-gray-600 dark:text-gray-400'
  if (question.user_answer_id === question.correct_answer_id) return 'text-green-600 dark:text-green-400'
  return 'text-red-600 dark:text-red-400'
}

const isUserAnswer = (question: Question, answer: Answer): boolean => {
  return question.user_answer_id === answer.id
}

const isCorrectAnswer = (question: Question, answer: Answer): boolean => {
  return question.correct_answer_id === answer.id
}

const getAnswerClass = (question: Question, answer: Answer): string => {
  const isUser = isUserAnswer(question, answer)
  const isCorrect = isCorrectAnswer(question, answer)
  
  if (isUser && isCorrect) {
    return 'border-green-500 bg-green-50 dark:bg-green-900/20'
  }
  if (isUser && !isCorrect) {
    return 'border-red-500 bg-red-50 dark:bg-red-900/20'
  }
  if (isCorrect) {
    return 'border-green-300 bg-green-50 dark:bg-green-900/10'
  }
  return 'border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700'
}

const getAnswerLetterClass = (question: Question, answer: Answer): string => {
  const isUser = isUserAnswer(question, answer)
  const isCorrect = isCorrectAnswer(question, answer)
  
  if (isUser && isCorrect) {
    return 'bg-green-500 text-white'
  }
  if (isUser && !isCorrect) {
    return 'bg-red-500 text-white'
  }
  if (isCorrect) {
    return 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400'
  }
  return 'bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300'
}

const getAnswerTextClass = (question: Question, answer: Answer): string => {
  const isUser = isUserAnswer(question, answer)
  const isCorrect = isCorrectAnswer(question, answer)
  
  if (isUser && isCorrect) {
    return 'text-green-700 dark:text-green-300 font-medium'
  }
  if (isUser && !isCorrect) {
    return 'text-red-700 dark:text-red-300 font-medium'
  }
  if (isCorrect) {
    return 'text-green-700 dark:text-green-400'
  }
  return 'text-gray-800 dark:text-gray-200'
}

const scrollToQuestion = (index: number) => {
  if (index >= 0 && index < filteredQuestions.value.length) {
    const element = document.querySelectorAll('.bg-white.dark\\:bg-gray-800')[index + 1]
    if (element) {
      element.scrollIntoView({ behavior: 'smooth', block: 'start' })
    }
  }
}

const exportReview = () => {
  const reviewData = {
    summary: {
      total: questions.value.length,
      correct: correctCount.value,
      incorrect: incorrectCount.value,
      unanswered: unansweredCount.value,
      accuracy: accuracyPercentage.value
    },
    questions: questions.value.map(q => ({
      question: q.question_text,
      userAnswer: q.answers.find(a => a.id === q.user_answer_id)?.answer_text || 'Not answered',
      correctAnswer: q.answers.find(a => a.id === q.correct_answer_id)?.answer_text,
      isCorrect: q.user_answer_id === q.correct_answer_id,
      explanation: q.explanation
    }))
  }
  
  const dataStr = JSON.stringify(reviewData, null, 2)
  const dataBlob = new Blob([dataStr], { type: 'application/json' })
  const url = URL.createObjectURL(dataBlob)
  const link = document.createElement('a')
  link.href = url
  link.download = `quiz-review-${route.params.test_id}.json`
  link.click()
  URL.revokeObjectURL(url)
}

const printReview = () => {
  window.print()
}

const goToResults = () => {
  router.push({ name: 'Result', params: { test_id: route.params.test_id } })
}

const goHome = () => {
  router.push('/')
}

onMounted(() => {
  fetchReviewData()
})
</script>

<style scoped>
/* Print styles */
@media print {
  .no-print {
    display: none !important;
  }
  
  .bg-gradient-to-br {
    background: white !important;
  }
  
  .shadow-lg {
    box-shadow: none !important;
    border: 1px solid #e5e7eb !important;
  }
}

/* Smooth scrolling */
html {
  scroll-behavior: smooth;
}

/* Custom scrollbar for review content */
.review-scroll::-webkit-scrollbar {
  width: 8px;
}

.review-scroll::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 4px;
}

.review-scroll::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 4px;
}

.review-scroll::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}

/* Question transition animations */
.question-card {
  transition: all 0.3s ease;
}

.question-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
}

/* Filter transition */
.filter-transition {
  transition: all 0.5s ease;
}

/* Answer highlight animation */
@keyframes highlightAnswer {
  0% {
    background-color: transparent;
  }
  50% {
    background-color: rgba(59, 130, 246, 0.1);
  }
  100% {
    background-color: transparent;
  }
}

.answer-highlight {
  animation: highlightAnswer 1s ease-in-out;
}
</style>