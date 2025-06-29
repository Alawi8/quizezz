<template>
  <footer class="fixed bottom-0 left-0 right-0 z-40 bg-white/95 dark:bg-gray-900/95 backdrop-blur-sm border-t border-gray-200 dark:border-gray-700">
    <div class="flex items-center justify-between px-4 py-3">
      <!-- Left Tools -->
      <div class="flex items-center space-x-2">
        <button @click="showSettings = true" class="tool-btn" title="Settings">⚙️</button>
        <button @click="showFilter = true" class="tool-btn" title="Filter">🔍</button>
        <button @click="showHelp = true" class="tool-btn" title="Help">❓</button>
        <button @click="showCalculator = true" class="tool-btn" title="Calculator">🧮</button>
      </div>

      <!-- Center Navigation -->
      <div class="flex items-center space-x-3">
        <button 
          @click="handlePrevious" 
          :disabled="!canGoPrevious"
          class="tool-btn"
          :class="{ 'opacity-50 cursor-not-allowed': !canGoPrevious }"
          title="Previous"
        >
          ←
        </button>
        <div class="px-3 py-1 bg-gray-100 dark:bg-gray-800 rounded-full text-sm font-medium">
          {{ currentQuestionIndex + 1 }} / {{ totalQuestions }}
        </div>
        <button 
          @click="handleNext" 
          :disabled="!canGoNext"
          class="tool-btn"
          :class="{ 'opacity-50 cursor-not-allowed': !canGoNext }"
          title="Next"
        >
          →
        </button>
      </div>

      <!-- Right Actions -->
      <div class="flex items-center space-x-2">
        <button @click="showNotes = true" class="tool-btn" title="Notes">📝</button>
        <button 
          @click="toggleBookmark" 
          class="tool-btn"
          :class="{ 'bg-orange-100 dark:bg-orange-900/30 text-orange-600': isBookmarked }"
          title="Bookmark"
        >
          {{ isBookmarked ? '🏷️' : '🔖' }}
        </button>
        <button @click="showQuestionMenu = true" class="tool-btn" title="Questions">📋</button>
      </div>
    </div>

    <!-- Modals -->
    <Teleport to="body">
      <!-- Settings Modal -->
      <div v-if="showSettings" class="modal-overlay" @click.self="showSettings = false">
        <div class="modal-content max-w-sm">
          <div class="modal-header">
            <h3 class="font-semibold">Settings</h3>
            <button @click="showSettings = false" class="text-gray-500 hover:text-gray-700">✕</button>
          </div>
          <div class="p-4 space-y-4">
            <div class="flex items-center justify-between">
              <span>🌙 Dark Mode</span>
              <button @click="toggleTheme" class="toggle-switch" :class="{ active: isDark }">
                <div class="toggle-thumb" :class="{ active: isDark }"></div>
              </button>
            </div>
            <div class="flex items-center justify-between">
              <span>💾 Auto Save</span>
              <button @click="autoSave = !autoSave" class="toggle-switch" :class="{ active: autoSave }">
                <div class="toggle-thumb" :class="{ active: autoSave }"></div>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Filter Modal -->
      <div v-if="showFilter" class="modal-overlay" @click.self="showFilter = false">
        <div class="modal-content max-w-sm">
          <div class="modal-header">
            <h3 class="font-semibold">Filter Questions</h3>
            <button @click="showFilter = false" class="text-gray-500 hover:text-gray-700">✕</button>
          </div>
          <div class="p-4 space-y-2">
            <button 
              v-for="filter in filters" 
              :key="filter.key"
              @click="setFilter(filter.key)"
              class="w-full flex items-center justify-between p-3 rounded-lg border transition-colors"
              :class="currentFilter === filter.key 
                ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20 text-blue-700' 
                : 'border-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
            >
              <span>{{ filter.label }}</span>
              <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">{{ filter.count }}</span>
            </button>
          </div>
        </div>
      </div>

      <!-- Help Modal -->
      <div v-if="showHelp" class="modal-overlay" @click.self="showHelp = false">
        <div class="modal-content max-w-md">
          <div class="modal-header">
            <h3 class="font-semibold">Quick Help</h3>
            <button @click="showHelp = false" class="text-gray-500 hover:text-gray-700">✕</button>
          </div>
          <div class="p-4 space-y-3 text-sm">
            <div class="flex items-start space-x-3">
              <span class="text-lg">🖱️</span>
              <div><strong>Click:</strong> Select answers by clicking</div>
            </div>
            <div class="flex items-start space-x-3">
              <span class="text-lg">⌨️</span>
              <div><strong>Keyboard:</strong> Use ← → arrows to navigate</div>
            </div>
            <div class="flex items-start space-x-3">
              <span class="text-lg">🏷️</span>
              <div><strong>Bookmark:</strong> Mark questions for review</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Calculator Modal -->
      <div v-if="showCalculator" class="modal-overlay" @click.self="showCalculator = false">
        <div class="modal-content max-w-xs">
          <div class="modal-header">
            <h3 class="font-semibold">Calculator</h3>
            <button @click="showCalculator = false" class="text-gray-500 hover:text-gray-700">✕</button>
          </div>
          <div class="p-4">
            <input v-model="calcDisplay" readonly class="w-full p-3 text-right text-lg bg-gray-50 dark:bg-gray-700 border rounded-lg font-mono mb-3" placeholder="0" />
            <div class="grid grid-cols-4 gap-2">
              <button @click="clearCalc" class="calc-btn bg-red-500 hover:bg-red-600 text-white">C</button>
              <button @click="deleteLast" class="calc-btn bg-orange-500 hover:bg-orange-600 text-white">⌫</button>
              <button @click="appendCalc('%')" class="calc-btn bg-blue-500 hover:bg-blue-600 text-white">%</button>
              <button @click="appendCalc('/')" class="calc-btn bg-blue-500 hover:bg-blue-600 text-white">÷</button>
              
              <button @click="appendCalc('7')" class="calc-btn bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600">7</button>
              <button @click="appendCalc('8')" class="calc-btn bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600">8</button>
              <button @click="appendCalc('9')" class="calc-btn bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600">9</button>
              <button @click="appendCalc('*')" class="calc-btn bg-blue-500 hover:bg-blue-600 text-white">×</button>
              
              <button @click="appendCalc('4')" class="calc-btn bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600">4</button>
              <button @click="appendCalc('5')" class="calc-btn bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600">5</button>
              <button @click="appendCalc('6')" class="calc-btn bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600">6</button>
              <button @click="appendCalc('-')" class="calc-btn bg-blue-500 hover:bg-blue-600 text-white">-</button>
              
              <button @click="appendCalc('1')" class="calc-btn bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600">1</button>
              <button @click="appendCalc('2')" class="calc-btn bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600">2</button>
              <button @click="appendCalc('3')" class="calc-btn bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600">3</button>
              <button @click="appendCalc('+')" class="calc-btn bg-blue-500 hover:bg-blue-600 text-white">+</button>
              
              <button @click="appendCalc('0')" class="calc-btn bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 col-span-2">0</button>
              <button @click="appendCalc('.')" class="calc-btn bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600">.</button>
              <button @click="calculate" class="calc-btn bg-green-500 hover:bg-green-600 text-white">=</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Notes Modal -->
      <div v-if="showNotes" class="modal-overlay" @click.self="showNotes = false">
        <div class="modal-content max-w-sm">
          <div class="modal-header">
            <h3 class="font-semibold">Question Notes</h3>
            <button @click="showNotes = false" class="text-gray-500 hover:text-gray-700">✕</button>
          </div>
          <div class="p-4">
            <textarea
              v-model="noteText"
              class="w-full h-24 p-3 border rounded-lg resize-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              placeholder="Add your notes..."
              maxlength="300"
            ></textarea>
            <div class="flex justify-between items-center mt-3">
              <span class="text-xs text-gray-500">{{ noteText.length }}/300</span>
              <div class="space-x-2">
                <button @click="noteText = ''" class="px-3 py-1 text-red-600 hover:bg-red-50 rounded text-sm">Clear</button>
                <button @click="saveNote" class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">Save</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Question Navigator -->
      <div v-if="showQuestionMenu" class="modal-overlay" @click.self="showQuestionMenu = false">
        <div class="modal-content max-w-sm">
          <div class="modal-header">
            <h3 class="font-semibold">Questions</h3>
            <button @click="showQuestionMenu = false" class="text-gray-500 hover:text-gray-700">✕</button>
          </div>
          <div class="p-4">
            <div class="grid grid-cols-6 gap-2 mb-4">
              <button
                v-for="i in totalQuestions"
                :key="i"
                @click="goToQuestion(i - 1)"
                class="w-8 h-8 rounded text-xs font-bold transition-all hover:scale-105"
                :class="getQuestionClass(i - 1)"
              >
                {{ i }}
              </button>
            </div>
            <div class="flex justify-center space-x-4 text-xs text-gray-600">
              <div class="flex items-center space-x-1">
                <div class="w-3 h-3 bg-blue-500 rounded"></div>
                <span>Current</span>
              </div>
              <div class="flex items-center space-x-1">
                <div class="w-3 h-3 bg-green-500 rounded"></div>
                <span>Answered</span>
              </div>
              <div class="flex items-center space-x-1">
                <div class="w-3 h-3 bg-orange-500 rounded"></div>
                <span>Marked</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Teleport>
  </footer>
