// resources/js/profile/profileForm.js
import axios from '@/auth/axios.js';

export default function profileForm() {
    return {
        name: '',
        email: '',
        success: null,
        error: null,

        async init() {
            try {
                const res = await axios.get('/profile');
                this.name = res.data.name;
                this.email = res.data.email;
            } catch (e) {
                this.error = "Failed to load profile.";
            }
        },

        async updateProfile() {
            try {
                await axios.patch('/profile', {
                    name: this.name,
                    email: this.email,
                });
                this.success = "Saved.";
                this.error = null;
            } catch (e) {
                this.success = null;
                this.error = "Failed to save changes.";
            }
        }
    }
};
export default function updatePasswordForm() {
    return {
        current_password: '',
        password: '',
        password_confirmation: '',
        success: null,
        error: null,

        async updatePassword() {
            try {
                await axios.put('/user/password', {
                    current_password: this.current_password,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                });

                this.success = 'Password updated successfully.';
                this.error = null;

                this.current_password = '';
                this.password = '';
                this.password_confirmation = '';
            } catch (e) {
                this.success = null;
                this.error = e.response?.data?.message || 'Failed to update password.';
            }
        }
    };
};
export default function deleteAccountForm() {
    return {
        showConfirmModal: false,
        password: '',
        error: null,
        success: null,

        async deleteAccount() {
            try {
                await axios.delete('/profile', {
                    data: {
                        password: this.password,
                    },
                });

                this.success = "Your account has been deleted.";
                this.error = null;

                // تسجيل خروج تلقائي بعد الحذف
                localStorage.removeItem("auth_token");
                delete axios.defaults.headers.common["Authorization"];
                window.location.href = "/login";
            } catch (err) {
                this.error = err.response?.data?.message || "Failed to delete account.";
                this.success = null;
            }
        }
    };
};

export default function profilePage() {
    return {
        section: 'info', // info | password | delete
        setSection(s) {
            this.section = s;
        }
    };
}
