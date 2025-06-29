<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-30">
      <div class="absolute top-0 left-0 w-96 h-96 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
      <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-r from-yellow-400 to-pink-500 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
      <div class="absolute -bottom-8 left-20 w-96 h-96 bg-gradient-to-r from-green-400 to-blue-500 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative">
      <!-- Hero/CTA Section -->
      <section class="relative min-h-screen flex items-center justify-center px-2 md:px-6 py-8 md:py-20">
        <div class="w-full max-w-7xl mx-auto text-center">
          <!-- Loading State -->
          <div v-if="loadingUser" class="backdrop-blur-sm bg-white bg-opacity-30 rounded-3xl p-6 md:p-12 border border-white border-opacity-20 shadow-2xl">
            <div class="flex items-center justify-center gap-4 mb-6">
              <div class="w-8 md:w-12 h-8 md:h-12 border-4 border-green-500 border-t-transparent rounded-full animate-spin"></div>
              <p class="text-lg md:text-2xl font-semibold text-gray-700">Initializing QuizzApp...</p>
            </div>
            <div class="flex justify-center gap-2">
              <div class="w-2 md:w-3 h-2 md:h-3 bg-green-400 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
              <div class="w-2 md:w-3 h-2 md:h-3 bg-green-500 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
              <div class="w-2 md:w-3 h-2 md:h-3 bg-green-600 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
            </div>
          </div>

          <!-- Main Hero Content -->
          <div v-if="!loadingUser" class="space-y-6 md:space-y-8">
            <!-- Hero Title -->
            <div class="space-y-4 md:space-y-6">
              <div class="inline-flex items-center gap-2 bg-gradient-to-r from-green-100 to-emerald-100 backdrop-blur-sm px-4 md:px-6 py-2 md:py-3 rounded-full border border-green-200 shadow-lg">
                <component :is="StarIcon" class="w-4 md:w-5 h-4 md:h-5 text-yellow-500 animate-pulse" />
                <span class="text-sm md:text-base text-green-700 font-semibold">Transform Your Learning Journey</span>
                <component :is="StarIcon" class="w-4 md:w-5 h-4 md:h-5 text-yellow-500 animate-pulse" />
              </div>
              
              <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold leading-tight">
                <span class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 bg-clip-text text-transparent">
                  Master Skills with
                </span>
                <br>
                <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                  Interactive Quizzes
                </span>
              </h1>
              
              <p class="text-base md:text-xl lg:text-2xl text-gray-600 max-w-4xl mx-auto leading-relaxed">
                Unlock your potential with our cutting-edge quiz platform. 
                <span class="font-semibold text-green-600">Engage, Learn, Excel</span> - all in one place.
              </p>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col gap-4 md:gap-6 mt-8 md:mt-12">
              <button 
                v-if="canViewQuizzes"
                @click="scrollToQuizzes"
                class="group relative overflow-hidden w-full md:w-auto md:mx-auto px-6 md:px-8 py-3 md:py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white text-base md:text-lg font-bold rounded-2xl shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-105"
              >
                <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-green-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative flex items-center justify-center gap-3">
                  <component :is="RocketIcon" class="w-5 md:w-6 h-5 md:h-6 group-hover:animate-bounce" />
                  <span>Start Learning Now</span>
                  <component :is="ArrowRightIcon" class="w-4 md:w-5 h-4 md:h-5 transform group-hover:translate-x-1 transition-transform duration-300" />
                </div>
              </button>

              <button 
                v-else
                @click="navigateToRegister"
                class="group relative overflow-hidden w-full md:w-auto md:mx-auto px-6 md:px-8 py-3 md:py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-base md:text-lg font-bold rounded-2xl shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-105"
              >
                <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative flex items-center justify-center gap-3">
                  <component :is="UserPlusIcon" class="w-5 md:w-6 h-5 md:h-6 group-hover:animate-bounce" />
                  <span>Join QuizzApp</span>
                  <component :is="ArrowRightIcon" class="w-4 md:w-5 h-4 md:h-5 transform group-hover:translate-x-1 transition-transform duration-300" />
                </div>
              </button>

              <button 
                @click="scrollToFeatures"
                class="group flex items-center justify-center gap-3 w-full md:w-auto md:mx-auto px-6 md:px-8 py-3 md:py-4 bg-white bg-opacity-80 backdrop-blur-sm text-gray-700 text-base md:text-lg font-semibold rounded-2xl border-2 border-gray-200 hover:border-green-300 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
              >
                <component :is="PlayCircleIcon" class="w-5 md:w-6 h-5 md:h-6 text-green-600 group-hover:animate-pulse" />
                <span>Watch Demo</span>
              </button>
            </div>

            <!-- Stats Section -->
            <div class="grid grid-cols-3 gap-2 md:gap-8 mt-12 md:mt-16 max-w-4xl mx-auto">
              <div class="backdrop-blur-sm bg-white bg-opacity-60 rounded-xl md:rounded-2xl p-3 md:p-6 border border-white border-opacity-30 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <div class="text-2xl md:text-4xl font-bold text-green-600 mb-1 md:mb-2">10K+</div>
                <div class="text-xs md:text-base text-gray-600 font-medium">Active Learners</div>
              </div>
              <div class="backdrop-blur-sm bg-white bg-opacity-60 rounded-xl md:rounded-2xl p-3 md:p-6 border border-white border-opacity-30 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <div class="text-2xl md:text-4xl font-bold text-blue-600 mb-1 md:mb-2">500+</div>
                <div class="text-xs md:text-base text-gray-600 font-medium">Interactive Quizzes</div>
              </div>
              <div class="backdrop-blur-sm bg-white bg-opacity-60 rounded-xl md:rounded-2xl p-3 md:p-6 border border-white border-opacity-30 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <div class="text-2xl md:text-4xl font-bold text-purple-600 mb-1 md:mb-2">98%</div>
                <div class="text-xs md:text-base text-gray-600 font-medium">Success Rate</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Scroll Indicator -->
        <div v-if="!loadingUser && canViewQuizzes" class="absolute bottom-8 left-1/2 transform -translate-x-1/2">
          <button @click="scrollToQuizzes" class="animate-bounce">
            <component :is="ChevronDownIcon" class="w-8 h-8 text-green-600" />
          </button>
        </div>
      </section>

      <!-- Features Section -->
      <section ref="featuresSection" class="relative py-10 md:py-20 px-2 md:px-6">
        <div class="w-full max-w-7xl mx-auto">
          <div class="text-center mb-8 md:mb-16">
            <h2 class="text-3xl md:text-5xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent mb-4 md:mb-6">
              Why Choose QuizzApp?
            </h2>
            <p class="text-base md:text-xl text-gray-600 max-w-3xl mx-auto">
              Experience the future of learning with our innovative features designed to maximize your potential
            </p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8">
            <div class="group backdrop-blur-sm bg-white bg-opacity-70 rounded-2xl md:rounded-3xl p-6 md:p-8 border border-white border-opacity-30 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
              <div class="w-12 md:w-16 h-12 md:h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl md:rounded-2xl flex items-center justify-center mb-4 md:mb-6 group-hover:scale-110 transition-transform duration-300 mx-auto md:mx-0">
                <BarChart2 class="w-6 md:w-8 h-6 md:h-8 text-white" />
              </div>
              <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-3 md:mb-4 text-center md:text-left">Smart Learning</h3>
              <p class="text-gray-600 leading-relaxed text-center md:text-left text-sm md:text-base">
                AI-powered adaptive learning that adjusts to your pace and understanding level for optimal results.
              </p>
            </div>

            <div class="group backdrop-blur-sm bg-white bg-opacity-70 rounded-2xl md:rounded-3xl p-6 md:p-8 border border-white border-opacity-30 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
              <div class="w-12 md:w-16 h-12 md:h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl md:rounded-2xl flex items-center justify-center mb-4 md:mb-6 group-hover:scale-110 transition-transform duration-300 mx-auto md:mx-0">
                <FileText class="w-6 md:w-8 h-6 md:h-8 text-white" />
              </div>
              <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-3 md:mb-4 text-center md:text-left">Real-time Analytics</h3>
              <p class="text-gray-600 leading-relaxed text-center md:text-left text-sm md:text-base">
                Track your progress with detailed analytics and insights to identify strengths and improvement areas.
              </p>
            </div>

            <div class="group backdrop-blur-sm bg-white bg-opacity-70 rounded-2xl md:rounded-3xl p-6 md:p-8 border border-white border-opacity-30 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
              <div class="w-12 md:w-16 h-12 md:h-16 bg-gradient-to-r from-purple-500 to-pink-600 rounded-xl md:rounded-2xl flex items-center justify-center mb-4 md:mb-6 group-hover:scale-110 transition-transform duration-300 mx-auto md:mx-0">
                <FolderOpen class="w-6 md:w-8 h-6 md:h-8 text-white" />
              </div>
              <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-3 md:mb-4 text-center md:text-left">Gamification</h3>
              <p class="text-gray-600 leading-relaxed text-center md:text-left text-sm md:text-base">
                Earn points, unlock achievements, and compete with friends to make learning fun and engaging.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- Quizzes Section -->
      <section ref="quizzesSection" class="relative py-10 md:py-20 px-2 md:px-6">
        <div class="w-full max-w-7xl mx-auto">
          <div v-if="canViewQuizzes">
            <div class="text-center mb-8 md:mb-16">
              <div class="inline-flex items-center gap-2 bg-gradient-to-r from-green-100 to-emerald-100 backdrop-blur-sm px-4 md:px-6 py-2 md:py-3 rounded-full border border-green-200 shadow-lg mb-4 md:mb-6">
                <component :is="BookOpenIcon" class="w-4 md:w-5 h-4 md:h-5 text-green-600" />
                <span class="text-sm md:text-base text-green-700 font-semibold">Ready to Challenge Yourself?</span>
              </div>
              
              <h2 class="text-3xl md:text-5xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-4 md:mb-6">
                Available Quizzes
              </h2>
              <p class="text-base md:text-xl text-gray-600 max-w-3xl mx-auto">
                Choose from our curated collection of interactive quizzes designed to test and enhance your knowledge
              </p>
            </div>

            <!-- Loading State -->
            <div v-if="quizService.loading" class="text-center py-10 md:py-20">
              <div class="inline-flex items-center gap-4 backdrop-blur-sm bg-white bg-opacity-60 rounded-2xl px-6 md:px-8 py-4 md:py-6 border border-white border-opacity-30 shadow-lg">
                <div class="w-6 md:w-8 h-6 md:h-8 border-4 border-green-500 border-t-transparent rounded-full animate-spin"></div>
                <span class="text-base md:text-xl font-semibold text-gray-700">Discovering amazing quizzes...</span>
              </div>
            </div>

            <!-- Error State -->
            <div v-else-if="quizService.error" class="text-center py-10 md:py-20">
              <div class="inline-flex items-center gap-4 backdrop-blur-sm bg-red-50 bg-opacity-80 rounded-2xl px-6 md:px-8 py-4 md:py-6 border border-red-200 shadow-lg">
                <component :is="ExclamationTriangleIcon" class="w-6 md:w-8 h-6 md:h-8 text-red-500 animate-pulse" />
                <span class="text-base md:text-xl font-semibold text-red-700">{{ quizService.error }}</span>
              </div>
            </div>

            <!-- Quizzes Grid -->
            <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-8">
              <div
                v-for="(test, index) in quizService.all"
                :key="test.id"
                class="group relative backdrop-blur-sm bg-white bg-opacity-80 rounded-2xl md:rounded-3xl p-4 md:p-8 border border-white border-opacity-40 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 hover:scale-105 overflow-hidden"
              >
                <!-- Background Decoration -->
                <div class="absolute top-0 right-0 w-16 md:w-24 h-16 md:h-24 bg-gradient-to-br from-green-200 to-emerald-300 rounded-full -translate-y-8 md:-translate-y-12 translate-x-8 md:translate-x-12 opacity-50 group-hover:opacity-70 transition-opacity duration-300"></div>
                <div class="absolute bottom-0 left-0 w-12 md:w-16 h-12 md:h-16 bg-gradient-to-tr from-blue-200 to-purple-300 rounded-full translate-y-6 md:translate-y-8 -translate-x-6 md:-translate-x-8 opacity-30 group-hover:opacity-50 transition-opacity duration-300"></div>
                
                <div class="relative">
                  <!-- Quiz Icon -->
                  <div class="w-12 md:w-16 h-12 md:h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl md:rounded-2xl flex items-center justify-center mb-4 md:mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg mx-auto md:mx-0">
                    <Settings class="w-6 md:w-8 h-6 md:h-8 text-white" />
                  </div>

                  <!-- Quiz Content -->
                  <div class="space-y-3 md:space-y-4 mb-6 md:mb-8">
                    <h3 class="text-lg md:text-2xl font-bold text-gray-800 group-hover:text-green-700 transition-colors duration-300 text-center md:text-left">
                      {{ test.title }}
                    </h3>
                    
                    <div class="flex items-center justify-center md:justify-start gap-2 text-green-600">
                      <component :is="ClockIcon" class="w-4 md:w-5 h-4 md:h-5" />
                      <span class="font-medium text-sm md:text-base">
                        {{ test.duration ? `${test.duration} minutes` : 'Flexible timing' }}
                      </span>
                    </div>

                    <div class="flex items-center justify-center md:justify-start gap-2 text-gray-600">
                      <component :is="UserGroupIcon" class="w-4 md:w-5 h-4 md:h-5" />
                      <span class="text-xs md:text-sm">{{ Math.floor(Math.random() * 1000) + 100 }}+ participants</span>
                    </div>
                  </div>

                  <!-- Start Button -->
                  <button
                    @click="startTest(test.id)"
                    class="group/btn relative w-full overflow-hidden bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold py-3 md:py-4 px-4 md:px-6 rounded-xl md:rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
                  >
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-green-600 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative flex items-center justify-center gap-2">
                      <component :is="PlayIcon" class="w-4 md:w-5 h-4 md:h-5 group-hover/btn:animate-pulse" />
                      <span class="text-sm md:text-base">Start Quiz</span>
                      <component :is="ArrowRightIcon" class="w-3 md:w-4 h-3 md:h-4 transform group-hover/btn:translate-x-1 transition-transform duration-300" />
                    </div>
                  </button>
                </div>
              </div>

              <!-- Empty State -->
              <div v-if="quizService.all.length === 0" class="col-span-full text-center py-10 md:py-20">
                <div class="max-w-md mx-auto">
                  <div class="w-16 md:w-24 h-16 md:h-24 bg-gradient-to-r from-gray-300 to-gray-400 rounded-full flex items-center justify-center mx-auto mb-4 md:mb-6">
                    <component :is="BookOpenIcon" class="w-8 md:w-12 h-8 md:h-12 text-white" />
                  </div>
                  <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-3 md:mb-4">No Quizzes Available</h3>
                  <p class="text-gray-600 mb-6 md:mb-8 text-sm md:text-base">
                    We're preparing amazing quizzes for you. Check back soon!
                  </p>
                  <button 
                    @click="quizService.fetch()"
                    class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-xl hover:shadow-lg transition-all duration-300"
                  >
                    Refresh
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Unauthorized State -->
          <div v-else class="text-center py-10 md:py-20">
            <div class="max-w-md mx-auto backdrop-blur-sm bg-white bg-opacity-70 rounded-2xl md:rounded-3xl p-8 md:p-12 border border-white border-opacity-30 shadow-xl">
              <div class="w-16 md:w-24 h-16 md:h-24 bg-gradient-to-r from-red-400 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4 md:mb-6">
                <component :is="LockClosedIcon" class="w-8 md:w-12 h-8 md:h-12 text-white" />
              </div>
              <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-3 md:mb-4">Access Required</h3>
              <p class="text-gray-600 mb-6 md:mb-8 text-sm md:text-base">
                Join our community to access amazing quizzes and start your learning journey!
              </p>
              <button 
                @click="navigateToRegister"
                class="w-full md:w-auto px-6 md:px-8 py-3 md:py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-xl md:rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
              >
                Join Now
              </button>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watchEffect, reactive } from 'vue'
