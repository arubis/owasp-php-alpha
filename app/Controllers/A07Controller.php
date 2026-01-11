<?php
/**
 * A07: Identification and Authentication Failures
 */

class A07Controller extends BaseController {
    public function __construct() {
        require_once __DIR__ . '/../Middleware/AuthMiddleware.php';
        AuthMiddleware::requireAuth();
    }

    /**
     * VULNERABLE: No session regeneration on login
     */
    public function vulnerable() {
        $message = '';
        $sessionInfo = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            if ($_POST['action'] === 'login_demo') {
                // VULNERABILITY: Session fixation - no session regeneration
                // Old session ID is reused, making it vulnerable to session hijacking
                $_SESSION['user_id'] = 999;
                $_SESSION['username'] = 'demo_user';
                $_SESSION['role'] = 'user';
                
                // VULNERABILITY: Session ID not regenerated
                $message = "Logged in (VULNERABLE: Session ID not regenerated)";
            }
        }

        $sessionInfo = [
            'session_id' => session_id(),
            'session_name' => session_name(),
            'user_id' => $_SESSION['user_id'] ?? 'Not set',
            'username' => $_SESSION['username'] ?? 'Not set'
        ];

        $this->render('a07/vulnerable', [
            'message' => $message,
            'sessionInfo' => $sessionInfo
        ]);
    }

    /**
     * SECURE: session_regenerate_id(true), proper logout
     */
    public function secure() {
        $message = '';
        $sessionInfo = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            if ($_POST['action'] === 'login_demo') {
                // SECURE: Regenerate session ID on login to prevent session fixation
                session_regenerate_id(true); // Delete old session file
                
                $_SESSION['user_id'] = 999;
                $_SESSION['username'] = 'demo_user';
                $_SESSION['role'] = 'user';
                
                $message = "Logged in (SECURE: Session ID regenerated)";
            }
        }

        $sessionInfo = [
            'session_id' => session_id(),
            'session_name' => session_name(),
            'user_id' => $_SESSION['user_id'] ?? 'Not set',
            'username' => $_SESSION['username'] ?? 'Not set'
        ];

        $this->render('a07/secure', [
            'message' => $message,
            'sessionInfo' => $sessionInfo
        ]);
    }
}
