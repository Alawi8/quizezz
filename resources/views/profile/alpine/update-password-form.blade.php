<!-- UPDATE PASSWORD FORM -->
<section x-data="updatePasswordForm()" class="space-y-6">
    <template x-if="success">
        <p class="text-green-600 text-sm" x-text="success"></p>
    </template>

    <template x-if="error">
        <p class="text-red-600 text-sm" x-text="error"></p>
    </template>

    <form @submit.prevent="updatePassword" class="space-y-6">
        <div>
            <label for="current_password" class="block font-medium text-sm text-gray-700 dark:text-white">Current Password</label>
            <input type="password" id="current_password" x-model="current_password" class="w-full mt-1 border rounded p-2 dark:bg-gray-800 dark:text-white" autocomplete="current-password">
        </div>

        <div>
            <label for="password" class="block font-medium text-sm text-gray-700 dark:text-white">New Password</label>
            <input type="password" id="password" x-model="password" class="w-full mt-1 border rounded p-2 dark:bg-gray-800 dark:text-white" autocomplete="new-password">
        </div>

        <div>
            <label for="password_confirmation" class="block font-medium text-sm text-gray-700 dark:text-white">Confirm Password</label>
            <input type="password" id="password_confirmation" x-model="password_confirmation" class="w-full mt-1 border rounded p-2 dark:bg-gray-800 dark:text-white" autocomplete="new-password">
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Save</button>
    </form>
</section>
