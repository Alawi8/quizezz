// import axios from "axios";

export async function endQuiz() {
    this.timeUp = true;
    clearInterval(this.timer);

    const allAnswered = this.questions.every(q => this.userAnswers[q.id]);
    if (!allAnswered) {
        alert("❌ Please answer all questions before ending the quiz.");
        this.timeUp = false;
        return;
    }

    const hasPending = () =>
        Object.values(this.isSubmittingAnswer || {}).some(v => v === true);

    while (hasPending()) {
        console.log("⏳ Waiting for pending submissions...");
        await new Promise(resolve => setTimeout(resolve, 200));
    }

    try {
        const response = await axios.get(`/student/final-result/${this.testId}`);
        this.finalResult = response.data;
    } catch (error) {
        console.error("Failed to load result:", error);
        this.finalResult = { correct: 0, total: 0, score: 0 };
    }

    this.resultLoaded = true;
}



export function confirmEndQuiz() {
    this.timeUp = true;
    clearInterval(this.timer);
    this.showEndTestModal = false;
}

// this function is used after the quiz is ended
export function getAnswerClass(questionIndex, optionIndex) {
    if (!this.resultLoaded) return '';

    const question = this.questions[questionIndex];
    const answer = question.answers[optionIndex];
    const userAnswerId = this.userAnswers[question.id];
    const isUserAnswer = answer.id === userAnswerId;
    const isCorrect = Boolean(answer.is_correct); 

    if (isUserAnswer && isCorrect) {
        return 'bg-green-500 text-white border-green-700';
    }

    if (isUserAnswer && !isCorrect) {
        return 'bg-red-500 text-white border-red-700';
    }

    if (!isUserAnswer && isCorrect) {
        return 'bg-green-200 text-green-800 border-green-300';
    }

    return '';
}



export function getOptionClasses(index, optionId) {
    const questionId = this.questions[this.currentIndex]?.id;

    if (this.resultLoaded) {
        return this.getAnswerClass(this.currentIndex, index);
    }

    if (
        this.userAnswers[questionId] === optionId &&
        !this.isStrikethrough(this.currentIndex, index)
    ) {
        return 'bg-green-500 text-white border-green-700';
    }

    if (this.isStrikethrough(this.currentIndex, index)) {
        return 'line-through bg-red-500 text-white opacity-75 border-red-400';
    }

    if (
        !this.userAnswers[questionId] &&
        !this.isStrikethrough(this.currentIndex, index)
    ) {
        return 'hover:bg-gray-100';
    }

    return '';
}
