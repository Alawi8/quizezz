<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            ⚙️ System Settings
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto py-10 px-6 space-y-12"
         x-data="adminQuizManager()" x-init="init()">

        <!-- ✅ Flash Alert -->
        <template x-if="systemSettings.flashMessage">
            <div
                class="border px-4 py-3 rounded transition"
                :class="systemSettings.flashType === 'success' 
                         ? 'bg-green-100 border-green-400 text-green-700' 
                         : 'bg-red-100 border-red-400 text-red-700'"
            >
                <span x-text="systemSettings.flashMessage"></span>
            </div>
        </template>

        <!-- 🛠️ System Info -->
        <div class="bg-white dark:bg-gray-900 border rounded-lg shadow p-6 space-y-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">🛠️ System Info</h3>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">System Name</label>
                <input type="text"
                       x-model="systemSettings.settings.system_name"
                       placeholder="Enter system name"
                       class="w-full border px-3 py-2 rounded dark:bg-gray-800 dark:text-white">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">System Description</label>
                <textarea rows="3"
                          x-model="systemSettings.settings.system_description"
                          placeholder="Enter system description"
                          class="w-full border px-3 py-2 rounded dark:bg-gray-800 dark:text-white"></textarea>
            </div>

            <div class="text-right">
                <button @click="systemSettings.saveSystemInfo()"
                        class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
                    💾 Save Settings
                </button>
            </div>
        </div>

        <!-- 🌙 Dark Mode Toggle -->
        <div class="bg-white dark:bg-gray-900 border rounded-lg shadow p-6 space-y-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">🌙 Dark Mode</h3>

            <div class="flex items-center justify-between">
                <span class="text-gray-700 dark:text-gray-300">
                    Enable or disable dark mode for all users
                </span>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer"
                           x-model="systemSettings.settings.dark_mode_enabled">
                    <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 rounded-full peer-checked:bg-blue-600 relative">
                        <span class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition peer-checked:translate-x-5"></span>
                    </div>
                </label>
            </div>
        </div>

        <!-- 📥 Import Questions -->
        <div class="bg-white dark:bg-gray-900 border rounded-lg shadow p-6 space-y-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">📥 Import Questions</h3>

            <div>
                <input type="file"
                       @change="systemSettings.handleFileUpload($event, 'questions')"
                       accept=".csv,.xlsx"
                       class="w-full border px-3 py-2 rounded dark:bg-gray-800 dark:text-white">
            </div>

            <div class="text-right">
                <button @click="systemSettings.uploadFile('questions')"
                        class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
                    ⬆️ Upload & Import
                </button>
            </div>
        </div>

        <!-- 🗑️ Delete All Questions -->
        <div class="bg-white dark:bg-gray-900 border border-red-500 rounded-lg shadow p-6 space-y-4">
            <h3 class="text-lg font-semibold text-red-600">🗑️ Delete All Questions</h3>
            <p class="text-sm text-gray-700 dark:text-gray-300">
                This will permanently delete all questions. This action cannot be undone.
            </p>
            <div class="text-right">
                <button @click="systemSettings.deleteAll('questions')"
                        class="bg-red-600 text-white px-5 py-2 rounded hover:bg-red-700 transition">
                    Delete All Questions
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
