<?php
$title = 'A02: Cryptographic Failures - Vulnerable';
ob_start();
?>

<h1>A02: Cryptographic Failures - Vulnerable Example</h1>

<div class="alert alert-danger">
    <strong>VULNERABLE IMPLEMENTATION</strong><br>
    This example stores passwords using MD5, which is cryptographically broken and easily crackable.
    Passwords should NEVER be stored in plaintext or using weak hashing algorithms.
</div>

<h2>Create User (Vulnerable)</h2>

<?php if ($message): ?>
    <div class="alert alert-warning"><?= htmlspecialchars($message) ?></div>
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
    <button type="submit" class="btn">Create User (MD5 Hash)</button>
</form>

<?php if ($userData): ?>
    <h3>User Created</h3>
    <pre>Username: <?= htmlspecialchars($userData['username']) ?>
Password Hash (MD5): <?= htmlspecialchars($userData['password_hash']) ?></pre>
    <p><strong>Problem:</strong> MD5 hashes can be cracked using rainbow tables or brute force attacks in seconds/minutes.</p>
<?php endif; ?>

<h3>All Users (Password Hashes Visible)</h3>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Password Hash</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($allUsers as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['id']) ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><code><?= htmlspecialchars($user['password_hash']) ?></code></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p><a href="/a02/secure" class="btn">View Secure Implementation</a></p>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
