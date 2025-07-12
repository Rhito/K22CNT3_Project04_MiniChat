// src/components/sidebar-panels/SettingsSidebar.tsx
export default function SettingsSidebar() {
    return (
        <div className="text-gray-400 p-4">
            Tùy chọn cài đặt sẽ hiển thị ở đây.
            <div>
                <button
                    className="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition"
                    onClick={() => {
                        localStorage.clear();
                        window.location.href = "/";
                    }}
                >
                    Đăng xuất
                </button>
            </div>
        </div>
    );
}
