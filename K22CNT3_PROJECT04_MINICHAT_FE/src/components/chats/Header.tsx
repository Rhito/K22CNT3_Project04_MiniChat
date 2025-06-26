import { useEffect, useState } from "react";
import conversationApi from "../../Api/conversationApi";
import type { Conversation } from "../../Api/conversationApi";
import { getUserInfo } from "../../Api/loginApi";

interface ChatHeaderProps {
    conversationId: number;
}

export default function ChatHeader({ conversationId }: ChatHeaderProps) {
    const [conversation, setConversation] = useState<Conversation | null>(null);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState<string | null>(null);
    const myId = getUserInfo()?.id;

    useEffect(() => {
        const token = localStorage.getItem("authToken");
        if (!token || !conversationId) return;

        const fetchConversation = async () => {
            setLoading(true);
            try {
                const all = await conversationApi(token, setError, setLoading);
                const found = all.find((c) => c.id === conversationId);
                setConversation(found || null);
            } catch (error) {
                console.error("Error fetching conversation:", error);
                setError("Không thể tải tiêu đề hội thoại");
            } finally {
                setLoading(false);
            }
        };

        fetchConversation();
    }, [conversationId]);

    if (loading) {
        return (
            <div className="bg-gray-800 px-4 py-2 border-b border-gray-700 text-gray-400">
                Đang tải thông tin...
            </div>
        );
    }

    if (error || !conversation) {
        return (
            <div className="bg-gray-800 px-4 py-2 border-b border-gray-700 text-red-400">
                {error || "Không tìm thấy cuộc trò chuyện"}
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
            ? `https://k22cnt3_project4_minichat.test/storage/${conversation.avatar}`
            : "/group-avatar.png"
        : conversation.participants.find((p) => p.id !== myId)?.avatar
        ? `https://k22cnt3_project4_minichat.test/storage/${
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
