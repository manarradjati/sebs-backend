# Smart Event Booking System (Bkevent)

## 📌 Project Overview

The **Smart Event Booking System (Bkevent)** is a full-stack web application built with **Laravel (PHP)** and **Vue.js** that allows users to browse, book, manage, and review various events such as concerts, conferences, and workshops. The system provides role-based features for **Admins**, **Organizers**, and **Regular Users**, supporting event creation, booking management, secure authentication, media uploads, and notification handling.

---

## 🎯 Objectives

- Develop a RESTful API with Laravel.
- Implement JWT-based authentication and role-based authorization.
- Use MySQL for relational data (users, bookings, etc.).
- Use MongoDB for flexible data (reviews, logs, analytics).
- Support file uploads (event images, ticket PDFs).
- Enable email notifications for user actions.
- Design clean and maintainable codebase (MVC, services, repositories).
- Validate input, manage errors, and use middlewares effectively.

---

## 🛠️ Tech Stack

| Layer          | Technology                          |
|----------------|--------------------------------------|
| Frontend       | Vue.js 3, Vue Router, Axios          |
| Backend        | Laravel 10.x, Laravel Sanctum/JWT    |
| Relational DB  | MySQL                                |
| NoSQL DB       | MongoDB + Laravel MongoDB extension  |
| Auth           | JWT / Laravel Sanctum                |
| File Uploads   | Laravel File Storage, Intervention Image |
| Notifications  | Laravel Notifications (Mail)         |
| Ticket PDFs    | DomPDF / Snappy                      |
| API Docs       | Swagger (via Laravel OpenAPI tools)  |
| Tools          | Postman, Composer, npm, Git          |

---

## 🔐 Key Modules

### 1. User Module
- User Registration & Login (JWT-based)
- Profile view and update
- Role-based access (Admin, Organizer, User)

### 2. Event Management
- Organizers can create, update, delete events
- Categorization and tagging
- Image upload support
- Status tracking (Upcoming, Ongoing, Completed)

### 3. Booking System
- Book or cancel event tickets
- Download ticket as PDF
- Receive email confirmation for bookings

### 4. Review & Rating
- Post-event user reviews
- 1–5 star rating system
- Aggregated event rating via MongoDB

### 5. Admin Dashboard APIs
- Manage users (ban/unban, promote)
- Approve/reject organizer events
- View site-wide statistics

### 6. Notifications
- Email notifications for:
  - Registration
  - Booking/cancellation
  - Event updates

---

## 🧰 Installation & Setup

### Prerequisites

- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL
- MongoDB

### Backend (Laravel)

```bash
git clone https://github.com/manarradjati/sebs-backend.git
cd sebs-backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed   # Optional: Seed initial data
php artisan serve
```

### Frontend (Vue.js)

```bash
cd frontend
npm install
npm run dev
```

---

## 🔗 API Documentation

- Swagger UI: `http://localhost:8000/api/documentation`
- Postman Collection: [Download Here](#)

---

## 📂 Project Structure (Backend)

```
app/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
├── Models/
├── Services/
├── Repositories/
routes/
├── api.php
database/
├── migrations/
├── seeders/
```

---

## ⚙️ Environment Configuration

Edit `.env` with appropriate database settings:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sebs
DB_USERNAME=root
DB_PASSWORD=

MONGO_DB_HOST=127.0.0.1
MONGO_DB_PORT=27017
MONGO_DB_DATABASE=sebs_mongo
```

---

## ✅ Features Under Development

- Real-time notifications using Pusher or WebSockets
- Event calendar integration
- Payment gateway (e.g., Stripe, PayPal)

---

## 🧪 Testing

- PHPUnit for backend testing
- Vue Test Utils for frontend
- Run all backend tests:  
  ```bash
  php artisan test
  ```

---

## 👨‍💻 Authors & Contributors

- **Backend**: [manarradjati](https://github.com/manarradjati)
- **Frontend**: [manarradjati](https://github.com/manarradjati)
- **Database Design**: [manarradjati](https://github.com/manarradjati)

---

## 📄 License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).