import axios from '@/auth/axios'
import { useRouter } from 'vue-router'
import useUserAuth from '@/composable/userAuth'
import { BarChart2, FileText, FolderOpen, Settings } from 'lucide-vue-next'

// Icons - SVG templates
const StarIcon = { 
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
  </svg>` 
}

const RocketIcon = { 
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
  </svg>` 
}

const ArrowRightIcon = { 
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
  </svg>` 
}

const UserPlusIcon = { 
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.765z" />
  </svg>` 
}

const PlayCircleIcon = { 
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    <path stroke-linecap="round" stroke-linejoin="round" d="M15.91 11.672a.375.375 0 010 .656l-5.603 3.113a.375.375 0 01-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112z" />
  </svg>` 
}

const ChevronDownIcon = { 
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
  </svg>` 
}

const BookOpenIcon = { 
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
  </svg>` 
}

const ExclamationTriangleIcon = { 
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
  </svg>` 
}

const ClockIcon = { 
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>` 
}

const UserGroupIcon = { 
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
  </svg>` 
}

const PlayIcon = { 
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
  </svg>` 
}

const LockClosedIcon = { 
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
  </svg>` 
}

// Service Class
class QuizService {
  constructor() {
    this.tests = []
    this.loading = false
    this.error = null
  }

  async fetch() {
    this.loading = true
    try {
      const res = await axios.get('/api/student/display')
      this.tests = res.data?.data ?? []
    } catch {
      this.error = '❌ Failed to load quizzes.'
    } finally {
      this.loading = false
    }
  }

