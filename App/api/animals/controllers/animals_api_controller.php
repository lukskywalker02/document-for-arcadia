<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Api\Animals\Controllers
 * 📂 Physical File:   App/api/animals/controllers/animals_api_controller.php
 * 
 * 📝 Description:
 * API Controller for Animals.
 * Handles all API requests related to animals.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Animals\Models\AnimalFull (via App/animals/models/animalFull.php)
 * - Arcadia\Api\Helpers\ApiResponse (via App/api/helpers/api_response.php)
 */

require_once __DIR__ . '/../../../animals/models/animalFull.php';
require_once __DIR__ . '/../../helpers/api_response.php';

class AnimalsApiController {
    
    /**
     * GET /api/animals
     * List all animals
     */
    public function index() {
        $animalModel = new AnimalFull();
        $animals = $animalModel->getAll();
        
        // Format the response
        $formatted = array_map(function($animal) {
            return [
                'id' => $animal->id_full_animal ?? null,
                'name' => $animal->animal_name ?? null,
                'gender' => $animal->gender ?? null,
                'species' => $animal->specie_name ?? null,
                'category' => $animal->category_name ?? null,
                'habitat' => $animal->habitat_name ?? null,
                'image' => $animal->media_path ?? null,
                'image_medium' => $animal->media_path_medium ?? null,
                'image_large' => $animal->media_path_large ?? null
            ];
        }, $animals);
        
        api_success($formatted, 'Animals retrieved successfully');
    }
    
    /**
     * GET /api/animals/{id}
     * Get a specific animal by ID
     */
    public function show() {
        $id = $_GET['id'] ?? null;
        
        if (!$id || !is_numeric($id)) {
            api_error('Invalid animal ID', 400);
        }
        
        $animalModel = new AnimalFull();
        $animal = $animalModel->getById($id);
        
        if (!$animal) {
            api_error('Animal not found', 404);
        }
        
        // Format the response
        $formatted = [
            'id' => $animal->id_full_animal ?? null,
            'name' => $animal->animal_name ?? null,
            'gender' => $animal->gender ?? null,
            'species' => $animal->specie_name ?? null,
            'category' => $animal->category_name ?? null,
            'habitat' => $animal->habitat_name ?? null,
            'image' => $animal->media_path ?? null,
            'image_medium' => $animal->media_path_medium ?? null,
            'image_large' => $animal->media_path_large ?? null
        ];
        
        api_success($formatted, 'Animal retrieved successfully');
    }
}

