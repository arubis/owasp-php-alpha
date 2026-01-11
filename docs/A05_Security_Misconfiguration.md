# A05: Security Misconfiguration

## Description

Security Misconfiguration is the most commonly seen issue. This can happen at any level of an application stack, including the network services, platform, web server, application server, database, frameworks, custom code, and pre-installed virtual machines, containers, or storage. Such flaws frequently give attackers unauthorized access to system data or functionality.

## Where It Exists in the App

### Vulnerable Implementation
- **Location**: `/app/Controllers/A05Controller.php` - `vulnerable()` method
- **Route**: `/a05/vulnerable`
- **View**: `/app/Views/a05/vulnerable.php`

The vulnerable implementation demonstrates security misconfiguration:
- Debug mode enabled (display_errors = 1)
- Detailed error messages revealing system information
- File paths and line numbers exposed
- Database structure revealed in errors

### Secure Implementation
- **Location**: `/app/Controllers/A05Controller.php` - `secure()` method
- **Route**: `/a05/secure`
- **View**: `/app/Views/a05/secure.php`

The secure implementation:
- Error display disabled in production (display_errors = 0)
- Generic error messages for users
- Detailed errors logged to file, not shown to users
- No system information exposure

## Why It Is Dangerous

1. **Information Disclosure**: Error messages reveal system structure, file paths, database schema
2. **Attack Surface**: Debug information helps attackers understand the application
3. **Credential Exposure**: Errors might reveal database credentials or API keys
4. **Path Disclosure**: File paths can be used for further attacks
5. **Framework/Version Disclosure**: Helps attackers identify known vulnerabilities

## How the Secure Version Fixes It

1. **Error Display Disabled**: `display_errors = 0` prevents errors from being shown to users
2. **Generic Messages**: Users see generic error messages that don't reveal system details
3. **Error Logging**: Detailed errors are logged to files for developers to review
4. **Separation of Concerns**: Development and production environments have different error handling
5. **Minimal Information**: Only return necessary data, not all database columns

## Best Practices

- Disable debug mode in production
- Set `display_errors = 0` in production
- Log errors to files, not to users
- Use generic error messages for users
- Keep detailed error information in logs only
- Regularly review and rotate error logs
- Use different configurations for development and production
- Remove default accounts and passwords
- Keep software and frameworks updated
- Disable unnecessary features and services
- Use security headers (X-Frame-Options, CSP, etc.)

## Testing the Vulnerability

1. Navigate to `/a05/vulnerable`
2. Try to view a non-existent user (e.g., user_id = 9999)
3. Notice the detailed error message with file paths and database structure
4. Compare with `/a05/secure` which shows only a generic error message
