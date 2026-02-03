<?php

namespace App\Http\Controllers\Vulnerabilities;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * A07: Identification and Authentication Failures
 * 
 * This controller demonstrates authentication vulnerabilities
 * and how to properly implement authentication in Laravel.
 */
class A07Controller extends Controller
{
    /**
     * VULNERABLE: Authentication without session regeneration
     * 
     * Session fixation attack:
     * 1. Attacker visits the site and gets a session ID
     * 2. Attacker tricks victim into using that session ID
     * 3. Victim logs in with the attacker's session ID
     * 4. Attacker now has access to victim's authenticated session
     */
    public function vulnerable(Request $request)
    {
        $message = null;
        $sessionInfo = [
            'session_id' => session()->getId(),
            'user' => auth()->user(),
        ];

        if ($request->isMethod('post')) {
            $action = $request->input('action');

            if ($action === 'login') {
                $username = $request->input('username');
                $password = $request->input('password');

                $user = User::where('username', $username)->first();

                if ($user && Hash::check($password, $user->password)) {
                    // VULNERABILITY: No session regeneration!
                    // The session ID remains the same after login
                    // This enables session fixation attacks
                    Auth::login($user);
                    
                    $message = "Logged in successfully! Notice: Session ID did NOT change.";
                    $sessionInfo['session_id_after'] = session()->getId();
                    $sessionInfo['user'] = $user;
                } else {
                    // VULNERABILITY: Reveals if username exists
                    if (!$user) {
                        $message = "User not found.";
                    } else {
                        $message = "Invalid password.";
                    }
                }
            } elseif ($action === 'logout') {
                // VULNERABILITY: Not invalidating session properly
                Auth::logout();
                // Session ID remains the same!
                $message = "Logged out. Notice: Session ID did NOT change.";
            }
        }

        $sessionInfo['session_id'] = session()->getId();

        return view('vulnerabilities.a07.vulnerable', [
            'message' => $message,
            'sessionInfo' => $sessionInfo,
        ]);
    }

    /**
     * SECURE: Authentication with proper session management
     * 
     * Security measures:
     * 1. Session regeneration after login
     * 2. Session invalidation on logout
     * 3. Generic error messages (no user enumeration)
     */
    public function secure(Request $request)
    {
        $message = null;
        $sessionInfo = [
            'session_id_before' => session()->getId(),
            'user' => auth()->user(),
        ];

        if ($request->isMethod('post')) {
            $action = $request->input('action');

            if ($action === 'login') {
                $username = $request->input('username');
                $password = $request->input('password');

                $user = User::where('username', $username)->first();

                if ($user && Hash::check($password, $user->password)) {
                    Auth::login($user);
                    
                    // SECURE: Regenerate session ID after login
                    // This prevents session fixation attacks
                    $request->session()->regenerate();
                    
                    $message = "Logged in successfully! Session ID has been regenerated.";
                    $sessionInfo['session_id_after'] = session()->getId();
                    $sessionInfo['user'] = $user;
                    $sessionInfo['session_regenerated'] = true;
                } else {
                    // SECURE: Generic error message - no user enumeration
                    $message = "Invalid credentials.";
                }
            } elseif ($action === 'logout') {
                Auth::logout();
                
                // SECURE: Invalidate the session and regenerate token
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                $message = "Logged out securely. Session has been invalidated.";
                $sessionInfo['session_invalidated'] = true;
            }
        }

        $sessionInfo['session_id_current'] = session()->getId();

        return view('vulnerabilities.a07.secure', [
            'message' => $message,
            'sessionInfo' => $sessionInfo,
        ]);
    }
}
