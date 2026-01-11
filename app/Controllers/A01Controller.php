<?php
/**
 * A01: Broken Access Control
 */

class A01Controller extends BaseController {
    public function __construct() {
        require_once __DIR__ . '/../Middleware/AuthMiddleware.php';
        AuthMiddleware::requireAuth();
    }

    /**
     * VULNERABLE: Admin page protected only by frontend/UI check
     * Can be bypassed by directly accessing the URL
     */
    public function vulnerableAdmin() {
        // VULNERABILITY: No server-side access control check
        // Only relying on frontend/user to not access this page
        
        $this->render('a01/vulnerable_admin', [
            'message' => 'Welcome to the Admin Panel!',
            'users' => $this->getAllUsers()
        ]);
    }

    /**
     * SECURE: Proper role-based access control middleware
     */
    public function secureAdmin() {
        // SECURE: Server-side role check
        AuthMiddleware::requireAdmin();
        
        $this->render('a01/secure_admin', [
            'message' => 'Welcome to the Admin Panel!',
            'users' => $this->getAllUsers()
        ]);
    }

    private function getAllUsers() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT id, username, email, role FROM users");
        return $stmt->fetchAll();
    }
}
