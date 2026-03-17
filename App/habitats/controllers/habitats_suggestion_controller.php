<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Habitats\Controllers
 * 📂 Physical File:   App/habitats/controllers/habitats_suggestion_controller.php
 * 
 * 📝 Description:
 * Controller for managing habitat suggestions.
 * Veterinarians can create, edit (pending only), and delete (accepted/rejected only).
 * Admins can review (accept/reject) and delete any suggestion.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Habitats\Models\HabitatSuggestion (via App/habitats/models/habitatSuggestion.php)
 * - Arcadia\Habitats\Models\Habitat (via App/habitats/models/habitat.php)
 */

require_once __DIR__ . "/../models/habitatSuggestion.php";
require_once __DIR__ . "/../models/habitat.php";
require_once __DIR__ . "/../../../includes/helpers/csrf.php";

class HabitatsSuggestionController
{
    /**
     * Dashboard: List suggestions
     * Veterinarians see only their suggestions, Admins see all
     */
    public function start()
    {
        $suggestionModel = new HabitatSuggestion();
        $habitatModel = new Habitat();
        
        $userRoleName = $_SESSION['user']['role_name'] ?? null;
        $userId = $_SESSION['user']['id_user'] ?? null;
        
        // Veterinarians see only their suggestions, Admins see all
        if ($userRoleName === 'Veterinary') {
            $suggestions = $suggestionModel->getByVeterinarian($userId);
        } else {
            $suggestions = $suggestionModel->getAll();
        }
        
        $habitats = $habitatModel->getAll();
        
        if (file_exists(__DIR__ . '/../views/suggestion/start.php')) {
            include_once __DIR__ . '/../views/suggestion/start.php';
        } else {
            echo "Error: View file not found at " . __DIR__ . '/../views/suggestion/start.php';
        }
    }

    /**
     * Show form to create a new suggestion (Veterinarian only)
     */
    public function create()
    {
        $userRoleName = $_SESSION['user']['role_name'] ?? null;
        if ($userRoleName !== 'Veterinary') {
            header('Location: /habitats/suggestion/start?msg=error&error=Only veterinarians can create suggestions');
            exit;
        }

        $habitatModel = new Habitat();
        $habitats = $habitatModel->getAll();
        
        if (file_exists(__DIR__ . '/../views/suggestion/create.php')) {
            include_once __DIR__ . '/../views/suggestion/create.php';
        } else {
            echo "Error: View file not found at " . __DIR__ . '/../views/suggestion/create.php';
        }
    }

    /**
     * Save new suggestion (Veterinarian only)
     */
    public function save()
    {
        $userRoleName = $_SESSION['user']['role_name'] ?? null;
        if ($userRoleName !== 'Veterinary') {
            header('Location: /habitats/suggestion/start?msg=error&error=Only veterinarians can create suggestions');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /habitats/suggestion/start?msg=error&error=Invalid request method');
            exit;
        }

        // Verify CSRF token
        if (!csrf_verify('habitat_suggestion_save')) {
            header('Location: /habitats/suggestion/create?msg=error&error=Invalid request. Please try again.');
            exit;
        }

        $habitatId = $_POST['habitat_id'] ?? null;
        $details = trim($_POST['details'] ?? '');
        $userId = $_SESSION['user']['id_user'] ?? null;

        // Validation
        if (!$habitatId || empty($details)) {
            header('Location: /habitats/suggestion/create?msg=error&error=All required fields must be filled');
            exit;
        }

        $suggestionModel = new HabitatSuggestion();
        $result = $suggestionModel->create($habitatId, $userId, $details);

        if ($result) {
            header('Location: /habitats/suggestion/start?msg=saved');
        } else {
            header('Location: /habitats/suggestion/create?msg=error&error=Failed to save suggestion');
        }
        exit;
    }

    /**
     * Show form to edit a suggestion (Veterinarian only, pending only)
     */
    public function edit()
    {
        $userRoleName = $_SESSION['user']['role_name'] ?? null;
        if ($userRoleName !== 'Veterinary') {
            header('Location: /habitats/suggestion/start?msg=error&error=Only veterinarians can edit suggestions');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /habitats/suggestion/start?msg=error&error=ID is required');
            exit;
        }

        $suggestionModel = new HabitatSuggestion();
        $habitatModel = new Habitat();
        
        $suggestion = $suggestionModel->getById($id);
        $habitats = $habitatModel->getAll();
        
        $userId = $_SESSION['user']['id_user'] ?? null;

        // Check if suggestion exists and belongs to this veterinarian
        if (!$suggestion) {
            header('Location: /habitats/suggestion/start?msg=error&error=Suggestion not found');
            exit;
        }

        if ($suggestion->suggested_by != $userId) {
            header('Location: /habitats/suggestion/start?msg=error&error=You can only edit your own suggestions');
            exit;
        }

        // Check if status is pending (only pending can be edited)
        if ($suggestion->status !== 'pending') {
            header('Location: /habitats/suggestion/start?msg=error&error=You can only edit pending suggestions');
            exit;
        }

        if (file_exists(__DIR__ . '/../views/suggestion/edit.php')) {
            include_once __DIR__ . '/../views/suggestion/edit.php';
        } else {
            echo "Error: View file not found at " . __DIR__ . '/../views/suggestion/edit.php';
        }
    }

