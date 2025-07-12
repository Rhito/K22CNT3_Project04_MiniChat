// src/components/layout/Nav.tsx

import {
    FiMessageSquare,
    FiUser,
    FiUsers,
    FiPhone,
    FiBookmark,
    FiSettings,
} from "react-icons/fi";
import { FaRegAddressBook } from "react-icons/fa";
import type { JSX } from "react";
import type { TabId } from "../../types";

// ✅ Sử dụng kiểu này trong props
type NavProps = {
    active: TabId;
    onSelect: (tab: TabId) => void;
};

const menuItems: { id: TabId; icon: JSX.Element; label: string }[] = [
    { id: "chat", icon: <FiMessageSquare />, label: "Chat" },
    { id: "profile", icon: <FiUser />, label: "Profile" },
    { id: "friends", icon: <FaRegAddressBook />, label: "Friends" },
    { id: "groups", icon: <FiUsers />, label: "Groups" },
    { id: "settings", icon: <FiSettings />, label: "Settings" },
];

export default function Nav({ active, onSelect }: NavProps) {
    return (
        <div className="w-14 bg-[#1f2937] text-gray-400 flex flex-col justify-between items-center py-4">
            <div className="flex flex-col space-y-6 items-center">
                {menuItems.map((item) => (
                    <button
                        key={item.id}
                        onClick={() => onSelect(item.id)}
                        className={`relative group w-10 h-10 flex items-center justify-center rounded-lg transition-colors duration-200
                            ${
                                active === item.id
                                    ? "text-green-500 bg-gray-700"
                                    : "hover:bg-gray-700"
                            }
                        `}
                        title={item.label}
                    >
                        {item.icon}
                        {active === item.id && (
                            <span className="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-green-500 rounded-r" />
                        )}
                    </button>
                ))}
            </div>

            <div className="flex flex-col items-center space-y-4">
                <img
                    src="/avatar.jpg"
                    className="w-8 h-8 rounded-full border-2 border-gray-600"
                    alt="User avatar"
                />
            </div>
        </div>
    );
}
