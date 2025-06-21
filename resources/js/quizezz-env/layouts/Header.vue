<!--resources/quizezz-env/components/Header.vue-->
<script setup lang="ts">

</script>

<template>
    <header class="bg-black text-white p-4 rounded-b-xl shadow-md w-full">
        <div class="flex flex-wrap md:flex-nowrap items-center justify-between gap-4">
            <!-- Left Section -->
            <div class="text-lg font-semibold text-center md:text-left">
                Question
            </div>

            <!-- Time Section -->
            <div class="text-lg font-semibold text-center md:text-left">
                Time Left:
            </div>

            <!-- Progress Bar & Button Section -->
            <div class="flex-1 flex flex-wrap md:flex-nowrap items-center gap-2">
                <div class="w-full md:flex-1 h-4 bg-gray-600 rounded-full overflow-hidden relative">
                    <div class="h-full bg-green-400 transition-all duration-300"></div>
                </div>
                <div class="text-white text-sm font-semibold hidden md:block">
                    <!-- الوقت المتبقي -->
                </div>
                <button @click="endQuiz" class="bg-red-500 px-4 py-2 rounded-full text-white hover:bg-red-600 w-full md:w-auto">
                    End Quiz
                </button>
            </div>
        </div>
    </header>
</template>

<style scoped>

</style>
