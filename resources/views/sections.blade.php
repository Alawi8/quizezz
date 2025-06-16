<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Start Quiz</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/entrypoints/app.js'])
</head>

<body class="bg-gray-100 min-h-screen" x-data="chooseSections" x-init="fetchTests()">
    {{-- @include('partials.header') --}}
    <main class="p-6 max-w-5xl mx-auto">

        <template x-if="tests.length > 0">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="test in tests" :key="test.id">
                    <article
                        class="bg-white border border-gray-200 rounded-lg shadow-md p-6 transition hover:shadow-lg flex flex-col justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800 mb-2" x-text="test.title"></h2>
                            <p class="text-gray-600 text-sm mb-4"
                                x-text="test.description || 'لا يوجد وصف لهذا الاختبار.'"></p>
                        </div>
                        <button class="mt-auto bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
                            @click="loadQuestions(test.id)">
                            ابدأ الاختبار
                        </button>
                    </article>
                </template>
            </div>
        </template>

        <template x-if="tests.length === 0">
            <p class="text-center text-gray-500 mt-10">لا توجد اختبارات حالياً.</p>
        </template>


    </main>
    {{-- @include('partials.footer') --}}
</body>

</html>
