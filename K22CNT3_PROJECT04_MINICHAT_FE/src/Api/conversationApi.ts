import { instance } from "./api";

export interface Participant {
    id: number;
    name: string;
    avatar: string | null;
    email: string;
}

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

export interface Conversation {
    id: number;
    type: string;
    title: string | null;
    avatar: string | null;
    created_by: number;
    participants: Participant[];
    messages: Message[];
}

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

const conversationApi = async (
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

export default conversationApi;
