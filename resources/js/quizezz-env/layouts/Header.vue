<script setup>
import { ref, watch, onMounted } from 'vue'
import {
    AlarmClock,
    XCircle,
    LogOut,
    BarChart2,
    FileText,
    FolderOpen,
    Settings,
    LayoutDashboard
} from 'lucide-vue-next'
import Navbar from "@/quizezz-env/layouts/Navbar.vue";

const props = defineProps({
    duration: Number // مدة الاختبار بالثواني
})

const emit = defineEmits(['time-up'])

const timeLeft = ref(props.duration || 0)
const intervalId = ref(null)
const testEnded = ref(false)

const formatTime = (seconds) => {
    const min = Math.floor(seconds / 60)
    const sec = seconds % 60
    return `${min}:${sec < 10 ? '0' : ''}${sec}`
}

function startTimer() {
    timeLeft.value = props.duration
    intervalId.value = setInterval(() => {
        if (timeLeft.value > 0) {
            timeLeft.value--
        } else {
            clearInterval(intervalId.value)
            testEnded.value = true
            emit('time-up')
            alert('The test has ended')
        }
    }, 1000)
}

watch(() => props.duration, (newVal) => {
    if (newVal && !intervalId.value) startTimer()
})

onMounted(() => {
    if (props.duration) startTimer()
})
</script>

<template>
    <header
        class="sticky top-0 z-50 bg-black text-white m-0 p-0 w-full shadow-md rounded-b-xl rounded-t-none border-b border-white/10"
    >


        <!-- Main Header Section -->
        <div
            class="flex items-center justify-between flex-wrap gap-4 px-4 py-2"
        >
            <!-- Section Icon and Info -->
            <div class="flex items-center gap-2">
                <LayoutDashboard class="w-6 h-6 text-white hover:text-green-400 transition duration-200" />
                <span class="text-sm">قسم الأسئلة</span>
            </div>

            <!-- Timer -->
            <div class="flex items-center gap-2 mx-auto">
                <AlarmClock class="w-6 h-6 text-white animate-pulse" />
                <span class="text-base font-semibold tracking-wide">{{ formatTime(timeLeft) }}</span>
            </div>

            <!-- Exit / End Icon -->
            <a href="/" class="flex items-center gap-3">
                <template v-if="testEnded">
                    <XCircle class="w-6 h-6 text-red-500 hover:scale-110 transition duration-200" title="Test Ended" />
                </template>
                <LogOut
                    class="w-6 h-6 text-white cursor-pointer hover:text-red-400 transition duration-200"
                    title="Exit Test"
                />
            </a>
        </div>
    </header>
</template>



