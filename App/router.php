<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\App
 * 📂 Physical File:   App/router.php
 * 
 * 📝 Description:
 * CENTRAL ROUTER ("The Guard").
 * Validates permissions, sessions and dispatches to Domain Routers.
 * 
 * 🔗 Dependencies:
 * - Arcadia\{Domain}\{Domain}Router (via App/{domain}/{domain}Router.php)
 */

session_start();

// 1. Disable browser cache to prevent update issues
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$domain = $_GET["domain"] ?? "home";

// 2. Define public domains that do not require authentication
$public_domains = ["auth", "contact", "home", "about", "habitats", "animals", "cms", "testimonials"];

// 2.1 Check session expiration (11 hours = 39600 seconds)
// If the session is older, we destroy it and redirect to login
if (isset($_SESSION["user"]["username"])) {
    $sessionTimeout = 39600; // 11 hours in seconds
    $lastActivity = $_SESSION["last_activity"] ?? time();
    
    if (time() - $lastActivity > $sessionTimeout) {
        // Session expired: destroy it completely
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header("Location: /auth/pages/login?msg=session_expired");
        exit();
    } else {
        // Update last activity time
        $_SESSION["last_activity"] = time();
    }
    
    // Additional verification: validate session data integrity
    if (!isset($_SESSION["user"]["id_user"]) || !isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        // Invalid session data: destroy it
        $_SESSION = array();
        session_destroy();
        header("Location: /auth/pages/login?msg=invalid_session");
        exit();
    }
}

// 3. Main security check
// If there is no authenticated user and the domain is not public, redirect to login
if (!isset($_SESSION["user"]["username"]) && !in_array($domain, $public_domains)) {
    // we redirect to login!.
    header("Location: /auth/pages/login");
    exit();
}

// 3.1 Specific protection for Dashboard (/home/pages/start)
// Although "home" is public for the main page, the "start" action requires authentication
if ($domain === "home" && $_GET["action"] === "start" && !isset($_SESSION["user"]["username"])) {
    //we'll redirect to login page.
    header("Location: /auth/pages/login");
    exit();
}

// 3.2 Global protection for management controllers (/gest/)
// Any access to a "gest" controller requires authentication, even in public domains
$controller = $_GET['controller'] ?? '';
if ($controller === 'gest' && !isset($_SESSION["user"]["username"])) {
    header("Location: /auth/pages/login");
    exit();
}

// 3.3 Protection for private routes within "animals" domain
// The "feeding" and "gest" controllers require authentication
if ($domain === "animals") {
    $controller = $_GET['controller'] ?? '';
    if (in_array($controller, ['feeding', 'gest']) && !isset($_SESSION["user"]["username"])) {
        header("Location: /auth/pages/login");
        exit();
    }
}

// 3.4 Protection for private routes within "habitats" domain
// The "gest" and "suggestion" controllers require authentication
if ($domain === "habitats") {
    $controller = $_GET['controller'] ?? '';
    if (in_array($controller, ['gest', 'suggestion']) && !isset($_SESSION["user"]["username"])) {
        header("Location: /auth/pages/login");
        exit();
    }
}

// 4. Inverse check: already authenticated users
// If an authenticated user tries to access login, redirect to dashboard
// This prevents infinite loops and improves user experience
if (isset($_SESSION["user"]["username"]) && $domain === "auth" && $_GET["action"] === "login") {
    header("Location: /home/pages/start");
    exit();
}

// 5. Whitelist of allowed domains
// Only domains in this list can be processed. Any other will be rejected
$allowed_domains = ["hero", "medias", "habitat1", "cms", "about", "auth", "home", "animals", "employees", "habitats", "permissions", "reports", "roles", "schedules", "testimonials", "users", "contact", "vreports"];

if (in_array($domain, $allowed_domains)) {
    // Domain is valid: load its corresponding router
    $domainRouterPath = __DIR__ . "/{$domain}/{$domain}Router.php";

    if (file_exists($domainRouterPath)) {
        require_once $domainRouterPath;
    } else {
        // ERROR 500: Domain is in the list but its router file does not exist
        // This is a programming error, not a user error
        http_response_code(500); 
        header('Location: /public/error-500.php');
        exit();
    }
} else {
    // ERROR 404: The requested domain does not exist in our list
    http_response_code(404);
    header('Location: /public/error-404.php');
    exit();
}

?>


