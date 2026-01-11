# A10: Server-Side Request Forgery (SSRF)

## Description

Server-Side Request Forgery (SSRF) flaws occur whenever a web application is fetching a remote resource without validating the user-supplied URL. It allows an attacker to coerce the application to send a crafted request to an unexpected destination, even when protected by a firewall, VPN, or another type of network ACL.

## Where It Exists in the App

### Vulnerable Implementation
- **Location**: `/app/Controllers/A10Controller.php` - `vulnerable()` method
- **Route**: `/a10/vulnerable`
- **View**: `/app/Views/a10/vulnerable.php`

The vulnerable implementation:
- Fetches any user-supplied URL without validation
- Can access internal services (localhost, private IPs)
- Can access cloud metadata endpoints
- No domain allowlist
- No IP address filtering

### Secure Implementation
- **Location**: `/app/Controllers/A10Controller.php` - `secure()` method
- **Route**: `/a10/secure`
- **View**: `/app/Views/a10/secure.php`

The secure implementation:
- Domain allowlist (only allowed domains)
- Blocks internal/private IP ranges
- Protocol restrictions (only HTTP/HTTPS)
- No redirect following
- IP address validation

## Why It Is Dangerous

1. **Internal Network Access**: Can access internal services not exposed to the internet
2. **Cloud Metadata Access**: Can access cloud metadata endpoints (AWS, Azure, GCP)
3. **Port Scanning**: Can scan internal network ports
4. **Bypass Firewalls**: Bypasses firewall restrictions
5. **Information Disclosure**: Can retrieve sensitive internal information
6. **Remote Code Execution**: In some cases, can lead to RCE

## How the Secure Version Fixes It

1. **Domain Allowlist**: Only allows requests to pre-approved domains
2. **IP Address Validation**: Blocks private/internal IP ranges (RFC 1918)
3. **Protocol Restrictions**: Only allows HTTP and HTTPS protocols
4. **No Redirect Following**: Prevents redirect-based attacks
5. **URL Parsing**: Properly validates URL structure before processing
6. **Timeout Limits**: Prevents resource exhaustion attacks

## Best Practices

- Use a whitelist of allowed domains/IPs when possible
- Block private IP ranges (10.0.0.0/8, 172.16.0.0/12, 192.168.0.0/16)
- Block localhost (127.0.0.0/8)
- Block link-local addresses (169.254.0.0/16)
- Block cloud metadata IPs (169.254.169.254)
- Disable redirect following or validate redirect URLs
- Use DNS rebinding protection
- Consider using a proxy service for URL fetching
- Log all URL fetch requests for monitoring
- Validate URL scheme (only http/https)
- Use URL parsing libraries to validate URLs
- Implement rate limiting on URL fetching endpoints
- Use network segmentation to limit internal access

## Testing the Vulnerability

1. Navigate to `/a10/vulnerable`
2. Try fetching: `http://localhost` or `http://127.0.0.1`
3. Notice it can access internal resources
4. Compare with `/a10/secure` which blocks internal IPs
5. Try fetching an allowed domain (e.g., `https://example.com`) in secure version

**Educational Note**: In a real attack, an attacker might try:
- `http://localhost:8080/admin` - Access internal admin panel
- `http://169.254.169.254/latest/meta-data/` - Access AWS metadata
- `http://192.168.1.1` - Access router admin panel
- `file:///etc/passwd` - Attempt file system access
