// IMPORTS
import Alpine from "alpinejs";
import copyToClipboard from "./sections/testManager";
import sectionManager from "./sections/sectionsCrud";
import questionManager from './questions/questionCrud';
import userManager from "./users/usersMangment";
import systemSettings from "./questions/systemSettings";

// ✅ MAIN ADMIN MODULE
export default function AdminQuizManager() {
    return {
        currentTab: 'questions',
        loading: false,

        sectionManager: sectionManager(),
        questionManager: questionManager(),
        userManager: userManager(),
        systemSettings: systemSettings(),

        copySectionId(id) {
            copyToClipboard(id);
        },
    };
}
