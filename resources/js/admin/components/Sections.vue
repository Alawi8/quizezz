<template>
    <div class="max-w-6xl mx-auto p-6 space-y-8">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-green-700">🗂️ Manage Sections</h2>
            <button 
                @click="toggleForm" 
                class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 transition flex items-center gap-2"
            >
                <Plus class="w-4 h-4" /> 
                {{ isEditing ? 'Update Section' : 'Add New Section' }}
            </button>
        </div>

        <!-- Add New Section Form -->
        <transition name="slide-down">
            <div v-if="showForm && !isEditing" class="bg-white border border-green-300 rounded-lg p-6 space-y-4">
                <form @submit.prevent="createSection">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <input
                                v-model="formData.title"
                                type="text"
                                placeholder="Section Title"
                                class="w-full border border-green-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                required
                            />
                        </div>
                        <div>
                            <input
                                v-model.number="formData.duration"
                                type="number"
                                placeholder="Duration (minutes)"
                                min="1"
                                max="999"
                                class="w-full border border-green-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                required
                            />
                        </div>
                        <div>
                            <input
                                v-model="formData.description"
                                type="text"
                                placeholder="Short Description"
                                class="w-full border border-green-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                required
                            />
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 mt-4">
                        <button
                            type="button"
                            @click="cancelForm"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            :disabled="isLoading"
                            class="bg-green-700 text-white font-semibold px-6 py-2 rounded hover:bg-green-800 transition disabled:opacity-50 flex items-center gap-2"
                        >
                            <Folder class="w-4 h-4" /> 
                            {{ isLoading ? 'Saving...' : 'Save Section' }}
                        </button>
                    </div>
                </form>
            </div>
        </transition>

        <!-- Flash Message -->
        <transition name="fade">
            <div
                v-if="notification.message"
                :class="notificationClasses"
                class="px-4 py-3 rounded flex items-center justify-between"
            >
                <span>{{ notification.message }}</span>
                <button @click="hideNotification" class="ml-4 text-lg font-bold">&times;</button>
            </div>
        </transition>

        <!-- Search and Filter -->
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="flex-1">
                <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Search sections..."
                    class="w-full max-w-md border border-green-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                />
            </div>
            <div class="flex items-center gap-2">
                <label class="text-sm text-gray-600">Items per page:</label>
                <select 
                    v-model="itemsPerPage" 
                    @change="goToPage(1)"
                    class="border border-green-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>

        <!-- Pagination Info -->
        <div class="flex justify-between items-center text-sm text-gray-600" v-if="filteredSections.length > 0">
            <div>
                Showing {{ startIndex + 1 }} to {{ endIndex }} 
                of {{ filteredSections.length }} sections
            </div>
        </div>

        <!-- Loading State -->
        <div v-if="isLoading && sections.length === 0" class="text-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-700 mx-auto"></div>
            <p class="mt-4 text-gray-600">Loading sections...</p>
        </div>

        <!-- Sections List -->
        <div class="space-y-4" v-else>
            <transition-group name="list-item" tag="div">
                <div
                    v-for="section in currentPageItems"
                    :key="section.id"
                    :class="editingSection?.id === section.id ? 'bg-green-50 border-green-500' : 'bg-white border-green-300'"
                    class="border rounded-lg shadow-sm p-5 flex flex-col gap-4 transition-all duration-200"
                >
                    <div class="flex flex-col md:flex-row justify-between md:items-center w-full">
                        <div class="flex-1 space-y-1">
                            <h3 class="text-lg font-semibold">{{ section.title }}</h3>
                            <p class="text-sm text-gray-600">{{ section.description }}</p>
                            <p class="text-xs text-gray-500">Duration: {{ section.duration }} mins</p>
                        </div>
                        <div class="flex gap-2 flex-wrap items-center mt-2 md:mt-0">
                            <button 
                                @click="startEdit(section)" 
                                class="bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700 flex items-center gap-1 transition"
                            >
                                <Edit class="w-4 h-4" /> Edit
                            </button>
                            <button 
                                @click="confirmDelete(section)" 
                                class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700 flex items-center gap-1 transition"
                            >
                                <Trash class="w-4 h-4" /> Delete
                            </button>
                        </div>
                    </div>

                    <!-- Inline Edit Form -->
                    <transition name="slide-down">
                        <div v-if="editingSection?.id === section.id" class="border border-green-300 bg-white p-4 rounded-lg space-y-4">
                            <form @submit.prevent="updateSection">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <input
                                        v-model="formData.title"
                                        type="text"
                                        placeholder="Section Title"
                                        class="w-full border border-green-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                        required
                                    />
                                    <input
                                        v-model.number="formData.duration"
                                        type="number"
                                        placeholder="Duration (minutes)"
                                        min="1"
                                        max="999"
                                        class="w-full border border-green-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                        required
                                    />
                                    <input
                                        v-model="formData.description"
                                        type="text"
                                        placeholder="Short Description"
                                        class="w-full border border-green-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                        required
                                    />
                                </div>
                                <div class="flex justify-end gap-2 mt-4">
                                    <button
                                        type="button"
                                        @click="cancelEdit"
                                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        type="submit"
                                        :disabled="isLoading"
                                        class="bg-green-700 hover:bg-green-800 text-white px-6 py-2 rounded transition disabled:opacity-50 flex items-center gap-2"
                                    >
                                        <Edit class="w-4 h-4" /> 
                                        {{ isLoading ? 'Updating...' : 'Update Section' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </transition>
                </div>
            </transition-group>
        </div>

        <!-- Empty State -->
        <div v-if="filteredSections.length === 0 && !isLoading" class="text-center py-12 text-gray-500">
            <div v-if="searchQuery">
                <h3 class="text-lg font-medium mb-2">No sections found</h3>
                <p>No sections match your search criteria.</p>
                <button @click="searchQuery = ''" class="mt-2 text-green-600 hover:text-green-700">Clear search</button>
            </div>
            <div v-else>
                <h3 class="text-lg font-medium mb-2">No sections found</h3>
                <p>Click "Add New Section" to create your first section.</p>
            </div>
        </div>

        <!-- Pagination Controls -->
        <div class="flex justify-center items-center gap-4" v-if="totalPages > 1">
            <button 
                @click="previousPage"
                :disabled="currentPage === 1"
                :class="paginationButtonClass(currentPage === 1)"
                class="px-4 py-2 rounded transition"
            >
                Previous
            </button>
            
            <div class="flex gap-1">
                <button
                    v-for="page in visiblePages"
                    :key="page"
                    @click="goToPage(page)"
                    :class="currentPage === page 
                        ? 'bg-green-700 text-white' 
                        : 'bg-white text-green-700 border border-green-300 hover:bg-green-50'"
                    class="px-3 py-2 rounded transition"
                >
                    {{ page }}
                </button>
            </div>
            
            <button 
                @click="nextPage"
                :disabled="currentPage === totalPages"
                :class="paginationButtonClass(currentPage === totalPages)"
                class="px-4 py-2 rounded transition"
            >
                Next
            </button>
        </div>

        <!-- Confirm Delete Dialog -->
        <transition name="modal">
            <div
                v-if="sectionToDelete"
                class="fixed inset-0 z-50 bg-black/40 flex items-center justify-center p-4"
                style="backdrop-filter: blur(2px)"
                @click.self="cancelDelete"
            >
                <div class="bg-white rounded-lg p-6 shadow-lg w-full max-w-md space-y-4">
                    <h2 class="text-lg font-bold text-red-600">Delete Section?</h2>
                    <p class="text-gray-700">
                        Are you sure you want to delete "<strong>{{ sectionToDelete.title }}</strong>"? 
                        This action cannot be undone.
                    </p>
                    <div class="flex justify-end gap-3">
                        <button
                            @click="cancelDelete"
                            class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 transition"
                        >
                            Cancel
                        </button>
                        <button
                            @click="deleteSection"
                            :disabled="isLoading"
                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 flex items-center gap-1 transition disabled:opacity-50"
                        >
                            <Trash class="w-4 h-4" /> 
                            {{ isLoading ? 'Deleting...' : 'Confirm Delete' }}
                        </button>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted, watch } from 'vue'
import axios from '@/composable/axios.js'
import { Edit, Trash, Plus, Folder } from 'lucide-vue-next'

// State Management
const sections = ref([])
const isLoading = ref(false)
const showForm = ref(false)
const editingSection = ref(null)
const sectionToDelete = ref(null)
const searchQuery = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(10)

// Form Data
const formData = reactive({
    title: '',
    description: '',
    duration: 30
})

// Notification
const notification = reactive({
    message: null,
    type: 'success'
})

// Computed Properties
const isEditing = computed(() => editingSection.value !== null)

const filteredSections = computed(() => {
    if (!searchQuery.value) return sections.value
    
    const query = searchQuery.value.toLowerCase()
    return sections.value.filter(section => 
        section.title.toLowerCase().includes(query) ||
        section.description.toLowerCase().includes(query)
    )
})

const totalPages = computed(() => 
    Math.ceil(filteredSections.value.length / itemsPerPage.value)
)

const startIndex = computed(() => 
    (currentPage.value - 1) * itemsPerPage.value
)

const endIndex = computed(() => 
    Math.min(startIndex.value + itemsPerPage.value, filteredSections.value.length)
)

const currentPageItems = computed(() => 
    filteredSections.value.slice(startIndex.value, endIndex.value)
)

const visiblePages = computed(() => {
    const pages = []
    const start = Math.max(1, currentPage.value - 2)
    const end = Math.min(totalPages.value, currentPage.value + 2)
    
    for (let i = start; i <= end; i++) {
        pages.push(i)
    }
    return pages
})

const notificationClasses = computed(() => ({
    'bg-green-100 border border-green-400 text-green-700': notification.type === 'success',
    'bg-red-100 border border-red-400 text-red-700': notification.type === 'error'
}))

// Methods
const showNotification = (message, type = 'success') => {
    notification.message = message
    notification.type = type
    setTimeout(hideNotification, 4000)
}

const hideNotification = () => {
    notification.message = null
}

const resetForm = () => {
    formData.title = ''
    formData.description = ''
    formData.duration = 30
    editingSection.value = null
}

const toggleForm = () => {
    showForm.value = !showForm.value
    if (!showForm.value) {
        resetForm()
    }
}

const cancelForm = () => {
    showForm.value = false
    resetForm()
}

const startEdit = (section) => {
    editingSection.value = { ...section }
    formData.title = section.title
    formData.description = section.description
    formData.duration = section.duration
    showForm.value = false
}

const cancelEdit = () => {
    resetForm()
}

const confirmDelete = (section) => {
    sectionToDelete.value = section
}

const cancelDelete = () => {
    sectionToDelete.value = null
}

const paginationButtonClass = (disabled) => 
    disabled 
        ? 'bg-gray-300 text-gray-500 cursor-not-allowed' 
        : 'bg-green-700 hover:bg-green-800 text-white'

const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page
    }
}

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++
    }
}

const previousPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--
    }
}

const adjustPageAfterDelete = () => {
    if (currentPage.value > totalPages.value && totalPages.value > 0) {
        currentPage.value = totalPages.value
    }
}

// API Methods
const loadSections = async () => {
    try {
        isLoading.value = true
        const response = await axios.get('/api/admin/section')
        sections.value = response.data
    } catch (error) {
        console.error('Error loading sections:', error)
        showNotification('❌ Failed to load sections', 'error')
    } finally {
        isLoading.value = false
    }
}

const createSection = async () => {
    try {
        isLoading.value = true
        const response = await axios.post('/api/admin/section', formData)
        sections.value.push(response.data)
        showNotification('✅ Section added successfully')
        cancelForm()
        goToPage(1)
    } catch (error) {
        console.error('Error creating section:', error)
        showNotification('❌ Failed to add section', 'error')
    } finally {
        isLoading.value = false
    }
}

const updateSection = async () => {
    try {
        isLoading.value = true
        const response = await axios.put(`/api/admin/section/${editingSection.value.id}`, formData)
        
        const index = sections.value.findIndex(s => s.id === editingSection.value.id)
        if (index !== -1) {
            sections.value[index] = response.data
        }
        
        showNotification('✅ Section updated successfully')
        resetForm()
    } catch (error) {
        console.error('Error updating section:', error)
        showNotification('❌ Failed to update section', 'error')
    } finally {
        isLoading.value = false
    }
}

const deleteSection = async () => {
    try {
        isLoading.value = true
        await axios.delete(`/api/admin/section/${sectionToDelete.value.id}`)
        
        sections.value = sections.value.filter(s => s.id !== sectionToDelete.value.id)
        showNotification('✅ Section deleted successfully')
        cancelDelete()
        adjustPageAfterDelete()
    } catch (error) {
        console.error('Error deleting section:', error)
        showNotification('❌ Failed to delete section', 'error')
    } finally {
        isLoading.value = false
    }
}

// Watchers
watch(searchQuery, () => {
    goToPage(1)
})

// Lifecycle
onMounted(loadSections)
</script>

<style scoped>
/* Animations */
.slide-down-enter-active,
.slide-down-leave-active {
    transition: all 0.3s ease;
    max-height: 500px;
    overflow: hidden;
}

.slide-down-enter-from,
.slide-down-leave-to {
    max-height: 0;
    opacity: 0;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}

.list-item-enter-active,
.list-item-leave-active {
    transition: all 0.2s ease;
}

.list-item-enter-from,
.list-item-leave-to {
    opacity: 0;
    transform: translateX(-10px);
}

.list-item-move {
    transition: transform 0.2s ease;
}
</style>