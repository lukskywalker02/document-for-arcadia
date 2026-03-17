<?php

/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\CMS
 * 📂 Physical File:   App/cms/cmsRouter.php
 * 
 * 📝 Description:
 * Router for the Cms domain.
 * Handles incoming requests and delegates to the appropriate controller.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Includes\Functions (via includes/functions.php)
 * - Arcadia\CMS\Controllers\BricksGestController (via App/cms/controllers/bricks_gest_controller.php)
 * - Arcadia\Includes\Layouts\BO_main_layout (via includes/layouts/BO_main_layout.php)
 */

require_once __DIR__ . '/../../includes/functions.php';

// Check if the URL is requesting 'bricks' controller
$controller = $_GET['controller'] ?? 'pages';

if ($controller === 'bricks') {
    // Manual routing for Bricks within CMS domain
    require_once __DIR__ . '/controllers/bricks_gest_controller.php';

    $action = $_GET['action'] ?? 'start';
    $controllerInstance = new BricksGestController();

    if (method_exists($controllerInstance, $action)) {
        // Capture view and load layout (BackOffice)
        ob_start();
        $controllerInstance->$action();
        $viewContent = ob_get_clean();

        $domain = 'cms'; // Context for menu
        require __DIR__ . "/../../includes/layouts/BO_main_layout.php";
    } else {
        echo "Error: Action '$action' not found in BricksGestController.";
    }
} elseif ($controller === 'gest') {
    // CMS Services Management
    handleDomainRouting('cms', __DIR__);
} else {
    // Public Pages
    handleDomainRouting('cms', __DIR__);
}
