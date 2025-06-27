import { useState, useRef } from "react";
import axios from "axios";
import { Paperclip, Send } from "lucide-react";

interface Props {
    conversationId: number;
    onMessageSent?: (newMessage: any) => void;
}

export default function MessageInput({ conversationId, onMessageSent }: Props) {
    const [sendMessage, setSendMessage] = useState("");
    const [sending, setSending] = useState(false);
    const fileInputRef = useRef<HTMLInputElement>(null);
    const token = localStorage.getItem("authToken");

    const handleSend = async () => {
        if (!sendMessage.trim() || !token) return;
        setSending(true);

        try {
            const res = await axios.post(
                `${import.meta.env.VITE_API_BASE_URL}/api/v1/messages`,
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

            setSendMessage("");
            onMessageSent?.(res.data.data);
        } catch (err: any) {
            console.error(
                "Gửi tin nhắn thất bại:",
                err.response?.data?.message || err.message
            );
        } finally {
            setSending(false);
        }
    };

    const handleFileChange = async (e: React.ChangeEvent<HTMLInputElement>) => {
        const file = e.target.files?.[0];
        if (!file || !token) return;

        const formData = new FormData();
        formData.append("conversation_id", conversationId.toString());
        formData.append("files[]", file);

        try {
            const res = await axios.post(
                `${import.meta.env.VITE_API_BASE_URL}/api/v1/messages/upload`,
                formData,
                {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        "Content-Type": "multipart/form-data",
                    },
                }
            );
            onMessageSent?.(res.data.data);
        } catch (err: any) {
            console.error(
                "Gửi file thất bại:",
                err.response?.data?.message || err.message
            );
        } finally {
            if (fileInputRef.current) {
                fileInputRef.current.value = "";
            }
        }
    };

    const handleKeyDown = (e: React.KeyboardEvent<HTMLInputElement>) => {
        if (e.key === "Enter" && !e.shiftKey) {
            e.preventDefault();
            handleSend();
        }
    };

    return (
        <div className="w-full px-4 py-3 bg-gray-900 border-t border-gray-700">
            <div className="flex items-center bg-gray-800 rounded-full px-4 py-2 shadow-inner focus-within:ring-2 focus-within:ring-blue-600 transition">
                {/* Nút đính kèm */}
                <label
                    className="text-gray-300 hover:text-green-400 cursor-pointer transition"
                    title="Đính kèm file"
                >
                    <Paperclip size={20} />
                    <input
                        type="file"
                        ref={fileInputRef}
                        onChange={handleFileChange}
                        className="hidden"
                    />
                </label>

                {/* Input nhập tin nhắn */}
                <input
                    type="text"
                    value={sendMessage}
                    onChange={(e) => setSendMessage(e.target.value)}
                    onKeyDown={handleKeyDown}
                    placeholder="Nhập tin nhắn..."
                    disabled={sending}
                    className="flex-1 bg-transparent border-none outline-none text-white px-4 placeholder-gray-400 text-sm"
                />

                {/* Nút gửi */}
                <button
                    onClick={handleSend}
                    disabled={sending || !sendMessage.trim()}
                    className="text-gray-300 hover:text-blue-500 transition disabled:opacity-40 disabled:cursor-not-allowed"
                    title="Gửi"
                >
                    <Send size={20} />
                </button>
            </div>
        </div>
    );
}
