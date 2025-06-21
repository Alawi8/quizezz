import { ref } from 'vue'
import axios from './axios.js'

const user = ref(null)
const token = ref(localStorage.getItem('auth_token') || null)
const error = ref(null)
const loading = ref(false)

if (token.value) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`
}

async function login(email, password) {
    try {
        const res = await axios.post('/api/login', { email, password })

        token.value = res.data.token
        user.value = normalizeUser(res.data.user)

        localStorage.setItem('auth_token', token.value)
        axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`

        return { success: true }
    } catch (err) {
        error.value = err.response?.data?.message || 'Login failed'
        return { success: false, message: error.value }
    }
}

async function register(name, email, password) {
    try {
        const res = await axios.post('/api/register', { name, email, password })

        token.value = res.data.token
        user.value = normalizeUser(res.data.user)

        localStorage.setItem('auth_token', token.value)
        axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`

        return { success: true }
    } catch (err) {
        error.value = err.response?.data?.message || 'Registration failed'
        return { success: false, message: error.value }
    }
}

async function fetchUser() {
    loading.value = true
    try {
        const res = await axios.get('/api/me')
        user.value = normalizeUser(res.data)
    } catch (err) {
        user.value = null
        error.value = 'Unauthenticated'
        console.error('Fetch user error:', err)
    } finally {
        loading.value = false
    }
}

async function logout() {
    try {
        await axios.post('/api/logout')
    } catch (_) {}

    localStorage.removeItem('auth_token')
    delete axios.defaults.headers.common['Authorization']
    user.value = null
    token.value = null

    error.value = 'You have been logged out.'
}

async function init() {
    if (token.value) {
        await fetchUser()
    }
}

function hasRole(role) {
    return user.value?.roles?.includes(role)
}

function hasAnyRole(roles = []) {
    return roles.some(r => hasRole(r))
}

function normalizeUser(u) {
    return {
        ...u,
        roles: Array.isArray(u.roles) && u.roles.length && typeof u.roles[0] === 'object'
            ? u.roles.map(r => r.name)
            : u.roles,
    }
}

export default function useUserAuth() {
    return {
        user,
        token,
        error,
        loading,
        login,
        register,
        logout,
        fetchUser,
        init,
        hasRole,
        hasAnyRole,
    }
}
