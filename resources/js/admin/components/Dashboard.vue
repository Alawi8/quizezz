<template>
    <div class="max-w-7xl mx-auto p-6 space-y-8 text-green-700">
        <h2 class="text-2xl font-bold flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h13M3 7h13v6H3z" /></svg>
            Dashboard Statistics
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white border-2 border-green-500 rounded-2xl shadow p-6 text-center">
                <p class="text-sm text-gray-500">Total Users</p>
                <h3 class="text-3xl font-bold text-green-700">{{ stats.totalUsers }}</h3>
            </div>

            <div class="bg-white border-2 border-green-500 rounded-2xl shadow p-6 text-center">
                <p class="text-sm text-gray-500">Total Questions</p>
                <h3 class="text-3xl font-bold text-green-700">{{ stats.totalSections }}</h3>
            </div>

            <div class="bg-white border-2 border-green-500 rounded-2xl shadow p-6 text-center">
                <p class="text-sm text-gray-500">Total Tests</p>
                <h3 class="text-3xl font-bold text-green-700">{{ stats.totalTests }}</h3>
            </div>

            <div class="bg-white border-2 border-green-500 rounded-2xl shadow p-6 text-center">
                <p class="text-sm text-gray-500">Total Answers</p>
                <h3 class="text-3xl font-bold text-green-700">{{ stats.totalAnswers }}</h3>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from "axios";

const stats = ref({
    totalUsers: 0,
    totalSections: 0,
    totalTests: 0,
    totalAnswers: 0
})

async function fetchCounts() {
    try {
        const res = await axios.get("/api/admin/stats")
        stats.value = {
            totalUsers: res.data.users,
            totalSections: res.data.questions,
            totalTests: res.data.tests,
            totalAnswers: res.data.answers,
        }
    } catch (err) {
        console.error("❌ Failed to fetch stats", err)
    }
}

onMounted(fetchCounts)
</script>

<style scoped>
</style>
