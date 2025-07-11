// src/components/friends/PendingRequestsTab.tsx
import { useEffect, useState } from "react";
import type { User } from "../../types";

const API_BASE = import.meta.env.VITE_API_BASE_URL;
const token = localStorage.getItem("authToken");
const headers = {
    Authorization: `Bearer ${token}`,
    "Content-Type": "application/json",
};

type FriendRequest = {
    id: number;
    sender: User | null;
};

type Props = {
    onSelect?: (user: User) => void;
};

export default function PendingRequestsTab({ onSelect }: Props) {
    const [requests, setRequests] = useState<FriendRequest[]>([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetchRequests();
    }, []);

    const fetchRequests = async () => {
        try {
            const res = await fetch(`${API_BASE}/api/v1/friends/requests`, {
                headers,
            });
            const json = await res.json();
            setRequests(json.data || []);
        } catch (err) {
            console.error("Failed to fetch friend requests:", err);
        } finally {
            setLoading(false);
        }
    };

    const handleAccept = async (senderId: number) => {
        await fetch(`${API_BASE}/api/v1/friends/accept`, {
            method: "POST",
            headers,
            body: JSON.stringify({ sender_id: senderId }),
        });
        fetchRequests();
    };

    const handleReject = async (id: number) => {
        await fetch(`${API_BASE}/api/v1/friends/reject/${id}`, {
            method: "DELETE",
            headers,
        });
        fetchRequests();
    };

    const avatarUrl = (avatar: string | null) =>
        avatar ? `${API_BASE}/storage/${avatar}` : "/default-avatar.png";

    if (loading) {
        return <p className="text-gray-400 text-sm">Đang tải danh sách...</p>;
    }

    return (
        <div>
            {requests.length === 0 ? (
                <p className="text-gray-400 text-sm">
                    Không có lời mời kết bạn.
                </p>
            ) : (
                <ul className="space-y-2">
                    {requests.map((req) =>
                        req.sender ? (
                            <li
                                key={req.id}
                                className="flex items-center gap-3 hover:bg-gray-800 px-2 py-1 rounded cursor-pointer"
                                onClick={() => onSelect?.(req.sender!)}
                            >
                                <img
                                    src={avatarUrl(req.sender.avatar)}
                                    alt="Avatar"
                                    className="w-10 h-10 rounded-full"
                                />
                                <div className="flex-1">
                                    <p className="text-sm font-medium">
                                        {req.sender.name}
                                    </p>
                                    <p className="text-xs text-gray-400">
                                        {req.sender.email}
                                    </p>
                                </div>
                                <button
                                    className="text-xs text-green-400 hover:underline"
                                    onClick={(e) => {
                                        e.stopPropagation();
                                        handleAccept(req.sender!.id);
                                    }}
                                >
                                    Chấp nhận
                                </button>
                                <button
                                    className="text-xs text-red-400 hover:underline"
                                    onClick={(e) => {
                                        e.stopPropagation();
                                        handleReject(req.id);
                                    }}
                                >
                                    Từ chối
                                </button>
                            </li>
                        ) : null
                    )}
                </ul>
            )}
        </div>
    );
}
