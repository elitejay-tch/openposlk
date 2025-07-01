# 🇱🇰 OpenPOSLK

**OpenPOSLK** is a Laravel-based, fully open-source Point of Sale and inventory management system.

🎯 It is designed for two key purposes:

- 👨‍💻 **Developers**: Learn how to build real-world business systems from scratch, using clean architecture and Laravel best practices — no third-party UI packages or prebuilt admin panels.
- 🏪 **Small Businesses**: A free-to-use POS and stock system for Sri Lankan (and global) shops, usable without subscriptions, licenses, or proprietary software.

---

## ✨ Features (MVP)

- 🔐 User login with roles (Admin / Cashier)
- 📦 Product and category management
- 🛒 POS screen with cart and checkout
- 🧾 Printable invoices
- 📊 Basic sales reports
- 🗃️ Stock control

---

## 📦 Tech Stack

- Laravel (PHP Framework)
- Blade (Laravel templating)
- Tailwind CSS
- MySQL / SQLite
- Built 100% from scratch — no Filament/Nova/Backpack

---

## 🚀 Getting Started

```bash
git clone https://github.com/yourusername/openposlk.git
cd openposlk
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve
