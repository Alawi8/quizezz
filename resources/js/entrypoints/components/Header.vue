<template>
    <div class="relative">
        <!-- Background Blur Overlay when modal is open -->
        <transition
            enter-active-class="transition ease-out duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="showLogin || showRegister" class="fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm z-40"></div>
        </transition>

        <header class="relative bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 text-white shadow-2xl sticky top-0 z-50 rounded-2xl mx-2 sm:mx-4 mt-2 sm:mt-4 backdrop-blur-lg border border-white border-opacity-20">
            <!-- Decorative Background Elements -->
            <div class="absolute inset-0 overflow-hidden rounded-2xl">
                <div class="absolute top-0 left-0 w-20 sm:w-32 h-20 sm:h-32 bg-white bg-opacity-10 rounded-full -translate-x-10 sm:-translate-x-16 -translate-y-10 sm:-translate-y-16 animate-pulse"></div>
                <div class="absolute bottom-0 right-0 w-16 sm:w-24 h-16 sm:h-24 bg-white bg-opacity-10 rounded-full translate-x-8 sm:translate-x-12 translate-y-8 sm:translate-y-12 animate-pulse animation-delay-2000"></div>
                <div class="absolute top-1/2 left-1/4 w-12 sm:w-16 h-12 sm:h-16 bg-white bg-opacity-5 rounded-full animate-float"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-3 sm:px-6 py-3 sm:py-4 flex items-center justify-between">
                <!-- Logo with Enhanced Animation -->
                <div class="flex items-center group">
                    <div class="relative">
                        <div class="absolute inset-0 bg-white bg-opacity-20 rounded-xl blur-sm group-hover:bg-opacity-30 transition-all duration-300"></div>
                        <div class="relative bg-white bg-opacity-10 backdrop-blur-sm rounded-xl px-2 sm:px-4 py-1.5 sm:py-2 border border-white border-opacity-30 group-hover:scale-105 transition-all duration-300">
                            <div class="text-lg sm:text-2xl font-extrabold tracking-wide bg-gradient-to-r from-white to-green-100 bg-clip-text text-transparent">
                                QuizzApp
                            </div>
                            <div class="absolute -top-0.5 sm:-top-1 -right-0.5 sm:-right-1 w-2 sm:w-3 h-2 sm:h-3 bg-yellow-400 rounded-full animate-ping opacity-75"></div>
                        </div>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex gap-6 xl:gap-8 items-center">
                    <a 
                        href="/" 
                        class="group relative px-3 xl:px-4 py-2 text-white font-medium transition-all duration-300 hover:text-green-100 rounded-xl hover:bg-white hover:bg-opacity-10"
                    >
                        <span class="relative z-10">Home</span>
                        <div class="absolute inset-0 bg-white bg-opacity-0 group-hover:bg-opacity-20 rounded-xl transition-all duration-300 transform scale-0 group-hover:scale-100"></div>
                        <div class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-white transition-all duration-300 group-hover:w-full group-hover:left-0"></div>
                    </a>
                    
                    <a 
                        href="/projects" 
                        class="group relative px-3 xl:px-4 py-2 text-white font-medium transition-all duration-300 hover:text-green-100 rounded-xl hover:bg-white hover:bg-opacity-10"
                    >
                        <span class="relative z-10">My Projects</span>
                        <div class="absolute inset-0 bg-white bg-opacity-0 group-hover:bg-opacity-20 rounded-xl transition-all duration-300 transform scale-0 group-hover:scale-100"></div>
                        <div class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-white transition-all duration-300 group-hover:w-full group-hover:left-0"></div>
                    </a>
                    
                    <RouterLink
                        to="/quizzes" 
                        class="group relative px-3 xl:px-4 py-2 text-white font-medium transition-all duration-300 hover:text-green-100 rounded-xl hover:bg-white hover:bg-opacity-10"
                    >
                        <span class="relative z-10">Quizzes</span>
                        <div class="absolute inset-0 bg-white bg-opacity-0 group-hover:bg-opacity-20 rounded-xl transition-all duration-300 transform scale-0 group-hover:scale-100"></div>
                        <div class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-white transition-all duration-300 group-hover:w-full group-hover:left-0"></div>
                    </RouterLink>
                </nav>

                <!-- Right Side - User/Auth Section -->
                <div class="flex items-center gap-2 sm:gap-4">
                    <!-- User Dropdown (Desktop & Mobile) -->
                    <div v-if="user" class="relative">
                        <button 
                            @click="toggleDropdown" 
                            class="group flex items-center gap-2 sm:gap-3 bg-white bg-opacity-90 backdrop-blur-sm text-green-700 font-semibold px-3 sm:px-6 py-2 sm:py-3 rounded-full shadow-lg hover:shadow-xl hover:bg-opacity-100 transition-all duration-300 transform hover:scale-105 border border-white border-opacity-50"
                        >
                            <div class="w-6 sm:w-8 h-6 sm:h-8 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full flex items-center justify-center text-white font-bold text-xs sm:text-sm">
                                {{ user.name.charAt(0).toUpperCase() }}
                            </div>
                            <span class="hidden sm:block text-sm sm:text-base">{{ user.name }}</span>
                            <ChevronDownIcon :class="['w-3 sm:w-4 h-3 sm:h-4 transition-transform duration-300', dropdownOpen ? 'rotate-180' : '']" />
                        </button>
                        
                        <transition
                            enter-active-class="transition ease-out duration-200"
                            enter-from-class="opacity-0 scale-95 translate-y-2"
                            enter-to-class="opacity-100 scale-100 translate-y-0"
                            leave-active-class="transition ease-in duration-150"
                            leave-from-class="opacity-100 scale-100 translate-y-0"
                            leave-to-class="opacity-0 scale-95 translate-y-2"
                        >
                            <div v-if="dropdownOpen" class="absolute right-0 mt-3 w-64 sm:w-72 bg-white backdrop-blur-lg bg-opacity-95 text-green-700 rounded-2xl shadow-2xl py-4 px-2 border border-white border-opacity-30 animate-slideInDown">
                                <!-- User Info Header -->
                                <div class="px-4 py-3 border-b border-green-100">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 sm:w-10 h-8 sm:h-10 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                            {{ user.name.charAt(0).toUpperCase() }}
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="font-semibold text-gray-800 text-sm sm:text-base truncate">{{ user.name }}</p>
                                            <p class="text-xs sm:text-sm text-gray-600 truncate">{{ user.email || 'user@example.com' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Menu Items -->
                                <div class="py-2">
                                    <a 
                                        href="/profile" 
                                        class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-green-50 transition-all duration-200 mx-2"
                                        @click="closeDropdown"
                                    >
                                        <ProfileIcon class="w-4 sm:w-5 h-4 sm:h-5 text-green-600 group-hover:text-green-700 flex-shrink-0" />
                                        <span class="font-medium group-hover:text-green-800 text-sm sm:text-base">Profile</span>
                                    </a>
                                    
                                    <a 
                                        href="/my-projects" 
                                        class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-green-50 transition-all duration-200 mx-2"
                                        @click="closeDropdown"
                                    >
                                        <ProjectsIcon class="w-4 sm:w-5 h-4 sm:h-5 text-green-600 group-hover:text-green-700 flex-shrink-0" />
                                        <span class="font-medium group-hover:text-green-800 text-sm sm:text-base">My Projects</span>
                                    </a>
                                    
                                    <a 
                                        href="/settings" 
                                        class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-green-50 transition-all duration-200 mx-2"
                                        @click="closeDropdown"
                                    >
                                        <SettingsIcon class="w-4 sm:w-5 h-4 sm:h-5 text-green-600 group-hover:text-green-700 flex-shrink-0" />
                                        <span class="font-medium group-hover:text-green-800 text-sm sm:text-base">Settings</span>
                                    </a>
                                    
                                    <a 
                                        href="/admin/dashboard" 
                                        class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-green-50 transition-all duration-200 mx-2"
                                        @click="closeDropdown"
                                    >
                                        <DashboardIcon class="w-4 sm:w-5 h-4 sm:h-5 text-green-600 group-hover:text-green-700 flex-shrink-0" />
                                        <span class="font-medium group-hover:text-green-800 text-sm sm:text-base">Admin Dashboard</span>
                                    </a>
                                </div>

                                <hr class="my-2 border-green-100">
                                
                                <button 
                                    @click="handleLogout" 
                                    class="group flex items-center gap-3 w-full text-left px-4 py-3 text-red-600 rounded-xl hover:bg-red-50 transition-all duration-200 mx-2 font-medium"
                                >
                                    <LogoutIcon class="w-4 sm:w-5 h-4 sm:h-5 flex-shrink-0" />
                                    <span class="group-hover:text-red-700 text-sm sm:text-base">Logout</span>
                                </button>
                            </div>
                        </transition>
                    </div>

                    <!-- Guest Links (Desktop) -->
                    <div v-else class="hidden md:flex items-center gap-3">
                        <button 
                            @click="openLoginModal" 
                            class="group relative overflow-hidden bg-white bg-opacity-90 backdrop-blur-sm text-green-700 px-4 lg:px-6 py-2 lg:py-3 rounded-full font-semibold hover:bg-opacity-100 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl border border-white border-opacity-50 text-sm lg:text-base"
                        >
                            <div class="absolute inset-0 bg-gradient-to-r from-green-50 to-emerald-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <span class="relative">Login</span>
                        </button>
                        <button 
                            @click="openRegisterModal" 
                            class="group text-white font-medium px-3 lg:px-4 py-2 rounded-xl hover:bg-white hover:bg-opacity-10 transition-all duration-300 relative text-sm lg:text-base"
                        >
                            <span class="relative">Register</span>
                            <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-white transition-all duration-300 group-hover:w-full"></div>
                        </button>
                    </div>

                    <!-- Mobile Menu Toggle -->
                    <button 
                        @click="toggleNav" 
                        class="lg:hidden relative group p-2 rounded-xl bg-white bg-opacity-10 backdrop-blur-sm border border-white border-opacity-30 hover:bg-opacity-20 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50"
                    >
                        <div class="relative w-5 sm:w-6 h-5 sm:h-6">
                            <span :class="['absolute top-0 left-0 w-5 sm:w-6 h-0.5 bg-white rounded-full transition-all duration-300 transform origin-center', navOpen ? 'rotate-45 translate-y-2 sm:translate-y-2.5' : '']"></span>
                            <span :class="['absolute top-2 sm:top-2.5 left-0 w-5 sm:w-6 h-0.5 bg-white rounded-full transition-all duration-300', navOpen ? 'opacity-0' : 'opacity-100']"></span>
                            <span :class="['absolute top-4 sm:top-5 left-0 w-5 sm:w-6 h-0.5 bg-white rounded-full transition-all duration-300 transform origin-center', navOpen ? '-rotate-45 -translate-y-2 sm:-translate-y-2.5' : '']"></span>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <transition
                enter-active-class="transition ease-out duration-300"
                enter-from-class="opacity-0 max-h-0"
                enter-to-class="opacity-100 max-h-96"
                leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100 max-h-96"
                leave-to-class="opacity-0 max-h-0"
            >
                <div v-if="navOpen" class="lg:hidden overflow-hidden bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 border-t border-white border-opacity-20">
                    <!-- Navigation Links -->
                    <div class="px-4 py-4 space-y-2">
                        <a 
                            href="/" 
                            class="block px-4 py-3 text-white font-medium rounded-xl hover:bg-white hover:bg-opacity-10 transition-all duration-200"
                            @click="closeNav"
                        >
                            Home
                        </a>
                        
                        <a 
                            href="/projects" 
                            class="block px-4 py-3 text-white font-medium rounded-xl hover:bg-white hover:bg-opacity-10 transition-all duration-200"
                            @click="closeNav"
                        >
                            My Projects
                        </a>
                        
                        <RouterLink 
                            to="/quizzes" 
                            class="block px-4 py-3 text-white font-medium rounded-xl hover:bg-white hover:bg-opacity-10 transition-all duration-200"
                            @click="closeNav"
                        >
                            Quizzes
                        </RouterLink>
                    </div>

                    <!-- Guest Links on Mobile -->
                    <div v-if="!user" class="px-4 pb-4 border-t border-white border-opacity-20 pt-4 space-y-2">
                        <button 
                            @click="openLoginModal" 
                            class="block w-full text-left text-white font-medium py-3 px-4 rounded-xl hover:bg-white hover:bg-opacity-10 transition-all duration-200"
                        >
                            Login
                        </button>
                        <button 
                            @click="openRegisterModal" 
                            class="block w-full text-left text-white font-medium py-3 px-4 rounded-xl hover:bg-white hover:bg-opacity-10 transition-all duration-200"
                        >
                            Register
                        </button>
                    </div>
                </div>
            </transition>

            <!-- Enhanced Login Modal -->
            <transition
                enter-active-class="transition ease-out duration-300"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div v-if="showLogin" class="fixed inset-0 flex items-center justify-center z-50 p-4 min-h-screen">
                    <transition
                        enter-active-class="transition ease-out duration-300"
                        enter-from-class="opacity-0 scale-95 translate-y-4"
                        enter-to-class="opacity-100 scale-100 translate-y-0"
                        leave-active-class="transition ease-in duration-200"
                        leave-from-class="opacity-100 scale-100 translate-y-0"
                        leave-to-class="opacity-0 scale-95 translate-y-4"
                    >
                        <div class="bg-white backdrop-blur-lg bg-opacity-95 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-sm sm:max-w-md border border-white border-opacity-30 relative overflow-hidden mx-4 my-auto">
                            <!-- Decorative Background -->
                            <div class="absolute top-0 right-0 w-24 sm:w-32 h-24 sm:h-32 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full -translate-y-12 sm:-translate-y-16 translate-x-12 sm:translate-x-16 opacity-50"></div>
                            <div class="absolute bottom-0 left-0 w-20 sm:w-24 h-20 sm:h-24 bg-gradient-to-tr from-green-50 to-emerald-50 rounded-full translate-y-10 sm:translate-y-12 -translate-x-10 sm:-translate-x-12 opacity-50"></div>
                            
                            <div class="relative">
                                <!-- Header -->
                                <div class="text-center mb-6">
                                    <div class="inline-flex items-center justify-center w-12 sm:w-16 h-12 sm:h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl mb-4 shadow-lg">
                                        <UserIcon class="w-6 sm:w-8 h-6 sm:h-8 text-white" />
                                    </div>
                                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-2">Welcome Back</h2>
                                    <p class="text-gray-600 text-sm sm:text-base">Sign in to your account</p>
                                </div>

                                <form @submit.prevent="loginHandler" class="space-y-6">
                                    <div class="space-y-4">
                                        <div class="relative">
                                            <input 
                                                v-model="email" 
                                                type="email" 
                                                placeholder="Email address"
                                                class="w-full px-4 py-3 sm:py-4 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 placeholder-gray-400 text-sm sm:text-base text-gray-900"
                                                required
                                            />
                                            <EmailIcon class="absolute right-4 top-1/2 transform -translate-y-1/2 w-4 sm:w-5 h-4 sm:h-5 text-gray-400" />
                                        </div>
                                        
                                        <div class="relative">
                                            <input 
                                                v-model="password" 
                                                type="password" 
                                                placeholder="Password"
                                                class="w-full px-4 py-3 sm:py-4 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 placeholder-gray-400 text-sm sm:text-base text-gray-900"
                                                required
                                            />
                                            <LockIcon class="absolute right-4 top-1/2 transform -translate-y-1/2 w-4 sm:w-5 h-4 sm:h-5 text-gray-400" />
                                        </div>
                                    </div>

                                    <div class="space-y-4">
                                        <button 
                                            type="submit"
                                            :disabled="isLoading"
                                            class="group w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold py-3 sm:py-4 rounded-xl hover:from-green-700 hover:to-emerald-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none shadow-lg hover:shadow-xl text-sm sm:text-base"
                                        >
                                            <span v-if="!isLoading">Login</span>
                                            <div v-else class="flex items-center justify-center gap-2">
                                                <div class="w-4 sm:w-5 h-4 sm:h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                                                <span>Logging in...</span>
                                            </div>
                                        </button>
                                        
                                        <div class="flex gap-2">
                                            <button 
                                                @click="closeLoginModal" 
                                                type="button" 
                                                class="flex-1 text-gray-600 font-medium py-3 hover:text-gray-800 transition-colors duration-200 text-sm sm:text-base"
                                            >
                                                Cancel
                                            </button>
                                            <button 
                                                @click="switchToRegister" 
                                                type="button" 
                                                class="flex-1 text-green-600 font-medium py-3 hover:text-green-800 transition-colors duration-200 text-sm sm:text-base"
                                            >
                                                Register
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <!-- Error Message -->
                                <transition
                                    enter-active-class="transition ease-out duration-200"
                                    enter-from-class="opacity-0 translate-y-2"
                                    enter-to-class="opacity-100 translate-y-0"
                                    leave-active-class="transition ease-in duration-150"
                                    leave-from-class="opacity-100 translate-y-0"
                                    leave-to-class="opacity-0 translate-y-2"
                                >
                                    <div v-if="error" class="mt-4 p-4 bg-red-50 border border-red-200 rounded-xl">
                                        <div class="flex items-center gap-2">
                                            <AlertCircleIcon class="w-4 sm:w-5 h-4 sm:h-5 text-red-500 flex-shrink-0" />
                                            <p class="text-red-700 font-medium text-sm sm:text-base">{{ error }}</p>
                                        </div>
                                    </div>
                                </transition>
                            </div>
                        </div>
                    </transition>
                </div>
            </transition>

            <!-- Enhanced Register Modal -->
            <transition
                enter-active-class="transition ease-out duration-300"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div v-if="showRegister" class="fixed inset-0 flex items-center justify-center z-50 p-4 min-h-screen">
                    <transition
                        enter-active-class="transition ease-out duration-300"
                        enter-from-class="opacity-0 scale-95 translate-y-4"
                        enter-to-class="opacity-100 scale-100 translate-y-0"
                        leave-active-class="transition ease-in duration-200"
                        leave-from-class="opacity-100 scale-100 translate-y-0"
                        leave-to-class="opacity-0 scale-95 translate-y-4"
                    >
                        <div class="bg-white backdrop-blur-lg bg-opacity-95 p-6 sm:p-8 rounded-2xl shadow-2xl w-full max-w-sm sm:max-w-md border border-white border-opacity-30 relative overflow-hidden mx-4 my-auto">
                            <!-- Decorative Background -->
                            <div class="absolute top-0 right-0 w-24 sm:w-32 h-24 sm:h-32 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full -translate-y-12 sm:-translate-y-16 translate-x-12 sm:translate-x-16 opacity-50"></div>
                            <div class="absolute bottom-0 left-0 w-20 sm:w-24 h-20 sm:h-24 bg-gradient-to-tr from-blue-50 to-indigo-50 rounded-full translate-y-10 sm:translate-y-12 -translate-x-10 sm:-translate-x-12 opacity-50"></div>
                            
                            <div class="relative">
                                <!-- Header -->
                                <div class="text-center mb-6">
                                    <div class="inline-flex items-center justify-center w-12 sm:w-16 h-12 sm:h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl mb-4 shadow-lg">
                                        <UserPlusIcon class="w-6 sm:w-8 h-6 sm:h-8 text-white" />
                                    </div>
                                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-2">Create Account</h2>
                                    <p class="text-gray-600 text-sm sm:text-base">Join QuizzApp today</p>
                                </div>

                                <form @submit.prevent="registerHandler" class="space-y-6">
                                    <div class="space-y-4">
                                        <div class="relative">
                                            <input 
                                                v-model="registerName" 
                                                type="text" 
                                                placeholder="Full Name"
                                                class="w-full px-4 py-3 sm:py-4 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 placeholder-gray-400 text-sm sm:text-base text-gray-900"
                                                required
                                            />
                                            <UserIcon class="absolute right-4 top-1/2 transform -translate-y-1/2 w-4 sm:w-5 h-4 sm:h-5 text-gray-400" />
                                        </div>

                                        <div class="relative">
                                            <input 
                                                v-model="registerEmail" 
                                                type="email" 
                                                placeholder="Email address"
                                                class="w-full px-4 py-3 sm:py-4 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 placeholder-gray-400 text-sm sm:text-base text-gray-900"
                                                required
                                            />
                                            <EmailIcon class="absolute right-4 top-1/2 transform -translate-y-1/2 w-4 sm:w-5 h-4 sm:h-5 text-gray-400" />
                                        </div>
                                        
                                        <div class="relative">
                                            <input 
                                                v-model="registerPassword" 
                                                type="password" 
                                                placeholder="Password"
                                                class="w-full px-4 py-3 sm:py-4 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 placeholder-gray-400 text-sm sm:text-base text-gray-900"
                                                required
                                            />
                                            <LockIcon class="absolute right-4 top-1/2 transform -translate-y-1/2 w-4 sm:w-5 h-4 sm:h-5 text-gray-400" />
                                        </div>

                                        <div class="relative">
                                            <input 
                                                v-model="registerConfirmPassword" 
                                                type="password" 
                                                placeholder="Confirm Password"
                                                class="w-full px-4 py-3 sm:py-4 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 placeholder-gray-400 text-sm sm:text-base text-gray-900"
                                                required
                                            />
                                            <LockIcon class="absolute right-4 top-1/2 transform -translate-y-1/2 w-4 sm:w-5 h-4 sm:h-5 text-gray-400" />
                                        </div>
                                    </div>

                                    <div class="space-y-4">
                                        <button 
                                            type="submit"
                                            :disabled="isRegisterLoading"
                                            class="group w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-3 sm:py-4 rounded-xl hover:from-blue-700 hover:to-indigo-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none shadow-lg hover:shadow-xl text-sm sm:text-base"
                                        >
                                            <span v-if="!isRegisterLoading">Create Account</span>
                                            <div v-else class="flex items-center justify-center gap-2">
                                                <div class="w-4 sm:w-5 h-4 sm:h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                                                <span>Creating Account...</span>
                                            </div>
                                        </button>
                                        
                                        <div class="flex gap-2">
                                            <button 
                                                @click="closeRegisterModal" 
                                                type="button" 
                                                class="flex-1 text-gray-600 font-medium py-3 hover:text-gray-800 transition-colors duration-200 text-sm sm:text-base"
                                            >
                                                Cancel
                                            </button>
                                            <button 
                                                @click="switchToLogin" 
                                                type="button" 
                                                class="flex-1 text-blue-600 font-medium py-3 hover:text-blue-800 transition-colors duration-200 text-sm sm:text-base"
                                            >
                                                Login
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <!-- Error Message -->
                                <transition
                                    enter-active-class="transition ease-out duration-200"
                                    enter-from-class="opacity-0 translate-y-2"
                                    enter-to-class="opacity-100 translate-y-0"
                                    leave-active-class="transition ease-in duration-150"
                                    leave-from-class="opacity-100 translate-y-0"
                                    leave-to-class="opacity-0 translate-y-2"
                                >
                                    <div v-if="registerError" class="mt-4 p-4 bg-red-50 border border-red-200 rounded-xl">
                                        <div class="flex items-center gap-2">
                                            <AlertCircleIcon class="w-4 sm:w-5 h-4 sm:h-5 text-red-500 flex-shrink-0" />
                                            <p class="text-red-700 font-medium text-sm sm:text-base">{{ registerError }}</p>
                                        </div>
                                    </div>
                                </transition>

                                <!-- Success Message -->
                                <transition
                                    enter-active-class="transition ease-out duration-200"
                                    enter-from-class="opacity-0 translate-y-2"
                                    enter-to-class="opacity-100 translate-y-0"
                                    leave-active-class="transition ease-in duration-150"
                                    leave-from-class="opacity-100 translate-y-0"
                                    leave-to-class="opacity-0 translate-y-2"
                                >
                                    <div v-if="registerSuccess" class="mt-4 p-4 bg-green-50 border border-green-200 rounded-xl">
                                        <div class="flex items-center gap-2">
                                            <CheckCircleIcon class="w-4 sm:w-5 h-4 sm:h-5 text-green-500 flex-shrink-0" />
                                            <p class="text-green-700 font-medium text-sm sm:text-base">{{ registerSuccess }}</p>
                                        </div>
                                    </div>
                                </transition>
                            </div>
                        </div>
                    </transition>
                </div>
            </transition>
        </header>
    </div>
</template>

<script setup>
import { ref, onMounted, watch, onUnmounted } from 'vue'
import useUserAuth from '@/composable/userAuth'

const { user, login, logout, init, register } = useUserAuth()

// Icons
const ChevronDownIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>' }
const UserIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>' }
const UserPlusIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" /></svg>' }
const EmailIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>' }
const LockIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>' }
const AlertCircleIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>' }
const CheckCircleIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>' }
const LogoutIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" /></svg>' }

// Menu Icons
const ProfileIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>' }
const ProjectsIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" /></svg>' }
const SettingsIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>' }
const DashboardIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l-1-3m1 3l-1-3m-16.5-3h16.5" /></svg>' }

// State
const showLogin = ref(false)
const showRegister = ref(false)
const dropdownOpen = ref(false)
const navOpen = ref(false)

// Login Form
const email = ref('')
const password = ref('')
const error = ref(null)
const isLoading = ref(false)

// Register Form
const registerName = ref('')
const registerEmail = ref('')
const registerPassword = ref('')
const registerConfirmPassword = ref('')
const registerError = ref(null)
const registerSuccess = ref(null)
const isRegisterLoading = ref(false)

// Methods
const toggleNav = () => {
    navOpen.value = !navOpen.value
    if (navOpen.value) {
        dropdownOpen.value = false
        showLogin.value = false
        showRegister.value = false
    }
}

const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value
    if (dropdownOpen.value) {
        navOpen.value = false
        showLogin.value = false
        showRegister.value = false
    }
}

const openLoginModal = () => {
    showLogin.value = true
    showRegister.value = false
    navOpen.value = false
    dropdownOpen.value = false
    error.value = null
    email.value = ''
    password.value = ''
}

const openRegisterModal = () => {
    showRegister.value = true
    showLogin.value = false
    navOpen.value = false
    dropdownOpen.value = false
    registerError.value = null
    registerSuccess.value = null
    registerName.value = ''
    registerEmail.value = ''
    registerPassword.value = ''
    registerConfirmPassword.value = ''
}

const closeLoginModal = () => {
    showLogin.value = false
    error.value = null
    email.value = ''
    password.value = ''
    isLoading.value = false
}

const closeRegisterModal = () => {
    showRegister.value = false
    registerError.value = null
    registerSuccess.value = null
    registerName.value = ''
    registerEmail.value = ''
    registerPassword.value = ''
    registerConfirmPassword.value = ''
    isRegisterLoading.value = false
}

const switchToRegister = () => {
    closeLoginModal()
    openRegisterModal()
}

const switchToLogin = () => {
    closeRegisterModal()
    openLoginModal()
}

const closeNav = () => {
    navOpen.value = false
}

const closeDropdown = () => {
    dropdownOpen.value = false
}

const handleLogout = async () => {
    await logout()
    dropdownOpen.value = false
}

async function loginHandler() {
    error.value = null
    isLoading.value = true
    
    try {
        await login(email.value, password.value)
        if (!user.value) {
            error.value = 'Login failed'
        } else {
            closeLoginModal()
        }
    } catch (err) {
        error.value = 'Login failed'
    } finally {
        isLoading.value = false
    }
}

async function registerHandler() {
    registerError.value = null
    registerSuccess.value = null
    isRegisterLoading.value = true
    
    try {
        // Validate password match
        if (registerPassword.value !== registerConfirmPassword.value) {
            registerError.value = 'Passwords do not match'
            return
        }

        // Validate password length
        if (registerPassword.value.length < 6) {
            registerError.value = 'Password must be at least 6 characters'
            return
        }

        // استدعاء دالة التسجيل بالمعاملات المنفصلة
        const result = await register(
            registerName.value,
            registerEmail.value, 
            registerPassword.value
        )
        
        if (result.success) {
            registerSuccess.value = 'Account created successfully! You can now login.'
            
            // Auto switch to login after 2 seconds
            setTimeout(() => {
                switchToLogin()
            }, 2000)
        } else {
            registerError.value = result.message || 'Registration failed'
        }
        
    } catch (err) {
        registerError.value = err.message || 'Registration failed'
    } finally {
        isRegisterLoading.value = false
    }
}

// Close dropdowns when clicking outside
const handleClickOutside = (event) => {
    const target = event.target
    if (!target.closest('.relative')) {
        dropdownOpen.value = false
        navOpen.value = false
    }
}

// Lifecycle
onMounted(async () => {
    await init()
    document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside)
})

