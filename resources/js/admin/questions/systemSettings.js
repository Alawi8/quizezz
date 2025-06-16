import axios from '../../auth/axios';
export default function systemSettings() {
    return {
        settings: {
            system_name: '',
            system_description: '',
            dark_mode_enabled: false,
        },
        flashMessage: null,
        flashType: 'success',
        file: null,

        async init() {
            const token = localStorage.getItem("auth_token");
            if (token) {
                axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
            }

            // لاحقًا ممكن تضيف جلب الإعدادات
            // const res = await axios.get('/settings');
            // this.settings = res.data;
        },

        async saveSystemInfo() {
            try {
                const res = await axios.post('/settings', this.settings);
                this.setFlash('✅ Settings saved successfully', 'success');
            } catch (err) {
                this.setFlash('❌ Error saving settings', 'error');
                console.error(err.response?.data || err.message);
            }
        },

        handleFileUpload(e) {
            this.file = e.target.files[0];
        },

        async uploadFile(type) {
            if (!this.file) return alert("Choose a file");

            const formData = new FormData();
            formData.append("file", this.file);

            try {
                await axios.post(`/import/${type}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                this.setFlash("✅ File uploaded successfully", "success");
            } catch (e) {
                this.setFlash("❌ Upload failed", "error");
                console.error(e.response?.data || e.message);
            }
        },

        async deleteAll(type) {
            if (!confirm("Are you sure? This cannot be undone.")) return;

            try {
                await axios.delete(`/delete/${type}`);
                this.setFlash(`✅ All ${type} deleted successfully`, "success");
            } catch (e) {
                this.setFlash("❌ Delete failed", "error");
                console.error(e.response?.data || e.message);
            }
        },

        setFlash(msg, type = 'success') {
            this.flashMessage = msg;
            this.flashType = type;
            setTimeout(() => this.flashMessage = null, 4000);
        }
    };
}
