// 📁 src/pages/UserRegister.tsx
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
        <div className="max-w-md mx-auto mt-10 p-6 border rounded bg-white">
            <h2 className="text-2xl font-semibold mb-6 text-center">Đăng ký</h2>
            <form onSubmit={handleSubmit}>
                <input
                    name="name"
                    value={form.name}
                    onChange={handleChange}
                    placeholder="Tên đăng nhập"
                    className="w-full mb-3 px-3 py-2 border rounded"
                    required
                    disabled={loading}
                />
                <input
                    name="email"
                    value={form.email}
                    onChange={handleChange}
                    type="email"
                    placeholder="Email"
                    className="w-full mb-3 px-3 py-2 border rounded"
                    required
                    disabled={loading}
                />
                <input
                    name="password"
                    value={form.password}
                    onChange={handleChange}
                    type="password"
                    placeholder="Mật khẩu"
                    className="w-full mb-3 px-3 py-2 border rounded"
                    required
                    disabled={loading}
                />
                <input
                    name="password_confirmation"
                    value={form.password_confirmation}
                    onChange={handleChange}
                    type="password"
                    placeholder="Xác nhận mật khẩu"
                    className="w-full mb-3 px-3 py-2 border rounded"
                    required
                    disabled={loading}
                />
                {error && (
                    <div className="text-red-600 mb-2 text-sm">{error}</div>
                )}
                <button
                    className="w-full bg-blue-600 text-white py-2 rounded"
                    disabled={loading}
                >
                    {loading ? "Đang đăng ký..." : "Đăng ký"}
                </button>
            </form>
            <p className="text-center mt-4 text-sm">
                Đã có tài khoản?{" "}
                <Link to="/" className="text-blue-600 hover:underline">
                    Đăng nhập
                </Link>
            </p>
        </div>
    );
};

export default UserRegister;
