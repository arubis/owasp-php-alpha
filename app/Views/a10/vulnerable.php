<?php
$title = 'A10: SSRF - Vulnerable';
ob_start();
?>

<h1>A10: Server-Side Request Forgery (SSRF) - Vulnerable Example</h1>

<div class="alert alert-danger">
    <strong>VULNERABLE IMPLEMENTATION</strong><br>
    This example demonstrates SSRF vulnerabilities:
    - Server fetches any user-supplied URL without validation
    - Can access internal resources, localhost, cloud metadata endpoints
    <strong>WARNING:</strong> This is for educational purposes only. Do not attempt to exploit production systems.
</div>

<h2>URL Fetcher (Vulnerable)</h2>

<form method="POST" style="max-width: 500px;">
    <div class="form-group">
        <label for="url">URL to Fetch:</label>
        <input type="text" id="url" name="url" placeholder="https://example.com" required>
    </div>
    <button type="submit" class="btn">Fetch URL (Vulnerable)</button>
</form>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if ($result): ?>
    <h3>Response</h3>
    <table>
        <tr>
            <th>URL</th>
            <td><?= htmlspecialchars($result['url']) ?></td>
        </tr>
        <tr>
            <th>HTTP Code</th>
            <td><?= htmlspecialchars($result['http_code']) ?></td>
        </tr>
        <tr>
            <th>Content Length</th>
            <td><?= htmlspecialchars($result['content_length']) ?> bytes</td>
        </tr>
        <tr>
            <th>Content (first 500 chars)</th>
            <td><pre style="max-height: 200px; overflow: auto;"><?= htmlspecialchars($result['content']) ?></pre></td>
        </tr>
    </table>
<?php endif; ?>

<div class="alert alert-warning" style="margin-top: 2rem;">
    <strong>Vulnerability: SSRF</strong>
    <ul>
        <li>No URL validation - accepts any URL</li>
        <li>Can access internal services (localhost, 127.0.0.1, 10.0.0.0/8, etc.)</li>
        <li>Can access cloud metadata endpoints (169.254.169.254)</li>
        <li>Can access private network resources</li>
        <li>No domain allowlist</li>
        <li>No IP address filtering</li>
    </ul>
</div>

<div class="alert alert-info">
    <strong>Educational Note:</strong> In a real attack, an attacker could use this to:
    <ul>
        <li>Access internal APIs (http://localhost:8080/admin)</li>
        <li>Retrieve cloud metadata (http://169.254.169.254/latest/meta-data/)</li>
        <li>Scan internal network ports</li>
        <li>Bypass firewall restrictions</li>
    </ul>
</div>

<p><a href="/a10/secure" class="btn">View Secure Implementation</a></p>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
