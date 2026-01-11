<?php
/**
 * A03: Injection (SQL Injection)
 */

class A03Controller extends BaseController {
    public function __construct() {
        require_once __DIR__ . '/../Middleware/AuthMiddleware.php';
        AuthMiddleware::requireAuth();
    }

    /**
     * VULNERABLE: SQL queries using string concatenation
     */
    public function vulnerable() {
        $products = [];
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
            $search = $_GET['search'] ?? '';
            
            $db = Database::getInstance()->getConnection();
            
            // VULNERABILITY: Direct string concatenation - SQL Injection vulnerable!
            // Try: ' OR '1'='1
            // Or: '; DROP TABLE products; --
            $query = "SELECT * FROM products WHERE name LIKE '%" . $search . "%'";
            
            try {
                $result = $db->query($query);
                $products = $result->fetchAll();
            } catch (Exception $e) {
                $error = "Error: " . $e->getMessage();
            }
        } else {
            // Show all products by default
            $db = Database::getInstance()->getConnection();
            $stmt = $db->query("SELECT * FROM products");
            $products = $stmt->fetchAll();
        }

        $this->render('a03/vulnerable', [
            'products' => $products,
            'error' => $error,
            'search' => $_GET['search'] ?? ''
        ]);
    }

    /**
     * SECURE: Using prepared statements (PDO)
     */
    public function secure() {
        $products = [];
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
            $search = $_GET['search'] ?? '';
            
            $db = Database::getInstance()->getConnection();
            
            // SECURE: Using prepared statements with parameter binding
            $stmt = $db->prepare("SELECT * FROM products WHERE name LIKE ?");
            $searchParam = '%' . $search . '%';
            $stmt->execute([$searchParam]);
            $products = $stmt->fetchAll();
        } else {
            // Show all products by default
            $db = Database::getInstance()->getConnection();
            $stmt = $db->query("SELECT * FROM products");
            $products = $stmt->fetchAll();
        }

        $this->render('a03/secure', [
            'products' => $products,
            'error' => $error,
            'search' => $_GET['search'] ?? ''
        ]);
    }
}
