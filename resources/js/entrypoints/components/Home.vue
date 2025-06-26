<template>
  <div class="container mx-auto px-4 py-8 animate-fade-in">
    <!-- 🔄 Loading user -->
    <div v-if="loadingUser" class="text-center text-gray-500 py-12 animate-pulse">
      <p class="text-xl font-medium">🔄 Checking user status...</p>
    </div>

    <!-- ✅ Display quizzes -->
    <div v-else>
      <transition name="fade" mode="out-in">
        <div v-if="canViewQuizzes">
          <h1 class="text-4xl font-extrabold text-center text-green-700 mb-10 animate-slide-down">
            Available Quizzes
          </h1>

          <div v-if="loadingTests" class="text-center text-gray-500 text-lg animate-pulse">
            🔄 Loading quizzes...
          </div>

          <div v-else-if="errorMessage" class="text-center text-red-500 text-lg animate-shake">
            {{ errorMessage }}
          </div>

          <div v-else class="grid sm:grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-6">
            <transition-group name="fade" tag="div" class="contents">
              <div
                v-for="test in tests"
                :key="test.id"
                class="bg-white border border-green-200 rounded-2xl p-6 shadow-md hover:shadow-xl transition-all duration-300 animate-fade-in hover:-translate-y-1"
              >
                <h2 class="text-2xl font-bold text-green-700 mb-2">{{ test.title }}</h2>
                <p class="text-green-600 mb-4">
                  Duration: {{ test.duration ?? 'Not specified' }} mins
                </p>
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

        <!-- ❌ Unauthorized -->
        <div v-else class="text-center text-red-500 py-12 text-lg animate-bounce">
          🚫 You are not authorized to view quizzes.
        </div>
      </transition>
    </div>
  </div>
</template>


<script setup>
import { ref, computed, onMounted, watchEffect } from 'vue'
import axios from '@/auth/axios'
import { useRouter } from 'vue-router'
import useUserAuth from '@/composable/userAuth'

const router = useRouter()
const { user, token, fetchUser, hasAnyRole } = useUserAuth()

const tests = ref([])
const loadingUser = ref(true)
const loadingTests = ref(false)
const errorMessage = ref(null)

// ✅ هل المستخدم يملك صلاحية مشاهدة الاختبارات
const canViewQuizzes = computed(() => {
  return token.value && hasAnyRole(['super-admin', 'student'])
})

// ✅ جلب الاختبارات
async function fetchTests() {
  loadingTests.value = true
  try {
    const res = await axios.get('/api/student/display')
    tests.value = res.data?.data ?? []
  } catch {
    errorMessage.value = '❌ Failed to load quizzes.'
  } finally {
    loadingTests.value = false
  }
}

// ✅ بدء الاختبار
function startTest(id) {
  window.location.href = `/questions/${id}`
}

// ✅ تحميل المستخدم عند بدء الصفحة
onMounted(async () => {
  if (token.value) {
    await fetchUser()
  }
  loadingUser.value = false
})

// ✅ تحديث تلقائي للاختبارات عند تغيّر حالة الدخول
watchEffect(() => {
  if (canViewQuizzes.value) {
    fetchTests()
  } else {
    tests.value = []
  }
})
</script>


<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s ease;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}

.animate-slide-down {
    animation: slideDown 0.5s ease-out;
}
@keyframes slideDown {
    0% {
        opacity: 0;
        transform: translateY(-20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-shake {
    animation: shake 0.6s ease-in-out;
}
@keyframes shake {
    0%, 100% {
        transform: translateX(0);
    }
    20%, 60% {
        transform: translateX(-5px);
    }
    40%, 80% {
        transform: translateX(5px);
    }
}

.animate-bounce {
    animation: bounce 1s infinite;
}
@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

.animate-fade-in {
    animation: fadeIn 0.6s ease-in-out;
}
@keyframes fadeIn {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}
</style>
