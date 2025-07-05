<template>
  <nav class="sticky top-0 z-50 bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl border-b border-gray-200/50 dark:border-gray-700/50 transition-all duration-300 shadow-sm">
    <div class="container mx-auto px-4">
      <div class="flex items-center justify-between h-16">
        <!-- Logo Section -->
        <div class="flex items-center space-x-3">
          <div class="w-10 h-10 bg-gradient-to-br from-green-500 via-green-600 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg transform hover:scale-105 transition-transform duration-200">
            <a href="/" class="text-white font-bold text-lg">Q</a>
          </div>
          <a href="/" class="hidden sm:block text-xl font-bold bg-gradient-to-r from-green-600 via-green-700 to-emerald-700 bg-clip-text text-transparent">
            QuizApp
          </a>
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center space-x-2">
          <template v-if="testId">
            <!-- Questions -->
            <div class="relative group">
              <RouterLink
                :to="{ name: 'quiz', params: { test_id: testId } }"
                class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-300 transform hover:scale-110 relative"
                :class="[
                  isActiveRoute('quiz') 
                    ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg shadow-green-500/25' 
                    : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400'
                ]"
              >
                <FileText class="w-5 h-5" />
                
                <!-- Tooltip -->
                <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2 bg-gray-900 dark:bg-gray-700 text-white text-sm px-3 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-10 pointer-events-none">
                  Questions
                  <div class="absolute -top-1 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-900 dark:bg-gray-700 rotate-45"></div>
                </div>
              </RouterLink>
            </div>
            
            <!-- Results -->
            <div class="relative group">
              <RouterLink
                :to="{ name: 'Result', params: { test_id: testId } }"
                class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-300 transform hover:scale-110 relative"
                :class="[
                  isActiveRoute('Result') 
                    ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg shadow-blue-500/25' 
                    : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400'
                ]"
              >
                <BarChart2 class="w-5 h-5" />
                
                <!-- Tooltip -->
                <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2 bg-gray-900 dark:bg-gray-700 text-white text-sm px-3 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-10 pointer-events-none">
                  Results
                  <div class="absolute -top-1 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-900 dark:bg-gray-700 rotate-45"></div>
                </div>
              </RouterLink>
            </div>
            
            <!-- Review -->
            <div class="relative group">
              <RouterLink
                :to="{ name: 'Review', params: { test_id: testId } }"
                class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-300 transform hover:scale-110 relative"
                :class="[
                  isActiveRoute('Review') 
                    ? 'bg-gradient-to-r from-purple-500 to-violet-500 text-white shadow-lg shadow-purple-500/25' 
                    : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-400 hover:text-purple-600 dark:hover:text-purple-400'
                ]"
              >
                <FolderOpen class="w-5 h-5" />
                
                <!-- Tooltip -->
                <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2 bg-gray-900 dark:bg-gray-700 text-white text-sm px-3 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-10 pointer-events-none">
                  Review
                  <div class="absolute -top-1 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-900 dark:bg-gray-700 rotate-45"></div>
                </div>
              </RouterLink>
            </div>
          </template>

          <template v-else>
            <!-- Disabled States -->
            <div class="flex items-center justify-center w-12 h-12 rounded-xl text-gray-300 dark:text-gray-700 cursor-not-allowed">
              <FileText class="w-5 h-5" />
            </div>
            <div class="flex items-center justify-center w-12 h-12 rounded-xl text-gray-300 dark:text-gray-700 cursor-not-allowed">
              <BarChart2 class="w-5 h-5" />
            </div>
            <div class="flex items-center justify-center w-12 h-12 rounded-xl text-gray-300 dark:text-gray-700 cursor-not-allowed">
              <FolderOpen class="w-5 h-5" />
            </div>
          </template>

          <!-- Divider -->
          <div class="w-px h-8 bg-gray-200 dark:bg-gray-700 mx-2"></div>

          <!-- Fullscreen Button -->
          <div class="relative group">
            <button 
              @click="toggleFullscreen"
              class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-300 transform hover:scale-110 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-400 hover:text-orange-600 dark:hover:text-orange-400"
              :title="isFullscreen ? 'Exit Fullscreen (ESC)' : 'Enter Fullscreen (F11)'"
            >
              <Maximize v-if="!isFullscreen" class="w-5 h-5" />
              <Minimize v-else class="w-5 h-5" />
              
              <!-- Tooltip -->
              <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2 bg-gray-900 dark:bg-gray-700 text-white text-sm px-3 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-10 pointer-events-none">
                {{ isFullscreen ? 'Exit Fullscreen' : 'Fullscreen' }}
                <div class="absolute -top-1 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-900 dark:bg-gray-700 rotate-45"></div>
              </div>
            </button>
          </div>

          <!-- Reset Test Button -->
          <div class="relative group">
            <button 
              @click="resetTest"
              :disabled="!testId || isResetLoading"
              class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-300 transform hover:scale-110 relative"
              :class="[
                testId && !isResetLoading
                  ? 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400'
                  : 'text-gray-300 dark:text-gray-700 cursor-not-allowed'
              ]"
              :title="testId ? 'Reset Test' : 'No test selected'"
            >
              <RotateCcw v-if="!isResetLoading" class="w-5 h-5" />
              <Loader2 v-else class="w-5 h-5 animate-spin" />
              
              <!-- Tooltip -->
              <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2 bg-gray-900 dark:bg-gray-700 text-white text-sm px-3 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-10 pointer-events-none">
                {{ isResetLoading ? 'Resetting...' : 'Reset Test' }}
                <div class="absolute -top-1 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-900 dark:bg-gray-700 rotate-45"></div>
              </div>
            </button>
          </div>
        </div>

        <!-- Mobile Menu Button -->
        <div class="md:hidden">
          <button 
            @click="toggleMobileMenu"
            class="flex items-center justify-center w-10 h-10 rounded-lg transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-400"
          >
            <Menu v-if="!mobileMenuOpen" class="w-6 h-6" />
            <X v-else class="w-6 h-6" />
          </button>
        </div>
      </div>

      <!-- Mobile Menu -->
      <Transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="transform -translate-y-4 opacity-0"
        enter-to-class="transform translate-y-0 opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="transform translate-y-0 opacity-100"
        leave-to-class="transform -translate-y-4 opacity-0"
      >
        <div v-if="mobileMenuOpen" class="md:hidden border-t border-gray-200 dark:border-gray-700 bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl">
          <div class="px-4 py-6 space-y-3">
            <template v-if="testId">
              <!-- Questions -->
              <RouterLink
                :to="{ name: 'quiz', params: { test_id: testId } }"
                @click="closeMobileMenu"
                class="flex items-center space-x-4 px-4 py-3 rounded-xl transition-all duration-200"
                :class="[
                  isActiveRoute('quiz') 
                    ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' 
                    : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300'
                ]"
              >
                <FileText class="w-6 h-6 flex-shrink-0" />
                <span class="font-medium">Questions</span>
              </RouterLink>
              
              <!-- Results -->
              <RouterLink
                :to="{ name: 'Result', params: { test_id: testId } }"
                @click="closeMobileMenu"
                class="flex items-center space-x-4 px-4 py-3 rounded-xl transition-all duration-200"
                :class="[
                  isActiveRoute('Result') 
                    ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' 
                    : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300'
                ]"
              >
                <BarChart2 class="w-6 h-6 flex-shrink-0" />
                <span class="font-medium">Results</span>
              </RouterLink>
              
              <!-- Review -->
              <RouterLink
                :to="{ name: 'Review', params: { test_id: testId } }"
                @click="closeMobileMenu"
                class="flex items-center space-x-4 px-4 py-3 rounded-xl transition-all duration-200"
                :class="[
                  isActiveRoute('Review') 
                    ? 'bg-gradient-to-r from-purple-500 to-violet-500 text-white shadow-lg' 
                    : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300'
                ]"
              >
                <FolderOpen class="w-6 h-6 flex-shrink-0" />
                <span class="font-medium">Review</span>
              </RouterLink>
            </template>

            <!-- Divider -->
            <div class="border-t border-gray-200 dark:border-gray-700 my-4"></div>

            <!-- Fullscreen -->
            <button 
              @click="toggleFullscreen"
              class="flex items-center space-x-4 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 w-full"
            >
              <Maximize v-if="!isFullscreen" class="w-6 h-6 flex-shrink-0" />
              <Minimize v-else class="w-6 h-6 flex-shrink-0" />
              <span class="font-medium">{{ isFullscreen ? 'Exit Fullscreen' : 'Fullscreen' }}</span>
            </button>

            <!-- Reset Test -->
            <button 
              @click="resetTest"
              :disabled="!testId || isResetLoading"
              class="flex items-center space-x-4 px-4 py-3 rounded-xl transition-all duration-200 w-full"
              :class="[
                testId && !isResetLoading
                  ? 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300'
                  : 'text-gray-400 dark:text-gray-600 cursor-not-allowed'
              ]"
            >
              <RotateCcw v-if="!isResetLoading" class="w-6 h-6 flex-shrink-0" />
              <Loader2 v-else class="w-6 h-6 flex-shrink-0 animate-spin" />
              <span class="font-medium">{{ isResetLoading ? 'Resetting...' : 'Reset Test' }}</span>
            </button>
          </div>
        </div>
      </Transition>
    </div>

    <!-- Success Toast -->
    <Transition
      enter-active-class="transition duration-300 ease-out"
      enter-from-class="transform translate-y-2 opacity-0"
      enter-to-class="transform translate-y-0 opacity-100"
      leave-active-class="transition duration-200 ease-in"
      leave-from-class="transform translate-y-0 opacity-100"
      leave-to-class="transform translate-y-2 opacity-0"
    >
      <div
        v-if="showSuccessToast"
        class="fixed top-20 right-4 z-50 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 shadow-lg max-w-sm"
      >
        <div class="flex items-center space-x-3">
          <div class="flex-shrink-0">
            <CheckCircle class="w-5 h-5 text-green-600 dark:text-green-400" />
          </div>
          <div class="text-sm font-medium text-green-800 dark:text-green-200">
            Test reset successfully!
          </div>
        </div>
      </div>
    </Transition>

    <!-- Error Toast -->
    <Transition
      enter-active-class="transition duration-300 ease-out"
      enter-from-class="transform translate-y-2 opacity-0"
      enter-to-class="transform translate-y-0 opacity-100"
      leave-active-class="transition duration-200 ease-in"
      leave-from-class="transform translate-y-0 opacity-100"
      leave-to-class="transform translate-y-2 opacity-0"
    >
      <div
        v-if="showErrorToast"
        class="fixed top-20 right-4 z-50 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 shadow-lg max-w-sm"
      >
        <div class="flex items-center space-x-3">
          <div class="flex-shrink-0">
            <AlertCircle class="w-5 h-5 text-red-600 dark:text-red-400" />
          </div>
          <div>
            <div class="text-sm font-medium text-red-800 dark:text-red-200">
              Reset Failed
            </div>
            <div class="text-xs text-red-600 dark:text-red-400 mt-1">
              {{ errorMessage }}
            </div>
          </div>
        </div>
      </div>
    </Transition>
  </nav>
