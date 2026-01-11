# A08: Software and Data Integrity Failures

## Description

Software and Data Integrity Failures relate to code and infrastructure that does not protect against integrity violations. An example of this is where an application relies upon plugins, libraries, or modules from untrusted sources, repositories, and content delivery networks (CDNs). An insecure CI/CD pipeline can introduce the potential for unauthorized access, malicious code, or system compromise.

## Where It Exists in the App

### Vulnerable Implementation
- **Location**: `/app/Controllers/A08Controller.php` - `vulnerable()` method
- **Route**: `/a08/vulnerable`
- **View**: `/app/Views/a08/vulnerable.php`

The vulnerable implementation demonstrates data integrity failures:
- File upload without integrity validation
- No hash/signature verification
- Trusting user-supplied files completely
- No file type validation beyond basic extension check

### Secure Implementation
- **Location**: `/app/Controllers/A08Controller.php` - `secure()` method
- **Route**: `/a08/secure`
- **View**: `/app/Views/a08/secure.php`

The secure implementation:
- Calculates and stores SHA-256 hash for integrity verification
- Validates file type using MIME type detection (finfo)
- Uses whitelist of allowed file types
- Secure file naming (hash-based)

## Why It Is Dangerous

1. **File Tampering**: Files can be modified without detection
2. **Malicious Files**: Attackers can upload malicious files (malware, scripts)
3. **Data Corruption**: Modified files can corrupt data or system
4. **No Verification**: Cannot verify file integrity after upload
5. **Supply Chain Attacks**: Compromised files can be distributed to users

## How the Secure Version Fixes It

1. **Hash Verification**: SHA-256 hash calculated and stored for integrity checks
2. **MIME Type Validation**: Uses finfo to detect actual file type (not just extension)
3. **File Type Whitelist**: Only allows specific, safe file types
4. **Secure Naming**: Hash-based file names prevent collisions and guessing
5. **Integrity Checks**: Can verify file integrity later by recalculating hash

## Best Practices

- Calculate and store hashes for uploaded files
- Use cryptographic signatures for critical files/updates
- Verify checksums when downloading dependencies
- Use MIME type detection, not just file extensions
- Implement file type whitelisting
- Store uploaded files outside web root when possible
- Scan uploaded files for malware
- Implement file size limits
- Use secure, unique file names
- Verify file integrity before processing
- Use digital signatures for software updates
- Secure CI/CD pipelines
- Verify package integrity from package managers
- Use Content Security Policy (CSP) headers

## Testing the Vulnerability

1. Navigate to `/a08/vulnerable`
2. Upload a file and notice there's no integrity check
3. Compare with `/a08/secure` which calculates and displays a hash
4. Note the MIME type validation in the secure version
