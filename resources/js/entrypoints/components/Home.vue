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
      <section class="relative min-h-screen flex items-center justify-center px-4 py-20">
        <div class="max-w-7xl mx-auto text-center">
          <!-- Loading State -->
          <transition
            enter-active-class="transition ease-out duration-500"
            enter-from-class="opacity-0 transform translate-y-8"
            enter-to-class="opacity-100 transform translate-y-0"
            leave-active-class="transition ease-in duration-300"
            leave-from-class="opacity-100 transform translate-y-0"
            leave-to-class="opacity-0 transform translate-y-8"
          >
            <div v-if="loadingUser" class="backdrop-blur-sm bg-white bg-opacity-30 rounded-3xl p-12 border border-white border-opacity-20 shadow-2xl">
              <div class="flex items-center justify-center gap-4 mb-6">
                <div class="w-12 h-12 border-4 border-green-500 border-t-transparent rounded-full animate-spin"></div>
                <p class="text-2xl font-semibold text-gray-700">Initializing QuizzApp...</p>
              </div>
              <div class="flex justify-center gap-2">
                <div class="w-3 h-3 bg-green-400 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                <div class="w-3 h-3 bg-green-500 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                <div class="w-3 h-3 bg-green-600 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
              </div>
            </div>
          </transition>

          <!-- Main Hero Content -->
          <transition
            enter-active-class="transition ease-out duration-700"
            enter-from-class="opacity-0 transform translate-y-12"
            enter-to-class="opacity-100 transform translate-y-0"
            leave-active-class="transition ease-in duration-300"
            leave-from-class="opacity-100 transform translate-y-0"
            leave-to-class="opacity-0 transform translate-y-12"
          >
            <div v-if="!loadingUser" class="space-y-8">
              <!-- Hero Title -->
              <div class="space-y-6">
                <div class="inline-flex items-center gap-2 bg-gradient-to-r from-green-100 to-emerald-100 backdrop-blur-sm px-6 py-3 rounded-full border border-green-200 shadow-lg">
                  <StarIcon class="w-5 h-5 text-yellow-500 animate-pulse" />
                  <span class="text-green-700 font-semibold">Transform Your Learning Journey</span>
                  <StarIcon class="w-5 h-5 text-yellow-500 animate-pulse" />
                </div>
                
                <h1 class="text-6xl md:text-7xl font-extrabold leading-tight">
                  <span class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 bg-clip-text text-transparent animate-gradient">
                    Master Skills with
                  </span>
                  <br>
                  <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent animate-gradient animation-delay-1000">
                    Interactive Quizzes
                  </span>
                </h1>
                
                <p class="text-xl md:text-2xl text-gray-600 max-w-4xl mx-auto leading-relaxed">
                  Unlock your potential with our cutting-edge quiz platform. 
                  <span class="font-semibold text-green-600">Engage, Learn, Excel</span> - all in one place.
                </p>
              </div>

              <!-- CTA Buttons -->
              <div class="flex flex-col sm:flex-row items-center justify-center gap-6 mt-12">
                <button 
                  v-if="canViewQuizzes"
                  @click="scrollToQuizzes"
                  class="group relative overflow-hidden px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white text-lg font-bold rounded-2xl shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-105"
                >
                  <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-green-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                  <div class="relative flex items-center gap-3">
                    <RocketIcon class="w-6 h-6 group-hover:animate-bounce" />
                    <span>Start Learning Now</span>
                    <ArrowRightIcon class="w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-300" />
                  </div>
                </button>

                <button 
                  v-else
                  @click="navigateToRegister"
                  class="group relative overflow-hidden px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-lg font-bold rounded-2xl shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-105"
                >
                  <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                  <div class="relative flex items-center gap-3">
                    <UserPlusIcon class="w-6 h-6 group-hover:animate-bounce" />
                    <span>Join QuizzApp</span>
                    <ArrowRightIcon class="w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-300" />
                  </div>
                </button>

                <button 
                  @click="scrollToFeatures"
                  class="group flex items-center gap-3 px-8 py-4 bg-white bg-opacity-80 backdrop-blur-sm text-gray-700 text-lg font-semibold rounded-2xl border-2 border-gray-200 hover:border-green-300 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
                >
                  <PlayCircleIcon class="w-6 h-6 text-green-600 group-hover:animate-pulse" />
                  <span>Watch Demo</span>
                </button>
              </div>

              <!-- Stats Section -->
              <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16 max-w-4xl mx-auto">
                <div class="backdrop-blur-sm bg-white bg-opacity-60 rounded-2xl p-6 border border-white border-opacity-30 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                  <div class="text-4xl font-bold text-green-600 mb-2">10K+</div>
                  <div class="text-gray-600 font-medium">Active Learners</div>
                </div>
                <div class="backdrop-blur-sm bg-white bg-opacity-60 rounded-2xl p-6 border border-white border-opacity-30 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                  <div class="text-4xl font-bold text-blue-600 mb-2">500+</div>
                  <div class="text-gray-600 font-medium">Interactive Quizzes</div>
                </div>
                <div class="backdrop-blur-sm bg-white bg-opacity-60 rounded-2xl p-6 border border-white border-opacity-30 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                  <div class="text-4xl font-bold text-purple-600 mb-2">98%</div>
                  <div class="text-gray-600 font-medium">Success Rate</div>
                </div>
              </div>
            </div>
          </transition>
        </div>

        <!-- Scroll Indicator -->
        <div v-if="!loadingUser && canViewQuizzes" class="absolute bottom-8 left-1/2 transform -translate-x-1/2">
          <button @click="scrollToQuizzes" class="animate-bounce">
            <ChevronDownIcon class="w-8 h-8 text-green-600" />
          </button>
        </div>
      </section>

      <!-- Features Section -->
      <section ref="featuresSection" class="relative py-20 px-4">
        <div class="max-w-7xl mx-auto">
          <div class="text-center mb-16">
            <h2 class="text-5xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent mb-6">
              Why Choose QuizzApp?
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
              Experience the future of learning with our innovative features designed to maximize your potential
            </p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="group backdrop-blur-sm bg-white bg-opacity-70 rounded-3xl p-8 border border-white border-opacity-30 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
              <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                <BrainIcon class="w-8 h-8 text-white" />
              </div>
              <h3 class="text-2xl font-bold text-gray-800 mb-4">Smart Learning</h3>
              <p class="text-gray-600 leading-relaxed">
                AI-powered adaptive learning that adjusts to your pace and understanding level for optimal results.
              </p>
            </div>

            <div class="group backdrop-blur-sm bg-white bg-opacity-70 rounded-3xl p-8 border border-white border-opacity-30 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
              <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                <ChartBarIcon class="w-8 h-8 text-white" />
              </div>
              <h3 class="text-2xl font-bold text-gray-800 mb-4">Real-time Analytics</h3>
              <p class="text-gray-600 leading-relaxed">
                Track your progress with detailed analytics and insights to identify strengths and improvement areas.
              </p>
            </div>

            <div class="group backdrop-blur-sm bg-white bg-opacity-70 rounded-3xl p-8 border border-white border-opacity-30 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
              <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                <TrophyIcon class="w-8 h-8 text-white" />
              </div>
              <h3 class="text-2xl font-bold text-gray-800 mb-4">Gamification</h3>
              <p class="text-gray-600 leading-relaxed">
                Earn points, unlock achievements, and compete with friends to make learning fun and engaging.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- Quizzes Section -->
      <section ref="quizzesSection" class="relative py-20 px-4">
        <div class="max-w-7xl mx-auto">
          <transition
            enter-active-class="transition ease-out duration-500"
            enter-from-class="opacity-0 transform translate-y-8"
            enter-to-class="opacity-100 transform translate-y-0"
          >
            <div v-if="canViewQuizzes">
              <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 bg-gradient-to-r from-green-100 to-emerald-100 backdrop-blur-sm px-6 py-3 rounded-full border border-green-200 shadow-lg mb-6">
                  <BookOpenIcon class="w-5 h-5 text-green-600" />
                  <span class="text-green-700 font-semibold">Ready to Challenge Yourself?</span>
                </div>
                
                <h2 class="text-5xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-6">
                  Available Quizzes
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                  Choose from our curated collection of interactive quizzes designed to test and enhance your knowledge
                </p>
              </div>

              <!-- Loading State -->
              <transition
                enter-active-class="transition ease-out duration-300"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
              >
                <div v-if="quizService.loading" class="text-center py-20">
                  <div class="inline-flex items-center gap-4 backdrop-blur-sm bg-white bg-opacity-60 rounded-2xl px-8 py-6 border border-white border-opacity-30 shadow-lg">
                    <div class="w-8 h-8 border-4 border-green-500 border-t-transparent rounded-full animate-spin"></div>
                    <span class="text-xl font-semibold text-gray-700">Discovering amazing quizzes...</span>
                  </div>
                </div>
              </transition>

              <!-- Error State -->
              <transition
                enter-active-class="transition ease-out duration-300"
                enter-from-class="opacity-0 scale-95"
                enter-to-class="opacity-100 scale-100"
                leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100 scale-100"
                leave-to-class="opacity-0 scale-95"
              >
                <div v-if="quizService.error" class="text-center py-20">
                  <div class="inline-flex items-center gap-4 backdrop-blur-sm bg-red-50 bg-opacity-80 rounded-2xl px-8 py-6 border border-red-200 shadow-lg">
                    <ExclamationTriangleIcon class="w-8 h-8 text-red-500 animate-pulse" />
                    <span class="text-xl font-semibold text-red-700">{{ quizService.error }}</span>
                  </div>
                </div>
              </transition>

              <!-- Quizzes Grid -->
              <transition-group
                enter-active-class="transition ease-out duration-500"
                enter-from-class="opacity-0 transform translate-y-8 scale-95"
                enter-to-class="opacity-100 transform translate-y-0 scale-100"
                leave-active-class="transition ease-in duration-300"
                leave-from-class="opacity-100 transform translate-y-0 scale-100"
                leave-to-class="opacity-0 transform translate-y-8 scale-95"
                tag="div"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8"
                v-if="!quizService.loading && !quizService.error"
              >
                <div
                  v-for="(test, index) in quizService.all"
                  :key="test.id"
                  class="group relative backdrop-blur-sm bg-white bg-opacity-80 rounded-3xl p-8 border border-white border-opacity-40 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 hover:scale-105 overflow-hidden"
                  :style="{ animationDelay: `${index * 100}ms` }"
                >
                  <!-- Background Decoration -->
                  <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-green-200 to-emerald-300 rounded-full -translate-y-12 translate-x-12 opacity-50 group-hover:opacity-70 transition-opacity duration-300"></div>
                  <div class="absolute bottom-0 left-0 w-16 h-16 bg-gradient-to-tr from-blue-200 to-purple-300 rounded-full translate-y-8 -translate-x-8 opacity-30 group-hover:opacity-50 transition-opacity duration-300"></div>
                  
                  <div class="relative">
                    <!-- Quiz Icon -->
                    <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                      <QuestionMarkCircleIcon class="w-8 h-8 text-white" />
                    </div>

                    <!-- Quiz Content -->
                    <div class="space-y-4 mb-8">
                      <h3 class="text-2xl font-bold text-gray-800 group-hover:text-green-700 transition-colors duration-300 line-clamp-2">
                        {{ test.title }}
                      </h3>
                      
                      <div class="flex items-center gap-2 text-green-600">
                        <ClockIcon class="w-5 h-5" />
                        <span class="font-medium">
                          {{ test.duration ? `${test.duration} minutes` : 'Flexible timing' }}
                        </span>
                      </div>

                      <div class="flex items-center gap-2 text-gray-600">
                        <UserGroupIcon class="w-5 h-5" />
                        <span class="text-sm">{{ Math.floor(Math.random() * 1000) + 100 }}+ participants</span>
                      </div>
                    </div>

                    <!-- Start Button -->
                    <button
                      @click="startTest(test.id)"
                      class="group/btn relative w-full overflow-hidden bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold py-4 px-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
                    >
                      <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-green-600 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                      <div class="relative flex items-center justify-center gap-2">
                        <PlayIcon class="w-5 h-5 group-hover/btn:animate-pulse" />
                        <span>Start Quiz</span>
                        <ArrowRightIcon class="w-4 h-4 transform group-hover/btn:translate-x-1 transition-transform duration-300" />
                      </div>
                    </button>
                  </div>
                </div>
              </transition-group>

              <!-- Empty State -->
              <div v-if="!quizService.loading && !quizService.error && quizService.all.length === 0" class="text-center py-20">
                <div class="max-w-md mx-auto">
                  <div class="w-24 h-24 bg-gradient-to-r from-gray-300 to-gray-400 rounded-full flex items-center justify-center mx-auto mb-6">
                    <BookOpenIcon class="w-12 h-12 text-white" />
                  </div>
                  <h3 class="text-2xl font-bold text-gray-800 mb-4">No Quizzes Available</h3>
                  <p class="text-gray-600 mb-8">
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
          </transition>

          <!-- Unauthorized State -->
          <transition
            enter-active-class="transition ease-out duration-500"
            enter-from-class="opacity-0 transform translate-y-8"
            enter-to-class="opacity-100 transform translate-y-0"
          >
            <div v-if="!loadingUser && !canViewQuizzes" class="text-center py-20">
              <div class="max-w-md mx-auto backdrop-blur-sm bg-white bg-opacity-70 rounded-3xl p-12 border border-white border-opacity-30 shadow-xl">
                <div class="w-24 h-24 bg-gradient-to-r from-red-400 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6">
                  <LockClosedIcon class="w-12 h-12 text-white" />
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Access Required</h3>
                <p class="text-gray-600 mb-8">
                  Join our community to access amazing quizzes and start your learning journey!
                </p>
                <button 
                  @click="navigateToRegister"
                  class="px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
                >
                  Join Now
                </button>
              </div>
            </div>
          </transition>
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

