<template>
    <div class="p-6">
        <Header/>
        <h1 class="text-2xl font-bold mb-4">📝 Quiz Questions</h1>

        <div v-if="error" class="text-red-600 mb-4">{{ error }}</div>

        <ul class="space-y-4">
            <li v-for="(q, i) in questions" :key="q.id" class="p-4 border rounded">
                <h2 class="font-semibold mb-2">{{ i + 1 }}. {{ q.question_text }}</h2>
                <ul class="ml-4 list-disc">
                    <li v-for="option in q.answers" :key="option.id">
                        {{ option.answer_text }}
                    </li>
                </ul>
            </li>
        </ul>
        <Footer/>
    </div>
</template>

<script setup>
import { ref, onMounted , watchEffect } from 'vue'
import axios from '@/auth/axios'
import useUserAuth from '@/composable/userAuth.js'
import Header from "@/quizezz-env/layouts/Header.vue";
import Footer from "@/quizezz-env/layouts/Footer.vue";

const { token } = useUserAuth()
const questions = ref([])
const error = ref(null)

function getTestIdFromUrl() {
    const parts = window.location.pathname.split('/')
    return parts[parts.length - 1] || null
}

const testId = getTestIdFromUrl()

async function fetchQuestions() {
    try {
        if (!testId) throw new Error('Test ID not found in URL.')

        const res = await axios.get(`/api/student/question/${testId}`, {
            headers: { Authorization: `Bearer ${token.value}` }
        })

        questions.value = res.data.data || []
    } catch (err) {
        error.value = err.response?.data?.message || err.message || 'Error loading questions'
        console.error('Fetch Error:', error.value)
    }
}

watchEffect(() => {
    const testId = getTestIdFromUrl()
    fetchQuestions(testId)
})
</script>
