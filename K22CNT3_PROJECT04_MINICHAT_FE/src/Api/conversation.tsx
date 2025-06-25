import { instance } from "./api";

const conversationApi = async (
  token: string,
  setError: (msg: string) => void,
  setLoading: (loading: boolean) => void
) => {
  setLoading(true);
  setError("");

  try {
    // Gọi CSRF cookie nếu backend yêu cầu (Laravel Sanctum)
    await instance.get("/sanctum/csrf-cookie");

    // Gọi API lấy danh sách cuộc trò chuyện
    const res = await instance.get("api/v1/conversation", {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    return res.data.data;
  } catch (error: any) {
    setError(error?.response?.data?.message || "An error occurred");
    return null;
  } finally {
    setLoading(false);
  }
};
export default conversationApi;
