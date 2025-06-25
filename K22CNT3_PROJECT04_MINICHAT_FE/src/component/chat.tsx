import ChatBody from "./Body";
import ChatHeader from "./Header";
import MessageInput from "./Message";
import Nav from "./Nav";
import Sidebar from "./Sidebar";
import { useState } from "react";
export default function Chat() {
  const [active, setActive] = useState("chat");

  return (
    <div className="flex h-screen bg-gray-900 text-white">
      <Nav active={active} onSelect={setActive} />
      <Sidebar activeTab={active} />
      <div className="flex flex-col flex-1">
        <ChatHeader />
        {/* <ChatBody /> */}
        <MessageInput />
      </div>
    </div>
  );
}
