<!-- DELETE ACCOUNT FORM -->
<section x-data="deleteAccountForm()" class="space-y-6">
    <template x-if="success">
        <p class="text-green-600 text-sm" x-text="success"></p>
    </template>

    <template x-if="error">
        <p class="text-red-600 text-sm" x-text="error"></p>
    </template>

    <button @click="showConfirmModal = true" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Delete Account</button>

    <div x-show="showConfirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg w-96">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                Are you sure you want to delete your account?
            </h2>
            <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">
                This action cannot be undone. Please enter your password to confirm.
            </p>

            <input type="password" x-model="password"
                placeholder="Enter your password"
                class="w-full border px-3 py-2 rounded dark:bg-gray-700 dark:text-white" />

            <div class="flex justify-end mt-4 space-x-2">
                <button @click="showConfirmModal = false"
                    class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                <button @click="deleteAccount()"
                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Confirm Delete</button>
            </div>
        </div>
    </div>
</section>
