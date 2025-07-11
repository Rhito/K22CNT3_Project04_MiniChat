export type FriendStatus = "accepted" | "pending" | "requested" | "blocked";

export interface FriendUser {
    id: number;
    name: string;
    email: string;
    avatar: string | null;
}

export interface Friendship {
    id: number;
    sender_id: number;
    receiver_id: number;
    status: FriendStatus;
    sender?: FriendUser;
    receiver?: FriendUser;
}
