<template>
  <footer class="fixed bottom-0 left-0 right-0 z-40 bg-white/95 dark:bg-gray-900/95 backdrop-blur-sm border-t border-gray-200 dark:border-gray-700">
    <!-- Mobile Layout -->
    <div class="block lg:hidden">
      <div class="flex items-center justify-between px-4 py-3">
        <!-- Left Menu Button -->
        <button 
          @click="showLeftMenu = !showLeftMenu" 
          class="tool-btn relative"
          title="Tools"
        >
          <MoreHorizontal class="w-5 h-5" />
          <div v-if="showLeftMenu" class="absolute bottom-full left-0 mb-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 p-2 flex space-x-2">
            <button @click="openModal('settings')" class="tool-btn-small" title="Settings">
              <Settings class="w-4 h-4" />
            </button>
            <button @click="openModal('filter')" class="tool-btn-small" title="Filter">
              <Filter class="w-4 h-4" />
            </button>
            <button @click="openModal('help')" class="tool-btn-small" title="Help">
              <HelpCircle class="w-4 h-4" />
            </button>
            <button @click="openModal('calculator')" class="tool-btn-small" title="Calculator">
              <Calculator class="w-4 h-4" />
            </button>
          </div>
        </button>

        <!-- Center Navigation -->
        <div class="flex items-center space-x-3">
          <button 
            @click="handlePrevious" 
            :disabled="!canGoPrevious"
            class="nav-btn"
            :class="{ 'opacity-50 cursor-not-allowed': !canGoPrevious }"
            title="Previous"
          >
            <ChevronLeft class="w-4 h-4" />
          </button>
          
          <div class="px-3 py-1 bg-gray-100 dark:bg-gray-800 rounded-full text-sm font-medium min-w-[80px] text-center">
            {{ currentQuestionIndex + 1 }} / {{ totalQuestions }}
          </div>
          
          <button 
            @click="handleNext" 
            :disabled="!canGoNext"
            class="nav-btn"
            :class="{ 'opacity-50 cursor-not-allowed': !canGoNext }"
            title="Next"
          >
            <ChevronRight class="w-4 h-4" />
          </button>
        </div>

        <!-- Right Menu Button -->
        <button 
          @click="showRightMenu = !showRightMenu" 
          class="tool-btn relative"
          title="Actions"
        >
          <MoreVertical class="w-5 h-5" />
          <div v-if="showRightMenu" class="absolute bottom-full right-0 mb-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 p-2 flex space-x-2">
            <button @click="openModal('notes')" class="tool-btn-small" title="Notes">
              <PenTool class="w-4 h-4" />
            </button>
            <button 
              @click="toggleBookmark" 
              class="tool-btn-small"
              :class="{ 'bg-orange-100 dark:bg-orange-900/30 text-orange-600': isBookmarked }"
              title="Bookmark"
            >
              <Bookmark class="w-4 h-4" :fill="isBookmarked ? 'currentColor' : 'none'" />
            </button>
            <button @click="openModal('questions')" class="tool-btn-small" title="Questions">
              <List class="w-4 h-4" />
            </button>
          </div>
        </button>
      </div>
    </div>

    <!-- Desktop Layout -->
    <div class="hidden lg:block">
      <div class="flex items-center justify-between px-6 py-3">
        <!-- Left Tools -->
        <div class="flex items-center space-x-2">
          <button @click="openModal('settings')" class="tool-btn" title="Settings">
            <Settings class="w-5 h-5" />
          </button>
          <button @click="openModal('filter')" class="tool-btn" title="Filter">
            <Filter class="w-5 h-5" />
          </button>
          <button @click="openModal('help')" class="tool-btn" title="Help">
            <HelpCircle class="w-5 h-5" />
          </button>
          <button @click="openModal('calculator')" class="tool-btn" title="Calculator">
            <Calculator class="w-5 h-5" />
          </button>
        </div>

        <!-- Center Navigation -->
        <div class="flex items-center space-x-4">
          <button 
            @click="handlePrevious" 
            :disabled="!canGoPrevious"
            class="nav-btn"
            :class="{ 'opacity-50 cursor-not-allowed': !canGoPrevious }"
            title="Previous Question"
          >
            <ChevronLeft class="w-5 h-5" />
            <span class="ml-2 text-sm font-medium">Previous</span>
          </button>
          
          <div class="px-4 py-2 bg-gradient-to-r from-blue-50 to-green-50 dark:from-blue-900/20 dark:to-green-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
            <div class="text-sm text-gray-600 dark:text-gray-400 text-center">Question</div>
            <div class="text-lg font-bold text-gray-900 dark:text-white text-center">
              {{ currentQuestionIndex + 1 }} / {{ totalQuestions }}
            </div>
          </div>
          
          <button 
            @click="handleNext" 
            :disabled="!canGoNext"
            class="nav-btn"
            :class="{ 'opacity-50 cursor-not-allowed': !canGoNext }"
            title="Next Question"
          >
            <span class="mr-2 text-sm font-medium">Next</span>
            <ChevronRight class="w-5 h-5" />
          </button>
        </div>

        <!-- Right Actions -->
        <div class="flex items-center space-x-2">
          <button @click="openModal('notes')" class="tool-btn" title="Notes">
            <PenTool class="w-5 h-5" />
          </button>
          <button 
            @click="toggleBookmark" 
            class="tool-btn"
            :class="{ 'bg-orange-100 dark:bg-orange-900/30 text-orange-600': isBookmarked }"
            title="Bookmark Question"
          >
            <Bookmark class="w-5 h-5" :fill="isBookmarked ? 'currentColor' : 'none'" />
          </button>
          <button @click="openModal('questions')" class="tool-btn" title="Question Navigator">
            <List class="w-5 h-5" />
          </button>
        </div>
      </div>
    </div>

    <!-- Modals -->
    <Teleport to="body">
      <!-- Settings Modal -->
      <div v-if="showSettings" class="modal-overlay" @click.self="closeAllModals">
        <div class="modal-content max-w-sm">
          <div class="modal-header">
            <h3 class="font-semibold flex items-center">
              <Settings class="w-5 h-5 mr-2" />
              Settings
            </h3>
            <button @click="closeAllModals" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
              <X class="w-5 h-5" />
            </button>
          </div>
          <div class="p-4 space-y-4">
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-2">
                <Moon class="w-4 h-4" />
                <span>Dark Mode</span>
              </div>
              <button @click="toggleTheme" class="toggle-switch" :class="{ active: isDark }">
                <div class="toggle-thumb" :class="{ active: isDark }"></div>
              </button>
            </div>
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-2">
                <Save class="w-4 h-4" />
                <span>Auto Save</span>
              </div>
              <button @click="autoSave = !autoSave" class="toggle-switch" :class="{ active: autoSave }">
                <div class="toggle-thumb" :class="{ active: autoSave }"></div>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Filter Modal -->
      <div v-if="showFilter" class="modal-overlay" @click.self="closeAllModals">
        <div class="modal-content max-w-sm">
          <div class="modal-header">
            <h3 class="font-semibold flex items-center">
              <Filter class="w-5 h-5 mr-2" />
              Filter Questions
            </h3>
            <button @click="closeAllModals" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
              <X class="w-5 h-5" />
            </button>
          </div>
          <div class="p-4 space-y-2">
            <button 
              v-for="filter in filters" 
              :key="filter.key"
              @click="setFilter(filter.key)"
              class="w-full flex items-center justify-between p-3 rounded-lg border transition-colors"
              :class="currentFilter === filter.key 
                ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300' 
                : 'border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700'"
            >
              <span>{{ filter.label }}</span>
              <span class="px-2 py-1 text-xs rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">{{ filter.count }}</span>
            </button>
          </div>
        </div>
      </div>

      <!-- Help Modal -->
      <div v-if="showHelp" class="modal-overlay" @click.self="closeAllModals">
        <div class="modal-content max-w-md">
          <div class="modal-header">
            <h3 class="font-semibold flex items-center">
              <HelpCircle class="w-5 h-5 mr-2" />
              Quick Help
            </h3>
            <button @click="closeAllModals" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
              <X class="w-5 h-5" />
            </button>
          </div>
          <div class="p-4 space-y-4 text-sm">
            <div class="flex items-start space-x-3">
              <Mouse class="w-5 h-5 text-blue-500 mt-0.5" />
              <div>
                <div class="font-medium">Mouse Controls</div>
                <div class="text-gray-600 dark:text-gray-400">Click to select answers</div>
              </div>
            </div>
            <div class="flex items-start space-x-3">
              <Keyboard class="w-5 h-5 text-green-500 mt-0.5" />
              <div>
                <div class="font-medium">Keyboard Shortcuts</div>
                <div class="text-gray-600 dark:text-gray-400">← → arrows to navigate, 1-4 for answers</div>
              </div>
            </div>
            <div class="flex items-start space-x-3">
              <Bookmark class="w-5 h-5 text-orange-500 mt-0.5" />
              <div>
                <div class="font-medium">Bookmarks</div>
                <div class="text-gray-600 dark:text-gray-400">Mark questions for later review</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Calculator Modal -->
      <div v-if="showCalculator" class="modal-overlay" @click.self="closeAllModals">
        <div class="modal-content max-w-xs">
          <div class="modal-header">
            <h3 class="font-semibold flex items-center">
              <Calculator class="w-5 h-5 mr-2" />
              Calculator
            </h3>
            <button @click="closeAllModals" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
              <X class="w-5 h-5" />
            </button>
          </div>
          <div class="p-4">
            <input 
              v-model="calcDisplay" 
              readonly 
              class="w-full p-3 text-right text-lg bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg font-mono mb-3" 
              placeholder="0" 
            />
            <div class="grid grid-cols-4 gap-2">
              <button @click="clearCalc" class="calc-btn bg-red-500 hover:bg-red-600 text-white">C</button>
              <button @click="deleteLast" class="calc-btn bg-orange-500 hover:bg-orange-600 text-white">
                <Delete class="w-4 h-4" />
              </button>
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
      <div v-if="showNotes" class="modal-overlay" @click.self="closeAllModals">
        <div class="modal-content max-w-sm">
          <div class="modal-header">
            <h3 class="font-semibold flex items-center">
              <PenTool class="w-5 h-5 mr-2" />
              Question Notes
            </h3>
            <button @click="closeAllModals" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
              <X class="w-5 h-5" />
            </button>
          </div>
          <div class="p-4">
            <textarea
              v-model="noteText"
              class="w-full h-24 p-3 border border-gray-300 dark:border-gray-600 rounded-lg resize-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700"
              placeholder="Add your notes for this question..."
              maxlength="300"
            ></textarea>
            <div class="flex justify-between items-center mt-3">
              <span class="text-xs text-gray-500">{{ noteText.length }}/300</span>
              <div class="space-x-2">
                <button @click="noteText = ''" class="px-3 py-1 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded text-sm">
                  Clear
                </button>
                <button @click="saveNote" class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                  Save
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Question Navigator -->
      <div v-if="showQuestions" class="modal-overlay" @click.self="closeAllModals">
        <div class="modal-content max-w-sm">
          <div class="modal-header">
            <h3 class="font-semibold flex items-center">
              <List class="w-5 h-5 mr-2" />
              Question Navigator
            </h3>
            <button @click="closeAllModals" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
              <X class="w-5 h-5" />
            </button>
          </div>
          <div class="p-4">
            <div class="grid grid-cols-6 gap-2 mb-4">
              <button
                v-for="i in totalQuestions"
                :key="i"
                @click="goToQuestion(i - 1)"
                class="w-8 h-8 rounded text-xs font-bold transition-all hover:scale-105 focus:scale-95"
                :class="getQuestionClass(i - 1)"
              >
                {{ i }}
              </button>
            </div>
            <div class="flex justify-center space-x-4 text-xs text-gray-600 dark:text-gray-400">
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
import {
  Settings,
  Filter,
  HelpCircle,
  Calculator,
  PenTool,
  Bookmark,
  List,
  ChevronLeft,
  ChevronRight,
  MoreHorizontal,
  MoreVertical,
  X,
  Moon,
  Save,
  Mouse,
  Keyboard,
  Delete
} from 'lucide-vue-next'

