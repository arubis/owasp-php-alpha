<?php
$title = 'A06: Vulnerable Components - Secure';
ob_start();
?>

<h1>A06: Vulnerable and Outdated Components - Secure Example</h1>

<div class="alert alert-success">
    <strong>SECURE IMPLEMENTATION</strong><br>
    This example demonstrates secure component management practices.
</div>

<h2>Secure Component Management</h2>

<p><?= htmlspecialchars($message) ?></p>

<h3>Best Practices</h3>
<ul>
    <?php foreach ($bestPractices as $practice): ?>
    <li><?= htmlspecialchars($practice) ?></li>
    <?php endforeach; ?>
</ul>

<h3>Implementation Steps</h3>
<ol>
    <li><strong>Regular Audits:</strong> Run <code>composer audit</code> regularly to check for vulnerabilities</li>
    <li><strong>Keep Dependencies Updated:</strong> Update packages regularly, but test thoroughly</li>
    <li><strong>Use Lock Files:</strong> Commit composer.lock to version control for reproducible builds</li>
    <li><strong>Monitor Security Advisories:</strong> Subscribe to security mailing lists for your dependencies</li>
    <li><strong>Remove Unused Dependencies:</strong> Reduce attack surface by removing unused packages</li>
    <li><strong>Automate Scanning:</strong> Include dependency scanning in CI/CD pipelines</li>
</ol>

<h3>Example Commands</h3>
<pre>
# Audit dependencies for vulnerabilities
composer audit

# Update all dependencies (minor/patch versions)
composer update

# Update to latest versions (including major)
composer update --with-all-dependencies

# Check outdated packages
composer outdated

# Show security advisories
composer audit --format=json
</pre>

<p><a href="/a06/vulnerable" class="btn">View Vulnerable Implementation</a></p>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
