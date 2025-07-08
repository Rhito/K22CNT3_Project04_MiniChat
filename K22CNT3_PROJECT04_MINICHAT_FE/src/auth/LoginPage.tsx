import React, { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import { loginApi } from "../services/auth/login";

const UserLogin: React.FC = () => {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [error, setError] = useState("");
    const [loading, setLoading] = useState(false);
    const navigate = useNavigate();

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setError("");
        setLoading(true);

        try {
            await loginApi({ email, password });
            navigate("/chat");
        } catch (err: any) {
            setError(err?.response?.data?.message || "Đăng nhập thất bại.");
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="max-w-md mx-auto mt-10 p-6 border border-gray-300 rounded-lg shadow bg-white">
            <h2 className="text-2xl font-semibold mb-6 text-center">
                Đăng nhập
            </h2>
            <form onSubmit={handleSubmit}>
                <input
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    type="email"
                    placeholder="Email"
                    className="w-full mb-3 px-3 py-2 border rounded"
                    disabled={loading}
                    required
                />
                <input
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    type="password"
                    placeholder="Mật khẩu"
                    className="w-full mb-3 px-3 py-2 border rounded"
                    disabled={loading}
                    required
                />
                {error && (
                    <div className="text-red-600 mb-2 text-sm">{error}</div>
                )}
                <button
                    className="w-full bg-blue-600 text-white py-2 rounded"
                    disabled={loading}
                >
                    {loading ? "Đang đăng nhập..." : "Đăng nhập"}
                </button>
            </form>
            <p className="text-center mt-4 text-sm">
                Chưa có tài khoản?{" "}
                <Link to="/register" className="text-blue-600 hover:underline">
                    Đăng ký
                </Link>
            </p>
        </div>
    );
};

export default UserLogin;
