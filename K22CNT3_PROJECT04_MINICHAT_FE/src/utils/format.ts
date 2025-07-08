export function formatTime(date: string): string {
    return new Date(date).toLocaleTimeString("vi-VN", {
        hour: "2-digit",
        minute: "2-digit",
    });
}

export function formatDate(date: string): string {
    return new Date(date).toLocaleDateString("vi-VN");
}

export function isEdited(createdAt: string, updatedAt: string): boolean {
    return new Date(updatedAt).getTime() - new Date(createdAt).getTime() > 1000;
}

export function isSameDay(date1: string, date2: string): boolean {
    return new Date(date1).toDateString() === new Date(date2).toDateString();
}
