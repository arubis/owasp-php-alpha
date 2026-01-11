# A01: Broken Access Control

## Description

Broken Access Control occurs when restrictions on what authenticated users are allowed to do are not properly enforced. Attackers can exploit these flaws to access unauthorized functionality or data, such as accessing other users' accounts, viewing sensitive files, modifying other users' data, changing access rights, etc.

## Where It Exists in the App

### Vulnerable Implementation
- **Location**: `/app/Controllers/A01Controller.php` - `vulnerableAdmin()` method
- **Route**: `/a01/vulnerable/admin`
- **View**: `/app/Views/a01/vulnerable_admin.php`

The vulnerable implementation has NO server-side access control. The admin page can be accessed by any authenticated user by directly navigating to the URL, even if they are not administrators.

### Secure Implementation
- **Location**: `/app/Controllers/A01Controller.php` - `secureAdmin()` method
- **Route**: `/a01/secure/admin`
- **View**: `/app/Views/a01/secure_admin.php`

The secure implementation uses `AuthMiddleware::requireAdmin()` which performs server-side role validation before allowing access.

## Why It Is Dangerous

1. **Unauthorized Access**: Regular users can access admin-only functionality
2. **Data Exposure**: Sensitive data (like user lists, configuration) can be viewed by unauthorized users
3. **Privilege Escalation**: Users can perform actions beyond their authorized level
4. **Compliance Violations**: Breaches access control requirements in regulations (GDPR, HIPAA, etc.)
5. **Business Impact**: Unauthorized modifications can affect business operations

## How the Secure Version Fixes It

1. **Server-Side Validation**: Access control is enforced on the server, not just the client
2. **Role-Based Access Control (RBAC)**: Uses middleware to check user roles before allowing access
3. **Fail-Safe Defaults**: Denies access by default unless explicitly authorized
4. **Centralized Enforcement**: Access control logic is centralized in middleware, making it easier to maintain
5. **No Client-Side Reliance**: Does not depend on hidden links or client-side checks

## Best Practices

- Always enforce access control on the server side
- Use middleware/filters for consistent access control
- Implement role-based access control (RBAC) or attribute-based access control (ABAC)
- Deny access by default
- Log all access control failures
- Test access control thoroughly
- Use principle of least privilege

## Testing the Vulnerability

1. Log in as a regular user (username: `user`, password: `user123`)
2. Navigate to `/a01/vulnerable/admin` directly
3. Notice you can access the admin panel without being an admin
4. Compare with `/a01/secure/admin` which will redirect you if you're not an admin
