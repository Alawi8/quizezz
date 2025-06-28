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
            <div v-if="showLogin" class="fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm z-40"></div>
        </transition>

        <header class="relative bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 text-white shadow-2xl sticky top-0 z-50 rounded-2xl mx-4 mt-4 backdrop-blur-lg border border-white border-opacity-20">
            <!-- Decorative Background Elements -->
            <div class="absolute inset-0 overflow-hidden rounded-2xl">
                <div class="absolute top-0 left-0 w-32 h-32 bg-white bg-opacity-10 rounded-full -translate-x-16 -translate-y-16 animate-pulse"></div>
                <div class="absolute bottom-0 right-0 w-24 h-24 bg-white bg-opacity-10 rounded-full translate-x-12 translate-y-12 animate-pulse animation-delay-2000"></div>
                <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-white bg-opacity-5 rounded-full animate-float"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <!-- Logo with Enhanced Animation -->
                <div class="flex items-center group">
                    <div class="relative">
                        <div class="absolute inset-0 bg-white bg-opacity-20 rounded-xl blur-sm group-hover:bg-opacity-30 transition-all duration-300"></div>
                        <div class="relative bg-white bg-opacity-10 backdrop-blur-sm rounded-xl px-4 py-2 border border-white border-opacity-30 group-hover:scale-105 transition-all duration-300">
                            <div class="text-2xl font-extrabold tracking-wide bg-gradient-to-r from-white to-green-100 bg-clip-text text-transparent">
                                QuizzApp
                            </div>
                            <div class="absolute -top-1 -right-1 w-3 h-3 bg-yellow-400 rounded-full animate-ping opacity-75"></div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Toggle with Enhanced Animation -->
                <button 
                    @click="toggleNav" 
                    class="md:hidden relative group p-2 rounded-xl bg-white bg-opacity-10 backdrop-blur-sm border border-white border-opacity-30 hover:bg-opacity-20 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50"
                >
                    <div class="relative w-6 h-6">
                        <span :class="['absolute top-0 left-0 w-6 h-0.5 bg-white rounded-full transition-all duration-300 transform origin-center', navOpen ? 'rotate-45 translate-y-2.5' : '']"></span>
                        <span :class="['absolute top-2.5 left-0 w-6 h-0.5 bg-white rounded-full transition-all duration-300', navOpen ? 'opacity-0' : 'opacity-100']"></span>
                        <span :class="['absolute top-5 left-0 w-6 h-0.5 bg-white rounded-full transition-all duration-300 transform origin-center', navOpen ? '-rotate-45 -translate-y-2.5' : '']"></span>
                    </div>
                </button>

                <!-- Main Navigation with Enhanced Styling -->
                <nav :class="[
                    'transition-all duration-500 ease-in-out',
                    navOpen 
                        ? 'flex flex-col absolute top-full left-0 w-full bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 rounded-2xl mt-2 p-6 shadow-2xl border border-white border-opacity-20 backdrop-blur-lg animate-slideInDown' 
                        : 'hidden md:flex md:gap-8 md:items-center'
                ]">
                    <a 
                        href="/" 
                        class="group relative px-4 py-2 text-white font-medium transition-all duration-300 hover:text-green-100 rounded-xl hover:bg-white hover:bg-opacity-10"
                        @click="closeNav"
                    >
                        <span class="relative z-10">Home</span>
                        <div class="absolute inset-0 bg-white bg-opacity-0 group-hover:bg-opacity-20 rounded-xl transition-all duration-300 transform scale-0 group-hover:scale-100"></div>
                        <div class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-white transition-all duration-300 group-hover:w-full group-hover:left-0"></div>
                    </a>
                    
                    <a 
                        href="/projects" 
                        class="group relative px-4 py-2 text-white font-medium transition-all duration-300 hover:text-green-100 rounded-xl hover:bg-white hover:bg-opacity-10"
                        style="animation-delay: 100ms"
                        @click="closeNav"
                    >
                        <span class="relative z-10">My Projects</span>
                        <div class="absolute inset-0 bg-white bg-opacity-0 group-hover:bg-opacity-20 rounded-xl transition-all duration-300 transform scale-0 group-hover:scale-100"></div>
                        <div class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-white transition-all duration-300 group-hover:w-full group-hover:left-0"></div>
                    </a>
                    
                    <a 
                        href="/tests" 
                        class="group relative px-4 py-2 text-white font-medium transition-all duration-300 hover:text-green-100 rounded-xl hover:bg-white hover:bg-opacity-10"
                        style="animation-delay: 200ms"
                        @click="closeNav"
                    >
                        <span class="relative z-10">Quizzes</span>
                        <div class="absolute inset-0 bg-white bg-opacity-0 group-hover:bg-opacity-20 rounded-xl transition-all duration-300 transform scale-0 group-hover:scale-100"></div>
                        <div class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-white transition-all duration-300 group-hover:w-full group-hover:left-0"></div>
                    </a>
                </nav>

                <!-- User Dropdown with Enhanced Design -->
                <div v-if="user" class="relative ml-4">
                    <button 
                        @click="toggleDropdown" 
                        class="group flex items-center gap-3 bg-white bg-opacity-90 backdrop-blur-sm text-green-700 font-semibold px-6 py-3 rounded-full shadow-lg hover:shadow-xl hover:bg-opacity-100 transition-all duration-300 transform hover:scale-105 border border-white border-opacity-50"
                    >
                        <div class="w-8 h-8 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                            {{ user.name.charAt(0).toUpperCase() }}
                        </div>
                        <span class="hidden sm:block">{{ user.name }}</span>
                        <ChevronDownIcon :class="['w-4 h-4 transition-transform duration-300', dropdownOpen ? 'rotate-180' : '']" />
                    </button>
                    
                    <transition
                        enter-active-class="transition ease-out duration-200"
                        enter-from-class="opacity-0 scale-95 translate-y-2"
                        enter-to-class="opacity-100 scale-100 translate-y-0"
                        leave-active-class="transition ease-in duration-150"
                        leave-from-class="opacity-100 scale-100 translate-y-0"
                        leave-to-class="opacity-0 scale-95 translate-y-2"
                    >
                        <div v-if="dropdownOpen" class="absolute right-0 mt-3 w-72 bg-white backdrop-blur-lg bg-opacity-95 text-green-700 rounded-2xl shadow-2xl py-4 px-2 border border-white border-opacity-30 animate-slideInDown">
                            <!-- User Info Header -->
                            <div class="px-4 py-3 border-b border-green-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ user.name.charAt(0).toUpperCase() }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ user.name }}</p>
                                        <p class="text-sm text-gray-600">{{ user.email || 'user@example.com' }}</p>
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
                                    <ProfileIcon class="w-5 h-5 text-green-600 group-hover:text-green-700" />
                                    <span class="font-medium group-hover:text-green-800">Profile</span>
                                </a>
                                
                                <a 
                                    href="/my-projects" 
                                    class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-green-50 transition-all duration-200 mx-2"
                                    @click="closeDropdown"
                                >
                                    <ProjectsIcon class="w-5 h-5 text-green-600 group-hover:text-green-700" />
                                    <span class="font-medium group-hover:text-green-800">My Projects</span>
                                </a>
                                
                                <a 
                                    href="/settings" 
                                    class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-green-50 transition-all duration-200 mx-2"
                                    @click="closeDropdown"
                                >
                                    <SettingsIcon class="w-5 h-5 text-green-600 group-hover:text-green-700" />
                                    <span class="font-medium group-hover:text-green-800">Settings</span>
                                </a>
                                
                                <a 
                                    href="/admin/dashboard" 
                                    class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-green-50 transition-all duration-200 mx-2"
                                    @click="closeDropdown"
                                >
                                    <DashboardIcon class="w-5 h-5 text-green-600 group-hover:text-green-700" />
                                    <span class="font-medium group-hover:text-green-800">Admin Dashboard</span>
                                </a>
                            </div>

                            <hr class="my-2 border-green-100">
                            
                            <button 
                                @click="handleLogout" 
                                class="group flex items-center gap-3 w-full text-left px-4 py-3 text-red-600 rounded-xl hover:bg-red-50 transition-all duration-200 mx-2 font-medium"
                            >
                                <LogoutIcon class="w-5 h-5" />
                                <span class="group-hover:text-red-700">Logout</span>
                            </button>
                        </div>
                    </transition>
                </div>

                <!-- Guest Links with Enhanced Styling -->
                <div v-else class="hidden md:flex items-center gap-4">
                    <button 
                        @click="openLoginModal" 
                        class="group relative overflow-hidden bg-white bg-opacity-90 backdrop-blur-sm text-green-700 px-6 py-3 rounded-full font-semibold hover:bg-opacity-100 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl border border-white border-opacity-50"
                    >
                        <div class="absolute inset-0 bg-gradient-to-r from-green-50 to-emerald-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <span class="relative">Login</span>
                    </button>
                    <a 
                        href="/register" 
                        class="group text-white font-medium px-4 py-2 rounded-xl hover:bg-white hover:bg-opacity-10 transition-all duration-300 relative"
                    >
                        <span class="relative">Register</span>
                        <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-white transition-all duration-300 group-hover:w-full"></div>
                    </a>
                </div>
            </div>

            <!-- Guest Links on Mobile -->
            <transition
                enter-active-class="transition ease-out duration-300"
                enter-from-class="opacity-0 max-h-0"
                enter-to-class="opacity-100 max-h-40"
                leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100 max-h-40"
                leave-to-class="opacity-0 max-h-0"
            >
                <div v-if="!user && navOpen" class="md:hidden px-6 pb-6 border-t border-white border-opacity-20 mt-4 pt-4 overflow-hidden">
                    <button 
                        @click="openLoginModal" 
                        class="block w-full text-left text-white font-medium py-3 px-4 rounded-xl hover:bg-white hover:bg-opacity-10 transition-all duration-200 mb-2"
                    >
                        Login
                    </button>
                    <a 
                        href="/register" 
                        class="block w-full text-left text-white font-medium py-3 px-4 rounded-xl hover:bg-white hover:bg-opacity-10 transition-all duration-200"
                    >
                        Register
                    </a>
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
                <div v-if="showLogin" class="fixed inset-0 flex items-center justify-center z-50 p-4">
                    <transition
                        enter-active-class="transition ease-out duration-300"
                        enter-from-class="opacity-0 scale-95 translate-y-4"
                        enter-to-class="opacity-100 scale-100 translate-y-0"
                        leave-active-class="transition ease-in duration-200"
                        leave-from-class="opacity-100 scale-100 translate-y-0"
                        leave-to-class="opacity-0 scale-95 translate-y-4"
                    >
                        <div class="bg-white backdrop-blur-lg bg-opacity-95 p-8 rounded-2xl shadow-2xl w-full max-w-md border border-white border-opacity-30 relative overflow-hidden">
                            <!-- Decorative Background -->
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full -translate-y-16 translate-x-16 opacity-50"></div>
                            <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-green-50 to-emerald-50 rounded-full translate-y-12 -translate-x-12 opacity-50"></div>
                            
                            <div class="relative">
                                <!-- Header -->
                                <div class="text-center mb-6">
                                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl mb-4 shadow-lg">
                                        <UserIcon class="w-8 h-8 text-white" />
                                    </div>
                                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Welcome Back</h2>
                                    <p class="text-gray-600">Sign in to your account</p>
                                </div>

                                <form @submit.prevent="loginHandler" class="space-y-6">
                                    <div class="space-y-4">
                                        <div class="relative">
                                            <input 
                                                v-model="email" 
                                                type="email" 
                                                placeholder="Email address"
                                                class="w-full px-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                                                required
                                            />
                                            <EmailIcon class="absolute right-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                                        </div>
                                        
                                        <div class="relative">
                                            <input 
                                                v-model="password" 
                                                type="password" 
                                                placeholder="Password"
                                                class="w-full px-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                                                required
                                            />
                                            <LockIcon class="absolute right-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                                        </div>
                                    </div>

                                    <div class="space-y-4">
                                        <button 
                                            type="submit"
                                            :disabled="isLoading"
                                            class="group w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold py-4 rounded-xl hover:from-green-700 hover:to-emerald-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none shadow-lg hover:shadow-xl"
                                        >
                                            <span v-if="!isLoading">Login</span>
                                            <div v-else class="flex items-center justify-center gap-2">
                                                <div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                                                <span>Logging in...</span>
                                            </div>
                                        </button>
                                        
                                        <button 
                                            @click="closeLoginModal" 
                                            type="button" 
                                            class="w-full text-gray-600 font-medium py-3 hover:text-gray-800 transition-colors duration-200"
                                        >
                                            Cancel
                                        </button>
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
                                            <AlertCircleIcon class="w-5 h-5 text-red-500" />
                                            <p class="text-red-700 font-medium">{{ error }}</p>
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

