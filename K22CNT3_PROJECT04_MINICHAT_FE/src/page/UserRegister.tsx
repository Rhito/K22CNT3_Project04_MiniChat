import React, { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import { registerUser } from "../Api/registerApi";

const UserRegister: React.FC = () => {
    const navigate = useNavigate();

    const [form, setForm] = useState({
        name: "",
        email: "",
        password: "",
        confirmPassword: "",
    });

    const [error, setError] = useState<string | null>(null);
    const [success, setSuccess] = useState<string | null>(null);
    const [loading, setLoading] = useState(false);

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        setForm({ ...form, [e.target.name]: e.target.value });
    };

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setError(null);
        setSuccess(null);

        if (form.name.length < 8) {
            setError("Tên đăng nhập phải có ít nhất 8 ký tự.");
            return;
        }
        if (form.password.length < 8) {
            setError("Mật khẩu phải có ít nhất 8 ký tự.");
            return;
        }
        if (form.confirmPassword.length < 8) {
            setError("Xác nhận mật khẩu phải có ít nhất 8 ký tự.");
            return;
        }
        if (form.password !== form.confirmPassword) {
            setError("Mật khẩu xác nhận không khớp.");
            return;
        }

        setLoading(true);
        try {
            await registerUser({
                name: form.name,
                email: form.email,
                password: form.password,
                password_confirmation: form.confirmPassword,
            });
            setSuccess("Đăng ký thành công! Đang chuyển hướng...");
            setTimeout(() => {
                navigate("/");
            }, 1500);
        } catch (err: any) {
            setError(
                err?.response?.data?.message ||
                    "Đăng ký thất bại. Vui lòng thử lại."
            );
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="max-w-md mx-auto mt-16 p-6 bg-white border border-gray-300 rounded-xl shadow-lg dark:bg-gray-800 dark:border-gray-700">
            <h2 className="text-3xl font-bold text-center text-gray-800 dark:text-white mb-6">
                Đăng ký
            </h2>

            <form onSubmit={handleSubmit} className="space-y-5">
                <div>
                    <label
                        htmlFor="name"
                        className="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1"
                    >
                        Tên đăng nhập
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value={form.name}
                        onChange={handleChange}
                        className="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                        required
                        disabled={loading}
                        minLength={8}
                    />
                </div>

                <div>
                    <label
                        htmlFor="email"
                        className="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1"
                    >
                        Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value={form.email}
                        onChange={handleChange}
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
                        type="password"
                        name="password"
                        id="password"
                        value={form.password}
                        onChange={handleChange}
                        className="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                        required
                        disabled={loading}
                        minLength={8}
                    />
                </div>

                <div>
                    <label
                        htmlFor="confirmPassword"
                        className="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1"
                    >
                        Xác nhận mật khẩu
                    </label>
                    <input
                        type="password"
                        name="confirmPassword"
                        id="confirmPassword"
                        value={form.confirmPassword}
                        onChange={handleChange}
                        className="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                        required
                        disabled={loading}
                        minLength={8}
                    />
                </div>

                {error && (
                    <p className="text-sm text-red-600 dark:text-red-400">
                        {error}
                    </p>
                )}
                {success && (
                    <p className="text-sm text-green-600 dark:text-green-400">
                        {success}
                    </p>
                )}

                <button
                    type="submit"
                    className="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition disabled:opacity-60 disabled:cursor-not-allowed"
                    disabled={loading}
                >
                    {loading ? "Đang đăng ký..." : "Đăng ký"}
                </button>

                <p className="mt-4 text-sm text-center text-gray-600 dark:text-gray-300">
                    Đã có tài khoản?{" "}
                    <Link
                        to="/"
                        className="text-blue-600 hover:underline dark:text-blue-400"
                    >
                        Đăng nhập
                    </Link>
                </p>
            </form>
        </div>
    );
};

export default UserRegister;
