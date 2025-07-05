<template>
  <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
    <!-- Question Header -->
    <div class="bg-gradient-to-r from-green-50 to-blue-50 dark:from-green-900/20 dark:to-blue-900/20 p-4 md:p-6 border-b border-gray-200 dark:border-gray-700">
      <div class="flex items-start justify-between mb-3 md:mb-4">
        <!-- Question Info -->
        <div class="flex items-center space-x-2 md:space-x-3">
          <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center text-white font-bold text-sm md:text-base">
            {{ questionIndex + 1 }}
          </div>
          <div>
            <h2 class="text-base md:text-lg font-semibold text-gray-900 dark:text-white">
              Question {{ questionIndex + 1 }}
            </h2>
            <div class="flex items-center space-x-2 mt-1">
              <div 
                class="w-2 h-2 rounded-full"
                :class="statusColor"
              ></div>
              <span class="text-xs md:text-sm text-gray-600 dark:text-gray-400">
                {{ statusText }}
              </span>
            </div>
          </div>
        </div>
        
        <!-- Question Actions -->
        <div class="flex items-center space-x-1 md:space-x-2">
          <button
            @click="toggleBookmark"
            class="p-2 rounded-lg transition-all duration-200 hover:scale-110"
            :class="isBookmarked 
              ? 'text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20' 
              : 'text-gray-400 hover:text-red-500 hover:bg-gray-50 dark:hover:bg-gray-700'"
            :title="isBookmarked ? 'Remove bookmark' : 'Add bookmark'"
          >
            <Flag class="w-4 h-4 md:w-5 md:h-5" :fill="isBookmarked ? 'currentColor' : 'none'" />
          </button>
          
          <button
            v-if="strikedAnswers.length > 0"
            @click="clearStrikes"
            class="p-2 rounded-lg text-orange-500 hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-all duration-200"
            title="Clear strikes"
          >
            <RotateCcw class="w-4 h-4 md:w-5 md:h-5" />
          </button>
        </div>
      </div>

      <!-- Question Text -->
      <div class="prose dark:prose-invert max-w-none">
        <p class="text-base md:text-lg leading-relaxed text-gray-800 dark:text-gray-200 mb-0">
          {{ question.question_text }}
        </p>
      </div>
    </div>

    <!-- Answer Options -->
    <div class="p-4 md:p-6">
      <div class="space-y-2 md:space-y-3">
        <button
          v-for="(answer, index) in question.answers"
          :key="answer.id"
          class="group relative w-full text-left"
          @click="handleSelectAnswer(answer)"
          @touchstart="handleTouchStart(answer)"
          @touchend="handleTouchEnd"
          @contextmenu.prevent="handleStrikeAnswer(answer)"
          :disabled="isStriked(answer)"
        >
          <div
            class="flex items-center p-3 md:p-4 rounded-xl border-2 transition-all duration-300"
            :class="getAnswerClass(answer)"
          >
            <!-- Answer Letter -->
            <div 
              class="flex-shrink-0 w-8 h-8 md:w-10 md:h-10 rounded-lg flex items-center justify-center font-bold text-sm md:text-lg mr-3 md:mr-4 transition-all duration-300"
              :class="getLetterClass(answer)"
            >
              {{ String.fromCharCode(65 + index) }}
            </div>

            <!-- Answer Content -->
            <div class="flex-1 min-w-0">
              <span 
                class="text-sm md:text-lg leading-relaxed transition-all duration-300 block"
                :class="getTextClass(answer)"
              >
                {{ answer.answer_text }}
              </span>
            </div>

            <!-- Status Indicators -->
            <div class="flex items-center space-x-1 md:space-x-2 ml-2 md:ml-4">
              <!-- Strike Indicator -->
              <div 
                v-if="isStriked(answer)"
                class="flex items-center justify-center w-5 h-5 md:w-6 md:h-6 bg-red-100 dark:bg-red-900/30 rounded-full"
              >
                <X class="w-3 h-3 md:w-4 md:h-4 text-red-600 dark:text-red-400" />
              </div>

              <!-- Selected Indicator -->
              <div 
                v-else-if="isSelected(answer)"
                class="flex items-center justify-center w-5 h-5 md:w-6 md:h-6 bg-green-100 dark:bg-green-900/30 rounded-full"
              >
                <Check class="w-3 h-3 md:w-4 md:h-4 text-green-600 dark:text-green-400" />
              </div>

              <!-- Hover Indicator -->
              <ChevronRight 
                v-else
                class="w-4 h-4 md:w-5 md:h-5 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity duration-200" 
              />
            </div>
          </div>

          <!-- Strike Animation Overlay -->
          <div 
            v-if="isStriked(answer)"
            class="absolute inset-0 pointer-events-none"
          >
            <div class="absolute inset-0 bg-red-500/10 rounded-xl"></div>
            <div class="absolute top-1/2 left-0 right-0 h-0.5 bg-red-500 transform -translate-y-1/2"></div>
          </div>
        </button>
      </div>

      <!-- Instructions -->
      <div class="mt-4 md:mt-6 p-3 md:p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
        <div class="flex items-start space-x-3">
          <Info class="w-4 h-4 md:w-5 md:h-5 text-blue-500 mt-0.5 flex-shrink-0" />
          <div class="text-xs md:text-sm text-gray-600 dark:text-gray-400">
            <p class="mb-2 font-medium">Instructions:</p>
            <div class="space-y-1">
              <p>• Tap to select an answer</p>
              <p class="md:hidden">• Long press to eliminate option</p>
              <p class="hidden md:block">• Right-click to strike out options</p>
              <p class="hidden md:block">• Use keyboard 1, 2, 3, 4 for quick selection</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'
