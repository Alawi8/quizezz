<!-- ✅ Green Section -->
<div class="bg-green-500 text-white py-4 text-2xl font-bold flex justify-between px-4" x-data x-init="$store.userAuth.init()">
    <p>test</p>

    <a href="/" class="text-2xl">🏠</a>

    <template x-if="$store.userAuth.user">
        <p x-text="$store.userAuth.user.name"></p>
    </template>
</div>



<!-- ✅ Main Content -->
<template x-if="!timeUp">
    <div class="flex flex-1">
        <!-- ✅ Sidebar for Question Navigation -->
        <aside class="w-1/10 bg-white p-4 text-center border-r border-gray-300 overflow-y-auto" style="max-height: 70vh">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Questions</h3>
            <div class="flex flex-col space-y-2">
                <template x-for="(question, index) in visibleQuestions" :key="question.id || index">
                    <button class="py-2 rounded-md border font-semibold transition-all duration-200 relative pr-6"
                        :class="question.id === questions[currentIndex]?.id ?
                            'bg-blue-600 text-white border-blue-800 triangle-right' :
                            (userAnswers[question.id] ?
                                'bg-yellow-800 text-white border-yellow-900 hover:bg-yellow-900' :
                                'bg-green-500 text-white border-green-600 hover:bg-green-600')"
                        @click="selectQuestionById(question.id)">
                        <span x-text="(index + 1)">f</span>
                    </button>
                </template>
            </div>
        </aside>

        <!-- ✅ Display Question Content -->
        <main class="flex-1 bg-white p-6 flex flex-col items-start justify-center relative w-full">
            <!-- Question Title -->
            <h2 class="text-2xl font-semibold mb-6 w-full" x-text="currentTitle"></h2>

            <!-- message for answer sent -->
            <template x-if="answerSent">
                <div class="mb-4 text-green-600 font-semibold text-lg transition-all duration-300">
                    ✅ Answer sent
                </div>
            </template>

            <!-- options -->
            <ul class="space-y-4 w-full">
                <template x-for="(option, index) in Array.isArray(currentOptions) ? currentOptions : []"
                    :key="option.id ?? index">
                    <li class="w-full" @contextmenu.prevent="toggleStrikeThrough(currentIndex, index)">
                        <label
                            class="flex items-center space-x-4 w-full p-4 border rounded-lg cursor-pointer transition-all duration-300 text-lg"
                            :class="[
                                // ✅ بعد نهاية الاختبار: استخدم دالة التلوين
                                resultLoaded ? getAnswerClass(currentIndex, index) : '',
                            
                                // ✅ قبل النتيجة: اختيار المستخدم
                                (!resultLoaded &&
                                    userAnswers[questions[currentIndex].id] === option.id &&
                                    !isStrikethrough(currentIndex, index)) ?
                                'bg-green-500 text-white border-green-700' : '',
                            
                                // ✅ الإضراب بأي وقت
                                isStrikethrough(currentIndex, index) ?
                                'line-through bg-red-500 text-white opacity-75 border-red-400' : '',
                            
                                // ✅ الهوفر في الوضع العادي
                                (!resultLoaded &&
                                    !userAnswers[questions[currentIndex].id] &&
                                    !isStrikethrough(currentIndex, index)) ?
                                'hover:bg-gray-100' : ''
                            ]"
                            @click="selectAnswer(currentIndex, option.id, index)">
                            <span class="font-bold text-lg">
                                <span x-text="String.fromCharCode(65 + index)"></span>.
                            </span>

                            <span x-text="option.answer_text" class="flex-1"></span>

                            <input type="radio" :name="'question_' + currentIndex" :value="option.id"
                                x-model="userAnswers[questions[currentIndex].id]" class="hidden">

                        </label>
                    </li>
                </template>
            </ul>


        </main>
    </div>
</template>

<!-- ✅ Time Up Result -->
<template x-if="timeUp">
    <div class="flex items-center justify-center min-h-screen bg-gray-50 p-4">
        <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md text-center space-y-4">

            <!-- Final Score -->
            <h1 class="text-5xl font-bold text-green-600" x-text="'Score: ' + finalResult.score + '/100'"></h1>

            <!-- Result Details -->
            <div class="text-gray-700 text-base space-y-1">
                <p>✅ Correct Answers: <span x-text="finalResult.correct"></span></p>
                <p>❌ Total Questions: <span x-text="finalResult.total"></span></p>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-center space-x-4 pt-2">
                <button @click="clearAnswersAndRestart()"
                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                    🔁 Retry
                </button>

                <button @click="goToHome()"
                    class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800 transition">
                    🏠 Home
                </button>
            </div>

            <!-- Loading Message -->
            <template x-if="!resultLoaded">
                <p class="text-gray-400 text-sm mt-2">⏳ Calculating your result...</p>
            </template>
        </div>
    </div>
</template>
