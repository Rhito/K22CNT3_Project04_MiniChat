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
        online?: boolean;
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
            } catch {
                setError("Không thể tải tin nhắn.");
            } finally {
                setLoading(false);
            }
        };

        fetchMessages();

        const channel = echo.private(`conversation.${conversationId}`);
        channel
            .listen(".message.sent", (e: any) => {
                if (e.message) {
                    setMessages((prev) => {
                        const exists = prev.some(
                            (msg) => msg.id === e.message.id
                        );
                        return exists ? prev : [...prev, e.message];
                    });
                }
            })
            .listen(".message.updated", (e: any) => {
                setMessages((prev) =>
                    prev.map((msg) =>
                        msg.id === e.message.id ? e.message : msg
                    )
                );
            })
            .listen(".message.deleted", (e: any) => {
                setMessages((prev) =>
                    prev.map((msg) =>
                        msg.id === e.message.id ? e.message : msg
                    )
                );
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
            prev.map((msg) =>
                msg.id === id
                    ? {
                          ...msg,
                          is_deleted: true,
                          deleted_at: new Date().toISOString(),
                      }
                    : msg
            )
        );
    };

    const handleDeleteMessage = (id: number) => {
        setMessages((prev) =>
            prev.map((msg) =>
                msg.id === id
                    ? {
                          ...msg,
                          content: "Tin nhắn đã bị xoá",
                          updated_at: new Date().toISOString(),
                      }
                    : msg
            )
        );
    };

    const handleEditMessage = (id: number, newContent: string) => {
        setMessages((prev) =>
            prev.map((msg) =>
                msg.id === id
                    ? {
                          ...msg,
                          content: newContent,
                          updated_at: new Date().toISOString(),
                      }
                    : msg
            )
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
            className="flex-1 overflow-y-auto px-4 py-2 space-y-6 bg-gray-900"
        >
            {loading ? (
                <div className="text-gray-400 text-sm animate-pulse">
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

                    const isEdited =
                        new Date(msg.updated_at).getTime() -
                            new Date(msg.created_at).getTime() >
                        1000;
                    const showFullDate =
                        new Date(msg.created_at).toDateString() !==
                        new Date().toDateString();

                    return (
                        <div
                            key={msg.id}
                            className={`group flex items-end gap-3 transition-all duration-300 ease-in-out transform ${
                                isMe ? "justify-end" : "justify-start"
                            }`}
                        >
                            {!isMe && (
                                <div className="relative">
                                    <img
                                        src={avatarUrl}
                                        alt="avatar"
                                        className="w-9 h-9 rounded-full shadow-md border border-gray-600"
                                    />
                                    {msg.sender?.online && (
                                        <span className="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-gray-900 rounded-full"></span>
                                    )}
                                </div>
                            )}

                            <div
                                className={`relative px-4 py-3 rounded-2xl max-w-xs md:max-w-sm lg:max-w-md space-y-2 shadow-md ${
                                    isMe
                                        ? "bg-gradient-to-tr from-indigo-500 to-blue-600 text-white rounded-br-none"
                                        : "bg-gradient-to-tr from-gray-700 to-gray-800 text-white rounded-bl-none"
                                }`}
                            >
                                <div className="text-sm leading-relaxed break-words whitespace-pre-wrap">
                                    {msg.message_type === "text" &&
                                        (msg.is_deleted ? (
                                            <i className="text-gray-300">
                                                Tin nhắn đã bị xoá
                                            </i>
                                        ) : (
                                            msg.content || (
                                                <i>(Không có nội dung)</i>
                                            )
                                        ))}

                                    {msg.message_type === "file" &&
                                        msg.attachments &&
                                        renderAttachments(msg.attachments)}
                                </div>

                                <div className="flex justify-end items-center gap-2 text-xs text-gray-300">
                                    <span>
                                        {new Date(
                                            msg.created_at
                                        ).toLocaleTimeString("vi-VN", {
                                            hour: "2-digit",
                                            minute: "2-digit",
                                        })}
                                        {showFullDate && (
                                            <>
                                                {" "}
                                                •{" "}
                                                {new Date(
                                                    msg.created_at
                                                ).toLocaleDateString("vi-VN")}
                                            </>
                                        )}
                                    </span>
                                    {isEdited && (
                                        <span
                                            className="italic text-gray-400"
                                            title="Tin nhắn đã được chỉnh sửa"
                                        >
                                            (Đã chỉnh sửa)
                                        </span>
                                    )}
                                </div>

                                {isMe && !msg.is_deleted && (
                                    <div className="absolute bottom-1 left-1 hidden group-hover:block">
                                        <MessageActions
                                            messageId={msg.id}
                                            currentContent={msg.content ?? ""}
                                            onHideSuccess={() =>
                                                handleHideMessage(msg.id)
                                            }
                                            onDeleteSuccess={() =>
                                                handleDeleteMessage(msg.id)
                                            }
                                            onEditSuccess={(newContent) =>
                                                handleEditMessage(
                                                    msg.id,
                                                    newContent
                                                )
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
                                    className="w-9 h-9 rounded-full shadow-md border border-gray-600"
                                />
                            )}
                        </div>
                    );
                })
            )}
        </div>
    );
}
