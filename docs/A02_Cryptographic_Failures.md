# A02: Cryptographic Failures

## Description

Cryptographic failures (formerly known as "Sensitive Data Exposure") occur when sensitive data is not properly protected through encryption or hashing. This includes storing passwords in plaintext, using weak hashing algorithms, or not encrypting sensitive data in transit.

## Where It Exists in the App

### Vulnerable Implementation
- **Location**: `/app/Controllers/A02Controller.php` - `vulnerable()` method
- **Route**: `/a02/vulnerable`
- **View**: `/app/Views/a02/vulnerable.php`

The vulnerable implementation uses MD5 for password hashing, which is cryptographically broken and can be easily cracked using rainbow tables or brute force attacks.

### Secure Implementation
- **Location**: `/app/Controllers/A02Controller.php` - `secure()` method
- **Route**: `/a02/secure`
- **View**: `/app/Views/a02/secure.php`

The secure implementation uses PHP's `password_hash()` function with bcrypt, which is designed specifically for password hashing and includes automatic salt generation.

## Why It Is Dangerous

1. **Password Cracking**: Weak hashes (MD5, SHA1) can be cracked in seconds/minutes
2. **Rainbow Tables**: Precomputed hash tables allow instant password recovery
3. **No Salt**: Without salt, identical passwords produce identical hashes
4. **Data Exposure**: If database is compromised, all passwords are immediately at risk
5. **Account Takeover**: Attackers can impersonate users by recovering their passwords

## How the Secure Version Fixes It

1. **Strong Algorithm**: Uses bcrypt (or Argon2), which is purpose-built for password hashing
2. **Automatic Salting**: `password_hash()` automatically generates and stores unique salts
3. **Computational Cost**: Bcrypt is computationally expensive, making brute force attacks impractical
4. **Proper Verification**: Uses `password_verify()` which handles salt extraction automatically
5. **Future-Proof**: The algorithm can be upgraded without breaking existing hashes

## Best Practices

- Always use `password_hash()` and `password_verify()` in PHP
- Use bcrypt (default) or Argon2 for password hashing
- Never use MD5, SHA1, or SHA256 for passwords
- Never store passwords in plaintext
- Use HTTPS for data in transit
- Encrypt sensitive data at rest
- Use strong, unique encryption keys
- Implement proper key management

## Testing the Vulnerability

1. Navigate to `/a02/vulnerable`
2. Create a user with a simple password (e.g., "password123")
3. Note the MD5 hash displayed
4. Use an online MD5 cracker or rainbow table to recover the password
5. Compare with `/a02/secure` which uses bcrypt (impossible to crack in reasonable time)
