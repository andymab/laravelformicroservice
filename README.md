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
Используется Laravel Sanctum для access_token.

refresh_token генерируется вручную и хранится в базе данных (в поле users.refresh_token).
 Проверка токенов
/api/login: доступен через middleware apikey.

Требует заголовок X-API-KEY.

/api/refresh и /api/user: доступны только с auth:sanctum.

Используют access_token, полученный после логина.

Роутинг (routes/api.php)
```php
Route::middleware(['apikey'])->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/refresh', [LoginController::class, 'refresh']);
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });
});

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

