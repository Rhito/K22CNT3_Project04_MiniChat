// src/components/chat/ChatHeader.tsx

import { useConversationById } from "../../hooks/useConversationById";
import { getUserInfo } from "../../services/authService";

interface ChatHeaderProps {
    conversationId: number;
}

export default function ChatHeader({ conversationId }: ChatHeaderProps) {
    const {
        conversation,
        loading: isLoading,
        error,
    } = useConversationById(conversationId);

    const myId = getUserInfo()?.id;

    if (isLoading) {
        return (
            <div className="bg-gray-800 px-4 py-2 text-sm text-gray-400">
                Đang tải hội thoại...
            </div>
        );
    }

    if (error || !conversation) {
        return (
            <div className="bg-gray-800 px-4 py-2 text-sm text-red-400">
                Lỗi tải dữ liệu
            </div>
        );
    }

    const isGroup = conversation.type === "group";
    const displayName = isGroup
        ? conversation.title || "Nhóm không tên"
        : conversation.participants.find((p) => p.id !== myId)?.name ||
          "Người dùng";
    const avatar = isGroup
        ? conversation.avatar
            ? `${import.meta.env.VITE_API_BASE_URL}/storage/${
                  conversation.avatar
              }`
            : "/group-avatar.png"
        : conversation.participants.find((p) => p.id !== myId)?.avatar
        ? `${import.meta.env.VITE_API_BASE_URL}/storage/${
              conversation.participants.find((p) => p.id !== myId)?.avatar
          }`
        : "/default-avatar.png";

    return (
        <div className="bg-gray-800 px-4 py-2 border-b border-gray-700 flex items-center gap-3">
            <img
                src={avatar}
                alt={displayName}
                className="w-10 h-10 rounded-full object-cover border border-gray-600"
            />
            <div className="flex flex-col">
                <div className="font-semibold">{displayName}</div>
                <div className="text-xs text-gray-400">
                    {isGroup
                        ? `${conversation.participants.length} thành viên`
                        : "Đang hoạt động"}
                </div>
            </div>
        </div>
    );
}
