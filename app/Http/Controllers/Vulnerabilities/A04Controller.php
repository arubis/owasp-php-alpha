<?php

namespace App\Http\Controllers\Vulnerabilities;

use App\Http\Controllers\Controller;
use App\Models\CustomPasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

/**
 * A04: Insecure Design
 * 
 * This controller demonstrates insecure design patterns,
 * specifically around password reset functionality.
 */
class A04Controller extends Controller
{
    /**
     * VULNERABLE: Password reset with predictable tokens
     * 
     * Design flaws:
     * 1. Token is only 4 digits (10,000 possibilities)
     * 2. No rate limiting on token verification
     * 3. Long expiration time (24 hours)
     * 4. Token is not hashed in database
     */
    public function vulnerable(Request $request)
    {
        $message = null;
        $token = null;
        $tokens = [];

        if ($request->isMethod('post')) {
            $action = $request->input('action');

            if ($action === 'request_reset') {
                $email = $request->input('email');
                $user = User::where('email', $email)->first();

                if ($user) {
                    // VULNERABILITY: Create predictable 4-digit token
                    $reset = CustomPasswordReset::createVulnerableToken($user);
                    $token = $reset->token;
                    $message = "Reset token generated: $token (This would normally be sent via email)";
                } else {
                    // VULNERABILITY: User enumeration - different response for invalid email
                    $message = "No user found with that email address.";
                }
            } elseif ($action === 'verify_token') {
                $tokenInput = $request->input('token');
                
                // VULNERABILITY: No rate limiting - attacker can brute force
                $reset = CustomPasswordReset::where('token', $tokenInput)
                    ->where('used', false)
                    ->first();

                if ($reset && $reset->isValid()) {
                    $message = "Token valid! Password reset for user: " . $reset->user->email;
                } else {
                    $message = "Invalid or expired token.";
                }
            }
        }

        // Show existing tokens for demonstration
        $tokens = CustomPasswordReset::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('vulnerabilities.a04.vulnerable', [
            'message' => $message,
            'token' => $token,
            'tokens' => $tokens,
        ]);
    }

    /**
     * SECURE: Password reset with proper security measures
     * 
     * Security measures:
     * 1. Cryptographically secure 64-character token
     * 2. Rate limiting on requests
     * 3. Short expiration time (15 minutes)
     * 4. Token is hashed in database
     * 5. Generic response (no user enumeration)
     */
    public function secure(Request $request)
    {
        $message = null;
        $rateLimitInfo = null;

        if ($request->isMethod('post')) {
            $action = $request->input('action');
            $key = 'password-reset:' . $request->ip();

            if ($action === 'request_reset') {
                // SECURE: Rate limiting - max 5 requests per minute
                if (RateLimiter::tooManyAttempts($key, 5)) {
                    $seconds = RateLimiter::availableIn($key);
                    $message = "Too many attempts. Please try again in $seconds seconds.";
                    $rateLimitInfo = "Rate limit exceeded. Retry in: $seconds seconds";
                } else {
                    RateLimiter::hit($key, 60);

                    $email = $request->input('email');
                    $user = User::where('email', $email)->first();

                    if ($user) {
                        // SECURE: Create cryptographically secure token
                        CustomPasswordReset::createSecureToken($user);
                    }

                    // SECURE: Generic response - prevents user enumeration
                    $message = "If an account exists with that email, you will receive a password reset link.";
                    $rateLimitInfo = "Attempts remaining: " . (5 - RateLimiter::attempts($key)) . "/5";
                }
            } elseif ($action === 'verify_token') {
                // SECURE: Rate limiting on verification too
                $verifyKey = 'token-verify:' . $request->ip();
                
                if (RateLimiter::tooManyAttempts($verifyKey, 10)) {
                    $seconds = RateLimiter::availableIn($verifyKey);
                    $message = "Too many verification attempts. Please try again in $seconds seconds.";
                } else {
                    RateLimiter::hit($verifyKey, 300); // 5 minute window

                    $tokenInput = $request->input('token');
                    $hashedToken = hash('sha256', $tokenInput);

                    $reset = CustomPasswordReset::where('token', $hashedToken)
                        ->where('used', false)
                        ->first();

                    if ($reset && $reset->isValid()) {
                        $reset->markAsUsed();
                        $message = "Token valid! You can now reset your password.";
                    } else {
                        $message = "Invalid or expired token.";
                    }
                }
            }
        }

        return view('vulnerabilities.a04.secure', [
            'message' => $message,
            'rateLimitInfo' => $rateLimitInfo,
        ]);
    }
}
