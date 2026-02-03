<?php

namespace App\Http\Controllers\Vulnerabilities;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * A02: Cryptographic Failures
 * 
 * This controller demonstrates cryptographic vulnerabilities
 * and how Laravel provides secure cryptographic functions.
 */
class A02Controller extends Controller
{
    /**
     * VULNERABLE: Using weak hashing algorithms
     * 
     * MD5 and SHA1 are NOT suitable for password hashing because:
     * 1. They are too fast (enables brute force attacks)
     * 2. No salt by default
     * 3. Rainbow table attacks are trivial
     */
    public function vulnerable(Request $request)
    {
        $result = null;
        $hashType = 'md5';

        if ($request->isMethod('post')) {
            $password = $request->input('password', '');
            $hashType = $request->input('hash_type', 'md5');

            // VULNERABILITY: Using weak hash algorithms for passwords
            switch ($hashType) {
                case 'md5':
                    // MD5 is broken - can be cracked in seconds
                    $result = md5($password);
                    break;
                case 'sha1':
                    // SHA1 is also weak for passwords
                    $result = sha1($password);
                    break;
                case 'sha256':
                    // Better but still not suitable for passwords (no salt, too fast)
                    $result = hash('sha256', $password);
                    break;
            }
        }

        // Show some "leaked" password hashes for demonstration
        $leakedHashes = [
            ['hash' => '5f4dcc3b5aa765d61d8327deb882cf99', 'algorithm' => 'MD5', 'cracked' => 'password'],
            ['hash' => '482c811da5d5b4bc6d497ffa98491e38', 'algorithm' => 'MD5', 'cracked' => 'password123'],
            ['hash' => 'e99a18c428cb38d5f260853678922e03', 'algorithm' => 'MD5', 'cracked' => 'abc123'],
            ['hash' => '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'algorithm' => 'SHA1', 'cracked' => 'password'],
        ];

        return view('vulnerabilities.a02.vulnerable', [
            'result' => $result,
            'hashType' => $hashType,
            'leakedHashes' => $leakedHashes,
        ]);
    }

    /**
     * SECURE: Using bcrypt through Laravel's Hash facade
     * 
     * Laravel uses bcrypt by default which:
     * 1. Is intentionally slow (prevents brute force)
     * 2. Includes automatic salting
     * 3. Has configurable cost factor
     */
    public function secure(Request $request)
    {
        $result = null;
        $verifyResult = null;

        if ($request->isMethod('post')) {
            $password = $request->input('password', '');
            $action = $request->input('action', 'hash');

            if ($action === 'hash') {
                // SECURE: Laravel's Hash facade uses bcrypt by default
                // Each hash is unique due to random salt
                $result = Hash::make($password);
            } elseif ($action === 'verify') {
                $hashToVerify = $request->input('hash_to_verify', '');
                // SECURE: Timing-safe comparison
                $verifyResult = Hash::check($password, $hashToVerify);
            }
        }

        return view('vulnerabilities.a02.secure', [
            'result' => $result,
            'verifyResult' => $verifyResult,
            'bcryptRounds' => config('hashing.bcrypt.rounds', 12),
        ]);
    }
}
