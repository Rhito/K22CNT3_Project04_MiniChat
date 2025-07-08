import { useState } from "react";
import { useEditMessage } from "../../hooks/useMessageActions";
import type { Message } from "../../types";

export default function EditMessageModal({
    message,
    onClose,
}: {
    message: Message;
    onClose: () => void;
}) {
    const [content, setContent] = useState(message.content || "");
    const { editMessage, loading } = useEditMessage();

    const handleSave = () => {
        if (content.trim()) {
            editMessage(message.id, content);
            onClose();
        }
    };

    return (
        <div className="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div className="bg-gray-900 border border-gray-700 rounded-xl w-96 p-6 text-white">
                <h2 className="text-lg font-bold mb-4">Chỉnh sửa tin nhắn</h2>
                <textarea
                    value={content}
                    onChange={(e) => setContent(e.target.value)}
                    className="w-full h-24 bg-gray-800 border border-gray-600 rounded-md p-2 text-white"
                />
                <div className="mt-4 flex justify-end gap-2">
                    <button
                        onClick={onClose}
                        className="px-4 py-2 bg-gray-600 rounded-md"
                    >
                        Huỷ
                    </button>
                    <button
                        onClick={handleSave}
                        disabled={loading || !content.trim()}
                        className="px-4 py-2 bg-blue-600 rounded-md hover:bg-blue-500"
                    >
                        Lưu
                    </button>
                </div>
            </div>
        </div>
    );
}
