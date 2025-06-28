<template>
    <div class="max-w-7xl mx-auto p-6 space-y-8">
        <!-- Header with gradient background -->
        <div class="relative overflow-hidden bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 rounded-3xl p-8 text-white shadow-2xl">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="relative z-10">
                <h2 class="text-3xl font-bold flex items-center gap-3">
                    <div class="p-2 bg-white/20 rounded-xl backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    Dashboard Statistics
                </h2>
                <p class="text-emerald-100 mt-2 text-lg">Real-time platform analytics and insights</p>
            </div>
            
            <!-- Decorative elements -->
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/5 rounded-full"></div>
            <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-white/5 rounded-full"></div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Users Card -->
            <div class="group bg-white hover:bg-gradient-to-br hover:from-blue-50 hover:to-indigo-50 border border-gray-200 hover:border-blue-300 rounded-2xl shadow-lg hover:shadow-2xl p-6 text-center transition-all duration-500 transform hover:-translate-y-2 hover:scale-105">
                <div class="flex justify-center mb-4">
                    <div class="p-4 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-gray-500 font-medium mb-2">Total Users</p>
                <h3 class="text-4xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors duration-300 counter" data-target="{{ stats.totalUsers }}">{{ animatedStats.totalUsers }}</h3>
                <div class="mt-3 flex items-center justify-center text-green-500">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium">Active</span>
                </div>
            </div>

            <!-- Total Questions Card -->
            <div class="group bg-white hover:bg-gradient-to-br hover:from-purple-50 hover:to-pink-50 border border-gray-200 hover:border-purple-300 rounded-2xl shadow-lg hover:shadow-2xl p-6 text-center transition-all duration-500 transform hover:-translate-y-2 hover:scale-105">
                <div class="flex justify-center mb-4">
                    <div class="p-4 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-gray-500 font-medium mb-2">Total Questions</p>
                <h3 class="text-4xl font-bold text-gray-800 group-hover:text-purple-600 transition-colors duration-300 counter" data-target="{{ stats.totalSections }}">{{ animatedStats.totalSections }}</h3>
                <div class="mt-3 flex items-center justify-center text-green-500">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium">Growing</span>
                </div>
            </div>

            <!-- Total Tests Card -->
            <div class="group bg-white hover:bg-gradient-to-br hover:from-emerald-50 hover:to-teal-50 border border-gray-200 hover:border-emerald-300 rounded-2xl shadow-lg hover:shadow-2xl p-6 text-center transition-all duration-500 transform hover:-translate-y-2 hover:scale-105">
                <div class="flex justify-center mb-4">
                    <div class="p-4 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-gray-500 font-medium mb-2">Total Tests</p>
                <h3 class="text-4xl font-bold text-gray-800 group-hover:text-emerald-600 transition-colors duration-300 counter" data-target="{{ stats.totalTests }}">{{ animatedStats.totalTests }}</h3>
                <div class="mt-3 flex items-center justify-center text-green-500">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium">Available</span>
                </div>
            </div>

            <!-- Total Answers Card -->
            <div class="group bg-white hover:bg-gradient-to-br hover:from-orange-50 hover:to-red-50 border border-gray-200 hover:border-orange-300 rounded-2xl shadow-lg hover:shadow-2xl p-6 text-center transition-all duration-500 transform hover:-translate-y-2 hover:scale-105">
                <div class="flex justify-center mb-4">
                    <div class="p-4 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-gray-500 font-medium mb-2">Total Answers</p>
                <h3 class="text-4xl font-bold text-gray-800 group-hover:text-orange-600 transition-colors duration-300 counter" data-target="{{ stats.totalAnswers }}">{{ animatedStats.totalAnswers }}</h3>
                <div class="mt-3 flex items-center justify-center text-green-500">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium">Submitted</span>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div v-if="isLoading" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white p-8 rounded-2xl shadow-2xl">
                <div class="flex items-center space-x-3">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-600"></div>
                    <span class="text-gray-700 font-medium">Loading statistics...</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue'
import axios from "axios";

const isLoading = ref(true)

const stats = ref({
    totalUsers: 0,
    totalSections: 0,
    totalTests: 0,
    totalAnswers: 0
})

// For animated counting effect
const animatedStats = reactive({
    totalUsers: 0,
    totalSections: 0,
    totalTests: 0,
    totalAnswers: 0
})

// Animate numbers counting up
function animateValue(obj, key, start, end, duration) {
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        obj[key] = Math.floor(progress * (end - start) + start);
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}

async function fetchCounts() {
    try {
        isLoading.value = true
        const res = await axios.get("/api/admin/stats")
        
        stats.value = {
            totalUsers: res.data.users,
            totalSections: res.data.questions,
            totalTests: res.data.tests,
            totalAnswers: res.data.answers,
        }

        // Animate the counting effect
        setTimeout(() => {
            animateValue(animatedStats, 'totalUsers', 0, stats.value.totalUsers, 2000)
            animateValue(animatedStats, 'totalSections', 0, stats.value.totalSections, 2200)
            animateValue(animatedStats, 'totalTests', 0, stats.value.totalTests, 2400)
            animateValue(animatedStats, 'totalAnswers', 0, stats.value.totalAnswers, 2600)
        }, 500)
        
    } catch (err) {
        console.error("❌ Failed to fetch stats", err)
    } finally {
        isLoading.value = false
    }
}

onMounted(fetchCounts)
</script>

<style scoped>
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

.group {
    animation: fadeInUp 0.6s ease-out;
}

.group:nth-child(1) { animation-delay: 0.1s; }
.group:nth-child(2) { animation-delay: 0.2s; }
.group:nth-child(3) { animation-delay: 0.3s; }
.group:nth-child(4) { animation-delay: 0.4s; }

/* Custom scrollbar for modern look */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(45deg, #10b981, #059669);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(45deg, #059669, #047857);
}
</style>