const { user, login, logout, init } = useUserAuth()

// Icons
const ChevronDownIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>' }
const UserIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>' }
const EmailIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>' }
const LockIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>' }
const AlertCircleIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>' }
const LogoutIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" /></svg>' }

// Menu Icons
const ProfileIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>' }
const ProjectsIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" /></svg>' }
const SettingsIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>' }
const DashboardIcon = { template: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l-1-3m1 3l-1-3m-16.5-3h16.5" /></svg>' }

// State
const showLogin = ref(false)
const dropdownOpen = ref(false)
const navOpen = ref(false)
const email = ref('')
const password = ref('')
const error = ref(null)
const isLoading = ref(false)

// Methods
const toggleNav = () => {
    navOpen.value = !navOpen.value
    if (navOpen.value) {
        dropdownOpen.value = false
        showLogin.value = false
    }
}

const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value
    if (dropdownOpen.value) {
        navOpen.value = false
        showLogin.value = false
    }
}

const openLoginModal = () => {
    showLogin.value = true
    navOpen.value = false
    dropdownOpen.value = false
    error.value = null
    email.value = ''
    password.value = ''
}

const closeLoginModal = () => {
    showLogin.value = false
    error.value = null
    email.value = ''
    password.value = ''
    isLoading.value = false
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
    }
})

