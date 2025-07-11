// src/components/friends/FriendsTab.tsx
import { useEffect, useState } from "react";
import axios from "../../utils/axios";
import type { User } from "../../types";

export default function FriendsTab() {
    const [selectedUser, setSelectedUser] = useState<User | null>(null);
    const [friends, setFriends] = useState<User[]>([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetchFriends();
    }, []);

    const fetchFriends = async () => {
        try {
            const res = await axios.get("/api/v1/friends");
            setFriends(res.data.data || []);
        } catch (err) {
            console.error("Lỗi khi tải bạn bè:", err);
        } finally {
            setLoading(false);
        }
    };

    const avatarUrl = (avatar: string | null) =>
        avatar
            ? `${import.meta.env.VITE_API_BASE_URL}/storage/${avatar}`
            : "/default-avatar.png";

    return (
        <div className="relative p-4 text-white flex flex-col h-full">
            {/* Header */}
            {!selectedUser && (
                <div className="flex justify-between items-center mb-4">
                    <h2 className="text-lg font-semibold">Danh sách bạn bè</h2>
                </div>
            )}

            {/* Main content */}
            <div className="flex-1 overflow-y-auto">
                {loading ? (
                    <p className="text-sm text-gray-400">
                        Đang tải danh sách bạn bè...
                    </p>
                ) : (
                    <ul className="space-y-2">
                        {friends.map((f) => (
                            <li
                                key={f.id}
                                className="flex items-center gap-3 hover:bg-gray-800 p-2 rounded cursor-pointer"
                                onClick={() => setSelectedUser(f)}
                            >
                                <img
                                    src={avatarUrl(f.avatar)}
                                    alt="avatar"
                                    className="w-10 h-10 rounded-full"
                                />
                                <div>
                                    <p className="text-sm font-medium">
                                        {f.name}
                                    </p>
                                    <p className="text-xs text-gray-400">
                                        {f.email}
                                    </p>
                                </div>
                            </li>
                        ))}
                    </ul>
                )}
            </div>
        </div>
    );
}
