import { instance } from "./api";

const messengerApi = async (
  id: number,
  token: string,
  setError: (msg: string) => void,
  setLoading: (loading: boolean) => void
) => {
  setLoading(true);
  setError("");

  try {
    // Gọi CSRF cookie nếu backend yêu cầu (Laravel Sanctum)
    await instance.get("/sanctum/csrf-cookie");

    // Gọi API lấy tin nhắn
    const res = await instance.get(`api/v1/messages/${id}`, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    const rawMessages = res.data.data;

    // Lọc và chuyển đổi chỉ các tin nhắn text
    const textMessages = rawMessages
      .filter((msg: any) => msg.message_type === "text" && msg.content)
      .map((msg: any) => ({
        sender: msg.sender_id.toString(),
        text: msg.content,
      }));

    return textMessages;
  } catch (error: any) {
    setError(error?.response?.data?.message || "An error occurred");
    return null;
  } finally {
    setLoading(false);
  }
};
export default messengerApi;
