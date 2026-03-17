<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Testimonials\Controllers
 * 📂 Physical File:   App/testimonials/controllers/testimonials_gest_controller.php
 * 
 * 📝 Description:
 * Back office controller for testimonials management.
 * Handles listing, validating, rejecting, editing, and deleting testimonials (admin only).
 * Editing is useful for cleaning inappropriate content before validation, even though not explicitly mentioned in the PDF.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Testimonials\Models\Testimonial (via App/testimonials/models/testimonial.php)
 * - Arcadia\Database\Connection (via database/connection.php)
 * - Arcadia\Includes\Functions (via includes/functions.php)
 */


require_once __DIR__ . '/../../../database/connection.php';
require_once __DIR__ . '/../models/testimonial.php';
require_once __DIR__ . '/../../../includes/functions.php';
require_once __DIR__ . '/../../../includes/helpers/csrf.php';

class TestimonialsGestController
{
    /**
     * Display all testimonials with filtering options (admin dashboard)
     */
    public function start()
    {
        // Check that user is Admin or Employee (not Veterinarian)
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header('Location: /auth/pages/login?msg=error&error=You must be logged in');
            exit;
        }
        
        $roleName = $_SESSION["user"]["role_name"] ?? '';
        if ($roleName !== 'Admin' && $roleName !== 'Employee') {
            header('Location: /auth/pages/login?msg=error&error=You do not have permission to view testimonials. Only Admin and Employee can access this section.');
            exit;
        }

        $testimonialModel = new Testimonial();
        
        // Get filter status from query parameter
        $statusFilter = $_GET['status'] ?? null;
        if ($statusFilter && !in_array($statusFilter, ['pending', 'validated', 'rejected'])) {
            $statusFilter = null;
        }

        // Get all testimonials (or filtered by status)
        $testimonials = $testimonialModel->getAll($statusFilter);
        
        // Get statistics
        $stats = $testimonialModel->getStats();

