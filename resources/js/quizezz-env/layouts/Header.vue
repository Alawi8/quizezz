<template>
  <header class="sticky top-16 z-40 bg-white/90 dark:bg-gray-900/90 backdrop-blur-lg border-b border-gray-200 dark:border-gray-700 transition-all duration-300">
    <div class="container mx-auto px-4">
      <div class="flex items-center justify-between py-3">
        <!-- Section Info -->
        <div class="flex items-center space-x-3">
          <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
            <LayoutDashboard class="w-4 h-4 text-white" />
          </div>
          <div>
            <h1 class="text-base font-semibold text-gray-900 dark:text-white truncate max-w-xs">
              {{ quizData?.title || 'Loading...' }}
            </h1>
            <p class="text-xs text-gray-600 dark:text-gray-400 truncate max-w-xs">
              {{ quizData?.description || 'Please wait...' }}
            </p>
          </div>
        </div>

        <!-- Circular Timer with Progress -->
        <div class="flex items-center justify-center">
          <div v-if="!quizData" class="flex items-center space-x-2 bg-gray-50 dark:bg-gray-800 px-4 py-2 rounded-full border border-gray-200 dark:border-gray-600">
            <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-blue-500"></div>
            <span class="text-xs text-gray-500 dark:text-gray-400">Loading...</span>
          </div>
          
          <div v-else class="relative group">
            <!-- Circular Progress Ring -->
            <div class="relative w-16 h-16">
              <!-- Background Circle -->
              <svg class="w-full h-full -rotate-90" viewBox="0 0 64 64">
                <circle
                  cx="32"
                  cy="32"
                  r="28"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="4"
                  class="text-gray-200 dark:text-gray-700"
                />
                <!-- Progress Circle -->
                <circle
                  cx="32"
                  cy="32"
                  r="28"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="4"
                  stroke-linecap="round"
                  :stroke-dasharray="circumference"
                  :stroke-dashoffset="strokeDashoffset"
                  :class="getProgressColorClass()"
                  class="transition-all duration-500 ease-out"
                />
              </svg>
              
              <!-- Timer Content -->
              <div class="absolute inset-0 flex flex-col items-center justify-center">
                <AlarmClock 
                  class="w-3 h-3 mb-0.5"
                  :class="getTimerIconColorClass()"
                />
                <div 
                  class="text-xs font-bold leading-none"
                  :class="getTimerColorClass()"
                >
                  {{ formatShortTime(timeLeft) }}
                </div>
              </div>
            </div>
            
            <!-- Progress Info Tooltip -->
            <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 whitespace-nowrap">
              <div class="bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                {{ props.answeredQuestions }}/{{ props.totalQuestions }} answered
              </div>
            </div>
          </div>
        </div>

        <!-- Exit Button -->
        <div class="flex items-center space-x-2">
          <div v-if="testEnded" class="flex items-center space-x-1 text-red-500">
            <XCircle class="w-4 h-4" />
            <span class="text-xs font-medium hidden sm:inline">Ended</span>
          </div>
          
          <button
            @click="handleExit"
            :disabled="!quizData"
            class="flex items-center space-x-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg transition-all duration-200 group disabled:opacity-50 disabled:cursor-not-allowed"
            title="Exit Test"
          >
            <LogOut class="w-4 h-4 group-hover:scale-110 transition-transform duration-200" />
            <span class="text-xs font-medium hidden sm:inline">Exit</span>
          </button>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup lang="ts">
import { ref, watch, onMounted, computed, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import {
  AlarmClock,
  XCircle,
  LogOut,
  LayoutDashboard
} from 'lucide-vue-next'

interface QuizData {
  id: string
  title: string
  description: string
  duration: number // المدة بالدقائق
  questions_count: number
}

interface Props {
  quizData?: QuizData | null
  currentQuestion?: number
  totalQuestions?: number
  answeredQuestions?: number
  testEnded?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  quizData: null,
  currentQuestion: 0,
  totalQuestions: 0,
  answeredQuestions: 0,
  testEnded: false
})

const emit = defineEmits<{
  'time-up': []
  'exit-test': []
}>()

const router = useRouter()
const timeLeft = ref(0)
const intervalId = ref<NodeJS.Timeout | null>(null)

// حساب محيط الدائرة للـ progress ring
const circumference = 2 * Math.PI * 28 // radius = 28

const strokeDashoffset = computed(() => {
  const progress = progressPercentage.value / 100
  return circumference - (progress * circumference)
})

// مفتاح حفظ الوقت في localStorage
const getTimerStorageKey = () => {
  return props.quizData ? `quiz_timer_${props.quizData.id}` : null
}

// حفظ الوقت المتبقي
const saveTimeLeft = () => {
  const key = getTimerStorageKey()
  if (key) {
    try {
      const timerData = {
        timeLeft: timeLeft.value,
        timestamp: Date.now()
      }
      localStorage.setItem(key, JSON.stringify(timerData))
    } catch (e) {
      console.warn('Failed to save timer:', e)
    }
  }
}

