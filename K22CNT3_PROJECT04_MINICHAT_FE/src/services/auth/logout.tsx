import axios from "axios";

export async function logoutApi() {
    const token = localStorage.getItem("authToken");
    await axios.post(
        `${import.meta.env.VITE_API_BASE_URL}/api/v1/logout`,
        {},
        {
            headers: {
                Authorization: `Bearer ${token}`,
            },
            withCredentials: true,
        }
    );
    localStorage.removeItem("authToken");
    localStorage.removeItem("user");
    window.location.href = "/";
}
