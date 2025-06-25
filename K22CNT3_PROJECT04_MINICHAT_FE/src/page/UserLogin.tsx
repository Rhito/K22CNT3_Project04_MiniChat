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
      setError("Please enter both email and password.");
      setLoading(false);
      return;
    }
    loginApi(email, password, setError, setLoading, navigate);
  };

  return (
    <div className="max-w-md mx-auto mt-10 p-6 border border-gray-300 rounded-lg shadow bg-white">
      <h2 className="text-2xl font-semibold mb-6 text-center">Đăng nhập</h2>
      <form onSubmit={handleSubmit}>
        <div className="mb-4">
          <label htmlFor="email" className="block font-medium mb-1">
            Email
          </label>
          <input
            id="email"
            type="email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            className="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-400"
            required
            disabled={loading}
          />
        </div>
        <div className="mb-4">
          <label htmlFor="password" className="block font-medium mb-1">
            Mật khẩu
          </label>
          <input
            id="password"
            type="password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            className="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-400"
            required
            disabled={loading}
          />
        </div>
        <div className="mb-4 flex justify-between items-center">
          <div />
          <Link
            to="/register"
            className="text-blue-600 hover:underline text-sm font-medium"
          >
            Đăng kí
          </Link>
        </div>
        {error && <div className="text-red-600 mb-4 text-sm">{error}</div>}
        <button
          type="submit"
          className="w-full py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition disabled:opacity-60"
          disabled={loading}
        >
          {loading ? "Logging in..." : "Đăng nhập"}
        </button>
      </form>
    </div>
  );
};

export default UserLogin;
