// src/components/shared/UniversalSearchBar.tsx
import { useState } from "react";

export default function UniversalSearchBar() {
    const [query, setQuery] = useState("");

    const handleSearch = (e: React.FormEvent) => {
        e.preventDefault();
        console.log("Searching for:", query);
        // TODO: Implement search logic
    };

    return (
        <form onSubmit={handleSearch} className="p-2">
            <input
                type="text"
                value={query}
                onChange={(e) => setQuery(e.target.value)}
                placeholder="Tìm kiếm..."
                className="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500"
            />
        </form>
    );
}
