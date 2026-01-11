<?php
/**
 * Simple router for the application
 */

// Start session
session_start();

// Load configuration
$config = require __DIR__ . '/../config/app.php';

// Autoload classes
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../app/Controllers/',
        __DIR__ . '/../app/Models/',
        __DIR__ . '/../app/Middleware/',
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});

// Get the route from the URL
$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = $_SERVER['SCRIPT_NAME'];
$basePath = dirname($scriptName);

// Remove base path and query string
$route = str_replace($basePath, '', $requestUri);
$route = parse_url($route, PHP_URL_PATH);
$route = rtrim($route, '/');
$route = $route ?: '/';

// Route mapping
$routes = [
    '/' => ['AuthController', 'login'],
    '/login' => ['AuthController', 'login'],
    '/login-process' => ['AuthController', 'processLogin'],
    '/logout' => ['AuthController', 'logout'],
    '/dashboard' => ['DashboardController', 'index'],
    
    // A01: Broken Access Control
    '/a01/vulnerable/admin' => ['A01Controller', 'vulnerableAdmin'],
    '/a01/secure/admin' => ['A01Controller', 'secureAdmin'],
    
    // A02: Cryptographic Failures
    '/a02/vulnerable' => ['A02Controller', 'vulnerable'],
    '/a02/secure' => ['A02Controller', 'secure'],
    
    // A03: Injection
    '/a03/vulnerable' => ['A03Controller', 'vulnerable'],
    '/a03/secure' => ['A03Controller', 'secure'],
    
    // A04: Insecure Design
    '/a04/vulnerable' => ['A04Controller', 'vulnerable'],
    '/a04/secure' => ['A04Controller', 'secure'],
    
    // A05: Security Misconfiguration
    '/a05/vulnerable' => ['A05Controller', 'vulnerable'],
    '/a05/secure' => ['A05Controller', 'secure'],
    
    // A06: Vulnerable Components
    '/a06/vulnerable' => ['A06Controller', 'vulnerable'],
    '/a06/secure' => ['A06Controller', 'secure'],
    
    // A07: Authentication Failures
    '/a07/vulnerable' => ['A07Controller', 'vulnerable'],
    '/a07/secure' => ['A07Controller', 'secure'],
    
    // A08: Data Integrity Failures
    '/a08/vulnerable' => ['A08Controller', 'vulnerable'],
    '/a08/secure' => ['A08Controller', 'secure'],
    
    // A09: Logging Failures
    '/a09/vulnerable' => ['A09Controller', 'vulnerable'],
    '/a09/secure' => ['A09Controller', 'secure'],
    
    // A10: SSRF
    '/a10/vulnerable' => ['A10Controller', 'vulnerable'],
    '/a10/secure' => ['A10Controller', 'secure'],
];

// Handle route
if (isset($routes[$route])) {
    list($controllerName, $method) = $routes[$route];
    
    if (class_exists($controllerName) && method_exists($controllerName, $method)) {
        $controller = new $controllerName();
        $controller->$method();
    } else {
        http_response_code(404);
        die("Controller or method not found: $controllerName::$method");
    }
} else {
    http_response_code(404);
    die("Route not found: $route");
}
