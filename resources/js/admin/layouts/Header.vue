<template>
    <header class="relative bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 text-white w-full px-4 py-3 shadow-2xl">
        <!-- Background overlay -->
        <div class="absolute inset-0 bg-black/5"></div>
        
        <div class="relative z-10 flex items-center justify-between">
            <!-- Left Section - Settings -->
            <div class="flex items-center gap-3">
                <button 
                    @click.stop="showSettings = !showSettings" 
                    class="group p-2.5 rounded-xl bg-white/10 hover:bg-white/20 transition-all duration-300 hover:scale-105 border border-white/20"
                >
                    <Settings class="w-5 h-5 transition-transform duration-300" :class="{ 'rotate-90': showSettings }" />
                </button>

                <button class="group p-2.5 rounded-xl bg-white/10 hover:bg-white/20 transition-all duration-300 hover:scale-105 border border-white/20">
                    <Search class="w-5 h-5" />
                </button>
            </div>

            <!-- Center Navigation -->
            <nav class="flex items-center gap-2">
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center gap-2">
                    <a
                        href="/" 
                        class="group relative bg-white/15 px-4 py-2.5 rounded-xl hover:bg-white/25 transition-all duration-300 hover:scale-105"
                    >
                        <Home class="w-5 h-5" />
                    </a>

                    <button class="group relative bg-white/15 px-4 py-2.5 rounded-xl hover:bg-white/25 transition-all duration-300 hover:scale-105">
                        <HelpCircle class="w-5 h-5" />
                    </button>

                    <button class="group relative bg-white/15 px-4 py-2.5 rounded-xl hover:bg-white/25 transition-all duration-300 hover:scale-105">
                        <Folder class="w-5 h-5" />
                    </button>

                    <button class="group relative bg-white/15 px-4 py-2.5 rounded-xl hover:bg-white/25 transition-all duration-300 hover:scale-105">
                        <User class="w-5 h-5" />
                    </button>
                </div>

                <!-- Mobile Dropdown -->
                <div class="relative md:hidden" ref="moreRef">
                    <button 
                        @click.stop="showMoreIcons = !showMoreIcons"
                        class="p-2.5 rounded-xl bg-white/15 hover:bg-white/25 transition-all duration-300 border border-white/20"
                    >
                        <span class="text-lg">⋯</span>
                    </button>
                    
                    <div 
                        v-if="showMoreIcons"
                        class="absolute top-12 right-0 bg-white text-gray-800 p-3 rounded-xl shadow-2xl border min-w-[180px] z-50"
                    >
                        <button class="flex items-center gap-3 w-full p-2 rounded-lg hover:bg-gray-100 transition-colors text-left">
                            <Home class="w-4 h-4 text-green-600" /> 
                            <span>Home</span>
                        </button>
                        <button class="flex items-center gap-3 w-full p-2 rounded-lg hover:bg-gray-100 transition-colors text-left">
                            <HelpCircle class="w-4 h-4 text-green-600" /> 
                            <span>Help</span>
                        </button>
                        <button class="flex items-center gap-3 w-full p-2 rounded-lg hover:bg-gray-100 transition-colors text-left">
                            <Folder class="w-4 h-4 text-green-600" /> 
                            <span>Folders</span>
                        </button>
                        <button class="flex items-center gap-3 w-full p-2 rounded-lg hover:bg-gray-100 transition-colors text-left">
                            <User class="w-4 h-4 text-green-600" /> 
                            <span>Users</span>
                        </button>
                    </div>
                </div>
            </nav>

            <!-- Right Section - Notifications & Menu -->
            <div class="flex items-center gap-3">
                <!-- Notifications -->
                <div class="relative" ref="notificationsRef">
                    <button 
                        @click.stop="showNotifications = !showNotifications"
                        class="group relative p-2.5 rounded-xl bg-white/10 hover:bg-white/20 transition-all duration-300 hover:scale-105 border border-white/20"
                    >
                        <Bell class="w-5 h-5" />
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                    </button>

                    <div 
                        v-if="showNotifications"
                        class="absolute top-12 right-0 bg-white text-gray-800 p-4 rounded-xl shadow-2xl border w-80 z-50"
                    >
                        <h3 class="font-bold text-lg mb-3">Notifications</h3>
                        <div class="space-y-3">
                            <div class="p-3 bg-blue-50 rounded-lg border-r-4 border-blue-400">
                                <p class="text-sm font-medium">New Notification</p>
                                <p class="text-xs text-gray-600 mt-1">A new question has been added</p>
                            </div>
                            <div class="p-3 bg-green-50 rounded-lg border-r-4 border-green-400">
                                <p class="text-sm font-medium">New User</p>
                                <p class="text-xs text-gray-600 mt-1">A new user joined the platform</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Toggle -->
                <button 
                    @click.stop="showSidebar = !showSidebar" 
                    class="group p-2.5 rounded-xl bg-white/10 hover:bg-white/20 transition-all duration-300 hover:scale-105 border border-white/20"
                >
                    <Menu class="w-5 h-5 transition-transform duration-300" :class="{ 'rotate-90': showSidebar }" />
                </button>
            </div>
        </div>
    </header>

    <!-- Sidebar Menu (Right) -->
    <div v-if="showSidebar" class="fixed inset-0 z-50">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/50" @click="closeAllMenus"></div>
        
        <!-- Sidebar -->
        <div 
            ref="sidebarRef"
            class="absolute top-0 right-0 h-full w-80 bg-white shadow-2xl transform transition-transform duration-300"
            :class="{ 'translate-x-0': showSidebar, 'translate-x-full': !showSidebar }"
        >
            <!-- Header -->
            <div class="bg-gradient-to-r from-emerald-600 to-green-600 p-6 text-white">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold flex items-center gap-3">
                        <Menu class="w-6 h-6" />
                        Main Menu
                    </h2>
                    <button @click="closeAllMenus" class="p-2 rounded-lg hover:bg-white/20 transition-colors">
                        <X class="w-5 h-5" />
                    </button>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="p-6 space-y-2">
                <router-link
                    to="/admin/dashboard"
                    class="group flex items-center gap-4 p-4 rounded-xl text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-all duration-300"
                    @click="closeAllMenus"
                >
                    <div class="p-2 bg-emerald-100 text-emerald-600 rounded-lg">
                        <Home class="w-5 h-5" />
                    </div>
                    <span class="font-medium">Dashboard</span>
                </router-link>

                <router-link
                    to="/admin/dashboard/questions"
                    class="group flex items-center gap-4 p-4 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-300"
                    @click="closeAllMenus"
                >
                    <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                        <HelpCircle class="w-5 h-5" />
                    </div>
                    <span class="font-medium">Questions</span>
                </router-link>

                <router-link
                    to="/admin/dashboard/sections"
                    class="group flex items-center gap-4 p-4 rounded-xl text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-all duration-300"
                    @click="closeAllMenus"
                >
                    <div class="p-2 bg-purple-100 text-purple-600 rounded-lg">
                        <Folder class="w-5 h-5" />
                    </div>
                    <span class="font-medium">Sections</span>
                </router-link>

                <router-link
                    to="/admin/dashboard/users"
                    class="group flex items-center gap-4 p-4 rounded-xl text-gray-700 hover:bg-orange-50 hover:text-orange-700 transition-all duration-300"
                    @click="closeAllMenus"
                >
                    <div class="p-2 bg-orange-100 text-orange-600 rounded-lg">
                        <User class="w-5 h-5" />
                    </div>
                    <span class="font-medium">Users</span>
                </router-link>

                <router-link
                    to="/admin/dashboard/settings"
                    class="group flex items-center gap-4 p-4 rounded-xl text-gray-700 hover:bg-gray-50 hover:text-gray-700 transition-all duration-300"
                    @click="closeAllMenus"
                >
                    <div class="p-2 bg-gray-100 text-gray-600 rounded-lg">
                        <Settings class="w-5 h-5" />
                    </div>
                    <span class="font-medium">Settings</span>
                </router-link>
            </div>

            <!-- Footer -->
            <div class="absolute bottom-0 left-0 right-0 p-6 border-t">
                <button class="flex items-center gap-3 w-full p-3 rounded-xl text-red-600 hover:bg-red-50 transition-all duration-300">
                    <LogOut class="w-5 h-5" />
                    <span class="font-medium">Logout</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Settings Panel (Left) -->
    <div v-if="showSettings" class="fixed inset-0 z-50">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/50" @click="closeAllMenus"></div>
        
        <!-- Settings Panel -->
        <div 
            ref="settingsRef"
            class="absolute top-0 left-0 h-full w-80 bg-white shadow-2xl transform transition-transform duration-300"
            :class="{ 'translate-x-0': showSettings, '-translate-x-full': !showSettings }"
        >
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold flex items-center gap-3">
                        <Settings class="w-6 h-6" />
                        Settings
                    </h2>
                    <button @click="closeAllMenus" class="p-2 rounded-lg hover:bg-white/20 transition-colors">
                        <X class="w-5 h-5" />
                    </button>
                </div>
            </div>

            <!-- Settings Content -->
            <div class="p-6 space-y-6">
                <!-- Theme Settings -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800">Appearance</h3>
                    
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <label class="flex items-center justify-between cursor-pointer">
                            <div class="flex items-center gap-3">
                                <Moon class="w-5 h-5 text-gray-600" />
                                <span class="font-medium text-gray-700">Dark Mode</span>
                            </div>
                            <input 
                                type="checkbox" 
                                v-model="darkMode" 
                                class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500"
                            >
                        </label>
                    </div>
                </div>

                <!-- Language Settings -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800">Language</h3>
                    
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <button class="flex items-center justify-between w-full p-3 rounded-lg hover:bg-white transition-colors">
                            <div class="flex items-center gap-3">
                                <Globe class="w-5 h-5 text-gray-600" />
                                <span class="font-medium text-gray-700">English</span>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800">Notifications</h3>
                    
                    <div class="bg-gray-50 p-4 rounded-xl space-y-3">
                        <label class="flex items-center justify-between cursor-pointer">
                            <div class="flex items-center gap-3">
                                <Bell class="w-5 h-5 text-gray-600" />
                                <span class="font-medium text-gray-700">Enable Notifications</span>
                            </div>
                            <input 
                                type="checkbox" 
                                checked 
                                class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500"
                            >
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import {
    Home,
    HelpCircle,
    Folder,
    Settings,
    User,
    Menu,
    Bell,
    Search,
    Moon,
    Globe,
    LogOut,
    X
} from 'lucide-vue-next'

// State
const showSidebar = ref(false)
const showSettings = ref(false)
const showMoreIcons = ref(false)
const showNotifications = ref(false)
const darkMode = ref(false)

// Refs
const sidebarRef = ref(null)
const settingsRef = ref(null)
const moreRef = ref(null)
const notificationsRef = ref(null)

// Methods
function closeAllMenus() {
    showSidebar.value = false
    showSettings.value = false
    showMoreIcons.value = false
    showNotifications.value = false
}

function handleClickOutside(event) {
    const sidebar = sidebarRef.value
    const settings = settingsRef.value
    const more = moreRef.value
    const notifications = notificationsRef.value
    
    if (
        (showSidebar.value && sidebar && !sidebar.contains(event.target)) ||
        (showSettings.value && settings && !settings.contains(event.target)) ||
        (showMoreIcons.value && more && !more.contains(event.target)) ||
        (showNotifications.value && notifications && !notifications.contains(event.target))
    ) {
        closeAllMenus()
    }
}

// Lifecycle
onMounted(() => {
    document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside)
})
</script>

<style scoped>
/* Smooth transitions */
.transform {
    transition: transform 0.3s ease-in-out;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(45deg, #10b981, #059669);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(45deg, #059669, #047857);
}
</style>