<?php
/**
 * A10: Server-Side Request Forgery (SSRF)
 */

class A10Controller extends BaseController {
    public function __construct() {
        require_once __DIR__ . '/../Middleware/AuthMiddleware.php';
        AuthMiddleware::requireAuth();
    }

    /**
     * VULNERABLE: Server fetches any user-supplied URL
     */
    public function vulnerable() {
        $result = null;
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['url'])) {
            $url = $_POST['url'] ?? '';
            
            if (!empty($url)) {
                // VULNERABILITY: Fetching any URL without validation
                // Can be used to access internal resources, localhost, etc.
                
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $errorCode = curl_errno($ch);
                curl_close($ch);
                
                if ($errorCode === 0) {
                    $result = [
                        'url' => $url,
                        'http_code' => $httpCode,
                        'content' => substr($response, 0, 500), // Limit display
                        'content_length' => strlen($response)
                    ];
                } else {
                    $error = "Error fetching URL: " . curl_strerror($errorCode);
                }
            }
        }

        $this->render('a10/vulnerable', [
            'result' => $result,
            'error' => $error
        ]);
    }

    /**
     * SECURE: Domain allowlist, blocked internal IP ranges
     */
    public function secure() {
        $result = null;
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['url'])) {
            $url = $_POST['url'] ?? '';
            
            if (!empty($url)) {
                // SECURE: Validate URL and parse components
                $parsedUrl = parse_url($url);
                
                if (!$parsedUrl || !isset($parsedUrl['host'])) {
                    $error = "Invalid URL format";
                } else {
                    $host = $parsedUrl['host'];
                    
                    // SECURE: Domain allowlist
                    $allowedDomains = ['example.com', 'httpbin.org', 'jsonplaceholder.typicode.com'];
                    $isAllowed = false;
                    
                    foreach ($allowedDomains as $allowedDomain) {
                        if ($host === $allowedDomain || substr($host, -strlen('.' . $allowedDomain)) === '.' . $allowedDomain) {
                            $isAllowed = true;
                            break;
                        }
                    }
                    
                    if (!$isAllowed) {
                        $error = "Domain not allowed. Only allowed domains can be accessed.";
                    } else {
                        // SECURE: Resolve IP and check for internal ranges
                        $ip = gethostbyname($host);
                        
                        // SECURE: Block internal/private IP ranges
                        $isInternal = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
                        
                        if ($isInternal === false) {
                            $error = "Access to internal IP addresses is not allowed.";
                        } else {
                            // SECURE: Only allow HTTP/HTTPS
                            $scheme = $parsedUrl['scheme'] ?? 'http';
                            if (!in_array($scheme, ['http', 'https'])) {
                                $error = "Only HTTP and HTTPS protocols are allowed.";
                            } else {
                                // Fetch the URL
                                $ch = curl_init($url);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); // Don't follow redirects
                                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                                curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
                                curl_setopt($ch, CURLOPT_REDIR_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
                                
                                $response = curl_exec($ch);
                                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                $errorCode = curl_errno($ch);
                                curl_close($ch);
                                
                                if ($errorCode === 0) {
                                    $result = [
                                        'url' => $url,
                                        'http_code' => $httpCode,
                                        'content' => substr($response, 0, 500),
                                        'content_length' => strlen($response)
                                    ];
                                } else {
                                    $error = "Error fetching URL: " . curl_strerror($errorCode);
                                }
                            }
                        }
                    }
                }
            }
        }

        $this->render('a10/secure', [
            'result' => $result,
            'error' => $error
        ]);
    }
}
