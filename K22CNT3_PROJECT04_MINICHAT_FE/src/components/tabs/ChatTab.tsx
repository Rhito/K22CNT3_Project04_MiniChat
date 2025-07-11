import { useEffect, useState } from "react";
import { getUserInfo } from "../../Api/loginApi";
import { conversationApi } from "../../Api/conversationApi";
import echo from "../../echo/createEcho";

interface Participant {
    id: number;
    name: string;
    email: string;
    avatar: string | null;
}

interface Message {
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

interface Conversation {
    id: number;
    title: string | null;
    avatar: string | null;
    type: string;
    created_by: number;
    participants: Participant[];
    messages: Message[];
}

interface ChatTabProps {
    onSelectConversation?: (id: number) => void;
}

const ChatTab: React.FC<ChatTabProps> = ({ onSelectConversation }) => {
    const [conversations, setConversations] = useState<Conversation[]>([]);
    const [loading, setLoading] = useState<boolean>(false);
    const [error, setError] = useState<string>("");

    const userInfo = getUserInfo();
    const myId = userInfo?.id;

    useEffect(() => {
        const token = localStorage.getItem("authToken");
        if (!token || !myId) return;

        conversationApi(token, setError, setLoading).then((data) => {
            setConversations(data);
        });
    }, [myId]);

    useEffect(() => {
        if (!conversations.length) return;

        conversations.forEach((conv) => {
            echo.private(`conversation.${conv.id}`).listen(
                ".message.sent",
                (e: any) => {
                    setConversations((prev) => {
                        const updated = prev.map((c) => {
                            if (c.id === e.message.conversation_id) {
                                return {
                                    ...c,
                                    messages: [e.message],
                                };
                            }
                            return c;
                        });

                        return updated.sort((a, b) => {
                            const aTime = new Date(
                                a.messages[0]?.created_at || 0
                            ).getTime();
                            const bTime = new Date(
                                b.messages[0]?.created_at || 0
                            ).getTime();
                            return bTime - aTime;
                        });
                    });
                }
            );
        });

        return () => {
            conversations.forEach((conv) => {
                echo.leave(`conversation.${conv.id}`);
            });
        };
    }, [conversations]);

    return (
        <div>
            <h2 className="text-lg font-semibold text-white mb-4">
                Trò chuyện
            </h2>

            {loading && <div className="text-gray-400 text-sm">Loading...</div>}
            {error && <div className="text-red-400 text-sm">{error}</div>}

            {conversations.length === 0 ? (
                <div className="text-gray-400 text-sm">No conversations.</div>
            ) : (
                <div className="space-y-3">
                    {conversations.map((conv) => {
                        const other = conv.participants.find(
                            (p) => p.id !== myId
                        );
                        const lastMessage = conv.messages[0];

                        const displayName =
                            conv.type === "group"
                                ? conv.title || "Nhóm không tên"
                                : other?.name || "Người dùng";

                        const avatarUrl =
                            conv.type === "group"
                                ? conv.avatar
                                    ? `https://k22cnt3_project04_minichat.test/storage/${conv.avatar}`
                                    : "/group-avatar.png"
                                : other?.avatar
                                ? `https://k22cnt3_project04_minichat.test/storage/${other.avatar}`
                                : "/default-avatar.png";

                        return (
                            <div
                                key={conv.id}
                                onClick={() => onSelectConversation?.(conv.id)}
                                className="flex items-center gap-3 p-3 rounded-lg bg-gray-800 hover:bg-gray-700 cursor-pointer"
                            >
                                <img
                                    src={avatarUrl}
                                    alt={displayName}
                                    className="w-12 h-12 rounded-full object-cover border border-gray-600"
                                />
                                <div className="flex-1 overflow-hidden">
                                    <div className="text-white font-medium truncate">
                                        {displayName}
                                    </div>
                                    <div className="text-gray-400 text-sm truncate">
                                        {lastMessage?.content ||
                                            lastMessage?.message_type ||
                                            "Không có tin nhắn"}
                                    </div>
                                </div>
                            </div>
                        );
                    })}
                </div>
            )}
        </div>
    );
};

export default ChatTab;
