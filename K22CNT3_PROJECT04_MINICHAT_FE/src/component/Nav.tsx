import {
  FiMessageSquare,
  FiUser,
  FiUsers,
  FiPhone,
  FiBookmark,
  FiSettings,
} from "react-icons/fi";
import { FaRegAddressBook } from "react-icons/fa"; // Contact icon

type Props = {
  active: string;
  onSelect: (tab: string) => void;
};

const menuItems = [
  { id: "chat", icon: <FiMessageSquare />, label: "Chat" },
  { id: "contacts", icon: <FaRegAddressBook />, label: "Contacts" },
  { id: "profile", icon: <FiUser />, label: "Profile" },
  { id: "groups", icon: <FiUsers />, label: "Groups" },
  { id: "calls", icon: <FiPhone />, label: "Calls" },
  { id: "bookmarks", icon: <FiBookmark />, label: "Bookmarks" },
  { id: "settings", icon: <FiSettings />, label: "Settings" },
];

export default function Nav({ active, onSelect }: Props) {
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
              <span className="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-green-500 rounded-r"></span>
            )}
          </button>
        ))}
      </div>

      <div className="flex flex-col items-center space-y-4">
        <img
          src="/avatar.jpg"
          className="w-8 h-8 rounded-full border-2 border-gray-600"
          alt="User"
        />
      </div>
    </div>
  );
}
