<x-app-layout>
    <div x-data="adminQuizManager" x-init="userManager.fetchUsers();
    userManager.fetchRoles()" x-cloak class="max-w-6xl mx-auto p-6 space-y-8">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Users Management') }}
            </h2>
        </x-slot>

        <!-- ✅ زر إظهار / إخفاء نموذج الإضافة -->
        <div class="text-right">
            <button @click="userManager.showForm = !userManager.showForm"
                class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                <span x-show="!userManager.showForm">➕ Add User</span>
                <span x-show="userManager.showForm">❌ Hide Form</span>
            </button>
        </div>

        <!-- ✅ نموذج إضافة مستخدم جديد -->
        <div x-show="userManager.showForm" class="bg-white border rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-xl font-bold text-gray-800">Add New User</h2>

            <!-- 🔴 Error messages -->
            <div x-show="userManager.errors.length"
                class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded space-y-1" role="alert">
                <template x-for="error in userManager.errors" :key="error">
                    <div class="text-sm" x-text="error"></div>
                </template>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" x-model="userManager.newUser.name" class="w-full border px-4 py-2 rounded"
                    placeholder="Name">

                <input type="email" x-model="userManager.newUser.email" class="w-full border px-4 py-2 rounded"
                    placeholder="Email">

                <input type="password" x-model="userManager.newUser.password" class="w-full border px-4 py-2 rounded"
                    placeholder="Password">

                <select x-model="userManager.newUser.role" class="w-full border px-4 py-2 rounded">
                    <option value="">Select Role</option>
                    <template x-for="role in userManager.availableRoles" :key="role">
                        <option :value="role" x-text="role"></option>
                    </template>
                </select>
            </div>

            <div class="text-right">
                <button @click="userManager.addUser()"
                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    Save User
                </button>
            </div>
        </div>


        <!-- ✅ قائمة المستخدمين -->
        <div class="space-y-6">
            <template x-for="user in userManager.users" :key="user.id">
                <div class="bg-white border rounded-lg shadow-sm p-5 space-y-4">
                    <div class="flex flex-col md:flex-row justify-between md:items-center space-y-2 md:space-y-0">
                        <div class="flex-1 space-y-1">
                            <h3 class="text-lg font-semibold text-gray-800" x-text="user.name"></h3>
                            <p class="text-sm text-gray-600" x-text="user.email"></p>
                            <p class="text-xs text-gray-500">
                                Role:
                                <span class="inline-block px-2 py-0.5 bg-indigo-100 text-indigo-700 rounded"
                                    x-text="user.roles.length ? user.roles[0].name : 'None'"></span>
                            </p>
                        </div>

                        <div class="flex gap-2 flex-wrap items-center">
                            <select class="border px-3 py-1 rounded"
                                @change="userManager.changeRole(user, $event.target.value)">
                                <option value="">Change Role</option>
                                <template x-for="role in userManager.availableRoles" :key="role">
                                    <option :value="role" x-text="role"></option>
                                </template>
                            </select>

                            <button @click="userManager.confirmDelete(user)"
                                class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700 transition">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- ✅ تأكيد الحذف -->
        <div x-show="userManager.deletingUser" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
            style="backdrop-filter: blur(2px);">
            <div class="bg-white rounded-lg p-6 w-full max-w-md space-y-4">
                <h2 class="text-lg font-bold text-red-600">Delete User?</h2>
                <p class="text-gray-700">Are you sure you want to delete this user? This action is permanent.</p>
                <div class="flex justify-end gap-3">
                    <button @click="userManager.deletingUser = null"
                        class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
                        Cancel
                    </button>
                    <button @click="userManager.deleteConfirmed()"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        Confirm Delete
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
