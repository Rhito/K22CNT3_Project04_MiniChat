import { useEffect, useState } from "react";
import { fetchConversations } from "../../services/conversationService";
import { getUserInfo } from "../../services/authService";
import type { Conversation } from "../../types";

export default function ChatSidebar({
    onSelectConversation,
    selectedConversationId,
}: {
    onSelectConversation: (id: number) => void;
    selectedConversationId?: number | null;
}) {
    const [conversations, setConversations] = useState<Conversation[]>([]);
    const [loading, setLoading] = useState(true);
    const myId = getUserInfo()?.id;

    useEffect(() => {
        const token = localStorage.getItem("authToken");
        if (!token) return;
        fetchConversations(token)
            .then(setConversations)
            .catch(console.error)
            .finally(() => setLoading(false));
    }, []);

    return (
        <div className="text-white-400 p-4">
            <h2 className="text-lg font-semibold mb-4">Đoạn chat</h2>
            {conversations.length === 0 && !loading && (
                <div className="text-center text-gray-500">
                    Không tìm thấy đoạn chat nào.
                </div>
            )}
            <div className="p-2">
                {loading ? (
                    <div className="text-sm text-gray-400">Đang tải...</div>
                ) : (
                    <ul className="space-y-1">
                        {conversations.map((conv) => {
                            const isGroup = conv.type === "group";
                            const participant = conv.participants.find(
                                (p) => p.id !== myId
                            );
                            const displayName = isGroup
                                ? conv.title || "Nhóm không tên"
                                : participant?.name || "Người dùng";
                            const avatar = isGroup
                                ? conv.avatar
                                    ? `${
                                          import.meta.env.VITE_API_BASE_URL
                                      }/storage/${conv.avatar}`
                                    : "/group-avatar.png"
                                : participant?.avatar
                                ? `${
                                      import.meta.env.VITE_API_BASE_URL
                                  }/storage/${participant.avatar}`
                                : "/default-avatar.png";

                            const isActive = conv.id === selectedConversationId;

                            return (
                                <li key={conv.id}>
                                    <button
                                        onClick={() =>
                                            onSelectConversation(conv.id)
                                        }
                                        className={`flex items-center gap-3 px-4 py-2 rounded w-full text-left hover:bg-gray-800 ${
                                            isActive
                                                ? "bg-gray-800 text-white"
                                                : "text-gray-300"
                                        }`}
                                    >
                                        <img
                                            src={avatar}
                                            alt={displayName}
                                            className="w-10 h-10 rounded-full border border-gray-600"
                                        />
                                        <span className="truncate">
                                            {displayName}
                                        </span>
                                    </button>
                                </li>
                            );
                        })}
                    </ul>
                )}
            </div>
        </div>
    );
}
