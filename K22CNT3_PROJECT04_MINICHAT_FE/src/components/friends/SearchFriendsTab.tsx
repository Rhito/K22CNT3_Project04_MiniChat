import { useState } from "react";

const API_BASE = import.meta.env.VITE_API_BASE_URL;
const token = localStorage.getItem("authToken");
const headers = {
    Authorization: `Bearer ${token}`,
    "Content-Type": "application/json",
};

export default function SearchFriendsTab() {
    const [query, setQuery] = useState("");
    const [results, setResults] = useState<any[]>([]);

    const handleSearch = async () => {
        const res = await fetch(`${API_BASE}/api/v1/friends/search`, {
            method: "POST",
            headers,
            body: JSON.stringify({ query }),
        });
        const json = await res.json();
        setResults(json.data);
    };

    const handleAdd = async (receiverId: number) => {
        await fetch(`${API_BASE}/api/v1/friends/request`, {
            method: "POST",
            headers,
            body: JSON.stringify({ receiver_id: receiverId }),
        });
        alert("Đã gửi lời mời kết bạn!");
        setResults([]);
    };

    const avatarUrl = (avatar: string | null) =>
        avatar ? `${API_BASE}/storage/${avatar}` : "/default-avatar.png";

    return (
        <div>
            <input
                value={query}
                onChange={(e) => setQuery(e.target.value)}
                placeholder="Nhập tên hoặc email..."
                className="w-full bg-gray-800 text-white px-3 py-2 rounded outline-none"
            />
            <button
                onClick={handleSearch}
                className="mt-2 bg-green-500 px-3 py-1 rounded text-sm"
            >
                Tìm kiếm
            </button>

            <ul className="space-y-2 mt-3">
                {results.map((u) => (
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
                            className="text-xs text-green-400 hover:underline"
                            onClick={() => handleAdd(u.id)}
                        >
                            Kết bạn
                        </button>
                    </li>
                ))}
            </ul>
        </div>
    );
}
