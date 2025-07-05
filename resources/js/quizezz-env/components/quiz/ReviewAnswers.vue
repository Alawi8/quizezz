<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-900 dark:to-black py-8">
    <div class="container mx-auto px-4">
      <!-- Header -->
      <div class="text-center mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-2">Answer Review</h1>
        <p class="text-gray-600 dark:text-gray-400 text-sm md:text-base">Review your answers and see the correct solutions</p>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex items-center justify-center min-h-[50vh]">
        <div class="text-center">
          <div class="w-12 h-12 md:w-16 md:h-16 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin mx-auto mb-4"></div>
          <p class="text-gray-600 dark:text-gray-400 text-sm md:text-base">Loading review data...</p>
        </div>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="max-w-md mx-auto">
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6 text-center">
          <AlertCircle class="w-8 h-8 md:w-12 md:h-12 text-red-600 dark:text-red-400 mx-auto mb-4" />
          <h2 class="text-lg md:text-xl font-semibold text-red-800 dark:text-red-200 mb-2">Error Loading Review</h2>
          <p class="text-red-600 dark:text-red-400 mb-4 text-sm md:text-base">{{ error }}</p>
          <button @click="fetchReviewData" class="w-full md:w-auto px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200">
            Try Again
          </button>
        </div>
      </div>

      <!-- Review Content -->
      <div v-else class="max-w-4xl mx-auto space-y-6">
        <!-- Summary Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-4 md:p-6">
          <div class="flex items-center justify-between mb-4 md:mb-6">
            <h2 class="text-lg md:text-xl font-semibold text-gray-900 dark:text-white">Summary</h2>
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
          <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
            <div class="text-center p-3 md:p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
              <div class="text-xl md:text-2xl font-bold text-green-600 dark:text-green-400 mb-1">{{ correctCount }}</div>
              <div class="text-xs md:text-sm text-gray-600 dark:text-gray-400">Correct</div>
            </div>
            <div class="text-center p-3 md:p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
              <div class="text-xl md:text-2xl font-bold text-red-600 dark:text-red-400 mb-1">{{ incorrectCount }}</div>
              <div class="text-xs md:text-sm text-gray-600 dark:text-gray-400">Incorrect</div>
            </div>
            <div class="text-center p-3 md:p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
              <div class="text-xl md:text-2xl font-bold text-gray-600 dark:text-gray-400 mb-1">{{ unansweredCount }}</div>
              <div class="text-xs md:text-sm text-gray-600 dark:text-gray-400">Unanswered</div>
            </div>
            <div class="text-center p-3 md:p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
              <div class="text-xl md:text-2xl font-bold text-blue-600 dark:text-blue-400 mb-1">{{ accuracyPercentage }}%</div>
              <div class="text-xs md:text-sm text-gray-600 dark:text-gray-400">Accuracy</div>
            </div>
          </div>
        </div>

        <!-- Questions Review -->
        <div class="space-y-4 md:space-y-6">
          <div 
            v-for="(question, index) in filteredQuestions" 
            :key="question.id"
            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden"
          >
            <!-- Question Header -->
            <div 
              class="p-4 md:p-6 border-b border-gray-200 dark:border-gray-700"
              :class="getQuestionHeaderClass(question)"
            >
              <div class="flex items-start justify-between">
                <div class="flex items-center space-x-2 md:space-x-3">
                  <div 
                    class="w-8 h-8 md:w-10 md:h-10 rounded-lg flex items-center justify-center text-white font-bold text-sm md:text-base"
                    :class="getQuestionNumberClass(question)"
                  >
                    {{ getOriginalQuestionIndex(question) + 1 }}
                  </div>
                  <div>
                    <h3 class="text-base md:text-lg font-semibold text-gray-900 dark:text-white">
                      Question {{ getOriginalQuestionIndex(question) + 1 }}
                    </h3>
                    <div class="flex items-center space-x-2 md:space-x-4 mt-1">
                      <div class="flex items-center space-x-2">
                        <component :is="getStatusIcon(question)" class="w-3 h-3 md:w-4 md:h-4" :class="getStatusIconClass(question)" />
                        <span class="text-xs md:text-sm font-medium" :class="getStatusTextClass(question)">
                          {{ getStatusText(question) }}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Quick Navigation -->
                <div class="flex items-center space-x-1 md:space-x-2">
                  <button
                    @click="scrollToQuestion(index - 1)"
                    :disabled="index === 0"
                    class="p-1 md:p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed"
                  >
                    <ChevronUp class="w-3 h-3 md:w-4 md:h-4" />
                  </button>
                  <button
                    @click="scrollToQuestion(index + 1)"
                    :disabled="index === filteredQuestions.length - 1"
                    class="p-1 md:p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed"
                  >
                    <ChevronDown class="w-3 h-3 md:w-4 md:h-4" />
                  </button>
                </div>
              </div>

              <!-- Question Text -->
              <div class="mt-3 md:mt-4 prose dark:prose-invert max-w-none">
                <p class="text-sm md:text-lg leading-relaxed text-gray-800 dark:text-gray-200 mb-0">
                  {{ question.question_text }}
                </p>
              </div>
            </div>

            <!-- Answer Options -->
            <div class="p-4 md:p-6">
              <div class="space-y-2 md:space-y-3">
                <div
                  v-for="(answer, answerIndex) in question.answers"
                  :key="answer.id"
                  class="flex items-center p-3 md:p-4 rounded-xl border-2 transition-all duration-200"
                  :class="getAnswerClass(question, answer)"
                >
                  <!-- Answer Letter -->
                  <div 
                    class="flex-shrink-0 w-6 h-6 md:w-8 md:h-8 rounded-lg flex items-center justify-center font-bold text-xs md:text-sm mr-3 md:mr-4 transition-all duration-300"
                    :class="getAnswerLetterClass(question, answer)"
                  >
                    {{ String.fromCharCode(65 + answerIndex) }}
                  </div>

                  <!-- Answer Text -->
                  <div class="flex-1">
                    <span :class="getAnswerTextClass(question, answer)" class="text-sm md:text-base">
                      {{ answer.answer_text }}
                    </span>
                  </div>

                  <!-- Status Icons -->
                  <div class="flex items-center space-x-1 md:space-x-2 ml-2 md:ml-4">
                    <!-- User's Choice Indicator -->
                    <div v-if="isUserAnswer(question, answer)" class="flex items-center space-x-1">
                      <User class="w-3 h-3 md:w-4 md:h-4 text-blue-600 dark:text-blue-400" />
                      <span class="text-xs text-blue-600 dark:text-blue-400 hidden md:inline">Your Choice</span>
                    </div>

                    <!-- Correct Answer Indicator -->
                    <div v-if="isCorrectAnswer(question, answer)" class="flex items-center space-x-1">
                      <CheckCircle class="w-4 h-4 md:w-5 md:h-5 text-green-600 dark:text-green-400" />
                      <span class="text-xs text-green-600 dark:text-green-400 hidden md:inline">Correct Answer</span>
                    </div>

                    <!-- Result Status for User's Choice -->
                    <div v-if="isUserAnswer(question, answer)" class="flex items-center space-x-1">
                      <CheckCircle v-if="isCorrectAnswer(question, answer)" class="w-4 h-4 md:w-5 md:h-5 text-green-600 dark:text-green-400" />
                      <XCircle v-else class="w-4 h-4 md:w-5 md:h-5 text-red-600 dark:text-red-400" />
                      <span v-if="isCorrectAnswer(question, answer)" class="text-xs text-green-600 dark:text-green-400 hidden sm:inline">✓ Correct</span>
                      <span v-else class="text-xs text-red-600 dark:text-red-400 hidden sm:inline">✗ Wrong</span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Explanation Section -->
              <div v-if="question.explanation" class="mt-4 md:mt-6 p-3 md:p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                <div class="flex items-start space-x-2 md:space-x-3">
                  <Lightbulb class="w-4 h-4 md:w-5 md:h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" />
                  <div>
                    <h4 class="font-medium text-blue-800 dark:text-blue-200 mb-2 text-sm md:text-base">Explanation</h4>
                    <p class="text-blue-700 dark:text-blue-300 text-xs md:text-sm leading-relaxed">
                      {{ question.explanation }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- No Results Message -->
        <div v-if="filteredQuestions.length === 0" class="text-center py-8 md:py-12">
          <div class="w-12 h-12 md:w-16 md:h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
            <Search class="w-6 h-6 md:w-8 md:h-8 text-gray-400" />
          </div>
          <h3 class="text-base md:text-lg font-medium text-gray-900 dark:text-white mb-2">No Questions Found</h3>
          <p class="text-gray-600 dark:text-gray-400 text-sm md:text-base">Try adjusting your filter to see more results.</p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center pt-6 md:pt-8">
          <button 
            @click="exportReview"
            class="flex items-center justify-center px-4 md:px-6 py-2 md:py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all duration-200 text-sm md:text-base"
          >
            <Download class="w-4 h-4 md:w-5 md:h-5 mr-2" />
            Export Review
          </button>
          
          <button 
            @click="printReview"
            class="flex items-center justify-center px-4 md:px-6 py-2 md:py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-all duration-200 text-sm md:text-base"
          >
            <Printer class="w-4 h-4 md:w-5 md:h-5 mr-2" />
            Print Review
          </button>
          
          <button 
            @click="goToResults"
            class="flex items-center justify-center px-4 md:px-6 py-2 md:py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-all duration-200 text-sm md:text-base"
          >
            <BarChart class="w-4 h-4 md:w-5 md:h-5 mr-2" />
            View Results
          </button>
          
          <button 
            @click="goHome"
            class="flex items-center justify-center px-4 md:px-6 py-2 md:py-3 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition-all duration-200 text-sm md:text-base"
          >
            <Home class="w-4 h-4 md:w-5 md:h-5 mr-2" />
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
import axios from 'axios'
import useUserAuth from '@/composable/userAuth.js'
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

interface QuizApiData {
  id: string
  title: string
  description: string
  duration: number
  questions_count: number
}

const route = useRoute()
const router = useRouter()
const { token } = useUserAuth()

// State
const loading = ref(true)
const error = ref('')
const questions = ref<Question[]>([])
const userAnswers = ref<Record<number, number>>({})
const filterType = ref('all')

// Computed properties
const correctCount = computed(() => 
  questions.value.filter(q => {
    const userAnswer = userAnswers.value[q.id]
    const correctAnswer = q.answers.find(a => a.is_correct)
    return userAnswer && correctAnswer && userAnswer === correctAnswer.id
  }).length
)

const incorrectCount = computed(() => 
  questions.value.filter(q => {
    const userAnswer = userAnswers.value[q.id]
    const correctAnswer = q.answers.find(a => a.is_correct)
    return userAnswer && correctAnswer && userAnswer !== correctAnswer.id
  }).length
)

const unansweredCount = computed(() => 
  questions.value.filter(q => !userAnswers.value[q.id]).length
)

const accuracyPercentage = computed(() => {
  const answered = questions.value.filter(q => userAnswers.value[q.id]).length
  if (answered === 0) return 0
  return Math.round((correctCount.value / answered) * 100)
})

const filteredQuestions = computed(() => {
  switch (filterType.value) {
    case 'correct':
      return questions.value.filter(q => {
        const userAnswer = userAnswers.value[q.id]
        const correctAnswer = q.answers.find(a => a.is_correct)
        return userAnswer && correctAnswer && userAnswer === correctAnswer.id
      })
    case 'incorrect':
      return questions.value.filter(q => {
        const userAnswer = userAnswers.value[q.id]
        const correctAnswer = q.answers.find(a => a.is_correct)
        return userAnswer && correctAnswer && userAnswer !== correctAnswer.id
      })
    case 'unanswered':
      return questions.value.filter(q => !userAnswers.value[q.id])
    default:
      return questions.value
  }
})

// Methods
const fetchQuizData = async (testId: string) => {
  try {
    const response = await axios.get('/api/student/display', {
      headers: { Authorization: `Bearer ${token.value}` }
    })

    const quiz = response.data.data?.find((item: QuizApiData) => item.id === testId)
    
    if (!quiz) {
      throw new Error('Quiz not found')
    }

    return quiz
  } catch (err: any) {
    console.error('Error fetching quiz data:', err)
    throw err
  }
}

const fetchReviewData = async () => {
  loading.value = true
  error.value = ''
  
  try {
    const testId = route.params.test_id as string
    
    if (!testId) {
      throw new Error('No test ID provided')
    }

    // Fetch quiz data and questions from the same API as QuizPage
    const [quizData, questionsRes, userAnswersRes] = await Promise.all([
      fetchQuizData(testId),
      axios.get(`/api/student/question/${testId}`, {
        headers: { Authorization: `Bearer ${token.value}` }
      }),
      axios.get(`/api/student/user-answers`, {
        headers: { Authorization: `Bearer ${token.value}` }
      })
    ])

    // Process questions and add correct answer identification
    questions.value = (questionsRes.data.data || []).map((question: Question) => ({
      ...question,
      // Add explanation if needed
      explanation: `The correct answer is ${question.answers.find(a => a.is_correct)?.answer_text || 'not specified'}.`
    }))
    
    userAnswers.value = userAnswersRes.data || {}

    console.log('Review data loaded:', {
      title: quizData.title,
      questionsCount: questions.value.length,
      answeredCount: Object.keys(userAnswers.value).length
    })

  } catch (e: any) {
    console.error('Error loading review data:', e)
    
    if (e.response?.status === 404) {
      error.value = 'Quiz not found. Please check the quiz ID.'
    } else if (e.response?.status === 401) {
      error.value = 'Authentication required. Please log in again.'
    } else {
      error.value = e.response?.data?.message || e.message || 'Failed to load review data.'
    }
  } finally {
    loading.value = false
  }
}

const getOriginalQuestionIndex = (question: Question): number => {
  return questions.value.findIndex(q => q.id === question.id)
}

const getQuestionHeaderClass = (question: Question): string => {
  const userAnswerId = userAnswers.value[question.id]
  if (!userAnswerId) {
    return 'bg-gray-50 dark:bg-gray-700/50'
  }
  
  const correctAnswer = question.answers.find(a => a.is_correct)
  if (correctAnswer && userAnswerId === correctAnswer.id) {
    return 'bg-green-50 dark:bg-green-900/20'
  }
  return 'bg-red-50 dark:bg-red-900/20'
}

const getQuestionNumberClass = (question: Question): string => {
  const userAnswerId = userAnswers.value[question.id]
  if (!userAnswerId) {
    return 'bg-gray-500'
  }
  
  const correctAnswer = question.answers.find(a => a.is_correct)
  if (correctAnswer && userAnswerId === correctAnswer.id) {
    return 'bg-green-500'
  }
  return 'bg-red-500'
}

const getStatusIcon = (question: Question) => {
  const userAnswerId = userAnswers.value[question.id]
  if (!userAnswerId) return AlertCircle
  
  const correctAnswer = question.answers.find(a => a.is_correct)
  if (correctAnswer && userAnswerId === correctAnswer.id) return CheckCircle
  return XCircle
}

const getStatusIconClass = (question: Question): string => {
  const userAnswerId = userAnswers.value[question.id]
  if (!userAnswerId) return 'text-gray-500'
  
  const correctAnswer = question.answers.find(a => a.is_correct)
  if (correctAnswer && userAnswerId === correctAnswer.id) return 'text-green-600 dark:text-green-400'
  return 'text-red-600 dark:text-red-400'
}

const getStatusText = (question: Question): string => {
  const userAnswerId = userAnswers.value[question.id]
  if (!userAnswerId) return 'Not Answered'
  
  const correctAnswer = question.answers.find(a => a.is_correct)
  if (correctAnswer && userAnswerId === correctAnswer.id) return 'Correct'
  return 'Incorrect'
}

const getStatusTextClass = (question: Question): string => {
  const userAnswerId = userAnswers.value[question.id]
  if (!userAnswerId) return 'text-gray-600 dark:text-gray-400'
  
  const correctAnswer = question.answers.find(a => a.is_correct)
  if (correctAnswer && userAnswerId === correctAnswer.id) return 'text-green-600 dark:text-green-400'
  return 'text-red-600 dark:text-red-400'
}

const isUserAnswer = (question: Question, answer: Answer): boolean => {
  return userAnswers.value[question.id] === answer.id
}

const isCorrectAnswer = (question: Question, answer: Answer): boolean => {
  return answer.is_correct === true
}

const getAnswerClass = (question: Question, answer: Answer): string => {
  const userAnswerId = userAnswers.value[question.id]
  const isUserChoice = userAnswerId === answer.id
  const isCorrectAnswer = answer.is_correct === true
  
  // إجابة المستخدم صحيحة
  if (isUserChoice && isCorrectAnswer) {
    return 'border-green-500 bg-green-50 dark:bg-green-900/20'
  }
  
  // إجابة المستخدم خاطئة
  if (isUserChoice && !isCorrectAnswer) {
    return 'border-red-500 bg-red-50 dark:bg-red-900/20'
  }
  
  // إظهار الإجابة الصحيحة (إذا لم يختارها المستخدم)
  if (isCorrectAnswer && !isUserChoice) {
    return 'border-green-300 bg-green-50 dark:bg-green-900/10 ring-2 ring-green-200 dark:ring-green-800'
  }
  
  // إجابة عادية غير مختارة
  return 'border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700'
}

const getAnswerLetterClass = (question: Question, answer: Answer): string => {
  const userAnswerId = userAnswers.value[question.id]
  const isUserChoice = userAnswerId === answer.id
  const isCorrectAnswer = answer.is_correct === true
  
  // إجابة المستخدم صحيحة
  if (isUserChoice && isCorrectAnswer) {
    return 'bg-green-500 text-white'
  }
  
  // إجابة المستخدم خاطئة
  if (isUserChoice && !isCorrectAnswer) {
    return 'bg-red-500 text-white'
  }
  
  // إظهار الإجابة الصحيحة
  if (isCorrectAnswer) {
    return 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400'
  }
  
  // إجابة عادية
  return 'bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300'
}

const getAnswerTextClass = (question: Question, answer: Answer): string => {
  const userAnswerId = userAnswers.value[question.id]
  const isUserChoice = userAnswerId === answer.id
  const isCorrectAnswer = answer.is_correct === true
  
  // إجابة المستخدم صحيحة
  if (isUserChoice && isCorrectAnswer) {
    return 'text-green-700 dark:text-green-300 font-medium'
  }
  
  // إجابة المستخدم خاطئة
  if (isUserChoice && !isCorrectAnswer) {
    return 'text-red-700 dark:text-red-300 font-medium'
  }
  
  // إظهار الإجابة الصحيحة
  if (isCorrectAnswer) {
    return 'text-green-700 dark:text-green-400 font-medium'
  }
  
  // إجابة عادية
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
    questions: questions.value.map(q => {
      const userAnswer = q.answers.find(a => a.id === userAnswers.value[q.id])
      const correctAnswer = q.answers.find(a => a.is_correct)
      return {
        question: q.question_text,
        userAnswer: userAnswer?.answer_text || 'Not answered',
        correctAnswer: correctAnswer?.answer_text || 'Not specified',
        isCorrect: userAnswer && correctAnswer && userAnswer.id === correctAnswer.id,
        explanation: q.explanation
      }
    })
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

/* Question transition animations */
.question-card {
  transition: all 0.3s ease;
}

.question-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
}

/* Mobile optimizations */
@media (max-width: 640px) {
  .container {
    padding-left: 1rem;
    padding-right: 1rem;
  }
}

/* Container responsive design */
.container {
  max-width: 100%;
}

@media (min-width: 640px) {
  .container {
    max-width: 640px;
  }
}

@media (min-width: 768px) {
  .container {
    max-width: 768px;
  }
}

@media (min-width: 1024px) {
  .container {
    max-width: 1024px;
  }
}

@media (min-width: 1280px) {
  .container {
    max-width: 1280px;
  }
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

/* Filter transition */
.filter-transition {
  transition: all 0.5s ease;
}

/* Button hover effects */
button:hover {
  transform: translateY(-1px);
}

button:active {
  transform: translateY(0);
}

/* Responsive text sizing */
@media (max-width: 640px) {
  h1 {
    font-size: 1.5rem;
  }
  
  h2 {
    font-size: 1.25rem;
  }
  
  h3 {
    font-size: 1.125rem;
  }
}
</style>