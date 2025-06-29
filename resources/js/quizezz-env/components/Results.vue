<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-green-50 dark:from-gray-900 dark:to-black py-8">
    <div class="container mx-auto px-4">
      <!-- Loading State -->
      <div v-if="loading" class="flex items-center justify-center min-h-[50vh]">
        <div class="text-center">
          <div class="w-16 h-16 border-4 border-green-200 border-t-green-600 rounded-full animate-spin mx-auto mb-4"></div>
          <p class="text-gray-600 dark:text-gray-400">Loading your results...</p>
        </div>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="max-w-md mx-auto">
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6 text-center">
          <div class="w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
            <AlertCircle class="w-8 h-8 text-red-600 dark:text-red-400" />
          </div>
          <h2 class="text-xl font-semibold text-red-800 dark:text-red-200 mb-2">Unable to Load Results</h2>
          <p class="text-red-600 dark:text-red-400 mb-4">{{ error }}</p>
          <button @click="fetchResult" class="btn-primary">
            Try Again
          </button>
        </div>
      </div>

      <!-- Results Content -->
      <div v-else-if="result" class="max-w-4xl mx-auto space-y-8">
        <!-- Header -->
        <div class="text-center">
          <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Quiz Results</h1>
          <p class="text-gray-600 dark:text-gray-400">Here's how you performed on the quiz</p>
        </div>

        <!-- Score Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
          <div class="bg-gradient-to-r from-green-500 to-blue-500 p-8 text-white text-center">
            <div class="mb-6">
              <div class="text-6xl font-bold mb-2">{{ result.score }}</div>
              <div class="text-xl opacity-90">out of 100</div>
            </div>
            
            <!-- Performance Badge -->
            <div class="inline-flex items-center px-4 py-2 bg-white/20 rounded-full">
              <component :is="getPerformanceIcon()" class="w-6 h-6 mr-2" />
              <span class="font-semibold">{{ getPerformanceLevel() }}</span>
            </div>
          </div>

          <!-- Detailed Stats -->
          <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
              <!-- Total Questions -->
              <div class="text-center p-6 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-3">
                  <FileText class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ result.total }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Total Questions</div>
              </div>

              <!-- Correct Answers -->
              <div class="text-center p-6 bg-green-50 dark:bg-green-900/20 rounded-xl">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-3">
                  <CheckCircle class="w-6 h-6 text-green-600 dark:text-green-400" />
                </div>
                <div class="text-2xl font-bold text-green-600 dark:text-green-400 mb-1">{{ result.correct }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Correct Answers</div>
              </div>

              <!-- Incorrect Answers -->
              <div class="text-center p-6 bg-red-50 dark:bg-red-900/20 rounded-xl">
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-3">
                  <XCircle class="w-6 h-6 text-red-600 dark:text-red-400" />
                </div>
                <div class="text-2xl font-bold text-red-600 dark:text-red-400 mb-1">{{ result.total - result.correct }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Incorrect Answers</div>
              </div>
            </div>

            <!-- Progress Bar -->
            <div class="mb-8">
              <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Accuracy</span>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ accuracyPercentage }}%</span>
              </div>
              <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                <div 
                  class="bg-gradient-to-r from-green-500 to-green-600 h-3 rounded-full transition-all duration-1000 ease-out"
                  :style="{ width: `${accuracyPercentage}%` }"
                ></div>
              </div>
            </div>

            <!-- Performance Breakdown -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Time Statistics -->
              <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                  <Clock class="w-5 h-5 mr-2 text-blue-500" />
                  Time Statistics
                </h3>
                <div class="space-y-3">
                  <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Total Time</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ getEfficiencyRating() }}</span>
                  </div>
                </div>
              </div>

              <!-- Performance Insights -->
              <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                  <TrendingUp class="w-5 h-5 mr-2 text-green-500" />
                  Performance Insights
                </h3>
                <div class="space-y-3">
                  <div class="flex items-center justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Grade</span>
                    <span class="px-3 py-1 rounded-full text-sm font-medium" :class="getGradeClass()">
                      {{ getLetterGrade() }}
                    </span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Percentile</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ getPercentile() }}%</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Status</span>
                    <span class="font-medium" :class="getStatusClass()">{{ getStatus() }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <button 
            @click="reviewAnswers"
            class="flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105"
          >
            <Eye class="w-5 h-5 mr-2" />
            Review Answers
          </button>
          
          <button 
            @click="downloadResults"
            class="flex items-center justify-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105"
          >
            <Download class="w-5 h-5 mr-2" />
            Download Results
          </button>
          
          <button 
            @click="retakeQuiz"
            class="flex items-center justify-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105"
          >
            <RotateCcw class="w-5 h-5 mr-2" />
            Retake Quiz
          </button>
          
          <button 
            @click="goHome"
            class="flex items-center justify-center px-6 py-3 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition-all duration-200"
          >
            <Home class="w-5 h-5 mr-2" />
            Back to Home
          </button>
        </div>

        <!-- Detailed Breakdown -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-8">
          <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
            <BarChart class="w-6 h-6 mr-3 text-blue-500" />
            Detailed Analysis
          </h2>

          <!-- Performance Chart -->
          <div class="mb-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
              <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                <div class="text-3xl font-bold text-green-600 dark:text-green-400 mb-1">A+</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Target Grade</div>
              </div>
              <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-1">{{ getLetterGrade() }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Your Grade</div>
              </div>
              <div class="text-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">{{ result.total }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Questions</div>
              </div>
              <div class="text-center p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                <div class="text-3xl font-bold text-orange-600 dark:text-orange-400 mb-1">{{ formatTime(totalTime) }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Duration</div>
              </div>
            </div>
          </div>

          <!-- Recommendations -->
          <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
              <Lightbulb class="w-5 h-5 mr-2 text-yellow-500" />
              Recommendations
            </h3>
            <div class="space-y-3">
              <div v-for="recommendation in getRecommendations()" :key="recommendation.id" 
                   class="flex items-start space-x-3 p-3 bg-white dark:bg-gray-800 rounded-lg">
                <div class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center"
                     :class="recommendation.colorClass">
                  <component :is="recommendation.icon" class="w-4 h-4" />
                </div>
                <div>
                  <div class="font-medium text-gray-900 dark:text-white">{{ recommendation.title }}</div>
                  <div class="text-sm text-gray-600 dark:text-gray-400">{{ recommendation.description }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import {
  AlertCircle,
  CheckCircle,
  XCircle,
  Clock,
  TrendingUp,
  Eye,
  Download,
  RotateCcw,
  Home,
  BarChart,
  Lightbulb,
  FileText,
  Trophy,
  Target,
  BookOpen,
  Brain
} from 'lucide-vue-next'

interface QuizResult {
  correct: number
  total: number
  score: number
  timeSpent?: number
  startTime?: string
  endTime?: string
}

interface Recommendation {
  id: string
  title: string
  description: string
  icon: any
  colorClass: string
}

const route = useRoute()
const router = useRouter()

const result = ref<QuizResult | null>(null)
const loading = ref(true)
const error = ref('')

// Mock data for demo - replace with actual API data
const totalTime = ref(1800) // 30 minutes in seconds
const averageTimePerQuestion = computed(() => {
  if (!result.value) return 0
  return Math.round(totalTime.value / result.value.total)
})

const accuracyPercentage = computed(() => {
  if (!result.value) return 0
  return Math.round((result.value.correct / result.value.total) * 100)
})

const fetchResult = async () => {
  loading.value = true
  error.value = ''
  
  try {
    const testId = route.params.test_id as string
    const token = localStorage.getItem('auth_token')

    const res = await axios.get(`/api/student/final-result/${testId}`, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })

    result.value = res.data
  } catch (e: any) {
    error.value = e.response?.data?.message || 'Failed to load quiz results.'
    console.error(e)
  } finally {
    loading.value = false
  }
}

const getPerformanceLevel = (): string => {
  if (!result.value) return 'Unknown'
  const percentage = accuracyPercentage.value
  
  if (percentage >= 90) return 'Excellent'
  if (percentage >= 80) return 'Very Good'
  if (percentage >= 70) return 'Good'
  if (percentage >= 60) return 'Fair'
  return 'Needs Improvement'
}

const getPerformanceIcon = () => {
  const percentage = accuracyPercentage.value
  if (percentage >= 90) return Trophy
  if (percentage >= 70) return Target
  return BookOpen
}

const getLetterGrade = (): string => {
  const percentage = accuracyPercentage.value
  if (percentage >= 97) return 'A+'
  if (percentage >= 93) return 'A'
  if (percentage >= 90) return 'A-'
  if (percentage >= 87) return 'B+'
  if (percentage >= 83) return 'B'
  if (percentage >= 80) return 'B-'
  if (percentage >= 77) return 'C+'
  if (percentage >= 73) return 'C'
  if (percentage >= 70) return 'C-'
  if (percentage >= 67) return 'D+'
  if (percentage >= 60) return 'D'
  return 'F'
}

const getGradeClass = (): string => {
  const percentage = accuracyPercentage.value
  if (percentage >= 90) return 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200'
  if (percentage >= 80) return 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200'
  if (percentage >= 70) return 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200'
  if (percentage >= 60) return 'bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-200'
  return 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200'
}

const getPercentile = (): number => {
  // Mock percentile calculation
  const percentage = accuracyPercentage.value
  return Math.min(Math.max(percentage + Math.random() * 10 - 5, 0), 100)
}

const getStatus = (): string => {
  const percentage = accuracyPercentage.value
  if (percentage >= 70) return 'Passed'
  return 'Failed'
}

const getStatusClass = (): string => {
  const percentage = accuracyPercentage.value
  if (percentage >= 70) return 'text-green-600 dark:text-green-400'
  return 'text-red-600 dark:text-red-400'
}

const getEfficiencyRating = (): string => {
  const avgTime = averageTimePerQuestion.value
  if (avgTime < 60) return 'Very Fast'
  if (avgTime < 120) return 'Fast'
  if (avgTime < 180) return 'Average'
  if (avgTime < 240) return 'Slow'
  return 'Very Slow'
}

const formatTime = (seconds: number): string => {
  const minutes = Math.floor(seconds / 60)
  const remainingSeconds = seconds % 60
  
  if (minutes === 0) {
    return `${remainingSeconds}s`
  }
  
  return `${minutes}m ${remainingSeconds}s`
}

const getRecommendations = (): Recommendation[] => {
  const percentage = accuracyPercentage.value
  const recommendations: Recommendation[] = []

  if (percentage >= 90) {
    recommendations.push({
      id: 'excellent',
      title: 'Outstanding Performance!',
      description: 'You have demonstrated excellent mastery of the subject matter.',
      icon: Trophy,
      colorClass: 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400'
    })
  } else if (percentage >= 70) {
    recommendations.push({
      id: 'good',
      title: 'Good Job!',
      description: 'You performed well. Review the missed questions to improve further.',
      icon: Target,
      colorClass: 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400'
    })
  } else {
    recommendations.push({
      id: 'improvement',
      title: 'Focus on Key Areas',
      description: 'Consider reviewing the material and practicing more questions.',
      icon: BookOpen,
      colorClass: 'bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400'
    })
  }

  if (averageTimePerQuestion.value > 180) {
    recommendations.push({
      id: 'time',
      title: 'Improve Time Management',
      description: 'Try to answer questions more quickly while maintaining accuracy.',
      icon: Clock,
      colorClass: 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400'
    })
  }

  recommendations.push({
    id: 'practice',
    title: 'Continue Learning',
    description: 'Regular practice will help reinforce your knowledge and skills.',
    icon: Brain,
    colorClass: 'bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400'
  })

  return recommendations
}

// Actions
const reviewAnswers = () => {
  router.push({ name: 'Review', params: { test_id: route.params.test_id } })
}

const downloadResults = () => {
  // Create and download results as PDF/JSON
  const dataStr = JSON.stringify(result.value, null, 2)
  const dataBlob = new Blob([dataStr], { type: 'application/json' })
  const url = URL.createObjectURL(dataBlob)
  const link = document.createElement('a')
  link.href = url
  link.download = `quiz-results-${route.params.test_id}.json`
  link.click()
  URL.revokeObjectURL(url)
}

const retakeQuiz = () => {
  if (confirm('Are you sure you want to retake this quiz? Your current results will be lost.')) {
    router.push({ name: 'quiz', params: { test_id: route.params.test_id } })
  }
}

const goHome = () => {
  router.push('/')
}

onMounted(() => {
  fetchResult()
})
</script>

<style scoped>
/* Animation for score display */
@keyframes scoreReveal {
  0% {
    transform: scale(0);
    opacity: 0;
  }
  50% {
    transform: scale(1.1);
  }
  100% {
    transform: scale(1);
    opacity: 1;
  }
}

.score-animation {
  animation: scoreReveal 0.8s ease-out;
}

/* Progress bar animation */
@keyframes progressFill {
  0% {
    width: 0%;
  }
  100% {
    width: var(--progress-width);
  }
}

.progress-bar {
  animation: progressFill 1s ease-out;
}
</style>