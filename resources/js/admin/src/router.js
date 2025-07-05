import { createRouter, createWebHistory } from 'vue-router'
import Home from '../components/Dashboard.vue'
import Questions from '../components/Questions.vue'
// import Settings from '../components/Settings.vue'

import useUserAuth from '@/composable/userAuth'
import Sections from "@/admin/components/Sections.vue";
import Users from "@/admin/components/Users.vue";
import Settings from "@/admin/components/Settings.vue";

const routes = [
    {
        path: '/admin/dashboard',
        name: 'DashboardHome',
        component: Home,
        meta: { requiresAuth: true },
    },
    {
        path: '/admin/dashboard/questions',
        name: 'Questions',
        component: Questions,
        meta: { requiresAuth: true, roles: ['super-admin', 'admin' ] },
    },
    {
        path: '/admin/dashboard/sections',
        name: 'Sections',
        component: Sections,
        meta: { requiresAuth: true, roles: ['super-admin', 'admin' ] },
    },
    {
        path: '/admin/dashboard/users',
        name: 'Users',
        component: Users,
        meta: { requiresAuth: true, roles: ['super-admin', 'admin' ] },
    },
    {
        path: '/admin/dashboard/settings',
        name: 'Settings',
        component: Settings,
        meta: { requiresAuth: true, roles: ['super-admin' ,'admin'] },
    },

]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

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
