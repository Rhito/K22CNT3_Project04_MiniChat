# Use Node.js 20 Alpine for compatibility with react-router@7.6.0
FROM node:20-alpine

# Set working directory
WORKDIR /app

# Copy package.json and package-lock.json to leverage Docker cache
COPY frontend/package*.json ./

# Install dependencies
RUN npm install

# Copy the rest of the frontend code
COPY frontend/ .

# Expose port 5173 for Vite
EXPOSE 5173

# Start Vite development server
CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0", "--port", "5173"]