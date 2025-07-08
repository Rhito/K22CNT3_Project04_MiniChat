import { Route, Routes, Navigate } from "react-router-dom";
import "./App.css";
import UserLogin from "./auth/LoginPage";
import UserRegister from "./auth/RegisterPage";
import ChatPage from "./pages/ChatPage";
import CheckLogin from "./components/CheckLogin";

function App() {
    return (
        <Routes>
            <Route path="/" element={<UserLogin />} />
            <Route path="/register" element={<UserRegister />} />

            <Route
                path="/chat"
                element={
                    <CheckLogin>
                        <ChatPage />
                    </CheckLogin>
                }
            />
            <Route
                path="/chat/:conversationId"
                element={
                    <CheckLogin>
                        <ChatPage />
                    </CheckLogin>
                }
            />

            {/* Redirect fallback nếu không khớp route */}
            <Route path="*" element={<Navigate to="/" />} />
        </Routes>
    );
}

export default App;
