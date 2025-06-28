<script setup>
import { ref, computed, onMounted, watchEffect, reactive } from 'vue'
import axios from '@/auth/axios'
import { useRouter } from 'vue-router'
import useUserAuth from '@/composable/userAuth'

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

const router = useRouter()
const { token, fetchUser, hasAnyRole } = useUserAuth()
const loadingUser = ref(true)

const quizService = reactive(new QuizService())
const canViewQuizzes = computed(() => token.value && hasAnyRole(['super-admin', 'student']))

function startTest(id) {
  window.location.href = `/questions/${id}`
}

onMounted(async () => {
  if (token.value) await fetchUser()
  loadingUser.value = false
})

watchEffect(() => {
  if (canViewQuizzes.value) quizService.fetch()
})
</script>

<template>
  <div class="container mx-auto px-4 py-8 animate-fade-in">
    <div v-if="loadingUser" class="text-center text-gray-500 py-12 animate-pulse">
      <p class="text-xl font-medium">🔄 Checking user status...</p>
    </div>

    <div v-else>
      <transition name="fade" mode="out-in">
        <div v-if="canViewQuizzes">
          <h1 class="text-4xl font-extrabold text-center text-green-700 mb-10 animate-slide-down">
            Available Quizzes
          </h1>

          <div v-if="quizService.loading" class="text-center text-gray-500 text-lg animate-pulse">
            🔄 Loading quizzes...
          </div>

          <div v-else-if="quizService.error" class="text-center text-red-500 text-lg animate-shake">
            {{ quizService.error }}
          </div>

          <div v-else class="grid sm:grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-6">
            <transition-group name="fade" tag="div" class="contents">
              <div
                v-for="test in quizService.all"
                :key="test.id"
                class="bg-white border border-green-200 rounded-2xl p-6 shadow-md hover:shadow-xl transition-all duration-300 animate-fade-in hover:-translate-y-1"
              >
                <h2 class="text-2xl font-bold text-green-700 mb-2">{{ test.title }}</h2>
                <p class="text-green-600 mb-4">Duration: {{ test.duration ?? 'Not specified' }} mins</p>
                <button
                  @click="startTest(test.id)"
                  class="w-full bg-gradient-to-r from-green-500 to-green-700 text-white px-4 py-2 rounded-full font-semibold shadow hover:opacity-90 transition-all duration-300"
                >
                  Start Now
                </button>
              </div>
            </transition-group>
          </div>
        </div>

        <div v-else class="text-center text-red-500 py-12 text-lg animate-bounce">
          🚫 You are not authorized to view quizzes.
        </div>
      </transition>
    </div>
  </div>
</template>