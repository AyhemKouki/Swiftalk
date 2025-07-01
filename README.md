# Laravel Application

A modern web application built with Laravel 12.19.3, featuring real-time communication, modern UI, and comprehensive functionality.

## ✨ Features

### 🔐 Authentication & Security
- Complete user registration and login system
- User profile management
- Enhanced security with Laravel Breeze
- Session management and password reset

### 💬 Real-Time Communication
- Live chat with Laravel Echo and Reverb
- Instant notifications
- Peer-to-peer communication with PeerJS
- WebSocket connections for real-time updates

### 🎨 Modern User Interface
- Bootstrap integration for UI components
- Mobile-first approach

## 🚀 Quick Installation
1. **Clone the repository**
   ```bash
   git clone https://github.com/AyhemKouki/LMS.git
   cd LMS
   ```

2. **Install the PHP dependencies**
   ```bash
   composer install
   ```

3. **Install the JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Environment configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database configuration**
   - Create the SQLite database file:
   ```bash
   touch database/database.sqlite
   ```
   
   - Configure the file `.env` :
   ```env
   DB_CONNECTION=sqlite
   DB_DATABASE=/chemin/absolu/vers/database/database.sqlite
   QUEUE_CONNECTION=database
   ```

6. **Execute the migrations**
   ```bash
   php artisan migrate
   ```

7. **Compile the assets**
   ```bash
   npm run build
   ```

   ## 🚀 Use

### Development

1. **Start the development server**
   ```bash
   php artisan serve
   ```

2. **Compile the assets in development mode**
   ```bash
   npm run dev
   ```

3. **Start the queue worker**
   ```bash
   php artisan queue:work
   ```
4. **Start Laravel Reverb (WebSocket server)**
   ```bash
   php artisan reverb:start
   ```
5. **Start PeerJS server (for peer-to-peer communication)**
   ```bash
   npx peerjs --port 9000
   ```


