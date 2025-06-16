import Alpine from 'alpinejs';
import userAuth from '../auth/userAuth.js';
import adminQuizManager from '../admin/app.js'; 
import registerProfileComponents from "../auth/profile/index";
// ✅ REGISTER PROFILE COMPONENTS ONCE
document.addEventListener('alpine:init', () => {
    registerProfileComponents(Alpine);
});

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.store('userAuth', userAuth());
    Alpine.data('adminQuizManager', adminQuizManager);
});

Alpine.start();
