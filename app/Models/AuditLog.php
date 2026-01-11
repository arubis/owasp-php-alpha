<?php
/**
 * Audit log model for A09 demonstration
 */

class AuditLog {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function log($action, $resource = null, $details = null) {
        $userId = $_SESSION['user_id'] ?? null;
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;
        
        $stmt = $this->db->prepare(
            "INSERT INTO audit_logs (user_id, action, resource, ip_address, user_agent, details) 
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        
        return $stmt->execute([
            $userId,
            $action,
            $resource,
            $ipAddress,
            $userAgent,
            $details ? json_encode($details) : null
        ]);
    }

    public function getAll($limit = 100) {
        $stmt = $this->db->prepare(
            "SELECT al.*, u.username 
             FROM audit_logs al 
             LEFT JOIN users u ON al.user_id = u.id 
             ORDER BY al.created_at DESC 
             LIMIT ?"
        );
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
}
