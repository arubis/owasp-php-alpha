<?php

namespace App\Http\Controllers\Vulnerabilities;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * A01: Broken Access Control
 * 
 * This controller demonstrates broken access control vulnerabilities
 * and how to properly implement access control in Laravel.
 */
class A01Controller extends Controller
{
    /**
     * VULNERABLE: Admin page with NO server-side access control
     * 
     * This page can be accessed by ANY authenticated user,
     * regardless of their role. The only "protection" would be
     * hiding the link in the UI, which is easily bypassed.
     * 
     * Attack: Any logged-in user can directly navigate to this URL
     */
    public function vulnerable()
    {
        // VULNERABILITY: No role check!
        // Any authenticated user can access admin functionality
        $users = User::all();

        return view('vulnerabilities.a01.vulnerable', [
            'users' => $users,
            'message' => 'Welcome to the Admin Panel!',
        ]);
    }

    /**
     * SECURE: Admin page with proper role-based access control
     * 
     * Uses Laravel's middleware system to enforce access control
     * at the route level before the controller is even reached.
     * 
     * Laravel Protection: middleware('role:admin') in routes/web.php
     */
    public function secure()
    {
        // This method is protected by 'role:admin' middleware
        // defined in routes/web.php
        $users = User::all();

        return view('vulnerabilities.a01.secure', [
            'users' => $users,
            'message' => 'Welcome to the Secure Admin Panel!',
        ]);
    }

    /**
     * Additional VULNERABLE example: IDOR (Insecure Direct Object Reference)
     * 
     * Allows any user to view/edit any other user's profile
     * by simply changing the ID in the URL.
     */
    public function vulnerableProfile(Request $request, $id)
    {
        // VULNERABILITY: No check if the user can access this profile
        $user = User::findOrFail($id);

        return view('vulnerabilities.a01.vulnerable_profile', [
            'profile' => $user,
        ]);
    }

    /**
     * SECURE: Profile access with proper authorization
     * 
     * Users can only view their own profile, or admins can view any profile.
     */
    public function secureProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // SECURE: Check if user has permission to view this profile
        if ($request->user()->id !== $user->id && !$request->user()->isAdmin()) {
            abort(403, 'You are not authorized to view this profile.');
        }

        return view('vulnerabilities.a01.secure_profile', [
            'profile' => $user,
        ]);
    }
}
