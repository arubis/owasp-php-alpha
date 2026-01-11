<?php
/**
 * Database initialization script
 * Run this once to set up the database
 */

require_once __DIR__ . '/../config/database.php';

$dbConfig = require __DIR__ . '/../config/database.php';
$schemaPath = __DIR__ . '/schema.sql';

try {
    // Create database file if using SQLite
    if ($dbConfig['driver'] === 'sqlite') {
        $dbPath = $dbConfig['database'];
        $dbDir = dirname($dbPath);
        if (!is_dir($dbDir)) {
            mkdir($dbDir, 0755, true);
        }
        
        $pdo = new PDO('sqlite:' . $dbPath);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Read and execute schema (without user inserts - we'll do those with proper hashes)
        $schema = file_get_contents($schemaPath);
        
        // Remove the INSERT statements for users (we'll add them with proper hashes)
        $schema = preg_replace('/INSERT OR IGNORE INTO users.*?\);.*?\n/s', '', $schema);
        
        $pdo->exec($schema);
        
        // Generate proper password hashes and insert users
        $adminHash = password_hash('admin123', PASSWORD_BCRYPT);
        $userHash = password_hash('user123', PASSWORD_BCRYPT);
        
        $stmt = $pdo->prepare("INSERT OR IGNORE INTO users (username, email, password_hash, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['admin', 'admin@example.com', $adminHash, 'admin']);
        $stmt->execute(['user', 'user@example.com', $userHash, 'user']);
        
        echo "Database initialized successfully!\n";
        echo "Default users created:\n";
        echo "  - Admin: admin / admin123\n";
        echo "  - User: user / user123\n";
    } else {
        echo "Only SQLite is supported in this version.\n";
    }
} catch (PDOException $e) {
    die("Database initialization failed: " . $e->getMessage() . "\n");
}
