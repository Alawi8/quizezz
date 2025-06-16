<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- ✅ أضف Alpine.js هنا -->
    <div class="py-12" x-data="adminQuizManager()" x-init="sectionManager.fetchCounts()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- ✅ الإحصائيات -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6 text-center">
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Users</p>
                    <h3 class="text-3xl font-bold text-gray-800 dark:text-white" x-text="sectionManager.totalUsers">0</h3>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6 text-center">
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Sections</p>
                    <h3 class="text-3xl font-bold text-gray-800 dark:text-white" x-text="sectionManager.totalQuestions">0</h3>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6 text-center">
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Tests</p>
                    <h3 class="text-3xl font-bold text-gray-800 dark:text-white" x-text="sectionManager.totalTests">0</h3>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6 text-center">
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Answers</p>
                    <h3 class="text-3xl font-bold text-gray-800 dark:text-white" x-text="sectionManager.totalAnswers">0</h3>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
