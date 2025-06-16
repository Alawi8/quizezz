export async function init() {
  try {
      // ✅ Check if test ID exists
      if (!this?.testId) return;

      // ✅ Apply Dark Mode if needed
      this.toggleDarkMode(this.isDarkMode);

      // ✅ Fetch questions for the test
      const { data } = await axios.get(`/student/question/${this.testId}`);
      if (!data?.data?.length) return;

      this.questions = data.data;
      this.selectQuestion(0);

      // ✅ Load user answers and start the timer
      const [answersRes] = await Promise.all([
          axios.get("/user-answers"),
          this.startTimer(),
      ]);

      this.userAnswers = answersRes.data;
      this.updateProgress();

  } catch (error) {
      // ❗ Show only generic fallback when something is seriously broken
      this.showPopup = true;
      this.popupMessage = "⚠️ Something went wrong. Please refresh and try again.";
  }
}
