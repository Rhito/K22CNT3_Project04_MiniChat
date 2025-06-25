// src/Api/registerApi.ts
import { instance } from "./api";

export interface RegisterForm {
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
}

export const registerUser = async (form: RegisterForm) => {
  try {
    await instance.get("/sanctum/csrf-cookie", { withCredentials: true });

    const response = await instance.post("/api/v1/register", form, {});
    return response.data;
  } catch (error: unknown) {
    if (
      error &&
      typeof error === "object" &&
      "response" in error &&
      error.response &&
      typeof (error.response as any).data?.message === "string"
    ) {
      throw (error as any).response.data.message;
    }
    throw "Đăng ký không thành công. Vui lòng thử lại sau.";
  }
};
