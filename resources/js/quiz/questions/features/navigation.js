export function prevQuestion() {
    if (this.currentIndex > 0) {
        this.selectQuestion(this.currentIndex - 1);
    }
}

export function nextQuestion() {
    if (this.currentIndex < this.questions.length - 1) {
        this.selectQuestion(this.currentIndex + 1);
    } else {
        this.showEndTestModal = true;
    }
}