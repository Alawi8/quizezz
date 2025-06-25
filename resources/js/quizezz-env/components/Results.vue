<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const result = ref<null | {
  correct: number
  total: number
  score: number
}>(null)

const loading = ref(true)
const error = ref('')

const fetchResult = async () => {
  const testId = route.params.test_id as string
  const token = localStorage.getItem('auth_token')

  const res = await axios.get(`/api/student/final-result/${testId}`, {
    headers: {
      Authorization: `Bearer ${token}`
    }
  })

  result.value = res.data
}

onMounted(async () => {
  try {
    await fetchResult()
  } catch (e) {
    error.value = 'تعذر تحميل النتيجة.'
    console.error(e)
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <div class="max-w-xl mx-auto mt-10 bg-white/10 rounded-lg shadow-lg p-8 text-center">
    <h2 class="text-2xl font-bold mb-4 text-green-400">نتيجة الاختبار</h2>

    <div v-if="loading">جاري تحميل النتيجة...</div>
    <div v-else-if="error" class="text-red-500">{{ error }}</div>

    <div v-else-if="result">
      <div class="text-4xl font-extrabold mb-2 text-green-500">
        {{ result.score }} / 100
      </div>

      <div class="mb-4 text-lg">
        عدد الأسئلة:
        <span class="font-semibold text-white">{{ result.total }}</span>
      </div>

      <div class="flex justify-center gap-8 mb-4">
        <div>
          <div class="font-bold text-green-400">الإجابات الصحيحة</div>
          <div class="text-xl">{{ result.correct }}</div>
        </div>
        <div>
          <div class="font-bold text-red-400">الإجابات الخاطئة</div>
          <div class="text-xl">{{ result.total - result.correct }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
</style>
