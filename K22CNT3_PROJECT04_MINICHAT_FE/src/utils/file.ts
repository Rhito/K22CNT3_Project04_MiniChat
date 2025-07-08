// src/utils/file.ts

export function getAttachmentTypeIcon(fileType: string) {
    const lower = fileType.toLowerCase();
    if (lower.includes("image")) return "🖼️";
    if (lower.includes("pdf")) return "📄";
    if (lower.includes("video")) return "🎥";
    if (lower.includes("audio")) return "🎵";
    if (lower.includes("zip") || lower.includes("rar")) return "🗜️";
    if (lower.includes("excel") || lower.includes("spreadsheet")) return "📊";
    if (lower.includes("word")) return "📝";
    return "📎";
}
