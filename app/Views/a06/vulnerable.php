<?php
$title = 'A06: Vulnerable Components - Vulnerable';
ob_start();
?>

<h1>A06: Vulnerable and Outdated Components - Vulnerable Example</h1>

<div class="alert alert-danger">
    <strong>VULNERABLE IMPLEMENTATION</strong><br>
    This example demonstrates the risks of using outdated or vulnerable components.
    While we cannot demonstrate actual vulnerable libraries in this training app,
    this shows what can happen when dependencies are not kept up to date.
</div>

<h2>Outdated Component Example</h2>

<p><?= htmlspecialchars($message) ?></p>

<h3>Example Scenario</h3>
<div style="background: #f4f4f4; padding: 1rem; border-radius: 4px;">
    <p><strong>Current Version in Use:</strong> <?= htmlspecialchars($currentVersion) ?></p>
    <p><strong>Latest Available Version:</strong> <?= htmlspecialchars($latestVersion) ?></p>
    <p><strong>Known Vulnerability:</strong> <?= htmlspecialchars($exampleVulnerability) ?></p>
</div>

<h3>Risks of Outdated Components</h3>
<ul>
    <li>Known security vulnerabilities (CVEs) not patched</li>
    <li>Missing security fixes and improvements</li>
    <li>Compatibility issues with newer systems</li>
    <li>Lack of support from maintainers</li>
    <li>Potential for exploitation by attackers</li>
</ul>

<h3>How to Check for Vulnerabilities</h3>
<pre>
# Check for known vulnerabilities
composer audit

# Update dependencies
composer update

# Update specific package
composer update vendor/package-name
</pre>

<p><a href="/a06/secure" class="btn">View Secure Implementation</a></p>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
