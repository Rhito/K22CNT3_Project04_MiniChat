import { useMessages } from "../../hooks/useMessages";
import MessageItem from "./MessageItem";
import { useEffect, useRef } from "react";

interface ChatBodyProps {
    conversationId: number;
}

export default function ChatBody({ conversationId }: ChatBodyProps) {
    const { messages, isLoading, error } = useMessages(conversationId);
    const bottomRef = useRef<HTMLDivElement | null>(null);

    useEffect(() => {
        // Cuộn xuống cuối khi có tin nhắn mới
        bottomRef.current?.scrollIntoView({ behavior: "smooth" });
    }, [messages]);

    return (
        <div className="flex-1 overflow-y-auto px-4 py-2 space-y-6 bg-gray-900">
            {isLoading ? (
                <p className="text-gray-400 animate-pulse text-sm">
                    Đang tải tin nhắn...
                </p>
            ) : error ? (
                <p className="text-red-500 text-sm">{error}</p>
            ) : messages.length === 0 ? (
                <p className="text-gray-400 text-sm">Chưa có tin nhắn.</p>
            ) : (
                <>
                    {messages.map((msg) => (
                        <MessageItem key={msg.id} message={msg} />
                    ))}
                    {/* Phần tử đánh dấu cuối danh sách */}
                    <div ref={bottomRef} />
                </>
            )}
        </div>
    );
}
