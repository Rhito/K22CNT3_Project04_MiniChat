import { useState } from "react";
import axios from "axios";

interface Props {
    conversationId: number;
    onMessageSent?: (newMessage: any) => void; // Callback khi gửi thành công
}

export default function MessageInput({ conversationId, onMessageSent }: Props) {
    const [sendMessage, setSendMessage] = useState<string>("");
    const [sending, setSending] = useState(false);

    const handleSend = async () => {
        if (!sendMessage.trim()) return;

        const token = localStorage.getItem("authToken");
        if (!token) return;

        setSending(true);
        try {
            const res = await axios.post(
                `https://k22cnt3_project4_minichat.test/api/v1/messages`,
                {
                    conversation_id: conversationId,
                    content: sendMessage,
                    message_type: "text",
                },
                {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        Accept: "application/json",
                    },
                }
            );

            setSendMessage(""); // Clear input
            if (onMessageSent) onMessageSent(res.data.data); // Gọi callback
        } catch (err: any) {
            console.error(
                "Gửi tin nhắn thất bại:",
                err.response?.data?.message || err.message
            );
        } finally {
            setSending(false);
        }
    };

    const handleKeyPress = (e: React.KeyboardEvent<HTMLInputElement>) => {
        if (e.key === "Enter" && !e.shiftKey) {
            e.preventDefault();
            handleSend();
        }
    };

    return (
        <div className="p-4 border-t border-gray-700 flex items-center gap-2 bg-gray-800">
            <div className="relative w-full">
                <input
                    type="text"
                    placeholder="Nhập tin nhắn..."
                    value={sendMessage}
                    onChange={(e) => setSendMessage(e.target.value)}
                    onKeyDown={handleKeyPress}
                    disabled={sending}
                    className="w-full p-3 pr-10 rounded-full bg-gray-700 text-white placeholder-gray-400 focus:outline-none"
                />
                {sendMessage && (
                    <span
                        role="button"
                        aria-label="send"
                        className="absolute right-3 top-1/2 transform -translate-y-1/2 text-white text-lg cursor-pointer hover:text-blue-400"
                        onClick={handleSend}
                    >
                        ➤
                    </span>
                )}
            </div>
        </div>
    );
}