</template>

<script setup lang="ts">
import { computed, ref, onMounted, onUnmounted } from 'vue'
import { useRoute, RouterLink, useRouter } from 'vue-router'
import { 
  BarChart2, 
  FileText, 
  FolderOpen, 
  RotateCcw, 
  Loader2, 
  Maximize, 
  Minimize, 
  Menu, 
  X,
  CheckCircle,
  AlertCircle
} from 'lucide-vue-next'
import axios from 'axios'
import useUserAuth from '@/composable/userAuth.js'

const route = useRoute()
const router = useRouter()
const { token } = useUserAuth()

const isFullscreen = ref(false)
const mobileMenuOpen = ref(false)
const isResetLoading = ref(false)
const showSuccessToast = ref(false)
const showErrorToast = ref(false)
const errorMessage = ref('')

const testId = computed(() => route.params.test_id as string | undefined)

const isActiveRoute = (routeName: string) => {
  return route.name === routeName
}

const toggleMobileMenu = () => {
  mobileMenuOpen.value = !mobileMenuOpen.value
}

const closeMobileMenu = () => {
  mobileMenuOpen.value = false
}

const showToast = (type: 'success' | 'error', message?: string) => {
  if (type === 'success') {
    showSuccessToast.value = true
    setTimeout(() => {
      showSuccessToast.value = false
    }, 3000)
  } else {
    errorMessage.value = message || 'An unexpected error occurred'
    showErrorToast.value = true
    setTimeout(() => {
      showErrorToast.value = false
    }, 5000)
  }
}

