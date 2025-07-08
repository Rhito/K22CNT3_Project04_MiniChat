// ✅ hooks/useSendMessage.ts
import { useState } from "react";
import { sendTextMessage, uploadFile } from "../services/messageService";

export function useSendMessage(conversationId: number) {
    const [isSending, setIsSending] = useState(false);

    const send = async (content: string) => {
        const token = localStorage.getItem("authToken");
        if (!token) return;
        setIsSending(true);
        await sendTextMessage(conversationId, content, token);
        setIsSending(false);
    };

    const upload = async (file: File) => {
        const token = localStorage.getItem("authToken");
        if (!token) return;
        await uploadFile(conversationId, file, token);
    };

    return { send, upload, isSending };
}
