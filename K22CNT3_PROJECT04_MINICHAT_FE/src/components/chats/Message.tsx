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
                "https://k22cnt3_project4_minichat.test/api/v1/messages/upload",
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
        <div className="w-full px-4 py-3 bg-gray-800 border-t border-gray-700">
            <div className="relative flex items-center gap-3">
                {/* Input chính */}
                <input
                    type="text"
                    value={sendMessage}
                    onChange={(e) => setSendMessage(e.target.value)}
                    onKeyDown={handleKeyDown}
                    placeholder="Nhập tin nhắn..."
                    disabled={sending}
                    className="flex-1 rounded-full bg-gray-700 text-white px-4 py-3 pr-20 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />

                {/* Nút gửi */}
                <button
                    onClick={handleSend}
                    disabled={sending || !sendMessage.trim()}
                    className="absolute right-3 top-1/2 -translate-y-1/2 text-white hover:text-blue-400 transition disabled:opacity-50"
                >
                    <Send size={20} />
                </button>

                {/* Nút gửi file */}
                <label
                    className="absolute right-10 top-1/2 -translate-y-1/2 text-white hover:text-green-400 cursor-pointer transition"
                    title="Gửi file"
                >
                    <Paperclip size={20} />
                    <input
                        type="file"
                        ref={fileInputRef}
                        onChange={handleFileChange}
                        className="hidden"
                    />
                </label>
            </div>
        </div>
    );
}
