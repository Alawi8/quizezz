<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
        <!-- Site Info Header Section -->
        <div class="relative bg-white shadow-xl border-b border-gray-200/50">
            <!-- Background Pattern -->
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/5 via-purple-500/5 to-pink-500/5"></div>
            <div class="absolute inset-0 opacity-30">
                <div class="w-full h-full bg-gray-100"></div>
            </div>
            
            <div class="relative z-10 max-w-6xl mx-auto px-6 py-12">
                <div class="flex items-center justify-between">
                    <!-- Site Info Display -->
                    <div class="flex items-center gap-6">
                        <!-- Logo -->
                        <div class="relative group cursor-pointer" @click="openModal('logo')">
                            <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-xl group-hover:shadow-2xl transition-all duration-300 group-hover:scale-105">
                                <img v-if="siteInfo.logo" :src="siteInfo.logo" alt="Site Logo" class="w-16 h-16 rounded-xl object-cover">
                                <Settings v-else class="w-10 h-10 text-white" />
                            </div>
                            <!-- Edit Overlay -->
                            <div class="absolute inset-0 bg-black/40 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <Edit3 class="w-6 h-6 text-white" />
                            </div>
                        </div>

                        <!-- Site Info -->
                        <div class="space-y-2">
                            <div class="group cursor-pointer" @click="openModal('siteName')">
                                <h1 class="text-3xl font-bold text-gray-800 group-hover:text-indigo-600 transition-colors duration-300 flex items-center gap-2">
                                    {{ siteInfo.name || 'My Website' }}
                                    <Edit3 class="w-5 h-5 opacity-0 group-hover:opacity-100 transition-opacity duration-300" />
                                </h1>
                            </div>
                            <div class="group cursor-pointer" @click="openModal('siteDescription')">
                                <p class="text-lg text-gray-600 group-hover:text-gray-800 transition-colors duration-300 flex items-center gap-2">
                                    {{ siteInfo.description || 'Website description goes here...' }}
                                    <Edit3 class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300" />
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="flex items-center gap-3">
                        <button @click="openModal('siteName')" class="group p-3 bg-indigo-100 hover:bg-indigo-200 rounded-xl transition-all duration-300 hover:scale-105">
                            <Edit3 class="w-5 h-5 text-indigo-600 group-hover:scale-110 transition-transform duration-300" />
                        </button>
                        <button class="group p-3 bg-green-100 hover:bg-green-200 rounded-xl transition-all duration-300 hover:scale-105">
                            <Eye class="w-5 h-5 text-green-600 group-hover:scale-110 transition-transform duration-300" />
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-6xl mx-auto p-6 space-y-8">

            <!-- Flash Message -->
            <div v-if="flashMessage" 
                 class="fixed top-6 right-6 z-50 transform transition-all duration-500"
                 :class="flashType === 'success' ? 'bg-green-500' : 'bg-red-500'"
            >
                <div class="bg-white/95 backdrop-blur-sm border rounded-xl shadow-2xl p-4 flex items-center gap-3 min-w-[300px]">
                    <div class="p-2 rounded-full" :class="flashType === 'success' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'">
                        <CheckCircle v-if="flashType === 'success'" class="w-5 h-5" />
                        <AlertCircle v-else class="w-5 h-5" />
                    </div>
                    <span class="font-medium text-gray-800">{{ flashMessage }}</span>
                </div>
            </div>

            <!-- Settings Cards Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    
                <!-- Dark Mode Card -->
                <div class="group bg-white/80 backdrop-blur-sm border border-gray-200/50 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-1">
                    <div class="p-8 space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="p-3 bg-gradient-to-br from-gray-700 to-gray-900 rounded-xl">
                                <Moon class="w-6 h-6 text-white" />
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">Theme Settings</h3>
                        </div>

                        <div class="space-y-6">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                <div>
                                    <h4 class="font-semibold text-gray-800">Dark Mode</h4>
                                    <p class="text-sm text-gray-600">Enable dark theme for all users</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" v-model="system.dark_mode_enabled">
                                    <div class="w-14 h-7 bg-gray-200 rounded-full peer-checked:bg-gradient-to-r peer-checked:from-indigo-500 peer-checked:to-purple-600 transition-all duration-300">
                                        <div class="absolute top-0.5 left-0.5 bg-white w-6 h-6 rounded-full transition-transform duration-300 peer-checked:translate-x-7 shadow-lg"></div>
                                    </div>
                                </label>
                            </div>

                            <div class="p-4 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
                                <div class="flex items-center gap-3">
                                    <Info class="w-5 h-5 text-blue-600" />
                                    <span class="text-sm text-blue-800 font-medium">Changes will apply to all users on next login</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Import Questions Card -->
                <div class="group bg-white/80 backdrop-blur-sm border border-gray-200/50 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-1">
                    <div class="p-8 space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="p-3 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl">
                                <Upload class="w-6 h-6 text-white" />
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">Import Data</h3>
                        </div>

                        <div class="space-y-4">
                            <div class="relative">
                                <input 
                                    type="file" 
                                    @change="handleFileUpload" 
                                    accept=".csv,.xlsx"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                >
                                <div class="border-2 border-dashed border-gray-300 hover:border-green-500 rounded-xl p-8 text-center transition-colors duration-300">
                                    <Upload class="w-12 h-12 text-gray-400 mx-auto mb-4" />
                                    <p class="text-gray-600 font-medium">
                                        {{ uploadedFile ? uploadedFile.name : 'Click to select file or drag and drop' }}
                                    </p>
                                    <p class="text-sm text-gray-500 mt-1">CSV or XLSX files only</p>
                                </div>
                            </div>

                            <button 
                                @click="uploadFile('questions')" 
                                :disabled="!uploadedFile"
                                class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 disabled:from-gray-300 disabled:to-gray-400 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300 flex items-center justify-center gap-2 hover:scale-105 shadow-lg hover:shadow-xl disabled:cursor-not-allowed disabled:hover:scale-100"
                            >
                                <ArrowUpToLine class="w-5 h-5" />
                                Upload & Import Questions
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Danger Zone Card -->
                <div class="group bg-white/80 backdrop-blur-sm border-2 border-red-200 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-1">
                    <div class="p-8 space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="p-3 bg-gradient-to-br from-red-500 to-rose-600 rounded-xl">
                                <Trash2 class="w-6 h-6 text-white" />
                            </div>
                            <h3 class="text-2xl font-bold text-red-600">Danger Zone</h3>
                        </div>

                        <div class="space-y-4">
                            <div class="p-4 bg-red-50 border border-red-200 rounded-xl">
                                <div class="flex items-center gap-3 mb-2">
                                    <AlertTriangle class="w-5 h-5 text-red-600" />
                                    <h4 class="font-semibold text-red-800">Delete All Questions</h4>
                                </div>
                                <p class="text-sm text-red-700 mb-4">
                                    This will permanently delete all questions and cannot be undone.
                                </p>
                                <button 
                                    @click="deleteAll('questions')" 
                                    class="bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white font-semibold px-6 py-2 rounded-lg transition-all duration-300 flex items-center gap-2 hover:scale-105 shadow-lg hover:shadow-xl"
                                >
                                    <Trash class="w-4 h-4" />
                                    Delete All Questions
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Backdrop -->
        <div v-if="showModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300" 
                 :class="{ 'scale-100 opacity-100': showModal, 'scale-95 opacity-0': !showModal }">
                
                <!-- Modal Header -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-gray-800">
                            Edit {{ modalType === 'siteName' ? 'Site Name' : modalType === 'siteDescription' ? 'Site Description' : 'Site Logo' }}
                        </h3>
                        <button @click="closeModal" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                            <X class="w-5 h-5 text-gray-500" />
                        </button>
                    </div>
                </div>

                <!-- Modal Content -->
                <div class="p-6 space-y-4">
                    <!-- Site Name Modal -->
                    <div v-if="modalType === 'siteName'">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Site Name</label>
                        <input 
                            type="text" 
                            v-model="tempValue" 
                            placeholder="Enter site name"
                            class="w-full border-2 border-gray-200 focus:border-indigo-500 rounded-xl px-4 py-3 transition-colors duration-300 focus:outline-none focus:ring-4 focus:ring-indigo-100"
                            @keyup.enter="saveModal"
                        >
                    </div>

                    <!-- Site Description Modal -->
                    <div v-if="modalType === 'siteDescription'">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Site Description</label>
                        <textarea 
                            rows="4" 
                            v-model="tempValue" 
                            placeholder="Enter site description"
                            class="w-full border-2 border-gray-200 focus:border-indigo-500 rounded-xl px-4 py-3 transition-colors duration-300 focus:outline-none focus:ring-4 focus:ring-indigo-100"
                        ></textarea>
                    </div>

                    <!-- Logo Modal -->
                    <div v-if="modalType === 'logo'">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Site Logo</label>
                        <div class="space-y-4">
                            <input 
                                type="file" 
                                @change="handleLogoUpload" 
                                accept="image/*"
                                class="w-full border-2 border-gray-200 focus:border-indigo-500 rounded-xl px-4 py-3 transition-colors duration-300 focus:outline-none"
                            >
                            <div v-if="logoPreview" class="flex justify-center">
                                <img :src="logoPreview" alt="Logo Preview" class="w-20 h-20 rounded-xl object-cover border-2 border-gray-200">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="p-6 border-t border-gray-200 flex items-center justify-end gap-3">
                    <button @click="closeModal" class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium transition-colors">
                        Cancel
                    </button>
                    <button @click="saveModal" class="bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold px-6 py-2 rounded-lg transition-all duration-300 hover:scale-105">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import {
    Settings,
    FileText,
    Save,
    Moon,
    Upload,
    Trash,
    Trash2,
    ArrowUpToLine,
    Edit3,
    Eye,
    CheckCircle,
    AlertCircle,
    Info,
    AlertTriangle,
    X
} from 'lucide-vue-next'

