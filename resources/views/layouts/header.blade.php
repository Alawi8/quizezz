<nav class="bg-green-500 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700"
     x-data
     x-init="$store.userAuth.init()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="/">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                </a>
            </div>

            <!-- Auth Section -->
            <div class="flex items-center space-x-4 text-sm">
                <!-- Logged in -->
                <template x-if="$store.userAuth.user">
                    <div class="flex items-center space-x-3">
                        <span class="text-white font-semibold" x-text="$store.userAuth.user.name"></span>

                        <button @click="$store.userAuth.logout()" class="text-red-100 hover:text-white bg-red-600 px-3 py-1 rounded">
                            Logout
                        </button>
                    </div>
                </template>

                <!-- Guest -->
                <template x-if="!$store.userAuth.user">
                    <div class="flex items-center space-x-3">
                        <a href="/login" class="text-white hover:underline">Login</a>
                        <a href="/register" class="text-white hover:underline">Register</a>
                    </div>
                </template>
            </div>
        </div>
    </div>
</nav>
