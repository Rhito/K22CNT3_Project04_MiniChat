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
