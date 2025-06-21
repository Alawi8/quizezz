<template>
    <div class="max-w-6xl mx-auto p-6 space-y-8 text-green-700">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold">👥 Users Management</h2>
            <button
                v-if="canManage"
                @click="showForm = !showForm"
                class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition"
            >
                {{ showForm ? '❌ Hide Form' : '➕ Add User' }}
            </button>
        </div>

        <!-- Add User Form -->
        <div v-if="showForm" class="bg-white border rounded-lg shadow-sm p-6 space-y-4">
            <h2 class="text-xl font-bold text-gray-800">Add New User</h2>

            <div
                v-if="errors.length"
                class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded space-y-1"
            >
                <div v-for="(error, i) in errors" :key="i" class="text-sm">{{ error }}</div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input v-model="form.name" type="text" class="w-full border px-4 py-2 rounded" placeholder="Name" />
                <input v-model="form.email" type="email" class="w-full border px-4 py-2 rounded" placeholder="Email" />
                <input
                    v-model="form.password"
                    type="password"
                    class="w-full border px-4 py-2 rounded"
                    placeholder="Password"
                />
                <select v-model="form.role" class="w-full border px-4 py-2 rounded">
                    <option value="">Select Role</option>
                    <option v-for="role in availableRoles" :key="role" :value="role">{{ role }}</option>
                </select>
            </div>

            <div class="text-right">
                <button @click="addUser" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    Save User
                </button>
            </div>
        </div>

        <!-- Users List -->
        <div class="space-y-6">
            <div
                v-for="(user, index) in users"
                :key="index"
                class="bg-white border rounded-lg shadow-sm p-5 space-y-4"
            >
                <div class="flex flex-col md:flex-row justify-between md:items-center space-y-2 md:space-y-0">
                    <div class="flex-1 space-y-1">
                        <h3 class="text-lg font-semibold text-gray-800">{{ user.name }}</h3>
                        <p class="text-sm text-gray-600">{{ user.email }}</p>
                        <p class="text-xs text-gray-500">
                            Role:
                            <span class="inline-block px-2 py-0.5 bg-indigo-100 text-indigo-700 rounded">
                {{ user.roles?.[0]?.name || 'None' }}
              </span>
                        </p>
                    </div>

                    <div v-if="canManage" class="flex gap-2 flex-wrap items-center">
                        <select v-model="user.role" @change="changeRole(user)" class="border px-3 py-1 rounded">
                            <option value="">Change Role</option>
                            <option v-for="role in availableRoles" :key="role" :value="role">{{ role }}</option>
                        </select>

                        <button
                            @click="confirmDelete(user)"
                            class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700 transition"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Confirm Delete -->
        <div v-if="deletingUser" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-full max-w-md space-y-4">
                <h2 class="text-lg font-bold text-red-600">Delete User?</h2>
                <p class="text-gray-700">This action is permanent.</p>
                <div class="flex justify-end gap-3">
                    <button @click="deletingUser = null" class="bg-gray-200 px-4 py-2 rounded">Cancel</button>
                    <button @click="deleteUser" class="bg-red-600 text-white px-4 py-2 rounded">Confirm Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from '@/auth/axios'
import useUserAuth from '@/composable/userAuth'

const { user } = useUserAuth()
const canManage = ['admin', 'super-admin'].some(role => user.value?.roles?.includes(role))

const users = ref([])
const availableRoles = ref([])
const showForm = ref(false)
const deletingUser = ref(null)
const errors = ref([])

const form = ref({
    name: '',
    email: '',
    password: '',
    role: ''
})

async function fetchUsers() {
    try {
        const res = await axios.get('api/admin/users')
        users.value = res.data.data || []
    } catch (err) {
        console.error('Failed to fetch users', err)
    }
}

async function fetchRoles() {
    try {
        const res = await axios.get('api/admin/roles')
        availableRoles.value = res.data.roles || []
    } catch (err) {
        console.error('Failed to fetch roles', err)
    }
}

async function addUser() {
    errors.value = []
    const { name, email, password, role } = form.value

    if (!name || !email || !password || !role) {
        errors.value.push('All fields are required.')
        return
    }

    try {
        const res = await axios.post('api/admin/users', { name, email, password, role })
        users.value.push(res.data.user)
        form.value = { name: '', email: '', password: '', role: '' }
        showForm.value = false
    } catch (err) {
        if (err.response?.status === 422) {
            errors.value = Object.values(err.response.data.errors).flat()
        } else {
            errors.value = ['Failed to add user.']
        }
    }
}

async function changeRole(user) {
    try {
        const res = await axios.post(`api/admin/users/${user.id}/update-role`, { role: user.role })
        user.roles = res.data.user.roles
    } catch (err) {
        console.error('Failed to update role', err)
    }
}

function confirmDelete(user) {
    deletingUser.value = user
}

async function deleteUser() {
    try {
        await axios.delete(`api/admin/users/${deletingUser.value.id}`)
        users.value = users.value.filter(u => u.id !== deletingUser.value.id)
        deletingUser.value = null
    } catch (err) {
        console.error('Failed to delete user', err)
    }
}

onMounted(async () => {
    await fetchRoles()
    await fetchUsers()
})
</script>
