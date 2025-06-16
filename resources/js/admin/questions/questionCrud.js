import axios from "axios";

export default function questionManager() {
    return {
        questions: [],
        tests: [],
        selectedTestId: null,
        editingQuestion: null,
        deletingQuestion: null,
        showForm: false,

        currentPage: 1,
        lastPage: 1,
        perPage: 10,
        total: 0,

        flashMessage: null,
        flashType: 'success',

        newQuestion: {
            question_text: "",
            test_id: "",
            answers: [
                { id: Date.now(), answer_text: "", is_correct: false },
                { id: Date.now() + 1, answer_text: "", is_correct: false },
            ],
        },

        // ✅ fetch questions with pagination
        async fetchQuestions(page = 1) {
            try {
                const res = await axios.get("/admin/questions", {
                    params: {
                        page: page,
                        per_page: this.perPage,
                        test_id: this.selectedTestId || undefined,
                    },
                });

                this.questions = res.data.data;
                this.currentPage = res.data.current_page;
                this.lastPage = res.data.last_page;
                this.total = res.data.total;
            } catch (err) {
                console.error("❌ Failed to load questions", err);
                this.setFlash("❌ Failed to load questions", "error");
            }
        },

        async filterByTest(testId) {
            this.selectedTestId = testId;
            this.currentPage = 1;
            await this.fetchQuestions();
        },

        // ✅ pagination controls
        nextPage() {
            if (this.currentPage < this.lastPage) {
                this.fetchQuestions(this.currentPage + 1);
            }
        },

        prevPage() {
            if (this.currentPage > 1) {
                this.fetchQuestions(this.currentPage - 1);
            }
        },

        // ✅ flash helper
        setFlash(message, type = 'success') {
            this.flashMessage = message;
            this.flashType = type;
            setTimeout(() => {
                this.flashMessage = null;
            }, 4000);
        },

        addAnswer() {
            this.newQuestion.answers.push({
                id: Date.now() + Math.random(),
                answer_text: "",
                is_correct: false,
            });
        },

        removeAnswer(index) {
            this.newQuestion.answers.splice(index, 1);
        },

        setCorrect(index) {
            this.newQuestion.answers.forEach((a, i) => {
                a.is_correct = i === index;
            });
        },

        resetForm() {
            this.newQuestion = {
                question_text: "",
                test_id: "",
                answers: [
                    { id: Date.now(), answer_text: "", is_correct: false },
                    { id: Date.now() + 1, answer_text: "", is_correct: false },
                ],
            };
            this.editingQuestion = null;
            this.showForm = false;
        },

        toggleForm() {
            if (this.showForm) {
                this.closeForm();
            } else {
                this.resetForm();
                this.showForm = true;
            }
        },

        closeForm() {
            this.showForm = false;
            this.resetForm();
        },

        edit(q) {
            this.newQuestion = {
                question_text: q.question_text || "",
                test_id: q.test_id || "",
                answers: Array.isArray(q.answers)
                    ? q.answers.map((a) => ({
                          id: Date.now() + Math.random(),
                          answer_text: a.answer_text || "",
                          is_correct: a.is_correct || false,
                      }))
                    : [],
            };
            this.editingQuestion = q.id;
        },

        async addQuestion() {
            if (this.editingQuestion !== null) return;

            const { question_text, test_id, answers } = this.newQuestion;

            if (!question_text.trim() || !test_id) {
                alert("Question text and test are required");
                return;
            }

            if (answers.length < 2) {
                alert("Please add at least two answers");
                return;
            }

            const correctAnswers = answers.filter((a) => a.is_correct);
            if (correctAnswers.length !== 1) {
                alert("Please select exactly one correct answer");
                return;
            }

            const payload = {
                question_text,
                test_id,
                answers: answers.map(({ answer_text, is_correct }) => ({
                    answer_text,
                    is_correct,
                })),
            };

            try {
                const res = await axios.post("/admin/questions", payload);

                this.setFlash(res.data.message, 'success');

                this.questions.push({
                    ...res.data,
                    answers: Array.isArray(res.data.answers)
                        ? res.data.answers
                        : [],
                });

                this.resetForm();
            } catch (err) {
                console.error("❌ Error creating question:", err);
                this.setFlash("❌ Failed to add question", "error");
            }
        },

        async updateQuestion() {
            try {
                const payload = {
                    question_text: this.newQuestion.question_text,
                    test_id: this.newQuestion.test_id,
                    answers: this.newQuestion.answers.map(
                        ({ answer_text, is_correct }) => ({
                            answer_text,
                            is_correct,
                        })
                    ),
                };

                const res = await axios.put(
                    `/admin/questions/${this.editingQuestion}`,
                    payload,
                    {
                        headers: {
                            "Content-Type": "application/json",
                        },
                    }
                );

                const i = this.questions.findIndex(
                    (q) => q.id === this.editingQuestion
                );
                if (i !== -1) {
                    this.questions[i] = res.data.data ?? res.data;
                }

                this.setFlash(res.data.message || "✅ Question updated successfully", 'success');

                this.resetForm();
            } catch (err) {
                console.error("❌ Failed to update question", err.response?.data || err);
                this.setFlash(err.response?.data?.message || "❌ Failed to update question", 'error');
            }
        },

        confirmDelete(q) {
            this.deletingQuestion = q;
        },

        async deleteConfirmed() {
            try {
                await axios.delete(`/admin/questions/${this.deletingQuestion.id}`);
                this.questions = this.questions.filter(
                    (q) => q.id !== this.deletingQuestion.id
                );
                this.deletingQuestion = null;
            } catch (err) {
                alert("❌ Failed to delete question");
            }
        },

        async deleteAllQuestions() {
            if (!confirm("⚠️ Are you sure you want to delete ALL questions? This cannot be undone.")) {
                return;
            }

            try {
                await axios.delete("/admin/questions");
                this.questions = [];
                this.setFlash("✅ All questions deleted.", "success");
            } catch (err) {
                console.error("❌ Failed to delete all questions", err);
                this.setFlash("❌ Failed to delete all questions.", "error");
            }
        },
    };
}
