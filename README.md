# OWASP Top 10 Laravel Training Application

Веб апликација во **Laravel** рамката која намерно содржи OWASP Top 10 ранливости за едукативни цели.

## Барања

- PHP 8.0+
- Composer
- SQLite

## Инсталација

```bash
# Инсталирај зависности
composer install

# Креирај .env
cp .env.example .env
php artisan key:generate

# Креирај база и seed
php artisan migrate --seed

# Стартувај сервер
php artisan serve
```

Отвори: http://localhost:8000

## Кредeнцијали

- **Admin**: `admin` / `admin123`
- **User**: `user` / `user123`

## OWASP Top 10 Ранливости

| ID | Ранливост | Laravel Заштита |
|----|-----------|-----------------|
| A01 | Broken Access Control | Middleware, Gates, Policies |
| A02 | Cryptographic Failures | Hash::make() (bcrypt) |
| A03 | Injection | Eloquent ORM, Query Builder |
| A04 | Insecure Design | RateLimiter, Str::random() |
| A05 | Security Misconfiguration | .env, APP_DEBUG=false |
| A06 | Vulnerable Components | composer audit |
| A07 | Auth Failures | Session regeneration |
| A08 | Data Integrity | Validation rules |
| A09 | Logging Failures | Log facade, Monolog |
| A10 | SSRF | URL validation, allowlists |

## Структура

```
app/Http/Controllers/Vulnerabilities/  - Контролери за секоја ранливост
resources/views/vulnerabilities/       - Views (vulnerable + secure)
docs/                                  - Документација
```

## Disclaimer

**Оваа апликација е НАМЕРНО РАНЛИВА** - само за едукативни цели!


<!-- Security scan triggered at 2026-08-31 17:26:23 -->

<!-- Security scan triggered at 2026-08-31 16:59:48 -->

<!-- Security scan triggered at 2026-09-02 06:55:35 -->