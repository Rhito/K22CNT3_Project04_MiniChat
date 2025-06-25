import axios from "axios";

export const instance = axios.create({
  baseURL: "https://k22cnt3_project04_minichat.test",
  withCredentials: true,
  timeout: 3000,
  headers: { "X-Custom-Header": "foobar" },
});
