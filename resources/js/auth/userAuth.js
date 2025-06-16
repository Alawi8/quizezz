import axios from "./axios.js";

export default function userAuth() {
    return {
        user: null,
        token: localStorage.getItem("auth_token") || null,
        loading: false,
        error: null,

        async login(email, password) {
            try {
                // ✅ SEND LOGIN REQUEST
                const response = await axios.post("/login", {
                    email,
                    password,
                });
                // ✅ SET TOKEN AND HEADERS
                this.token = response.data.token;
                localStorage.setItem("auth_token", this.token);
                axios.defaults.headers.common[
                    "Authorization"
                ] = `Bearer ${this.token}`;
                // ✅ SET USER DATA
                this.user = response.data.user;
                // ✅ FORCE REACTIVITY 
                if (Alpine?.store("userAuth")) {
                    Alpine.store("userAuth").user = this.user;
                    Alpine.store("userAuth").token = this.token;
                }
                // ✅ EXTRACT ROLE NAMES
                const roleNames = this.user.roles.map((r) => r.name);
                // ✅ REDIRECT BASED ON ROLE
                if (roleNames.includes("super-admin")) {
                    window.location.href = "/";
                } else if (roleNames.includes("student")) {
                    window.location.href = "/";
                } else {
                    window.location.href = "/";
                }
            } catch (err) {
                // ❌ HANDLE LOGIN ERROR
                this.error = "username or password is incorrect";
                console.error(
                    "Login error:",
                    err.response?.data || err.message
                );
            }
        },

        async register(name, email, password) {
            try {
                const response = await axios.post("/register", {
                    name,
                    email,
                    password,
                });
                this.token = response.data.token;
                this.user = response.data.user;
                localStorage.setItem("auth_token", this.token);
                axios.defaults.headers.common[
                    "Authorization"
                ] = `Bearer ${this.token}`;
            } catch (err) {
                this.error = "username or password is incorrect";
                console.error(
                    "Login error:",
                    err.response?.data || err.message
                );
            }
        },

        async fetchUser() {
            this.loading = true;
            try {
                if (!this.token) throw new Error("No token");
                axios.defaults.headers.common[
                    "Authorization"
                ] = `Bearer ${this.token}`;
                const response = await axios.get("/me");
                this.user = response.data;
            } catch (err) {
                this.error = "غير موثق";
                this.user = null;
                console.error(
                    "Fetch user error:",
                    err.response?.data || err.message
                );
            } finally {
                this.loading = false;
            }
        },

        async logout() {
            try {
                await axios.post("/logout");
            } catch (e) {}
            localStorage.removeItem("auth_token");
            delete axios.defaults.headers.common["Authorization"];
            this.user = null;
            this.token = null;
            window.location.href = "/";
        },

        init: async function () {
            if (this.token) {
                if (window.location.pathname !== "/login") {
                    axios.defaults.headers.common[
                        "Authorization"
                    ] = `Bearer ${this.token}`;
                    await this.fetchUser();
                }
            } else {
                this.user = null;
            }
        },

        protectAdminPage: async function (requiredRoles = ["super-admin","admin"]) {
            console.log("🔐 CHECKING ACCESS CONTROL FOR:", requiredRoles);
        
            if (!this.token) {
                console.warn("🔒 NO TOKEN FOUND, REDIRECTING TO /login...");
                window.location.href = "/login";
                return false;
            }
        
            try {
                await this.fetchUser();
            } catch (e) {
                console.error("❌ FAILED TO FETCH USER:", e);
                window.location.href = "/login";
                return false;
            }
        
            if (!this.user || !Array.isArray(this.user.roles)) {
                console.warn("❌ USER OR ROLES MISSING - REDIRECTING TO /login...");
                window.location.href = "/login";
                return false;
            }
        
            const userRoles = this.user.roles.map(r => r.name);
            const hasPermission = requiredRoles.some(role => userRoles.includes(role));
        
            if (hasPermission) {
                console.log("✅ ACCESS GRANTED. USER ROLES:", userRoles);
                return true;
            }
        
            console.warn("⛔ UNAUTHORIZED. Redirecting to home...");
            window.location.href = "/";
            return false;
        }
        
    };
}
