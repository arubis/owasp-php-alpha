<?php
$title = 'A09: Logging Failures - Secure';
ob_start();
?>

<h1>A09: Security Logging and Monitoring Failures - Secure Example</h1>

<div class="alert alert-success">
    <strong>SECURE IMPLEMENTATION</strong><br>
    This example demonstrates proper security logging and monitoring:
    - Comprehensive logging of security events
    - Audit trail for investigations
    - Monitoring capabilities
</div>

<h2>Security Events (Secure)</h2>

<?php if ($message): ?>
    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="POST" style="max-width: 500px;">
    <input type="hidden" name="action" value="admin_action">
    <button type="submit" class="btn">Perform Admin Action (Logged)</button>
</form>

<form method="POST" style="max-width: 500px; margin-top: 1rem;">
    <input type="hidden" name="action" value="sensitive_operation">
    <button type="submit" class="btn">Perform Sensitive Operation (Logged)</button>
</form>

<h3>Recent Audit Logs</h3>

<?php if (empty($logs)): ?>
    <p>No logs available yet. Perform an action above to see logging in action.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Timestamp</th>
                <th>User</th>
                <th>Action</th>
                <th>Resource</th>
                <th>IP Address</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
            <tr>
                <td><?= htmlspecialchars($log['created_at']) ?></td>
                <td><?= htmlspecialchars($log['username'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($log['action']) ?></td>
                <td><?= htmlspecialchars($log['resource'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($log['ip_address'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($log['details'] ?? 'N/A') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<div class="alert alert-success" style="margin-top: 2rem;">
    <strong>Security Features:</strong>
    <ul>
        <li>Logs all authentication events (login, logout, failed attempts)</li>
        <li>Logs all admin actions</li>
        <li>Logs sensitive operations</li>
        <li>Captures user ID, IP address, user agent, timestamp</li>
        <li>Stores logs in database for audit trail</li>
        <li>Enables security incident investigation</li>
        <li>Foundation for security monitoring and alerting</li>
    </ul>
</div>

<h3>Additional Best Practices</h3>
<ul>
    <li>Log to separate log files (not just database)</li>
    <li>Use log rotation to manage log file sizes</li>
    <li>Implement log aggregation and analysis tools</li>
    <li>Set up alerts for suspicious activities</li>
    <li>Protect log files from tampering</li>
    <li>Regular log review and analysis</li>
    <li>Comply with regulatory logging requirements</li>
</ul>

<p><a href="/a09/vulnerable" class="btn">View Vulnerable Implementation</a></p>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
