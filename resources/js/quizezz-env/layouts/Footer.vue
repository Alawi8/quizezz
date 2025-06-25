<script setup lang="ts">
import { inject, ref } from 'vue'
import {
    Settings, HelpCircle, Calculator, ChevronRight,
    ChevronLeft, Filter, MessageCircle, Flag
} from 'lucide-vue-next'

const prevQuestion = inject('prevQuestion')
const nextQuestion = inject('nextQuestion')

const showSettings = ref(false)
const showHelp = ref(false)
const showCalculator = ref(false)
const showFilter = ref(false)
const isDarkMode = ref(false)

const toggleDarkMode = () => {
    document.documentElement.classList.toggle('dark', isDarkMode.value)
}

// آلة حاسبة
const calcDisplay = ref('')
const appendCalc = (val: string) => calcDisplay.value += val
const clearCalc = () => calcDisplay.value = ''
const calculate = () => {
    try {
        calcDisplay.value = eval(calcDisplay.value).toString()
    } catch {
        calcDisplay.value = 'Error'
    }
}
</script>

<template>
    <footer class="bg-green-600 text-white p-4 rounded-t-xl shadow-lg dark:bg-black fixed bottom-0 inset-x-0 z-40">
        <div class="flex flex-wrap justify-between items-center gap-2">
            <!-- Left Buttons -->
            <div class="flex flex-wrap gap-2">
                <button @click="showSettings = true" class="bg-white text-green-600 p-2 rounded-full shadow"><Settings class="w-5 h-5" /></button>
                <button @click="showFilter = true" class="bg-white text-green-600 p-2 rounded-full shadow"><Filter class="w-5 h-5" /></button>
                <button @click="showHelp = true" class="bg-white text-green-600 p-2 rounded-full shadow"><HelpCircle class="w-5 h-5" /></button>
                <button @click="showCalculator = true" class="bg-white text-green-600 p-2 rounded-full shadow"><Calculator class="w-5 h-5" /></button>
            </div>

            <!-- Right Buttons -->
            <div class="flex flex-wrap gap-2">
                <button class="bg-white text-green-600 p-2 rounded-full shadow"><MessageCircle class="w-5 h-5" /></button>
                <button class="bg-white text-green-600 p-2 rounded-full shadow"><Flag class="w-5 h-5" /></button>
                <button @click="prevQuestion && prevQuestion()" class="bg-white text-green-600 p-2 rounded-full shadow">
                    <ChevronLeft class="w-5 h-5" />
                </button>
                <button @click="nextQuestion && nextQuestion()" class="bg-white text-green-600 p-2 rounded-full shadow">
                    <ChevronRight class="w-5 h-5" />
                </button>
            </div>
        </div>

        <!-- Settings Modal -->
        <div v-if="showSettings" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg w-80 text-black shadow">
                <h2 class="text-lg font-bold mb-4">Settings</h2>
                <label class="flex items-center gap-2">
                    <input type="checkbox" v-model="isDarkMode" @change="toggleDarkMode" />
                    <span>Dark Mode</span>
                </label>
                <button @click="showSettings = false" class="mt-4 w-full bg-green-600 text-white py-2 rounded">Close</button>
            </div>
        </div>

        <!-- Help Modal -->
        <div v-if="showHelp" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg w-96 text-black shadow overflow-y-auto max-h-[80vh]">
                <h2 class="text-lg font-bold mb-4">📘 How to use the platform</h2>
                <ul class="list-disc list-inside space-y-2 text-sm">
                    <li>🚀 المنصة توفر لك اختباراً تفاعلياً بأسئلة متعددة.</li>
                    <li>🟢 يمكنك الإجابة، مراجعة، أو وضع علامة على كل سؤال.</li>
                    <li>⚙ استخدم زر الإعدادات لتفعيل الوضع الداكن.</li>
                    <li>🧒 استخدم الآلة الحاسبة للحسابات السريعة.</li>
                    <li>🔍 زر الفلترة يساعدك في استعراض الأسئلة التي أجبت عليها أو لم تُجب.</li>
                    <li>⬅ ➡ استخدم أسهم التنقل للانتقال بين الأسئلة.</li>
                </ul>
                <button @click="showHelp = false" class="mt-4 w-full bg-green-600 text-white py-2 rounded">Got it</button>
            </div>
        </div>

        <!-- Filter Modal -->
        <div v-if="showFilter" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg w-80 text-black shadow">
                <h2 class="text-lg font-bold mb-4">Filter Questions</h2>
                <div class="flex flex-col gap-2">
                    <button class="bg-green-100 text-green-800 py-2 rounded">All Questions</button>
                    <button class="bg-green-100 text-green-800 py-2 rounded">Answered</button>
                    <button class="bg-green-100 text-green-800 py-2 rounded">Unanswered</button>
                </div>
                <button @click="showFilter = false" class="mt-4 w-full bg-green-600 text-white py-2 rounded">Close</button>
            </div>
        </div>

        <!-- Calculator Modal -->
        <div v-if="showCalculator" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg w-80 text-black shadow space-y-2">
                <h2 class="text-lg font-bold">🤮 Calculator</h2>
                <input type="text" v-model="calcDisplay" class="w-full border p-2 rounded text-right" readonly />
                <div class="grid grid-cols-4 gap-2">
                    <button @click="appendCalc('7')" class="bg-green-100 py-2 rounded">7</button>
                    <button @click="appendCalc('8')" class="bg-green-100 py-2 rounded">8</button>
                    <button @click="appendCalc('9')" class="bg-green-100 py-2 rounded">9</button>
                    <button @click="appendCalc('/')" class="bg-green-200 py-2 rounded">÷</button>

                    <button @click="appendCalc('4')" class="bg-green-100 py-2 rounded">4</button>
                    <button @click="appendCalc('5')" class="bg-green-100 py-2 rounded">5</button>
                    <button @click="appendCalc('6')" class="bg-green-100 py-2 rounded">6</button>
                    <button @click="appendCalc('*')" class="bg-green-200 py-2 rounded">×</button>

                    <button @click="appendCalc('1')" class="bg-green-100 py-2 rounded">1</button>
                    <button @click="appendCalc('2')" class="bg-green-100 py-2 rounded">2</button>
                    <button @click="appendCalc('3')" class="bg-green-100 py-2 rounded">3</button>
                    <button @click="appendCalc('-')" class="bg-green-200 py-2 rounded">−</button>

                    <button @click="clearCalc()" class="bg-red-200 py-2 rounded">C</button>
                    <button @click="appendCalc('0')" class="bg-green-100 py-2 rounded">0</button>
                    <button @click="calculate()" class="bg-green-500 text-white py-2 rounded">=</button>
                    <button @click="appendCalc('+')" class="bg-green-200 py-2 rounded">+</button>
                </div>
                <button @click="showCalculator = false" class="w-full mt-4 bg-green-600 text-white py-2 rounded">Close</button>
            </div>
        </div>
    </footer>
</template>

<style scoped>
html.dark {
    background-color: #111;
    color: white;
}
</style>
