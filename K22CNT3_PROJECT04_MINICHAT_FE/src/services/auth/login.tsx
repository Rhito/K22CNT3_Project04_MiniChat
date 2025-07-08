import axios from "axios";

interface LoginPayload {
    email: string;
    password: string;
}

export async function loginApi({ email, password }: LoginPayload) {
    const res = await axios.post(
        `${import.meta.env.VITE_API_BASE_URL}/api/v1/login`,
        {
            email,
            password,
        },
        {
            withCredentials: true,
        }
    );

    // Lưu token và user nếu có
    console.log(res.data.data.token);

    localStorage.setItem("authToken", res.data.data.token);

    localStorage.setItem("user", JSON.stringify(res.data.data.user));
    return res.data.data;
}
