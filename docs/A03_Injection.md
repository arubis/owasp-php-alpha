# A03: Injection

## Description

Injection flaws occur when untrusted data is sent to an interpreter as part of a command or query. The attacker's hostile data can trick the interpreter into executing unintended commands or accessing data without proper authorization. The most common form is SQL Injection, but injection can also occur in NoSQL databases, LDAP, XPath, command execution, etc.

## Where It Exists in the App

### Vulnerable Implementation
- **Location**: `/app/Controllers/A03Controller.php` - `vulnerable()` method
- **Route**: `/a03/vulnerable`
- **View**: `/app/Views/a03/vulnerable.php`

The vulnerable implementation builds SQL queries using string concatenation, allowing attackers to inject malicious SQL code.

### Secure Implementation
- **Location**: `/app/Controllers/A03Controller.php` - `secure()` method
- **Route**: `/a03/secure`
- **View**: `/app/Views/a03/secure.php`

The secure implementation uses prepared statements with parameter binding, which separates SQL code from data and prevents injection.

## Why It Is Dangerous

1. **Data Theft**: Attackers can read sensitive data from the database
2. **Data Modification**: Attackers can modify or delete data
3. **Authentication Bypass**: Can bypass login mechanisms
4. **Database Takeover**: Can potentially gain full control of the database
5. **System Compromise**: Can execute system commands in some cases

## How the Secure Version Fixes It

1. **Prepared Statements**: Uses PDO prepared statements which separate SQL code from data
2. **Parameter Binding**: User input is bound as parameters, not concatenated
3. **Automatic Escaping**: The database driver handles escaping automatically
4. **Type Safety**: Parameters can be typed, preventing unexpected input
5. **SQL Syntax Protection**: The query structure is fixed, preventing SQL injection

## Best Practices

- Always use prepared statements with parameter binding
- Use ORMs or query builders that use prepared statements
- Validate and sanitize input
- Use least privilege database accounts
- Never trust user input
- Use parameterized queries for all database operations
- Avoid dynamic SQL when possible
- Implement input validation and output encoding

## Testing the Vulnerability

1. Navigate to `/a03/vulnerable`
2. Try searching for: `' OR '1'='1`
3. Notice it returns all products instead of filtering
4. Compare with `/a03/secure` which properly handles this input as a literal string

**Educational Note**: In a real attack, an attacker might try:
- `' OR '1'='1` - Returns all records
- `'; DROP TABLE products; --` - Attempts to delete table
- `' UNION SELECT * FROM users; --` - Attempts to access other tables
