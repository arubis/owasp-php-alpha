<?php
/**
 * Authentication controller
 */

class AuthController extends BaseController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        // Redirect if already logged in
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/dashboard');
        }

        $error = $_GET['error'] ?? null;
        $this->render('auth/login', ['error' => $error]);
    }

    public function processLogin() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $this->redirect('/login?error=empty');
        }

        $user = $this->userModel->findByUsername($username);
        
        if ($user && password_verify($password, $user['password_hash'])) {
            // Secure session handling
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            $this->redirect('/dashboard');
        } else {
            $this->redirect('/login?error=invalid');
        }
    }

    public function logout() {
        session_destroy();
        session_start();
        session_regenerate_id(true);
        $this->redirect('/login');
    }
}
