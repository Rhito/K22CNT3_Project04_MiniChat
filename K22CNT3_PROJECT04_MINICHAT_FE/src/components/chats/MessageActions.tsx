import { MoreVertical, Trash2, EyeOff, Pencil } from "lucide-react";
import { useState } from "react";

interface Props {
    messageId: number;
    onHideSuccess: () => void;
}

export default function MessageActions({ messageId, onHideSuccess }: Props) {
    const [open, setOpen] = useState(false);

    const token = localStorage.getItem("authToken");

    const handleHide = async () => {
        if (!token) return;
        try {
            await fetch(
                `${
                    import.meta.env.VITE_API_BASE_URL
                }/api/v1/messages/${messageId}/hide`,
                {
                    method: "POST",
                    headers: {
                        Authorization: `Bearer ${token}`,
                        Accept: "application/json",
                    },
                }
            );
            console.log("Đã ẩn tin nhắn");
            onHideSuccess();
        } catch (error) {
            console.error("Lỗi ẩn tin nhắn", error);
        }
        setOpen(false);
    };

    const handleDelete = async () => {
        if (!token) return;
        try {
            await fetch(
                `${
                    import.meta.env.VITE_API_BASE_URL
                }/api/v1/messages/${messageId}`,
                {
                    method: "DELETE",
                    headers: {
                        Authorization: `Bearer ${token}`,
                        Accept: "application/json",
                    },
                }
            );
            console.log("Đã xoá tin nhắn");
        } catch (error) {
            console.error("Lỗi xoá tin nhắn", error);
        }
        setOpen(false);
    };

    const handleEdit = () => {
        // Gọi modal hoặc điều hướng đến form sửa
        alert("Chức năng sửa đang được phát triển.");
        setOpen(false);
    };

    return (
        <div className="relative inline-block text-left">
            <button
                onClick={() => setOpen(!open)}
                className="text-white p-1 rounded-full hover:bg-gray-600"
            >
                <MoreVertical size={16} />
            </button>

            {open && (
                <div className="absolute z-10 right-0 mt-1 w-36 bg-gray-800 border border-gray-700 rounded-md shadow-lg text-sm">
                    <button
                        onClick={handleEdit}
                        className="w-full flex items-center gap-2 px-3 py-2 text-left text-white hover:bg-gray-700"
                    >
                        <Pencil size={14} /> Sửa
                    </button>
                    <button
                        onClick={handleHide}
                        className="w-full flex items-center gap-2 px-3 py-2 text-left text-white hover:bg-gray-700"
                    >
                        <EyeOff size={14} /> Ẩn
                    </button>
                    <button
                        onClick={handleDelete}
                        className="w-full flex items-center gap-2 px-3 py-2 text-left text-red-400 hover:bg-gray-700"
                    >
                        <Trash2 size={14} /> Xoá
                    </button>
                </div>
            )}
        </div>
    );
}
