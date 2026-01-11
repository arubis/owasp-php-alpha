# OWASP Top 10 PHP Training Application

An intentionally vulnerable PHP web application demonstrating the OWASP Top 10 security risks (2021), built for educational and ethical hacking purposes. Each vulnerability includes both a **vulnerable implementation** and a **secure (fixed) implementation**.

## ⚠️ IMPORTANT DISCLAIMER

**This application is intentionally vulnerable for educational purposes only.** It should:
- Only be used in a controlled learning environment
- Never be deployed to production
- Never be exposed to the internet
- Only be used for educational and ethical hacking training

## Requirements

- PHP 8.0 or higher
- SQLite (included with PHP)
- Web server (PHP built-in server is sufficient)

## Installation on Windows

### Option 1: Install PHP via Windows PHP Installer (Recommended)

1. **Download PHP for Windows:**
   - Visit: https://windows.php.net/download/
   - Download the latest PHP 8.x "Thread Safe" ZIP file
   - Extract to `C:\php`

2. **Add PHP to PATH:**
   - Open System Properties → Environment Variables
   - Edit the "Path" variable under System variables
   - Add: `C:\php`
   - Click OK to save

3. **Verify Installation:**
   ```powershell
   php -v
   ```

### Option 2: Install via XAMPP

1. **Download XAMPP:**
   - Visit: https://www.apachefriends.org/
   - Download and install XAMPP
   - PHP will be located at: `C:\xampp\php\php.exe`

2. **Add to PATH (or use full path):**
   ```powershell
   # Add to PATH, or use full path:
   C:\xampp\php\php.exe db/init.php
   ```

### Option 3: Install via Chocolatey (if you have Chocolatey)

```powershell
choco install php
```

## Setup Instructions

### Step 1: Initialize the Database

Open PowerShell in the project directory and run:

```powershell
php db/init.php
```

This will create the SQLite database at `db/app.sqlite` with all required tables and default users.

**If PHP is not in PATH**, use the full path:
- XAMPP: `C:\xampp\php\php.exe db/init.php`
- Custom install: `C:\php\php.exe db/init.php`

### Step 2: Start the Development Server

```powershell
php -S localhost:8000 -t public
```

Or with full path:
```powershell
C:\php\php.exe -S localhost:8000 -t public
# or
C:\xampp\php\php.exe -S localhost:8000 -t public
```

### Step 3: Access the Application

1. Open your web browser
2. Navigate to: `http://localhost:8000`
3. You should see the login page

### Step 4: Login Credentials

**Default Users:**
- **Admin**: 
  - Username: `admin`
  - Password: `admin123`
- **Regular User**: 
  - Username: `user`
  - Password: `user123`

## Application Structure

```
owasp-top10-php-training-app/
├── app/
│   ├── Controllers/      # MVC Controllers
│   ├── Models/          # Database models
│   ├── Views/           # View templates
│   └── Middleware/      # Authentication middleware
├── config/              # Configuration files
├── db/                  # Database files and schema
├── docs/                # Documentation for each vulnerability
├── public/              # Public web root
│   ├── index.php       # Entry point
│   └── router.php      # Routing logic
└── storage/            # Logs and uploads
    ├── logs/
    └── uploads/
```

## OWASP Top 10 (2021) Vulnerabilities

Each vulnerability includes:
- **Vulnerable Example**: Demonstrates the insecure implementation
- **Secure Example**: Shows the proper, secure implementation

1. **[A01: Broken Access Control](docs/A01_Broken_Access_Control.md)**
   - Vulnerable: Admin page with no server-side access control
   - Secure: Role-based access control middleware

2. **[A02: Cryptographic Failures](docs/A02_Cryptographic_Failures.md)**
   - Vulnerable: MD5 password hashing
   - Secure: bcrypt password hashing

3. **[A03: Injection](docs/A03_Injection.md)**
   - Vulnerable: SQL injection via string concatenation
   - Secure: Prepared statements with parameter binding

4. **[A04: Insecure Design](docs/A04_Insecure_Design.md)**
   - Vulnerable: Predictable password reset tokens, no rate limiting
   - Secure: Random tokens, expiration, rate limiting

5. **[A05: Security Misconfiguration](docs/A05_Security_Misconfiguration.md)**
   - Vulnerable: Debug mode enabled, detailed error messages
   - Secure: Production-safe error handling

6. **[A06: Vulnerable and Outdated Components](docs/A06_Vulnerable_Components.md)**
   - Documentation and best practices for dependency management

7. **[A07: Identification and Authentication Failures](docs/A07_Authentication_Failures.md)**
   - Vulnerable: No session regeneration on login
   - Secure: Session regeneration to prevent fixation

8. **[A08: Software and Data Integrity Failures](docs/A08_Data_Integrity_Failures.md)**
   - Vulnerable: File upload without integrity validation
   - Secure: Hash verification and file type validation

9. **[A09: Security Logging and Monitoring Failures](docs/A09_Logging_Failures.md)**
   - Vulnerable: No logging of security events
   - Secure: Comprehensive audit logging

10. **[A10: Server-Side Request Forgery (SSRF)](docs/A10_SSRF.md)**
    - Vulnerable: Fetches any URL without validation
    - Secure: Domain allowlist and IP filtering

## Documentation

Detailed documentation for each vulnerability is available in the `/docs` directory:
- Description of the vulnerability
- Where it exists in the application
- Why it is dangerous
- How the secure version fixes it
- Best practices

## Troubleshooting

### PHP Not Found

If you see `php: The term 'php' is not recognized`:
1. Make sure PHP is installed
2. Add PHP to your system PATH, or
3. Use the full path to php.exe (e.g., `C:\xampp\php\php.exe`)

### Database Errors

- Make sure you ran `php db/init.php` first
- Check that the `db/` directory is writable
- Ensure SQLite extension is enabled in PHP (usually enabled by default)

### Routes Not Working

- Make sure you're accessing via `http://localhost:8000`
- The `public` directory should be the document root
- Check that `public/index.php` exists

### Session Issues

- Ensure the `storage/` directory is writable
- Check PHP session configuration

## Development Notes

- The application uses a simple MVC-like structure
- SQLite database for easy setup (no MySQL required)
- Plain PHP (no frameworks) for educational clarity
- Each vulnerability is intentionally isolated for learning

## License

This project is for educational purposes only.

## Credits

Built for ethical hacking and secure coding education. Demonstrates real-world security vulnerabilities and their fixes.
