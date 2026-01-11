<?php
$title = 'A05: Security Misconfiguration - Vulnerable';
ob_start();
?>

<h1>A05: Security Misconfiguration - Vulnerable Example</h1>

<div class="alert alert-danger">
    <strong>VULNERABLE IMPLEMENTATION</strong><br>
    This example demonstrates security misconfiguration:
    - Debug mode enabled (exposing error details)
    - Detailed error messages revealing system information
    - PHP configuration exposure
</div>

<h2>View User (Vulnerable)</h2>

<form method="GET" style="max-width: 500px;">
    <div class="form-group">
        <label for="user_id">User ID:</label>
        <input type="number" id="user_id" name="user_id" required>
    </div>
    <button type="submit" class="btn">View User</button>
</form>

<?php if ($error): ?>
    <div class="alert alert-danger">
        <strong>Error Details (Vulnerable - Reveals Too Much):</strong><br>
        <pre><?= htmlspecialchars($error) ?></pre>
    </div>
<?php endif; ?>

<?php if ($userData): ?>
    <h3>User Data</h3>
    <table>
        <tr>
            <th>ID</th>
            <td><?= htmlspecialchars($userData['id']) ?></td>
        </tr>
        <tr>
            <th>Username</th>
            <td><?= htmlspecialchars($userData['username']) ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= htmlspecialchars($userData['email']) ?></td>
        </tr>
    </table>
<?php endif; ?>

<div class="alert alert-warning" style="margin-top: 2rem;">
    <strong>Problems:</strong>
    <ul>
        <li>Debug mode enabled (display_errors = 1)</li>
        <li>Error messages reveal file paths, line numbers, and database structure</li>
        <li>PHP information exposed (phpinfo)</li>
        <li>Stack traces visible to users</li>
    </ul>
</div>

<p><a href="/a05/secure" class="btn">View Secure Implementation</a></p>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