// State
const flashMessage = ref('')
const flashType = ref('success')
const system = ref({
    system_name: '',
    system_description: '',
    dark_mode_enabled: false
})
const uploadedFile = ref(null)

// Site Info State
const siteInfo = ref({
    name: 'My Website',
    description: 'Website description goes here...',
    logo: null
})

// Modal State
const showModal = ref(false)
const modalType = ref('')
const tempValue = ref('')
const logoPreview = ref(null)

// Methods
async function init() {
    const token = localStorage.getItem("auth_token")
    if (token) {
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`
    }
    // Load site info from API
    // const res = await axios.get('api/site-info')
    // siteInfo.value = res.data
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

function handleLogoUpload(e) {
    const file = e.target.files[0]
    if (file) {
        const reader = new FileReader()
        reader.onload = (e) => {
            logoPreview.value = e.target.result
            tempValue.value = e.target.result
        }
        reader.readAsDataURL(file)
    }
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

function openModal(type) {
    modalType.value = type
    if (type === 'siteName') {
        tempValue.value = siteInfo.value.name
    } else if (type === 'siteDescription') {
        tempValue.value = siteInfo.value.description
    } else if (type === 'logo') {
        tempValue.value = siteInfo.value.logo
        logoPreview.value = siteInfo.value.logo
    }
    showModal.value = true
}

function closeModal() {
    showModal.value = false
    tempValue.value = ''
    logoPreview.value = null
    modalType.value = ''
}

async function saveModal() {
    try {
        if (modalType.value === 'siteName') {
            siteInfo.value.name = tempValue.value
        } else if (modalType.value === 'siteDescription') {
            siteInfo.value.description = tempValue.value
        } else if (modalType.value === 'logo') {
            siteInfo.value.logo = tempValue.value
        }
        
        // Save to API
        // await axios.post('api/site-info', siteInfo.value)
        
        setFlash('✅ Site information updated successfully', 'success')
        closeModal()
    } catch (err) {
        setFlash('❌ Error updating site information', 'error')
        console.error(err.response?.data || err.message)
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
/* Custom animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.group {
    animation: fadeInUp 0.6s ease-out;
}

.group:nth-child(1) { animation-delay: 0.1s; }
.group:nth-child(2) { animation-delay: 0.2s; }
.group:nth-child(3) { animation-delay: 0.3s; }
.group:nth-child(4) { animation-delay: 0.4s; }

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(45deg, #6366f1, #8b5cf6);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(45deg, #4f46e5, #7c3aed);
}
</style>