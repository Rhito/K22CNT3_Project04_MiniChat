import axios from "axios";
import type { Message } from "../types";

export async function fetchMessages(
    conversationId: number,
    token: string
): Promise<Message[]> {
    const res = await axios.get(
        `${
            import.meta.env.VITE_API_BASE_URL
        }/api/v1/messages/${conversationId}`,
        { headers: { Authorization: `Bearer ${token}` } }
    );
    return res.data.data;
}

export async function sendTextMessage(
    conversationId: number,
    content: string,
    token: string
) {
    return axios.post(
        `${import.meta.env.VITE_API_BASE_URL}/api/v1/messages`,
        { conversation_id: conversationId, content, message_type: "text" },
        { headers: { Authorization: `Bearer ${token}` } }
    );
}

export async function uploadFile(
    conversationId: number,
    file: File,
    token: string
) {
    const formData = new FormData();
    formData.append("conversation_id", conversationId.toString());
    formData.append("files[]", file);
    return axios.post(
        `${import.meta.env.VITE_API_BASE_URL}/api/v1/messages/upload`,
        formData,
        {
            headers: {
                Authorization: `Bearer ${token}`,
                "Content-Type": "multipart/form-data",
            },
        }
    );
}

export async function hideMessageApi(id: number, token: string) {
    return axios.post(
        `${import.meta.env.VITE_API_BASE_URL}/api/v1/messages/${id}/hide`,
        {},
        { headers: { Authorization: `Bearer ${token}` } }
    );
}

export async function deleteMessageApi(id: number, token: string) {
    return axios.put(
        `${import.meta.env.VITE_API_BASE_URL}/api/v1/messages/${id}`,
        {},
        { headers: { Authorization: `Bearer ${token}` } }
    );
}

export async function editMessageApi(
    id: number,
    content: string,
    token: string
) {
    return axios.patch(
        `${import.meta.env.VITE_API_BASE_URL}/api/v1/messages/${id}`,
        { content },
        { headers: { Authorization: `Bearer ${token}` } }
    );
}
