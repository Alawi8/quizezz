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
           <div id="auth-nav"></div>

        </div>
    </div>
</nav>
