<template>
    <header class="bg-green-700 text-white p-4 flex justify-between items-center">
        <div class="text-xl font-bold">🚀 MyApp</div>

        <div class="flex items-center space-x-3 text-sm">
            <!-- ✅ Logged in -->
            <div v-if="user" class="flex items-center space-x-3">
                <span class="font-semibold">{{ user.name }}</span>
                <button @click="logout" class="text-red-100 hover:text-white bg-red-600 px-3 py-1 rounded">
                    Logout
                </button>
            </div>

            <!-- ❌ Guest -->
            <div v-else class="flex items-center space-x-3">
                <button @click="showLogin = true" class="hover:underline">Login</button>
                <a href="/register" class="hover:underline">Register</a>
            </div>
        </div>

        <!-- 🔐 Modal Login -->
        <div v-if="showLogin" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded shadow-lg w-96">
                <h2 class="text-lg font-bold mb-4 text-gray-800">Login</h2>
                <form @submit.prevent="loginHandler">
                    <input v-model="email" type="email" placeholder="Email" class="border p-2 w-full mb-2" />
                    <input v-model="password" type="password" placeholder="Password" class="border p-2 w-full mb-4" />
                    <button class="bg-green-600 text-white px-4 py-2 rounded w-full">Login</button>
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
    const email = ref('')
    const password = ref('')
    const error = ref(null)

    // 🟢 عند تحميل الهيدر، نحاول نجيب بيانات المستخدم من جديد
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

