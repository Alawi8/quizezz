<template>
  <!-- Subscription Modal -->
  <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <!-- Backdrop -->
    <div 
      class="absolute inset-0 bg-black/50 backdrop-blur-sm" 
      @click="$emit('close')"
    ></div>
    
    <!-- Modal Content -->
    <div class="relative w-full max-w-6xl max-h-[90vh] overflow-y-auto">
      <div class="backdrop-blur-lg bg-white/95 rounded-3xl shadow-2xl border border-white/30 p-6 md:p-8">
        <!-- Header -->
        <div class="text-center mb-8 md:mb-12">
          <button 
            @click="$emit('close')"
            class="absolute top-4 right-4 p-2 rounded-full hover:bg-gray-100 transition-colors duration-200"
          >
            <component :is="XMarkIcon" class="w-6 h-6 text-gray-500" />
          </button>
          
          <div class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-100 to-purple-100 backdrop-blur-sm px-4 md:px-6 py-2 md:py-3 rounded-full border border-blue-200 shadow-lg mb-6">
            <component :is="CrownIcon" class="w-5 h-5 text-blue-600" />
            <span class="text-sm md:text-base text-blue-700 font-semibold">Choose Your Plan</span>
          </div>
          
          <h2 class="text-3xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-4">
            Subscription Plans
          </h2>
          
          <p class="text-base md:text-xl text-gray-600 max-w-3xl mx-auto">
            Unlock your learning potential with our flexible plans designed for every learner
          </p>
        </div>

        <!-- Plans Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
          <!-- Student Plan -->
          <div class="group relative backdrop-blur-sm bg-white/70 rounded-2xl md:rounded-3xl p-6 md:p-8 border border-white/40 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-green-200 to-emerald-300 rounded-full -translate-y-10 translate-x-10 opacity-50 group-hover:opacity-70 transition-opacity duration-300"></div>
            
            <div class="relative">
              <!-- Plan Icon -->
              <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                <component :is="AcademicCapIcon" class="w-8 h-8 text-white" />
              </div>

              <!-- Plan Details -->
              <div class="space-y-4 mb-8">
                <div>
                  <h3 class="text-2xl font-bold text-gray-800 mb-2">Student</h3>
                  <p class="text-gray-600">Perfect for individual learners</p>
                </div>
                
                <div class="flex items-baseline gap-1">
                  <span class="text-4xl font-bold text-green-600">30</span>
                  <span class="text-lg text-gray-500">SAR/month</span>
                </div>
              </div>

              <!-- Features -->
              <div class="space-y-4 mb-8">
                <div class="flex items-center gap-3">
                  <component :is="CheckIcon" class="w-5 h-5 text-green-500 flex-shrink-0" />
                  <span class="text-gray-700">Access to all quizzes</span>
                </div>
                <div class="flex items-center gap-3">
                  <component :is="CheckIcon" class="w-5 h-5 text-green-500 flex-shrink-0" />
                  <span class="text-gray-700">Basic analytics</span>
                </div>
                <div class="flex items-center gap-3">
                  <component :is="CheckIcon" class="w-5 h-5 text-green-500 flex-shrink-0" />
                  <span class="text-gray-700">Progress tracking</span>
                </div>
                <div class="flex items-center gap-3">
                  <component :is="CheckIcon" class="w-5 h-5 text-green-500 flex-shrink-0" />
                  <span class="text-gray-700">Mobile app access</span>
                </div>
                <div class="flex items-center gap-3">
                  <component :is="XMarkIcon" class="w-5 h-5 text-gray-300 flex-shrink-0" />
                  <span class="text-gray-400">Create custom quizzes</span>
                </div>
                <div class="flex items-center gap-3">
                  <component :is="XMarkIcon" class="w-5 h-5 text-gray-300 flex-shrink-0" />
                  <span class="text-gray-400">Advanced reports</span>
                </div>
              </div>

              <!-- Subscribe Button -->
              <button 
                @click="subscribe('student')"
                class="w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
              >
                <div class="flex items-center justify-center gap-2">
                  <span>Get Started</span>
                  <component :is="ArrowRightIcon" class="w-4 h-4" />
                </div>
              </button>
            </div>
          </div>

          <!-- Teacher Plan - Popular -->
          <div class="group relative backdrop-blur-sm bg-white/70 rounded-2xl md:rounded-3xl p-6 md:p-8 border-2 border-blue-400 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 scale-105">
            <!-- Popular Badge -->
            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
              <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg">
                Most Popular
              </div>
            </div>
            
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-200 to-purple-300 rounded-full -translate-y-12 translate-x-12 opacity-50 group-hover:opacity-70 transition-opacity duration-300"></div>
            
            <div class="relative">
              <!-- Plan Icon -->
              <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                <component :is="UserIcon" class="w-8 h-8 text-white" />
              </div>

              <!-- Plan Details -->
              <div class="space-y-4 mb-8">
                <div>
                  <h3 class="text-2xl font-bold text-gray-800 mb-2">Teacher</h3>
                  <p class="text-gray-600">Ideal for educators and trainers</p>
                </div>
                
                <div class="flex items-baseline gap-1">
                  <span class="text-4xl font-bold text-blue-600">75</span>
                  <span class="text-lg text-gray-500">SAR/month</span>
                </div>
              </div>

              <!-- Features -->
              <div class="space-y-4 mb-8">
                <div class="flex items-center gap-3">
                  <component :is="CheckIcon" class="w-5 h-5 text-green-500 flex-shrink-0" />
                  <span class="text-gray-700">Everything in Student</span>
                </div>
                <div class="flex items-center gap-3">
                  <component :is="CheckIcon" class="w-5 h-5 text-green-500 flex-shrink-0" />
                  <span class="text-gray-700">Create unlimited quizzes</span>
                </div>
                <div class="flex items-center gap-3">
                  <component :is="CheckIcon" class="w-5 h-5 text-green-500 flex-shrink-0" />
                  <span class="text-gray-700">Student management</span>
                </div>
                <div class="flex items-center gap-3">
                  <component :is="CheckIcon" class="w-5 h-5 text-green-500 flex-shrink-0" />
                  <span class="text-gray-700">Advanced analytics</span>
                </div>
                <div class="flex items-center gap-3">
                  <component :is="CheckIcon" class="w-5 h-5 text-green-500 flex-shrink-0" />
                  <span class="text-gray-700">Class performance reports</span>
                </div>
                <div class="flex items-center gap-3">
                  <component :is="XMarkIcon" class="w-5 h-5 text-gray-300 flex-shrink-0" />
                  <span class="text-gray-400">Multi-school management</span>
                </div>
              </div>

              <!-- Subscribe Button -->
              <button 
                @click="subscribe('teacher')"
                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
              >
                <div class="flex items-center justify-center gap-2">
                  <span>Choose Plan</span>
                  <component :is="ArrowRightIcon" class="w-4 h-4" />
                </div>
              </button>
            </div>
          </div>

          <!-- Admin Plan -->
          <div class="group relative backdrop-blur-sm bg-white/70 rounded-2xl md:rounded-3xl p-6 md:p-8 border border-white/40 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-purple-200 to-pink-300 rounded-full -translate-y-10 translate-x-10 opacity-50 group-hover:opacity-70 transition-opacity duration-300"></div>
            
            <div class="relative">
              <!-- Plan Icon -->
              <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                <component :is="CogIcon" class="w-8 h-8 text-white" />
              </div>

              <!-- Plan Details -->
              <div class="space-y-4 mb-8">
                <div>
                  <h3 class="text-2xl font-bold text-gray-800 mb-2">Admin</h3>
                  <p class="text-gray-600">Complete solution for institutions</p>
                </div>
                
                <div class="flex items-baseline gap-1">
                  <span class="text-4xl font-bold text-purple-600">120</span>
                  <span class="text-lg text-gray-500">SAR/month</span>
                </div>
              </div>

              <!-- Features -->
              <div class="space-y-4 mb-8">
                <div class="flex items-center gap-3">
                  <component :is="CheckIcon" class="w-5 h-5 text-green-500 flex-shrink-0" />
                  <span class="text-gray-700">Everything in Teacher</span>
                </div>
                <div class="flex items-center gap-3">
                  <component :is="CheckIcon" class="w-5 h-5 text-green-500 flex-shrink-0" />
                  <span class="text-gray-700">Multi-school management</span>
                </div>
                <div class="flex items-center gap-3">
                  <component :is="CheckIcon" class="w-5 h-5 text-green-500 flex-shrink-0" />
                  <span class="text-gray-700">User role management</span>
                </div>
                <div class="flex items-center gap-3">
                  <component :is="CheckIcon" class="w-5 h-5 text-green-500 flex-shrink-0" />
                  <span class="text-gray-700">Custom branding</span>
                </div>
                <div class="flex items-center gap-3">
                  <component :is="CheckIcon" class="w-5 h-5 text-green-500 flex-shrink-0" />
                  <span class="text-gray-700">API access</span>
                </div>
                <div class="flex items-center gap-3">
                  <component :is="CheckIcon" class="w-5 h-5 text-green-500 flex-shrink-0" />
                  <span class="text-gray-700">Priority support</span>
                </div>
              </div>

              <!-- Subscribe Button -->
              <button 
                @click="subscribe('admin')"
                class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
              >
                <div class="flex items-center justify-center gap-2">
                  <span>Get Enterprise</span>
                  <component :is="ArrowRightIcon" class="w-4 h-4" />
                </div>
              </button>
            </div>
          </div>
        </div>

        <!-- Bottom Section -->
        <div class="mt-12 text-center">
          <div class="backdrop-blur-sm bg-gradient-to-r from-gray-50 to-blue-50 rounded-2xl p-6 md:p-8 border border-white/30">
            <h3 class="text-xl font-bold text-gray-800 mb-4">All Plans Include:</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm text-gray-600">
              <div class="flex items-center gap-2">
                <component :is="ShieldCheckIcon" class="w-4 h-4 text-green-500" />
                <span>SSL Security</span>
              </div>
              <div class="flex items-center gap-2">
                <component :is="CloudIcon" class="w-4 h-4 text-green-500" />
                <span>Cloud Backup</span>
              </div>
              <div class="flex items-center gap-2">
                <component :is="HeartIcon" class="w-4 h-4 text-green-500" />
                <span>24/7 Support</span>
              </div>
              <div class="flex items-center gap-2">
                <component :is="GlobeIcon" class="w-4 h-4 text-green-500" />
                <span>Global Access</span>
              </div>
            </div>
          </div>
          
          <p class="text-sm text-gray-500 mt-6">
            All prices are in Saudi Riyal (SAR). You can cancel or upgrade your subscription at any time.
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineEmits } from 'vue'

