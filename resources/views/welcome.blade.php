<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Quiz System - Home</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Explore quizzes and challenge your knowledge.">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/entrypoints/pages.js'])
</head>
<body x-data="chooseSections()" x-init="$store.userAuth.init(); init()">
    <!-- Admin Shortcut -->
    <template x-if="$store.userAuth.user && $store.userAuth.user.roles.some(r => r.name === 'super-admin'|| r.name === 'admin')">
        <div class="bg-black p-4 ">
            <a href="/admin/dashboard"
                class="text-sm bg-green-600 text-white rounded-lg px-3 py-2 hover:bg-green-700 transition m-2">
                🛠️
            </a>
            <a href="/admin/questions"
                class="text-sm bg-green-600 text-white rounded-lg px-3 py-2 hover:bg-green-700 transition">
                📝
            </a>
        </div>
    </template>

    @include('layouts.header')

    <template x-if="$store.userAuth.user && $store.userAuth.user.roles.some(r => r.name === 'super-admin' || r.name === 'student')">
        <main class="flex-grow container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-10">Available Quizzes</h1>
            @include('frontend.sections.index')
        </main>
    </template>

    <template x-if="!$store.userAuth.user || $store.userAuth.user.roles.some(r => r.name === 'user' )">
        <div class="col-span-full text-center text-gray-500 py-12">
            <p class="text-lg">No quizzes available at the moment. Please check back later.</p>
        </div>
    </template>

    <footer class="bg-gray-800 text-white text-center py-4">
        &copy; 2025 Quiz System. All rights reserved.
    </footer>
</body>


</html>