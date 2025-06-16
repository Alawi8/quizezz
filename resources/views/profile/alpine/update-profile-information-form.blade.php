<!-- UPDATE PROFILE INFO FORM -->
<section x-data="infoForm()" x-init="init()" class="space-y-6">
    <template x-if="success">
        <p class="text-green-600 text-sm" x-text="success"></p>
    </template>

    <template x-if="error">
        <p class="text-red-600 text-sm" x-text="error"></p>
    </template>

    <form @submit.prevent="updateProfile" class="space-y-6">
        <div>
            <label for="name" class="block font-medium text-sm text-gray-700 dark:text-white">Name</label>
            <input type="text" id="name" x-model="name" class="w-full mt-1 border rounded p-2 dark:bg-gray-800 dark:text-white" required>
        </div>

        <div>
            <label for="email" class="block font-medium text-sm text-gray-700 dark:text-white">Email</label>
            <input type="email" id="email" x-model="email" class="w-full mt-1 border rounded p-2 dark:bg-gray-800 dark:text-white" required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
    </form>
</section>
