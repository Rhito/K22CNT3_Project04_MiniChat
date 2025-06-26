import { useEffect, useRef, useState } from "react";
import axios from "axios";
import { getUserInfo } from "../../Api/loginApi";

const API = "https://k22cnt3_project4_minichat.test/api/v1";

type Message = {
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
    sender?: {
        id: number;
        name: string;
        avatar: string | null;
    };
};

interface ChatBodyProps {
    conversationId: number;
}

export default function ChatBody({ conversationId }: ChatBodyProps) {
    const [messages, setMessages] = useState<Message[]>([]);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState<string | null>(null);
    const scrollContainerRef = useRef<HTMLDivElement>(null);

    const myInfo = getUserInfo();
    const myId = myInfo?.id;
    const token = localStorage.getItem("authToken");

    const scrollToBottom = () => {
        const container = scrollContainerRef.current;
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    };

    useEffect(() => {
        if (!token || !conversationId) return;

        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
        axios.defaults.headers.common["Accept"] = "application/json";

        let channel: any;

        const init = async () => {
            setLoading(true);

            // 1. Lấy danh sách tin nhắn ban đầu
            try {
                const res = await axios.get(
                    `${API}/messages/${conversationId}`
                );
                const rawMessages = res.data.data;
                if (Array.isArray(rawMessages)) {
                    setMessages(rawMessages.reverse()); // đảo thứ tự tin nhắn để mới nằm cuối
                } else {
                    setMessages([]);
                }
            } catch (err) {
                console.error("❌ Failed to load messages", err);
                setError("Không thể tải tin nhắn.");
            } finally {
                setLoading(false);
            }

            // 2. Khởi tạo Echo
            try {
                const { default: echo } = await import("../../echo/createEcho");

                channel = echo
                    .private(`conversation.${conversationId}`)
                    .listen(".message.sent", (e: any) => {
                        if (e.message) {
                            setMessages((prev) => {
                                const exists = prev.some(
                                    (m) => m.id === e.message.id
                                );
                                return exists ? prev : [...prev, e.message];
                            });
                        }
                    });
            } catch (err) {
                console.error("❌ Echo failed", err);
            }
        };

        init();

        return () => {
            if (channel) {
                channel.stopListening(".message.sent");
                channel.unsubscribe();
            }
        };
    }, [conversationId]);

    // Scroll xuống cuối khi có tin nhắn mới
    useEffect(() => {
        scrollToBottom();
    }, [messages]);

    return (
        <div
            ref={scrollContainerRef}
            className="flex-1 overflow-y-auto px-4 py-2 space-y-3 bg-gray-900"
        >
            {loading ? (
                <div className="text-gray-400 text-sm">
                    Đang tải tin nhắn...
                </div>
            ) : error ? (
                <div className="text-red-500 text-sm">{error}</div>
            ) : messages.length === 0 ? (
                <div className="text-gray-400 text-sm">Chưa có tin nhắn.</div>
            ) : (
                messages.map((msg) => {
                    const isMe = msg.sender_id === myId;
                    const avatarUrl = msg.sender?.avatar
                        ? `https://k22cnt3_project4_minichat.test/storage/${msg.sender.avatar}`
                        : "/default-avatar.png";

                    return (
                        <div
                            key={msg.id}
                            className={`flex items-end gap-2 ${
                                isMe ? "justify-end" : "justify-start"
                            }`}
                        >
                            {!isMe && (
                                <img
                                    src={avatarUrl}
                                    alt="avatar"
                                    className="w-8 h-8 rounded-full border border-gray-600"
                                />
                            )}
                            <div
                                className={`px-4 py-2 rounded-xl max-w-xs md:max-w-sm lg:max-w-md shadow ${
                                    isMe
                                        ? "bg-blue-600 text-white rounded-br-none"
                                        : "bg-gray-700 text-white rounded-bl-none"
                                }`}
                            >
                                <div className="text-sm whitespace-pre-wrap">
                                    {msg.content || <i>(Không có nội dung)</i>}
                                </div>
                                <div className="text-[11px] mt-1 text-gray-300 text-right">
                                    {new Date(
                                        msg.created_at
                                    ).toLocaleTimeString("vi-VN", {
                                        hour: "2-digit",
                                        minute: "2-digit",
                                    })}
                                </div>
                            </div>
                            {isMe && (
                                <img
                                    src={
                                        myInfo?.avatar
                                            ? `https://k22cnt3_project4_minichat.test/storage/${myInfo.avatar}`
                                            : "/default-avatar.png"
                                    }
                                    alt="avatar"
                                    className="w-8 h-8 rounded-full border border-gray-600"
                                />
                            )}
                        </div>
                    );
                })
            )}
        </div>
    );
}
