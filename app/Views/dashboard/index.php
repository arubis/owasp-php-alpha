<?php
$title = 'Dashboard - OWASP Top 10 Training';
ob_start();
?>

<h1>OWASP Top 10 Training Application</h1>
<p>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>! This application demonstrates the OWASP Top 10 security vulnerabilities.</p>

<div class="alert alert-info">
    <strong>Educational Purpose Only:</strong> This application is intentionally vulnerable for learning purposes. 
    Each vulnerability includes both a vulnerable implementation and a secure (fixed) implementation.
</div>

<h2>OWASP Top 10 (2021)</h2>

<div class="vulnerability-links">
    <?php foreach ($owaspItems as $item): ?>
    <div class="vuln-card">
        <h3><?= htmlspecialchars($item['id']) ?>: <?= htmlspecialchars($item['name']) ?></h3>
        <p><?= htmlspecialchars($item['description']) ?></p>
        <div style="margin-top: 1rem;">
            <a href="/<?= strtolower($item['id']) ?>/vulnerable">
                <span class="badge badge-vulnerable">Vulnerable Example</span>
            </a>
            <a href="/<?= strtolower($item['id']) ?>/secure">
                <span class="badge badge-secure">Secure Example</span>
            </a>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
