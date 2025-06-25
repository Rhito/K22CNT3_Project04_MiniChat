import { useEffect, useState } from "react";
import messengerApi from "../Api/messengerApi";

type Message = {
  sender: string;
  text: string;
};

export default function ChatBody() {
  const [messages, setMessages] = useState<Message[]>([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const token = localStorage.getItem("token");
    const fetchMessages = async () => {
      setLoading(true);
      try {
        const fetchedMessages = await messengerApi(
          1,
          token || "",
          (msg: string) => setError(msg),
          (loading: boolean) => setLoading(loading)
        );
        if (Array.isArray(fetchedMessages)) {
          setMessages(fetchedMessages);
        } else {
          setMessages([]);
        }
      } catch (error: unknown) {
        console.error("Error fetching messages:", error);
        setError("Something went wrong.");
      } finally {
        setLoading(false);
      }
    };

    fetchMessages();
  }, []);

  return (
    <div className="flex-1 overflow-y-auto p-4">
      {loading ? (
        <div className="text-gray-400 text-sm">Loading...</div>
      ) : error ? (
        <div className="text-red-500 text-sm">{error}</div>
      ) : (
        <ul>
          {messages.map((msg: Message, idx: number) => (
            <li key={idx} className="mb-2 text-white">
              {msg.text}
            </li>
          ))}
        </ul>
      )}
    </div>
  );
}
