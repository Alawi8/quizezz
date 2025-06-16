import axios from '@/auth/axios';

export default function deleteAccount() {
    return {
        showConfirmModal: false,
        password: '',
        error: null,
        success: null,

        async deleteAccount() {
            try {
                await axios.delete('/profile', {
                    data: { password: this.password }
                });

                this.success = "Account deleted.";
                this.error = null;

                localStorage.removeItem("auth_token");
                delete axios.defaults.headers.common["Authorization"];
                window.location.href = "/login";
            } catch (err) {
                this.error = err.response?.data?.message || "Failed to delete account.";
                this.success = null;
            }
        }
    };
}
