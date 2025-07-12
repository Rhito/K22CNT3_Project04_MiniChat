// src/components/conversations/ConversationList.tsx
import type { Conversation } from "../../types";
import ConversationItem from "./ConversationItem";

interface Props {
    myId: number;
    conversations: Conversation[];
    selectedId?: number | null;
    onSelect: (id: number) => void;
}

export default function ConversationList({
    conversations,
    myId,
    selectedId,
    onSelect,
}: Props) {
    return (
        <>
            <ul className="space-y-1">
                {conversations.map((conv) => (
                    <li key={conv.id}>
                        <ConversationItem
                            conversation={conv}
                            myId={myId}
                            isActive={conv.id === selectedId}
                            onSelect={onSelect}
                        />
                    </li>
                ))}
            </ul>
        </>
    );
}
