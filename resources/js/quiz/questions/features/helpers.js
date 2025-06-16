export function updateProgress() {
    if (!Array.isArray(this.questions)) {
        console.error("questions is not an array:", this.questions);
        this.progress = 0;
        return;
    }

    const answeredCount = this.questions.filter((q) =>
        this.userAnswers[q.id] !== null && this.userAnswers[q.id] !== undefined
    ).length;

    this.progress = (answeredCount / this.questions.length) * 100;

    if (answeredCount === this.questions.length && !this.resultLoaded) {
        this.resultLoaded = true;
    }
}


export function toggleDarkMode() {
    this.isDarkMode = !this.isDarkMode;
    document.documentElement.classList.toggle("dark", this.isDarkMode);
    localStorage.setItem("darkMode", this.isDarkMode);
}

import { submitAnswer } from "../alpaine/submission";

export function selectAnswer(questionIndex, answerId, optionIndex) {
    if (this.isStrikethrough(questionIndex, optionIndex)) return;

    const question = this.questions[questionIndex];
    const questionId = question.id;

    const selected = question.answers.find(ans => ans.id === answerId);
    if (!selected) {
        console.error("❌ answer not found:", answerId);
        return;
    }

    const previousAnswer = this.userAnswers[questionId];
    if (previousAnswer === selected.id && this.confirmedAnswers[questionId] === selected.id) {
        return;
    }

    this.userAnswers[questionId] = selected.id;
    this.updateProgress?.();

    submitAnswer.call(this, questionId, selected); 
}






export function toggleStrikeThrough(questionIndex, optionIndex) {
    if (!this.strikethroughAnswers[questionIndex]) {
        this.strikethroughAnswers[questionIndex] = {};
    }
    this.strikethroughAnswers[questionIndex][optionIndex] =
        !this.strikethroughAnswers[questionIndex][optionIndex];
    if (
        this.strikethroughAnswers[questionIndex][optionIndex] &&
        this.userAnswers[questionIndex] ===
        this.questions[questionIndex].answers[optionIndex].answer_text
    ) {
        this.userAnswers[questionIndex] = null;
    }
}

export function isStrikethrough(questionIndex, optionIndex) {
    return (
        this.strikethroughAnswers[questionIndex] &&
        this.strikethroughAnswers[questionIndex][optionIndex]
    );
}

