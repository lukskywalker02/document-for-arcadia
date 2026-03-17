<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Api\Animals
 * 📂 Physical File:   App/api/animals/animalsRouter.php
 * 
 * 📝 Description:
 * Router for the Animals API resource.
 * Handles all API requests related to animals.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Api\Helpers\ApiResponse (via App/api/helpers/api_response.php)
 */

require_once __DIR__ . '/../helpers/api_response.php';

$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

// Load the controller
require_once __DIR__ . '/controllers/animals_api_controller.php';

$controllerInstance = new AnimalsApiController();

if (method_exists($controllerInstance, $action)) {
    $controllerInstance->$action();
} else {
    api_error("Action '$action' not found", 404);
}

