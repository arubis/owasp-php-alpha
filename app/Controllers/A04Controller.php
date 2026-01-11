<?php
/**
 * A04: Insecure Design
 */

class A04Controller extends BaseController {
    public function __construct() {
        require_once __DIR__ . '/../Middleware/AuthMiddleware.php';
        AuthMiddleware::requireAuth();
    }

    /**
     * VULNERABLE: Predictable password reset tokens or missing limits
     */
    public function vulnerable() {
        $message = '';
        $token = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            
            if (!empty($email)) {
                $db = Database::getInstance()->getConnection();
                $userModel = new User();
                $user = $userModel->findByUsername($email);
                
                if ($user) {
                    // VULNERABILITY: Predictable token based on user ID and timestamp
                    $token = md5($user['id'] . time());
                    
                    // VULNERABILITY: No expiration time
                    // VULNERABILITY: No rate limiting
                    $stmt = $db->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)");
                    $stmt->execute([$user['id'], $token, date('Y-m-d H:i:s', strtotime('+1 day'))]);
                    
                    $message = "Password reset token generated: " . $token;
                } else {
                    $message = "User not found (but we don't reveal this in secure version)";
                }
            }
        }

        $this->render('a04/vulnerable', [
            'message' => $message,
            'token' => $token
        ]);
    }

    /**
     * SECURE: Random tokens, expiration, basic rate limiting
     */
    public function secure() {
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            
            if (!empty($email)) {
                $db = Database::getInstance()->getConnection();
                $userModel = new User();
                $user = $userModel->findByUsername($email);
                
                // SECURE: Don't reveal if user exists (prevents user enumeration)
                if ($user) {
                    // SECURE: Cryptographically secure random token
                    $token = bin2hex(random_bytes(32));
                    
                    // SECURE: Set expiration (1 hour)
                    $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));
                    
                    // SECURE: Basic rate limiting check (simplified - check recent requests)
                    $stmt = $db->prepare("SELECT COUNT(*) as count FROM password_resets WHERE user_id = ? AND created_at > datetime('now', '-1 hour')");
                    $stmt->execute([$user['id']]);
                    $recentRequests = $stmt->fetch()['count'];
                    
                    if ($recentRequests >= 3) {
                        $message = "Too many password reset requests. Please try again later.";
                    } else {
                        $stmt = $db->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)");
                        $stmt->execute([$user['id'], $token, $expiresAt]);
                        
                        // In real application, send email with token
                        $message = "If the email exists, a password reset link has been sent.";
                    }
                } else {
                    // SECURE: Same message whether user exists or not
                    $message = "If the email exists, a password reset link has been sent.";
                }
            }
        }

        $this->render('a04/secure', [
            'message' => $message
        ]);
    }
}
