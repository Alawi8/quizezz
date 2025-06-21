<template>
    <div class="max-w-6xl mx-auto p-6 space-y-8 text-green-700">
        <h2 class="text-2xl font-bold flex items-center gap-2">
            <Settings class="w-6 h-6" /> System Settings
        </h2>

        <!-- ✅ Flash Alert -->
        <div v-if="flashMessage" :class="flashType === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700'" class="border px-4 py-3 rounded transition">
            {{ flashMessage }}
        </div>

        <!-- 🛠️ System Info -->
        <div class="bg-white border rounded-lg shadow p-6 space-y-6">
            <h3 class="text-lg font-semibold flex items-center gap-2">
                <FileText class="w-5 h-5" /> System Info
            </h3>
            <div>
                <label class="block text-sm font-medium mb-1">System Name</label>
                <input type="text" v-model="system.system_name" placeholder="Enter system name"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">System Description</label>
                <textarea rows="3" v-model="system.system_description" placeholder="Enter system description"
                          class="w-full border px-3 py-2 rounded"></textarea>
            </div>

            <div class="text-right">
                <button @click="saveSystemInfo" class="bg-green-700 text-white px-5 py-2 rounded hover:bg-green-800 transition flex items-center gap-2">
                    <Save class="w-4 h-4" /> Save Settings
                </button>
            </div>
        </div>

        <!-- 🌙 Dark Mode Toggle -->
        <div class="bg-white border rounded-lg shadow p-6 space-y-4">
            <h3 class="text-lg font-semibold flex items-center gap-2">
                <Moon class="w-5 h-5" /> Dark Mode
            </h3>
            <div class="flex items-center justify-between">
                <span>
                  Enable or disable dark mode for all users
                </span>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" v-model="system.dark_mode_enabled">
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-green-600 relative">
                        <span class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition peer-checked:translate-x-5"></span>
                    </div>
                </label>
            </div>
        </div>

        <!-- 📅 Import Questions -->
        <div class="bg-white border rounded-lg shadow p-6 space-y-6">
            <h3 class="text-lg font-semibold flex items-center gap-2">
                <Upload class="w-5 h-5" /> Import Questions
            </h3>

            <div>
                <input type="file" @change="handleFileUpload" accept=".csv,.xlsx"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <div class="text-right">
                <button @click="uploadFile('questions')" class="bg-green-700 text-white px-5 py-2 rounded hover:bg-green-800 transition flex items-center gap-2">
                    <ArrowUpToLine class="w-4 h-4" /> Upload & Import
                </button>
            </div>
        </div>

        <!-- 🗑️ Delete All Questions -->
        <div class="bg-white border border-red-500 rounded-lg shadow p-6 space-y-4">
            <h3 class="text-lg font-semibold text-red-600 flex items-center gap-2">
                <Trash2 class="w-5 h-5" /> Delete All Questions
            </h3>
            <p class="text-sm">
                This will permanently delete all questions. This action cannot be undone.
            </p>
            <div class="text-right">
                <button @click="deleteAll('questions')" class="bg-red-600 text-white px-5 py-2 rounded hover:bg-red-700 transition flex items-center gap-2">
                    <Trash class="w-4 h-4" /> Delete All
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from '@/auth/axios'
import {
    Settings,
    FileText,
    Save,
    Moon,
    Upload,
    Trash,
    Trash2,
    ArrowUpToLine
} from 'lucide-vue-next'

const flashMessage = ref('')
const flashType = ref('success')
const system = ref({
    system_name: '',
    system_description: '',
    dark_mode_enabled: false
})
const uploadedFile = ref(null)

async function init() {
    const token = localStorage.getItem("auth_token")
    if (token) {
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`
    }
    // يمكنك جلب الإعدادات هنا لاحقاً
    // const res = await axios.get('api/settings')
    // system.value = res.data
}

async function saveSystemInfo() {
    try {
        await axios.post('api/settings', system.value)
        setFlash('✅ Settings saved successfully', 'success')
    } catch (err) {
        setFlash('❌ Error saving settings', 'error')
        console.error(err.response?.data || err.message)
    }
}

function handleFileUpload(e) {
    uploadedFile.value = e.target.files[0]
}

async function uploadFile(type) {
    if (!uploadedFile.value) return setFlash('Choose a file first', 'error')

    const formData = new FormData()
    formData.append('file', uploadedFile.value)

    try {
        await axios.post(`api/import/${type}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        setFlash('✅ File uploaded successfully', 'success')
        uploadedFile.value = null
    } catch (e) {
        setFlash('❌ Upload failed', 'error')
        console.error(e.response?.data || e.message)
    }
}

async function deleteAll(type) {
    if (!confirm('Are you sure? This cannot be undone.')) return

    try {
        await axios.delete(`api/delete/${type}`)
        setFlash(`✅ All ${type} deleted successfully`, 'success')
    } catch (e) {
        setFlash('❌ Delete failed', 'error')
        console.error(e.response?.data || e.message)
    }
}

function setFlash(msg, type = 'success') {
    flashMessage.value = msg
    flashType.value = type
    setTimeout(() => flashMessage.value = null, 4000)
}

onMounted(init)
</script>

<style scoped>
</style>