  get all() {
    return this.tests
  }
}

// Composables and State
const router = useRouter()
const { token, fetchUser, hasAnyRole } = useUserAuth()
const loadingUser = ref(true)
const quizService = reactive(new QuizService())
const canViewQuizzes = computed(() => token.value && hasAnyRole(['super-admin', 'student']))

// Refs for sections
const featuresSection = ref(null)
const quizzesSection = ref(null)

// Methods
function startTest(id) {
  window.location.href = `/questions/${id}`
}

function navigateToRegister() {
  router.push('/register')
}

function scrollToQuizzes() {
  quizzesSection.value?.scrollIntoView({ 
    behavior: 'smooth',
    block: 'start'
  })
}

function scrollToFeatures() {
  featuresSection.value?.scrollIntoView({ 
    behavior: 'smooth',
    block: 'start'
  })
}

// Lifecycle
onMounted(async () => {
  if (token.value) await fetchUser()
  loadingUser.value = false
})

watchEffect(() => {
  if (canViewQuizzes.value) quizService.fetch()
})
</script>

<style scoped>
/* Custom Animations */
@keyframes blob {
  0% { transform: translate(0px, 0px) scale(1); }
  33% { transform: translate(30px, -50px) scale(1.1); }
  66% { transform: translate(-20px, 20px) scale(0.9); }
  100% { transform: translate(0px, 0px) scale(1); }
}

