# 🚌 Real-Time Public Transport Tracking System - Jalandhar

A production-level Laravel application for tracking public transport in **Jalandhar, Punjab** with separate dashboards for Admins, Drivers, and Passengers.

---

## 🎯 Project Overview

This is a **100% Laravel-based web application** that enables:
- **Passengers** to track buses in real-time on a Jalandhar city map
- **Drivers** to manage trips
- **Admins** to monitor the entire transport network

---

## 🛠️ Tech Stack

- **Laravel 12** (Backend + Frontend)
- **SQLite** (Database)
- **Tailwind CSS** (Styling)
- **Leaflet.js + OpenStreetMap** (Interactive maps)
- **Laravel Authentication** (Role-based access control)

---

## 📁 Project Structure

```
Real-Time Transport Tracking System laravel project/
├── backend/                   # Complete Laravel application (all code here!)
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/  # Web & API controllers
│   │   │   └── Middleware/   # Role middleware
│   │   └── Models/            # Eloquent models (User, Bus, Route, etc.)
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   │   ├── migrations/        # Database migrations
│   │   └── seeders/           # Test data seeders
│   ├── public/
│   │   └── build/             # Compiled assets (CSS/JS)
│   ├── resources/
│   │   ├── views/             # Blade templates
│   │   │   ├── admin/
│   │   │   ├── auth/
│   │   │   ├── driver/
│   │   │   ├── layouts/
│   │   │   └── passenger/
│   │   ├── css/
│   │   └── js/
│   ├── routes/
│   ├── storage/
│   └── tests/
├── README.md
├── DATABASE_SCHEMA.md
└── GITHUB_SETUP.md
```

---

## 🚀 Getting Started

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & npm (for building assets)

### Installation

1. **Navigate to backend directory:**
   ```bash
   cd backend
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Set up environment file:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run migrations and seed test data:**
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Install and build frontend assets:**
   ```bash
   npm install
   npm run build
   ```

6. **Start the development server:**
   ```bash
   php artisan serve
   ```

Your application will now be running at: http://127.0.0.1:8000

---

## 🔐 Test Credentials

### Admin
- Email: `admin@smartcity.com`
- Password: `password`

### Driver
- Email: `rajesh@smartcity.com`
- Password: `password`

### Passenger
- Email: `priya@gmail.com`
- Password: `password`

---

## 📊 Features

### 🎫 Passenger Dashboard
- Interactive Jalandhar city map
- Live bus tracking with custom markers
- Route search (From → To)
- My Location toggle
- Nearby buses list

### 🚗 Driver Dashboard
- Trip management
- Live location sharing
- Trip statistics

### 👨‍💼 Admin Dashboard
- System analytics
- Manage buses, routes, and drivers
- Monitor entire network

---

## 🗺️ Map Features (Jalandhar City)
- Bus stops (Emerald Green markers)
- Railway stations (Red markers)
- LPU University (Purple marker)
- Major landmarks (Amber/Orange markers)
- Live bus locations (Cyan markers)

---

## 📝 Documentation
- `DATABASE_SCHEMA.md` - Complete database schema and relationships
- `GITHUB_SETUP.md` - Guide for publishing to GitHub

---

## 📄 License
Educational project - Free to use and modify

---

**Built with ❤️ for Jalandhar City**
