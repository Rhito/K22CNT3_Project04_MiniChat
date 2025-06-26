import ChatBody from "./chats/Body";
import ChatHeader from "./chats/Header";
import MessageInput from "./chats/Message";
import Nav from "./Nav";
import Sidebar from "./Sidebar";
import { useState } from "react";

export default function Chat() {
    const [active, setActive] = useState("chat");
    const [selectedConversationId, setSelectedConversationId] = useState<
        number | null
    >(null);

    return (
        <div className="flex h-screen bg-gray-900 text-white">
            <Nav active={active} onSelect={setActive} />
            <Sidebar
                activeTab={active}
                onSelectConversation={setSelectedConversationId}
            />
            <div className="flex flex-col flex-1">
                {selectedConversationId && (
                    <>
                        <ChatHeader conversationId={selectedConversationId} />
                        <ChatBody conversationId={selectedConversationId} />
                        <MessageInput conversationId={selectedConversationId} />
                    </>
                )}
            </div>
        </div>
    );
}
