<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import {
    Home,
    HelpCircle,
    Folder,
    Settings,
    User,
    Menu,
    BookOpen,
    FileText
} from 'lucide-vue-next'

const showSidebar = ref(false)
const showSettings = ref(false)
const showMoreIcons = ref(false)

const sidebarRef = ref(null)
const settingsRef = ref(null)
const moreRef = ref(null)

function closeAllMenus() {
    showSidebar.value = false
    showSettings.value = false
    showMoreIcons.value = false
}

function handleClickOutside(event) {
    const sidebar = sidebarRef.value
    const settings = settingsRef.value
    const more = moreRef.value
    if (
        (showSidebar.value && sidebar && !sidebar.contains(event.target)) ||
        (showSettings.value && settings && !settings.contains(event.target)) ||
        (showMoreIcons.value && more && !more.contains(event.target))
    ) {
        closeAllMenus()
    }
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside)
})
</script>

<template>
    <header class="bg-green-700 text-white w-full px-4 py-3 flex items-center justify-between shadow-md">

        <!-- Settings Icon (Left) -->
        <button @click.stop="showSettings = !showSettings" class="p-2 rounded-full hover:bg-green-800">
            <Settings class="w-6 h-6" />
        </button>

        <!-- Center Icons Row -->
        <nav class="flex flex-wrap justify-center items-center gap-2">
            <a href="/" class="bg-white text-green-700 px-3 py-1.5 rounded-full hover:bg-green-100">
                <Home class="w-5 h-5" />
            </a>

            <button class="bg-white text-green-700 px-3 py-1.5 rounded-full hover:bg-green-100">
                <HelpCircle class="w-5 h-5" />
            </button>
            <button class="bg-white text-green-700 px-3 py-1.5 rounded-full hover:bg-green-100">
                <Folder class="w-5 h-5" />
            </button>
            <button class="bg-white text-green-700 px-3 py-1.5 rounded-full hover:bg-green-100">
                <Settings class="w-5 h-5" />
            </button>
            <button class="bg-white text-green-700 px-3 py-1.5 rounded-full hover:bg-green-100">
                <User class="w-5 h-5" />
            </button>

            <!-- More Icons Dropdown -->
            <div class="relative md:hidden" ref="moreRef">
                <button @click.stop="showMoreIcons = !showMoreIcons"
                        class="bg-green-600 text-white px-3 py-1.5 rounded-full hover:bg-green-700">
                    ⋯
                </button>
                <div v-if="showMoreIcons"
                     class="absolute top-10 left-0 bg-white text-green-700 p-2 rounded-md shadow-lg space-y-1">
                    <button class="flex items-center gap-2 hover:text-green-800">
                        <BookOpen class="w-4 h-4" /> More 1
                    </button>
                    <button class="flex items-center gap-2 hover:text-green-800">
                        <FileText class="w-4 h-4" /> More 2
                    </button>
                </div>
            </div>
        </nav>

        <!-- Sidebar Toggle (Right) -->
        <button @click.stop="showSidebar = !showSidebar" class="p-2 rounded-full hover:bg-green-800">
            <Menu class="w-6 h-6" />
        </button>
    </header>

    <!-- Sidebar Menu (Right) -->
    <div v-if="showSidebar" ref="sidebarRef"
         class="fixed top-0 right-0 h-full w-64 bg-green-700 text-white shadow-lg z-50 p-4">
        <h2 class="text-lg font-bold mb-4 flex items-center gap-2"><Menu class="w-5 h-5" /> Menu</h2>
        <ul class="space-y-2">
            <li>
                <router-link
                    to="/admin/dashboard"
                    class="flex items-center gap-2 hover:text-white"
                    @click="closeAllMenus"
                >
                    <Home class="w-4 h-4" /> Dashboard
                </router-link>
            </li>
            <li>
                <router-link
                    to="/admin/dashboard/questions"
                    class="flex items-center gap-2 hover:text-white"
                    @click="closeAllMenus"
                >
                    <HelpCircle class="w-4 h-4" /> Questions
                </router-link>
            </li>
            <li>
                <router-link
                    to="/admin/dashboard/sections"
                    class="flex items-center gap-2 hover:text-white"
                    @click="closeAllMenus"
                >
                    <Folder class="w-4 h-4" /> Sections
                </router-link>
            </li>
            <li>
                <router-link
                    to="/admin/dashboard/users"
                    class="flex items-center gap-2 hover:text-white"
                    @click="closeAllMenus"
                >
                    <User class="w-4 h-4" /> Users
                </router-link>
            </li>
            <li>
                <router-link
                    to="/admin/dashboard/settings"
                    class="flex items-center gap-2 hover:text-white"
                    @click="closeAllMenus"
                >
                    <Settings class="w-4 h-4" /> Settings
                </router-link>
            </li>
        </ul>

        <button @click="closeAllMenus" class="mt-4 text-sm text-white hover:underline">Close</button>
    </div>

    <!-- Settings Panel (Left) -->
    <div v-if="showSettings" ref="settingsRef"
         class="fixed top-0 left-0 h-full w-64 bg-green-700 text-white shadow-lg z-50 p-4">
        <h2 class="text-lg font-bold mb-4 flex items-center gap-2"><Settings class="w-5 h-5" /> Settings</h2>
        <ul class="space-y-2">
            <li><label><input type="checkbox" class="mr-2"> Dark Mode</label></li>
            <li><label><input type="checkbox" class="mr-2"> English</label></li>
        </ul>
        <button @click="closeAllMenus" class="mt-4 text-sm text-white hover:underline">Close</button>
    </div>
</template>
