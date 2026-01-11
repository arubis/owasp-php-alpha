# A07: Identification and Authentication Failures

## Description

Confirmation of the user's identity, authentication, and session management is critical to protect against authentication-related attacks. There may be authentication weaknesses if the application permits automated attacks such as credential stuffing, uses weak or well-known passwords, has weak password recovery, uses plain text or weakly hashed passwords, or has missing or ineffective multi-factor authentication.

## Where It Exists in the App

### Vulnerable Implementation
- **Location**: `/app/Controllers/A07Controller.php` - `vulnerable()` method
- **Route**: `/a07/vulnerable`
- **View**: `/app/Views/a07/vulnerable.php`

The vulnerable implementation demonstrates session fixation vulnerability:
- No session regeneration on login
- Session ID remains the same before and after authentication
- Allows session hijacking attacks

### Secure Implementation
- **Location**: `/app/Controllers/A07Controller.php` - `secure()` method
- **Route**: `/a07/secure`
- **View**: `/app/Views/a07/secure.php`

The secure implementation:
- Regenerates session ID on login using `session_regenerate_id(true)`
- Deletes old session file to prevent reuse
- Prevents session fixation attacks

## Why It Is Dangerous

1. **Session Fixation**: If an attacker knows the session ID before login, they can use it after login
2. **Session Hijacking**: Reused session IDs are vulnerable to hijacking
3. **Account Takeover**: Attackers can gain unauthorized access to user accounts
4. **Privilege Escalation**: Session issues can lead to unauthorized privilege access
5. **No Protection**: Users' sessions are not properly protected

## How the Secure Version Fixes It

1. **Session Regeneration**: `session_regenerate_id(true)` creates a new session ID after authentication
2. **Old Session Deletion**: The `true` parameter deletes the old session file
3. **Session Fixation Prevention**: New session ID invalidates any pre-existing session tokens
4. **Secure Session Handling**: Proper session management prevents hijacking
5. **Also on Privilege Changes**: Should also regenerate on privilege escalation (e.g., user → admin)

## Best Practices

- Always regenerate session ID on login
- Use `session_regenerate_id(true)` to delete old session
- Regenerate session ID on privilege changes
- Use secure session cookie settings:
  - `HttpOnly`: Prevents JavaScript access
  - `Secure`: Only send over HTTPS
  - `SameSite`: Prevents CSRF attacks
- Set appropriate session timeout
- Implement proper logout (destroy session)
- Validate session on each request
- Use strong session ID generation
- Limit concurrent sessions per user
- Implement account lockout after failed attempts
- Use multi-factor authentication for sensitive operations

## Testing the Vulnerability

1. Navigate to `/a07/vulnerable`
2. Note the current session ID
3. Click "Simulate Login"
4. Notice the session ID remains the same (vulnerable)
5. Compare with `/a07/secure` where the session ID changes after login