// Define emits
const emit = defineEmits(['close'])

// Icons
const XMarkIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
  </svg>`
}

const CrownIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236l2.25 14.794m0 0a7.5 7.5 0 01-5.026-5.721M2.25 4.5l14.794 2.25a7.5 7.5 0 005.721 5.026c2.054.343 4.157.694 6.311 1.073" />
  </svg>`
}

const AcademicCapIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
  </svg>`
}

const UserIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
  </svg>`
}

const CogIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
  </svg>`
}

const CheckIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
  </svg>`
}

const ArrowRightIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
  </svg>`
}

const ShieldCheckIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
  </svg>`
}

const CloudIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 004.5 4.5H18a3.75 3.75 0 001.332-7.257 3 3 0 00-3.758-3.848 5.25 5.25 0 00-10.233 2.33A4.502 4.502 0 002.25 15z" />
  </svg>`
}

const HeartIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
  </svg>`
}

const GlobeIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
  </svg>`
}

// Methods
function subscribe(plan) {
  // Handle subscription logic here
  console.log(`Subscribing to ${plan} plan`)
  
  // You can add API call here
  // Example: 
  // await axios.post('/api/subscribe', { plan })
  
  // Close modal after successful subscription
  emit('close')
  
  // Show success message or redirect
  alert(`Successfully subscribed to ${plan} plan!`)
}
</script>

<style scoped>
/* Custom animations */
@keyframes fadeIn {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}

@keyframes slideUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-fadeIn {
  animation: fadeIn 0.3s ease-out;
}

.animate-slideUp {
  animation: slideUp 0.4s ease-out;
}

/* Backdrop blur support */
.backdrop-blur-sm {
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(4px);
}

.backdrop-blur-lg {
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
}

/* Gradient text */
.bg-clip-text {
  background-clip: text;
  -webkit-background-clip: text;
}

.text-transparent {
  color: transparent;
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.1);
  border-radius: 4px;
}

::-webkit-scrollbar-thumb {
  background: rgba(59, 130, 246, 0.3);
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: rgba(59, 130, 246, 0.5);
}
</style>