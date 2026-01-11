<?php
$title = 'A04: Insecure Design - Secure';
ob_start();
?>

<h1>A04: Insecure Design - Secure Example</h1>

<div class="alert alert-success">
    <strong>SECURE IMPLEMENTATION</strong><br>
    This example demonstrates secure design in password reset functionality:
    - Cryptographically secure random tokens
    - Expiration time enforcement
    - Basic rate limiting
    - No user enumeration (same response for existing/non-existing users)
</div>

<h2>Password Reset (Secure)</h2>

<form method="POST" style="max-width: 500px;">
    <div class="form-group">
        <label for="email">Email/Username:</label>
        <input type="text" id="email" name="email" required>
    </div>
    <button type="submit" class="btn">Request Password Reset</button>
</form>

<?php if ($message): ?>
    <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<h3>Security Features</h3>
<ul>
    <li><strong>Cryptographically secure tokens:</strong> Uses random_bytes() for unpredictable tokens</li>
    <li><strong>Expiration:</strong> Tokens expire after 1 hour</li>
    <li><strong>Rate limiting:</strong> Maximum 3 requests per hour per user</li>
    <li><strong>No user enumeration:</strong> Same response message regardless of whether user exists</li>
    <li><strong>One-time use:</strong> Tokens should be marked as used after password reset (implemented in schema)</li>
</ul>

<p><a href="/a04/vulnerable" class="btn">View Vulnerable Implementation</a></p>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
