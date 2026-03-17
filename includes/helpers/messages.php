<?php
/**
 * Message Display Helper
 * 
 * Functions to display success/error messages from URL parameters
 * and session variables in a consistent way across the application.
 */

/**
 * Display alert message from URL parameters (msg=error, msg=success)
 * 
 * Usage:
 * <?php require_once __DIR__ . '/../../../../includes/helpers/messages.php'; ?>
 * <?php display_alert_message(); ?>
 * 
 * @param string|null $defaultSuccessMessage Custom success message (optional)
 * @param array|null $customMessages Array of custom messages for specific msg values (e.g., ['saved' => 'Created!', 'updated' => 'Updated!'])
 * @return void Outputs HTML alert
 */
function display_alert_message($defaultSuccessMessage = 'Action completed successfully!', $customMessages = null) {
    if (!isset($_GET['msg'])) {
        return;
    }
    
    $msg = $_GET['msg'];
    
    // Handle error messages
    if ($msg === 'error' && isset($_GET['error'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo htmlspecialchars($_GET['error']);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
        return;
    }
    
    // Handle custom messages (saved, updated, deleted, etc.)
    if ($customMessages && isset($customMessages[$msg])) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        echo htmlspecialchars($customMessages[$msg]);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
        return;
    }
    
    // Handle success messages
    if ($msg === 'success') {
        $message = $_GET['message'] ?? $defaultSuccessMessage;
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        echo htmlspecialchars($message);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
        return;
    }
    
    // Fallback for other msg values (saved, updated, deleted, etc.) - default to success
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
    echo htmlspecialchars($defaultSuccessMessage);
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}

/**
 * Display alert message from session variables
 * 
 * @param string $sessionKey Session key (e.g., 'error_message', 'success_message')
 * @param string $alertType Alert type: 'danger', 'success', 'warning', 'info'
 * @param int $autoHideTime Time in milliseconds to auto-hide (0 = no auto-hide)
 * @return void Outputs HTML alert and unsets the session variable
 */
function display_session_alert($sessionKey, $alertType = 'danger', $autoHideTime = 0) {
    if (isset($_SESSION[$sessionKey])) {
        $messageId = 'alert-' . uniqid();
        echo '<div id="' . htmlspecialchars($messageId) . '" class="alert alert-' . htmlspecialchars($alertType) . ' alert-dismissible fade show" role="alert">';
        echo htmlspecialchars($_SESSION[$sessionKey]);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
        
        if ($autoHideTime > 0) {
            echo '<script>';
            echo 'setTimeout(function() {';
            echo '  document.getElementById("' . $messageId . '").style.display = "none";';
            echo '}, ' . $autoHideTime . ');';
            echo '</script>';
        }
        
        unset($_SESSION[$sessionKey]);
    }
}

/**
 * Display error message from a variable (legacy support)
 * 
 * @param mixed $error Error variable (string or null)
 * @return void Outputs HTML alert if error exists
 */
function display_error_variable($error) {
    if (isset($error) && $error) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo htmlspecialchars($error);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
    }
}

