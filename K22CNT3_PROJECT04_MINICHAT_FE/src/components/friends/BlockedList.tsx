// src/components/friends/BlockedList.tsx
import { useEffect, useState } from "react";

const API_BASE = import.meta.env.VITE_API_BASE_URL;
const token = localStorage.getItem("authToken");
const headers = {
    Authorization: `Bearer ${token}`,
};

export default function BlockedList() {
    const [blocked, setBlocked] = useState<any[]>([]);

    const fetchBlocked = async () => {
        const res = await fetch(`${API_BASE}/api/v1/friends`, { headers });
        const json = await res.json();
        const filtered = json.data.filter((f: any) => f.status === "blocked");
        setBlocked(filtered);
    };

    const handleUnblock = async (id: number) => {
        await fetch(`${API_BASE}/api/v1/friends/unblock/${id}`, {
            method: "DELETE",
            headers,
        });
        fetchBlocked();
    };

    useEffect(() => {
        fetchBlocked();
    }, []);

    const avatarUrl = (avatar: string | null) =>
        avatar ? `${API_BASE}/storage/${avatar}` : "/default-avatar.png";

    return (
        <div>
            <ul className="space-y-2">
                {blocked.map((u) => (
                    <li key={u.id} className="flex items-center gap-3">
                        <img
                            src={avatarUrl(u.avatar)}
                            className="w-10 h-10 rounded-full"
                        />
                        <div className="flex-1">
                            <p className="text-sm font-medium">{u.name}</p>
                            <p className="text-xs text-gray-400">{u.email}</p>
                        </div>
                        <button
                            className="text-xs text-yellow-400 hover:underline"
                            onClick={() => handleUnblock(u.id)}
                        >
                            Bỏ chặn
                        </button>
                    </li>
                ))}
            </ul>
        </div>
    );
}
