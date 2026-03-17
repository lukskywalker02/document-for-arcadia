<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Contact\Controllers
 * 📂 Physical File:   App/contact/controllers/contact_gest_controller.php
 * 
 * 📝 Description:
 * Back office controller for contact form management.
 * Handles listing and managing contact form submissions (admin/employee only).
 * 
 * 🔗 Dependencies:
 * - Arcadia\Contact\Models\FormContact (via App/contact/models/formContact.php)
 * - Arcadia\Includes\Functions (via includes/functions.php)
 */

require_once __DIR__ . '/../models/formContact.php';
require_once __DIR__ . '/../../../includes/functions.php';

class ContactGestController
{
    /**
     * Display all contact form submissions with filtering options
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
            header('Location: /auth/pages/login?msg=error&error=You do not have permission to view contact forms. Only Admin and Employee can access this section.');
            exit;
        }

        $formContactModel = new FormContact();
        
        // Get filter status from query parameter
        $emailSentFilter = null;
        if (isset($_GET['status'])) {
            if ($_GET['status'] === 'sent') {
                $emailSentFilter = true;
            } elseif ($_GET['status'] === 'pending') {
                $emailSentFilter = false;
            }
        }

        // Get all contact forms (or filtered by email_sent status)
        $contactForms = $formContactModel->getAll($emailSentFilter);
        
        // Get statistics
        $stats = $formContactModel->getStats();

        // Include the view
        if (file_exists(__DIR__ . '/../views/gest/start.php')) {
            include_once __DIR__ . '/../views/gest/start.php';
        } else {
            echo "Error: View start.php not found.";
        }
    }

    /**
     * Mark a contact form as email sent (manual action)
     */
    public function markAsSent()
    {
        // Check that user is Admin or Employee
        $roleName = $_SESSION["user"]["role_name"] ?? '';
        if ($roleName !== 'Admin' && $roleName !== 'Employee') {
            header('Location: /contact/gest/start?msg=error&error=You do not have permission to mark contact forms as sent');
            exit;
        }

        $contactId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if (!$contactId) {
            header('Location: /contact/gest/start?msg=error&error=Invalid contact form ID');
            exit;
        }

        $formContactModel = new FormContact();
        $result = $formContactModel->markAsSent($contactId);

        if ($result) {
            header('Location: /contact/gest/start?msg=success&message=Contact form marked as sent successfully');
        } else {
            header('Location: /contact/gest/start?msg=error&error=Failed to mark contact form as sent');
        }
        exit;
    }

    /**
     * Mark a contact form as pending (revert sent status)
     */
    public function markAsPending()
    {
        // Check that user is Admin or Employee
        $roleName = $_SESSION["user"]["role_name"] ?? '';
        if ($roleName !== 'Admin' && $roleName !== 'Employee') {
            header('Location: /contact/gest/start?msg=error&error=You do not have permission to mark contact forms as pending');
            exit;
        }

        $contactId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if (!$contactId) {
            header('Location: /contact/gest/start?msg=error&error=Invalid contact form ID');
            exit;
        }

        $formContactModel = new FormContact();
        $result = $formContactModel->markAsPending($contactId);

        if ($result) {
            header('Location: /contact/gest/start?msg=success&message=Contact form marked as pending successfully');
        } else {
            header('Location: /contact/gest/start?msg=error&error=Failed to mark contact form as pending');
        }
        exit;
    }

    /**
     * Delete a contact form (admin/employee action)
     */
    public function delete()
    {
        // Check that user is Admin or Employee
        $roleName = $_SESSION["user"]["role_name"] ?? '';
        if ($roleName !== 'Admin' && $roleName !== 'Employee') {
            header('Location: /contact/gest/start?msg=error&error=You do not have permission to delete contact forms');
            exit;
        }

        $contactId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if (!$contactId) {
            header('Location: /contact/gest/start?msg=error&error=Invalid contact form ID');
            exit;
        }

        $formContactModel = new FormContact();
        $result = $formContactModel->delete($contactId);

        if ($result) {
            header('Location: /contact/gest/start?msg=success&message=Contact form deleted successfully');
        } else {
            header('Location: /contact/gest/start?msg=error&error=Failed to delete contact form');
        }
        exit;
    }
}

