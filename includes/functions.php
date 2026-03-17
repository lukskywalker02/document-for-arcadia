<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Includes
 * 📂 Physical File:   includes/functions.php
 * 
 * 📝 Description:
 * Collection of global utility functions.
 * Helpers for routes, views and shared logic.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Includes\Templates\{Name} (via includes/templates/{name}.php)
 * - Arcadia\Includes\Layouts\FC_main_layout (via includes/layouts/FC_main_layout.php)
 * - Arcadia\Includes\Layouts\BO_main_layout (via includes/layouts/BO_main_layout.php)
 * - Arcadia\{Domain}\Controllers\{Controller} (via App/{domain}/controllers/{controller}.php)
 * - Arcadia\Schedules\Models\Schedule (via App/schedules/models/schedule.php)
 */

define("TEMPLATES_URL", __DIR__ . "/templates");
define("FUNCTIONS_URL", __DIR__ . "functions.php");


function includeTemplate(string  $nombre)
{
    include TEMPLATES_URL . "/{$nombre}.php";
}

if (!function_exists('get_row_class')) {

    function get_row_class(int $rowNumber): string
    {
        return ($rowNumber % 2 == 0) ? 'table-warning' : 'table-primary';
    }

    function get_cell_border_class(int $rowNumber): string
    {
        return ($rowNumber % 2 == 0) ? 'border border-start-5 border-top-0 border-bottom-0 border-end-5 border-primary' : 'border border-start-5 border-top-0 border-bottom-0 border-end-5 border-primary';
    }
}
// includes/functions.php


function handleDomainRouting($domainName, $basePath)
{
    $controller = $_GET['controller'] ?? 'pages';
    $action = $_GET['action'] ?? 'start';

    // Convert action with hyphens to camelCase (e.g., "forgot-password" -> "forgotPassword")
    // This allows us to use nice URLs while keeping valid PHP method names
    $action = str_replace('-', '', ucwords($action, '-'));
    $action = lcfirst($action); // Make first letter lowercase (camelCase)

    // Exemple of file name due to...(exemple) : employees_pages_controller.php
    // Exemple of class name due to...(exemple): EmployeesPagesController
    $controllerFileName = $domainName . "_" . $controller . "_controller.php";
    $controllerClassName = ucfirst($domainName) . ucfirst($controller) . "Controller";

    $controllerFile = $basePath . "/controllers/" . $controllerFileName;

    if (file_exists($controllerFile)) {
        require_once $controllerFile;

        // Check if the controller class exists
        if (!class_exists($controllerClassName)) {
            http_response_code(404);
            echo "Error: Controller class '$controllerClassName' not found.";
            exit();
        }

        $controllerInstance = new $controllerClassName();
        
        // Check if the action method exists
        if (!method_exists($controllerInstance, $action)) {
            // If it's animals/pages domain and action doesn't exist, redirect to allanimals
            if ($domainName === 'animals' && $controller === 'pages') {
                header('Location: /animals/pages/allanimals');
                exit();
            }
            // Otherwise show 404 error
            http_response_code(404);
            echo "Error 404: Page not found. The action '$action' does not exist in the controller.";
            exit();
        }

        ob_start();
        $controllerInstance->$action();
        $viewContent = ob_get_clean();

        // DEBUG EXTREME
        // echo "<!-- DEBUG FUNCTIONS: Received domain: '$domainName' -->";

        // IMPROVED LAYOUT SELECTION LOGIC:
        // Domain map -> public actions (empty = all)
        // Note: Actions are already converted to camelCase above, but we compare in lowercase
        $public_layout_map = [
            "home"      => ["index"],
            "about"     => ["about"],
            "habitats"  => ["habitats", "habitat1"],
            "animals"   => ["allanimals", "animalpicked"],
            "cms"       => ["cms"],
            "contact"   => ["contact", "submit"], // Public actions for contact form
            "auth"      => ["login"],
            "testimonials" => ["create"] // Public action for creating testimonials
        ];

        $domainKey = strtolower($domainName);
        $actionKey = strtolower($action);

        $usePublicLayout = false;
        if (isset($public_layout_map[$domainKey])) {
            $allowedActions = $public_layout_map[$domainKey];
                $usePublicLayout = empty($allowedActions) || in_array($actionKey, $allowedActions, true);
            }

        if ($usePublicLayout) {
            require __DIR__ . "/layouts/FC_main_layout.php";
        } else {
            require __DIR__ . "/layouts/BO_main_layout.php";
        }
    } else {
        http_response_code(404);
        header('Location: /public/error-404.php');
        exit();
    }
}


// function to get opening hours globally
function getOpeningHours() {
    // We require the model if it is not loaded (using absolute safe path)
    require_once __DIR__ . '/../App/schedules/models/schedule.php';
    
    $scheduleModel = new Schedule();
    return $scheduleModel->getAll();
}

// Generates Cloudinary URLs with transformations
function getCloudinaryUrl($baseUrl, $transformations) {
    if (!$baseUrl) return '';
    
    // Find the position of '/upload/'
    $uploadPos = strpos($baseUrl, '/upload/');
    if ($uploadPos === false) return $baseUrl; // Not a valid Cloudinary URL

    // The part before /upload/
    $base = substr($baseUrl, 0, $uploadPos);
    
    // The part after /upload/ (version and image name)
    $imagePath = substr($baseUrl, $uploadPos + strlen('/upload/'));

    // Reconstruct the URL correctly
    return $base . '/upload/' . $transformations . '/' . $imagePath;
}
 
/**
 * Check if the current user has a specific permission
 * @param string $permissionName The permission name to check (e.g., 'users-view', 'animals-create')
 * @return bool True if user has the permission, false otherwise
 */
if (!function_exists('hasPermission')) {
    function hasPermission($permissionName) {
        // If user is not logged in, they have no permissions
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            return false;
        }
        
        // Get user permissions from session
        $userPermissions = $_SESSION["user"]["permissions"] ?? [];
        
        // Check if the permission exists in the user's permissions array
        return in_array($permissionName, $userPermissions);
    }
}