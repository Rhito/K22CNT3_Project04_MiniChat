import { useState } from "react";

export default function MessageInput() {
  const [sendMessage, setSendMessage] = useState<string>("");

  return (
    <div className="p-4 border-t border-gray-700 flex items-center gap-2">
      <div className="relative w-full">
        <input
          type="text"
          placeholder="Type your message..."
          value={sendMessage}
          onChange={(e) => setSendMessage(e.target.value)}
          className="w-full p-2 pr-8 rounded bg-gray-700 text-white placeholder-gray-400"
        />
        {sendMessage && (
          <span
            role="img"
            aria-label="send"
            className="absolute right-2 top-1/2 transform -translate-y-1/2 text-white cursor-pointer"
            // Optionally, you can add onClick here to send the message
          >
            ➤
          </span>
        )}
      </div>
    </div>
  );
}