        // Include the view
        if (file_exists(__DIR__ . '/../views/gest/start.php')) {
            include_once __DIR__ . '/../views/gest/start.php';
        } else {
            echo "Error: View start.php not found.";
        }
    }

    /**
     * Validate a testimonial (admin action)
     */
    public function validate()
    {
        // Check that user is Admin or Employee
        $roleName = $_SESSION["user"]["role_name"] ?? '';
        if ($roleName !== 'Admin' && $roleName !== 'Employee') {
            header('Location: /testimonials/gest/start?msg=error&error=You do not have permission to validate testimonials');
            exit;
        }

        // Check if user is logged in
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header('Location: /auth/pages/login?msg=error&error=You must be logged in');
            exit;
        }

        $testimonialId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $validatorId = $_SESSION["user"]["id_user"] ?? null;

        if (!$testimonialId || !$validatorId) {
            header('Location: /testimonials/gest/start?msg=error&error=Invalid testimonial ID');
            exit;
        }

        $testimonialModel = new Testimonial();
        $result = $testimonialModel->validate($testimonialId, $validatorId);

        if ($result) {
            header('Location: /testimonials/gest/start?msg=success&message=Testimonial validated successfully');
        } else {
            header('Location: /testimonials/gest/start?msg=error&error=Failed to validate testimonial');
        }
        exit;
    }

    /**
     * Reject a testimonial (admin action)
     */
    public function reject()
    {
        // Check that user is Admin or Employee
        $roleName = $_SESSION["user"]["role_name"] ?? '';
        if ($roleName !== 'Admin' && $roleName !== 'Employee') {
            header('Location: /testimonials/gest/start?msg=error&error=You do not have permission to reject testimonials');
            exit;
        }

        // Check if user is logged in
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header('Location: /auth/pages/login?msg=error&error=You must be logged in');
            exit;
        }

        $testimonialId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $validatorId = $_SESSION["user"]["id_user"] ?? null;

        if (!$testimonialId || !$validatorId) {
            header('Location: /testimonials/gest/start?msg=error&error=Invalid testimonial ID');
            exit;
        }

        $testimonialModel = new Testimonial();
        $result = $testimonialModel->reject($testimonialId, $validatorId);

        if ($result) {
            header('Location: /testimonials/gest/start?msg=success&message=Testimonial rejected successfully');
        } else {
            header('Location: /testimonials/gest/start?msg=error&error=Failed to reject testimonial');
        }
        exit;
    }


    /**
     * Delete a testimonial (admin action)
     */
    public function delete()
    {
        // Check that user is Admin or Employee
        $roleName = $_SESSION["user"]["role_name"] ?? '';
        if ($roleName !== 'Admin' && $roleName !== 'Employee') {
            header('Location: /testimonials/gest/start?msg=error&error=You do not have permission to delete testimonials');
            exit;
        }

        $testimonialId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if (!$testimonialId) {
            header('Location: /testimonials/gest/start?msg=error&error=Invalid testimonial ID');
            exit;
        }

        $testimonialModel = new Testimonial();
        $result = $testimonialModel->delete($testimonialId);

        if ($result) {
            header('Location: /testimonials/gest/start?msg=success&message=Testimonial deleted successfully');
        } else {
            header('Location: /testimonials/gest/start?msg=error&error=Failed to delete testimonial');
        }
        exit;
    }

    /**
     * Display edit form for a testimonial
     * Allows editing content before validation (useful for cleaning inappropriate content)
     */
    public function edit()
    {
        // Check that user is Admin or Employee
        $roleName = $_SESSION["user"]["role_name"] ?? '';
        if ($roleName !== 'Admin' && $roleName !== 'Employee') {
            header('Location: /testimonials/gest/start?msg=error&error=You do not have permission to edit testimonials');
            exit;
        }

        $testimonialId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if (!$testimonialId) {
            header('Location: /testimonials/gest/start?msg=error&error=Invalid testimonial ID');
            exit;
        }

        $testimonialModel = new Testimonial();
        $testimonial = $testimonialModel->getById($testimonialId);

        if (!$testimonial) {
            header('Location: /testimonials/gest/start?msg=error&error=Testimonial not found');
            exit;
        }

        // Include the edit view
        if (file_exists(__DIR__ . '/../views/gest/edit.php')) {
            include_once __DIR__ . '/../views/gest/edit.php';
        } else {
            echo "Error: View edit.php not found.";
        }
    }

    /**
     * Update a testimonial (admin action)
     * Allows editing content before validation
     */
    public function update()
    {
        // Check that user is Admin or Employee
        $roleName = $_SESSION["user"]["role_name"] ?? '';
        if ($roleName !== 'Admin' && $roleName !== 'Employee') {
            header('Location: /testimonials/gest/start?msg=error&error=You do not have permission to update testimonials');
            exit;
        }

        // Only process POST requests
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /testimonials/gest/start?msg=error&error=Invalid request method');
            exit;
        }

        // Verify CSRF token
        if (!csrf_verify('testimonial_update')) {
            $id = $_POST['id'] ?? '';
            header('Location: /testimonials/gest/edit?id=' . $id . '&msg=error&error=Invalid request. Please try again.');
            exit;
        }

        $testimonialId = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $pseudo = trim($_POST['pseudo'] ?? '');
        $message = trim($_POST['message'] ?? '');
        $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
        $validateAfterEdit = isset($_POST['validate_after_edit']) && $_POST['validate_after_edit'] === '1';

        // Validate inputs
        if (!$testimonialId) {
            header('Location: /testimonials/gest/start?msg=error&error=Invalid testimonial ID');
            exit;
        }

        if (empty($pseudo)) {
            header('Location: /testimonials/gest/edit?id=' . $testimonialId . '&msg=error&error=Pseudonym is required');
            exit;
        }

        if (empty($message)) {
            header('Location: /testimonials/gest/edit?id=' . $testimonialId . '&msg=error&error=Message is required');
            exit;
        }

        if ($rating < 1 || $rating > 5) {
            header('Location: /testimonials/gest/edit?id=' . $testimonialId . '&msg=error&error=Rating must be between 1 and 5');
            exit;
        }

        $testimonialModel = new Testimonial();
        
        // Update the testimonial
        $result = $testimonialModel->update($testimonialId, $pseudo, $message, $rating);

        if (!$result) {
            header('Location: /testimonials/gest/edit?id=' . $testimonialId . '&msg=error&error=Failed to update testimonial');
            exit;
        }

        // If validate_after_edit is checked, also validate it
        if ($validateAfterEdit) {
            $validatorId = $_SESSION["user"]["id_user"] ?? null;
            if ($validatorId) {
                $testimonialModel->validate($testimonialId, $validatorId);
            }
            header('Location: /testimonials/gest/start?msg=success&message=Testimonial updated and validated successfully');
        } else {
            header('Location: /testimonials/gest/start?msg=success&message=Testimonial updated successfully');
        }
        exit;
    }
}

