import router from "./router";
import axios from "axios";

const axiosClient = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL,
    withCredentials: true,
    withXSRFToken: true
})

//Manipula o Bearer Token em cada requisição
axiosClient.interceptors.request.use(config => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

//Redireciona o usuario nao logado para a tela de login
axiosClient.interceptors.response.use((response) => {
    return response;
}, error => {
    if (error.response && error.response.status == 401) {
        router.push({name: 'Login'});
    }

    throw error; 
})

export default axiosClient