// استرجاع الوقت المحفوظ
const loadSavedTime = (): number | null => {
  const key = getTimerStorageKey()
  if (!key) return null
  
  try {
    const saved = localStorage.getItem(key)
    if (!saved) return null
    
    const timerData = JSON.parse(saved)
    const elapsed = Math.floor((Date.now() - timerData.timestamp) / 1000)
    const remainingTime = timerData.timeLeft - elapsed
    
    return remainingTime > 0 ? remainingTime : 0
  } catch (e) {
    console.warn('Failed to load saved timer:', e)
    return null
  }
}

// مسح البيانات المحفوظة
const clearSavedTime = () => {
  const key = getTimerStorageKey()
  if (key) {
    try {
      localStorage.removeItem(key)
    } catch (e) {
      console.warn('Failed to clear saved timer:', e)
    }
  }
}

const progressPercentage = computed(() => {
  if (!props.totalQuestions || props.totalQuestions === 0) return 0
  return Math.round((props.answeredQuestions / props.totalQuestions) * 100)
})

const formatTime = (seconds: number): string => {
  const hours = Math.floor(seconds / 3600)
  const minutes = Math.floor((seconds % 3600) / 60)
  const secs = seconds % 60
  
  if (hours > 0) {
    return `${hours}:${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`
  }
  return `${minutes}:${secs.toString().padStart(2, '0')}`
}

const formatShortTime = (seconds: number): string => {
  const minutes = Math.floor(seconds / 60)
  const secs = seconds % 60
  
  if (minutes >= 60) {
    const hours = Math.floor(minutes / 60)
    const remainingMinutes = minutes % 60
    return `${hours}:${remainingMinutes.toString().padStart(2, '0')}`
  }
  
  return `${minutes}:${secs.toString().padStart(2, '0')}`
}

const getTimerColorClass = (): string => {
  if (timeLeft.value <= 300) return 'text-red-600 dark:text-red-400'
  if (timeLeft.value <= 600) return 'text-yellow-600 dark:text-yellow-400'
  return 'text-green-600 dark:text-green-400'
}

const getTimerIconColorClass = (): string => {
  if (timeLeft.value <= 300) return 'text-red-500 dark:text-red-400 animate-pulse'
  if (timeLeft.value <= 600) return 'text-yellow-500 dark:text-yellow-400'
  return 'text-green-500 dark:text-green-400'
}

const getProgressColorClass = (): string => {
  if (progressPercentage.value >= 80) return 'text-green-500'
  if (progressPercentage.value >= 50) return 'text-blue-500'
  if (progressPercentage.value >= 25) return 'text-yellow-500'
  return 'text-gray-400'
}

const startTimer = (): void => {
  if (intervalId.value) clearInterval(intervalId.value)
  
  intervalId.value = setInterval(() => {
    if (timeLeft.value > 0 && !props.testEnded) {
      timeLeft.value--
      // حفظ الوقت كل 5 ثوانٍ
      if (timeLeft.value % 5 === 0) {
        saveTimeLeft()
      }
    } else if (timeLeft.value <= 0) {
      endTest()
    }
  }, 1000)
}

const endTest = (): void => {
  if (intervalId.value) {
    clearInterval(intervalId.value)
    intervalId.value = null
  }
  // مسح البيانات المحفوظة عند انتهاء الاختبار
  clearSavedTime()
  emit('time-up')
}

const handleExit = (): void => {
  if (confirm('Are you sure you want to exit the test? Your progress will be saved.')) {
    if (intervalId.value) {
      clearInterval(intervalId.value)
    }
    emit('exit-test')
  }
}

// مراقبة تغيير بيانات الكويز
watch(() => props.quizData, (newQuizData) => {
  if (newQuizData && newQuizData.duration) {
    // محاولة استرجاع الوقت المحفوظ أولاً
    const savedTime = loadSavedTime()
    
    if (savedTime !== null && savedTime > 0) {
      // استخدام الوقت المحفوظ
      timeLeft.value = savedTime
      console.log(`Timer resumed: ${Math.ceil(savedTime / 60)} minutes remaining`)
    } else {
      // بدء جديد - تحويل المدة من دقائق إلى ثواني
      timeLeft.value = newQuizData.duration * 60
      console.log(`Timer started: ${newQuizData.duration} minutes (${timeLeft.value} seconds)`)
    }
    
    startTimer()
  }
}, { immediate: true })

// إيقاف المؤقت عند انتهاء الاختبار
watch(() => props.testEnded, (ended) => {
  if (ended && intervalId.value) {
    clearInterval(intervalId.value)
    intervalId.value = null
  }
})

onUnmounted(() => {
  if (intervalId.value) {
    clearInterval(intervalId.value)
  }
  // حفظ الوقت المتبقي عند مغادرة الصفحة
  saveTimeLeft()
})

// Expose methods for parent component
defineExpose({
  resetTimer: () => {
    if (props.quizData) {
      timeLeft.value = props.quizData.duration * 60
      clearSavedTime() // مسح الوقت المحفوظ عند إعادة التعيين
      startTimer()
    }
  },
  clearSavedTimer: clearSavedTime
})
</script>