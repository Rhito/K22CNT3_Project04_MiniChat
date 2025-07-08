import Echo from "laravel-echo";
import Pusher from "pusher-js";

declare global {
    interface Window {
        Pusher: typeof Pusher;
    }
}

const authToken = localStorage.getItem("authToken");

window.Pusher = Pusher;

const echo = new Echo({
    broadcaster: "reverb",
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: Number(import.meta.env.VITE_REVERB_PORT),
    wssPort: Number(import.meta.env.VITE_REVERB_PORT),
    forceTLS: import.meta.env.VITE_REVERB_SCHEME === "https",
    encrypted: import.meta.env.VITE_REVERB_SCHEME === "https",
    disableStats: true,
    enabledTransports: ["ws", "wss"],
    authEndpoint: `${import.meta.env.VITE_API_BASE_URL}/api/broadcasting/auth`, // ✅ Laravel Reverb API
    auth: {
        headers: {
            Authorization: `Bearer ${authToken}`, // ✅ Bearer Token cho Sanctum
            Accept: "application/json",
        },
    },
});

export default echo;
