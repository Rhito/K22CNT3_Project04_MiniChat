import axios from "axios";

const API = import.meta.env.VITE_API_BASE_URL;
const token = localStorage.getItem("authToken");

export async function fetchFriends() {
    const res = await axios.get(`${API}/api/v1/friends`, {
        headers: { Authorization: `Bearer ${token}` },
    });
    return res.data.data;
}

export async function sendFriendRequest(receiver_id: number) {
    return axios.post(
        `${API}/api/v1/friends/request`,
        { receiver_id },
        {
            headers: { Authorization: `Bearer ${token}` },
        }
    );
}

export async function acceptFriendRequest(request_id: number) {
    return axios.post(
        `${API}/api/v1/friends/accept`,
        { request_id },
        {
            headers: { Authorization: `Bearer ${token}` },
        }
    );
}

export async function rejectFriendRequest(request_id: number) {
    return axios.patch(
        `${API}/api/v1/friends/reject/${request_id}`,
        {},
        {
            headers: { Authorization: `Bearer ${token}` },
        }
    );
}
