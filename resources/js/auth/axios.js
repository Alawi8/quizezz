import axios from 'axios'

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')

axios.defaults.baseURL = '/api'
axios.defaults.withCredentials = true
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.headers.common['Accept'] = 'application/json'

if (csrfToken) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
}

export default axios
