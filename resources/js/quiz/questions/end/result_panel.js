import axios from 'axios';

export async function clearAnswersAndRestart() {
    try {
        await axios.post('/student/clear-answers'); // Laravel API call
        console.log("✅ Answers cleared from DB");
    } catch (error) {
        alert("Error clearing answers from server");
        return;
    }
    

    // Reset frontend state
    this.userAnswers = {};
    this.confirmedAnswers = {};
    this.strikethroughAnswers = {};
    this.updateProgress(); 
    this.currentIndex = 0;
    this.resultLoaded = false;
    this.finalResult = {};
    this.timeUp = false;
    this.startTimer();
    this.selectQuestion(0);
}


export function goToHome() {
    window.location.href = "/";
}
