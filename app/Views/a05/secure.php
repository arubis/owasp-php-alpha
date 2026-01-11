<?php
$title = 'A05: Security Misconfiguration - Secure';
ob_start();
?>

<h1>A05: Security Misconfiguration - Secure Example</h1>

<div class="alert alert-success">
    <strong>SECURE IMPLEMENTATION</strong><br>
    This example demonstrates secure configuration:
    - Error display disabled in production
    - Generic error messages
    - Errors logged to file, not shown to users
    - No system information exposure
</div>

<h2>View User (Secure)</h2>

<form method="GET" style="max-width: 500px;">
    <div class="form-group">
        <label for="user_id">User ID:</label>
        <input type="number" id="user_id" name="user_id" required>
    </div>
    <button type="submit" class="btn">View User</button>
</form>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
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

<div class="alert alert-success" style="margin-top: 2rem;">
    <strong>Security Features:</strong>
    <ul>
        <li>Error display disabled (display_errors = 0)</li>
        <li>Generic error messages for users</li>
        <li>Detailed errors logged to file (not shown to users)</li>
        <li>Only necessary data returned (not all columns)</li>
        <li>No system information exposed</li>
    </ul>
</div>

<p><a href="/a05/vulnerable" class="btn">View Vulnerable Implementation</a></p>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
