<?php

namespace App\Http\Controllers\Vulnerabilities;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * A05: Security Misconfiguration
 * 
 * This controller demonstrates security misconfiguration vulnerabilities
 * and how Laravel helps prevent them through proper configuration.
 */
class A05Controller extends Controller
{
    /**
     * VULNERABLE: Security misconfiguration examples
     * 
     * Common misconfigurations:
     * 1. Debug mode enabled in production
     * 2. Exposing stack traces and error details
     * 3. Default/weak configurations
     * 4. Exposing sensitive information in responses
     */
    public function vulnerable(Request $request)
    {
        $action = $request->input('action');
        $result = null;
        $error = null;

        // VULNERABILITY: Exposing environment information
        $sensitiveInfo = [
            'app_debug' => config('app.debug'),
            'app_env' => config('app.env'),
            'app_key' => config('app.key'), // NEVER expose this!
            'db_connection' => config('database.default'),
            'db_database' => config('database.connections.sqlite.database'),
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
        ];

        if ($action === 'trigger_error') {
            try {
                // VULNERABILITY: When debug is true, this exposes:
                // - Full stack trace
                // - Database query details
                // - File paths
                // - Configuration values
                DB::select("SELECT * FROM nonexistent_table");
            } catch (\Exception $e) {
                // VULNERABILITY: Exposing detailed error information
                $error = [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                ];
            }
        }

        if ($action === 'phpinfo') {
            // VULNERABILITY: Exposing phpinfo() reveals everything about the server
            ob_start();
            phpinfo();
            $result = ob_get_clean();
        }

        return view('vulnerabilities.a05.vulnerable', [
            'sensitiveInfo' => $sensitiveInfo,
            'error' => $error,
            'phpinfoResult' => $result ?? null,
        ]);
    }

    /**
     * SECURE: Proper security configuration
     * 
     * Security best practices:
     * 1. Debug mode OFF in production (APP_DEBUG=false)
     * 2. Generic error messages for users
     * 3. Logging errors server-side only
     * 4. Not exposing sensitive configuration
     */
    public function secure(Request $request)
    {
        $action = $request->input('action');
        $result = null;
        $error = null;

        // SECURE: Only expose non-sensitive information
        $safeInfo = [
            'environment' => config('app.env'),
            'debug_enabled' => config('app.debug') ? 'Yes (should be No in production!)' : 'No',
            'recommendations' => [
                'Set APP_DEBUG=false in production',
                'Use HTTPS only (APP_URL should be https://)',
                'Run php artisan config:cache in production',
                'Set proper file permissions',
                'Use strong APP_KEY (auto-generated)',
                'Configure CORS properly',
                'Enable CSRF protection (enabled by default)',
            ],
        ];

        if ($action === 'trigger_error') {
            try {
                DB::select("SELECT * FROM nonexistent_table");
            } catch (\Exception $e) {
                // SECURE: Generic error message for users
                $error = "An error occurred. Please try again later.";
                
                // SECURE: Log the actual error for developers
                \Log::error('Database error', [
                    'message' => $e->getMessage(),
                    'user_id' => auth()->id(),
                ]);
            }
        }

        return view('vulnerabilities.a05.secure', [
            'safeInfo' => $safeInfo,
            'error' => $error,
        ]);
    }
}
