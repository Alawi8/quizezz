import axios from "axios";


export async function submitAnswer(questionId, selectedAnswer) {
    const question = this.questions.find(q => q.id === questionId);
    if (!question || !selectedAnswer?.id) return;

    this.isSubmittingAnswer = this.isSubmittingAnswer || {};
    if (this.isSubmittingAnswer[questionId]) return;

    this.isSubmittingAnswer[questionId] = true;

    try {
        await axios.post("/student/submit-answer", {
            question_id: questionId,
            answer_id: selectedAnswer.id,
        });

        this.confirmedAnswers[questionId] = selectedAnswer.id;
        this.answerSent = true;
        setTimeout(() => this.answerSent = false, 2000);
    } catch (err) {
        console.error("❌ Could not submit answer:", err);
        alert("❌ Could not submit answer.");
    } finally {
        this.isSubmittingAnswer[questionId] = false;
    }
}





export function selectQuestion(index) {
    const question = this.questions[index];

    if (!question || !Array.isArray(question.answers)) {
        console.warn("❌ Invalid question or missing answers at index:", index);
        this.currentTitle = "⚠️ Question not available";
        this.currentOptions = []; 
        return;
    }

    this.currentIndex = index;
    this.currentTitle = question.question_text;
    this.currentOptions = question.answers;
}


