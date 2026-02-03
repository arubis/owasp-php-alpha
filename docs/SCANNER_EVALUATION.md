# Евалуација на Security Скенери

## SAST (Static Application Security Testing)

### 1. PHPStan / Psalm
- **Тип**: Static Analysis
- **Цена**: Бесплатно (Open Source)
- **Команда**: `vendor/bin/phpstan analyse`
- **Детектира**: Type errors, undefined variables, dead code
- **Ефикасност за security**: ⭐⭐ (Ниска - не е фокусиран на security)

### 2. Snyk
- **Тип**: SAST + Dependency Scanning
- **Цена**: Free tier + Paid
- **Команда**: `snyk test`
- **Детектира**: SQL Injection, XSS, vulnerable dependencies
- **Ефикасност**: ⭐⭐⭐⭐ (Висока)

### 3. SonarQube
- **Тип**: SAST
- **Цена**: Community (free) + Enterprise
- **Детектира**: Security hotspots, code smells, SQL injection
- **Ефикасност**: ⭐⭐⭐⭐ (Висока)

### 4. Composer Audit
- **Тип**: Dependency Scanner
- **Цена**: Бесплатно (вграден во Composer)
- **Команда**: `composer audit`
- **Детектира**: Vulnerable packages
- **Ефикасност**: ⭐⭐⭐⭐⭐ (за dependencies)

## DAST (Dynamic Application Security Testing)

### 1. OWASP ZAP
- **Тип**: DAST
- **Цена**: Бесплатно (Open Source)
- **Детектира**: XSS, SQL Injection, CSRF, Headers
- **Ефикасност**: ⭐⭐⭐⭐⭐ (Одлична)

### 2. Burp Suite
- **Тип**: DAST + Manual Testing
- **Цена**: Community (free) + Pro ($449/год)
- **Детектира**: Сите OWASP Top 10
- **Ефикасност**: ⭐⭐⭐⭐⭐ (Индустриски стандард)

### 3. Nikto
- **Тип**: Web Scanner
- **Цена**: Бесплатно
- **Команда**: `nikto -h http://localhost:8000`
- **Детектира**: Misconfigurations, outdated software
- **Ефикасност**: ⭐⭐⭐ (Средна)

## Препораки

1. **За development**: PHPStan + Composer audit
2. **За CI/CD**: Snyk или SonarQube
3. **За penetration testing**: OWASP ZAP + Burp Suite

## Команди за скенирање

```bash
# Composer audit
composer audit

# PHPStan
composer require --dev phpstan/phpstan
vendor/bin/phpstan analyse app

# Snyk
npm install -g snyk
snyk test

# OWASP ZAP (Docker)
docker run -t owasp/zap2docker-stable zap-baseline.py -t http://localhost:8000
```
