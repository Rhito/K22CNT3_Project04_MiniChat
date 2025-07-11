// src/pages/FriendsPage.tsx

import { useState } from "react";
import FriendList from "../components/friends/FriendList";
import PendingRequestsTab from "../components/friends/PendingRequestsTab";
import SearchFriendsTab from "../components/friends/SearchFriendsTab";
import BlockedList from "../components/friends/BlockedList";

const tabs = [
    { id: "friends", label: "Bạn bè" },
    { id: "pending", label: "Lời mời" },
    { id: "search", label: "Tìm kiếm" },
    { id: "blocked", label: "Đã chặn" },
] as const;

type TabKey = (typeof tabs)[number]["id"];

export default function FriendsPage() {
    const [activeTab, setActiveTab] = useState<TabKey>("friends");

    return (
        <div className="flex flex-col h-full">
            {/* Header with tab buttons */}
            <div className="flex border-b border-gray-700 bg-gray-800">
                {tabs.map((tab) => (
                    <button
                        key={tab.id}
                        onClick={() => setActiveTab(tab.id)}
                        className={`px-4 py-2 text-sm font-medium border-b-2 transition-colors duration-200
                            ${
                                activeTab === tab.id
                                    ? "border-green-500 text-white"
                                    : "border-transparent text-gray-400 hover:text-white hover:border-gray-500"
                            }`}
                    >
                        {tab.label}
                    </button>
                ))}
            </div>

            {/* Tab content */}
            <div className="flex-1 overflow-y-auto p-4">
                {activeTab === "friends" && <FriendList />}
                {activeTab === "pending" && <PendingRequestsTab />}
                {activeTab === "search" && <SearchFriendsTab />}
                {activeTab === "blocked" && <BlockedList />}
            </div>
        </div>
    );
}