// Enhanced Reset Test Function
const resetTest = async () => {
  if (!testId.value || isResetLoading.value) return
  
  // Show confirmation dialog with more details
  const confirmed = window.confirm(
    '⚠️ Reset Test Confirmation\n\n' +
    'This action will:\n' +
    '• Delete all your current answers\n' +
    '• Reset your progress to zero\n' +
    '• Clear any bookmarks\n' +
    '• Remove saved notes\n\n' +
    'This action cannot be undone. Are you sure you want to continue?'
  )
  
  if (!confirmed) return
  
  try {
    isResetLoading.value = true
    
    // API call to clear user answers
    const response = await axios.post(
      '/api/student/clear-answers',
      { test_id: testId.value },
      {
        headers: {
          'Authorization': `Bearer ${token.value}`,
          'Content-Type': 'application/json'
        },
        timeout: 10000 // 10 second timeout
      }
    )
    
    if (response.status === 200) {
      // Clear local storage data
      try {
        localStorage.removeItem(`bookmarks_${testId.value}`)
        localStorage.removeItem(`quiz-notes`)
        localStorage.removeItem('userAnswers')
        localStorage.removeItem('testId')
        localStorage.removeItem(`quiz-progress-${testId.value}`)
        localStorage.removeItem(`quiz-time-${testId.value}`)
      } catch (localStorageError) {
        console.warn('Could not clear localStorage:', localStorageError)
      }
      
      // Show success message
      showToast('success')
      
      // Close mobile menu if open
      closeMobileMenu()
      
      // Wait for success message to show, then redirect
      setTimeout(async () => {
        try {
          // Force page reload to ensure clean state
          if (route.name === 'quiz') {
            window.location.reload()
          } else {
            await router.push({ name: 'quiz', params: { test_id: testId.value } })
            // Small delay then reload to ensure clean state
            setTimeout(() => {
              window.location.reload()
            }, 100)
          }
        } catch (routingError) {
          console.error('Routing error after reset:', routingError)
          // Fallback: just reload the page
          window.location.reload()
        }
      }, 1500)
      
    } else {
      throw new Error(`Server responded with status: ${response.status}`)
    }
    
  } catch (error: any) {
    console.error('Error resetting test:', error)
    
    let errorMsg = 'Please try again later.'
    
    if (error.response) {
      // Server responded with error status
      const status = error.response.status
      if (status === 401) {
        errorMsg = 'Authentication expired. Please log in again.'
      } else if (status === 403) {
        errorMsg = 'You do not have permission to reset this test.'
      } else if (status === 404) {
        errorMsg = 'Test not found or no longer available.'
      } else if (status === 429) {
        errorMsg = 'Too many requests. Please wait a moment.'
      } else if (status >= 500) {
        errorMsg = 'Server error. Please try again later.'
      } else {
        errorMsg = error.response.data?.message || `Server error (${status})`
      }
    } else if (error.request) {
      // Network error
      errorMsg = 'Network error. Check your connection.'
    } else if (error.code === 'ECONNABORTED') {
      // Timeout
      errorMsg = 'Request timeout. Please try again.'
    }
    
    showToast('error', errorMsg)
    
  } finally {
    isResetLoading.value = false
  }
}

