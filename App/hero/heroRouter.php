<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Hero
 * 📂 Physical File:   App/hero/heroRouter.php
 */

require_once __DIR__ . '/../../includes/functions.php';

// Check if the URL is requesting 'slides' controller
$controller = $_GET['controller'] ?? 'gest';

if ($controller === 'slides') {
    // Manual routing for Slides within Hero domain
    // WE MUST MIMIC handleDomainRouting LOGIC TO INCLUDE LAYOUTS!
    
    require_once __DIR__ . '/controllers/slides_gest_controller.php';
    
    $action = $_GET['action'] ?? 'create'; // Default action
    $controllerInstance = new SlidesGestController();
    
    if (method_exists($controllerInstance, $action)) {
        // 1. Capture View Content
        ob_start();
        $controllerInstance->$action();
        $viewContent = ob_get_clean();

        // 2. Load Layout (BackOffice)
        // We assume slides management is always BackOffice
        $domain = 'hero'; // Context for menu active state
        require __DIR__ . "/../../includes/layouts/BO_main_layout.php";

    } else {
        echo "Error: Action '$action' not found in SlidesGestController.";
    }
} else {
    // Default Hero routing (uses standard function)
    handleDomainRouting('hero', __DIR__);
}
