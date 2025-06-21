<template>
    <header class="bg-green-700 text-white shadow-md sticky top-0 z-50 rounded-lg">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <!-- Logo -->
            <div class="text-2xl font-extrabold tracking-wide">QuizzApp</div>

            <!-- Mobile Toggle -->
            <button @click="navOpen = !navOpen" class="md:hidden focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Main Nav -->
            <nav :class="['md:flex gap-6 items-center', navOpen ? 'flex flex-col absolute top-full rounded-lg mt-1 left-0 w-full bg-green-700 p-4' : 'hidden md:flex']">
                <a href="/" class="text-white hover:text-green-100 font-medium">Home</a>
                <a href="/projects" class="text-white hover:text-green-100 font-medium">My Projects</a>
                <a href="/tests" class="text-white hover:text-green-100 font-medium">Quizzes</a>
            </nav>

            <!-- User Dropdown -->
            <div v-if="user" class="relative ml-4">
                <button @click="dropdownOpen = !dropdownOpen" class="flex items-center gap-2 bg-white text-green-700 font-semibold px-4 py-1 rounded-full shadow-sm hover:bg-gray-100">
                    <span>{{ user.name }}</span>
                </button>
                <div v-if="dropdownOpen" class="absolute right-0 mt-2 w-64 max-w-[90vw] bg-white z-10 text-green-700 rounded-xl shadow-xl py-3 px-2 animate-fade-in">
                    <a href="/profile" class="block px-4 py-2 rounded hover:bg-green-50">Profile</a>
                    <a href="/my-projects" class="block px-4 py-2 rounded hover:bg-green-50">My Projects</a>
                    <a href="/settings" class="block px-4 py-2 rounded hover:bg-green-50">Settings</a>
                    <a href="/admin/dashboard" class="block px-4 py-2 rounded hover:bg-green-50">Admin Dashboard</a>
                    <hr class="my-2">
                    <button @click="logout" class="w-full text-left px-4 py-2 text-red-600 rounded hover:bg-red-50">Logout</button>
                </div>
            </div>

            <!-- Guest Links -->
            <div v-else class="hidden md:flex items-center gap-3">
                <button @click="showLogin = true" class="bg-white text-green-700 px-4 py-1 rounded-full font-medium hover:bg-gray-100">Login</button>
                <a href="/register" class="text-white underline">Register</a>
            </div>
        </div>

        <!-- Guest Links on Mobile -->
        <div v-if="!user && navOpen" class="md:hidden px-4 pb-4">
            <button @click="showLogin = true" class="block w-full text-left text-white font-medium py-2">Login</button>
            <a href="/register" class="block w-full text-left text-white font-medium py-2">Register</a>
        </div>

        <!-- Login Modal -->
        <div v-if="showLogin" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded shadow-lg w-80">
                <h2 class="text-lg font-bold mb-4 text-green-800">Login</h2>
                <form @submit.prevent="loginHandler">
                    <input v-model="email" type="email" placeholder="Email" class="border border-green-300 p-2 w-full mb-2 rounded" />
                    <input v-model="password" type="password" placeholder="Password" class="border border-green-300 p-2 w-full mb-4 rounded" />
                    <button class="bg-green-700 text-white px-4 py-2 rounded w-full">Login</button>
                    <button @click="showLogin = false" type="button" class="text-gray-500 text-sm mt-2 w-full">Cancel</button>
                </form>
                <p v-if="error" class="text-red-500 text-sm mt-2">{{ error }}</p>
            </div>
        </div>
    </header>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import useUserAuth from '@/composable/userAuth'

const { user, login, logout, init } = useUserAuth()

const showLogin = ref(false)
const dropdownOpen = ref(false)
const navOpen = ref(false)
const email = ref('')
const password = ref('')
const error = ref(null)

onMounted(async () => {
    await init()
})

async function loginHandler() {
    error.value = null
    await login(email.value, password.value)
    if (!user.value) {
        error.value = 'Login failed'
    } else {
        showLogin.value = false
    }
}
</script>

<style scoped>
.animate-fade-in {
    animation: fadeIn 0.3s ease-in-out;
}
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-5px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
