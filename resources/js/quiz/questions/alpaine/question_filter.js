export function getFilteredQuestions(questions, userAnswers, filter) {
    const selected = filter.selected;

    return questions.filter((q) => {
        const hasAnswer =
            Object.prototype.hasOwnProperty.call(userAnswers, q.id) &&
            userAnswers[q.id] !== null &&
            userAnswers[q.id] !== "";

        const isFlagged = q.isFlagged === true;

        if (selected === "answered") return hasAnswer;
        if (selected === "unanswered") return !hasAnswer;
        if (selected === "flagged") return isFlagged;

        return true; // default: show all
    });
}