// Watch for changes and close other modals
watch(showLogin, (val) => {
    if (val) {
        navOpen.value = false
        dropdownOpen.value = false
        showRegister.value = false
    }
})

watch(showRegister, (val) => {
    if (val) {
        navOpen.value = false
        dropdownOpen.value = false
        showLogin.value = false
    }
})

watch(dropdownOpen, (val) => {
    if (val) {
        navOpen.value = false
        showLogin.value = false
        showRegister.value = false
    }
})
</script>

<style scoped>
/* Custom Animations */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

@keyframes ping {
    75%, 100% {
        transform: scale(2);
        opacity: 0;
    }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

.animate-slideInDown {
    animation: slideInDown 0.3s ease-out;
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.animate-ping {
    animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

/* Responsive Max Height */
.max-h-96 {
    max-height: 24rem;
}

/* Focus Ring */
.focus\:ring-2:focus {
    box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.5);
}

.focus\:ring-green-500:focus {
    box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.5);
}

.focus\:ring-blue-500:focus {
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
}

.focus\:ring-white:focus {
    box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.5);
}

.focus\:ring-opacity-50:focus {
    box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.5);
}

.focus\:ring-offset-2:focus {
    box-shadow: 0 0 0 2px rgba(255, 255, 255, 1), 0 0 0 4px rgba(34, 197, 94, 0.5);
}

.focus\:border-transparent:focus {
    border-color: transparent;
}

/* Custom backdrop blur for older browsers */
@supports not (backdrop-filter: blur()) {
    .backdrop-blur-sm {
        background-color: rgba(255, 255, 255, 0.9);
    }
    .backdrop-blur-lg {
        background-color: rgba(255, 255, 255, 0.95);
    }
}

/* Ensure proper stacking for mobile menu */
@media (max-width: 1024px) {
    .lg\:hidden {
        position: relative;
        z-index: 40;
    }
}

/* Improved touch targets for mobile */
@media (max-width: 640px) {
    .touch-target {
        min-height: 44px;
        min-width: 44px;
    }
}

/* Text size adjustments for very small screens */
@media (max-width: 380px) {
    .text-responsive {
        font-size: 0.875rem;
    }
}
</style>