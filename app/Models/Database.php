<?php
/**
 * Database connection class using PDO
 */

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $config = require __DIR__ . '/../../config/database.php';
        
        if ($config['driver'] === 'sqlite') {
            $this->pdo = new PDO('sqlite:' . $config['database'], null, null, $config['options']);
        } else {
            // MySQL support can be added here if needed
            throw new Exception('Only SQLite is supported');
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}
