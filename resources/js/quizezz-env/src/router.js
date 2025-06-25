import { createRouter, createWebHistory } from 'vue-router'
import useUserAuth from '@/composable/userAuth.js'
import NotAuthorized from '@/quizezz-env/components/NotAuthorized.vue'
import QuizPage from "@/quizezz-env/components/QuizPage.vue";
import Results from "@/quizezz-env/components/Results.vue";
import ReviewAnswers from "@/quizezz-env/components/quiz/ReviewAnswers.vue";

const routes = [
    {
        path: '/questions/:test_id',
        name: 'quiz',
        component: QuizPage,
        props: true,
        meta: {
            requiresAuth: true,
            roles: ['student', 'super-admin']
        }
    },
    {
        path: '/unauthorized',
        name: 'unauthorized',
        component: NotAuthorized,
        props: true,
    },
    {
        path: '/questions/:test_id/re',
        name: 'Result',
        component: Results,
        props: true,
    },
    {
        path: '/questions/:test_id/review',
        name: 'Review',
        component: ReviewAnswers,
        props: true,
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach(async (to, from, next) => {
    const auth = useUserAuth()
    const token = localStorage.getItem('auth_token')

    // إذا ما فيه توكن → ممنوع
    if (!token) {
        return next({ name: 'unauthorized' })
    }

    // تحميل بيانات المستخدم إذا غير موجودة
    if (!auth.user.value) {
        try {
            await auth.fetchUser()
        } catch (e) {
            return next({ name: 'unauthorized' })
        }
    }

    if (to.meta.requiresAuth) {
        const allowedRoles = to.meta.roles || []
        const hasAccess = allowedRoles.some(role => auth.hasRole(role))

        if (!hasAccess) {
            return next({ name: 'unauthorized', query: { test_id: to.params.test_id } })
        }
    }

    return next()
})

export default router
