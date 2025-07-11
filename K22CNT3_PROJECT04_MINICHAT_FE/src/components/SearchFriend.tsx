import React, { useState } from "react";
import { searchFriend, addFriend } from "../Api/friendListApi";

const FriendSearchForm: React.FC = () => {
    const [email, setEmail] = useState("");
    const [result, setResult] = useState<any>(null);
    const [error, setError] = useState<string | null>(null);
    const [loading, setLoading] = useState(false);
    const [addSuccess, setAddSuccess] = useState<string | null>(null);

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setError(null);
        setAddSuccess(null);
        setResult(null);
        setLoading(true);

        const token = localStorage.getItem("authToken");
        if (!token) {
            setError("Bạn chưa đăng nhập.");
            setLoading(false);
            return;
        }

        try {
            const data = await searchFriend(token, email);
            setResult(data);
        } catch (err: any) {
            setError(err?.response?.data?.message || "Lỗi khi tìm bạn.");
        } finally {
            setLoading(false);
        }
    };

    const handleAddFriend = async (receiver_id: number) => {
        const token = localStorage.getItem("authToken");
        if (!token) {
            setError("Bạn chưa đăng nhập.");
            return;
        }
        console.log(receiver_id);
        try {
            await addFriend(token, receiver_id);
            setAddSuccess("Đã gửi lời mời kết bạn.");
        } catch (err: any) {
            setError(err?.response?.data?.message || "Không thể kết bạn.");
        }
    };

    return (
        <div className="max-w-md mx-auto mt-8 p-4 bg-white dark:bg-gray-800 border rounded shadow border-gray-300 dark:border-gray-700">
            <h2 className="text-xl font-bold mb-4 text-gray-800 dark:text-white">
                Tìm bạn theo Email
            </h2>
            <form onSubmit={handleSubmit} className="space-y-4">
                <input
                    type="email"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    placeholder="Nhập email bạn bè"
                    className="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                    required
                />
                <button
                    type="submit"
                    disabled={loading}
                    className="w-full py-2 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50"
                >
                    {loading ? "Đang tìm..." : "Tìm kiếm"}
                </button>
            </form>

            {error && <p className="mt-4 text-red-600 text-sm">{error}</p>}
            {addSuccess && (
                <p className="mt-2 text-green-500 text-sm">{addSuccess}</p>
            )}

            {result?.data?.length > 0 ? (
                <div className="mt-4 space-y-2">
                    {result.data.map((user: any) => (
                        <div
                            key={user.id}
                            className="p-3 border rounded bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white"
                        >
                            <p>
                                <strong>Tên:</strong> {user.name}
                            </p>
                            <p>
                                <strong>Email:</strong> {user.email}
                            </p>
                            <button
                                onClick={() => handleAddFriend(user.id)}
                                className="mt-2 px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm"
                            >
                                Kết bạn
                            </button>
                        </div>
                    ))}
                </div>
            ) : result ? (
                <p className="mt-4 text-gray-500 dark:text-gray-400 text-sm">
                    Không tìm thấy bạn nào.
                </p>
            ) : null}
        </div>
    );
};

export default FriendSearchForm;
