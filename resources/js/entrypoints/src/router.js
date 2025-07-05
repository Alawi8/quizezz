// src/router.js
import { createRouter, createWebHistory } from 'vue-router'
import Home from '../components/Home.vue'
import useUserAuth from '@/composable/userAuth' // تأكد من المسار الصحيح
import SectionsComponent from '../components/SectionsComponent.vue'

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
    },

        {
        path: '/quizzes',
        name: 'quizzes',
        component: SectionsComponent,
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

// حماية الراوتات
router.beforeEach(async (to, from, next) => {
    const { token, user, init, hasAnyRole } = useUserAuth()

    if (token.value && !user.value) {
        await init()
    }

    if (to.meta.requiresAuth) {
        if (!token.value) return next('/login')
        if (to.meta.roles && !hasAnyRole(to.meta.roles)) return next('/')
    }

    next()
})

export default router
