import axios from "@/auth/axios";

export default function chooseSections() {
    return {
        tests: [],
        loading: false,
        errorMessage: null,

        async fetchTests() {
            this.loading = true;
            this.errorMessage = null;

            try {
                const auth = Alpine.store("userAuth");

                // ✅ CHECK IF TOKEN EXISTS
                if (!auth?.token) {
                    this.errorMessage = "🚫 Unauthorized: No token found.";
                    return;
                }

                axios.defaults.headers.common["Authorization"] = `Bearer ${auth.token}`;

                // ✅ ENSURE USER DATA EXISTS
                const user = auth.user;
                if (!user || !Array.isArray(user.roles)) {
                    this.errorMessage = "🚫 Invalid user data.";
                    return;
                }

                const roles = user.roles.map(r => r.name);

                // ✅ ALLOW STUDENT AND SUPER ADMIN ONLY
                const allowed = ["student", "super-admin"];
                const hasAccess = roles.some(role => allowed.includes(role));

                if (!hasAccess) {
                    this.errorMessage = "🚫 Access denied.";
                    return;
                }

                // ✅ FETCH TESTS
                const res = await axios.get("/student/display");
                this.tests = res.data.data;

            } catch (err) {
                this.errorMessage = "❌ Failed to load tests.";
                console.error("FETCH ERROR:", err);
                const res = await axios.get("/student/display");
console.log("✅ TEST RESPONSE:", res.data);
this.tests = res.data?.data ?? res.data;

            } finally {
                this.loading = false;
            }
        },

        loadQuestions(id) {
            window.location.href = `/questions?test_id=${id}`;
        },

        init() {
            this.fetchTests();
        }
    };
}
