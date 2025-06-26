import { MoreVertical, Trash2, EyeOff, Pencil } from "lucide-react";
import { useState } from "react";

interface Props {
    messageId: number;
}

export default function MessageActions({ messageId }: Props) {
    const [open, setOpen] = useState(false);

    const token = localStorage.getItem("authToken");
    if (!token) return null;

    const handleRequest = async (method: "POST" | "DELETE", action: string) => {
        try {
            await fetch(
                `https://k22cnt3_project4_minichat.test/api/v1/messages/${messageId}/${action}`,
                {
                    method,
                    headers: {
                        Authorization: `Bearer ${token}`,
                        Accept: "application/json",
                    },
                }
            );
            console.log(`${action} thành công`);
        } catch (err) {
            console.error(`${action} thất bại`, err);
        } finally {
            setOpen(false);
        }
    };

    return (
        <div className="relative inline-block text-left">
            <button
                onClick={() => setOpen((prev) => !prev)}
                className="text-white p-1 rounded-full hover:bg-gray-600"
            >
                <MoreVertical size={16} />
            </button>

            {open && (
                <div className="absolute z-10 right-0 mt-1 w-36 bg-gray-800 border border-gray-700 rounded-md shadow-lg text-sm">
                    <button
                        onClick={() => handleRequest("POST", "hide")}
                        className="w-full flex items-center gap-2 px-3 py-2 text-left text-white hover:bg-gray-700"
                    >
                        <EyeOff size={14} /> Ẩn
                    </button>
                    <button
                        onClick={() =>
                            alert("Chức năng sửa chưa được triển khai")
                        }
                        className="w-full flex items-center gap-2 px-3 py-2 text-left text-white hover:bg-gray-700"
                    >
                        <Pencil size={14} /> Sửa
                    </button>
                    <button
                        onClick={() => handleRequest("DELETE", "")}
                        className="w-full flex items-center gap-2 px-3 py-2 text-left text-red-400 hover:bg-red-600"
                    >
                        <Trash2 size={14} /> Xoá
                    </button>
                </div>
            )}
        </div>
    );
}
