<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-30">
      <div class="absolute top-0 left-0 w-96 h-96 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
      <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-r from-yellow-400 to-pink-500 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
      <div class="absolute -bottom-8 left-20 w-96 h-96 bg-gradient-to-r from-green-400 to-blue-500 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
    </div>

    <!-- Content Container -->
    <div class="relative">
      <!-- Header Section -->
      <section class="relative py-10 md:py-20 px-2 md:px-6">
        <div class="w-full max-w-7xl mx-auto">
          <div class="text-center mb-8 md:mb-16">
            <div class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-100 to-blue-100 backdrop-blur-sm px-4 md:px-6 py-2 md:py-3 rounded-full border border-purple-200 shadow-lg mb-4 md:mb-6">
              <component :is="FolderIcon" class="w-4 md:w-5 h-4 md:h-5 text-purple-600" />
              <span class="text-sm md:text-base text-purple-700 font-semibold">Explore Learning Sections</span>
            </div>
            
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent mb-4 md:mb-6">
              Available Sections
            </h1>
            
            <p class="text-base md:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
              Discover organized learning paths and categorized content designed to enhance your knowledge systematically.
            </p>
          </div>

          <!-- Search and Filter Bar -->
          <div class="backdrop-blur-sm bg-white/70 rounded-2xl p-4 md:p-6 border border-white/40 shadow-xl mb-8 md:mb-12">
            <div class="flex flex-col md:flex-row gap-4 items-center">
              <!-- Search Input -->
              <div class="relative flex-1 w-full">
                <component :is="MagnifyingGlassIcon" class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                <input
                  v-model="searchQuery"
                  type="text"
                  placeholder="Search sections..."
                  class="w-full pl-12 pr-4 py-3 bg-white/80 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                />
              </div>
              
              <!-- Filter Dropdown -->
              <div class="relative">
                <select 
                  v-model="selectedCategory"
                  class="px-4 py-3 bg-white/80 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 cursor-pointer"
                >
                  <option value="">All Categories</option>
                  <option value="science">Science</option>
                  <option value="math">Mathematics</option>
                  <option value="history">History</option>
                  <option value="languages">Languages</option>
                  <option value="technology">Technology</option>
                </select>
              </div>

              <!-- Sort Dropdown -->
              <div class="relative">
                <select 
                  v-model="sortBy"
                  class="px-4 py-3 bg-white/80 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 cursor-pointer"
                >
                  <option value="name">Sort by Name</option>
                  <option value="created">Newest First</option>
                  <option value="popular">Most Popular</option>
                  <option value="quizzes">Quiz Count</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Sections Grid -->
      <section class="relative px-2 md:px-6 pb-10 md:pb-20">
        <div class="w-full max-w-7xl mx-auto">
          <!-- Loading State -->
          <div v-if="sectionsService.loading" class="text-center py-10 md:py-20">
            <div class="inline-flex items-center gap-4 backdrop-blur-sm bg-white bg-opacity-60 rounded-2xl px-6 md:px-8 py-4 md:py-6 border border-white border-opacity-30 shadow-lg">
              <div class="w-6 md:w-8 h-6 md:h-8 border-4 border-purple-500 border-t-transparent rounded-full animate-spin"></div>
              <span class="text-base md:text-xl font-semibold text-gray-700">Loading amazing sections...</span>
            </div>
          </div>

          <!-- Error State -->
          <div v-else-if="sectionsService.error" class="text-center py-10 md:py-20">
            <div class="inline-flex items-center gap-4 backdrop-blur-sm bg-red-50 bg-opacity-80 rounded-2xl px-6 md:px-8 py-4 md:py-6 border border-red-200 shadow-lg">
              <component :is="ExclamationTriangleIcon" class="w-6 md:w-8 h-6 md:h-8 text-red-500 animate-pulse" />
              <span class="text-base md:text-xl font-semibold text-red-700">{{ sectionsService.error }}</span>
            </div>
          </div>

          <!-- Sections Content -->
          <div v-else>
            <!-- Results Info -->
            <div class="flex justify-between items-center mb-6 md:mb-8">
              <div class="text-gray-600">
                <span class="font-medium">{{ filteredSections.length }}</span> sections found
                <span v-if="searchQuery || selectedCategory" class="text-sm">
                  ({{ totalSections }} total)
                </span>
              </div>
              
              <div class="text-sm text-gray-500">
                Page {{ currentPage }} of {{ totalPages }}
              </div>
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-8 mb-8 md:mb-12">
              <div
                v-for="(section, index) in paginatedSections"
                :key="section.id"
                class="group relative backdrop-blur-sm bg-white bg-opacity-80 rounded-2xl md:rounded-3xl p-4 md:p-8 border border-white border-opacity-40 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 hover:scale-105 overflow-hidden cursor-pointer"
                @click="openSection(section)"
              >
                <!-- Background Decoration -->
                <div class="absolute top-0 right-0 w-16 md:w-24 h-16 md:h-24 bg-gradient-to-br from-purple-200 to-blue-300 rounded-full -translate-y-8 md:-translate-y-12 translate-x-8 md:translate-x-12 opacity-50 group-hover:opacity-70 transition-opacity duration-300"></div>
                <div class="absolute bottom-0 left-0 w-12 md:w-16 h-12 md:h-16 bg-gradient-to-tr from-pink-200 to-purple-300 rounded-full translate-y-6 md:translate-y-8 -translate-x-6 md:-translate-x-8 opacity-30 group-hover:opacity-50 transition-opacity duration-300"></div>
                
                <div class="relative">
                  <!-- Section Icon -->
                  <div class="w-12 md:w-16 h-12 md:h-16 bg-gradient-to-r from-purple-500 to-blue-600 rounded-xl md:rounded-2xl flex items-center justify-center mb-4 md:mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg mx-auto md:mx-0">
                    <component :is="getIconForCategory(section.category)" class="w-6 md:w-8 h-6 md:h-8 text-white" />
                  </div>

                  <!-- Section Content -->
                  <div class="space-y-3 md:space-y-4 mb-6 md:mb-8">
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 group-hover:text-purple-700 transition-colors duration-300 text-center md:text-left line-clamp-2">
                      {{ section.title }}
                    </h3>
                    
                    <p class="text-sm md:text-base text-gray-600 text-center md:text-left line-clamp-3">
                      {{ section.description }}
                    </p>

                    <!-- Category Badge -->
                    <div class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-medium">
                      {{ section.category }}
                    </div>
                    
                    <div class="flex items-center justify-center md:justify-start gap-2 text-purple-600">
                      <component :is="BookOpenIcon" class="w-4 md:w-5 h-4 md:h-5" />
                      <span class="font-medium text-sm md:text-base">
                        {{ section.quizCount }} {{ section.quizCount === 1 ? 'Quiz' : 'Quizzes' }}
                      </span>
                    </div>

                    <div class="flex items-center justify-center md:justify-start gap-2 text-gray-600">
                      <component :is="UserGroupIcon" class="w-4 md:w-5 h-4 md:h-5" />
                      <span class="text-xs md:text-sm">{{ section.enrolledCount }}+ learners</span>
                    </div>
                  </div>

                  <!-- Explore Button -->
                  <button
                    class="group/btn relative w-full overflow-hidden bg-gradient-to-r from-purple-600 to-blue-600 text-white font-bold py-3 md:py-4 px-4 md:px-6 rounded-xl md:rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
                  >
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative flex items-center justify-center gap-2">
                      <component :is="EyeIcon" class="w-4 md:w-5 h-4 md:h-5 group-hover/btn:animate-pulse" />
                      <span class="text-sm md:text-base">Explore Section</span>
                      <component :is="ArrowRightIcon" class="w-3 md:w-4 h-3 md:h-4 transform group-hover/btn:translate-x-1 transition-transform duration-300" />
                    </div>
                  </button>
                </div>
              </div>
            </div>

            <!-- Empty State -->
            <div v-if="filteredSections.length === 0" class="text-center py-10 md:py-20">
              <div class="max-w-md mx-auto">
                <div class="w-16 md:w-24 h-16 md:h-24 bg-gradient-to-r from-gray-300 to-gray-400 rounded-full flex items-center justify-center mx-auto mb-4 md:mb-6">
                  <component :is="FolderIcon" class="w-8 md:w-12 h-8 md:h-12 text-white" />
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-3 md:mb-4">No Sections Found</h3>
                <p class="text-gray-600 mb-6 md:mb-8 text-sm md:text-base">
                  Try adjusting your search criteria or explore different categories.
                </p>
                <button 
                  @click="clearFilters"
                  class="px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-semibold rounded-xl hover:shadow-lg transition-all duration-300"
                >
                  Clear Filters
                </button>
              </div>
            </div>

            <!-- Pagination -->
            <div v-if="totalPages > 1" class="flex justify-center items-center mt-12">
              <div class="backdrop-blur-sm bg-white/70 rounded-2xl p-4 border border-white/40 shadow-xl">
                <div class="flex items-center gap-2">
                  <!-- Previous Button -->
                  <button
                    @click="goToPage(currentPage - 1)"
                    :disabled="currentPage === 1"
                    class="p-3 rounded-xl bg-white/80 border border-gray-200 hover:bg-purple-50 hover:border-purple-200 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200"
                  >
                    <component :is="ChevronLeftIcon" class="w-5 h-5 text-gray-600" />
                  </button>

                  <!-- Page Numbers -->
                  <div class="flex items-center gap-1">
                    <button
                      v-for="page in visiblePages"
                      :key="page"
                      @click="page !== '...' ? goToPage(page) : null"
                      :disabled="page === '...'"
                      :class="[
                        'w-10 h-10 rounded-lg font-medium transition-all duration-200',
                        page === currentPage
                          ? 'bg-gradient-to-r from-purple-600 to-blue-600 text-white shadow-lg'
                          : page === '...'
                          ? 'text-gray-400 cursor-default'
                          : 'bg-white/80 text-gray-600 hover:bg-purple-50 border border-gray-200'
                      ]"
                    >
                      {{ page }}
                    </button>
                  </div>

                  <!-- Next Button -->
                  <button
                    @click="goToPage(currentPage + 1)"
                    :disabled="currentPage === totalPages"
                    class="p-3 rounded-xl bg-white/80 border border-gray-200 hover:bg-purple-50 hover:border-purple-200 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200"
                  >
                    <component :is="ChevronRightIcon" class="w-5 h-5 text-gray-600" />
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, reactive, watch } from 'vue'
import { useRouter } from 'vue-router'

