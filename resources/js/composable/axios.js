import axios from 'axios'

const isLocal = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1'

axios.defaults.baseURL = isLocal
  ? 'http://127.0.0.1:8000'
  : 'https://Exam.meshcah.net' // ← غيّر هذا حسب نطاق الـ API الحقيقي بعد رفعه

axios.defaults.withCredentials = true

export default axios
