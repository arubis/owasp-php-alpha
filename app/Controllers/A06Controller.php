<?php
/**
 * A06: Vulnerable and Outdated Components
 */

class A06Controller extends BaseController {
    public function __construct() {
        require_once __DIR__ . '/../Middleware/AuthMiddleware.php';
        AuthMiddleware::requireAuth();
    }

    /**
     * VULNERABLE: Demonstration via comments/docs (example outdated dependency)
     */
    public function vulnerable() {
        // VULNERABILITY: Using outdated/unsupported libraries
        // Example: Using an old version of a library with known CVEs
        // This is demonstrated through documentation and comments
        
        $this->render('a06/vulnerable', [
            'message' => 'This demonstrates the risks of using outdated components.',
            'exampleVulnerability' => 'CVE-2021-12345: Remote Code Execution in library v1.2.3',
            'currentVersion' => '1.2.3',
            'latestVersion' => '2.5.0'
        ]);
    }

    /**
     * SECURE: composer audit explanation and update policy
     */
    public function secure() {
        // SECURE: Regular dependency auditing and updates
        // Use: composer audit, composer update
        
        $this->render('a06/secure', [
            'message' => 'This demonstrates secure component management.',
            'bestPractices' => [
                'Regularly audit dependencies (composer audit)',
                'Keep dependencies up to date',
                'Monitor security advisories',
                'Remove unused dependencies',
                'Use dependency lock files (composer.lock)',
                'Set up automated security scanning in CI/CD'
            ]
        ]);
    }
}
