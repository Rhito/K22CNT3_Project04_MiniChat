import { instance } from "./api";

export const loginApi = async (
  email: string,
  password: string,
  setError: (msg: string) => void,
  setLoading: (loading: boolean) => void,
  navigate: (path: string) => void
) => {
  setLoading(true);
  setError("");
  try {
    await instance.get("/sanctum/csrf-cookie");

    const response = await instance.post(
      "/api/v1/login",
      {
        email,
        password,
      },
      {
        headers: {
          "Content-Type": "application/json",
        },
      }
    );
    const token = response.data.data.token;
    localStorage.setItem("token", token);
    const userId = response.data.data.user.id;
    localStorage.setItem("user_id", userId.toString());
    if (response.status !== 200) {
      setError(response.data?.message || "Login failed");
      setLoading(false);
      return;
    }
    console.log(response.data);
    setLoading(false);
    navigate("/Home");
  } catch (error: any) {
    console.error("Login error:", error);
    if (error.response && error.response.data && error.response.data.message) {
      setError(error.response.data.message);
    } else if (error.message) {
      setError(`Error: ${error.message}`);
    } else {
      setError("An unknown error occurred. Please try again.");
    }
    setLoading(false);
  }
};
