<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Public
 * 📂 Physical File:   public/index.php
 * 
 * 📝 Description:
 * MAIN FRONT CONTROLLER.
 * "The Porter": Receives all requests and decides who to call.
 * 
 * 🔗 Dependencies:
 * - Vendor\Autoload (via vendor/autoload.php)
 * - Arcadia\Database\Connection (via database/connection.php)
 * - Arcadia\Includes\Functions (via includes/functions.php)
 * - Arcadia\App\Router (via App/router.php)
 */

// 0. Configure secure session cookies BEFORE starting session
// This makes session cookies more secure against attacks
session_set_cookie_params([
    'lifetime' => 0,                           // Cookie expira al cerrar navegador (sesión temporal)
    'path' => '/',                             // Cookie válida en todo el sitio
    'secure' => isset($_SERVER['HTTPS']),      // Solo HTTPS en producción (true si hay HTTPS)
    'httponly' => true,                        // JavaScript cannot access (prevents XSS cookie theft)
    'samesite' => 'Lax'                        // Protección CSRF adicional (Lax permite links externos, Strict no)
]);
// Note: 'Lax' allows you to arrive at the site from an external link with your session.
// 'Strict' would be more secure but would log you out when coming from another site.

// 1. Load required dependencies
require_once __DIR__ . '/../vendor/autoload.php';      // Load Composer libraries
require_once __DIR__ . '/../database/connection.php';  // Load database connection and config
require_once __DIR__ . '/../includes/functions.php';   // Load helper functions

// 1. Extract the path from the requested URL
$parsedUrl = parse_url($_SERVER['REQUEST_URI']);
$path = ltrim($parsedUrl['path'] ?? '', '/');

// 2. Serve static files from different locations
// Determine full path based on requested path
$fullPath = null;

if (strpos($path, 'src/') === 0 || strpos($path, 'node_modules/') === 0) {
    // Files outside public (src/, node_modules/)
    $fullPath = __DIR__ . '/../' . $path;
} elseif (strpos($path, 'public/') === 0) {
    // Explicit public/ prefix
    $fullPath = __DIR__ . '/../' . $path;
} elseif (strpos($path, 'build/') === 0) {
    // Build assets (inside public/)
    $fullPath = __DIR__ . '/' . $path;
}

if ($fullPath && file_exists($fullPath) && is_file($fullPath)) {
    // Set MIME type
    $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
    $mimes = [
        'css' => 'text/css', 'js' => 'application/javascript',
        'png' => 'image/png', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg',
        'gif' => 'image/gif', 'webp' => 'image/webp', 'svg' => 'image/svg+xml',
        'ttf' => 'font/ttf', 'woff' => 'font/woff', 'woff2' => 'font/woff2',
        'eot' => 'application/vnd.ms-fontobject'
    ];
    
    if (isset($mimes[$ext])) {
        header('Content-Type: ' . $mimes[$ext]);
    }
    
    readfile($fullPath);
    exit;
}

// 3. Check if the path corresponds to a real file inside the public directory
// If it exists, serve it directly without passing through the router
$publicFilePath = __DIR__ . '/' . $path;
if (file_exists($publicFilePath) && is_file($publicFilePath)) {
    readfile($publicFilePath);
    exit;
}

// 4. If it's not a file, interpret it as a "nice URL" and parse the segments
$parts = explode('/', $path);

// 5. Assign URL segments to GET parameters for the router
$_GET['domain'] = !empty($parts[0]) ? $parts[0] : 'home';
$_GET['controller'] = !empty($parts[1]) ? $parts[1] : 'pages';
$_GET['action'] = !empty($parts[2]) ? $parts[2] : 'index';

// 6. Load and execute the main router
require_once __DIR__ . '/../App/router.php';
?>