// State
const showSettings = ref(false)
const showFilter = ref(false)
const showHelp = ref(false)
const showCalculator = ref(false)
const showNotes = ref(false)
const showQuestions = ref(false)
const showLeftMenu = ref(false)
const showRightMenu = ref(false)

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
const handlePrevious = () => {
  if (canGoPrevious.value) {
    prevQuestion()
    closePopupMenus()
  }
}

const handleNext = () => {
  if (canGoNext.value) {
    nextQuestion()
    closePopupMenus()
  }
}

const closePopupMenus = () => {
  showLeftMenu.value = false
  showRightMenu.value = false
}

const openModal = (modalName: string) => {
  closeAllModals()
  closePopupMenus()
  
  switch (modalName) {
    case 'settings':
      showSettings.value = true
      break
    case 'filter':
      showFilter.value = true
      break
    case 'help':
      showHelp.value = true
      break
    case 'calculator':
      showCalculator.value = true
      break
    case 'notes':
      showNotes.value = true
      loadNote()
      break
    case 'questions':
      showQuestions.value = true
      break
  }
}

const closeAllModals = () => {
  showSettings.value = false
  showFilter.value = false
  showHelp.value = false
  showCalculator.value = false
  showNotes.value = false
  showQuestions.value = false
}

const toggleBookmark = () => {
  isBookmarked.value = !isBookmarked.value
  closePopupMenus()
}

