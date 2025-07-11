import { instance } from "./api";

export const getFriendList = async (token: string) => {
    try {
        const response = await instance.get("/api/v1/friends", {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });
        console.log("Friend list response:", response.data);
        return response.data.data;
    } catch (error) {
        throw error;
    }
};
export const deleteFriend = async (token: string, friendId: number) => {
    try {
        const response = await instance.delete(`/api/v1/friends/${friendId}`, {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });
        console.log("Delete friend response:", response.data);
        return response.data;
    } catch (error) {
        throw error;
    }
};

export const searchFriend = async (token: string, email: string) => {
    try {
        const response = await instance.post(
            `/api/v1/friends/search`,
            { query: email },

            {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: "application/json",
                    ContentType: "application/json",
                },
            }
        );

        console.log("Add friend response:", response.data);
        return response.data;
    } catch (error) {
        throw error;
    }
};
export const addFriend = async (token: string, receiver_id: number) => {
    try {
        const response = await instance.post(
            `/api/v1/friends/request`,
            { receiver_id },
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }
        );

        console.log("Add friend response:", response.data);
        return response.data;
    } catch (error) {
        throw error;
    }
};
export const getFriendRequests = async (token: string) => {
    try {
        const response = await instance.get("/api/v1/friends/requests", {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });
        console.log("Friend requests response:", response.data);
        return response.data.data;
    } catch (error) {
        throw error;
    }
};
export const acceptFriendRequest = async (token: string, sender_id: number) => {
    try {
        const response = await instance.post(
            `/api/v1/friends/accept`,
            { sender_id },
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }
        );
        console.log("Accept friend request response:", response.data);
        return response.data;
    } catch (error) {
        throw error;
    }
};
export const declineFriendRequest = async (
    token: string,
    receiver_id: number
) => {
    try {
        const response = await instance.delete(
            `/api/v1/friends/reject/${receiver_id}`,
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }
        );
        console.log("Decline friend request response:", response.data);
        return response.data;
    } catch (error) {
        throw error;
    }
};
