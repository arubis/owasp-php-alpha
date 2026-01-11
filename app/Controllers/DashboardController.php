<?php
/**
 * Dashboard controller
 */

class DashboardController extends BaseController {
    public function __construct() {
        require_once __DIR__ . '/../Middleware/AuthMiddleware.php';
        AuthMiddleware::requireAuth();
    }

    public function index() {
        $owaspItems = [
            [
                'id' => 'A01',
                'name' => 'Broken Access Control',
                'description' => 'Restrictions on what authenticated users are allowed to do are not properly enforced.'
            ],
            [
                'id' => 'A02',
                'name' => 'Cryptographic Failures',
                'description' => 'Sensitive data exposure due to weak or missing encryption.'
            ],
            [
                'id' => 'A03',
                'name' => 'Injection',
                'description' => 'SQL, NoSQL, Command, and other injection flaws.'
            ],
            [
                'id' => 'A04',
                'name' => 'Insecure Design',
                'description' => 'Security flaws in the design and architecture of the application.'
            ],
            [
                'id' => 'A05',
                'name' => 'Security Misconfiguration',
                'description' => 'Insecure default configurations, incomplete configurations, etc.'
            ],
            [
                'id' => 'A06',
                'name' => 'Vulnerable and Outdated Components',
                'description' => 'Using components with known vulnerabilities.'
            ],
            [
                'id' => 'A07',
                'name' => 'Identification and Authentication Failures',
                'description' => 'Authentication mechanisms are incorrectly implemented.'
            ],
            [
                'id' => 'A08',
                'name' => 'Software and Data Integrity Failures',
                'description' => 'Failures related to code and infrastructure that do not protect against integrity violations.'
            ],
            [
                'id' => 'A09',
                'name' => 'Security Logging and Monitoring Failures',
                'description' => 'Insufficient logging and monitoring leading to delayed detection of security incidents.'
            ],
            [
                'id' => 'A10',
                'name' => 'Server-Side Request Forgery (SSRF)',
                'description' => 'Web applications fetch a remote resource without validating the user-supplied URL.'
            ],
        ];

        $this->render('dashboard/index', ['owaspItems' => $owaspItems]);
    }
}
