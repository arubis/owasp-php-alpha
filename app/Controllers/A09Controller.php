<?php
/**
 * A09: Security Logging and Monitoring Failures
 */

class A09Controller extends BaseController {
    private $auditLog;

    public function __construct() {
        require_once __DIR__ . '/../Middleware/AuthMiddleware.php';
        AuthMiddleware::requireAuth();
        $this->auditLog = new AuditLog();
    }

    /**
     * VULNERABLE: No logging of authentication/admin events
     */
    public function vulnerable() {
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $action = $_POST['action'];
            
            if ($action === 'admin_action') {
                // VULNERABILITY: No logging of admin actions
                // No audit trail
                // No monitoring
                $message = "Admin action performed (VULNERABLE: Not logged)";
            } elseif ($action === 'sensitive_operation') {
                // VULNERABILITY: No logging of sensitive operations
                $message = "Sensitive operation completed (VULNERABLE: Not logged)";
            }
        }

        $this->render('a09/vulnerable', [
            'message' => $message
        ]);
    }

    /**
     * SECURE: Logging to /storage/logs + simple audit page
     */
    public function secure() {
        $message = '';
        $logs = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $action = $_POST['action'];
            
            if ($action === 'admin_action') {
                // SECURE: Log admin actions
                $this->auditLog->log('admin_action', 'admin_panel', ['description' => 'Admin action performed']);
                $message = "Admin action performed (SECURE: Logged)";
            } elseif ($action === 'sensitive_operation') {
                // SECURE: Log sensitive operations
                $this->auditLog->log('sensitive_operation', 'data_access', ['description' => 'Sensitive data accessed']);
                $message = "Sensitive operation completed (SECURE: Logged)";
            }
        }

        // Get recent audit logs
        $logs = $this->auditLog->getAll(20);

        $this->render('a09/secure', [
            'message' => $message,
            'logs' => $logs
        ]);
    }
}
