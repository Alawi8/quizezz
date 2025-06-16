import axios from '@/auth/axios';

export default function updatePassword() {
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
}
