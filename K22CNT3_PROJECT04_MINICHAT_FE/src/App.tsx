import { Route, Routes } from "react-router-dom";
import "./App.css";
import UserLogin from "./page/UserLogin";
import UserRegister from "./page/UserRegister";
import Chat from "./component/chat";

function App() {
  return (
    <>
      <Routes>
        <Route path="/" element={<UserLogin />} />
        <Route path="/register" element={<UserRegister />} />
        <Route path="/home" element={<Chat />} />
      </Routes>
    </>
  );
}

export default App;
