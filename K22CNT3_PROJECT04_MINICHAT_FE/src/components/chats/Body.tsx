import { useEffect, useRef, useState } from "react";
import messengerApi from "../../Api/messengerApi";
import { getUserInfo } from "../../Api/loginApi";
import echo from "../../echo/createEcho";
import MessageActions from "./MessageActions";

const BASE_URL = import.meta.env.VITE_API_BASE_URL;

interface Attachment {
    id: number;
    message_id: number;
    file_url: string;
    file_path: string;
    file_type: string;
}

interface Message {
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
    };
}

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

    const scrollToBottom = () => {
        const container = scrollContainerRef.current;
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    };

    useEffect(() => {
        const token = localStorage.getItem("authToken");
        if (!token || !conversationId) return;

        const fetchMessages = async () => {
            setLoading(true);
            try {
                const fetchedMessages = await messengerApi(
                    conversationId,
                    token,
                    (msg: string) => setError(msg),
                    (loading: boolean) => setLoading(loading)
                );

                setMessages(
                    Array.isArray(fetchedMessages)
                        ? fetchedMessages.reverse()
                        : []
                );
            } catch (error) {
                setError("Không thể tải tin nhắn.");
            } finally {
                setLoading(false);
            }
        };

        fetchMessages();

        const channel = echo.private(`conversation.${conversationId}`);
        channel.listen(".message.sent", (e: any) => {
            if (e.message) {
                setMessages((prev) => {
                    const exists = prev.some((msg) => msg.id === e.message.id);
                    return exists ? prev : [...prev, e.message];
                });
            }
        });

        return () => {
            echo.leave(`conversation.${conversationId}`);
        };
    }, [conversationId]);

    useEffect(() => {
        scrollToBottom();
    }, [messages]);

    const handleHideMessage = (id: number) => {
        setMessages((prev) =>
            prev.map((m) => (m.id === id ? { ...m, is_deleted: true } : m))
        );
    };

    const renderAttachments = (attachments: Attachment[]) => {
        return attachments.map((file) => {
            const url = `${BASE_URL}${file.file_url}`;

            if (file.file_type.startsWith("image/")) {
                return (
                    <img
                        key={file.id}
                        src={url}
                        alt="attachment"
                        className="rounded-lg max-w-xs border border-gray-600"
                    />
                );
            }

            if (file.file_type.startsWith("video/")) {
                return (
                    <video
                        key={file.id}
                        controls
                        className="rounded-lg max-w-xs border border-gray-600"
                        src={url}
                    />
                );
            }

            return (
                <div
                    key={file.id}
                    className="bg-gray-800 p-3 rounded-lg flex items-center gap-2 text-white border border-gray-600"
                >
                    <span className="text-xl">📄</span>
                    <a
                        href={url}
                        target="_blank"
                        rel="noopener noreferrer"
                        download
                        className="hover:underline truncate max-w-[200px]"
                    >
                        {file.file_path.split("/").pop()}
                    </a>
                </div>
            );
        });
    };

    return (
        <div
            ref={scrollContainerRef}
            className="flex-1 overflow-y-auto px-4 py-2 space-y-4 bg-gray-900"
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
                        ? `${BASE_URL}/storage/${msg.sender.avatar}`
                        : "/default-avatar.png";

                    return (
                        <div
                            key={msg.id}
                            className={`group flex items-end gap-2 ${
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
                                className={`relative px-4 py-2 rounded-2xl max-w-xs md:max-w-sm lg:max-w-md shadow space-y-2 ${
                                    isMe
                                        ? "bg-blue-600 text-white rounded-br-none"
                                        : "bg-gray-700 text-white rounded-bl-none"
                                }`}
                            >
                                <div className="text-sm break-words whitespace-pre-wrap">
                                    {msg.is_deleted ? (
                                        <i className="italic text-gray-400">
                                            (Tin nhắn đã bị xóa)
                                        </i>
                                    ) : (
                                        <>
                                            {msg.message_type === "text" &&
                                                (msg.content || (
                                                    <i>(Không có nội dung)</i>
                                                ))}

                                            {msg.message_type === "file" &&
                                                msg.attachments &&
                                                renderAttachments(
                                                    msg.attachments
                                                )}
                                        </>
                                    )}
                                </div>

                                <div className="text-[11px] text-gray-300 text-right">
                                    {new Date(
                                        msg.created_at
                                    ).toLocaleTimeString("vi-VN", {
                                        hour: "2-digit",
                                        minute: "2-digit",
                                    })}
                                </div>

                                {isMe && (
                                    <div className="absolute bottom-1 left-1 hidden group-hover:block">
                                        <MessageActions
                                            messageId={msg.id}
                                            onHideSuccess={() =>
                                                handleHideMessage(msg.id)
                                            }
                                        />
                                    </div>
                                )}
                            </div>

                            {isMe && (
                                <img
                                    src={
                                        myInfo?.avatar
                                            ? `${BASE_URL}/storage/${myInfo.avatar}`
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
