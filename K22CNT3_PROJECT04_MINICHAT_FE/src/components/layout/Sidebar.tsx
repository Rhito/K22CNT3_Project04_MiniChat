// src/components/layout/Sidebar.tsx

import { useEffect, useState } from "react";
import type { Conversation, TabId } from "../../types";
import { fetchConversations } from "../../services/conversationService";
import { getUserInfo } from "../../services/authService";

type SidebarProps = {
    activeTab: TabId;
    onSelectConversation: (id: number) => void;
    selectedConversationId?: number | null;
};

export default function Sidebar({
    activeTab,
    onSelectConversation,
    selectedConversationId,
}: SidebarProps) {
    const [conversations, setConversations] = useState<Conversation[]>([]);
    const [loading, setLoading] = useState(true);
    const myId = getUserInfo()?.id;

    useEffect(() => {
        const token = localStorage.getItem("authToken");
        if (!token) return;

        fetchConversations(token)
            .then((data) => setConversations(data))
            .catch((err) => console.error("Lỗi tải hội thoại:", err))
            .finally(() => setLoading(false));
    }, []);

    if (activeTab !== "chat") {
        return (
            <aside className="w-64 bg-gray-900 border-r border-gray-700 h-screen p-4 text-gray-400">
                {/* Optional content for other tabs */}
                {activeTab === "profile" && <div>Trang cá nhân</div>}
                {activeTab === "settings" && <div>Cài đặt</div>}
                {activeTab === "contacts" && <div>Danh bạ</div>}
                {/* v.v. */}
            </aside>
        );
    }

    return (
        <aside className="w-64 bg-gray-900 border-r border-gray-700 h-screen overflow-y-auto">
            <div className="p-4 text-white text-lg font-semibold border-b border-gray-700">
                MiniChat
            </div>

            <div className="p-2 text-gray-400 text-xs uppercase tracking-wide">
                Hội thoại
            </div>

            {loading ? (
                <div className="text-sm text-gray-400 px-4 py-2">
                    Đang tải...
                </div>
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
                            ? `${import.meta.env.VITE_API_BASE_URL}/storage/${
                                  participant.avatar
                              }`
                            : "/default-avatar.png";

                        const isActive = conv.id === selectedConversationId;

                        return (
                            <li key={conv.id}>
                                <button
                                    onClick={() =>
                                        onSelectConversation(conv.id)
                                    }
                                    className={`flex w-full items-center gap-3 px-4 py-2 hover:bg-gray-800 rounded text-left ${
                                        isActive
                                            ? "bg-gray-800 text-white"
                                            : "text-gray-300"
                                    }`}
                                >
                                    <img
                                        src={avatar}
                                        alt={displayName}
                                        className="w-10 h-10 rounded-full object-cover border border-gray-600"
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
        </aside>
    );
}
