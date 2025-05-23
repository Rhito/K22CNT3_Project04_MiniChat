import { useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";

const Register = () => {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [passwordConfirmation, setPasswordConfirmation] = useState("");
  const [firstName, setFirstName] = useState("");
  const [lastName, setLastName] = useState("");
  const navigate = useNavigate();

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      const response = await axios.post(
        `${import.meta.env.VITE_API_URL}/register`,
        {
          name,
          email,
          password,
          password_confirmation: passwordConfirmation,
          first_name: firstName,
          last_name: lastName,
        }
      );
      localStorage.setItem("token", response.data.token);
      navigate("/chat");
    } catch (error) {
      console.error("Đăng ký thất bại", error);
    }
  };

  return (
    <form onSubmit={handleSubmit}>
      <h2>Đăng ký</h2>
      <input
        value={name}
        onChange={(e) => setName(e.target.value)}
        placeholder="Tên người dùng"
      />
      <input
        value={firstName}
        onChange={(e) => setFirstName(e.target.value)}
        placeholder="Họ"
      />
      <input
        value={lastName}
        onChange={(e) => setLastName(e.target.value)}
        placeholder="Tên"
      />
      <input
        type="email"
        value={email}
        onChange={(e) => setEmail(e.target.value)}
        placeholder="Email"
      />
      <input
        type="password"
        value={password}
        onChange={(e) => setPassword(e.target.value)}
        placeholder="Mật khẩu"
      />
      <input
        type="password"
        value={passwordConfirmation}
        onChange={(e) => setPasswordConfirmation(e.target.value)}
        placeholder="Xác nhận mật khẩu"
      />
      <button type="submit">Đăng ký</button>
    </form>
  );
};

export default Register;
