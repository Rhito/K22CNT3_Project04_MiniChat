import axios from "axios";

const API_BASE = import.meta.env.VITE_API_BASE_URL;
const token = localStorage.getItem("authToken");

const instance = axios.create({
    baseURL: API_BASE,
    headers: {
        Authorization: `Bearer ${token}`,
    },
});

export default instance;
