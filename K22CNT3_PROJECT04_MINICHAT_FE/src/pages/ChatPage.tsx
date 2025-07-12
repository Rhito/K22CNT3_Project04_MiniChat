import { useParams, useNavigate } from "react-router-dom";
import { useEffect, useState } from "react";
import Sidebar from "../components/layout/Sidebar";
import Nav from "../components/layout/Nav";
import ChatHeader from "../components/chat/ChatHeader";
import ChatBody from "../components/chat/ChatBody";
import ChatInput from "../components/chat/ChatInput";
import type { TabId } from "../types";
import FriendsPage from "./FriendsPage";

export default function ChatPage() {
    const { conversationId } = useParams<{ conversationId?: string }>();
    const navigate = useNavigate(); // ✅ cần khai báo

    const [activeTab, setActiveTab] = useState<TabId>("chat");
    const [selectedConversationId, setSelectedConversationId] = useState<
        number | null
    >(null);

    useEffect(() => {
        if (conversationId) {
            const id = parseInt(conversationId, 10);
            if (!isNaN(id)) {
                setSelectedConversationId(id);
                setActiveTab("chat");
            }
        }
    }, [conversationId]);

    useEffect(() => {
        if (!selectedConversationId && conversationId) {
            navigate("/chat", { replace: true });
        }
    }, [selectedConversationId, conversationId, navigate]);

    return (
        <div className="flex h-screen bg-gray-900 text-white">
            <Nav active={activeTab} onSelect={setActiveTab} />

            <Sidebar
                activeTab={activeTab}
                selectedConversationId={selectedConversationId}
                onSelectConversation={(id) => setSelectedConversationId(id)}
                onTabChange={setActiveTab}
            />

            <div className="flex flex-col flex-1">
                {activeTab === "chat" && selectedConversationId ? (
                    <>
                        <ChatHeader conversationId={selectedConversationId} />
                        <ChatBody conversationId={selectedConversationId} />
                        <ChatInput conversationId={selectedConversationId} />
                    </>
                ) : activeTab === "friends" ? (
                    <FriendsPage />
                ) : (
                    <div className="flex flex-1 items-center justify-center text-gray-400 text-sm">
                        Chọn một cuộc trò chuyện để bắt đầu
                    </div>
                )}
            </div>
        </div>
    );
}
