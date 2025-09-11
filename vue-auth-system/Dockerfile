# Use official Node.js alpine image
FROM node:20-alpine

# Set working directory inside container
WORKDIR /app

# Copy package files and install dependencies
COPY package*.json ./
RUN npm install
RUN npm install laravel-echo pusher-js
# Copy all files
COPY . .

# Expose Vite dev server port
EXPOSE 5173

# Start Vite dev server, accessible externally
CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0"]