// Fullscreen Functions
function isFullscreenSupported() {
  return !!(
    document.fullscreenEnabled ||
    (document as any).webkitFullscreenEnabled ||
    (document as any).mozFullScreenEnabled ||
    (document as any).msFullscreenEnabled
  )
}

function getFullscreenElement() {
  return (
    document.fullscreenElement ||
    (document as any).webkitFullscreenElement ||
    (document as any).mozFullScreenElement ||
    (document as any).msFullscreenElement
  )
}

function requestFullscreen(element: HTMLElement) {
  if (element.requestFullscreen) {
    return element.requestFullscreen()
  } else if ((element as any).webkitRequestFullscreen) {
    return (element as any).webkitRequestFullscreen()
  } else if ((element as any).mozRequestFullScreen) {
    return (element as any).mozRequestFullScreen()
  } else if ((element as any).msRequestFullscreen) {
    return (element as any).msRequestFullscreen()
  }
  return Promise.reject(new Error('Fullscreen not supported'))
}

function exitFullscreenMode() {
  if (document.exitFullscreen) {
    return document.exitFullscreen()
  } else if ((document as any).webkitExitFullscreen) {
    return (document as any).webkitExitFullscreen()
  } else if ((document as any).mozCancelFullScreen) {
    return (document as any).mozCancelFullScreen()
  } else if ((document as any).msExitFullscreen) {
    return (document as any).msExitFullscreen()
  }
  return Promise.reject(new Error('Exit fullscreen not supported'))
}

