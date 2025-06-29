<template>
  <div class="question-scroll bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
    <!-- Header -->
    <div class="p-4 bg-gradient-to-r from-green-50 to-blue-50 dark:from-green-900/20 dark:to-blue-900/20 border-b border-gray-200 dark:border-gray-700">
      <h3 class="text-sm font-semibold text-gray-900 dark:text-white text-center">
        Questions
      </h3>
      <div class="mt-2 text-xs text-gray-600 dark:text-gray-400 text-center">
        {{ answeredCount }} / {{ questions.length }} answered
      </div>
    </div>

    <!-- Questions Grid -->
    <div class="p-3 max-h-[70vh] overflow-y-auto">
      <div class="grid grid-cols-1 gap-2">
        <button
          v-for="(question, index) in questions"
          :key="question.id"
          @click="handleQuestionChange(index)"
          class="relative group w-full h-12 rounded-lg border-2 font-bold text-sm transition-all duration-200 transform hover:scale-105 active:scale-95 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
          :class="getQuestionButtonClass(question, index)"
          :title="getQuestionTooltip(question, index)"
        >
          <!-- Question Number -->
          <span class="relative z-10">
            {{ index + 1 }}
          </span>

          <!-- Status Indicators -->
          <div class="absolute top-1 right-1 flex space-x-1">
            <!-- Bookmark Indicator -->
            <div 
              v-if="isBookmarked(question)"
              class="w-2 h-2 bg-red-500 rounded-full"
            ></div>
            
            <!-- Answer Status Dot -->
            <div 
              class="w-2 h-2 rounded-full"
              :class="getStatusDotClass(question)"
            ></div>
          </div>

          <!-- Current Question Indicator -->
          <div 
            v-if="currentIndex === index"
            class="absolute inset-0 bg-blue-500/20 rounded-lg animate-pulse"
          ></div>

          <!-- Progress Ring for Current Question -->
          <svg 
            v-if="currentIndex === index"
            class="absolute inset-0 w-full h-full -rotate-90"
            viewBox="0 0 48 48"
          >
            <circle
              cx="24"
              cy="24"
              r="20"
              stroke="currentColor"
              stroke-width="2"
              fill="none"
              class="text-blue-500/30"
            />
            <circle
              cx="24"
              cy="24"
              r="20"
              stroke="currentColor"
              stroke-width="2"
              fill="none"
              stroke-linecap="round"
              class="text-blue-500 animate-spin-slow"
              :stroke-dasharray="`${2 * Math.PI * 20}`"
              :stroke-dashoffset="`${2 * Math.PI * 20 * 0.75}`"
            />
          </svg>
        </button>
      </div>
    </div>

    <!-- Legend -->
    <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
      <div class="space-y-2">
        <div class="flex items-center justify-between text-xs">
          <div class="flex items-center space-x-2">
            <div class="w-3 h-3 bg-green-500 rounded"></div>
            <span class="text-gray-600 dark:text-gray-400">Answered</span>
          </div>
          <span class="font-medium text-gray-700 dark:text-gray-300">{{ answeredCount }}</span>
        </div>
        
        <div class="flex items-center justify-between text-xs">
          <div class="flex items-center space-x-2">
            <div class="w-3 h-3 bg-gray-400 rounded"></div>
            <span class="text-gray-600 dark:text-gray-400">Unanswered</span>
          </div>
          <span class="font-medium text-gray-700 dark:text-gray-300">{{ unansweredCount }}</span>
        </div>
        
        <div class="flex items-center justify-between text-xs">
          <div class="flex items-center space-x-2">
            <div class="w-3 h-3 bg-red-500 rounded"></div>
            <span class="text-gray-600 dark:text-gray-400">Bookmarked</span>
          </div>
          <span class="font-medium text-gray-700 dark:text-gray-300">{{ bookmarkedCount }}</span>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
        <div class="grid grid-cols-2 gap-2">
          <button
            @click="goToFirstUnanswered"
            class="px-2 py-1 text-xs bg-orange-100 hover:bg-orange-200 dark:bg-orange-900/20 dark:hover:bg-orange-900/30 text-orange-700 dark:text-orange-400 rounded transition-colors duration-200"
            :disabled="unansweredCount === 0"
          >
            Next Unanswered
          </button>
          
          <button
            @click="goToFirstBookmarked"
            class="px-2 py-1 text-xs bg-red-100 hover:bg-red-200 dark:bg-red-900/20 dark:hover:bg-red-900/30 text-red-700 dark:text-red-400 rounded transition-colors duration-200"
            :disabled="bookmarkedCount === 0"
          >
            Bookmarked
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'