// Icons
const StarIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" /></svg>' }
const RocketIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" /></svg>' }
const ArrowRightIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>' }
const UserPlusIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.765z" /></svg>' }
const PlayCircleIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15.91 11.672a.375.375 0 010 .656l-5.603 3.113a.375.375 0 01-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112z" /></svg>' }
const ChevronDownIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>' }
const BrainIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456L18.259 8.715z" /></svg>' }
const ChartBarIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" /></svg>' }
const TrophyIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5C5.25 5.671 6.171 6.5 7.25 6.5h1.993c.058 0 .116.001.174.003m-2.667-2.267c.91.166 1.836.318 2.777.456m2.667 2.267a8.944 8.944 0 00-1.981-.198m0 0v-.916c0-1.18.91-2.164 2.09-2.201a51.964 51.964 0 014.467 0c1.18.037 2.09 1.022 2.09 2.201v.916m-11.5.845C17.92 6.977 21.7 8.768 21.7 11.156c0 .414-.34.75-.756.75h-1.944m-11.5-2.667C3.02 6.977-.76 8.768-.76 11.156c0 .414.34.75.756.75h1.944" /></svg>' }
const BookOpenIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>' }
const ExclamationTriangleIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>' }
const QuestionMarkCircleIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" /></svg>' }
const ClockIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>' }
const UserGroupIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" /></svg>' }
const PlayIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" /></svg>' }
const LockClosedIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>' }

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

@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-20px); }
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
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

.animate-float {
  animation: float 6s ease-in-out infinite;
}

.animate-fadeInUp {
  animation: fadeInUp 0.6s ease-out forwards;
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

.backdrop-blur-lg {
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
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

/* Line Clamp */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
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

.duration-700 {
  transition-duration: 700ms;
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