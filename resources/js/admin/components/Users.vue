<template>
    <div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-emerald-50 p-4 md:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto space-y-6 md:space-y-8">
            
            <!-- Header Section -->
            <div class="bg-white rounded-3xl shadow-xl border border-green-200 p-6 md:p-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <Users class="w-8 h-8 text-white" />
                        </div>
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-green-600 to-emerald-700 bg-clip-text text-transparent">
                                Users Management
                            </h1>
                            <p class="text-gray-600 mt-1">Manage your team members and their roles</p>
                        </div>
                    </div>
                    <button
                        v-if="canManage"
                        @click="userOperations.openAddForm()"
                        class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-8 py-4 rounded-2xl font-semibold shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 flex items-center gap-3 w-full sm:w-auto justify-center group"
                    >
                        <UserPlus class="w-5 h-5 group-hover:scale-110 transition-transform" />
                        Add New User
                    </button>
                </div>
            </div>

            <!-- Search & Filter Section -->
            <div class="bg-white rounded-3xl shadow-xl border border-green-200 overflow-hidden">
                <!-- Header -->
                <div 
                    @click="searchManager.toggleCollapse()"
                    class="p-6 md:p-8 cursor-pointer hover:bg-green-50/70 transition-all duration-300 border-b border-green-100"
                >
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <Search class="w-6 h-6 text-green-600" />
                            <h2 class="text-xl font-bold text-gray-800">Search & Filter</h2>
                            <div v-if="searchManager.hasActiveFilters.value" class="bg-green-100 text-green-700 text-sm px-3 py-1 rounded-full font-medium">
                                Active
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div v-if="!searchManager.isExpanded.value && searchManager.hasActiveFilters.value" class="text-sm text-gray-600 font-medium">
                                {{ searchManager.filteredUsers.value.length }} results
                            </div>
                            <div 
                                :class="[
                                    'transform transition-transform duration-300 text-green-600',
                                    searchManager.isExpanded.value ? 'rotate-180' : 'rotate-0'
                                ]"
                            >
                                <ChevronDown class="w-6 h-6" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Collapsible Content -->
                <div 
                    :class="[
                        'overflow-hidden transition-all duration-500 ease-in-out',
                        searchManager.isExpanded.value ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0'
                    ]"
                >
                    <div class="p-6 md:p-8 space-y-6">
                        <!-- Search Input -->
                        <div class="relative">
                            <input
                                v-model="searchManager.searchQuery.value"
                                type="text"
                                class="w-full pl-14 pr-12 py-4 border-2 border-green-100 rounded-2xl focus:outline-none focus:border-green-400 focus:ring-4 focus:ring-green-100 transition-all duration-300 bg-green-50/30 text-lg"
                                placeholder="Search by name, email, or role..."
                            />
                            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-green-500">
                                <Search class="w-6 h-6" />
                            </div>
                            <button
                                v-if="searchManager.searchQuery.value"
                                @click="searchManager.searchQuery.value = ''"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-full hover:bg-gray-100"
                            >
                                <X class="w-5 h-5" />
                            </button>
                        </div>

                        <!-- Filters Row -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex-1">
                                <select
                                    v-model="searchManager.roleFilter.value"
                                    class="w-full px-6 py-4 border-2 border-green-100 rounded-2xl focus:outline-none focus:border-green-400 focus:ring-4 focus:ring-green-100 bg-white transition-all duration-300 text-lg"
                                >
                                    <option value="">All Roles</option>
                                    <option v-for="role in dataManager.availableRoles.value" :key="role" :value="role">
                                        {{ role }}
                                    </option>
                                </select>
                            </div>
                            <button
                                @click="searchManager.clearFilters()"
                                :disabled="!searchManager.hasActiveFilters.value"
                                class="bg-white border-2 border-green-200 text-green-600 hover:bg-green-50 hover:border-green-400 disabled:opacity-50 disabled:cursor-not-allowed px-8 py-4 rounded-2xl font-semibold transition-all duration-300 flex items-center gap-3 justify-center min-w-max"
                            >
                                <RotateCcw class="w-5 h-5" />
                                Clear Filters
                            </button>
                        </div>

                        <!-- Active Filters Display -->
                        <div v-if="searchManager.hasActiveFilters.value" class="flex flex-wrap items-center gap-3">
                            <div class="flex items-center gap-2 text-gray-600">
                                <Filter class="w-4 h-4" />
                                <span class="font-medium">{{ searchManager.filteredUsers.value.length }}</span> of 
                                <span class="font-medium">{{ dataManager.users.value.length }}</span> users
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <span v-if="searchManager.searchQuery.value" class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 text-sm px-4 py-2 rounded-xl font-medium">
                                    <Search class="w-3 h-3" />
                                    "{{ searchManager.searchQuery.value }}"
                                    <button @click="searchManager.searchQuery.value = ''" class="hover:text-blue-900 ml-1">
                                        <X class="w-3 h-3" />
                                    </button>
                                </span>
                                <span v-if="searchManager.roleFilter.value" class="inline-flex items-center gap-2 bg-purple-100 text-purple-700 text-sm px-4 py-2 rounded-xl font-medium">
                                    <Users class="w-3 h-3" />
                                    {{ searchManager.roleFilter.value }}
                                    <button @click="searchManager.roleFilter.value = ''" class="hover:text-purple-900 ml-1">
                                        <X class="w-3 h-3" />
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl shadow-xl p-8 text-white transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-4xl font-bold mb-2">{{ searchManager.filteredUsers.value.length }}</div>
                            <div class="text-green-100 font-medium">Total Users</div>
                        </div>
                        <div class="opacity-80">
                            <Users class="w-12 h-12" />
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl shadow-xl p-8 text-white transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-4xl font-bold mb-2">{{ userCalculations.activeUsersCount.value }}</div>
                            <div class="text-emerald-100 font-medium">Active Users</div>
                        </div>
                        <div class="opacity-80">
                            <UserCheck class="w-12 h-12" />
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-teal-500 to-cyan-600 rounded-3xl shadow-xl p-8 text-white transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-4xl font-bold mb-2">{{ userCalculations.adminUsersCount.value }}</div>
                            <div class="text-teal-100 font-medium">Admin Users</div>
                        </div>
                        <div class="opacity-80">
                            <Shield class="w-12 h-12" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users List -->
            <div class="space-y-4">
                <!-- Empty State -->
                <div v-if="searchManager.filteredUsers.value.length === 0" class="bg-white rounded-3xl shadow-xl border border-green-200 p-16 text-center">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-3xl flex items-center justify-center">
                        <Search class="w-12 h-12 text-gray-400" />
                    </div>
                    <h3 class="text-2xl font-bold text-gray-600 mb-3">No users found</h3>
                    <p class="text-gray-500 text-lg">Try adjusting your search criteria or add new users</p>
                </div>

                <!-- User Cards -->
                <div
                    v-for="(user, index) in paginationManager.paginatedUsers.value"
                    :key="user.id || index"
                    class="bg-white rounded-3xl shadow-xl border border-green-200 hover:shadow-2xl hover:border-green-300 transition-all duration-300 overflow-hidden group"
                >
                    <div class="p-6 md:p-8">
                        <div class="flex items-center justify-between gap-6">
                            <!-- User Info -->
                            <div class="flex items-center gap-6 flex-1 min-w-0">
                                <div class="relative flex-shrink-0">
                                    <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-emerald-600 rounded-3xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300">
                                        <span class="text-white font-bold text-2xl">
                                            {{ userUtilities.getInitials(user.name) }}
                                        </span>
                                    </div>
                                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-lg">
                                        <CheckCircle v-if="user.status === 'active'" class="w-5 h-5 text-green-500" />
                                        <XCircle v-else class="w-5 h-5 text-red-500" />
                                    </div>
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-2xl font-bold text-gray-900 mb-2 truncate">{{ user.name }}</h3>
                                    <p class="text-green-600 font-semibold text-lg mb-3 truncate">{{ user.email }}</p>
                                    <div class="flex flex-wrap items-center gap-4 text-gray-500">
                                        <div class="flex items-center gap-2">
                                            <Calendar class="w-4 h-4 text-blue-500" />
                                            <span class="text-sm">{{ userUtilities.formatDate(user.created_at) }}</span>
                                        </div>
                                        <div v-if="user.phone" class="flex items-center gap-2">
                                            <Phone class="w-4 h-4 text-blue-500" />
                                            <span class="text-sm">{{ user.phone }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Role Badge -->
                            <div class="hidden sm:flex">
                                <span class="px-6 py-3 bg-blue-50 text-blue-700 border-2 border-blue-200 rounded-2xl font-semibold flex items-center gap-2 whitespace-nowrap">
                                    <User class="w-4 h-4" />
                                    {{ userUtilities.getUserRole(user) }}
                                </span>
                            </div>

                            <!-- Status Badge -->
                            <div class="flex">
                                <span :class="[
                                    'px-6 py-3 rounded-2xl font-semibold border-2 flex items-center gap-2 whitespace-nowrap',
                                    user.status === 'active' 
                                        ? 'bg-green-50 text-green-700 border-green-200' 
                                        : 'bg-red-50 text-red-700 border-red-200'
                                ]">
                                    <CheckCircle v-if="user.status === 'active'" class="w-4 h-4" />
                                    <XCircle v-else class="w-4 h-4" />
                                    {{ user.status === 'active' ? 'Active' : 'Inactive' }}
                                </span>
                            </div>

                            <!-- Action Buttons -->
                            <div v-if="canManage" class="flex items-center gap-3">
                                <button
                                    @click="userOperations.openEditForm(user)"
                                    class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center gap-2"
                                >
                                    <Edit2 class="w-4 h-4" />
                                    <span class="hidden lg:inline">Edit</span>
                                </button>
                                <button
                                    @click="userOperations.confirmDelete(user)"
                                    class="bg-white border-2 border-red-200 text-red-600 hover:bg-red-50 hover:border-red-400 px-6 py-3 rounded-2xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center gap-2"
                                >
                                    <Trash2 class="w-4 h-4" />
                                    <span class="hidden lg:inline">Delete</span>
                                </button>
                            </div>
                        </div>

                        <!-- Mobile Role Info -->
                        <div class="sm:hidden mt-6 pt-6 border-t border-gray-100">
                            <span class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 border border-blue-200 rounded-xl font-medium">
                                <User class="w-3 h-3" />
                                {{ userUtilities.getUserRole(user) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="paginationManager.totalPages.value > 1" class="bg-white rounded-3xl shadow-xl border border-green-200 p-8">
                <div class="flex flex-col sm:flex-row justify-center items-center gap-6">
                    <button
                        @click="paginationManager.prevPage()"
                        :disabled="!paginationManager.hasPrevPage.value"
                        class="w-full sm:w-auto bg-white border-2 border-green-200 text-green-600 hover:bg-green-50 hover:border-green-400 disabled:opacity-50 disabled:cursor-not-allowed px-8 py-4 rounded-2xl font-semibold transition-all duration-300 flex items-center gap-3 justify-center"
                    >
                        <ChevronLeft class="w-5 h-5" />
                        Previous
                    </button>
                    
                    <div class="bg-green-50 border-2 border-green-200 text-green-700 px-8 py-4 rounded-2xl font-bold text-lg">
                        Page {{ paginationManager.currentPage.value }} of {{ paginationManager.totalPages.value }}
                        <span class="text-sm font-normal ml-2">({{ searchManager.filteredUsers.value.length }} users)</span>
                    </div>
                    
                    <button
                        @click="paginationManager.nextPage()"
                        :disabled="!paginationManager.hasNextPage.value"
                        class="w-full sm:w-auto bg-white border-2 border-green-200 text-green-600 hover:bg-green-50 hover:border-green-400 disabled:opacity-50 disabled:cursor-not-allowed px-8 py-4 rounded-2xl font-semibold transition-all duration-300 flex items-center gap-3 justify-center"
                    >
                        Next
                        <ChevronRight class="w-5 h-5" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Add/Edit User Modal -->
        <teleport to="body">
            <div v-if="userOperations.showModal.value" class="fixed inset-0 z-50 overflow-y-auto">
                <!-- Backdrop -->
                <div 
                    class="fixed inset-0 bg-black/70 backdrop-blur-md transition-all duration-500"
                    @click="userOperations.closeModal()"
                ></div>
                
                <!-- Modal -->
                <div class="flex min-h-full items-center justify-center p-4">
                    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-4xl transform transition-all duration-500 scale-100">
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-t-3xl p-8">
                            <div class="flex items-center justify-between">
                                <h2 class="text-3xl font-bold text-white flex items-center gap-4">
                                    <Edit2 v-if="userOperations.isEditing.value" class="w-8 h-8" />
                                    <UserPlus v-else class="w-8 h-8" />
                                    {{ userOperations.isEditing.value ? 'Edit User' : 'Add New User' }}
                                </h2>
                                <button
                                    @click="userOperations.closeModal()"
                                    class="text-white/80 hover:text-white hover:bg-white/20 rounded-2xl p-3 transition-all duration-300"
                                >
                                    <X class="w-7 h-7" />
                                </button>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-8 max-h-[75vh] overflow-y-auto">
                            <!-- Error Messages -->
                            <div
                                v-if="userOperations.errors.value.length"
                                class="bg-red-50 border-2 border-red-200 text-red-700 rounded-3xl p-6 mb-8"
                            >
                                <div class="font-bold flex items-center gap-3 mb-3">
                                    <AlertTriangle class="w-6 h-6" />
                                    Please fix the following errors:
                                </div>
                                <ul class="space-y-2 ml-9">
                                    <li v-for="(error, i) in userOperations.errors.value" :key="i" class="text-base">
                                        • {{ error }}
                                    </li>
                                </ul>
                            </div>

                            <!-- Form -->
                            <form @submit.prevent="userOperations.saveUser()" class="space-y-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-3">
                                        <label class="block text-base font-bold text-gray-700">Full Name *</label>
                                        <input
                                            v-model="userOperations.form.value.name"
                                            type="text"
                                            class="w-full px-6 py-4 border-2 border-gray-200 rounded-2xl focus:outline-none focus:border-green-400 focus:ring-4 focus:ring-green-100 transition-all duration-300 text-lg"
                                            placeholder="Enter full name"
                                            required
                                        />
                                    </div>

                                    <div class="space-y-3">
                                        <label class="block text-base font-bold text-gray-700">Email Address *</label>
                                        <input
                                            v-model="userOperations.form.value.email"
                                            type="email"
                                            class="w-full px-6 py-4 border-2 border-gray-200 rounded-2xl focus:outline-none focus:border-green-400 focus:ring-4 focus:ring-green-100 transition-all duration-300 text-lg"
                                            placeholder="Enter email address"
                                            required
                                        />
                                    </div>

                                    <div class="space-y-3">
                                        <label class="block text-base font-bold text-gray-700">
                                            {{ userOperations.isEditing.value ? 'New Password (optional)' : 'Password *' }}
                                        </label>
                                        <input
                                            v-model="userOperations.form.value.password"
                                            type="password"
                                            class="w-full px-6 py-4 border-2 border-gray-200 rounded-2xl focus:outline-none focus:border-green-400 focus:ring-4 focus:ring-green-100 transition-all duration-300 text-lg"
                                            placeholder="Enter password"
                                            :required="!userOperations.isEditing.value"
                                        />
                                    </div>

                                    <div class="space-y-3">
                                        <label class="block text-base font-bold text-gray-700">Role *</label>
                                        <select
                                            v-model="userOperations.form.value.role"
                                            class="w-full px-6 py-4 border-2 border-gray-200 rounded-2xl focus:outline-none focus:border-green-400 focus:ring-4 focus:ring-green-100 bg-white transition-all duration-300 text-lg"
                                            required
                                        >
                                            <option value="">Select Role</option>
                                            <option v-for="role in dataManager.availableRoles.value" :key="role" :value="role">
                                                {{ role }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="space-y-3">
                                        <label class="block text-base font-bold text-gray-700">Phone Number</label>
                                        <input
                                            v-model="userOperations.form.value.phone"
                                            type="tel"
                                            class="w-full px-6 py-4 border-2 border-gray-200 rounded-2xl focus:outline-none focus:border-green-400 focus:ring-4 focus:ring-green-100 transition-all duration-300 text-lg"
                                            placeholder="Enter phone number"
                                        />
                                    </div>

                                    <div class="space-y-3">
                                        <label class="block text-base font-bold text-gray-700">Status</label>
                                        <select
                                            v-model="userOperations.form.value.status"
                                            class="w-full px-6 py-4 border-2 border-gray-200 rounded-2xl focus:outline-none focus:border-green-400 focus:ring-4 focus:ring-green-100 bg-white transition-all duration-300 text-lg"
                                        >
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="flex flex-col sm:flex-row justify-end gap-6 pt-8 border-t-2 border-gray-100">
                                    <button
                                        type="button"
                                        @click="userOperations.closeModal()"
                                        class="w-full sm:w-auto bg-gray-100 hover:bg-gray-200 text-gray-700 px-10 py-4 rounded-2xl font-bold text-lg transition-all duration-300"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        type="submit"
                                        :disabled="userOperations.loading.value"
                                        class="w-full sm:w-auto bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed text-white px-10 py-4 rounded-2xl font-bold text-lg transition-all duration-300 flex items-center justify-center gap-3"
                                    >
                                        <Loader v-if="userOperations.loading.value" class="w-6 h-6 animate-spin" />
                                        <Save v-else-if="userOperations.isEditing.value" class="w-6 h-6" />
                                        <UserPlus v-else class="w-6 h-6" />
                                        {{ userOperations.loading.value ? 'Saving...' : 
                                           (userOperations.isEditing.value ? 'Update User' : 'Create User') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </teleport>

        <!-- Delete Confirmation Modal -->
        <teleport to="body">
            <div v-if="userOperations.deletingUser.value" class="fixed inset-0 z-50 overflow-y-auto">
                <!-- Backdrop -->
                <div 
                    class="fixed inset-0 bg-black/70 backdrop-blur-md transition-all duration-500"
                    @click="userOperations.deletingUser.value = null"
                ></div>
                
                <!-- Modal -->
                <div class="flex min-h-full items-center justify-center p-4">
                    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg transform transition-all duration-500 scale-100">
                        <div class="p-10 text-center space-y-8">
                            <div class="w-24 h-24 bg-red-100 rounded-3xl flex items-center justify-center mx-auto">
                                <Trash2 class="w-12 h-12 text-red-600" />
                            </div>
                            
                            <div class="space-y-4">
                                <h2 class="text-3xl font-bold text-gray-900">Delete User</h2>
                                <p class="text-gray-600 text-lg leading-relaxed">
                                    Are you sure you want to delete <strong class="text-red-600">{{ userOperations.deletingUser.value.name }}</strong>?
                                    <br>This action cannot be undone.
                                </p>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                                <button
                                    @click="userOperations.deletingUser.value = null"
                                    class="w-full sm:w-auto bg-gray-100 hover:bg-gray-200 text-gray-700 px-8 py-4 rounded-2xl font-bold text-lg transition-all duration-300"
                                >
                                    Cancel
                                </button>
                                <button
                                    @click="userOperations.deleteUser()"
                                    :disabled="userOperations.loading.value"
                                    class="w-full sm:w-auto bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 disabled:opacity-50 disabled:cursor-not-allowed text-white px-8 py-4 rounded-2xl font-bold text-lg transition-all duration-300 flex items-center justify-center gap-3"
                                >
                                    <Loader v-if="userOperations.loading.value" class="w-6 h-6 animate-spin" />
                                    <Trash2 v-else class="w-6 h-6" />
                                    {{ userOperations.loading.value ? 'Deleting...' : 'Delete User' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </teleport>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, nextTick } from 'vue'
import axios from '@/composable/axios'
import useUserAuth from '@/composable/userAuth'

// Lucide Vue Icons
import {
    Users,
    UserPlus,
    UserCheck,
    User,
    Search,
    Filter,
    ChevronDown,
    ChevronLeft,
    ChevronRight,
    X,
    RotateCcw,
    CheckCircle,
    XCircle,
    Calendar,
    Phone,
    Edit2,
    Trash2,
    Shield,
    AlertTriangle,
    Save,
    Loader
} from 'lucide-vue-next'

// ============= DATA MANAGER CLASS =============
class DataManager {
    constructor() {
        this.users = ref([])
        this.availableRoles = ref([])
        this.loading = ref(false)
        this.error = ref(null)
    }

    async fetchUsers() {
        try {
            this.loading.value = true
            this.error.value = null
            const response = await axios.get('api/admin/users')
            this.users.value = response.data.data || []
            return true
        } catch (error) {
            console.error('Failed to fetch users:', error)
            this.error.value = 'Failed to load users'
            return false
        } finally {
            this.loading.value = false
        }
    }

    async fetchRoles() {
        try {
            const response = await axios.get('api/admin/roles')
            this.availableRoles.value = response.data.roles || []
            return true
        } catch (error) {
            console.error('Failed to fetch roles:', error)
            this.error.value = 'Failed to load roles'
            return false
        }
    }

    refreshData() {
        return Promise.all([this.fetchUsers(), this.fetchRoles()])
    }
}

// ============= SEARCH MANAGER CLASS =============
class SearchManager {
    constructor(getUsersCallback) {
        this.searchQuery = ref('')
        this.roleFilter = ref('')
        this.isExpanded = ref(false) // Collapsed by default
        this.getUsersCallback = getUsersCallback
    }

    get filteredUsers() {
        return computed(() => {
            let filtered = this.getUsersCallback()

            // Apply search query filter
            if (this.searchQuery.value.trim()) {
                const query = this.searchQuery.value.toLowerCase().trim()
                filtered = filtered.filter(user =>
                    user.name?.toLowerCase().includes(query) ||
                    user.email?.toLowerCase().includes(query) ||
                    user.roles?.some(role => role.name?.toLowerCase().includes(query))
                )
            }

            // Apply role filter
            if (this.roleFilter.value) {
                filtered = filtered.filter(user =>
                    user.roles?.some(role => role.name === this.roleFilter.value)
                )
            }

            return filtered
        })
    }

    get hasActiveFilters() {
        return computed(() => 
            this.searchQuery.value.trim() !== '' || this.roleFilter.value !== ''
        )
    }

    toggleCollapse() {
        this.isExpanded.value = !this.isExpanded.value
    }

    clearFilters() {
        this.searchQuery.value = ''
        this.roleFilter.value = ''
    }

    resetSearch() {
        this.clearFilters()
        this.isExpanded.value = false
    }
}

// ============= PAGINATION MANAGER CLASS =============
class PaginationManager {
    constructor(getFilteredUsersCallback, itemsPerPage = 10) {
        this.currentPage = ref(1)
        this.itemsPerPage = itemsPerPage
        this.getFilteredUsersCallback = getFilteredUsersCallback
    }

    get totalPages() {
        return computed(() => 
            Math.ceil(this.getFilteredUsersCallback().length / this.itemsPerPage) || 1
        )
    }

    get paginatedUsers() {
        return computed(() => {
            const start = (this.currentPage.value - 1) * this.itemsPerPage
            const end = start + this.itemsPerPage
            return this.getFilteredUsersCallback().slice(start, end)
        })
    }

    get hasNextPage() {
        return computed(() => this.currentPage.value < this.totalPages.value)
    }

    get hasPrevPage() {
        return computed(() => this.currentPage.value > 1)
    }

    nextPage() {
        if (this.hasNextPage.value) {
            this.currentPage.value++
        }
    }

    prevPage() {
        if (this.hasPrevPage.value) {
            this.currentPage.value--
        }
    }

    goToPage(page) {
        if (page >= 1 && page <= this.totalPages.value) {
            this.currentPage.value = page
        }
    }

    resetPagination() {
        this.currentPage.value = 1
    }
}

// ============= USER OPERATIONS CLASS =============
class UserOperations {
    constructor(usersRef) {
        this.usersRef = usersRef
        this.showModal = ref(false)
        this.isEditing = ref(false)
        this.editingUser = ref(null)
        this.deletingUser = ref(null)
        this.errors = ref([])
        this.loading = ref(false)
        this.form = ref(this.getInitialForm())
    }

    getInitialForm() {
        return {
            name: '',
            email: '',
            password: '',
            role: '',
            phone: '',
            status: 'active'
        }
    }

    openAddForm() {
        this.isEditing.value = false
        this.editingUser.value = null
        this.form.value = this.getInitialForm()
        this.errors.value = []
        this.showModal.value = true
    }

    openEditForm(user) {
        this.isEditing.value = true
        this.editingUser.value = user
        this.form.value = {
            name: user.name || '',
            email: user.email || '',
            password: '',
            role: user.roles?.[0]?.name || '',
            phone: user.phone || '',
            status: user.status || 'active'
        }
        this.errors.value = []
        this.showModal.value = true
    }

    closeModal() {
        this.showModal.value = false
        this.isEditing.value = false
        this.editingUser.value = null
        this.errors.value = []
        this.form.value = this.getInitialForm()
    }

    async saveUser() {
        this.errors.value = []
        this.loading.value = true

        try {
            if (this.isEditing.value) {
                await this.updateUser()
            } else {
                await this.addUser()
            }
        } catch (error) {
            this.handleSaveError(error)
        } finally {
            this.loading.value = false
        }
    }

    async addUser() {
        const response = await axios.post('api/admin/users', this.form.value)
        this.usersRef.value.push(response.data.user)
        this.closeModal()
    }

    async updateUser() {
        const payload = { ...this.form.value }
        if (!payload.password) {
            delete payload.password
        }

        const response = await axios.put(`api/admin/users/${this.editingUser.value.id}`, payload)
        const index = this.usersRef.value.findIndex(u => u.id === this.editingUser.value.id)
        if (index !== -1) {
            this.usersRef.value[index] = response.data.user
        }
        this.closeModal()
    }

    handleSaveError(error) {
        if (error.response?.status === 422) {
            this.errors.value = Object.values(error.response.data.errors).flat()
        } else {
            this.errors.value = ['Failed to save user. Please try again.']
        }
    }

    confirmDelete(user) {
        this.deletingUser.value = user
    }

    async deleteUser() {
        if (!this.deletingUser.value) return

        this.loading.value = true
        try {
            await axios.delete(`api/admin/users/${this.deletingUser.value.id}`)
            this.usersRef.value = this.usersRef.value.filter(u => u.id !== this.deletingUser.value.id)
            this.deletingUser.value = null
        } catch (error) {
            console.error('Failed to delete user:', error)
            this.errors.value = ['Failed to delete user. Please try again.']
        } finally {
            this.loading.value = false
        }
    }
}

// ============= USER CALCULATIONS CLASS =============
class UserCalculations {
    constructor(getUsersCallback) {
        this.getUsersCallback = getUsersCallback
    }

    get activeUsersCount() {
        return computed(() =>
            this.getUsersCallback().filter(user => user.status === 'active' || !user.status).length
        )
    }

    get adminUsersCount() {
        return computed(() =>
            this.getUsersCallback().filter(user =>
                user.roles?.some(role => ['admin', 'super-admin'].includes(role.name))
            ).length
        )
    }

    get inactiveUsersCount() {
        return computed(() =>
            this.getUsersCallback().filter(user => user.status === 'inactive').length
        )
    }

    getUsersByRole(roleName) {
        return this.getUsersCallback().filter(user =>
            user.roles?.some(role => role.name === roleName)
        )
    }
}

// ============= USER UTILITIES CLASS =============
class UserUtilities {
    getInitials(name) {
        if (!name) return '?'
        return name
            .split(' ')
            .map(word => word.charAt(0))
            .join('')
            .toUpperCase()
            .substring(0, 2)
    }

    formatDate(dateString) {
        if (!dateString) return 'N/A'
        try {
            return new Date(dateString).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            })
        } catch {
            return 'Invalid Date'
        }
    }

    getUserRole(user) {
        return user.roles?.[0]?.name || 'No Role'
    }

    getUserStatus(user) {
        return user.status || 'active'
    }

    isUserActive(user) {
        return this.getUserStatus(user) === 'active'
    }

    isUserAdmin(user) {
        return user.roles?.some(role => ['admin', 'super-admin'].includes(role.name)) || false
    }
}

// ============= COMPONENT SETUP =============
const { user } = useUserAuth()

// Permission check
const canManage = computed(() => 
    ['admin', 'super-admin'].some(role => user.value?.roles?.includes(role))
)

// Initialize managers
const dataManager = new DataManager()
const searchManager = new SearchManager(() => dataManager.users.value)
const paginationManager = new PaginationManager(() => searchManager.filteredUsers.value, 10)
const userOperations = new UserOperations(dataManager.users)
const userCalculations = new UserCalculations(() => dataManager.users.value)
const userUtilities = new UserUtilities()

// Component lifecycle
onMounted(async () => {
    try {
        await dataManager.refreshData()
    } catch (error) {
        console.error('Failed to initialize component:', error)
    }
})

// Export for debugging (optional)
if (process.env.NODE_ENV === 'development') {
    window.userManagementDebug = {
        dataManager,
        searchManager,
        paginationManager,
        userOperations,
        userCalculations,
        userUtilities
    }
}
</script>



<style scoped>
/* Custom scrollbar for modal */
.overflow-y-auto::-webkit-scrollbar {
    width: 8px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #10b981;
    border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #059669;
}

/* Animation classes */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.fade-in {
    animation: fadeIn 0.3s ease-out;
}

/* Focus outline removal for better UX */
button:focus-visible,
input:focus-visible,
select:focus-visible {
    outline: 2px solid #10b981;
    outline-offset: 2px;
}
</style>