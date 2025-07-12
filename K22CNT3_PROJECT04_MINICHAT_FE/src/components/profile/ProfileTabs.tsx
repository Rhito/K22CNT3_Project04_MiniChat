import React, { useEffect, useState } from "react";

interface Profile {
    id: string;
    name: string;
    email: string;
    avatarUrl?: string;
}

const ProfileTabs: React.FC = () => {
    const [profile, setProfile] = useState<Profile | null>(null);

    useEffect(() => {
        const userStr = localStorage.getItem("user");
        if (userStr) {
            try {
                const user = JSON.parse(userStr);
                setProfile(user);
            } catch {
                setProfile(null);
            }
        }
    }, []);

    if (!profile)
        return (
            <div className="text-center text-gray-500 mt-8">
                Không tìm thấy thông tin cá nhân.
            </div>
        );

    return (
        <>
            <div>
                <h1 className="text-lg font-semibold mb-4 text-gray-800 dark:text-white">
                    Thông tin cá nhân
                </h1>
            </div>
            <div className="w-full max-w-md mx-auto mt-10 p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg">
                <div className="flex flex-col items-center gap-4">
                    {profile.avatarUrl ? (
                        <img
                            src={profile.avatarUrl}
                            alt="Avatar"
                            className="w-24 h-24 rounded-full object-cover shadow"
                        />
                    ) : (
                        <div className="w-24 h-24 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500">
                            No Avatar
                        </div>
                    )}

                    <h2 className="text-2xl font-semibold text-gray-800 dark:text-white">
                        {profile.name}
                    </h2>
                    <p className="text-gray-600 dark:text-gray-300">
                        Email: {profile.email}
                    </p>
                </div>
            </div>
        </>
    );
};

export default ProfileTabs;
