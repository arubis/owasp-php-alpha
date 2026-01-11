<?php
$title = 'A04: Insecure Design - Vulnerable';
ob_start();
?>

<h1>A04: Insecure Design - Vulnerable Example</h1>

<div class="alert alert-danger">
    <strong>VULNERABLE IMPLEMENTATION</strong><br>
    This example demonstrates insecure design in password reset functionality:
    - Predictable tokens (based on user ID + timestamp)
    - No expiration time enforcement
    - No rate limiting
    - User enumeration (reveals if email exists)
</div>

<h2>Password Reset (Vulnerable)</h2>

<form method="POST" style="max-width: 500px;">
    <div class="form-group">
        <label for="email">Email/Username:</label>
        <input type="text" id="email" name="email" required>
    </div>
    <button type="submit" class="btn">Request Password Reset</button>
</form>

<?php if ($message): ?>
    <div class="alert alert-warning"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if ($token): ?>
    <h3>Generated Token (Vulnerable)</h3>
    <pre><?= htmlspecialchars($token) ?></pre>
    <p><strong>Problems:</strong></p>
    <ul>
        <li>Token is predictable (based on user ID + timestamp)</li>
        <li>No expiration time enforcement</li>
        <li>No rate limiting (can request unlimited tokens)</li>
        <li>Reveals if user exists (user enumeration)</li>
    </ul>
<?php endif; ?>

<p><a href="/a04/secure" class="btn">View Secure Implementation</a></p>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
