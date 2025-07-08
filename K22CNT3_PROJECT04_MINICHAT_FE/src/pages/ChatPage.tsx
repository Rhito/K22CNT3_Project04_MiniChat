// src/pages/ChatPage.tsx

import { useState } from "react";
import Sidebar from "../components/layout/Sidebar";
import Nav from "../components/layout/Nav";
import ChatHeader from "../components/chat/ChatHeader";
import ChatBody from "../components/chat/ChatBody";
import ChatInput from "../components/chat/ChatInput";
import type { TabId } from "../types";

export default function ChatPage() {
    const [activeTab, setActiveTab] = useState<TabId>("chat");
    const [selectedConversationId, setSelectedConversationId] = useState<
        number | null
    >(null);

    return (
        <div className="flex h-screen bg-gray-900 text-white">
            {/* Navigation left bar */}
            <Nav active={activeTab} onSelect={setActiveTab} />

            {/* Sidebar hiển thị danh sách cuộc trò chuyện */}
            <Sidebar
                activeTab={activeTab}
                selectedConversationId={selectedConversationId}
                onSelectConversation={(id) => setSelectedConversationId(id)}
            />

            {/* Main chat area */}
            <div className="flex flex-col flex-1">
                {selectedConversationId ? (
                    <>
                        <ChatHeader conversationId={selectedConversationId} />
                        <ChatBody conversationId={selectedConversationId} />
                        <ChatInput conversationId={selectedConversationId} />
                    </>
                ) : (
                    <div className="flex flex-1 items-center justify-center text-gray-400 text-sm">
                        Chọn một cuộc trò chuyện để bắt đầu
                    </div>
                )}
            </div>
        </div>
    );
}