// Icons
const FolderIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
  </svg>`
}

const MagnifyingGlassIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
  </svg>`
}

const ExclamationTriangleIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
  </svg>`
}

const BookOpenIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
  </svg>`
}

const UserGroupIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
  </svg>`
}

const EyeIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
  </svg>`
}

const ArrowRightIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
  </svg>`
}

const ChevronLeftIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
  </svg>`
}

const ChevronRightIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
  </svg>`
}

// Category Icons
const BeakerIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5a2.25 2.25 0 00-.659 1.591v3.059a2.25 2.25 0 002.25 2.25h10.818a2.25 2.25 0 002.25-2.25v-3.059a2.25 2.25 0 00-.659-1.591L15 10.409a2.25 2.25 0 01-.659-1.591V3.104a48.554 48.554 0 00-4.682 0z" />
  </svg>`
}

const CalculatorIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V13.5zm0 2.25h.008v.008H8.25v-.008zm0 2.25h.008V18H8.25v-.008zM12 13.5h.008v.008H12V13.5zm0 2.25h.008v.008H12v-.008zm0 2.25h.008V18H12v-.008zM15.75 13.5h.008v.008h-.008V13.5zm0 2.25h.008v.008h-.008v-.008zM6 3.75A2.25 2.25 0 018.25 6v12A2.25 2.25 0 016 20.25H3.75A2.25 2.25 0 011.5 18V6A2.25 2.25 0 013.75 3.75H6zM15.75 3.75A2.25 2.25 0 0118 6v12A2.25 2.25 0 0115.75 20.25H13.5A2.25 2.25 0 0111.25 18V6a2.25 2.25 0 012.25-2.25h2.25z" />
  </svg>`
}

const ClockIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>`
}

const LanguageIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 21l5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 016-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.785.147 2.666.257m-4.589 8.495a18.023 18.023 0 01-3.827-5.802" />
  </svg>`
}

const ComputerDesktopIcon = {
  template: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
  </svg>`
}

// Services
class SectionsService {
  constructor() {
    this.sections = []
    this.loading = false
    this.error = null
  }

  async fetch() {
    this.loading = true
    this.error = null
    
    try {
      // Simulate API call with mock data
      await new Promise(resolve => setTimeout(resolve, 1000))
      
      this.sections = [
        {
          id: 1,
          title: "Advanced Physics",
          description: "Explore the fundamental laws of physics including mechanics, thermodynamics, and electromagnetism.",
          category: "science",
          quizCount: 25,
          enrolledCount: 4892,
          difficulty: "Intermediate"
        },
        {
          id: 6,
          title: "Organic Chemistry",
          description: "Understand molecular structures, reactions, and mechanisms in organic compounds.",
          category: "science",
          quizCount: 28,
          enrolledCount: 1324,
          difficulty: "Advanced"
        },
        {
          id: 7,
          title: "Statistics & Probability",
          description: "Master statistical analysis and probability theory for data-driven decision making.",
          category: "math",
          quizCount: 15,
          enrolledCount: 2847,
          difficulty: "Intermediate"
        },
        {
          id: 8,
          title: "Ancient Civilizations",
          description: "Discover the rich history and culture of ancient Egypt, Greece, and Rome.",
          category: "history",
          quizCount: 19,
          enrolledCount: 1953,
          difficulty: "Beginner"
        },
        {
          id: 9,
          title: "Spanish Conversation",
          description: "Improve your Spanish speaking skills through interactive conversations and exercises.",
          category: "languages",
          quizCount: 30,
          enrolledCount: 2764,
          difficulty: "Beginner"
        },
        {
          id: 10,
          title: "Machine Learning",
          description: "Introduction to artificial intelligence and machine learning algorithms.",
          category: "technology",
          quizCount: 35,
          enrolledCount: 3675,
          difficulty: "Advanced"
        },
        {
          id: 11,
          title: "Quantum Physics",
          description: "Explore the fascinating world of quantum mechanics and quantum phenomena.",
          category: "science",
          quizCount: 20,
          enrolledCount: 892,
          difficulty: "Advanced"
        },
        {
          id: 12,
          title: "Linear Algebra",
          description: "Master vectors, matrices, and linear transformations for advanced mathematics.",
          category: "math",
          quizCount: 24,
          enrolledCount: 1756,
          difficulty: "Advanced"
        }
      ]
    } catch (error) {
      this.error = 'Failed to load sections'
    } finally {
      this.loading = false
    }
  }

