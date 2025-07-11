export interface Attachment {
    id: number;
    message_id: number;
    file_name: string;
    file_url: string;
    file_path: string;
    file_type: string;
}

export interface Message {
    id: number;
    sender_id: number;
    conversation_id: number;
    content: string | null;
    message_type: string;
    created_at: string;
    updated_at: string;
    is_deleted: boolean;
    deleted_by: number | null;
    deleted_at: string | null;
    attachments?: Attachment[];
    sender?: {
        id: number;
        name: string;
        avatar: string | null;
        online?: boolean;
    };
}

export interface Conversation {
    id: number;
    title: string;
    type: "group" | "private";
    avatar?: string;
    participants: {
        id: number;
        name: string;
        avatar: string | null;
    }[];
    last_message?: {
        content: string;
        created_at: string;
        sender_id: number;
        is_deleted: boolean;
    };
}
export type TabId = "chat" | "profile" | "groups" | "friends" | "settings";

export type Friend = {
    id: number; // id của người bạn (user)
    name: string;
    email: string;
    avatar: string | null;
    status: "accepted" | "pending" | "requested"; // trạng thái quan hệ
    is_sender: boolean; // true nếu là người gửi lời mời
};

export type User = {
    id: number;
    name: string;
    email: string;
    avatar: string | null;
    is_active: boolean;
    is_blocked: boolean;
};