interface Question {
  id: number
  question_text: string
  answers: any[]
}

interface Props {
  questions: Question[]
  currentIndex: number
  userAnswers: Record<number, number>
  bookmarkedQuestions?: Set<number>
}

const props = withDefaults(defineProps<Props>(), {
  bookmarkedQuestions: () => new Set()
})

const emit = defineEmits<{
  'changeQuestion': [index: number]
}>()

// Computed Properties
const answeredCount = computed(() => {
  return props.questions.filter(q => props.userAnswers[q.id]).length
})

const unansweredCount = computed(() => {
  return props.questions.length - answeredCount.value
})

const bookmarkedCount = computed(() => {
  return props.bookmarkedQuestions.size
})

// Methods
const isAnswered = (question: Question): boolean => {
  return Boolean(props.userAnswers[question.id])
}

const isBookmarked = (question: Question): boolean => {
  return props.bookmarkedQuestions.has(question.id)
}

const getQuestionButtonClass = (question: Question, index: number): string => {
  const baseClass = 'relative overflow-hidden'
  
  if (props.currentIndex === index) {
    return `${baseClass} bg-blue-500 text-white border-blue-600 shadow-lg shadow-blue-500/30`
  }
  
  if (isBookmarked(question)) {
    if (isAnswered(question)) {
      return `${baseClass} bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 border-red-300 dark:border-red-700 hover:bg-red-200 dark:hover:bg-red-900/40`
    } else {
      return `${baseClass} bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 border-red-200 dark:border-red-800 hover:bg-red-100 dark:hover:bg-red-900/30`
    }
  }
  
  if (isAnswered(question)) {
    return `${baseClass} bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 border-green-300 dark:border-green-700 hover:bg-green-200 dark:hover:bg-green-900/40`
  }
  
  return `${baseClass} bg-white dark:bg-gray-700 text-gray-600 dark:text-gray-400 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 hover:text-gray-800 dark:hover:text-gray-200`
}

const getStatusDotClass = (question: Question): string => {
  if (isAnswered(question)) {
    return 'bg-green-500'
  }
  return 'bg-gray-400'
}

const getQuestionTooltip = (question: Question, index: number): string => {
  let tooltip = `Question ${index + 1}`
  
  if (isAnswered(question)) {
    tooltip += ' - Answered'
  } else {
    tooltip += ' - Not answered'
  }
  
  if (isBookmarked(question)) {
    tooltip += ' - Bookmarked'
  }
  
  if (props.currentIndex === index) {
    tooltip += ' - Current'
  }
  
  return tooltip
}

const handleQuestionChange = (index: number): void => {
  emit('changeQuestion', index)
}

const goToFirstUnanswered = (): void => {
  const firstUnanswered = props.questions.findIndex(q => !props.userAnswers[q.id])
  if (firstUnanswered !== -1) {
    emit('changeQuestion', firstUnanswered)
  }
}

const goToFirstBookmarked = (): void => {
  const firstBookmarked = props.questions.findIndex(q => props.bookmarkedQuestions.has(q.id))
  if (firstBookmarked !== -1) {
    emit('changeQuestion', firstBookmarked)
  }
}
</script>

<style scoped>
.question-scroll {
  scrollbar-width: thin;
  scrollbar-color: #d1d5db #f9fafb;
}

.question-scroll::-webkit-scrollbar {
  width: 6px;
}

.question-scroll::-webkit-scrollbar-track {
  background: #f9fafb;
  border-radius: 3px;
}

.question-scroll::-webkit-scrollbar-thumb {
  background: #d1d5db;
  border-radius: 3px;
}

.question-scroll::-webkit-scrollbar-thumb:hover {
  background: #9ca3af;
}

.dark .question-scroll {
  scrollbar-color: #4b5563 #1f2937;
}

.dark .question-scroll::-webkit-scrollbar-track {
  background: #1f2937;
}

.dark .question-scroll::-webkit-scrollbar-thumb {
  background: #4b5563;
}

.dark .question-scroll::-webkit-scrollbar-thumb:hover {
  background: #6b7280;
}

@keyframes spin-slow {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

.animate-spin-slow {
  animation: spin-slow 3s linear infinite;
}

/* Button press animation */
@keyframes buttonPress {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(0.95);
  }
  100% {
    transform: scale(1);
  }
}

.button-press {
  animation: buttonPress 0.2s ease-in-out;
}
</style>