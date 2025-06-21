// resources/js/quiz/router.js
import { createRouter, createWebHistory } from 'vue-router'
import QuizPage from '../components/QuizPage.vue'

const routes = [
    {
        path: '/qustions/:test_id',
        name: 'quiz',
        component: QuizPage,
        meta: { requiresAuth: true, roles: ['student' , 'super-admin'] }
    }

]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
