
# 📌 Portfolio CQRS Clean Architecture

A **full-stack portfolio application** built with **Laravel (CQRS architecture)**, **Vue 3 (Vite)**, and **Docker**.
This project demonstrates **scalable clean architecture** with **CQRS, Event Sourcing, and Real-time UI updates** — ideal for enterprise-level applications.

---

## 🚀 Features

* **CQRS Pattern** – Separation of Write (MySQL) and Read (MongoDB) models.
* **Event-driven Architecture** – RabbitMQ for event publishing and consumption.
* **Real-time UI** – Vue frontend updates instantly via Laravel Echo.
* **Clean Code & DRY** – Domain-driven structure with clear separation of concerns.
* **Dockerized Setup** – One command to spin up Laravel, Vue, MySQL, MongoDB, RabbitMQ, and phpMyAdmin.
* **Authentication** – JWT-based auth with login, register, and profile management.
* **Portfolio Module** – Manage projects with CRUD, statuses, and featured items.

---

## 🛠️ Tech Stack

* **Backend:** Laravel 10 (PHP-FPM)
* **Frontend:** Vue 3 + Vite
* **Database (Write):** MySQL 8
* **Database (Read):** MongoDB 6
* **Message Broker:** RabbitMQ 3 (with management UI)
* **Queue Worker:** Laravel Queue Worker (domain-events, default)
* **Proxy:** Nginx (reverse proxy for Laravel API + GraphQL)
* **Admin Tool:** phpMyAdmin

---

## 📂 Architecture Overview

```
vue-testing-project/
│
├── auth-system/ # Laravel backend (CQRS + API + Events)
│ ├── app/ # Domain, Application, Infrastructure code
│ ├── config/ # Laravel configuration
│ ├── graphql/ # GraphQL schemas
│ ├── routes/ # API + GraphQL routes
│ └── .env # Backend environment variables
│
├── vue-auth-system/ # Vue 3 frontend (Vite + Tailwind + Auth)
│ ├── src/ # Components, pages, stores
│ ├── tests/ # Unit tests
│ └── .env # Frontend environment variables
│
├── nginx/ # Nginx reverse proxy config
│ └── default.conf
│
├── docker-compose.yml # Main Docker configuration
└── README.md # Project documentation
```

✅ Ensures **eventual consistency**, **real-time UI updates**, and **CQRS separation**.

---

## 🐳 Docker Setup

### 1. Clone the repositories

```bash
git clone https://github.com/kayzinkhaing/portfolio-cqrs-clean-architecture.git
cd portfolio-cqrs-clean-architecture
```

### 2. Environment variables

Copy `.env.example` files for both **backend** and **frontend**:

```bash
cp auth-system/.env.example auth-system/.env
cp vue-auth-system/.env.example vue-auth-system/.env
```

### 3. Start the stack

```bash
docker compose up --build -d
```

### 4. Services exposed

| Service      | URL                                              | Notes                   |
| ------------ | ------------------------------------------------ | ----------------------- |
| Laravel API  | [http://localhost:8000](http://localhost:8000)   | Backend + GraphQL       |
| Vue Frontend | [http://localhost:5173](http://localhost:5173)   | Vite dev server         |
| phpMyAdmin   | [http://localhost:8081](http://localhost:8081)   | Manage MySQL            |
| RabbitMQ UI  | [http://localhost:15672](http://localhost:15672) | Guest / Guest (default) |
| MongoDB      | localhost:27017                                  | Read model storage      |
| MySQL        | localhost:3307                                   | Write model storage     |

---

## 🔄 Flow Summary

1. **MySQL (Write)** → Data written via CRUD service.
2. **Event Raised** → `ModelChanged` event dispatched.
3. **RabbitMQ** → Listener publishes event into message broker.
4. **Worker Job** → Consumes event, syncs into **MongoDB (Read)**.
5. **Broadcast** → Job fires `ModelChangedBroadcast` → via Echo.
6. **Vue Frontend** → Reacts in **real-time**, updating UI instantly.

✅ Includes retries & error handling:

* Laravel Worker: automatic retries with RabbitMQ.
* Vue Frontend: API retries on network failures.

---

## 📖 Project Modules

* **Portfolio**: CRUD for projects (title, description, status, dates, featured flag).
* **Auth**: Register, login, logout, JWT-based authentication.
* **Real-time UI**: Project changes reflected instantly across sessions.

---

## 🏗️ Clean Code Practices

* **CQRS** – Commands for write operations, Queries for read operations.
* **SOLID Principles** – Single-responsibility services, dependency injection.
* **DRY** – Shared logic extracted into reusable services.
* **Event-driven** – RabbitMQ ensures decoupling and scalability.
* **Testing** – Unit & integration tests for core modules.

---

## 🚀 Quick Demo Commands

### Run migrations

```bash
docker exec -it laravel php artisan migrate:fresh --seed
```

### Run queue worker (already running in container)

```bash
docker logs -f laravel-worker
```

### Access Tinker

```bash
docker exec -it laravel-backend php artisan tinker
```

---

## 🤝 Contributing

1. Fork this repo.
2. Create a new feature branch.
3. Submit a PR.


