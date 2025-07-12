import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";

const API_BASE = import.meta.env.VITE_API_BASE_URL;
const token = localStorage.getItem("authToken");
const headers = {
    Authorization: `Bearer ${token}`,
};

export default function FriendList() {
    const [friends, setFriends] = useState<any[]>([]);
    const navigate = useNavigate();
    const fetchFriends = async () => {
        const res = await fetch(`${API_BASE}/api/v1/friends`, { headers });
        const json = await res.json();
        setFriends(json.data);
    };
    const handleMessage = async (receiverId: number) => {
        try {
            const res = await fetch(`${API_BASE}/api/v1/messages/init`, {
                method: "POST",
                headers: {
                    ...headers,
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ receiver_id: receiverId }),
            });

            const json = await res.json();

            if (json.data?.id) {
                const conversationId = json.data.id;
                navigate(`/chat/${conversationId}`);
            } else {
                alert("Không thể mở cuộc trò chuyện.");
            }
        } catch (err) {
            console.error("Error initializing conversation", err);
        }
    };

    const handleRemove = async (id: number, name: string) => {
        const confirmed = window.confirm(
            `Bạn có chắc muốn hủy kết bạn với ${name}?`
        );
        if (!confirmed) return;
        window.location.reload();
        await fetch(`${API_BASE}/api/v1/friends/${id}`, {
            method: "DELETE",
            headers,
        });
        fetchFriends();
    };

    const handleBlock = async (id: number, name: string) => {
        const confirmed = window.confirm(`Bạn có chắc muốn chặn ${name}?`);
        if (!confirmed) return;

        await fetch(`${API_BASE}/api/v1/friends/block/${id}`, {
            method: "POST",
            headers,
        });
        fetchFriends();
    };

    useEffect(() => {
        fetchFriends();
    }, []);

    const avatarUrl = (avatar: string | null) =>
        avatar ? `${API_BASE}/storage/${avatar}` : "/default-avatar.png";

    return (
        <ul className="space-y-2">
            {friends.map((f) => (
                <li key={f.id} className="flex items-center gap-3">
                    <img
                        src={avatarUrl(f.avatar)}
                        className="w-10 h-10 rounded-full"
                        alt={f.name}
                    />
                    <div className="flex-1">
                        <p className="text-sm font-medium">{f.name}</p>
                        <p className="text-xs text-gray-400">{f.email}</p>
                    </div>
                    <button
                        className="text-xs text-red-400 hover:underline"
                        onClick={() => handleRemove(f.id, f.name)}
                    >
                        Hủy bạn
                    </button>
                    <button
                        className="text-xs text-yellow-400 hover:underline"
                        onClick={() => handleBlock(f.id, f.name)}
                    >
                        Chặn
                    </button>
                    <button
                        className="text-xs text-green-400 hover:underline"
                        onClick={() => handleMessage(f.id)}
                    >
                        Nhắn tin
                    </button>
                </li>
            ))}
        </ul>
    );
}
