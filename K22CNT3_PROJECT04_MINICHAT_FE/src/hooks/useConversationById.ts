import { useEffect, useState } from "react";
import type { Conversation } from "../types";
import { fetchConversations } from "../services/conversationService";

export function useConversationById(conversationId: number) {
    const [conversation, setConversation] = useState<Conversation | null>(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState<string | null>(null);

    useEffect(() => {
        const token = localStorage.getItem("authToken");
        if (!token || !conversationId) return;

        fetchConversations(token)
            .then((convs) =>
                setConversation(
                    convs.find((c) => c.id === conversationId) || null
                )
            )
            .catch((err) => setError(err.message))
            .finally(() => setLoading(false));
    }, [conversationId]);

    return { conversation, loading, error };
}
