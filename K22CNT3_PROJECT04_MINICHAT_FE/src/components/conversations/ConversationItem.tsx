// src/components/conversations/ConversationItem.tsx
import { formatMessageTimestamp } from "../../utils/time";
import type { Conversation } from "../../types";

interface Props {
    conversation: Conversation;
    myId: number;
    isActive: boolean;
    onSelect: (id: number) => void;
}

export default function ConversationItem({
    conversation,
    myId,
    isActive,
    onSelect,
}: Props) {
    const isGroup = conversation.type === "group";
    const participant = conversation.participants.find((p) => p.id !== myId);

    const displayName = isGroup
        ? conversation.title || "Nhóm không tên"
        : participant?.name || "Người dùng";

    const avatar = isGroup
        ? conversation.avatar
            ? `${import.meta.env.VITE_API_BASE_URL}/storage/${
                  conversation.avatar
              }`
            : "/group-avatar.png"
        : participant?.avatar
        ? `${import.meta.env.VITE_API_BASE_URL}/storage/${participant.avatar}`
        : "/default-avatar.png";

    const last = conversation.last_message;
    const preview = last
        ? last.is_deleted
            ? "Tin nhắn đã bị xoá"
            : last.content || "(Tệp đính kèm)"
        : "Chưa có tin nhắn";

    const time = last?.created_at
        ? formatMessageTimestamp(last.created_at)
        : "";

    return (
        <>
            <button
                onClick={() => onSelect(conversation.id)}
                className={`flex w-full items-center gap-3 px-4 py-2 hover:bg-gray-800 rounded text-left ${
                    isActive ? "bg-gray-800 text-white" : "text-gray-300"
                }`}
            >
                <img
                    src={avatar}
                    alt={displayName}
                    className="w-10 h-10 rounded-full object-cover border border-gray-600"
                />
                <div className="flex-1 min-w-0">
                    <div className="font-medium truncate">{displayName}</div>
                    <div className="text-xs truncate text-gray-400">
                        {preview}
                    </div>
                </div>
                {time && <div className="text-xs text-gray-500">{time}</div>}
            </button>
        </>
    );
}