const toggleTheme = () => {
  isDark.value = !isDark.value
  document.documentElement.classList.toggle('dark')
  localStorage.setItem('theme', isDark.value ? 'dark' : 'light')
}

const setFilter = (filter: string) => {
  currentFilter.value = filter
  closeAllModals()
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
  closeAllModals()
}

const loadNote = () => {
  const notes = JSON.parse(localStorage.getItem('quiz-notes') || '{}')
  noteText.value = notes[currentQuestionIndex.value] || ''
}

// Question navigation
const goToQuestion = (index: number) => {
  // Emit event to parent component to change question
  currentQuestionIndex.value = index
  closeAllModals()
}

const getQuestionClass = (index: number) => {
  if (index === currentQuestionIndex.value) 
    return 'bg-blue-500 text-white shadow-md'
  if ([1, 3, 5, 7, 9, 11, 13, 15, 17].includes(index)) 
    return 'bg-green-500 text-white shadow-sm'
  if ([2, 8, 14].includes(index)) 
    return 'bg-orange-500 text-white shadow-sm'
  return 'bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300'
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
    case 'B':
      toggleBookmark()
      break
    case 'Escape':
      closeAllModals()
      closePopupMenus()
      break
  }
}

// Click outside to close popup menus
const handleClickOutside = (e: Event) => {
  const target = e.target as HTMLElement
  if (!target.closest('.tool-btn')) {
    closePopupMenus()
  }
}

