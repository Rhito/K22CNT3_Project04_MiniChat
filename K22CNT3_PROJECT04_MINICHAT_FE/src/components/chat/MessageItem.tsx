import MessageActions from "./MessageActions";
import { getUserInfo } from "../../services/authService";
import { formatMessageTimestamp, isEdited } from "../../utils/time";
import type { Message } from "../../types";
import { buildAttachmentInfo } from "../../services/attachmentService";

export default function MessageItem({ message }: { message: Message }) {
    const myId = getUserInfo()?.id;
    const isMe = message.sender_id === myId;

    const avatar = message.sender?.avatar
        ? `${import.meta.env.VITE_API_BASE_URL}/storage/${
              message.sender.avatar
          }`
        : "/default-avatar.png";

    const attachments = message.attachments || [];
    const onlyImage =
        !message.content &&
        attachments.length === 1 &&
        /\.(jpg|jpeg|png|gif|webp)$/i.test(attachments[0].file_path);

    return (
        <div
            className={`group flex items-end gap-3 ${
                isMe ? "justify-end" : "justify-start"
            }`}
        >
            {!isMe && (
                <img
                    src={avatar}
                    className="w-9 h-9 rounded-full border border-gray-600"
                />
            )}

            <div
                className={`relative px-4 py-3 max-w-xs md:max-w-sm space-y-2 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 ease-in-out ${
                    isMe
                        ? "bg-gradient-to-br from-blue-500 to-purple-600 text-white rounded-br-none"
                        : "bg-gradient-to-br from-gray-700 to-gray-800 text-white rounded-bl-none"
                }`}
            >
                {/* Nội dung tin nhắn */}
                <div className="text-sm whitespace-pre-wrap">
                    {message.is_deleted ? (
                        <i className="text-gray-300">Tin nhắn đã bị xoá</i>
                    ) : (
                        <>
                            {message.content && (
                                <div className="mb-1">{message.content}</div>
                            )}

                            {/* File đính kèm */}
                            {attachments.map((file) => {
                                const { fileUrl, fileName, icon, isImage } =
                                    buildAttachmentInfo(
                                        file.file_path,
                                        file.file_name,
                                        file.file_type
                                    );

                                return isImage ? (
                                    <img
                                        key={file.id}
                                        src={fileUrl}
                                        alt={fileName}
                                        className={`rounded border border-gray-700 mt-2 ${
                                            onlyImage
                                                ? "w-full max-h-96 object-cover"
                                                : "max-h-60"
                                        }`}
                                    />
                                ) : (
                                    <a
                                        key={file.id}
                                        href={fileUrl}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="flex items-center gap-2 mt-2 p-2 bg-gray-700 hover:bg-gray-600 rounded text-sm"
                                    >
                                        <span>{icon}</span>
                                        <span className="truncate">
                                            {fileName}
                                        </span>
                                    </a>
                                );
                            })}
                        </>
                    )}
                </div>

                {/* Thời gian gửi */}
                <div className="flex justify-end text-xs text-gray-300">
                    {formatMessageTimestamp(message.created_at)}
                    {isEdited(message.created_at, message.updated_at) && (
                        <span className="ml-1 italic">(Đã chỉnh sửa)</span>
                    )}
                </div>

                {/* Nút hành động (chỉnh sửa / xoá) */}
                {isMe && !message.is_deleted && (
                    <div className="absolute bottom-1 -left-6 hidden group-hover:block">
                        <MessageActions message={message} />
                    </div>
                )}
            </div>

            {isMe && (
                <img
                    src={avatar}
                    className="w-9 h-9 rounded-full border border-gray-600"
                />
            )}
        </div>
    );
}