</template>

<script setup lang="ts">
import { ref, computed, inject, onMounted, onUnmounted, watch } from 'vue'

// State
const showSettings = ref(false)
const showFilter = ref(false)
const showHelp = ref(false)
const showCalculator = ref(false)
const showNotes = ref(false)
const showQuestionMenu = ref(false)

const isDark = ref(document.documentElement.classList.contains('dark'))
const autoSave = ref(true)
const isBookmarked = ref(false)
const currentFilter = ref('all')
const calcDisplay = ref('')
const noteText = ref('')

// Injected values
const prevQuestion = inject('prevQuestion', () => {})
const nextQuestion = inject('nextQuestion', () => {})
const currentQuestionIndex = inject('currentQuestionIndex', ref(0))
const totalQuestions = inject('totalQuestions', ref(25))

// Computed
const canGoPrevious = computed(() => currentQuestionIndex.value > 0)
const canGoNext = computed(() => currentQuestionIndex.value < totalQuestions.value - 1)

const filters = [
  { key: 'all', label: 'All Questions', count: 25 },
  { key: 'answered', label: 'Answered', count: 18 },
  { key: 'unanswered', label: 'Unanswered', count: 7 },
  { key: 'bookmarked', label: 'Bookmarked', count: 3 }
]

// Methods
const handlePrevious = () => canGoPrevious.value && prevQuestion()
const handleNext = () => canGoNext.value && nextQuestion()