  get all() {
    return this.sections
  }
}

// Router
const router = useRouter()

// State
const sectionsService = reactive(new SectionsService())
const searchQuery = ref('')
const selectedCategory = ref('')
const sortBy = ref('name')
const currentPage = ref(1)
const itemsPerPage = 8

// Computed
const filteredSections = computed(() => {
  let filtered = sectionsService.all

  // Filter by search query
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(section => 
      section.title.toLowerCase().includes(query) ||
      section.description.toLowerCase().includes(query)
    )
  }

  // Filter by category
  if (selectedCategory.value) {
    filtered = filtered.filter(section => section.category === selectedCategory.value)
  }

  // Sort
  filtered.sort((a, b) => {
    switch (sortBy.value) {
      case 'name':
        return a.title.localeCompare(b.title)
      case 'created':
        return b.id - a.id
      case 'popular':
        return b.enrolledCount - a.enrolledCount
      case 'quizzes':
        return b.quizCount - a.quizCount
      default:
        return 0
    }
  })

  return filtered
})

const totalSections = computed(() => sectionsService.all.length)
const totalPages = computed(() => Math.ceil(filteredSections.value.length / itemsPerPage))

const paginatedSections = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage
  const end = start + itemsPerPage
  return filteredSections.value.slice(start, end)
})

const visiblePages = computed(() => {
  const pages = []
  const total = totalPages.value
  const current = currentPage.value
  
  if (total <= 7) {
    for (let i = 1; i <= total; i++) {
      pages.push(i)
    }
  } else {
    if (current <= 4) {
      for (let i = 1; i <= 5; i++) {
        pages.push(i)
      }
      pages.push('...')
      pages.push(total)
    } else if (current >= total - 3) {
      pages.push(1)
      pages.push('...')
      for (let i = total - 4; i <= total; i++) {
        pages.push(i)
      }
    } else {
      pages.push(1)
      pages.push('...')
      for (let i = current - 1; i <= current + 1; i++) {
        pages.push(i)
      }
      pages.push('...')
      pages.push(total)
    }
  }
  
  return pages
})

// Methods
function getIconForCategory(category) {
  const icons = {
    science: BeakerIcon,
    math: CalculatorIcon,
    history: ClockIcon,
    languages: LanguageIcon,
    technology: ComputerDesktopIcon
  }
  return icons[category] || FolderIcon
}

function openSection(section) {
  router.push(`/sections/${section.id}`)
}

function goToPage(page) {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page
  }
}

function clearFilters() {
  searchQuery.value = ''
  selectedCategory.value = ''
  sortBy.value = 'name'
  currentPage.value = 1
}

// Watch for filter changes to reset pagination
watch([searchQuery, selectedCategory, sortBy], () => {
  currentPage.value = 1
})

// Lifecycle
onMounted(() => {
  sectionsService.fetch()
})
</script>

<style scoped>
/* Custom Animations */
@keyframes blob {
  0% { transform: translate(0px, 0px) scale(1); }
  33% { transform: translate(30px, -50px) scale(1.1); }
  66% { transform: translate(-20px, 20px) scale(0.9); }
  100% { transform: translate(0px, 0px) scale(1); }
}

.animate-blob {
  animation: blob 7s infinite;
}

.animation-delay-2000 {
  animation-delay: 2s;
}

.animation-delay-4000 {
  animation-delay: 4s;
}

/* Line clamp utilities */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Backdrop blur support */
.backdrop-blur-sm {
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(4px);
}

/* Gradient text */
.bg-clip-text {
  background-clip: text;
  -webkit-background-clip: text;
}

.text-transparent {
  color: transparent;
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.1);
  border-radius: 4px;
}

::-webkit-scrollbar-thumb {
  background: rgba(147, 51, 234, 0.3);
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: rgba(147, 51, 234, 0.5);
}
</style> 