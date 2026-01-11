<?php
/**
 * A05: Security Misconfiguration
 */

class A05Controller extends BaseController {
    public function __construct() {
        require_once __DIR__ . '/../Middleware/AuthMiddleware.php';
        AuthMiddleware::requireAuth();
    }

    /**
     * VULNERABLE: Debug mode enabled, detailed error messages
     */
    public function vulnerable() {
        $config = require __DIR__ . '/../../config/app.php';
        
        // VULNERABILITY: Debug mode enabled
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
        $error = '';
        $userData = null;

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user_id'])) {
            $userId = $_GET['user_id'];
            
            try {
                $db = Database::getInstance()->getConnection();
                
                // VULNERABILITY: Detailed error messages reveal system information
                $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
                $stmt->execute([$userId]);
                $userData = $stmt->fetch();
                
                if (!$userData) {
                    // VULNERABILITY: Revealing internal structure
                    throw new Exception("User with ID $userId not found in database table 'users'");
                }
            } catch (Exception $e) {
                // VULNERABILITY: Exposing full exception details
                $error = $e->getMessage() . " | File: " . $e->getFile() . " | Line: " . $e->getLine();
            }
        }

        $this->render('a05/vulnerable', [
            'error' => $error,
            'userData' => $userData,
            'debugMode' => true
        ]);
    }

    /**
     * SECURE: Production-safe error handling and config
     */
    public function secure() {
        $config = require __DIR__ . '/../../config/app.php';
        
        // SECURE: Disable error display in production
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        error_reporting(0);
        
        $error = '';
        $userData = null;

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user_id'])) {
            $userId = $_GET['user_id'];
            
            try {
                $db = Database::getInstance()->getConnection();
                
                // SECURE: Generic error messages
                $stmt = $db->prepare("SELECT id, username, email FROM users WHERE id = ?");
                $stmt->execute([$userId]);
                $userData = $stmt->fetch();
                
                if (!$userData) {
                    $error = "User not found.";
                }
            } catch (Exception $e) {
                // SECURE: Log error but show generic message
                error_log("Error in A05Controller: " . $e->getMessage());
                $error = "An error occurred. Please try again.";
            }
        }

        $this->render('a05/secure', [
            'error' => $error,
            'userData' => $userData,
            'debugMode' => false
        ]);
    }
}
