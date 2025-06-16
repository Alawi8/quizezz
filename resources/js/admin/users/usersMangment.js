import axios from "../../auth/axios.js";

export default function userManager() {
    return {
        users: [],
        availableRoles: [], // Comes from the server
        successMessage: '',
        deletingUser: null,
        showForm: false,
        errors: [],

        newUser: {
            name: '',
            email: '',
            password: '',
            role: '',
        },

        // ✅ Fetch all users
        async fetchUsers() {
            try {
                const res = await axios.get('/admin/users');
                this.users = res.data.data || [];
            } catch (err) {
                console.error('❌ Failed to load users', err);
                alert('Failed to load users');
            }
        },

        // ✅ Fetch roles only (no permissions)
        async fetchRoles() {
            try {
                const res = await axios.get('/admin/roles');
                this.availableRoles = res.data.roles || [];
            } catch (err) {
                console.error("❌ Failed to fetch roles", err);
            }
        },

        // ✅ Add a new user
        async addUser() {
            this.errors = []; // 🔁 Reset errors
        
            const { name, email, password, role } = this.newUser;
        
            if (!name || !email || !password || !role) {
                this.errors.push("Please fill in all fields.");
                return;
            }
        
            try {
                const res = await axios.post('/admin/users', {
                    name, email, password, role
                });
        
                this.users.push(res.data.user);
                this.successMessage = '✅ User created successfully!';
                this.newUser = { name: '', email: '', password: '', role: '' };
                this.showForm = false;
        
                setTimeout(() => this.successMessage = '', 3000);
            } catch (err) {
                if (err.response?.status === 422) {
                    const validationErrors = err.response.data.errors;
                    this.errors = Object.values(validationErrors).flat();
                } else if (err.response) {
                    this.errors = [err.response.data.message || "Server error"];
                } else {
                    this.errors = ["❌ Failed to connect to server."];
                }
        
                console.error("Add User Error:", err);
            }
        }
        ,

        // ✅ Change user role
        async changeRole(user, newRole) {
            if (!newRole) return;

            try {
                const res = await axios.post(`/admin/users/${user.id}/update-role`, {
                    role: newRole
                });
                user.roles = res.data.user.roles;
                this.successMessage = '✅ Role updated';
                setTimeout(() => this.successMessage = '', 3000);
            } catch (err) {
                alert('❌ Failed to update role');
                console.error(err);
            }
        },

        // ✅ Delete user
        confirmDelete(user) {
            this.deletingUser = user;
        },

        async deleteConfirmed() {
            try {
                await axios.delete(`/admin/users/${this.deletingUser.id}`);
                this.users = this.users.filter(u => u.id !== this.deletingUser.id);
                this.successMessage = '🗑️ User deleted';
                this.deletingUser = null;
                setTimeout(() => this.successMessage = '', 3000);
            } catch (err) {
                alert('❌ Failed to delete user');
                console.error(err);
            }
        }
    };
}
