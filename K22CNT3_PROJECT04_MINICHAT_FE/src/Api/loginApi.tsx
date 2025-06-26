import axios from "axios";
import type { AxiosResponse, AxiosError } from "axios";

interface LoginCredentials {
    email: string;
    password: string;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar: string;
    is_active: boolean;
}

interface LoginResponse {
    data: {
        user: User;
        token: string;
    };
    message: string;
}

const BASE_URL = "https://k22cnt3_project4_minichat.test";

// Main login function
const login = async (credentials: LoginCredentials): Promise<LoginResponse> => {
    try {
        const res: AxiosResponse<LoginResponse> = await axios.post(
            `${BASE_URL}/api/v1/login`,
            credentials,
            {
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
            }
        );

        const { token, user } = res.data.data;

        if (token) localStorage.setItem("authToken", token);
        if (user) localStorage.setItem("userInfo", JSON.stringify(user));

        return res.data;
    } catch (err) {
        const axiosErr = err as AxiosError<{ message: string }>;
        throw new Error(axiosErr.response?.data?.message ?? "Login failed.");
    }
};

// Helpers
export const getAuthToken = (): string | null =>
    localStorage.getItem("authToken");

export const getUserInfo = (): User | null => {
    const user = localStorage.getItem("userInfo");
    return user ? JSON.parse(user) : null;
};

export const clearAuthToken = (): void => {
    localStorage.removeItem("authToken");
    localStorage.removeItem("userInfo");
};

// Exports
export default login;
export { login as loginApi };
