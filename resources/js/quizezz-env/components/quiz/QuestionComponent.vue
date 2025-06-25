<template>
    <div class="p-4 border rounded shadow w-full h-full flex flex-col">
        <h2 class="text-lg md:text-xl font-semibold mb-4">
            {{ questionIndex + 1 }}. {{ question.question_text }}
        </h2>
        <ul class="space-y-4 w-full flex-1">
            <li
                v-for="(answer, index) in question.answers"
                :key="answer.id"
                class="w-full"
                @contextmenu.prevent="strikeAnswer(answer)"
            >
                <label
                    class="flex items-center space-x-4 w-full p-4 border rounded-lg cursor-pointer transition-all duration-300 text-lg"
                    :class="[
                        strikedAnswers.includes(answer.id)
                            ? 'line-through bg-red-500 text-white opacity-75 border-red-400'
                            : userAnswers[question.id] == answer.id
                                ? 'bg-green-600 text-white border-green-700'
                                : 'bg-white text-green-800 border-green-300 hover:bg-gray-100'
                    ]"
                    @click="selectAnswer(answer)"
                >
                    <span class="font-bold text-lg">{{ String.fromCharCode(65 + index) }}.</span>
                    <span class="flex-1">{{ answer.answer_text }}</span>
                </label>
            </li>
        </ul>
    </div>
</template>

<script setup>
defineProps({
    question: Object,
    questionIndex: Number,
    selectedAnswer: [String, Number],
    userAnswers: Object,
    strikedAnswers: Array,
    selectAnswer: Function,
    strikeAnswer: Function
});
</script>
