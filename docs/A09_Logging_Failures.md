# A09: Security Logging and Monitoring Failures

## Description

Logging and monitoring can be challenging to test, often involving interviews or asking if attacks were detected during a penetration test. There isn't much visibility for an attacker to know if logging and monitoring is enabled or not. Without logging and monitoring, breaches cannot be detected. Insufficient logging, detection, monitoring, and active response occurs any time:
- Auditable events, such as logins, failed logins, and high-value transactions, are not logged
- Warnings and errors generate no, inadequate, or unclear log messages
- Logs of applications and APIs are not monitored for suspicious activity
- Logs are only stored locally

## Where It Exists in the App

### Vulnerable Implementation
- **Location**: `/app/Controllers/A09Controller.php` - `vulnerable()` method
- **Route**: `/a09/vulnerable`
- **View**: `/app/Views/a09/vulnerable.php`

The vulnerable implementation demonstrates logging failures:
- No logging of authentication/admin events
- No audit trail
- No monitoring capabilities
- Cannot detect or investigate security incidents

### Secure Implementation
- **Location**: `/app/Controllers/A09Controller.php` - `secure()` method
- **Route**: `/a09/secure`
- **View**: `/app/Views/a09/secure.php`

The secure implementation:
- Logs all authentication events
- Logs admin actions
- Logs sensitive operations
- Captures user ID, IP address, user agent, timestamp
- Stores logs in database for audit trail
- Provides audit log viewing interface

## Why It Is Dangerous

1. **No Detection**: Security breaches cannot be detected without logging
2. **No Investigation**: Cannot investigate incidents without audit trail
3. **Compliance Violations**: Many regulations require logging (GDPR, PCI-DSS, HIPAA)
4. **Delayed Response**: Attacks can continue undetected
5. **No Accountability**: Cannot determine who did what and when

## How the Secure Version Fixes It

1. **Comprehensive Logging**: Logs all security-relevant events
2. **Audit Trail**: Stores logs with timestamps, user IDs, IP addresses
3. **Log Storage**: Logs stored in database for querying and analysis
4. **Monitoring Foundation**: Provides foundation for security monitoring
5. **Investigation Capability**: Enables security incident investigation

## Best Practices

- Log all authentication events (success, failure, logout)
- Log all authorization failures
- Log sensitive operations (data access, modifications)
- Log administrative actions
- Include relevant context (user ID, IP, timestamp, user agent)
- Log to separate log files (not just database)
- Use log rotation to manage log file sizes
- Implement log aggregation and analysis tools
- Set up alerts for suspicious activities
- Protect log files from tampering
- Regular log review and analysis
- Comply with regulatory logging requirements
- Use structured logging (JSON format)
- Centralize logs for distributed systems
- Monitor logs in real-time
- Implement log retention policies

## Testing the Vulnerability

1. Navigate to `/a09/vulnerable`
2. Perform some actions and notice there's no logging
3. Navigate to `/a09/secure`
4. Perform actions and view the audit logs
5. Notice the comprehensive logging of security events
