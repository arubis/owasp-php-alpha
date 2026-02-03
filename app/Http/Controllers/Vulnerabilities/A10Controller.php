<?php

namespace App\Http\Controllers\Vulnerabilities;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

/**
 * A10: Server-Side Request Forgery (SSRF)
 * 
 * This controller demonstrates SSRF vulnerabilities
 * and how to properly validate URLs before making server-side requests.
 */
class A10Controller extends Controller
{
    /**
     * VULNERABLE: SSRF - No URL validation
     * 
     * SSRF allows attackers to:
     * 1. Access internal services (localhost, internal IPs)
     * 2. Scan internal networks
     * 3. Access cloud metadata services (169.254.169.254)
     * 4. Bypass firewalls
     * 5. Perform port scanning
     */
    public function vulnerable(Request $request)
    {
        $url = $request->input('url', '');
        $result = null;
        $error = null;

        if ($request->isMethod('post') && $url) {
            try {
                // VULNERABILITY: No URL validation!
                // Attacker can make requests to any URL including:
                // - http://localhost/admin
                // - http://127.0.0.1:22
                // - http://169.254.169.254/latest/meta-data/ (AWS metadata)
                // - http://internal-service.local/
                // - file:///etc/passwd
                
                $response = Http::timeout(5)->get($url);
                
                $result = [
                    'status' => $response->status(),
                    'headers' => $response->headers(),
                    'body' => substr($response->body(), 0, 2000), // Limit response size
                    'url_requested' => $url,
                ];
            } catch (\Exception $e) {
                $error = "Error: " . $e->getMessage();
            }
        }

        // Dangerous URL examples for demonstration
        $dangerousUrls = [
            'http://localhost/admin' => 'Access local admin panel',
            'http://127.0.0.1:22' => 'Port scan SSH',
            'http://169.254.169.254/latest/meta-data/' => 'AWS metadata (credentials!)',
            'http://192.168.1.1/' => 'Access router admin',
            'file:///etc/passwd' => 'Read local files (if supported)',
            'http://internal-api.local/users' => 'Access internal APIs',
        ];

        return view('vulnerabilities.a10.vulnerable', [
            'url' => $url,
            'result' => $result,
            'error' => $error,
            'dangerousUrls' => $dangerousUrls,
        ]);
    }

    /**
     * SECURE: SSRF protection with URL validation
     * 
     * Security measures:
     * 1. Allowlist of permitted domains
     * 2. Block private/internal IP ranges
     * 3. Block localhost and loopback addresses
     * 4. Only allow HTTP/HTTPS protocols
     * 5. DNS rebinding protection
     */
    public function secure(Request $request)
    {
        $url = $request->input('url', '');
        $result = null;
        $error = null;
        $validationDetails = [];

        // SECURE: Allowlist of permitted domains
        $allowedDomains = [
            'httpbin.org',
            'jsonplaceholder.typicode.com',
            'api.github.com',
        ];

        if ($request->isMethod('post') && $url) {
            // SECURE: Parse and validate URL
            $parsedUrl = parse_url($url);
            
            // Check 1: Only allow HTTP/HTTPS
            if (!isset($parsedUrl['scheme']) || !in_array($parsedUrl['scheme'], ['http', 'https'])) {
                $error = "Only HTTP and HTTPS protocols are allowed.";
                $validationDetails[] = "❌ Invalid protocol";
            }
            
            // Check 2: Must have a host
            if (!isset($parsedUrl['host'])) {
                $error = "Invalid URL - no host specified.";
                $validationDetails[] = "❌ No host in URL";
            }
            
            if (!$error) {
                $host = $parsedUrl['host'];
                
                // Check 3: Block localhost and loopback
                if (in_array($host, ['localhost', '127.0.0.1', '::1', '0.0.0.0'])) {
                    $error = "Localhost addresses are not allowed.";
                    $validationDetails[] = "❌ Localhost blocked";
                }
                
                // Check 4: Resolve hostname and check for private IPs
                if (!$error) {
                    $ip = gethostbyname($host);
                    
                    if ($this->isPrivateIp($ip)) {
                        $error = "Private/internal IP addresses are not allowed.";
                        $validationDetails[] = "❌ Private IP blocked ($ip)";
                    } else {
                        $validationDetails[] = "✓ IP validation passed ($ip)";
                    }
                }
                
                // Check 5: Domain allowlist
                if (!$error && !in_array($host, $allowedDomains)) {
                    $error = "Domain not in allowlist. Allowed: " . implode(', ', $allowedDomains);
                    $validationDetails[] = "❌ Domain not in allowlist";
                } elseif (!$error) {
                    $validationDetails[] = "✓ Domain in allowlist";
                }
            }

            // If all checks pass, make the request
            if (!$error) {
                try {
                    $response = Http::timeout(5)->get($url);
                    
                    $result = [
                        'status' => $response->status(),
                        'body' => substr($response->body(), 0, 2000),
                        'url_requested' => $url,
                    ];
                    $validationDetails[] = "✓ Request completed successfully";
                } catch (\Exception $e) {
                    $error = "Request failed: " . $e->getMessage();
                }
            }
        }

        return view('vulnerabilities.a10.secure', [
            'url' => $url,
            'result' => $result,
            'error' => $error,
            'validationDetails' => $validationDetails,
            'allowedDomains' => $allowedDomains,
        ]);
    }

    /**
     * Check if an IP address is in a private range
     */
    private function isPrivateIp(string $ip): bool
    {
        // Private IP ranges
        $privateRanges = [
            '10.0.0.0/8',
            '172.16.0.0/12',
            '192.168.0.0/16',
            '127.0.0.0/8',
            '169.254.0.0/16', // Link-local and AWS metadata
            '0.0.0.0/8',
        ];

        $ipLong = ip2long($ip);
        
        if ($ipLong === false) {
            return true; // Invalid IP, treat as private
        }

        foreach ($privateRanges as $range) {
            [$subnet, $mask] = explode('/', $range);
            $subnetLong = ip2long($subnet);
            $maskLong = ~((1 << (32 - $mask)) - 1);
            
            if (($ipLong & $maskLong) === ($subnetLong & $maskLong)) {
                return true;
            }
        }

        return false;
    }
}
