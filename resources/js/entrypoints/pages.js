import './bootstrap';
import Alpine from "alpinejs";
import userAuth from '../auth/userAuth.js';
import '../quiz/quizManager';
import chooseSections from '../quiz/sections/chooseSections.js';

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.store('userAuth', userAuth()); // ✅ سجل store بشكل صحيح
    Alpine.data("chooseSections", chooseSections);
});

Alpine.start();
