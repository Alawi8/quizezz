import Alpine from "alpinejs";
import state from "./questions/features/state";

// Core Logic
import { init } from "./questions/features/init";
import {
    updateProgress,
    toggleDarkMode,
    selectAnswer,
    toggleStrikeThrough,
    isStrikethrough,

} from "./questions/features/helpers";
import logger from "./questions/features/logger";

// Navigation & sending questions
import { nextQuestion , prevQuestion } from "./questions/features/navigation";
import {  selectQuestion , submitAnswer} from "./questions/alpaine/submission";

// Timer & UI
import { updateTimerDisplay, startTimer } from "./questions/ui/timer";
import { calculate } from "./questions/ui/calculator";

// Results & Panels
import { endQuiz, confirmEndQuiz , getAnswerClass} from "./questions/end/result";
import { clearAnswersAndRestart, goToHome } from "./questions/end/result_panel";

// Filters & Display
import { getFilteredQuestions } from "./questions/alpaine/question_filter";

import chooseSections from "./sections/chooseSections";

export default Alpine.data("quizManager", () => ({
    // 🧠 App State
    ...state,
    logger,

    // 🚀 Initialization
    init,

    // 🎮 Navigation & Selection
    selectQuestion,
    selectQuestionById(id) {
        const index = this.questions.findIndex((q) => q.id === id);
        if (index !== -1) this.selectQuestion(index);
        else console.warn("❌ Question not found for ID:", id);
    },
    nextQuestion,
    submitAnswer,
    prevQuestion,

    // ✅ Answering & Logic
    selectAnswer,
    toggleStrikeThrough,
    isStrikethrough,
    updateProgress,

    // 🌓 UI & Theme
    toggleDarkMode,
    updateTimerDisplay,
    startTimer,

    // 🧮 Other Utilities
    calculate,

    // 🏁 End of Quiz
    endQuiz,
    confirmEndQuiz,
    getAnswerClass,
    clearAnswersAndRestart,
    goToHome,
    chooseSections,

    // 🔍 Filtered Questions View
    get visibleQuestions() {
        return getFilteredQuestions(
            this.questions,
            this.userAnswers,
            this.filter
        );
    },

    // 👀 Watchers
    watch: {
        "filter.selected": function () {
            this.currentIndex = 0;
            const firstVisible = this.visibleQuestions[0];
            if (firstVisible) {
                const indexInAll = this.questions.findIndex(
                    (q) => q.id === firstVisible.id
                );
                if (indexInAll !== -1) {
                    this.selectQuestion(indexInAll);
                }
            }
        },
    },
}));