onMounted(() => {
  document.addEventListener('keydown', handleKeyboard)
  document.addEventListener('click', handleClickOutside)
  loadNote()
})

onUnmounted(() => {
  document.removeEventListener('keydown', handleKeyboard)
  document.removeEventListener('click', handleClickOutside)
})

watch(currentQuestionIndex, loadNote)
</script>

<style scoped>
.tool-btn {
  @apply w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-200 hover:scale-105 hover:bg-gray-100 dark:hover:bg-gray-800 active:scale-95 text-gray-600 dark:text-gray-400;
}

.tool-btn-small {
  @apply w-8 h-8 rounded-lg flex items-center justify-center transition-all duration-200 hover:scale-105 hover:bg-gray-100 dark:hover:bg-gray-700 active:scale-95 text-gray-600 dark:text-gray-400;
}

.nav-btn {
  @apply flex items-center px-4 py-2 rounded-lg transition-all duration-200 hover:scale-105 hover:bg-blue-50 dark:hover:bg-blue-900/20 active:scale-95 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400;
}

.modal-overlay {
  @apply fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm;
}

.modal-content {
  @apply bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full border border-gray-200 dark:border-gray-700;
}

.modal-header {
  @apply flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700;
}

.toggle-switch {
  @apply relative w-11 h-6 bg-gray-300 dark:bg-gray-600 rounded-full transition-colors duration-200 cursor-pointer;
}

.toggle-switch.active {
  @apply bg-blue-600;
}

.toggle-thumb {
  @apply absolute w-4 h-4 bg-white rounded-full top-1 left-1 transition-transform duration-200 shadow-sm;
}

.toggle-thumb.active {
  @apply transform translate-x-5;
}

.calc-btn {
  @apply p-3 rounded-lg font-semibold transition-all duration-200 hover:scale-105 active:scale-95 text-sm;
}

/* Animations */
@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.popup-menu {
  animation: slideUp 0.2s ease-out;
}

/* Focus styles for accessibility */
.tool-btn:focus,
.tool-btn-small:focus,
.nav-btn:focus {
  @apply outline-none ring-2 ring-blue-500 ring-offset-2 dark:ring-offset-gray-900;
}

/* Mobile responsive adjustments */
@media (max-width: 640px) {
  .modal-content {
    @apply max-h-[80vh] overflow-y-auto;
  }
}

/* Smooth transitions for theme switching */
* {
  transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
}

</style>