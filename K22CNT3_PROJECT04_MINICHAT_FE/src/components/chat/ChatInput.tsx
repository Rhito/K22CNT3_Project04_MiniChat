import { useState, useRef } from "react";
import { Paperclip, Send } from "lucide-react";
import { useSendMessage } from "../../hooks/useSendMessage";

interface Props {
    conversationId: number;
}

export default function ChatInput({ conversationId }: Props) {
    const [text, setText] = useState("");
    const fileRef = useRef<HTMLInputElement>(null);
    const { send, upload, isSending } = useSendMessage(conversationId);

    const handleSend = () => {
        if (text.trim()) send(text).then(() => setText(""));
    };

    const handleFile = (e: React.ChangeEvent<HTMLInputElement>) => {
        const file = e.target.files?.[0];
        if (file) upload(file);
        if (fileRef.current) fileRef.current.value = "";
    };

    return (
        <div className="w-full px-4 py-3 bg-gray-900 border-t border-gray-700">
            <div className="flex items-center bg-gray-800 rounded-full px-4 py-2">
                <label className="cursor-pointer text-gray-300 hover:text-green-400">
                    <Paperclip size={20} />
                    <input
                        type="file"
                        ref={fileRef}
                        onChange={handleFile}
                        className="hidden"
                    />
                </label>
                <input
                    type="text"
                    value={text}
                    onChange={(e) => setText(e.target.value)}
                    onKeyDown={(e) => e.key === "Enter" && handleSend()}
                    placeholder="Nhập tin nhắn..."
                    className="flex-1 bg-transparent text-white px-4 outline-none text-sm"
                />
                <button
                    onClick={handleSend}
                    disabled={isSending || !text.trim()}
                    className="text-gray-300 hover:text-blue-500 disabled:opacity-40"
                >
                    <Send size={20} />
                </button>
            </div>
        </div>
    );
}
