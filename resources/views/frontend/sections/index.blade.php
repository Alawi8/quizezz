<div x-data="chooseSections" x-init="init()">
    <template x-if="loading">
        <p class="text-gray-500">Loading...</p>
    </template>

    <template x-if="errorMessage">
        <p class="text-red-600" x-text="errorMessage"></p>
    </template>


    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <template x-if="tests.length > 0">
            <template x-for="test in tests" :key="test.id">
                <div
                    class="bg-white border border-gray-200 rounded-2xl shadow p-6 flex flex-col justify-between transition hover:shadow-lg">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800" x-text="test.title"></h2>
                        <p class="text-sm text-gray-600 mt-2"
                            x-text="test.description || 'No description available.'"></p>
                    </div>
                    <!-- Conditional Start Quiz Button -->
                    <button class="mt-4 text-white font-medium py-2 px-4 rounded-2xl transition"
                        :class="test.questions_count > 0 ?
                            'bg-green-500 hover:bg-green-600 cursor-pointer' :
                            'bg-green-200  cursor-not-allowed'"
                        :disabled="test.questions_count === 0"
                        @click="test.questions_count > 0 && loadQuestions(test.id)">
                        Start Quiz
                    </button>
                </div>
            </template>
        </template>
    </div>
</div>
