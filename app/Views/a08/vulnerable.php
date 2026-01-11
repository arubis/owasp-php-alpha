<?php
$title = 'A08: Data Integrity Failures - Vulnerable';
ob_start();
?>

<h1>A08: Software and Data Integrity Failures - Vulnerable Example</h1>

<div class="alert alert-danger">
    <strong>VULNERABLE IMPLEMENTATION</strong><br>
    This example demonstrates data integrity failures:
    - File upload without integrity validation
    - No hash/signature verification
    - Trusting user-supplied files completely
</div>

<h2>File Upload (Vulnerable)</h2>

<?php if ($message): ?>
    <div class="alert alert-warning"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" style="max-width: 500px;">
    <div class="form-group">
        <label for="file">Select File:</label>
        <input type="file" id="file" name="file" required>
    </div>
    <button type="submit" class="btn">Upload File (Vulnerable)</button>
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
    </table>
<?php endif; ?>

<div class="alert alert-warning" style="margin-top: 2rem;">
    <strong>Problems:</strong>
    <ul>
        <li>No file integrity verification (no hash/signature check)</li>
        <li>No file type validation (beyond basic extension check)</li>
        <li>Trusting user-supplied files completely</li>
        <li>No verification that file hasn't been tampered with</li>
        <li>No protection against malicious file uploads</li>
    </ul>
</div>

<p><a href="/a08/secure" class="btn">View Secure Implementation</a></p>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
