import axios from "axios";

interface RegisterPayload {
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
}

export async function registerUser(payload: RegisterPayload) {
    const res = await axios.post(
        `${import.meta.env.VITE_API_BASE_URL}/api/v1/register`,
        payload
    );
    return res.data;
}
