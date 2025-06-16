{{-- resources/views/profile/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Profile
        </h2>
    </x-slot>

    <div class="py-12" x-data="profilePage()" x-init>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- NAVIGATION BUTTONS -->
            <div class="flex gap-4 mb-6">
                <button @click="setSection('info')" :class="section === 'info' ? 'bg-blue-700' : 'bg-blue-600'" class="px-4 py-2 rounded text-white">Info</button>
                <button @click="setSection('password')" :class="section === 'password' ? 'bg-green-700' : 'bg-green-600'" class="px-4 py-2 rounded text-white">Password</button>
                <button @click="setSection('delete')" :class="section === 'delete' ? 'bg-red-700' : 'bg-red-600'" class="px-4 py-2 rounded text-white">Delete</button>
            </div>

            <!-- PROFILE INFO SECTION -->
            <div x-show="section === 'info'">
                @include('profile.alpine.update-profile-information-form')
            </div>

            <!-- PASSWORD SECTION -->
            <div x-show="section === 'password'">
                @include('profile.alpine.update-password-form')
            </div>

            <!-- DELETE ACCOUNT SECTION -->
            <div x-show="section === 'delete'">
                @include('profile.alpine.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
