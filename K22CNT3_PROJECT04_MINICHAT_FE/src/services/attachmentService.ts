// src/services/attachmentService.ts

import { getAttachmentTypeIcon } from "../utils/file";

export type FilePreview = {
    fileUrl: string;
    fileName: string;
    icon: string;
    isImage: boolean;
};

export function buildAttachmentInfo(
    filePath: string,
    fileName?: string,
    fileType?: string
): FilePreview {
    const fileUrl = `${import.meta.env.VITE_API_BASE_URL}/storage/${filePath}`;
    const name = fileName || filePath.split("/").pop() || "Không rõ tên";
    const icon = getAttachmentTypeIcon(fileType || filePath);
    const isImage = /\.(jpg|jpeg|png|gif|webp)$/i.test(filePath);

    return { fileUrl, fileName: name, icon, isImage };
}