    /**
     * Update a suggestion (Veterinarian only, pending only)
     */
    public function update()
    {
        $userRoleName = $_SESSION['user']['role_name'] ?? null;
        if ($userRoleName !== 'Veterinary') {
            header('Location: /habitats/suggestion/start?msg=error&error=Only veterinarians can update suggestions');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /habitats/suggestion/start?msg=error&error=Invalid request method');
            exit;
        }

        // Verify CSRF token
        if (!csrf_verify('habitat_suggestion_update')) {
            $id = $_POST['id_hab_suggestion'] ?? '';
            header('Location: /habitats/suggestion/edit?id=' . $id . '&msg=error&error=Invalid request. Please try again.');
            exit;
        }

        $id = $_POST['id_hab_suggestion'] ?? null;
        $details = trim($_POST['details'] ?? '');
        $userId = $_SESSION['user']['id_user'] ?? null;

        if (!$id || empty($details)) {
            header('Location: /habitats/suggestion/start?msg=error&error=All required fields must be filled');
            exit;
        }

        // Verify the suggestion belongs to this veterinarian and is pending
        $suggestionModel = new HabitatSuggestion();
        $suggestion = $suggestionModel->getById($id);

        if (!$suggestion) {
            header('Location: /habitats/suggestion/start?msg=error&error=Suggestion not found');
            exit;
        }

        if ($suggestion->suggested_by != $userId) {
            header('Location: /habitats/suggestion/start?msg=error&error=You can only update your own suggestions');
            exit;
        }

        if ($suggestion->status !== 'pending') {
            header('Location: /habitats/suggestion/start?msg=error&error=You can only update pending suggestions');
            exit;
        }

        $result = $suggestionModel->update($id, $details);

        if ($result) {
            header('Location: /habitats/suggestion/start?msg=updated');
        } else {
            header('Location: /habitats/suggestion/start?msg=error&error=Failed to update suggestion');
        }
        exit;
    }

    /**
     * Review a suggestion (Accept or Reject) - Admin only
     */
    public function review()
    {
        $userRoleName = $_SESSION['user']['role_name'] ?? null;
        if ($userRoleName !== 'Admin') {
            header('Location: /habitats/suggestion/start?msg=error&error=Only admins can review suggestions');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /habitats/suggestion/start?msg=error&error=Invalid request method');
            exit;
        }

        // Verify CSRF token
        if (!csrf_verify('habitat_suggestion_review')) {
            header('Location: /habitats/suggestion/start?msg=error&error=Invalid request. Please try again.');
            exit;
        }

        $id = $_POST['id_hab_suggestion'] ?? null;
        $status = $_POST['status'] ?? null;
        $userId = $_SESSION['user']['id_user'] ?? null;

        if (!$id || !$status) {
            header('Location: /habitats/suggestion/start?msg=error&error=ID and status are required');
            exit;
        }

        // Validate status
        $allowedStatuses = ['accepted', 'rejected'];
        if (!in_array($status, $allowedStatuses)) {
            header('Location: /habitats/suggestion/start?msg=error&error=Invalid status');
            exit;
        }

        $suggestionModel = new HabitatSuggestion();
        $result = $suggestionModel->review($id, $status, $userId);

        if ($result) {
            header('Location: /habitats/suggestion/start?msg=reviewed');
        } else {
            header('Location: /habitats/suggestion/start?msg=error&error=Failed to review suggestion');
        }
        exit;
    }

    /**
     * Delete a suggestion
     * Veterinarians can only delete accepted/rejected suggestions
     * Admins can delete any suggestion
     */
    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /habitats/suggestion/start?msg=error&error=ID is required');
            exit;
        }

        $userRoleName = $_SESSION['user']['role_name'] ?? null;
        $userId = $_SESSION['user']['id_user'] ?? null;

        $suggestionModel = new HabitatSuggestion();
        $suggestion = $suggestionModel->getById($id);

        if (!$suggestion) {
            header('Location: /habitats/suggestion/start?msg=error&error=Suggestion not found');
            exit;
        }

        // Veterinarians can only delete accepted/rejected suggestions (not pending)
        if ($userRoleName === 'Veterinary') {
            if ($suggestion->suggested_by != $userId) {
                header('Location: /habitats/suggestion/start?msg=error&error=You can only delete your own suggestions');
                exit;
            }
            if ($suggestion->status === 'pending') {
                header('Location: /habitats/suggestion/start?msg=error&error=You cannot delete pending suggestions. Edit or wait for review.');
                exit;
            }
        }
        
        // Admins can only delete accepted/rejected suggestions (not pending - they must review first)
        if ($userRoleName === 'Admin') {
            if ($suggestion->status === 'pending') {
                header('Location: /habitats/suggestion/start?msg=error&error=You cannot delete pending suggestions. Please accept or reject them first.');
                exit;
            }
        }

        // Soft delete based on role
        $result = $suggestionModel->delete($id, $userRoleName);

        if ($result) {
            header('Location: /habitats/suggestion/start?msg=deleted');
        } else {
            header('Location: /habitats/suggestion/start?msg=error&error=Failed to delete suggestion');
        }
        exit;
    }
}

