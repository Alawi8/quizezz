<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Questions') }}
        </h2>
    </x-slot>

    <div x-data="adminQuizManager" x-init="sectionManager.fetchTests();
    questionManager.fetchQuestions();" class="max-w-6xl mx-auto p-6 space-y-8">

        <!-- ✅ Flash Message -->
        <div x-show="questionManager.flashMessage" x-transition
            :class="{
                'bg-green-100 border-green-400 text-green-700': questionManager.flashType === 'success',
                'bg-red-100 border-red-400 text-red-700': questionManager.flashType === 'error'
            }"
            class="border px-4 py-3 rounded relative">
            <span class="font-bold" x-text="questionManager.flashType === 'success' ? '✔️' : '⚠️'"></span>
            <span x-text="questionManager.flashMessage" class="ml-2"></span>
            <button @click="questionManager.flashMessage = null"
                class="absolute top-0 bottom-0 right-0 px-4 py-3 text-xl">&times;</button>
        </div>

        <!-- ✅ Top Controls -->
        <div class="flex flex-wrap justify-between items-center gap-4">
            <!-- ✅ Filter -->
            <select x-model="questionManager.selectedTestId"
                @change="questionManager.filterByTest(questionManager.selectedTestId)"
                class="border border-gray-300 rounded px-3 py-2 w-64">
                <option value="">All Tests</option>
                <template x-for="section in sectionManager.tests" :key="section.id">
                    <option :value="section.id" x-text="section.title"></option>
                </template>
            </select>

            <div class="flex items-center gap-2">
                <button @click="questionManager.toggleForm()"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    <span x-text="questionManager.showForm ? '➖' : '➕ '"></span>
                </button>

                <button @click="questionManager.deleteAllQuestions()"
                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    🗑️
                </button>
            </div>
        </div>

        <!-- ✅ Add Question Form -->
        <div x-show="questionManager.showForm" x-transition class="bg-white p-6 border rounded-lg shadow space-y-6">
            <h2 class="text-xl font-semibold text-gray-800">📝 New Question</h2>

            <input type="text" x-model="questionManager.newQuestion.question_text"
                class="w-full border border-gray-300 px-4 py-2 rounded" placeholder="Enter question text">

            <select x-model="questionManager.newQuestion.test_id"
                class="w-full border border-gray-300 px-4 py-2 rounded">
                <option value="">Select Test</option>
                <template x-for="section in sectionManager.tests" :key="section.id">
                    <option :value="section.id" x-text="section.title"></option>
                </template>
            </select>

            <div class="space-y-3">
                <template x-for="(ans, index) in questionManager.newQuestion.answers" :key="index">
                    <div class="flex items-center gap-2">
                        <input type="text" x-model="ans.answer_text" class="w-full border px-3 py-2 rounded"
                            placeholder="Answer option">
                        <label class="flex items-center gap-1 text-sm text-gray-600">
                            <input type="radio" name="correctAnswer" :value="index"
                                @change="questionManager.setCorrect(index)" :checked="ans.is_correct">
                            Correct
                        </label>
                        <button @click="questionManager.removeAnswer(index)"
                            class="text-red-500 hover:underline text-sm">Remove</button>
                    </div>
                </template>
                <button @click="questionManager.addAnswer()" class="text-blue-600 text-sm hover:underline">+ Add
                    Answer</button>
            </div>

            <div class="text-right">
                <button @click="questionManager.addQuestion()"
                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Save Question
                </button>
            </div>
        </div>

        <!-- ✅ Questions List -->
        <div class="space-y-4">
            <template x-for="q in questionManager.questions" :key="q.id">
                <div class="bg-white border rounded-lg shadow-sm p-5 space-y-4">
                    <!-- Preview Mode -->
                    <div class="flex justify-between items-start" x-show="questionManager.editingQuestion !== q.id">
                        <div class="space-y-1">
                            <h3 class="text-lg font-semibold text-gray-800" x-text="q.question_text"></h3>
                            <p class="text-sm text-gray-500">Test: <span class="font-semibold"
                                    x-text="q.test?.title ?? '—'"></span></p>

                            <ul class="list-disc pl-6 text-sm text-gray-700">
                                <template x-for="ans in q.answers.filter(a => a && a.answer_text)">
                                    <li :class="ans.is_correct ? 'text-green-600 font-bold' : ''"
                                        x-text="ans.answer_text"></li>
                                </template>
                            </ul>
                        </div>

                        <div class="flex gap-2 flex-wrap">
                            <button @click="questionManager.edit(q)"
                                class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 text-sm">Edit</button>
                            <button @click="questionManager.confirmDelete(q)"
                                class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">Delete</button>
                        </div>
                    </div>

                    <!-- Edit Mode -->
                    <template x-if="questionManager.editingQuestion === q.id">
                        <div class="border-t pt-4 mt-4 space-y-4">
                            <input type="text" x-model="questionManager.newQuestion.question_text"
                                class="w-full border border-gray-300 px-4 py-2 rounded"
                                placeholder="Edit question text">

                            <select x-model="questionManager.newQuestion.test_id"
                                class="w-full border border-gray-300 px-4 py-2 rounded">
                                <option value="">Select Test</option>
                                <template x-for="section in sectionManager.tests" :key="section.id">
                                    <option :value="section.id" x-text="section.title"></option>
                                </template>
                            </select>

                            <div class="space-y-3">
                                <template x-for="(ans, index) in questionManager.newQuestion.answers"
                                    :key="index">
                                    <div class="flex items-center gap-2">
                                        <input type="text" x-model="ans.answer_text"
                                            class="w-full border px-3 py-2 rounded" placeholder="Answer option">
                                        <label class="flex items-center gap-1 text-sm text-gray-600">
                                            <input type="radio" name="correctAnswerEdit" :value="index"
                                                @change="questionManager.setCorrect(index)" :checked="ans.is_correct">
                                            Correct
                                        </label>
                                        <button @click="questionManager.removeAnswer(index)"
                                            class="text-red-500 hover:underline text-sm">Remove</button>
                                    </div>
                                </template>
                                <button @click="questionManager.addAnswer()"
                                    class="text-blue-600 text-sm hover:underline">+ Add Answer</button>
                            </div>

                            <div class="flex justify-end gap-2">
                                <button @click="questionManager.resetForm()"
                                    class="bg-gray-200 text-gray-800 px-4 py-1 rounded hover:bg-gray-300">
                                    Cancel
                                </button>
                                <button @click="questionManager.updateQuestion()"
                                    class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                                    Update Question
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </template>

            <!-- ✅ Pagination -->
            <div class="flex justify-between items-center mt-6">
                <button @click="questionManager.prevPage()" :disabled="questionManager.currentPage === 1"
                    class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50">
                    ⬅️ Previous
                </button>
                <span class="text-sm text-gray-600">
                    Page <span x-text="questionManager.currentPage"></span> of <span
                        x-text="questionManager.lastPage"></span>
                </span>
                <button @click="questionManager.nextPage()"
                    :disabled="questionManager.currentPage === questionManager.lastPage"
                    class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50">
                    Next ➡️
                </button>
            </div>
        </div>

        <!-- ✅ Confirm Delete Dialog -->
        <div x-show="questionManager.deletingQuestion"
            class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center"
            style="backdrop-filter: blur(2px);">
            <div class="bg-white rounded-lg p-6 shadow-lg w-full max-w-md space-y-4">
                <h2 class="text-lg font-bold text-red-600">Delete Question?</h2>
                <p class="text-gray-700 text-sm">Are you sure you want to delete this question? This action cannot be
                    undone.</p>

                <div class="flex justify-end gap-3">
                    <button @click="questionManager.deletingQuestion = null"
                        class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
                        Cancel
                    </button>
                    <button @click="questionManager.deleteConfirmed()"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        Confirm Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
