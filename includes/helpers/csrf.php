<?php
/**
 * CSRF Protection Helper
 * 
 * Protects against Cross-Site Request Forgery (CSRF) attacks.
 * A CSRF attack occurs when a malicious website sends requests to your site
 * using the user's active session (their cookies).
 * 
 * This helper generates unique tokens that only your form can include,
 * blocking requests that come from other sites.
 */

// Ensure session is started
// If already active (by router.php), does nothing
if (session_status() !== PHP_SESSION_ACTIVE) { 
    session_start(); 
}

/**
 * Generates or retrieves a CSRF token for a specific key
 * 
 * @param string $key Unique identifier for the form/action (e.g., 'login_form', 'delete_user')
 * @return string The CSRF token (64 hexadecimal characters)
 * 
 * How it works:
 * 1. Generates a random 32-byte token (bin2hex converts it to 64 hex chars)
 * 2. Stores it in $_SESSION with an expiration time (2 hours)
 * 3. If it already exists and has not expired, reuses the same one
 */
function csrf_get_token(string $key = 'global'): string {
    // Initialize the token array if it doesn't exist
    if (!isset($_SESSION['csrf'])) {
        $_SESSION['csrf'] = [];
    }
    
    // If no token exists for this key OR it has expired, generate a new one
    if (empty($_SESSION['csrf'][$key]['value']) || $_SESSION['csrf'][$key]['expires'] < time()) {
        $_SESSION['csrf'][$key] = [
            'value' => bin2hex(random_bytes(32)), // Random 64-character token
            'expires' => time() + 7200 // Expires in 2 hours (7200 seconds)
        ];
    }
    
    return $_SESSION['csrf'][$key]['value'];
}

/**
 * Generates a hidden HTML field with the CSRF token
 * 
 * @param string $key Unique identifier for the form
 * @return string HTML: <input type="hidden" name="_csrf" value="...">
 * 
 * Usage in views:
 * <form method="POST">
 *     <?= csrf_field('login_form') ?>
 *     <!-- rest of the form -->
 * </form>
 */
function csrf_field(string $key = 'global'): string {
    $token = csrf_get_token($key);
    // htmlspecialchars prevents XSS if the token was tampered with
    return '<input type="hidden" name="_csrf" value="'.htmlspecialchars($token, ENT_QUOTES, 'UTF-8').'">';
}

/**
 * Verifies that the received CSRF token is valid
 * 
 * @param string $key Identifier of the form to verify
 * @param string|null $token Token to verify (if null, looks for it in $_POST['_csrf'] or HTTP_X_CSRF_TOKEN header)
 * @return bool true if the token is valid, false otherwise
 * 
 * Checks:
 * 1. That a token exists stored in session for this key
 * 2. That it has not expired
 * 3. That the received token matches EXACTLY with the stored one (hash_equals prevents timing attacks)
 * 
 * Usage in controllers:
 * if (!csrf_verify('login_form')) {
 *     die('Invalid CSRF token');
 * }
 */
function csrf_verify(string $key = 'global', ?string $token = null): bool {
    // If no token stored in session, fail
    if (!isset($_SESSION['csrf'][$key])) {
        return false;
    }
    
    // If token expired, fail
    if ($_SESSION['csrf'][$key]['expires'] < time()) {
        return false;
    }
    
    // If token not passed explicitly, look for it in POST or header (for AJAX)
    if ($token === null) {
        $token = $_POST['_csrf'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');
    }
    
    // Compare tokens using hash_equals (prevents timing attacks)
    // hash_equals compares in constant time, preventing an attacker
    // from deducing the correct token by measuring response time
    return hash_equals($_SESSION['csrf'][$key]['value'], (string)$token);
}

/**
 * Invalidates a CSRF token (removes it from the session)
 * 
 * @param string $key Identifier of the token to invalidate
 * @return void
 * 
 * Usage: after processing a critical form (one-time use)
 * csrf_invalidate('delete_user'); // The token can no longer be reused
 * 
 * This makes the token single-use, increasing security
 * for critical actions like deleting data or changing passwords.
 */
function csrf_invalidate(string $key = 'global'): void {
    if (isset($_SESSION['csrf'][$key])) {
        unset($_SESSION['csrf'][$key]);
    }
}

