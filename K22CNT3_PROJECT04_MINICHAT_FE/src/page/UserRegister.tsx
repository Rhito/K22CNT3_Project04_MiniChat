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
        err?.response?.data?.message || "Đăng ký thất bại. Vui lòng thử lại."
      );
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="max-w-md mx-auto mt-10 p-6 border border-gray-300 rounded-lg shadow bg-white">
      <h2 className="text-2xl font-semibold mb-6 text-center">Đăng ký</h2>
      <form onSubmit={handleSubmit}>
        <div className="mb-4">
          <label className="block mb-1">Tên đăng nhập</label>
          <input
            type="text"
            name="name"
            value={form.name}
            onChange={handleChange}
            className="w-full px-3 py-2 border rounded"
            required
            disabled={loading}
            minLength={8}
          />
        </div>
        <div className="mb-4">
          <label className="block mb-1">Email</label>
          <input
            type="email"
            name="email"
            value={form.email}
            onChange={handleChange}
            className="w-full px-3 py-2 border rounded"
            required
            disabled={loading}
          />
        </div>
        <div className="mb-4">
          <label className="block mb-1">Mật khẩu</label>
          <input
            type="password"
            name="password"
            value={form.password}
            onChange={handleChange}
            className="w-full px-3 py-2 border rounded"
            required
            disabled={loading}
            minLength={8}
          />
        </div>
        <div className="mb-4">
          <label className="block mb-1">Xác nhận mật khẩu</label>
          <input
            type="password"
            name="confirmPassword"
            value={form.confirmPassword}
            onChange={handleChange}
            className="w-full px-3 py-2 border rounded"
            required
            disabled={loading}
            minLength={8}
          />
        </div>
        {error && <p className="text-red-600 text-sm mb-2">{error}</p>}
        {success && <p className="text-green-600 text-sm mb-2">{success}</p>}
        <button
          type="submit"
          className="w-full py-2 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-60"
          disabled={loading}
        >
          {loading ? "Đang đăng ký..." : "Đăng ký"}
        </button>
        <p className="mt-4 text-sm text-center">
          Đã có tài khoản?{" "}
          <Link to="/" className="text-blue-600 hover:underline">
            Đăng nhập
          </Link>
        </p>
      </form>
    </div>
  );
};

export default UserRegister;
