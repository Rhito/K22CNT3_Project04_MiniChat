import { instance } from "./api";

// Participant: người tham gia cuộc hội thoại
export interface Participant {
    id: number;
    name: string;
    avatar: string | null;
    email: string;
}

// Message: tin nhắn trong hội thoại
export interface Message {
    id: number;
    conversation_id: number;
    sender_id: number;
    content: string | null;
    message_type: string;
    created_at: string;
    updated_at: string;
    is_deleted: boolean;
    deleted_by: number | null;
    deleted_at: string | null;
}

// Conversation: hội thoại
export interface Conversation {
    id: number;
    type: string;
    title: string | null;
    avatar: string | null;
    created_by: number;
    participants: Participant[];
    messages: Message[];
}

// Kiểu dữ liệu phân trang từ backend trả về
interface Pagination<T> {
    current_page: number;
    data: T[];
    total: number;
    per_page: number;
    last_page: number;
    next_page_url: string | null;
    prev_page_url: string | null;
}

interface ConversationApiResponse {
    status: boolean;
    message: string;
    data: Pagination<Conversation>;
}

// ✅ API: Lấy danh sách hội thoại
export const conversationApi = async (
    token: string,
    setError?: (err: string) => void,
    setLoading?: (loading: boolean) => void
): Promise<Conversation[]> => {
    try {
        setLoading?.(true);
        const res = await instance.get<ConversationApiResponse>(
            "/api/v1/conversation",
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: "application/json",
                },
            }
        );
        return res.data?.data?.data ?? [];
    } catch (err: any) {
        const message =
            err.response?.data?.message || "Không thể tải cuộc trò chuyện.";
        setError?.(message);
        return [];
    } finally {
        setLoading?.(false);
    }
};

// ✅ API: Tạo hoặc lấy hội thoại giữa 2 người
export const getOrCreateConversation = async (
    token: string,
    receiverId: number
): Promise<number> => {
    const res = await instance.post(
        "api/v1/messages/init",
        { receiver_id: receiverId },
        {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        }
    );
    return res.data?.data?.id;
};
