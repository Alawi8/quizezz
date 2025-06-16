import axios from "axios";

export default function testManagerFactory(initialTests = []) {
    return {
        tests: initialTests,
        newTestTitle: '',

        async createTest() {
            if (!this.newTestTitle.trim()) {
                alert("Title is required");
                return;
            }

            try {
                const response = await axios.post('/tests', {
                    title: this.newTestTitle
                }, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    }
                });

                this.tests.push(response.data.test);
                this.newTestTitle = '';
            } catch (error) {
                alert("Failed to create test.");
            }
        }
    };
}
export function copyToClipboard(text) {
    if (!navigator.clipboard) {
        alert("Clipboard API not supported");
        return;
    }

    navigator.clipboard.writeText(text)
        .then(() => {
            console.log("Copied to clipboard:", text);
        })
        .catch(err => {
            console.error("Clipboard copy failed:", err);
            alert("❌ Failed to copy.");
        });
}
