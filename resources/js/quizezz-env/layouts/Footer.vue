<!--resources/quizezz-env/components/Footer.vue-->
<script setup lang="ts">

</script>

<template>
    <footer class="bg-black text-white p-4 rounded-t-xl shadow-lg">
        <div class="flex flex-wrap items-center justify-between gap-2">
            <!-- Left Buttons -->
            <div class="flex flex-wrap gap-2">
                <button @click="showPopup = true" class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600">⚙</button>
                <button class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600">🔲</button>
                <button @click="showHelp = true" class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600">❓</button>
                <button @click="showCalculator = true" class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600">🖩</button>
            </div>

            <!-- Right Buttons -->
            <div class="flex flex-wrap gap-2">
                <button class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600">💬</button>
                <button class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600">🚩</button>
                <button @click="prevQuestion" class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600">Back</button>
                <button @click="nextQuestion" class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600">Next</button>
            </div>

            <!-- Collapsed Menu for Small Screens -->
            <div class="block sm:hidden">
                <button @click="showMore = !showMore" class="bg-green-700 px-3 py-2 rounded-full">☰</button>
                <div v-if="showMore" class="mt-2 space-y-2">
                    <div class="flex flex-wrap gap-2">
                        <button class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600">⚙</button>
                        <button class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600">🔲</button>
                        <button class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600">❓</button>
                        <button class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600">🖩</button>
                        <button class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600">💬</button>
                        <button class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600">🚩</button>
                        <button class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600">Back</button>
                        <button class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600">Next</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Modal -->
        <div v-if="showPopup" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-md w-96 text-black">
                <h3 class="text-xl font-semibold mb-4">Settings</h3>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" v-model="isDarkMode" @change="toggleDarkMode" class="h-5 w-5" />
                    <span>Enable Dark Mode</span>
                </label>
                <button class="bg-red-500 px-4 py-2 rounded text-white hover:bg-red-600 mt-4 w-full" @click="showPopup = false">Close</button>
            </div>
        </div>

        <!-- Help Modal -->
        <div v-if="showHelp" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-md w-96 text-black">
                <h3 class="text-xl font-semibold mb-4">Help</h3>
                <p class="mb-4">Answer each question carefully. You can mark and revisit.</p>
                <button class="bg-red-500 px-4 py-2 rounded text-white hover:bg-red-600 mt-4 w-full" @click="showHelp = false">Close</button>
            </div>
        </div>
    </footer>
</template>

<style scoped>

</style>
