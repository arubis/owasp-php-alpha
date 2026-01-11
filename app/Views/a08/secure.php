<?php
$title = 'A08: Data Integrity Failures - Secure';
ob_start();
?>

<h1>A08: Software and Data Integrity Failures - Secure Example</h1>

<div class="alert alert-success">
    <strong>SECURE IMPLEMENTATION</strong><br>
    This example demonstrates secure file upload with integrity validation:
    - Hash calculation and verification
    - File type validation
    - Secure file naming
</div>

<h2>File Upload (Secure)</h2>

<?php if ($message): ?>
    <div class="alert alert-<?= strpos($message, 'SECURE') !== false ? 'success' : 'danger' ?>"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" style="max-width: 500px;">
    <div class="form-group">
        <label for="file">Select Image File:</label>
        <input type="file" id="file" name="file" accept="image/*" required>
    </div>
    <button type="submit" class="btn">Upload File (Secure)</button>
</form>

<?php if ($uploadedFile): ?>
    <h3>Uploaded File Information</h3>
    <table>
        <tr>
            <th>Filename</th>
            <td><?= htmlspecialchars($uploadedFile['name']) ?></td>
        </tr>
        <tr>
            <th>Size</th>
            <td><?= number_format($uploadedFile['size'] / 1024, 2) ?> KB</td>
        </tr>
        <tr>
            <th>SHA-256 Hash</th>
            <td><code><?= htmlspecialchars($uploadedFile['hash']) ?></code></td>
        </tr>
        <tr>
            <th>MIME Type</th>
            <td><?= htmlspecialchars($uploadedFile['mime_type']) ?></td>
        </tr>
    </table>
<?php endif; ?>

<div class="alert alert-success" style="margin-top: 2rem;">
    <strong>Security Features:</strong>
    <ul>
        <li>File hash (SHA-256) calculated and stored for integrity verification</li>
        <li>MIME type validation using finfo (not just extension)</li>
        <li>Whitelist of allowed file types</li>
        <li>Secure file naming (hash-based, prevents filename collisions)</li>
        <li>Can verify file integrity later by recalculating hash</li>
        <li>For production: Consider digital signatures for critical files</li>
    </ul>
</div>

<h3>Additional Best Practices</h3>
<ul>
    <li>Use cryptographic signatures for critical files/updates</li>
    <li>Verify checksums when downloading dependencies</li>
    <li>Store files outside web root when possible</li>
    <li>Scan uploaded files for malware</li>
    <li>Implement file size limits</li>
    <li>Use Content Security Policy (CSP) headers</li>
</ul>

<p><a href="/a08/vulnerable" class="btn">View Vulnerable Implementation</a></p>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
