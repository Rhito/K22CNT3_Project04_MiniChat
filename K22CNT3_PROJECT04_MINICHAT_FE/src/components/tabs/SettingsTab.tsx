// 📁 components/sidebar/tabs/SettingsTab.tsx
export default function SettingsTab() {
    return (
        <div className="text-white text-[16px]">
            Cài đặt hệ thống...
            <div className="text-sm text-yellow-400">
                <button
                    className="bg-blue-500 hover:bg-yellow-600 text-white font-semibold py-1 px-3 rounded"
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
