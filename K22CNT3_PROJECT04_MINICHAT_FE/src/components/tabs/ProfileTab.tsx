import { useEffect, useState } from "react";
import { getUser } from "../../Api/userApi";
import { getUserInfo } from "../../Api/loginApi";

interface User {
    id: number;
    name: string;
    email: string;
    avatar: string;
}

const ProfileTab: React.FC = () => {
    const [user, setUser] = useState<User | null>(() => getUserInfo());
    const [loading, setLoading] = useState<boolean>(!user); // Nếu có sẵn user thì không loading

    useEffect(() => {
        const token = localStorage.getItem("authToken");
        if (!token) return;

        setLoading(true);

        getUser(token)
            .then((freshUser: User) => {
                setUser(freshUser);
                localStorage.setItem("userInfo", JSON.stringify(freshUser));
                localStorage.setItem("user_id", freshUser.id.toString());
            })
            .catch(() => {
                setUser(null);
                localStorage.removeItem("userInfo");
            })
            .finally(() => setLoading(false));
    }, []);

    return (
        <div>
            <h2 className="text-lg font-semibold text-white mb-4">
                Trang cá nhân
            </h2>

            {loading ? (
                <div className="text-center text-gray-400 py-6">
                    Đang tải...
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
                    <div className="text-[13px] text-gray-400">
                        {user.email}
                    </div>
                </div>
            ) : (
                <div className="text-center text-gray-400 py-6">
                    Không tìm thấy người dùng.
                </div>
            )}
        </div>
    );
};

export default ProfileTab;
