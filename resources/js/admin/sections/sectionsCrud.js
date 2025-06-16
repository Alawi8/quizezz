import axios from "axios";

export default function sectionManager() {
    return {
        tests: [],
        loading: false,
        showForm: false, // ✅ Toggle for form
        flashMessage: null, // ✅ Flash message
        flashType: 'success', // ✅ success | error

        totalUsers: 0,
        totalQuestions: 0,
        totalTests: 0,
        totalAnswers: 0,

        // section being created
        newTest: {
            title: '',
            description: '',
            duration: 30
        },

        // section being edited
        editingTest: null,

        // section being deleted
        deletingTest: null,

        // ✅ toggle form view
        toggleForm() {
            this.showForm = !this.showForm;
            if (this.showForm) {
                this.resetForm();
            }
        },

        // ✅ reset form data
        resetForm() {
            this.newTest = {
                title: '',
                description: '',
                duration: 30
            };
        },

        // ✅ fetch all sections
        async fetchTests() {
            this.loading = true;
            try {
                const res = await axios.get("/admin/section");
                this.tests = res.data;
            } catch (err) {
                this.setFlash("❌ Failed to load sections", 'error');
            } finally {
                this.loading = false;
            }
        },

        // ✅ add new section
        async addTest() {
            if (!this.newTest.title) {
                this.setFlash("Title is required", 'error');
                return;
            }

            try {
                const res = await axios.post("/admin/section", {
                    title: this.newTest.title,
                    description: this.newTest.description,
                    duration: this.newTest.duration
                });

                this.tests.push(res.data);
                this.resetForm();
                this.showForm = false;
                this.setFlash("✅ Section added successfully", 'success');
            } catch (err) {
                console.error("❌ Failed to add section", err);
                this.setFlash("❌ Failed to add section", 'error');
            }
        },

        // ✅ start editing
        edit(section) {
            this.editingTest = { ...section };
        },

        // ✅ save updates
        async updateTest() {
            try {
                const res = await axios.put(`/admin/section/${this.editingTest.id}`, {
                    title: this.editingTest.title,
                    description: this.editingTest.description,
                    duration: this.editingTest.duration
                });

                const index = this.tests.findIndex(t => t.id === this.editingTest.id);
                if (index !== -1) this.tests[index] = res.data;

                this.editingTest = null;
                this.setFlash("✅ Section updated", 'success');
            } catch (err) {
                this.setFlash("❌ Failed to update section", 'error');
            }
        },

        // ✅ confirm delete
        confirmDelete(section) {
            this.deletingTest = section;
        },

        // ✅ perform delete
        async deleteConfirmed() {
            if (!this.deletingTest) return;

            try {
                await axios.delete(`/admin/section/${this.deletingTest.id}`);
                this.tests = this.tests.filter(t => t.id !== this.deletingTest.id);
                this.setFlash("✅ Section deleted", 'success');
                this.deletingTest = null;
            } catch (err) {
                this.setFlash("❌ Failed to delete section", 'error');
            }
        },

        // ✅ Flash message helper
        setFlash(message, type = 'success') {
            this.flashMessage = message;
            this.flashType = type;
            setTimeout(() => this.flashMessage = null, 4000);
        },

        // fetch count for dashboard
        async fetchCounts() {
            try {
                const res = await axios.get("/admin/stats");
                this.totalUsers = res.data.users;
                this.totalQuestions = res.data.questions;
                this.totalTests = res.data.tests;
                this.totalAnswers = res.data.answers;
            } catch (err) {
                this.setFlash("❌ Failed to fetch stats", 'error');
            }
        },
        copySectionId(id) {
            // أنشئ input مخفي
            const tempInput = document.createElement("input");
            tempInput.style.position = "absolute";
            tempInput.style.left = "-1000px";
            tempInput.value = id;
            document.body.appendChild(tempInput);
        
            // حدده و انسخه
            tempInput.select();
            document.execCommand("copy");
        
            // احذفه بعد النسخ
            document.body.removeChild(tempInput);
        
            // عرض رسالة نجاح
            this.setFlash(`✅ Section ID ${id} copied`, 'success');
        }
        
        
    };
}
