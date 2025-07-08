export function getUserInfo(): {
    id: number;
    name: string;
    avatar?: string;
} | null {
    try {
        return JSON.parse(localStorage.getItem("user") || "null");
    } catch {
        return null;
    }
}
