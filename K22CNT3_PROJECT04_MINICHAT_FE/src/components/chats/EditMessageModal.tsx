import { useState } from "react";
import axios from "axios";

interface Props {
    messageId: number;
    initialContent: string;
    onClose: () => void;
    onUpdated: (newContent: string) => void;
}

export default function EditMessageModal({
    messageId,
    initialContent,
    onClose,
    onUpdated,
}: Props) {
    const [content, setContent] = useState(initialContent);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState<string | null>(null);

    const handleUpdate = async () => {
        const token = localStorage.getItem("authToken");
        if (!token) return;

        setLoading(true);
        setError(null); // Reset lỗi trước đó
        try {
            const response = await axios.patch(
                `${
                    import.meta.env.VITE_API_BASE_URL
                }/api/v1/messages/${messageId}`,
                { content },
                {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        Accept: "application/json",
                    },
                }
            );
            onUpdated(response.data.data.content);
            onClose();
        } catch (err: any) {
            const message =
                err.response?.data?.message || "Lỗi không xác định.";
            setError(message);
            console.error("Lỗi cập nhật tin nhắn:", message);
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div className="bg-gray-900 border border-gray-700 rounded-xl w-96 p-6 text-white">
                <h2 className="text-lg font-bold mb-4">Chỉnh sửa tin nhắn</h2>

                <textarea
                    value={content}
                    onChange={(e) => setContent(e.target.value)}
                    className="w-full h-24 bg-gray-800 border border-gray-600 rounded-md p-2 text-white resize-none"
                />

                {error && <p className="mt-2 text-sm text-red-400">{error}</p>}

                <div className="mt-4 flex justify-end gap-2">
                    <button
                        onClick={onClose}
                        className="px-4 py-2 rounded-md bg-gray-600 hover:bg-gray-500"
                        disabled={loading}
                    >
                        Huỷ
                    </button>
                    <button
                        onClick={handleUpdate}
                        className="px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-500"
                        disabled={loading || content.trim() === ""}
                    >
                        Lưu
                    </button>
                </div>
            </div>
        </div>
    );
}
