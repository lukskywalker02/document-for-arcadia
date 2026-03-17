<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Api
 * 📂 Physical File:   App/api/apiRouter.php
 * 
 * 📝 Description:
 * Router for the API domain.
 * Handles all API requests and delegates to the appropriate API controller.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Api\Helpers\ApiResponse (via App/api/helpers/api_response.php)
 */

require_once __DIR__ . '/helpers/api_response.php';

$controller = $_GET['controller'] ?? '';
$action = $_GET['action'] ?? 'index';

// If no controller specified, return API info
if (empty($controller)) {
    api_response([
        'name' => 'Zoo ARCADIA API',
        'version' => '1.0.0',
        'endpoints' => [
            'GET /api/animals' => 'List all animals',
            'GET /api/animals/{id}' => 'Get animal by ID',
            'GET /api/habitats' => 'List all habitats',
            'GET /api/habitats/{id}' => 'Get habitat by ID',
            'GET /api/services' => 'List all services',
            'GET /api/schedules' => 'Get zoo schedules',
            'GET /api/testimonials' => 'Get validated testimonials'
        ]
    ]);
    exit;
}

// Map controller name to resource router
// Pattern: animals → App/api/animals/animalsRouter.php
$resourceRouterPath = __DIR__ . '/' . $controller . '/' . $controller . 'Router.php';

if (file_exists($resourceRouterPath)) {
    require_once $resourceRouterPath;
} else {
    api_error("Resource '$controller' not found", 404);
}

