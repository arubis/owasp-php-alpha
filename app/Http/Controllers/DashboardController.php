<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the dashboard with all OWASP Top 10 vulnerabilities
     */
    public function index()
    {
        $vulnerabilities = [
            [
                'id' => 'A01',
                'name' => 'Broken Access Control',
                'description' => 'Access control enforces policy such that users cannot act outside of their intended permissions.',
                'vulnerable_route' => route('a01.vulnerable'),
                'secure_route' => route('a01.secure'),
                'color' => 'danger',
            ],
            [
                'id' => 'A02',
                'name' => 'Cryptographic Failures',
                'description' => 'Failures related to cryptography which often lead to exposure of sensitive data.',
                'vulnerable_route' => route('a02.vulnerable'),
                'secure_route' => route('a02.secure'),
                'color' => 'warning',
            ],
            [
                'id' => 'A03',
                'name' => 'Injection',
                'description' => 'User-supplied data is not validated, filtered, or sanitized by the application.',
                'vulnerable_route' => route('a03.vulnerable'),
                'secure_route' => route('a03.secure'),
                'color' => 'danger',
            ],
            [
                'id' => 'A04',
                'name' => 'Insecure Design',
                'description' => 'Missing or ineffective control design. Insecure design cannot be fixed by a perfect implementation.',
                'vulnerable_route' => route('a04.vulnerable'),
                'secure_route' => route('a04.secure'),
                'color' => 'warning',
            ],
            [
                'id' => 'A05',
                'name' => 'Security Misconfiguration',
                'description' => 'Missing appropriate security hardening or improperly configured permissions.',
                'vulnerable_route' => route('a05.vulnerable'),
                'secure_route' => route('a05.secure'),
                'color' => 'info',
            ],
            [
                'id' => 'A06',
                'name' => 'Vulnerable and Outdated Components',
                'description' => 'Using components with known vulnerabilities or without proper version management.',
                'vulnerable_route' => route('a06.index'),
                'secure_route' => route('a06.index'),
                'color' => 'secondary',
            ],
            [
                'id' => 'A07',
                'name' => 'Identification and Authentication Failures',
                'description' => 'Confirmation of the user identity, authentication, and session management.',
                'vulnerable_route' => route('a07.vulnerable'),
                'secure_route' => route('a07.secure'),
                'color' => 'danger',
            ],
            [
                'id' => 'A08',
                'name' => 'Software and Data Integrity Failures',
                'description' => 'Code and infrastructure that does not protect against integrity violations.',
                'vulnerable_route' => route('a08.vulnerable'),
                'secure_route' => route('a08.secure'),
                'color' => 'warning',
            ],
            [
                'id' => 'A09',
                'name' => 'Security Logging and Monitoring Failures',
                'description' => 'Without logging and monitoring, breaches cannot be detected.',
                'vulnerable_route' => route('a09.vulnerable'),
                'secure_route' => route('a09.secure'),
                'color' => 'info',
            ],
            [
                'id' => 'A10',
                'name' => 'Server-Side Request Forgery (SSRF)',
                'description' => 'SSRF flaws occur when a web application fetches a remote resource without validating the URL.',
                'vulnerable_route' => route('a10.vulnerable'),
                'secure_route' => route('a10.secure'),
                'color' => 'danger',
            ],
        ];

        return view('dashboard', compact('vulnerabilities'));
    }
}
