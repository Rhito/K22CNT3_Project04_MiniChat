import { instance } from "./api";

const messengerApi = async (
    conversationId: number,
    token: string,
    setError: (msg: string) => void,
    setLoading: (loading: boolean) => void
) => {
    setLoading(true);
    setError("");

    try {
        // Nếu dùng Sanctum: gọi để lấy cookie trước (nếu cần)
        await instance.get("/sanctum/csrf-cookie");

        // Gọi API tin nhắn của cuộc trò chuyện
        const res = await instance.get(`/api/v1/messages/${conversationId}`, {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            },
        });

        // Trả nguyên danh sách tin nhắn (không lọc)
        return res.data.data;
    } catch (error: any) {
        setError(
            error?.response?.data?.message ||
                "Không thể tải danh sách tin nhắn."
        );
        return [];
    } finally {
        setLoading(false);
    }
};

export default messengerApi;
