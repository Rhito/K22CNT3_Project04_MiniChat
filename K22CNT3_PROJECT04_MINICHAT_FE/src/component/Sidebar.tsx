import { useEffect, useState } from "react";
import { deleteFriend, getFriendList } from "../Api/friendListApi";
import { getUser } from "../Api/userApi";
import { useNavigate } from "react-router-dom";
import conversationApi from "../Api/conversation";

type Props = {
  activeTab: string;
};

type Friend = {
  id: number;
  name: string;
  email: string;
  avatar: string;
};

type User = {
  id: number;
  name: string;
  email: string;
  avatar: string;
};

type Conversation = {
  id: number;
  type: string;
  participants: {
    id: number;
    name: string;
    avatar: string;
  }[];
  messages: {
    text?: string;
    content?: string;
  }[];
};

const FriendItem = ({ friend }: { friend: Friend }) => {
  const [menuOpen, setMenuOpen] = useState(false);

  const handleDelete = () => {
    if (window.confirm(`Are you sure you want to delete ${friend.name}?`)) {
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

export default function Sidebar({ activeTab }: Props) {
  const [friends, setFriends] = useState<Friend[]>([]);
  const [loading, setLoading] = useState(false);

  const [user, setUser] = useState<User | null>(null);
  const [userLoading, setUserLoading] = useState(false);

  const [conversations, setConversations] = useState<Conversation[]>([]);
  const [convLoading, setConvLoading] = useState(false);
  const [convError, setConvError] = useState("");

  const navigate = useNavigate();

  useEffect(() => {
    const token = localStorage.getItem("token");

    if (activeTab === "contacts") {
      setLoading(true);
      if (token) {
        getFriendList(token)
          .then((friends: Friend[]) => setFriends(friends))
          .catch(() => setFriends([]))
          .finally(() => setLoading(false));
      } else {
        setFriends([]);
        setLoading(false);
      }
    } else {
      setFriends([]);
    }

    if (activeTab === "profile") {
      setUserLoading(true);
      if (token) {
        getUser(token)
          .then((user: User) => {
            setUser(user);
            localStorage.setItem("user_id", user.id.toString());
          })
          .catch(() => setUser(null))
          .finally(() => setUserLoading(false));
      } else {
        setUser(null);
        setUserLoading(false);
      }
    } else {
      setUser(null);
    }

    if (activeTab === "chat" && token) {
      conversationApi(token, setConvError, setConvLoading).then((data) => {
        console.log(data.data);
        if (data && Array.isArray(data.data)) {
          setConversations(data.data);
        } else {
          setConversations([]);
        }
      });
    } else {
      setConversations([]);
    }
  }, [activeTab]);

  return (
    <div className="w-80">
      <div className="pt-4 px-4 pb-6 h-full overflow-y-auto bg-gray-900 text-gray-200 space-y-2 transition-none">
        {activeTab === "chat" && (
          <div>
            <h2 className="text-lg font-semibold text-white mb-4">
              Trò chuyện
            </h2>
            {convLoading && (
              <div className="text-gray-400 text-sm">
                Đang tải cuộc trò chuyện...
              </div>
            )}
            {convError && (
              <div className="text-red-400 text-sm">Lỗi: {convError}</div>
            )}

            {conversations.length === 0 ? (
              <div className="text-gray-400 text-sm">
                Không có cuộc trò chuyện.
              </div>
            ) : (
              <div className="space-y-3">
                {conversations.map((conv) => {
                  const myId = Number(localStorage.getItem("user_id"));
                  const other = conv.participants.find((p) => p.id !== myId);
                  if (!other) return null;

                  return (
                    <div
                      key={conv.id}
                      className="flex items-center gap-3 p-3 rounded-lg bg-gray-800 hover:bg-gray-700 cursor-pointer"
                    >
                      <img
                        src={other.avatar || "/default-avatar.png"}
                        alt={other.name || "User"}
                        className="w-12 h-12 rounded-full object-cover border border-gray-600"
                      />
                      <div className="flex-1 overflow-hidden">
                        <div className="text-white font-medium truncate">
                          {other.name || "Người dùng"}
                        </div>
                        <div className="text-gray-400 text-sm truncate">
                          {conv.messages?.[0]?.content ||
                            conv.messages?.[0]?.text ||
                            "Không có tin nhắn"}
                        </div>
                      </div>
                    </div>
                  );
                })}
              </div>
            )}
          </div>
        )}

        {activeTab === "contacts" && (
          <>
            <div className="flex items-center justify-between mb-4">
              <h2 className="text-lg font-semibold text-white">Bạn bè</h2>
              <button
                className="text-sm text-blue-500 hover:underline"
                onClick={() => navigate("/add-friend")}
              >
                Thêm bạn
              </button>
            </div>

            <div className="space-y-4">
              {loading ? (
                <div className="text-center text-gray-400 py-6 text-[16px]">
                  Đang tải danh sách bạn bè ...
                </div>
              ) : friends.length === 0 ? (
                <div className="text-center text-gray-400 py-6 text-[16px]">
                  Không tìm thấy bạn bè nào.
                </div>
              ) : (
                friends.map((friend, idx) => (
                  <FriendItem key={friend.id || idx} friend={friend} />
                ))
              )}
            </div>
          </>
        )}

        {activeTab === "profile" && (
          <div>
            <h2 className="text-lg font-semibold text-white mb-4">
              Trang cá nhân
            </h2>
            {userLoading ? (
              <div className="text-center text-gray-400 py-6 text-[16px]">
                Đang tải trang cá nhân ...
              </div>
            ) : user ? (
              <div className="flex flex-col items-center gap-4 p-6 rounded-xl bg-gray-800 shadow-md">
                <img
                  src={user.avatar}
                  alt={user.name}
                  className="w-[80px] h-[80px] rounded-full object-cover border-2 border-gray-600"
                />
                <div className="text-[18px] font-semibold text-white">
                  {user.name}
                </div>
                <div className="text-[13px] text-gray-400">{user.email}</div>
              </div>
            ) : (
              <div className="text-center text-gray-400 py-6 text-[16px]">
                Không tìm thấy trang cá nhân.
              </div>
            )}
          </div>
        )}

        {activeTab === "settings" && (
          <div className="text-white text-[16px]">Cài đặt hệ thống...</div>
        )}

        {activeTab === "groups" && (
          <div className="text-white text-[16px]">Quản lý nhóm...</div>
        )}

        {activeTab === "bookmarks" && (
          <div className="text-white text-[16px]">Tin nhắn đã lưu.</div>
        )}
      </div>
    </div>
  );
}
