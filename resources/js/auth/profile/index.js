import profilePage from "./profilePage.js";
import infoForm from "./infoForm.js";
import updatePassword from "./updatePassword.js";
import deleteAccount from "./deleteAccount.js";

export default function registerProfileComponents(Alpine) {
    Alpine.data('profilePage', profilePage);
    Alpine.data('infoForm', infoForm);
    Alpine.data('updatePasswordForm', updatePassword);
    Alpine.data('deleteAccountForm', deleteAccount);
}
