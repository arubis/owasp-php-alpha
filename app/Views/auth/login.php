<?php
$title = 'Login - OWASP Top 10 Training';
ob_start();
?>

<h1>Login</h1>
<p>Use the credentials below to access the training application:</p>

<?php if ($error === 'empty'): ?>
    <div class="alert alert-danger">Please fill in all fields.</div>
<?php elseif ($error === 'invalid'): ?>
    <div class="alert alert-danger">Invalid username or password.</div>
<?php endif; ?>

<div style="background: #f0f0f0; padding: 1rem; margin: 1rem 0; border-radius: 4px;">
    <strong>Default Credentials:</strong><br>
    Admin: <code>admin</code> / <code>admin123</code><br>
    User: <code>user</code> / <code>user123</code>
</div>

<form method="POST" action="/login-process" style="max-width: 400px;">
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="btn">Login</button>
</form>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
