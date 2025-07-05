<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-green-50 dark:from-gray-900 dark:to-black">
    <!-- Loading State -->
    <div v-if="loading" class="flex items-center justify-center min-h-screen">
      <div class="text-center">
        <div class="w-12 h-12 md:w-16 md:h-16 border-4 border-green-200 border-t-green-600 rounded-full animate-spin mx-auto mb-4"></div>
        <p class="text-gray-600 dark:text-gray-400 text-sm md:text-base">Loading quiz...</p>
      </div>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="flex items-center justify-center min-h-screen p-4">
      <div class="text-center p-6 md:p-8 bg-red-50 dark:bg-red-900/20 rounded-xl border border-red-200 dark:border-red-800 max-w-md w-full">
        <div class="w-12 h-12 md:w-16 md:h-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-6 h-6 md:w-8 md:h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
          </svg>
        </div>
        <h2 class="text-lg md:text-xl font-semibold text-red-800 dark:text-red-200 mb-2">Error Loading Quiz</h2>
        <p class="text-red-600 dark:text-red-400 mb-4 text-sm md:text-base">{{ error }}</p>
        <button @click="retryLoading" class="w-full md:w-auto px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200">
          Try Again
        </button>
      </div>
    </div>

    <!-- Quiz Content -->
    <div v-else class="pb-20">
      <Header 
        :duration="test?.duration" 
        :currentQuestion="currentIndex + 1"
        :totalQuestions="questions.length"
        @time-up="handleTestEnd" 
        @exit-test="handleTestEnd"
      />

      <!-- Test Ended State -->
      <div v-if="testEnded" class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto text-center bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 md:p-8 border border-gray-200 dark:border-gray-700">
          <div class="w-16 h-16 md:w-20 md:h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8 md:w-10 md:h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
          </div>
          <h2 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white mb-4">Quiz Completed!</h2>
          <p class="text-gray-600 dark:text-gray-400 mb-6 text-sm md:text-base">{{ endMessage }}</p>
          <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center">
            <button @click="viewResults" class="w-full sm:w-auto px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 font-medium">
              View Results
            </button>
            <button @click="goHome" class="w-full sm:w-auto px-6 py-3 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg transition-colors duration-200 font-medium">
              Back to Home
            </button>
          </div>
        </div>
      </div>

      <!-- Active Quiz -->
      <div v-else-if="questionsVisible && questions.length > 0" class="container mx-auto px-4 py-6">
        <div class="flex gap-6">
          <!-- Questions Sidebar - Hidden on mobile -->
          <div class="hidden lg:block lg:w-20 flex-shrink-0">
            <QuestionsList
              :questions="questions"
              :currentIndex="currentIndex"
              :userAnswers="userAnswers"
              :bookmarkedQuestions="bookmarkedQuestions"
              @changeQuestion="changeQuestion"
            />
          </div>

          <!-- Main Question Area -->
          <div class="flex-1 min-h-0">
            <QuestionComponent
              v-if="currentQuestion"
              :question="currentQuestion"
              :questionIndex="currentIndex"
              :selectedAnswer="selectedAnswer"
              :userAnswers="userAnswers"
              :strikedAnswers="strikedAnswers"
              @selectAnswer="selectAnswer"
              @strikeAnswer="strikeAnswer"
            />
          </div>
        </div>

        <!-- Mobile Progress Indicator -->
        <div class="lg:hidden fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-white dark:bg-gray-800 px-4 py-2 rounded-full shadow-lg border border-gray-200 dark:border-gray-700 z-30">
          <div class="flex items-center space-x-3 text-sm">
            <span class="font-medium text-gray-700 dark:text-gray-300">
              {{ currentIndex + 1 }} / {{ questions.length }}
            </span>
            <div class="w-16 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
              <div 
                class="bg-green-500 h-2 rounded-full transition-all duration-300"
                :style="{ width: `${(answeredCount / questions.length) * 100}%` }"
              ></div>
            </div>
            <span class="text-xs text-gray-500 dark:text-gray-400">
              {{ answeredCount }} answered
            </span>
          </div>
        </div>
      </div>

      <Footer />
    </div>

    <!-- Flash Message -->
    <Transition name="flash">
      <div
        v-if="flashMessage"
        class="fixed top-20 right-4 z-50 p-3 md:p-4 rounded-lg shadow-lg border max-w-xs md:max-w-sm"
        :class="flashError 
          ? 'bg-red-50 border-red-200 text-red-800 dark:bg-red-900/20 dark:border-red-800 dark:text-red-200'
          : 'bg-green-50 border-green-200 text-green-800 dark:bg-green-900/20 dark:border-green-800 dark:text-green-200'
        "
      >
        <div class="flex items-center space-x-2">
          <svg v-if="!flashError" class="w-4 h-4 md:w-5 md:h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
          <svg v-else class="w-4 h-4 md:w-5 md:h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
          <span class="text-xs md:text-sm font-medium">{{ flashMessage }}</span>
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
const bookmarkedQuestions = ref<Set<number>>(new Set())
const questions = ref<Question[]>([])
const test = ref<Test | null>(null)
const testEnded = ref(false)
const questionsVisible = ref(true)
const endMessage = ref('')

// Computed Properties
const currentQuestion = computed(() => questions.value[currentIndex.value] || null)
const testId = computed(() => route.params.test_id as string)
const answeredCount = computed(() => Object.keys(userAnswers.value).length)

// Watchers
watch(currentIndex, () => {
  syncSelectedAnswer()
  strikedAnswers.value = []
})

// Provide values for child components
provide('prevQuestion', prevQuestion)
provide('nextQuestion', nextQuestion)
provide('currentQuestionIndex', currentIndex)
provide('totalQuestions', computed(() => questions.value.length))

// Methods
async function fetchQuizData() {
  try {
    const response = await axios.get('/api/student/display', {
      headers: { Authorization: `Bearer ${token.value}` }
    })

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

    const quizData = await fetchQuizData()
    
    const [questionsRes, userAnswersRes] = await Promise.all([
      axios.get(`/api/student/question/${testId.value}`, {
        headers: { Authorization: `Bearer ${token.value}` }
      }),
      axios.get(`/api/student/user-answers`, {
        headers: { Authorization: `Bearer ${token.value}` }
      })
    ])

    test.value = {
      id: quizData.id,
      title: quizData.title,
      description: quizData.description,
      duration: quizData.duration * 60,
      questions_count: quizData.questions_count
    }

    questions.value = questionsRes.data.data || []
    userAnswers.value = userAnswersRes.data || {}

    syncSelectedAnswer()
    loadBookmarks()

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

  try {
    localStorage.setItem('userAnswers', JSON.stringify(userAnswers.value))
    localStorage.setItem('testId', testId.value)
  } catch (e) {
    console.warn('Failed to save final state:', e)
  }
  
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

// Keyboard Navigation
function handleKeydown(event: KeyboardEvent) {
  if (testEnded.value) return

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
})

onUnmounted(() => {
  document.removeEventListener('keydown', handleKeydown)
  saveBookmarks()
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
</style>