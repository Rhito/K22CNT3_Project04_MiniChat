// src/components/friends/FriendDetailsPanel.tsx
import type { User } from "../../types";

type Props = {
    user: User;
    onClose: () => void;
};

export default function FriendDetailsPanel({ user, onClose }: Props) {
    const avatarUrl = user.avatar
        ? import.meta.env.VITE_API_BASE_URL + "/storage/" + user.avatar
        : "/default-avatar.png";

    return (
        <div className="flex flex-col gap-4">
            <button
                onClick={onClose}
                className="text-sm text-gray-400 hover:text-white"
            >
                ← Quay lại
            </button>
            <div className="flex items-center gap-4">
                <img
                    src={avatarUrl}
                    alt={user.name}
                    className="w-20 h-20 rounded-full"
                />
                <div>
                    <h2 className="text-xl font-bold">{user.name}</h2>
                    <p className="text-sm text-gray-400">{user.email}</p>
                </div>
            </div>
            {/* Bạn có thể thêm các hành động như Gửi tin nhắn, Xóa bạn, Chặn... tại đây */}
        </div>
    );
}
