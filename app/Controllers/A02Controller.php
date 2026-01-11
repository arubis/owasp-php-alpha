<?php
/**
 * A02: Cryptographic Failures
 */

class A02Controller extends BaseController {
    public function __construct() {
        require_once __DIR__ . '/../Middleware/AuthMiddleware.php';
        AuthMiddleware::requireAuth();
    }

    /**
     * VULNERABLE: Plaintext or weakly hashed passwords
     */
    public function vulnerable() {
        $message = '';
        $userData = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (!empty($username) && !empty($password)) {
                $db = Database::getInstance()->getConnection();
                
                // VULNERABILITY: Storing password in plaintext or using weak hash (MD5)
                $weakHash = md5($password); // NEVER DO THIS!
                
                $stmt = $db->prepare("INSERT INTO users (username, email, password_hash, role) VALUES (?, ?, ?, ?)");
                $stmt->execute([$username, $username . '@example.com', $weakHash, 'user']);
                
                $message = "User created! Password stored as: " . $weakHash;
                $userData = ['username' => $username, 'password_hash' => $weakHash];
            }
        }

        // Show all users with their password hashes (demonstration only)
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT id, username, password_hash FROM users LIMIT 5");
        $allUsers = $stmt->fetchAll();

        $this->render('a02/vulnerable', [
            'message' => $message,
            'userData' => $userData,
            'allUsers' => $allUsers
        ]);
    }

    /**
     * SECURE: Using password_hash() with bcrypt
     */
    public function secure() {
        $message = '';
        $userData = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (!empty($username) && !empty($password)) {
                $db = Database::getInstance()->getConnection();
                
                // SECURE: Using password_hash() with bcrypt (default algorithm)
                $secureHash = password_hash($password, PASSWORD_BCRYPT);
                
                $stmt = $db->prepare("INSERT INTO users (username, email, password_hash, role) VALUES (?, ?, ?, ?)");
                $stmt->execute([$username, $username . '@example.com', $secureHash, 'user']);
                
                $message = "User created! Password securely hashed using bcrypt.";
                $userData = ['username' => $username, 'password_hash' => $secureHash];
            }
        }

        $this->render('a02/secure', [
            'message' => $message,
            'userData' => $userData
        ]);
    }
}
