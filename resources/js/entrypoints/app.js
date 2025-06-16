import './bootstrap';
import Alpine from "alpinejs";
import userAuth from '../auth/userAuth.js';
import chooseSections from '../quiz/sections/chooseSections.js';
import '../quiz/quizManager'; // إذا فيه x-data مسجل داخله

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.store('userAuth', userAuth()); 
    Alpine.data("chooseSections", chooseSections);
});

Alpine.start();
