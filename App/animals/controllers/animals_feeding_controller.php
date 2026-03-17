<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Animals\Controllers
 * 📂 Physical File:   App/animals/controllers/animals_feeding_controller.php
 * 
 * 📝 Description:
 * Controller for managing feeding logs (feeding records).
 * Handles creation, listing, and management of animal feeding events.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Animals\Models\FeedingLog (via App/animals/models/feedingLog.php)
 * - Arcadia\Animals\Models\AnimalFull (via App/animals/models/animalFull.php)
 * - Arcadia\Animals\Models\Nutrition (via App/animals/models/nutrition.php)
 * - Arcadia\Includes\Functions (via includes/functions.php)
 */

require_once __DIR__ . "/../models/feedingLog.php";
require_once __DIR__ . "/../models/animalFull.php";
require_once __DIR__ . "/../models/nutrition.php";
require_once __DIR__ . "/../../../includes/functions.php";
require_once __DIR__ . "/../../../includes/helpers/csrf.php";

class AnimalsFeedingController
{
    /**
     * Dashboard: List all feeding logs
     */
    public function start()
    {
        $feedingModel = new FeedingLog();
        $animalModel = new AnimalFull();
        
        $feedings = $feedingModel->getAll();
        $animals = $animalModel->getAll();
        
        if (file_exists(__DIR__ . '/../views/feeding/start.php')) {
            include_once __DIR__ . '/../views/feeding/start.php';
        } else {
            echo "Error: View file not found at " . __DIR__ . '/../views/feeding/start.php';
        }
    }

    /**
     * Show form to create a new feeding log
     * Only users with animal_feeding-assign permission can create feeding logs
     */
    public function create()
    {
        // Check if user has permission to create
        if (!hasPermission('animal_feeding-assign')) {
            header('Location: /animals/feeding/start?msg=error&error=You do not have permission to create feeding logs');
            exit;
        }

        $animalModel = new AnimalFull();
        $animals = $animalModel->getAll();
        
        // Get user ID from session (employee who will feed)
        $userId = $_SESSION['user']['id_user'] ?? null;
        
        if (file_exists(__DIR__ . '/../views/feeding/create.php')) {
            include_once __DIR__ . '/../views/feeding/create.php';
        } else {
            echo "Error: View file not found at " . __DIR__ . '/../views/feeding/create.php';
        }
    }

    /**
     * Save feeding log (create new record)
     * Only users with animal_feeding-assign permission can save feeding logs
     */
    public function save()
    {
        // Check if user has permission to create
        if (!hasPermission('animal_feeding-assign')) {
            header('Location: /animals/feeding/start?msg=error&error=You do not have permission to create feeding logs');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /animals/feeding/start?msg=error&error=Invalid request method');
            exit;
        }

        // Verify CSRF token
        if (!csrf_verify('feeding_save')) {
            header('Location: /animals/feeding/create?msg=error&error=Invalid request. Please try again.');
            exit;
        }

        $animalFullId = $_POST['animal_f_id'] ?? null;
        $foodType = $_POST['food_type'] ?? null;
        $foodQty = $_POST['food_qtty'] ?? null;
        $foodDate = $_POST['food_date'] ?? null;
        
        // Get user ID from session (employee who fed)
        $userId = $_SESSION['user']['id_user'] ?? null;
        
        // Validate user ID is present (required for tracking who fed the animal)
        if ($userId === null) {
            error_log("Error: user_id is null when creating feeding log. Session user data: " . print_r($_SESSION['user'] ?? [], true));
            header('Location: /animals/feeding/create?msg=error&error=User session error. Please log in again.');
            exit;
        }

        // Validation
        if (!$animalFullId || !$foodType || !$foodQty) {
            header('Location: /animals/feeding/create?msg=error&error=All required fields must be filled');
            exit;
        }

        // Validate food_type enum
        $allowedFoodTypes = ['meat', 'fruit', 'legumes', 'insect'];
        if (!in_array($foodType, $allowedFoodTypes)) {
            header('Location: /animals/feeding/create?msg=error&error=Invalid food type');
            exit;
        }

        // Validate quantity (must be positive)
        $foodQty = (int)$foodQty;
        if ($foodQty <= 0) {
            header('Location: /animals/feeding/create?msg=error&error=Food quantity must be greater than 0');
            exit;
        }

        $feedingModel = new FeedingLog();
        $result = $feedingModel->create($animalFullId, $foodType, $foodQty, $userId, $foodDate);

        if ($result) {
            header('Location: /animals/feeding/start?msg=saved');
        } else {
            header('Location: /animals/feeding/create?msg=error&error=Failed to save feeding log');
        }
        exit;
    }

    /**
     * View feeding logs for a specific animal
     */
    public function view()
    {
        $animalFullId = $_GET['animal_id'] ?? null;
        
        if (!$animalFullId) {
            header('Location: /animals/feeding/start?msg=error&error=Animal ID is required');
            exit;
        }

        $feedingModel = new FeedingLog();
        $animalModel = new AnimalFull();
        
        $feedings = $feedingModel->getByAnimalId($animalFullId);
        $animal = $animalModel->getById($animalFullId);
        $lastFeeding = $feedingModel->getLastFeeding($animalFullId);

        if (!$animal) {
            header('Location: /animals/feeding/start?msg=error&error=Animal not found');
            exit;
        }

        if (file_exists(__DIR__ . '/../views/feeding/view.php')) {
            include_once __DIR__ . '/../views/feeding/view.php';
        } else {
            echo "Error: View file not found at " . __DIR__ . '/../views/feeding/view.php';
        }
    }

    /**
     * Delete a feeding log entry
     * Only users with animal_feeding-delete or animal_feeding-assign permission can delete feeding logs
     */
    public function delete()
    {
        // Check if user has permission to delete
        if (!hasPermission('animal_feeding-delete') && !hasPermission('animal_feeding-assign')) {
            header('Location: /animals/feeding/start?msg=error&error=You do not have permission to delete feeding logs');
            exit;
        }

        $id = $_GET['id'] ?? null;
        $animalId = $_GET['animal_id'] ?? null;
        
        if (!$id) {
            header('Location: /animals/feeding/start?msg=error&error=ID is required');
            exit;
        }

        $feedingModel = new FeedingLog();
        $result = $feedingModel->delete($id);

        // Redirect back to view if animal_id is provided, otherwise to start
        if ($result) {
            if ($animalId) {
                header('Location: /animals/feeding/view?animal_id=' . $animalId . '&msg=deleted');
            } else {
                header('Location: /animals/feeding/start?msg=deleted');
            }
        } else {
            if ($animalId) {
                header('Location: /animals/feeding/view?animal_id=' . $animalId . '&msg=error&error=Failed to delete feeding log');
            } else {
                header('Location: /animals/feeding/start?msg=error&error=Failed to delete feeding log');
            }
        }
        exit;
    }
}

