import {
    format,
    isToday,
    isYesterday,
    parseISO,
    formatDistanceToNow,
} from "date-fns";
import { vi } from "date-fns/locale";

/**
 * Hiển thị thời gian dạng tương đối như: "2 giờ trước", "hôm qua", hoặc "dd/MM/yyyy lúc HH:mm"
 */
export function formatMessageTimestamp(date: string): string {
    const parsedDate = parseISO(date);

    if (isToday(parsedDate)) {
        // Hôm nay → hiển thị tương đối: "2 giờ trước", "vài phút trước"
        return formatDistanceToNow(parsedDate, { locale: vi, addSuffix: true });
    }

    if (isYesterday(parsedDate)) {
        return `Hôm qua lúc ${format(parsedDate, "HH:mm", { locale: vi })}`;
    }

    // Ngày khác → hiển thị rõ ràng
    return format(parsedDate, "dd/MM/yyyy 'lúc' HH:mm", { locale: vi });
}

export function isEdited(createdAt: string, updatedAt: string): boolean {
    return new Date(updatedAt).getTime() - new Date(createdAt).getTime() > 1000;
}
