<script setup>
import { ref, watch, onMounted } from 'vue'
import { AlarmClock, XCircle, LogOut } from 'lucide-vue-next'

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
    <header class="bg-black text-white p-4 rounded-b-xl shadow-md w-full">
        <div class="flex flex-wrap md:flex-nowrap items-center justify-between gap-4">
            <!-- Timer -->
            <div class="flex items-center gap-2">
                <AlarmClock class="w-5 h-5 text-white" />
                <span>{{ formatTime(timeLeft) }}</span>
            </div>

            <!-- End Test Icon -->
            <div v-if="testEnded" class="flex items-center gap-2 text-red-500 font-bold">
                <XCircle class="w-5 h-5" />
                <span>The test has ended</span>
            </div>

            <!-- Exit Button or other control -->
            <div class="flex items-center gap-2 ml-auto">
                <LogOut class="w-5 h-5 text-white cursor-pointer" title="Exit Test" />
            </div>
        </div>
    </header>
</template>
