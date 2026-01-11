# A04: Insecure Design

## Description

Insecure Design is a broad category representing different weaknesses, expressed as "missing or ineffective control design." This is different from Security Misconfiguration, as insecure design cannot be fixed by configuration changes. Insecure design flaws include missing security controls, weak security controls, or security controls that are bypassed due to design flaws.

## Where It Exists in the App

### Vulnerable Implementation
- **Location**: `/app/Controllers/A04Controller.php` - `vulnerable()` method
- **Route**: `/a04/vulnerable`
- **View**: `/app/Views/a04/vulnerable.php`

The vulnerable implementation demonstrates insecure design in password reset functionality:
- Predictable tokens (based on user ID + timestamp)
- No expiration time enforcement
- No rate limiting
- User enumeration (reveals if email exists)

### Secure Implementation
- **Location**: `/app/Controllers/A04Controller.php` - `secure()` method
- **Route**: `/a04/secure`
- **View**: `/app/Views/a04/secure.php`

The secure implementation addresses all these issues:
- Cryptographically secure random tokens
- Expiration time enforcement
- Basic rate limiting
- No user enumeration (same response for existing/non-existing users)

## Why It Is Dangerous

1. **Predictable Tokens**: Attackers can guess or predict reset tokens
2. **No Rate Limiting**: Attackers can request unlimited reset tokens, leading to spam or DoS
3. **User Enumeration**: Attackers can discover valid usernames/emails
4. **No Expiration**: Tokens remain valid indefinitely
5. **Account Takeover**: Weak design allows attackers to reset other users' passwords

## How the Secure Version Fixes It

1. **Secure Random Tokens**: Uses `random_bytes()` to generate cryptographically secure tokens
2. **Expiration**: Tokens expire after a set time (1 hour in this example)
3. **Rate Limiting**: Limits the number of reset requests per user per time period
4. **No User Enumeration**: Returns the same message whether the user exists or not
5. **One-Time Use**: Tokens are marked as used after password reset (schema supports this)

## Best Practices

- Design security into the application from the start
- Use threat modeling to identify security requirements
- Implement security controls as part of the design, not as an afterthought
- Use secure random number generators for tokens
- Implement rate limiting on all user-facing endpoints
- Avoid user enumeration by providing consistent responses
- Set appropriate expiration times for tokens
- Mark tokens as used after use
- Implement proper session management
- Follow secure coding principles and patterns

## Testing the Vulnerability

1. Navigate to `/a04/vulnerable`
2. Request a password reset for a user
3. Note the predictable token format (MD5 of user ID + timestamp)
4. Try multiple requests and notice there's no rate limiting
5. Compare with `/a04/secure` which uses secure tokens and rate limiting
