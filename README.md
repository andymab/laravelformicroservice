# 🧩 Auth Microservice (Laravel 12)

Микросервис для аутентификации и авторизации пользователей, реализованный на Laravel 12 с использованием API-ключей и токенов. Архитектура — Domain-Driven Design (DDD).

## 🚀 Стек технологий

- PHP 8.2
- Laravel 12
- Sanctum (токены)
- DDD структура
- Middleware (API key)
- MySQL / SQLite

## ⚙️ Установка

```bash
git clone https://your.repo/backend.git
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

📁 Структура проекта (DDD)
src/Domain/User — доменная логика пользователя

src/Application/User/LoginService.php — сервис входа

src/Http/Controllers/LoginController.php — контроллер

App\Http\Middleware\CheckApiKey.php — проверка X-API-KEY

🔐 Авторизация
Шаг 1: Логин
POST /api/login
```http
Headers:
  Content-Type: application/json
  X-API-KEY: supersecureapikey

Body:
{
  "email": "admin@example.com",
  "password": "password"
}
```

Ответ:
```json
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGci..."
}
```

Шаг 2: Защищённые запросы
Добавляй Authorization: Bearer <token> и X-API-KEY в заголовки всех защищённых запросов.

🧪 Проверка через curl
```bash
curl -X POST http://backendapi/api/login \
  -H "Content-Type: application/json" \
  -H "X-API-KEY: supersecureapikey" \
  -d '{"email":"admin@example.com","password":"password"}'
```