const toggleBookmark = () => {
  isBookmarked.value = !isBookmarked.value
}

const toggleTheme = () => {
  isDark.value = !isDark.value
  document.documentElement.classList.toggle('dark')
  localStorage.setItem('theme', isDark.value ? 'dark' : 'light')
}

const setFilter = (filter: string) => {
  currentFilter.value = filter
  showFilter.value = false
}

// Calculator
const appendCalc = (value: string) => {
  if (calcDisplay.value === 'Error') calcDisplay.value = ''
  calcDisplay.value += value
}

const clearCalc = () => calcDisplay.value = ''
const deleteLast = () => calcDisplay.value = calcDisplay.value.slice(0, -1)

const calculate = () => {
  try {
    const result = eval(calcDisplay.value.replace(/×/g, '*').replace(/÷/g, '/'))
    calcDisplay.value = result.toString()
  } catch {
    calcDisplay.value = 'Error'
    setTimeout(() => calcDisplay.value = '', 2000)
  }
}

// Notes
const saveNote = () => {
  const notes = JSON.parse(localStorage.getItem('quiz-notes') || '{}')
  notes[currentQuestionIndex.value] = noteText.value
  localStorage.setItem('quiz-notes', JSON.stringify(notes))
  showNotes.value = false
}

const loadNote = () => {
  const notes = JSON.parse(localStorage.getItem('quiz-notes') || '{}')
  noteText.value = notes[currentQuestionIndex.value] || ''
}

// Question navigation
const goToQuestion = (index: number) => {
  showQuestionMenu.value = false
}

const getQuestionClass = (index: number) => {
  if (index === currentQuestionIndex.value) return 'bg-blue-500 text-white'
  if ([1, 3, 5, 7, 9, 11, 13, 15, 17].includes(index)) return 'bg-green-500 text-white'
  if ([2, 8, 14].includes(index)) return 'bg-orange-500 text-white'
  return 'bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600'
}

// Keyboard shortcuts
const handleKeyboard = (e: KeyboardEvent) => {
  if ((e.target as HTMLElement).tagName === 'INPUT' || (e.target as HTMLElement).tagName === 'TEXTAREA') return
  
  switch(e.key) {
    case 'ArrowLeft':
      e.preventDefault()
      handlePrevious()
      break
    case 'ArrowRight':
      e.preventDefault()
      handleNext()
      break
    case 'b':
      toggleBookmark()
      break
    case 'Escape':
      showSettings.value = false
      showFilter.value = false
      showHelp.value = false
      showCalculator.value = false
      showNotes.value = false
      showQuestionMenu.value = false
      break
  }
}

onMounted(() => {
  document.addEventListener('keydown', handleKeyboard)
  loadNote()
})

onUnmounted(() => {
  document.removeEventListener('keydown', handleKeyboard)
})

watch(currentQuestionIndex, loadNote)
</script>

<style scoped>
.tool-btn {
  @apply w-10 h-10 rounded-lg flex items-center justify-center text-lg transition-all duration-200 hover:scale-105 hover:bg-gray-100 dark:hover:bg-gray-800 active:scale-95;
}

.modal-overlay {
  @apply fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50;
}

.modal-content {
  @apply bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full;
}

.modal-header {
  @apply flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700;
}

.toggle-switch {
  @apply relative w-11 h-6 bg-gray-300 dark:bg-gray-600 rounded-full transition-colors duration-200;
}

.toggle-switch.active {
  @apply bg-blue-600;
}

.toggle-thumb {
  @apply absolute w-4 h-4 bg-white rounded-full top-1 left-1 transition-transform duration-200;
}

.toggle-thumb.active {
  @apply transform translate-x-5;
}

.calc-btn {
  @apply p-3 rounded-lg font-semibold transition-all duration-200 hover:scale-105 active:scale-95;
}
</style>