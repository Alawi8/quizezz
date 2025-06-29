<template>
  <nav class="sticky top-0 z-50 bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl border-b border-gray-200/50 dark:border-gray-700/50 transition-all duration-300 shadow-sm">
    <div class="container mx-auto px-4">
      <div class="flex items-center justify-between h-16">
        <!-- Logo Section -->
        <div class="flex items-center space-x-3">
          <div class="w-10 h-10 bg-gradient-to-br from-green-500 via-green-600 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg transform hover:scale-105 transition-transform duration-200">
            <span class="text-white font-bold text-lg">Q</span>
          </div>
          <span class="hidden sm:block text-xl font-bold bg-gradient-to-r from-green-600 via-green-700 to-emerald-700 bg-clip-text text-transparent">
            QuizApp
          </span>
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

          <!-- Theme Toggle -->
          <div class="relative group">
            <button 
              @click="toggleTheme"
              class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-300 transform hover:scale-110 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400"
              title="Toggle Theme"
            >
              <Settings class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" />
              
              <!-- Tooltip -->
              <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2 bg-gray-900 dark:bg-gray-700 text-white text-sm px-3 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-10 pointer-events-none">
                Settings
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

            <!-- Theme Toggle -->
            <button 
              @click="toggleTheme"
              class="flex items-center space-x-4 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 w-full"
            >
              <Settings class="w-6 h-6 flex-shrink-0" />
              <span class="font-medium">Settings</span>
            </button>
          </div>
        </div>
      </Transition>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { computed, ref, onMounted, onUnmounted } from 'vue'
import { useRoute, RouterLink } from 'vue-router'
import { BarChart2, FileText, FolderOpen, Settings, Maximize, Minimize, Menu, X } from 'lucide-vue-next'

const route = useRoute()
const isFullscreen = ref(false)
const mobileMenuOpen = ref(false)

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

const toggleTheme = () => {
  const isDark = document.documentElement.classList.contains('dark')
  if (isDark) {
    document.documentElement.classList.remove('dark')
    localStorage.setItem('theme', 'light')
  } else {
    document.documentElement.classList.add('dark')
    localStorage.setItem('theme', 'dark')
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