export default {
    // 🔷 public info
    info(title, data = null) {
        console.groupCollapsed(`🔷 [INFO] ${title}`);
        if (data) console.log(data);
        console.groupEnd();
    },

    // ⚠️ warnings
    warn(title, data = null) {
        console.groupCollapsed(`⚠️ [WARN] ${title}`);
        if (data) console.warn(data);
        console.groupEnd();
    },

    // ❌ errors
    error(title, error = null) {
        console.groupCollapsed(`❌ [ERROR] ${title}`);
        if (error) {
            console.error(error);
            console.trace();
        }
        console.groupEnd();
    },

    // ✅ success
    success(title, data = null) {
        console.groupCollapsed(`✅ [SUCCESS] ${title}`);
        if (data) console.log(data);
        console.groupEnd();
    }
};
