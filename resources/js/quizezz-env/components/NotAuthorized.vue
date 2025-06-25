<script setup>
import { useRoute } from 'vue-router'
const route = useRoute()
const testId = route.query.test_id
</script>

<template>
    <div class="min-h-screen flex flex-col items-center justify-center text-center text-red-700">
        <h1 class="text-3xl font-bold mb-4">🚫 لا تملك صلاحية الوصول</h1>
        <p class="text-lg">رقم الاختبار: {{ testId }}</p>
        <a
            to="/"
            class="mt-6 inline-block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
        >
            الرجوع للصفحة الرئيسية
        </a>
    </div>
</template>
