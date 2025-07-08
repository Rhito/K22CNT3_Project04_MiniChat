import axios from "axios";
import type { Conversation } from "../types";

export async function fetchConversations(
    token: string
): Promise<Conversation[]> {
    const res = await axios.get(
        `${import.meta.env.VITE_API_BASE_URL}/api/v1/conversations`,
        {
            headers: { Authorization: `Bearer ${token}` },
        }
    );
    return res.data.data.data;
}
