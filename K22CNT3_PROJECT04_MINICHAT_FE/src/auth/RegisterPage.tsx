import React, { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import { registerUser } from "../services/auth/register";

const UserRegister: React.FC = () => {
    const navigate = useNavigate();
    const [form, setForm] = useState({
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
    });
    const [error, setError] = useState<string | null>(null);
    const [loading, setLoading] = useState(false);

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        setForm({ ...form, [e.target.name]: e.target.value });
    };

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setError(null);
        if (form.password !== form.password_confirmation) {
            setError("Mật khẩu xác nhận không khớp.");
            return;
        }
        setLoading(true);
        try {
            await registerUser(form);
            navigate("/");
        } catch (err: any) {
            setError(err?.response?.data?.message || "Đăng ký thất bại");
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="min-h-screen flex items-center justify-center bg-gray-100">
            <div className="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg">
                <h2 className="text-3xl font-bold text-center text-gray-800 mb-6">
                    Đăng ký
                </h2>
                <form onSubmit={handleSubmit} className="space-y-4">
                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">
                            Tên đăng nhập
                        </label>
                        <input
                            name="name"
                            value={form.name}
                            onChange={handleChange}
                            placeholder="Nhập tên đăng nhập"
                            className="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                            disabled={loading}
                        />
                    </div>
                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">
                            Email
                        </label>
                        <input
                            name="email"
                            type="email"
                            value={form.email}
                            onChange={handleChange}
                            placeholder="Nhập email"
                            className="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                            disabled={loading}
                        />
                    </div>
                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">
                            Mật khẩu
                        </label>
                        <input
                            name="password"
                            type="password"
                            value={form.password}
                            onChange={handleChange}
                            placeholder="Nhập mật khẩu"
                            className="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                            disabled={loading}
                        />
                    </div>
                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">
                            Xác nhận mật khẩu
                        </label>
                        <input
                            name="password_confirmation"
                            type="password"
                            value={form.password_confirmation}
                            onChange={handleChange}
                            placeholder="Nhập lại mật khẩu"
                            className="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                            disabled={loading}
                        />
                    </div>
                    {error && (
                        <div className="text-red-500 text-sm">{error}</div>
                    )}
                    <button
                        type="submit"
                        className={`w-full py-2 rounded-xl text-white font-semibold transition duration-200 ${
                            loading
                                ? "bg-blue-400 cursor-not-allowed"
                                : "bg-blue-600 hover:bg-blue-700"
                        }`}
                        disabled={loading}
                    >
                        {loading ? "Đang đăng ký..." : "Đăng ký"}
                    </button>
                </form>
                <p className="mt-6 text-center text-sm text-gray-600">
                    Đã có tài khoản?{" "}
                    <Link
                        to="/"
                        className="text-blue-600 hover:underline font-medium"
                    >
                        Đăng nhập
                    </Link>
                </p>
            </div>
        </div>
    );
};

export default UserRegister;
