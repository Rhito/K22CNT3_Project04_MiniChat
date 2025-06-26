// 📁 components/sidebar/tabs/ContactsTab.tsx
import { useEffect, useState } from "react";
import { getFriendList, deleteFriend } from "../../Api/friendListApi";
import { useNavigate } from "react-router-dom";

type Friend = {
    id: number;
    name: string;
    email: string;
    avatar: string;
};

type FriendItemProps = {
    friend: Friend;
};

const FriendItem: React.FC<FriendItemProps> = ({ friend }) => {
    const [menuOpen, setMenuOpen] = useState<boolean>(false);

    const handleDelete = () => {
        if (window.confirm(`Delete ${friend.name}?`)) {
            deleteFriend(localStorage.getItem("token") || "", friend.id);
        }
        setMenuOpen(false);
    };

    return (
        <div className="relative flex items-center gap-4 px-4 py-3 bg-gray-800 hover:bg-gray-700 cursor-pointer shadow-md w-full h-[80px] rounded-md">
            <img
                src={friend.avatar}
                alt={friend.name}
                className="w-[56px] h-[56px] rounded-full object-cover border-2 border-gray-600"
            />
            <div className="overflow-hidden flex-1">
                <div className="text-white font-semibold text-[16px] truncate w-[200px]">
                    {friend.name}
                </div>
                <div className="text-gray-400 text-[12px] truncate w-[200px]">
                    {friend.email}
                </div>
            </div>
            <div className="relative">
                <button
                    onClick={(e) => {
                        e.stopPropagation();
                        setMenuOpen(!menuOpen);
                    }}
                    className="text-white text-xl px-2 py-1 hover:bg-gray-700 rounded-md"
                >
                    ...
                </button>
                {menuOpen && (
                    <div className="absolute right-0 mt-2 w-[120px] bg-gray-800 border border-gray-700 rounded-md shadow-lg z-20">
                        <button
                            onClick={handleDelete}
                            className="w-full text-left px-4 py-2 text-sm text-white hover:bg-gray-700"
                        >
                            Delete
                        </button>
                    </div>
                )}
            </div>
        </div>
    );
};

const ContactsTab: React.FC = () => {
    const [friends, setFriends] = useState<Friend[]>([]);
    const [loading, setLoading] = useState<boolean>(false);
    const navigate = useNavigate();

    useEffect(() => {
        const token = localStorage.getItem("token");
        if (token) {
            setLoading(true);
            getFriendList(token)
                .then((res: Friend[]) => setFriends(res))
                .finally(() => setLoading(false));
        }
    }, []);

    return (
        <div>
            <div className="flex items-center justify-between mb-4">
                <h2 className="text-lg font-semibold text-white">Bạn bè</h2>
                <button
                    className="text-sm text-blue-500 hover:underline"
                    onClick={() => navigate("/add-friend")}
                >
                    Thêm bạn
                </button>
            </div>
            {loading ? (
                <div className="text-center text-gray-400 py-6">
                    Loading friends...
                </div>
            ) : friends.length === 0 ? (
                <div className="text-center text-gray-400 py-6">
                    No friends found.
                </div>
            ) : (
                <div className="space-y-3">
                    {friends.map((friend) => (
                        <FriendItem key={friend.id} friend={friend} />
                    ))}
                </div>
            )}
        </div>
    );
};

export default ContactsTab;