function enterFullscreen() {
  if (!isFullscreenSupported()) {
    console.warn('Fullscreen is not supported in this browser')
    return
  }

  if (!getFullscreenElement()) {
    requestFullscreen(document.documentElement)
      .then(() => {
        isFullscreen.value = true
        console.log('Entered fullscreen mode')
      })
      .catch((err) => {
        console.warn('Could not enter fullscreen mode:', err)
      })
  }
}

function exitFullscreen() {
  if (getFullscreenElement()) {
    exitFullscreenMode()
      .then(() => {
        isFullscreen.value = false
        console.log('Exited fullscreen mode')
      })
      .catch((err) => {
        console.warn('Could not exit fullscreen mode:', err)
      })
  }
}

function toggleFullscreen() {
  if (isFullscreen.value) {
    exitFullscreen()
  } else {
    enterFullscreen()
  }
  // Close mobile menu if open
  closeMobileMenu()
}

// Listen for fullscreen changes (e.g., user presses ESC)
function handleFullscreenChange() {
  isFullscreen.value = !!getFullscreenElement()
}

// Keyboard shortcut for F11
function handleKeydown(event: KeyboardEvent) {
  if (event.key === 'F11') {
    event.preventDefault()
    toggleFullscreen()
  }
  // Close mobile menu on ESC
  if (event.key === 'Escape' && mobileMenuOpen.value) {
    closeMobileMenu()
  }
}

onMounted(() => {
  // Add event listeners for different browsers
  document.addEventListener('fullscreenchange', handleFullscreenChange)
  document.addEventListener('webkitfullscreenchange', handleFullscreenChange)
  document.addEventListener('mozfullscreenchange', handleFullscreenChange)
  document.addEventListener('MSFullscreenChange', handleFullscreenChange)
  document.addEventListener('keydown', handleKeydown)
})

onUnmounted(() => {
  // Remove event listeners for different browsers
  document.removeEventListener('fullscreenchange', handleFullscreenChange)
  document.removeEventListener('webkitfullscreenchange', handleFullscreenChange)
  document.removeEventListener('mozfullscreenchange', handleFullscreenChange)
  document.removeEventListener('MSFullscreenChange', handleFullscreenChange)
  document.removeEventListener('keydown', handleKeydown)
})
</script>