import { 
  Flag, 
  RotateCcw, 
  Check, 
  X, 
  ChevronRight, 
  Info 
} from 'lucide-vue-next'

interface Answer {
  id: number
  answer_text: string
}

interface Question {
  id: number
  question_text: string
  answers: Answer[]
}

interface Props {
  question: Question
  questionIndex: number
  selectedAnswer?: number | null
  userAnswers: Record<number, number>
  strikedAnswers: number[]
}

const props = withDefaults(defineProps<Props>(), {
  selectedAnswer: null
})

const emit = defineEmits<{
  'selectAnswer': [answer: Answer]
  'strikeAnswer': [answer: Answer]
}>()

// Touch handling for mobile
const touchTimer = ref<NodeJS.Timeout | null>(null)
const isLongPress = ref(false)

// Computed Properties
const isBookmarked = computed(() => {
  // This would be managed by parent component
  return false
})

const statusColor = computed(() => {
  const isAnswered = props.userAnswers[props.question.id]
  if (isAnswered) return 'bg-green-500'
  if (props.strikedAnswers.length > 0) return 'bg-orange-500'
  return 'bg-gray-400'
})

const statusText = computed(() => {
  const isAnswered = props.userAnswers[props.question.id]
  const strikedCount = props.strikedAnswers.length
  
  if (isAnswered) return 'Answered'
  if (strikedCount > 0) return `${strikedCount} option(s) eliminated`
  return 'Not answered'
})

// Methods
const isSelected = (answer: Answer): boolean => {
  return props.userAnswers[props.question.id] === answer.id
}

const isStriked = (answer: Answer): boolean => {
  return props.strikedAnswers.includes(answer.id)
}

const getAnswerClass = (answer: Answer): string => {
  const baseClass = 'transition-all duration-300 transform active:scale-[0.98]'
  
  if (isStriked(answer)) {
    return `${baseClass} bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800 opacity-60 cursor-not-allowed`
  }
  
  if (isSelected(answer)) {
    return `${baseClass} bg-green-50 dark:bg-green-900/20 border-green-500 dark:border-green-400 shadow-lg shadow-green-500/20`
  }
  
  return `${baseClass} bg-white dark:bg-gray-700 border-gray-200 dark:border-gray-600 hover:border-green-300 dark:hover:border-green-600 hover:bg-green-50 dark:hover:bg-green-900/10 active:border-green-400`
}

const getLetterClass = (answer: Answer): string => {
  if (isStriked(answer)) {
    return 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400'
  }
  
  if (isSelected(answer)) {
    return 'bg-green-500 text-white shadow-lg'
  }
  
  return 'bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 group-hover:bg-green-100 dark:group-hover:bg-green-900/30 group-hover:text-green-700 dark:group-hover:text-green-400'
}

const getTextClass = (answer: Answer): string => {
  if (isStriked(answer)) {
    return 'text-red-600 dark:text-red-400 line-through'
  }
  
  if (isSelected(answer)) {
    return 'text-green-700 dark:text-green-300 font-medium'
  }
  
  return 'text-gray-800 dark:text-gray-200 group-hover:text-green-700 dark:group-hover:text-green-300'
}

const handleSelectAnswer = (answer: Answer): void => {
  if (!isStriked(answer) && !isLongPress.value) {
    emit('selectAnswer', answer)
  }
}

const handleStrikeAnswer = (answer: Answer): void => {
  if (!isSelected(answer)) {
    emit('strikeAnswer', answer)
  }
}

// Mobile touch handlers
const handleTouchStart = (answer: Answer): void => {
  isLongPress.value = false
  touchTimer.value = setTimeout(() => {
    isLongPress.value = true
    // Haptic feedback if available
    if (navigator.vibrate) {
      navigator.vibrate(50)
    }
    handleStrikeAnswer(answer)
  }, 500) // 500ms for long press
}

const handleTouchEnd = (): void => {
  if (touchTimer.value) {
    clearTimeout(touchTimer.value)
    touchTimer.value = null
  }
  // Reset long press flag after a short delay
  setTimeout(() => {
    isLongPress.value = false
  }, 100)
}

const toggleBookmark = (): void => {
  // This would emit to parent component
  console.log('Toggle bookmark for question:', props.question.id)
}

const clearStrikes = (): void => {
  // This would emit to parent component
  console.log('Clear strikes for question:', props.question.id)
}
</script>