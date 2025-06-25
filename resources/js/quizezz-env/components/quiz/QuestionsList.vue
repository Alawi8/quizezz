<template>
    <div class="question-scroll w-20 h-screen overflow-y-auto flex flex-col gap-2 p-2 items-center border rounded">
        <button
            v-for="(q, i) in questions"
            :key="q.id"
            @click="() => changeQuestion(i)"
            :class="[
                'w-10 h-10 rounded-full border text-sm font-bold flex items-center justify-center shrink-0',
                currentIndex === i
                    ? 'bg-green-600 text-white'
                    : userAnswers[q.id]
                    ? 'bg-blue-100 text-blue-800 border-blue-400'
                    : 'bg-white text-green-600 border-green-600'
            ]"
        >
            {{ i + 1 }}
        </button>
    </div>
</template>

<script setup>
const props = defineProps({
    questions: {
        type: Array,
        required: true
    },
    currentIndex: {
        type: Number,
        required: true
    },
    userAnswers: {
        type: Object,
        required: true
    },
    changeQuestion: {
        type: Function,
        required: true
    }
});

// لا حاجة لعمل destructuring هنا إذا كنت تستخدم props مباشرة في القالب
</script>
