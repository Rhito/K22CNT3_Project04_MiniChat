import { useEffect, useState } from "react";
import { getFriendList, deleteFriend } from "../../Api/friendListApi";
import FriendSearchForm from "../SearchFriend";
import { MoreVertical } from "lucide-react";
import { useNavigate } from "react-router-dom";
import { getOrCreateConversation } from "../../Api/conversationApi";

type Friend = {
    id: number;
    name: string;
    email: string;
    avatar: string;
};

type FriendItemProps = {
    friend: Friend;
    onDeleteSuccess: (id: number) => void;
    onOpenConversation: (friend: Friend) => void;
};

const FriendItem: React.FC<FriendItemProps> = ({
    friend,
    onDeleteSuccess,
    onOpenConversation,
}) => {
    const [menuOpen, setMenuOpen] = useState(false);

    const handleDelete = async () => {
        const token = localStorage.getItem("authToken") || "";
        if (window.confirm(`Bạn có chắc muốn xóa ${friend.name}?`)) {
            try {
                await deleteFriend(token, friend.id);
                onDeleteSuccess(friend.id);
            } catch {
                alert("Xóa bạn thất bại.");
            }
        }
        setMenuOpen(false);
    };

    return (
        <div
            onClick={() => onOpenConversation(friend)}
            className="relative flex items-center gap-4 px-4 py-3 bg-gray-800 hover:bg-gray-700 cursor-pointer shadow-md w-full h-[80px] rounded-md"
        >
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
                    <MoreVertical size={20} />
                </button>
                {menuOpen && (
                    <div className="absolute right-0 mt-2 w-[120px] bg-gray-800 border border-gray-700 rounded-md shadow-lg z-20">
                        <button
                            onClick={handleDelete}
                            className="w-full text-left px-4 py-2 text-sm text-white hover:bg-gray-700"
                        >
                            Xóa bạn
                        </button>
                    </div>
                )}
            </div>
        </div>
    );
};

const ContactsTab: React.FC = () => {
    const [friends, setFriends] = useState<Friend[]>([]);
    const [loading, setLoading] = useState(false);
    const [showSearch, setShowSearch] = useState(false);
    const navigate = useNavigate();

    useEffect(() => {
        const token = localStorage.getItem("authToken");
        if (token) {
            setLoading(true);
            getFriendList(token)
                .then((res) => setFriends(res))
                .catch(() => alert("Không thể tải danh sách bạn bè"))
                .finally(() => setLoading(false));
        }
    }, []);

    const handleDeleteSuccess = (id: number) => {
        setFriends((prev) => prev.filter((friend) => friend.id !== id));
    };

    const handleOpenConversation = async (friend: Friend) => {
        const token = localStorage.getItem("authToken");
        if (!token) return;

        try {
            const conversationId = await getOrCreateConversation(
                token,
                friend.id
            );
            localStorage.setItem("currentOtherId", friend.id.toString());
        } catch (err) {
            alert("Không thể mở cuộc hội thoại.");
        }
    };

    return (
        <div>
            <div className="flex items-center justify-between mb-4">
                <h2 className="text-lg font-semibold text-white">Bạn bè</h2>
                <button
                    className="text-sm text-blue-500 hover:underline"
                    onClick={() => setShowSearch((prev) => !prev)}
                >
                    {showSearch ? "Đóng tìm kiếm" : "Thêm bạn"}
                </button>
            </div>

            {showSearch && (
                <div className="mb-4">
                    <FriendSearchForm />
                </div>
            )}

            {loading ? (
                <div className="text-center text-gray-400 py-6">
                    Đang tải danh sách bạn bè...
                </div>
            ) : friends.length === 0 ? (
                <div className="text-center text-gray-400 py-6">
                    Không có bạn bè nào.
                </div>
            ) : (
                <div className="space-y-3">
                    {friends.map((friend) => (
                        <FriendItem
                            key={friend.id}
                            friend={friend}
                            onDeleteSuccess={handleDeleteSuccess}
                            onOpenConversation={handleOpenConversation}
                        />
                    ))}
                </div>
            )}
        </div>
    );
};

export default ContactsTab;
