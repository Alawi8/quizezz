<template>
  <div id="app" class="min-h-screen bg-gradient-to-br from-gray-50 to-green-50 dark:from-gray-900 dark:to-black transition-colors duration-300">
    <Navbar />
    <main >
      <Transition name="fade" mode="out-in">
        <router-view />
      </Transition>
    </main>
  </div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue'
import Navbar from './layouts/Navbar.vue'

onMounted(() => {
  // Initialize theme from localStorage
  const savedTheme = localStorage.getItem('theme')
  if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark')
  }
})
</script>

<style>
/* CSS Custom Properties */
:root {
  --primary: #16a34a;
  --primary-hover: #15803d;
  --secondary: #f0fdf4;
  --text-primary: #1f2937;
  --text-secondary: #6b7280;
  --border: #e5e7eb;
  --background: #ffffff;
  --surface: #f9fafb;
}

.dark {
  --primary: #22c55e;
  --primary-hover: #16a34a;
  --secondary: #1f2937;
  --text-primary: #f9fafb;
  --text-secondary: #d1d5db;
  --border: #374151;
  --background: #111827;
  --surface: #1f2937;
}

/* Global Styles */
* {
  box-sizing: border-box;
}

body {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  line-height: 1.6;
  color: var(--text-primary);
  background-color: var(--background);
}

/* Transitions */
.fade-enter-active,
.fade-leave-active {
  transition: all 0.3s ease;
}

.fade-enter-from {
  opacity: 0;
  transform: translateY(10px);
}

.fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}

/* Utility Classes */
.btn-primary {
  @apply bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 px-6 rounded-lg transition-all duration-200 transform hover:scale-105 active:scale-95;
}

.btn-secondary {
  @apply bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium py-2.5 px-6 rounded-lg transition-all duration-200;
}

.card {
  @apply bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 transition-all duration-200;
}

/* Scrollbar Styling */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: var(--surface);
}

::-webkit-scrollbar-thumb {
  background: var(--border);
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: var(--text-secondary);
}
</style>