watch(dropdownOpen, (val) => {
    if (val) {
        navOpen.value = false
        showLogin.value = false
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

/* Backdrop Blur Support */
.backdrop-blur-sm {
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}

.backdrop-blur-lg {
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
}

/* Opacity Classes */
.bg-opacity-10 {
    background-color: rgba(255, 255, 255, 0.1);
}

.bg-opacity-20 {
    background-color: rgba(255, 255, 255, 0.2);
}

.bg-opacity-30 {
    background-color: rgba(255, 255, 255, 0.3);
}

.bg-opacity-50 {
    background-color: rgba(255, 255, 255, 0.5);
}

.bg-opacity-90 {
    background-color: rgba(255, 255, 255, 0.9);
}

.bg-opacity-95 {
    background-color: rgba(255, 255, 255, 0.95);
}

.border-opacity-20 {
    border-color: rgba(255, 255, 255, 0.2);
}

.border-opacity-30 {
    border-color: rgba(255, 255, 255, 0.3);
}

.border-opacity-50 {
    border-color: rgba(255, 255, 255, 0.5);
}

/* Black Opacity Classes */
.bg-black.bg-opacity-30 {
    background-color: rgba(0, 0, 0, 0.3);
}

/* Gradient Text */
.bg-clip-text {
    background-clip: text;
    -webkit-background-clip: text;
}

.text-transparent {
    color: transparent;
}

/* Transform Classes */
.rotate-180 {
    transform: rotate(180deg);
}

.rotate-45 {
    transform: rotate(45deg);
}

.-rotate-45 {
    transform: rotate(-45deg);
}

.scale-0 {
    transform: scale(0);
}

.scale-95 {
    transform: scale(0.95);
}

.scale-100 {
    transform: scale(1);
}

.-translate-x-16 {
    transform: translateX(-4rem);
}

.-translate-y-16 {
    transform: translateY(-4rem);
}

.translate-x-12 {
    transform: translateX(3rem);
}

.translate-y-12 {
    transform: translateY(3rem);
}

.translate-x-16 {
    transform: translateX(4rem);
}

.-translate-x-12 {
    transform: translateX(-3rem);
}

.translate-y-2\.5 {
    transform: translateY(0.625rem);
}

.-translate-y-2\.5 {
    transform: translateY(-0.625rem);
}

.translate-y-2 {
    transform: translateY(0.5rem);
}

.translate-y-4 {
    transform: translateY(1rem);
}

.-translate-y-1\/2 {
    transform: translateY(-50%);
}

/* Responsive Classes */
@media (max-width: 768px) {
    .max-h-0 {
        max-height: 0;
    }
    
    .max-h-40 {
        max-height: 10rem;
    }
}

/* Focus Styles */
.focus\:ring-2:focus {
    box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.5);
}

.focus\:ring-green-500:focus {
    box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.5);
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

/* Disabled States */
.disabled\:opacity-50:disabled {
    opacity: 0.5;
}

.disabled\:cursor-not-allowed:disabled {
    cursor: not-allowed;
}

.disabled\:transform-none:disabled {
    transform: none;
}

/* Group Hover Effects */
.group:hover .group-hover\:bg-opacity-100 {
    background-color: rgba(255, 255, 255, 1);
}

.group:hover .group-hover\:bg-opacity-20 {
    background-color: rgba(255, 255, 255, 0.2);
}

.group:hover .group-hover\:text-green-700 {
    color: rgb(21 128 61);
}

.group:hover .group-hover\:text-green-800 {
    color: rgb(22 101 52);
}

.group:hover .group-hover\:text-red-700 {
    color: rgb(185 28 28);
}

.group:hover .group-hover\:scale-100 {
    transform: scale(1);
}

.group:hover .group-hover\:w-full {
    width: 100%;
}

.group:hover .group-hover\:left-0 {
    left: 0;
}

.group:hover .group-hover\:opacity-100 {
    opacity: 1;
}

/* Animation Timing */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

.duration-150 {
    transition-duration: 150ms;
}

.duration-200 {
    transition-duration: 200ms;
}

.duration-300 {
    transition-duration: 300ms;
}

.duration-500 {
    transition-duration: 500ms;
}

.ease-in {
    transition-timing-function: cubic-bezier(0.4, 0, 1, 1);
}

.ease-out {
    transition-timing-function: cubic-bezier(0, 0, 0.2, 1);
}

.ease-in-out {
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}
</style>