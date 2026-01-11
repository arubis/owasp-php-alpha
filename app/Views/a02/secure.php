<?php
$title = 'A02: Cryptographic Failures - Secure';
ob_start();
?>

<h1>A02: Cryptographic Failures - Secure Example</h1>

<div class="alert alert-success">
    <strong>SECURE IMPLEMENTATION</strong><br>
    This example uses PHP's password_hash() function with bcrypt, which is designed for password hashing.
    It includes salt generation and is computationally expensive to prevent brute force attacks.
</div>

<h2>Create User (Secure)</h2>

<?php if ($message): ?>
    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="POST" style="max-width: 500px;">
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="btn">Create User (Secure Hash)</button>
</form>

<?php if ($userData): ?>
    <h3>User Created</h3>
    <pre>Username: <?= htmlspecialchars($userData['username']) ?>
Password Hash (bcrypt): <?= htmlspecialchars($userData['password_hash']) ?></pre>
    <p><strong>Benefits:</strong></p>
    <ul>
        <li>Uses bcrypt, a purpose-built password hashing algorithm</li>
        <li>Automatically generates and stores a unique salt</li>
        <li>Computationally expensive, making brute force attacks impractical</li>
        <li>Use password_verify() to check passwords (includes salt handling)</li>
    </ul>
<?php endif; ?>

<p><a href="/a02/vulnerable" class="btn">View Vulnerable Implementation</a></p>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
