<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Contact
 * 📂 Physical File:   App/contact/contactRouter.php
 * 
 * 📝 Description:
 * Router for the Contact domain.
 * Handles incoming requests and delegates to the appropriate controller.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Includes\Functions (via includes/functions.php)
 * - Arcadia\Includes\Layouts\BO_main_layout (via includes/layouts/BO_main_layout.php)
 * - Arcadia\Contact\Controllers\ContactGestController (via App/contact/controllers/contact_gest_controller.php)
 */

require_once __DIR__ . '/../../includes/functions.php';

// Check if the URL is requesting 'gest' controller (back office)
$controller = $_GET['controller'] ?? 'pages';

if ($controller === 'gest') {
    // Manual routing for Contact Forms Management (BackOffice)
    require_once __DIR__ . '/controllers/contact_gest_controller.php';

    $action = $_GET['action'] ?? 'start';
    // Convert action with hyphens to camelCase
    $action = str_replace('-', '', ucwords($action, '-'));
    $action = lcfirst($action);
    
    $controllerInstance = new ContactGestController();

    if (method_exists($controllerInstance, $action)) {
        // Capture view and load layout (BackOffice)
        ob_start();
        $controllerInstance->$action();
        $viewContent = ob_get_clean();

        $domain = 'contact'; // Context for menu
        require __DIR__ . "/../../includes/layouts/BO_main_layout.php";
    } else {
        echo "Error: Action '$action' not found in ContactGestController.";
    }
} else {
    // Public Pages (contact form)
    handleDomainRouting('contact', __DIR__);
}