@keyframes gradient {
  0%, 100% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.5; }
}

.animate-blob {
  animation: blob 7s infinite;
}

.animate-gradient {
  background-size: 200% 200%;
  animation: gradient 3s ease infinite;
}

.animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.animation-delay-1000 {
  animation-delay: 1s;
}

.animation-delay-2000 {
  animation-delay: 2s;
}

.animation-delay-4000 {
  animation-delay: 4s;
}

/* Backdrop Blur Support */
.backdrop-blur-sm {
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(4px);
}

/* Opacity Classes */
.bg-opacity-30 {
  background-color: rgba(255, 255, 255, 0.3);
}

.bg-opacity-60 {
  background-color: rgba(255, 255, 255, 0.6);
}

.bg-opacity-70 {
  background-color: rgba(255, 255, 255, 0.7);
}

.bg-opacity-80 {
  background-color: rgba(255, 255, 255, 0.8);
}

.border-opacity-20 {
  border-color: rgba(255, 255, 255, 0.2);
}

.border-opacity-30 {
  border-color: rgba(255, 255, 255, 0.3);
}

.border-opacity-40 {
  border-color: rgba(255, 255, 255, 0.4);
}

/* Gradient Text */
.bg-clip-text {
  background-clip: text;
  -webkit-background-clip: text;
}

