// ✅ hooks/useMessages.ts
import { useEffect, useState } from "react";
import type { Message } from "../types";
import echo from "../echo/createEcho";
import { fetchMessages } from "../services/messageService";

export function useMessages(conversationId: number) {
    const [messages, setMessages] = useState<Message[]>([]);
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState<string | null>(null);

    useEffect(() => {
        const token = localStorage.getItem("authToken");
        if (!token) {
            setError("No auth token found");
            console.warn("[useMessages] Missing auth token");
            return;
        }

        setIsLoading(true);

        const loadMessages = async () => {
            try {
                const data = await fetchMessages(conversationId, token);
                setMessages(data.reverse());
            } catch (err: any) {
                console.error("[useMessages] Fetch error:", err);
                setError(err.message || "Lỗi khi tải tin nhắn");
            } finally {
                setIsLoading(false);
            }
        };

        loadMessages();

        try {
            const channel = echo.private(`conversation.${conversationId}`);

            channel
                .listen(".message.sent", (e: any) => {
                    console.log("[Echo] message.sent", e.message);
                    setMessages((prev) =>
                        prev.some((msg) => msg.id === e.message.id)
                            ? prev
                            : [...prev, e.message]
                    );
                })
                .listen(".message.updated", (e: any) => {
                    console.log("[Echo] message.updated", e.message);
                    setMessages((prev) =>
                        prev.map((msg) =>
                            msg.id === e.message.id ? e.message : msg
                        )
                    );
                })
                .listen(".message.deleted", (e: any) => {
                    console.log("[Echo] message.deleted", e.message);
                    setMessages((prev) =>
                        prev.map((msg) =>
                            msg.id === e.message.id ? e.message : msg
                        )
                    );
                });

            return () => {
                console.info(
                    `[useMessages] Leaving channel conversation.${conversationId}`
                );
                echo.leave(`conversation.${conversationId}`);
            };
        } catch (err: any) {
            console.error("[useMessages] Echo subscription error:", err);
        }
    }, [conversationId]);

    return { messages, isLoading, error };
}
