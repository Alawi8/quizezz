<template>
    <div class="max-w-6xl mx-auto p-6 space-y-8">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-green-700">🗂️ Manage Sections</h2>
            <button @click="toggleForm" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 transition">
                <Plus class="inline w-4 h-4 mr-1" /> {{ editingTest ? 'Update Section' : 'Add New Section' }}
            </button>
        </div>

        <!-- Add New Section Form -->
        <div v-if="showForm && !editingTest" class="bg-white border border-green-300 rounded-lg p-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input
                    v-model="newTest.title"
                    type="text"
                    placeholder="Section Title"
                    class="w-full border border-green-300 rounded px-4 py-2"
                />
                <input
                    v-model.number="newTest.duration"
                    type="number"
                    placeholder="Duration (minutes)"
                    class="w-full border border-green-300 rounded px-4 py-2"
                />
                <input
                    v-model="newTest.description"
                    type="text"
                    placeholder="Short Description"
                    class="w-full border border-green-300 rounded px-4 py-2"
                />
            </div>
            <div class="text-right">
                <button
                    @click="addTest"
                    class="bg-green-700 text-white font-semibold px-6 py-2 rounded hover:bg-green-800 transition"
                >
                    <Folder class="inline w-4 h-4 mr-1" /> Save Section
                </button>
            </div>
        </div>

        <!-- Flash Message -->
        <div
            v-if="flashMessage"
            :class="flashType === 'success'
        ? 'bg-green-100 border border-green-400 text-green-700'
        : 'bg-red-100 border border-red-400 text-red-700'"
            class="px-4 py-3 rounded"
        >
            {{ flashMessage }}
        </div>

        <!-- List -->
        <div class="space-y-4">
            <div
                v-for="section in tests"
                :key="section.id"
                :class="editingTest?.id === section.id ? 'bg-green-50 border-green-500' : 'bg-white border-green-300'"
                class="border rounded-lg shadow-sm p-5 flex flex-col gap-4"
            >
                <div class="flex flex-col md:flex-row justify-between md:items-center w-full">
                    <div class="flex-1 space-y-1">
                        <h3 class="text-lg font-semibold">{{ section.title }}</h3>
                        <p class="text-sm">{{ section.description }}</p>
                        <p class="text-xs text-gray-500">Duration: {{ section.duration }} mins</p>
                    </div>
                    <div class="flex gap-2 flex-wrap items-center mt-2 md:mt-0">
                        <button @click="edit(section)" class="bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700 flex items-center gap-1">
                            <Edit class="w-4 h-4" /> Edit
                        </button>
                        <button @click="confirmDelete(section)" class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700 flex items-center gap-1">
                            <Trash class="w-4 h-4" /> Delete
                        </button>
                    </div>
                </div>

                <!-- Inline Edit Form -->
                <div v-if="editingTest?.id === section.id" class="border border-green-300 bg-white p-4 rounded-lg space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <input
                            v-model="newTest.title"
                            type="text"
                            placeholder="Section Title"
                            class="w-full border border-green-300 rounded px-4 py-2"
                        />
                        <input
                            v-model.number="newTest.duration"
                            type="number"
                            placeholder="Duration (minutes)"
                            class="w-full border border-green-300 rounded px-4 py-2"
                        />
                        <input
                            v-model="newTest.description"
                            type="text"
                            placeholder="Short Description"
                            class="w-full border border-green-300 rounded px-4 py-2"
                        />
                    </div>
                    <div class="text-right">
                        <button
                            @click="updateTest"
                            class="bg-green-700 hover:bg-green-800 text-white px-6 py-2 rounded flex items-center gap-1"
                        >
                            <Edit class="w-4 h-4" /> Update Section
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Confirm Delete Dialog -->
        <div
            v-if="deletingTest"
            class="fixed inset-0 z-50 bg-black/40 flex items-center justify-center"
            style="backdrop-filter: blur(2px)"
        >
            <div class="bg-white rounded-lg p-6 shadow-lg w-full max-w-md space-y-4">
                <h2 class="text-lg font-bold text-red-600">Delete Section?</h2>
                <p class="text-gray-700">This action cannot be undone. Are you sure you want to delete this section?</p>
                <div class="flex justify-end gap-3">
                    <button
                        @click="deletingTest = null"
                        class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300"
                    >
                        Cancel
                    </button>
                    <button
                        @click="deleteConfirmed"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 flex items-center gap-1"
                    >
                        <Trash class="inline w-4 h-4 mr-1" /> Confirm Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from '@/auth/axios'
import { Edit, Trash, Plus, Folder } from 'lucide-vue-next'

const tests = ref([])
const showForm = ref(false)
const flashMessage = ref(null)
const flashType = ref('success')

const deletingTest = ref(null)
const editingTest = ref(null)

const newTest = ref({ title: '', description: '', duration: 30 })

function toggleForm() {
    showForm.value = !showForm.value
    if (!showForm.value) {
        resetForm()
    }
}

function resetForm() {
    newTest.value = { title: '', description: '', duration: 30 }
    editingTest.value = null
}

async function fetchTests() {
    try {
        const res = await axios.get('/api/admin/section')
        tests.value = res.data
    } catch (err) {
        setFlash('❌ Failed to load sections', 'error')
    }
}

async function addTest() {
    try {
        const res = await axios.post('/api/admin/section', newTest.value)
        tests.value.push(res.data)
        setFlash('✅ Section added successfully', 'success')
        resetForm()
        showForm.value = false
    } catch (err) {
        setFlash('❌ Failed to add section', 'error')
    }
}

function edit(section) {
    editingTest.value = { ...section }
    newTest.value = { ...section }
    showForm.value = false
}

async function updateTest() {
    try {
        const res = await axios.put(`/api/admin/section/${editingTest.value.id}`, newTest.value)
        const index = tests.value.findIndex(t => t.id === editingTest.value.id)
        if (index !== -1) tests.value[index] = res.data
        setFlash('✅ Section updated successfully', 'success')
        resetForm()
    } catch (err) {
        setFlash('❌ Failed to update section', 'error')
    }
}

function confirmDelete(section) {
    deletingTest.value = section
}

async function deleteConfirmed() {
    try {
        await axios.delete(`/api/admin/section/${deletingTest.value.id}`)
        tests.value = tests.value.filter(t => t.id !== deletingTest.value.id)
        setFlash('✅ Section deleted', 'error')
        deletingTest.value = null
    } catch (err) {
        setFlash('❌ Failed to delete section', 'error')
    }
}

function setFlash(msg, type = 'success') {
    flashMessage.value = msg
    flashType.value = type
    setTimeout(() => (flashMessage.value = null), 4000)
}

onMounted(fetchTests)
</script>

<style scoped></style>
