<?php

namespace App\Http\Controllers\Vulnerabilities;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * A09: Security Logging and Monitoring Failures
 * 
 * This controller demonstrates the importance of proper
 * security logging and monitoring.
 */
class A09Controller extends Controller
{
    /**
     * VULNERABLE: No logging of security events
     * 
     * Without proper logging:
     * 1. Cannot detect ongoing attacks
     * 2. Cannot investigate security incidents
     * 3. Cannot identify compromised accounts
     * 4. No evidence for forensic analysis
     */
    public function vulnerable(Request $request)
    {
        $message = null;
        $simulatedActions = [];

        if ($request->isMethod('post')) {
            $action = $request->input('action');

            switch ($action) {
                case 'failed_login':
                    // VULNERABILITY: No logging of failed login attempts
                    // Attacker can brute force without detection
                    $message = "Failed login attempt - NOT LOGGED";
                    $simulatedActions[] = "Failed login for user 'admin' - No log entry created";
                    break;

                case 'admin_access':
                    // VULNERABILITY: No logging of sensitive resource access
                    $message = "Admin panel accessed - NOT LOGGED";
                    $simulatedActions[] = "Admin panel access - No audit trail";
                    break;

                case 'data_export':
                    // VULNERABILITY: No logging of data exports
                    $message = "Sensitive data exported - NOT LOGGED";
                    $simulatedActions[] = "User data exported - No record kept";
                    break;

                case 'permission_change':
                    // VULNERABILITY: No logging of permission changes
                    $message = "User permissions changed - NOT LOGGED";
                    $simulatedActions[] = "User role changed to admin - No audit entry";
                    break;
            }
        }

        return view('vulnerabilities.a09.vulnerable', [
            'message' => $message,
            'simulatedActions' => $simulatedActions,
            'logsExist' => false,
        ]);
    }

    /**
     * SECURE: Comprehensive security logging
     * 
     * Security logging best practices:
     * 1. Log all authentication events (success and failure)
     * 2. Log access to sensitive resources
     * 3. Log all administrative actions
     * 4. Log data modifications and exports
     * 5. Include relevant context (IP, user agent, timestamp)
     * 6. Protect log integrity
     * 7. Set up alerts for suspicious patterns
     */
    public function secure(Request $request)
    {
        $message = null;
        $newLog = null;

        if ($request->isMethod('post')) {
            $action = $request->input('action');

            switch ($action) {
                case 'failed_login':
                    // SECURE: Log failed login attempts
                    $newLog = AuditLog::logSecurityEvent(
                        'failed_login',
                        'authentication',
                        json_encode([
                            'username' => 'attempted_user',
                            'reason' => 'invalid_credentials',
                        ])
                    );
                    
                    // Also log to Laravel's logging system
                    Log::warning('Failed login attempt', [
                        'username' => 'attempted_user',
                        'ip' => request()->ip(),
                        'user_agent' => request()->userAgent(),
                    ]);
                    
                    $message = "Failed login attempt logged for security monitoring";
                    break;

                case 'admin_access':
                    // SECURE: Log access to sensitive resources
                    $newLog = AuditLog::logSecurityEvent(
                        'admin_panel_access',
                        'admin_panel',
                        json_encode([
                            'section' => 'user_management',
                        ])
                    );
                    
                    Log::info('Admin panel accessed', [
                        'user_id' => auth()->id(),
                        'ip' => request()->ip(),
                    ]);
                    
                    $message = "Admin panel access logged for audit trail";
                    break;

                case 'data_export':
                    // SECURE: Log data exports
                    $newLog = AuditLog::logSecurityEvent(
                        'data_export',
                        'user_data',
                        json_encode([
                            'export_type' => 'csv',
                            'record_count' => 150,
                        ])
                    );
                    
                    Log::info('Data export performed', [
                        'user_id' => auth()->id(),
                        'export_type' => 'user_data',
                        'ip' => request()->ip(),
                    ]);
                    
                    $message = "Data export logged for compliance";
                    break;

                case 'permission_change':
                    // SECURE: Log permission changes (critical!)
                    $newLog = AuditLog::logSecurityEvent(
                        'permission_change',
                        'user_roles',
                        json_encode([
                            'target_user_id' => 5,
                            'old_role' => 'user',
                            'new_role' => 'admin',
                            'changed_by' => auth()->id(),
                        ])
                    );
                    
                    Log::warning('User permission changed', [
                        'admin_id' => auth()->id(),
                        'target_user' => 5,
                        'new_role' => 'admin',
                        'ip' => request()->ip(),
                    ]);
                    
                    $message = "Permission change logged with full audit trail";
                    break;
            }
        }

        // Get recent audit logs
        $auditLogs = AuditLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return view('vulnerabilities.a09.secure', [
            'message' => $message,
            'newLog' => $newLog,
            'auditLogs' => $auditLogs,
        ]);
    }
}
