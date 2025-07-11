import React, { useEffect, useState } from "react";
import {
    acceptFriendRequest,
    declineFriendRequest,
    getFriendRequests,
} from "../../Api/friendListApi";

type FriendRequest = {
    id: number;
    sender_id: number;
    receiver_id: number;
    status: string;
    sender: {
        id: number;
        name: string;
        email: string;
        avatar?: string;
    };
};

const FriendRequestList: React.FC = () => {
    const [requests, setRequests] = useState<FriendRequest[]>([]);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState<string | null>(null);

    const fetchRequests = async () => {
        const token = localStorage.getItem("authToken");
        if (!token) {
            setError("Bạn chưa đăng nhập.");
            return;
        }

        setLoading(true);
        try {
            const res = await getFriendRequests(token);
            console.log("Friend requests response:", res);
            setRequests((res as FriendRequest[]) || []);
            console.log(res);
        } catch (err) {
            setError("Không thể tải danh sách lời mời.");
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchRequests();
    }, []);

    const handleAccept = async (sender_id: number) => {
        const token = localStorage.getItem("authToken");
        if (!token) return;
        console.log(sender_id);
        try {
            await acceptFriendRequest(token, sender_id);
            // Cập nhật lại danh sách
            setRequests((prev) =>
                prev.filter((req) => req.sender_id !== sender_id)
            );
        } catch (err) {
            alert("Lỗi khi chấp nhận lời mời.");
        }
    };

    const handleDecline = async (receiver_id: number) => {
        const token = localStorage.getItem("authToken");
        if (!token) return;

        try {
            await declineFriendRequest(token, receiver_id);
            setRequests((prev) =>
                prev.filter((req) => req.receiver_id !== receiver_id)
            );
        } catch (err) {
            alert("Lỗi khi từ chối lời mời.");
        }
    };

    return (
        <div className="max-w-md mx-auto mt-6 p-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded shadow">
            <h2 className="text-xl font-bold text-gray-800 dark:text-white mb-4">
                Lời mời kết bạn
            </h2>

            {loading && <p className="text-blue-500">Đang tải...</p>}
            {error && <p className="text-red-500">{error}</p>}

            {!loading && !error && requests.length === 0 && (
                <p className="text-gray-600 dark:text-gray-300 text-sm">
                    Không có lời mời nào.
                </p>
            )}

            <ul className="space-y-3">
                {requests.map((req) => (
                    <li
                        key={req.id}
                        className="p-3 bg-gray-100 dark:bg-gray-700 rounded shadow-sm"
                    >
                        <p className="text-gray-900 dark:text-white font-medium">
                            {req.sender?.name}
                        </p>
                        <p className="text-gray-600 dark:text-gray-300 text-sm">
                            {req.sender?.email}
                        </p>
                        <div className="mt-2 flex gap-2">
                            <button
                                onClick={() => handleAccept(req.sender_id)}
                                className="px-3 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700"
                            >
                                Chấp nhận
                            </button>
                            <button
                                onClick={() => handleDecline(req.id)}
                                className="px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700"
                            >
                                Từ chối
                            </button>
                        </div>
                    </li>
                ))}
            </ul>
        </div>
    );
};

export default FriendRequestList;