.text-transparent {
  color: transparent;
}

/* Hover Effects */
.hover\:shadow-3xl:hover {
  box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
}

/* Transform Classes */
.scale-95 {
  transform: scale(0.95);
}

.scale-100 {
  transform: scale(1);
}

.translate-y-8 {
  transform: translateY(2rem);
}

.translate-y-12 {
  transform: translateY(3rem);
}

.-translate-y-12 {
  transform: translateY(-3rem);
}

.translate-x-12 {
  transform: translateX(3rem);
}

.-translate-x-8 {
  transform: translateX(-2rem);
}

.translate-y-8 {
  transform: translateY(2rem);
}

/* Group Hover Effects */
.group:hover .group-hover\:text-green-700 {
  color: rgb(21 128 61);
}

.group:hover .group-hover\:scale-110 {
  transform: scale(1.1);
}

.group:hover .group-hover\:opacity-70 {
  opacity: 0.7;
}

.group:hover .group-hover\:opacity-50 {
  opacity: 0.5;
}

.group:hover .group-hover\:animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.group:hover .group-hover\:animate-bounce {
  animation: bounce 1s infinite;
}

.group\/btn:hover .group-hover\/btn\:opacity-100 {
  opacity: 1;
}

.group\/btn:hover .group-hover\/btn\:translate-x-1 {
  transform: translateX(0.25rem);
}

.group\/btn:hover .group-hover\/btn\:animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Transition Classes */
.transition-all {
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

.duration-300 {
  transition-duration: 300ms;
}

.duration-500 {
  transition-duration: 500ms;
}

/* Custom Scrollbar */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.1);
  border-radius: 4px;
}

::-webkit-scrollbar-thumb {
  background: rgba(34, 197, 94, 0.3);
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: rgba(34, 197, 94, 0.5);
}
</style>