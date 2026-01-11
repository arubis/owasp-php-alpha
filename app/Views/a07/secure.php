<?php
$title = 'A07: Authentication Failures - Secure';
ob_start();
?>

<h1>A07: Identification and Authentication Failures - Secure Example</h1>

<div class="alert alert-success">
    <strong>SECURE IMPLEMENTATION</strong><br>
    This example demonstrates secure session management:
    - Session regeneration on login (prevents session fixation)
    - New session ID generated after authentication
</div>

<h2>Session Management (Secure)</h2>

<?php if ($message): ?>
    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="POST" style="max-width: 500px;">
    <input type="hidden" name="action" value="login_demo">
    <button type="submit" class="btn">Simulate Login (Secure)</button>
</form>

<h3>Current Session Information</h3>
<table>
    <tr>
        <th>Session ID</th>
        <td><code><?= htmlspecialchars($sessionInfo['session_id']) ?></code></td>
    </tr>
    <tr>
        <th>Session Name</th>
        <td><?= htmlspecialchars($sessionInfo['session_name']) ?></td>
    </tr>
    <tr>
        <th>User ID</th>
        <td><?= htmlspecialchars($sessionInfo['user_id']) ?></td>
    </tr>
    <tr>
        <th>Username</th>
        <td><?= htmlspecialchars($sessionInfo['username']) ?></td>
    </tr>
</table>

<div class="alert alert-success" style="margin-top: 2rem;">
    <strong>Security Features:</strong>
    <ul>
        <li>Session ID regenerated on login using <code>session_regenerate_id(true)</code></li>
        <li>Old session file is deleted (true parameter)</li>
        <li>Prevents session fixation attacks</li>
        <li>New session ID invalidates any pre-existing session tokens</li>
        <li>Also regenerate on privilege escalation (e.g., user → admin)</li>
    </ul>
</div>

<h3>Additional Best Practices</h3>
<ul>
    <li>Use secure session cookie settings (HttpOnly, Secure, SameSite)</li>
    <li>Set appropriate session timeout</li>
    <li>Implement proper logout (destroy session)</li>
    <li>Regenerate session ID on privilege changes</li>
    <li>Validate session on each request</li>
</ul>

<p><a href="/a07/vulnerable" class="btn">View Vulnerable Implementation</a></p>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
