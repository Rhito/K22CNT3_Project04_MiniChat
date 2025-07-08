import { useState } from "react";
import * as messageApi from "../services/messageService";

export function useMessageActions() {
    const hideMessage = async (id: number) => {
        const token = localStorage.getItem("authToken");
        if (token) await messageApi.hideMessageApi(id, token);
    };

    const deleteMessage = async (id: number) => {
        const token = localStorage.getItem("authToken");
        if (token) await messageApi.deleteMessageApi(id, token);
    };

    return { hideMessage, deleteMessage };
}

export function useEditMessage() {
    const [loading, setLoading] = useState(false);

    const editMessage = async (id: number, content: string) => {
        const token = localStorage.getItem("authToken");
        if (!token) return;
        setLoading(true);
        await messageApi.editMessageApi(id, content, token);
        setLoading(false);
    };

    return { editMessage, loading };
}
