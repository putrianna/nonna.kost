# 🏠 Nonna Kost – Room Rental Management System

A web-based information system to manage room rentals at **Nonna Kost**, supporting **daily, weekly, and monthly** stays with flexible pricing based on room type.

Built to reduce spreadsheet chaos, human error, and “eh ini kamarnya kosong atau enggak sih?” moments.

---

## ✨ Features

* 🛏️ **Room & Room Type Management**
  Manage physical rooms and categorize them by type (Standard, Deluxe, AC, etc.).

* 💰 **Flexible Pricing System**

  * Daily, weekly, and monthly rates
  * Pricing defined per room type
  * Supports mixed pricing (e.g. weekly + remaining days daily)

* 📅 **Rental & Occupancy Tracking**

  * Track check-in and check-out dates
  * Prevent double booking
  * Clear rental status lifecycle (booked, active, completed)

* 🧾 **Detailed Billing Breakdown**

  * One rental, multiple charge segments
  * Transparent pricing (e.g. “1 week + 3 days”)
  * Ready for invoices and receipts

* 👤 **Tenant Management**
  Store tenant information for tracking stays and payments.

* 💵 **Payment Records**
  Track payments by method, amount, and date.

---

## 🧠 Design Principles

* **Single source of truth for occupancy**
  One rental = one stay, even if pricing is split.

* **Pricing snapshots for historical accuracy**
  Rate changes won’t affect past rentals.

* **Scalable schema**
  Ready for future features like discounts, add-ons, penalties, and reports.

---

## 🛠️ Tech Stack

* **Backend**: Laravel
* **Frontend**: Vue.js
* **Routing & Rendering**: Inertia.js
* **Asset Bundling**: Vite
* **Database**: MySQL / MariaDB
* **Testing**: Pest

---

## 🗄️ Core Database Entities

* `room_types` – Room categories and characteristics
* `rooms` – Physical rooms
* `rate_plans` – Daily / weekly / monthly pricing per room type
* `tenants` – Renters
* `rentals` – Rental contracts / occupancies
* `rental_charges` – Detailed billing segments
* `payments` – Payment records

---

## 🚀 Getting Started

```bash
git clone https://github.com/your-username/nonna-kost.git
cd nonna-kost

composer install
npm install
cp .env.example .env
php artisan key:generate

php artisan migrate
npm run dev
php artisan serve
```

---

## 🧪 Running Tests

```bash
php artisan test
# or
./vendor/bin/pest
```

---

## 📌 Project Status

🛠️ Actively developed
Features and structure may evolve as real-world kost problems reveal themselves (they always do).

---
