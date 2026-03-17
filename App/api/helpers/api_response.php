<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Api\Helpers
 * 📂 Physical File:   App/api/helpers/api_response.php
 * 
 * 📝 Description:
 * Helper functions for API responses.
 * Standardizes JSON responses with proper HTTP status codes.
 */

/**
 * Send a successful JSON response
 * 
 * @param mixed $data The data to return
 * @param int $statusCode HTTP status code (default: 200)
 * @return void
 */
function api_response($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

/**
 * Send an error JSON response
 * 
 * @param string $message Error message
 * @param int $statusCode HTTP status code (default: 400)
 * @return void
 */
function api_error($message, $statusCode = 400) {
    http_response_code($statusCode);
    echo json_encode([
        'error' => true,
        'message' => $message
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

/**
 * Send a success JSON response with message
 * 
 * @param mixed $data The data to return
 * @param string $message Success message
 * @param int $statusCode HTTP status code (default: 200)
 * @return void
 */
function api_success($data, $message = null, $statusCode = 200) {
    $response = [
        'success' => true,
        'data' => $data
    ];
    
    if ($message !== null) {
        $response['message'] = $message;
    }
    
    http_response_code($statusCode);
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

