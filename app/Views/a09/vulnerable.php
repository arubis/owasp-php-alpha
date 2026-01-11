<?php
$title = 'A09: Logging Failures - Vulnerable';
ob_start();
?>

<h1>A09: Security Logging and Monitoring Failures - Vulnerable Example</h1>

<div class="alert alert-danger">
    <strong>VULNERABLE IMPLEMENTATION</strong><br>
    This example demonstrates security logging and monitoring failures:
    - No logging of authentication/admin events
    - No audit trail
    - No monitoring capabilities
</div>

<h2>Security Events (Vulnerable)</h2>

<?php if ($message): ?>
    <div class="alert alert-warning"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="POST" style="max-width: 500px;">
    <input type="hidden" name="action" value="admin_action">
    <button type="submit" class="btn">Perform Admin Action (Not Logged)</button>
</form>

<form method="POST" style="max-width: 500px; margin-top: 1rem;">
    <input type="hidden" name="action" value="sensitive_operation">
    <button type="submit" class="btn">Perform Sensitive Operation (Not Logged)</button>
</form>

<div class="alert alert-warning" style="margin-top: 2rem;">
    <strong>Problems:</strong>
    <ul>
        <li>No logging of authentication events (login, logout, failed attempts)</li>
        <li>No logging of admin actions</li>
        <li>No logging of sensitive operations</li>
        <li>No audit trail for security incidents</li>
        <li>Unable to detect or investigate security breaches</li>
        <li>No monitoring or alerting capabilities</li>
    </ul>
</div>

<p><a href="/a09/secure" class="btn">View Secure Implementation</a></p>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
