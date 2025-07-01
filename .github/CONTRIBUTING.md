# 🤝 Contributing to OpenPOSLK

Thank you for considering contributing to **OpenPOSLK**!  
This project is built to help developers (especially Sri Lankans 🇱🇰) learn real-world system development — and help small businesses with a free POS system.

---

## ✅ Before You Start

Please make sure you have:

- Laravel (latest version) installed
- MySQL or SQLite running locally
- A GitHub account
- Basic understanding of PHP and Blade templates

---

## 🚀 Getting Started Locally

```bash
git clone https://github.com/YOUR_USERNAME/openposlk.git
cd openposlk
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

✅ Test that the app is running at: [http://localhost:8000](http://localhost:8000)

---

## 📄 Contribution Guidelines

### 1. Fork the Repository

Click **"Fork"** at the top right of the repo.

### 2. Clone Your Fork Locally

```bash
git clone https://github.com/YOUR_USERNAME/openposlk.git
```

### 3. Create a Feature Branch

```bash
git checkout -b feature/your-feature-name
```

### 4. Make Your Changes

- Use Laravel best practices.
- If you're modifying the database:
  - Clearly explain your changes in the PR.
  - Include proper `timestamps()` and `softDeletes()` in migrations.
  - Add a seeder if possible.

### 5. Commit and Push

```bash
git add .
git commit -m "Add: your feature summary"
git push origin feature/your-feature-name
```

### 6. Open a Pull Request

- Go to your fork on GitHub.
- Click **"Compare & Pull Request"**.
- Include:
  - Description of changes
  - Screenshots (if UI-related)
  - Related issue (if any)

---

## 🧱 Code Standards

- Follow Laravel naming conventions.
- Use Blade and Tailwind CSS (no Bootstrap or admin panels).
- Keep controllers thin. Use service classes when needed.
- Always test your code before opening a PR.
- Use `FormRequest` for form validation where appropriate.

---

## 🧪 Testing

We currently don’t require automated tests, but:

- Test your changes locally.
- Run `php artisan migrate:fresh --seed` to verify DB setup works.

---

## 🗂️ Labels to Watch

These help you find tasks that match your skill level:

- `good first issue` – Beginner-friendly tasks
- `help wanted` – Needs help from contributors
- `backend`, `frontend`, `database` – Type of task

---

## 💬 Need Help?

You can reach out via:

- GitHub Discussions: [https://github.com/YOUR_USERNAME/openposlk/discussions](https://github.com/YOUR_USERNAME/openposlk/discussions)
- Email: [info@elitejay.com](mailto:info@elitejay.com)

---

## 🙏 Thank You!

Whether you're fixing a typo or adding a new module —  
**you’re helping others learn and build better systems.**  
Let’s grow together 🚀
