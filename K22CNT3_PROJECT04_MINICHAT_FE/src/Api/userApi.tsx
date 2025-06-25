import { instance } from "./api";

export const getUser = async (token: string) => {
  try {
    const response = await instance.get("/api/v1/user", {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
    console.log("user:", response.data);
    return response.data.data;
  } catch (error) {
    throw error;
  }
};
