import { MoreVertical, Pencil, EyeOff, Trash2 } from "lucide-react";
import { useState } from "react";
import { useMessageActions } from "../../hooks/useMessageActions";
import type { Message } from "../../types";
import EditMessageModal from "./EditMessageModal";

export default function MessageActions({ message }: { message: Message }) {
    const [open, setOpen] = useState(false);
    const [editOpen, setEditOpen] = useState(false);
    const { hideMessage, deleteMessage } = useMessageActions();

    const handleDelete = () => {
        const confirmed = window.confirm(
            "Bạn có chắc chắn muốn xoá tin nhắn này?"
        );
        if (confirmed) {
            deleteMessage(message.id);
            setOpen(false);
        }
    };

    const handleHide = () => {
        const confirmed = window.confirm("Bạn có muốn ẩn tin nhắn này không?");
        if (confirmed) {
            hideMessage(message.id);
            setOpen(false);
        }
    };

    return (
        <div className="relative inline-block">
            <button
                onClick={() => setOpen(!open)}
                className="text-white p-1 rounded-full hover:bg-gray-600"
            >
                <MoreVertical size={16} />
            </button>
            {open && (
                <div className="absolute right-1 bottom-7 z-10 mt-1 w-36 bg-gray-800 border border-gray-700 rounded-md shadow-lg">
                    <button
                        onClick={() => {
                            setEditOpen(true);
                            setOpen(false);
                        }}
                        className="w-full flex items-center gap-2 px-3 py-2 hover:bg-gray-700"
                    >
                        <Pencil size={14} /> <span>Sửa</span>
                    </button>
                    <button
                        onClick={handleHide}
                        className="w-full flex items-center gap-2 px-3 py-2 hover:bg-gray-700"
                    >
                        <EyeOff size={14} /> <span>Ẩn</span>
                    </button>
                    <button
                        onClick={handleDelete}
                        className="w-full flex items-center gap-2 px-3 py-2 text-red-400 hover:bg-gray-700"
                    >
                        <Trash2 size={14} /> <span>Xoá</span>
                    </button>
                </div>
            )}

            {editOpen && (
                <EditMessageModal
                    message={message}
                    onClose={() => setEditOpen(false)}
                />
            )}
        </div>
    );
}
