// src/components/layout/Sidebar.tsx
import { AnimatePresence, motion } from "framer-motion";
import type { TabId } from "../../types";
import ChatSidebar from "../sidebar-panels/ChatSidebar";
import FriendsSidebar from "../sidebar-panels/FriendsSidebar";
import GroupsSidebar from "../sidebar-panels/GroupsSidebar";
import ProfileSidebar from "../sidebar-panels/ProfileSidebar";
import SettingsSidebar from "../sidebar-panels/SettingsSidebar";
import UniversalSearchBar from "../shared/UniversalSearchBar";
import { useMemo } from "react";

const transition = {
    duration: 0.3,
    ease: [0.4, 0, 0.2, 1] as [number, number, number, number],
};

const panelVariants = {
    initial: { opacity: 0, x: -20 },
    animate: { opacity: 1, x: 0 },
    exit: { opacity: 0, x: -20 },
};

const panelMap: Record<TabId, React.ComponentType<any>> = {
    chat: ChatSidebar,
    friends: FriendsSidebar,
    groups: GroupsSidebar,
    profile: ProfileSidebar,
    settings: SettingsSidebar,
};

type SidebarProps = {
    activeTab: TabId;
    onTabChange: (tab: TabId) => void;
    selectedConversationId?: number | null;
    onSelectConversation: (id: number) => void;
};

export default function Sidebar({
    activeTab,
    selectedConversationId,
    onSelectConversation,
    onTabChange,
}: SidebarProps) {
    const ActivePanel = useMemo(() => panelMap[activeTab], [activeTab]);

    return (
        <aside className="relative w-64 h-screen bg-gray-900 border-r border-gray-700 overflow-hidden">
            {/* <UniversalSearchBar /> */}

            <AnimatePresence mode="wait">
                <motion.div
                    key={activeTab}
                    variants={panelVariants}
                    initial="initial"
                    animate="animate"
                    exit="exit"
                    transition={transition}
                    className="absolute inset-0"
                >
                    <ActivePanel
                        selectedConversationId={selectedConversationId}
                        onSelectConversation={onSelectConversation}
                    />
                </motion.div>
            </AnimatePresence>

            <div className="absolute bottom-0 left-0 w-full bg-gray-800 border-t border-gray-700 p-2 flex justify-around text-sm text-gray-400">
                {Object.keys(panelMap).map((tab) => (
                    <button
                        key={tab}
                        className={`px-2 py-1 rounded hover:text-white transition-colors ${
                            activeTab === tab ? "text-green-500" : ""
                        }`}
                        onClick={() => onTabChange(tab as TabId)} // ✅ đúng callback
                    >
                        {tab}
                    </button>
                ))}
            </div>
        </aside>
    );
}
