<?php
$title = 'A07: Authentication Failures - Vulnerable';
ob_start();
?>

<h1>A07: Identification and Authentication Failures - Vulnerable Example</h1>

<div class="alert alert-danger">
    <strong>VULNERABLE IMPLEMENTATION</strong><br>
    This example demonstrates authentication failures:
    - No session regeneration on login (session fixation vulnerability)
    - Session ID remains the same before and after login
</div>

<h2>Session Management (Vulnerable)</h2>

<?php if ($message): ?>
    <div class="alert alert-warning"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="POST" style="max-width: 500px;">
    <input type="hidden" name="action" value="login_demo">
    <button type="submit" class="btn">Simulate Login (Vulnerable)</button>
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

<div class="alert alert-warning" style="margin-top: 2rem;">
    <strong>Vulnerability: Session Fixation</strong>
    <ul>
        <li>Session ID is NOT regenerated on login</li>
        <li>If an attacker knows the session ID before login, they can use it after login</li>
        <li>Allows session hijacking attacks</li>
        <li>No protection against session fixation attacks</li>
    </ul>
</div>

<p><a href="/a07/secure" class="btn">View Secure Implementation</a></p>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
