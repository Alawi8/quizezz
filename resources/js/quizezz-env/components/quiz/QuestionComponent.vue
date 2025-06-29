<template>
  <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:shadow-xl">
    <!-- Question Header -->
    <div class="bg-gradient-to-r from-green-50 to-blue-50 dark:from-green-900/20 dark:to-blue-900/20 p-6 border-b border-gray-200 dark:border-gray-700">
      <div class="flex items-start justify-between mb-4">
        <div class="flex items-center space-x-3">
          <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center text-white font-bold">
            {{ questionIndex + 1 }}
          </div>
          <div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
              Question {{ questionIndex + 1 }}
            </h2>
            <div class="flex items-center space-x-4 mt-1">
              <span class="text-sm text-gray-600 dark:text-gray-400">
                {{ getAnswerStatus() }}
              </span>
              <div class="flex items-center space-x-2">
                <div 
                  class="w-2 h-2 rounded-full"
                  :class="getStatusColor()"
                ></div>
                <span class="text-xs text-gray-500 dark:text-gray-400">
                  {{ getStatusText() }}
                </span>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Question Actions -->
        <div class="flex items-center space-x-2">
          <button
            @click="toggleBookmark"
            class="p-2 rounded-lg transition-all duration-200 hover:scale-110"
            :class="isBookmarked 
              ? 'text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20' 
              : 'text-gray-400 hover:text-red-500 hover:bg-gray-50 dark:hover:bg-gray-700'"
            :title="isBookmarked ? 'Remove bookmark' : 'Add bookmark'"
          >
            <Flag class="w-5 h-5" :fill="isBookmarked ? 'currentColor' : 'none'" />
          </button>
          
          <button
            @click="clearStrikes"
            v-if="strikedAnswers.length > 0"
            class="p-2 rounded-lg text-orange-500 hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-all duration-200"
            title="Clear strikes"
          >
            <RotateCcw class="w-5 h-5" />
          </button>
        </div>
      </div>

      <!-- Question Text -->
      <div class="prose dark:prose-invert max-w-none">
        <p class="text-lg leading-relaxed text-gray-800 dark:text-gray-200 mb-0">
          {{ question.question_text }}
        </p>
      </div>
    </div>

    <!-- Answer Options -->
    <div class="p-6">
      <div class="space-y-3">
        <div
          v-for="(answer, index) in question.answers"
          :key="answer.id"
          class="group relative"
          @contextmenu.prevent="handleStrikeAnswer(answer)"
        >
          <label
            class="flex items-center p-4 rounded-xl border-2 cursor-pointer transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98]"
            :class="getAnswerClass(answer, index)"
            @click="handleSelectAnswer(answer)"
          >
            <!-- Answer Letter -->
            <div 
              class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center font-bold text-lg mr-4 transition-all duration-300"
              :class="getLetterClass(answer)"
            >
              {{ String.fromCharCode(65 + index) }}
            </div>

            <!-- Answer Content -->
            <div class="flex-1 min-w-0">
              <span 
                class="text-lg leading-relaxed transition-all duration-300"
                :class="getTextClass(answer)"
              >
                {{ answer.answer_text }}
              </span>
            </div>

            <!-- Status Indicators -->
            <div class="flex items-center space-x-2 ml-4">
              <!-- Strike Indicator -->
              <div 
                v-if="isStriked(answer)"
                class="flex items-center justify-center w-6 h-6 bg-red-100 dark:bg-red-900/30 rounded-full"
                title="Striked out"
              >
                <X class="w-4 h-4 text-red-600 dark:text-red-400" />
              </div>

              <!-- Selected Indicator -->
              <div 
                v-if="isSelected(answer)"
                class="flex items-center justify-center w-6 h-6 bg-green-100 dark:bg-green-900/30 rounded-full"
              >
                <Check class="w-4 h-4 text-green-600 dark:text-green-400" />
              </div>

              <!-- Hover Indicator -->
              <div 
                class="opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                v-if="!isSelected(answer) && !isStriked(answer)"
              >
                <ChevronRight class="w-5 h-5 text-gray-400" />
              </div>
            </div>
          </label>

          <!-- Strike Animation Overlay -->
          <div 
            v-if="isStriked(answer)"
            class="absolute inset-0 pointer-events-none"
          >
            <div class="absolute inset-0 bg-red-500/10 rounded-xl"></div>
            <div class="absolute top-1/2 left-0 right-0 h-0.5 bg-red-500 transform -translate-y-1/2"></div>
          </div>
        </div>
      </div>

      <!-- Answer Instructions -->
      <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
        <div class="flex items-start space-x-3">
          <Info class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" />
          <div class="text-sm text-gray-600 dark:text-gray-400">
            <p class="mb-2"><strong>Instructions:</strong></p>
            <ul class="space-y-1">
              <li>• Click on an answer to select it</li>
              <li>• Right-click to strike out incorrect options</li>
              <li>• Use keyboard shortcuts: 1, 2, 3, 4 for quick selection</li>
              <li>• Your answers are automatically saved</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
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
  isBookmarked?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  selectedAnswer: null,
  isBookmarked: false
})

