<template>
    <div class="p-4 min-h-screen bg-white dark:bg-black">
        <Header :duration="test?.duration" @time-up="handleTestEnd" />

        <div v-if="!testEnded && questionsVisible" class="flex flex-row gap-4">
            <QuestionsList
                :questions="questions"
                :currentIndex="currentIndex"
                :userAnswers="userAnswers"
                :changeQuestion="changeQuestion"
            />
            <QuestionComponent
                v-if="currentQuestion"
                :question="currentQuestion"
                :questionIndex="currentIndex"
                :selectedAnswer="selectedAnswer"
                :userAnswers="userAnswers"
                :strikedAnswers="strikedAnswers"
                :selectAnswer="selectAnswer"
                :strikeAnswer="strikeAnswer"
            />
        </div>

        <div v-if="testEnded" class="text-center mt-10 text-green-600 text-xl font-bold">
            {{ endMessage }}
        </div>

        <Footer />
    </div>
</template>

<script setup>
import { ref, computed, onMounted, provide, watch } from 'vue';
import axios from '@/auth/axios';
import useUserAuth from '@/composable/userAuth.js';
import Header from '@/quizezz-env/layouts/Header.vue';
import Footer from '@/quizezz-env/layouts/Footer.vue';
import QuestionsList from '@/quizezz-env/components/quiz/QuestionsList.vue';
import QuestionComponent from '@/quizezz-env/components/quiz/QuestionComponent.vue';
import { useRouter } from 'vue-router';
// ...existing code...
const router = useRouter();
const currentIndex = ref(0);
const selectedAnswer = ref(null);
const strikedAnswers = ref([]);
const flashMessage = ref(null);
const flashError = ref(false);
const userAnswers = ref({});

const { token } = useUserAuth();
const questions = ref([]);
const test = ref(null);
const testEnded = ref(false);
const questionsVisible = ref(true);
const endMessage = ref('');

const currentQuestion = computed(() => questions.value[currentIndex.value] || null);

// عند تغيير السؤال، حدث الإجابة المختارة والإجابات المشطوبة
watch(currentIndex, () => {
    syncSelectedAnswer();
    strikedAnswers.value = [];
});

// ...existing code...
function handleTestEnd() {
    testEnded.value = true;
    questionsVisible.value = false;
    endMessage.value = '✅ The test has ended. Thank you for your participation.';

    // حفظ الإجابات في localStorage
    localStorage.setItem('userAnswers', JSON.stringify(userAnswers.value));
    localStorage.setItem('testId', getTestIdFromUrl());

    // الانتقال إلى صفحة النتائج
    router.push({ name: 'ResultPage' });
}
// ...existing code...

async function fetchQuestions() {
    const testId = getTestIdFromUrl();
    try {
        const res = await axios.get(`/api/student/question/${testId}`, {
            headers: { Authorization: `Bearer ${token.value}` }
        });
        questions.value = res.data.data || [];
        await fetchUserAnswers();
        syncSelectedAnswer();
    } catch (err) {
        console.error('Fetch Error:', err);
    }
}

async function fetchUserAnswers() {
    try {
        const res = await axios.get(`/api/student/user-answers`, {
            headers: { Authorization: `Bearer ${token.value}` }
        });
        userAnswers.value = res.data || {};
        syncSelectedAnswer();
    } catch (err) {
        console.error('Failed to fetch user answers:', err);
    }
}

function selectAnswer(answer) {
    selectedAnswer.value = answer.id;
    submitAnswer(currentQuestion.value.id, answer.id);
    // بعد اختيار إجابة، امسح الإجابات المشطوبة
    strikedAnswers.value = [];
}

function strikeAnswer(answer) {
    if (!strikedAnswers.value.includes(answer.id)) {
        strikedAnswers.value.push(answer.id);
    } else {
        strikedAnswers.value = strikedAnswers.value.filter(id => id !== answer.id);
    }
}

async function submitAnswer(questionId, answerId) {
    try {
        const res = await axios.post(
            `/api/student/submit-answer`,
            { question_id: questionId, answer_id: answerId },
            { headers: { Authorization: `Bearer ${token.value}` } }
        );
        flashMessage.value = res.data?.message || '✅ Answer submitted successfully';
        flashError.value = false;
        // حدث الإجابة في userAnswers
        userAnswers.value[questionId] = answerId;
    } catch (err) {
        flashMessage.value = err.response?.data?.message || '❌ Failed to submit answer';
        flashError.value = true;
        console.error('Submit error:', err);
    }

    setTimeout(() => {
        flashMessage.value = null;
    }, 3000);
}

function syncSelectedAnswer() {
    // لاحظ: يجب التأكد من وجود currentQuestion
    if (currentQuestion.value && userAnswers.value) {
        selectedAnswer.value = userAnswers.value[currentQuestion.value.id] ?? null;
    } else {
        selectedAnswer.value = null;
    }
}

function scrollToQuestion(index) {
    setTimeout(() => {
        const buttons = document.querySelectorAll('.question-scroll button');
        if (buttons[index]) {
            buttons[index].scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }, 100); // تأخير بسيط لضمان التحديث
}

function getTestIdFromUrl() {
    const parts = window.location.pathname.split('/');
    return parts[parts.length - 1] || null;
}

function changeQuestion(index) {
    currentIndex.value = index;
    scrollToQuestion(index);
}

function nextQuestion() {
    if (currentIndex.value < questions.value.length - 1) {
        currentIndex.value++;
        scrollToQuestion(currentIndex.value);
    }
}

function prevQuestion() {
    if (currentIndex.value > 0) {
        currentIndex.value--;
        scrollToQuestion(currentIndex.value);
    }
}

// توفير دوال التنقل للفوتر عبر provide
provide('nextQuestion', nextQuestion);
provide('prevQuestion', prevQuestion);

onMounted(fetchQuestions);
</script>

<style scoped>
::-webkit-scrollbar {
    display: none;
}
.line-through {
    text-decoration: line-through;
}
</style>
