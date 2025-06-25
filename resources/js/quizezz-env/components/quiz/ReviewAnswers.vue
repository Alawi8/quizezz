<script setup lang="ts">
import { ref, computed } from "vue";
import { useRoute } from "vue-router";

// جلب test_id من الراوت
const route = useRoute();
const testId = computed(() => route.params.test_id as string | undefined);

// بيانات افتراضية (يمكنك استبدالها بجلب من API)
const questions = ref([
    {
        id: 1,
        question: "ما عاصمة فرنسا؟",
        user_answer: "باريس",
        correct_answer: "باريس",
    },
    {
        id: 2,
        question: "ما هو أكبر كوكب في المجموعة الشمسية؟",
        user_answer: "المريخ",
        correct_answer: "المشتري",
    },
    {
        id: 3,
        question: "من هو مخترع الهاتف؟",
        user_answer: "غراهام بيل",
        correct_answer: "غراهام بيل",
    },
]);

// حساب عدد الإجابات الصحيحة
const correctCount = computed(() =>
    questions.value.filter(q => q.user_answer === q.correct_answer).length
);
</script>

<template>
    <section class="max-w-2xl mx-auto mt-10 px-4">
        <h2 class="text-2xl font-bold mb-4">مراجعة الأسئلة</h2>
        <div v-if="!testId" class="text-red-500">لا يوجد اختبار محدد.</div>
        <div v-else>
            <div class="mb-4 text-green-700 font-semibold">
                نتيجتك: {{ correctCount }} من {{ questions.length }}
            </div>
            <ul>
                <li
                    v-for="q in questions"
                    :key="q.id"
                    class="mb-4 border-b border-gray-200 pb-2"
                >
                    <div class="font-medium mb-1">س: {{ q.question }}</div>
                    <div>
            <span :class="q.user_answer === q.correct_answer ? 'text-green-600' : 'text-red-600'">
              إجابتك: {{ q.user_answer }}
            </span>
                        <span v-if="q.user_answer !== q.correct_answer" class="ml-2 text-gray-500">
              (الإجابة الصحيحة: {{ q.correct_answer }})
            </span>
                    </div>
                </li>
            </ul>
        </div>
    </section>
</template>

<style scoped>
</style>
