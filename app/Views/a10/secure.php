<?php
$title = 'A10: SSRF - Secure';
ob_start();
?>

<h1>A10: Server-Side Request Forgery (SSRF) - Secure Example</h1>

<div class="alert alert-success">
    <strong>SECURE IMPLEMENTATION</strong><br>
    This example demonstrates secure URL fetching:
    - Domain allowlist
    - Internal IP address blocking
    - Protocol restrictions
    - No redirect following
</div>

<h2>URL Fetcher (Secure)</h2>

<form method="POST" style="max-width: 500px;">
    <div class="form-group">
        <label for="url">URL to Fetch:</label>
        <input type="text" id="url" name="url" placeholder="https://example.com" required>
        <small>Allowed domains: example.com, httpbin.org, jsonplaceholder.typicode.com</small>
    </div>
    <button type="submit" class="btn">Fetch URL (Secure)</button>
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

<div class="alert alert-success" style="margin-top: 2rem;">
    <strong>Security Features:</strong>
    <ul>
        <li><strong>Domain Allowlist:</strong> Only allows requests to pre-approved domains</li>
        <li><strong>IP Address Validation:</strong> Blocks internal/private IP ranges (10.0.0.0/8, 172.16.0.0/12, 192.168.0.0/16, 127.0.0.0/8)</li>
        <li><strong>Protocol Restrictions:</strong> Only allows HTTP and HTTPS</li>
        <li><strong>No Redirect Following:</strong> Prevents redirect-based attacks</li>
        <li><strong>URL Parsing:</strong> Properly validates URL structure</li>
        <li><strong>Timeout Limits:</strong> Prevents resource exhaustion</li>
    </ul>
</div>

<h3>Additional Best Practices</h3>
<ul>
    <li>Use a whitelist of allowed domains/IPs when possible</li>
    <li>Block private IP ranges (RFC 1918)</li>
    <li>Block localhost/127.0.0.1</li>
    <li>Block link-local addresses (169.254.0.0/16)</li>
    <li>Disable redirect following or validate redirect URLs</li>
    <li>Use DNS rebinding protection</li>
    <li>Consider using a proxy service for URL fetching</li>
    <li>Log all URL fetch requests for monitoring</li>
</ul>

<p><a href="/a10/vulnerable" class="btn">View Vulnerable Implementation</a></p>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
