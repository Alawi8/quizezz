import axios from '@/auth/axios';

export default function infoForm() {
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
    };
}
