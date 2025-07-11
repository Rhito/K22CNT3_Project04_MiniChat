import React, { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import { loginApi } from "../Api/loginApi";

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

        if (!email || !password) {
            setError("Vui lòng nhập đầy đủ email và mật khẩu.");
            setLoading(false);
            return;
        }

        try {
            await loginApi({ email, password });
            navigate("/Home");
        } catch (err: any) {
            setError(err.message || "Đăng nhập thất bại.");
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="max-w-md mx-auto mt-16 p-6 bg-white border border-gray-300 rounded-xl shadow-lg dark:bg-gray-800 dark:border-gray-700">
            <h2 className="text-3xl font-bold text-center text-gray-800 dark:text-white mb-6">
                Đăng nhập
            </h2>

            <form onSubmit={handleSubmit} className="space-y-5">
                <div>
                    <label
                        htmlFor="email"
                        className="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1"
                    >
                        Email
                    </label>
                    <input
                        id="email"
                        type="email"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        className="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                        required
                        disabled={loading}
                    />
                </div>

                <div>
                    <label
                        htmlFor="password"
                        className="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1"
                    >
                        Mật khẩu
                    </label>
                    <input
                        id="password"
                        type="password"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                        className="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                        required
                        disabled={loading}
                    />
                </div>

                <div className="flex justify-between items-center">
                    <div />
                    <Link
                        to="/register"
                        className="text-sm text-blue-600 hover:underline font-medium dark:text-blue-400"
                    >
                        Đăng ký
                    </Link>
                </div>

                {error && (
                    <p className="text-sm text-red-600 dark:text-red-400">
                        {error}
                    </p>
                )}

                <button
                    type="submit"
                    className="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition disabled:opacity-60 disabled:cursor-not-allowed"
                    disabled={loading}
                >
                    {loading ? "Đang đăng nhập..." : "Đăng nhập"}
                </button>
            </form>
        </div>
    );
};

export default UserLogin;
