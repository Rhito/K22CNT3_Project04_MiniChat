import ChatTab from "./tabs/ChatTab";
import ContactsTab from "./tabs/ContactsTab";
import ProfileTab from "./tabs/ProfileTab";
import SettingsTab from "./tabs/SettingsTab";
import GroupsTab from "./tabs/GroupsTab";
import BookmarksTab from "./tabs/BookmarksTab";

interface SidebarProps {
    activeTab: string;
    onSelectConversation?: (id: number) => void;
}

export default function Sidebar({
    activeTab,
    onSelectConversation,
}: SidebarProps) {
    return (
        <div className="w-80">
            <div className="pt-4 px-4 pb-6 h-full overflow-y-auto bg-gray-900 text-gray-200 space-y-2">
                {activeTab === "chat" && (
                    <ChatTab onSelectConversation={onSelectConversation} />
                )}
                {activeTab === "contacts" && <ContactsTab />}
                {activeTab === "profile" && <ProfileTab />}
                {activeTab === "settings" && <SettingsTab />}
                {activeTab === "groups" && <GroupsTab />}
                {activeTab === "bookmarks" && <BookmarksTab />}
            </div>
        </div>
    );
}