const emit = defineEmits<{
  'selectAnswer': [answer: Answer]
  'strikeAnswer': [answer: Answer]
  'toggleBookmark': []
  'clearStrikes': []
}>()

// Computed Properties
const getAnswerStatus = (): string => {
  const isAnswered = props.userAnswers[props.question.id]
  const strikedCount = props.strikedAnswers.length
  
  if (isAnswered) return 'Answered'
  if (strikedCount > 0) return `${strikedCount} option(s) eliminated`
  return 'Not answered'
}

const getStatusColor = (): string => {
  const isAnswered = props.userAnswers[props.question.id]
  if (isAnswered) return 'bg-green-500'
  if (props.strikedAnswers.length > 0) return 'bg-orange-500'
  return 'bg-gray-400'
}

const getStatusText = (): string => {
  const isAnswered = props.userAnswers[props.question.id]
  if (isAnswered) return 'Complete'
  if (props.strikedAnswers.length > 0) return 'In Progress'
  return 'Pending'
}

// Methods
const isSelected = (answer: Answer): boolean => {
  return props.userAnswers[props.question.id] === answer.id
}

const isStriked = (answer: Answer): boolean => {
  return props.strikedAnswers.includes(answer.id)
}

const getAnswerClass = (answer: Answer, index: number): string => {
  const baseClass = 'transition-all duration-300'
  
  if (isStriked(answer)) {
    return `${baseClass} bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800 opacity-60 cursor-not-allowed`
  }
  
  if (isSelected(answer)) {
    return `${baseClass} bg-green-50 dark:bg-green-900/20 border-green-500 dark:border-green-400 shadow-lg shadow-green-500/20`
  }
  
  return `${baseClass} bg-white dark:bg-gray-700 border-gray-200 dark:border-gray-600 hover:border-green-300 dark:hover:border-green-600 hover:bg-green-50 dark:hover:bg-green-900/10 hover:shadow-md`
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
  if (!isStriked(answer)) {
    emit('selectAnswer', answer)
  }
}

const handleStrikeAnswer = (answer: Answer): void => {
  if (!isSelected(answer)) {
    emit('strikeAnswer', answer)
  }
}

const toggleBookmark = (): void => {
  emit('toggleBookmark')
}

const clearStrikes = (): void => {
  emit('clearStrikes')
}
</script>

<style scoped>
/* Custom animations for answer selection */
@keyframes selectPulse {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.02);
  }
  100% {
    transform: scale(1);
  }
}

.answer-selected {
  animation: selectPulse 0.3s ease-in-out;
}

/* Strike-through line animation */
@keyframes strikeThrough {
  0% {
    width: 0;
  }
  100% {
    width: 100%;
  }
}

.strike-line {
  animation: strikeThrough 0.3s ease-in-out;
}

/* Smooth hover transitions */
.answer-option:hover {
  transform: translateY(-1px);
}

/* Focus styles for accessibility */
.answer-option:focus-within {
  outline: 2px solid #10b981;
  outline-offset: 2px;
}
</style>