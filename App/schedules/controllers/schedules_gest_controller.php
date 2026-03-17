<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Schedules\Controllers
 * 📂 Physical File:   App/schedules/controllers/schedules_gest_controller.php
 * 
 * 📝 Description:
 * Controller for managing opening hours.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Database\Connection (via database/connection.php)
 * - Arcadia\Schedules\Models\Schedule (via App/schedules/models/schedule.php)
 * - Arcadia\Includes\Functions (via includes/functions.php)
 */

require_once __DIR__ . '/../../../database/connection.php';
require_once __DIR__ . '/../models/schedule.php';
require_once __DIR__ . '/../../../includes/functions.php';

DB::createInstance();

class SchedulesGestController {
    public function start() {
        $scheduleModel = new Schedule();
        $schedules = $scheduleModel->getAll();

        // Load the static management view
        // Make sure the 'start.php' file is in 'views/gest/'
        if (file_exists(__DIR__ . '/../views/gest/start.php')) {
            include_once __DIR__ . '/../views/gest/start.php';
        } else {
            echo "Error: View file not found at " . __DIR__ . '/../views/gest/start.php';
        }
    }
    
    public function edit() {
        // Check if user has permission to edit schedules
        if (!hasPermission('schedules-edit')) {
            header('Location: /schedules/gest/start?msg=error&error=You do not have permission to edit schedules');
            exit;
        }

        $scheduleModel = new Schedule();
        $error = null;
        $success = null;

        // CHECK IF WE ARE SAVING (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get data from the form
            $id = $_POST['id_opening'] ?? null;
            $data = [
                'time_slot'    => $_POST['time_slot'] ?? '',
                'opening_time' => $_POST['opening_time'] ?? '',
                'closing_time' => $_POST['closing_time'] ?? '',
                'status'       => $_POST['status'] ?? 'open'
            ];

            if ($id && $scheduleModel->update($id, $data)) {
                // Redirect to the list with success message (or show it here)
                header('Location: /schedules/gest/start'); 
                exit;
            } else {
                $error = "Failed to update schedule.";
            }
        }

        // SHOW FORM (GET)
        $id = $_GET['id'] ?? null;
        $schedule = null;

        if ($id) {
            $schedule = $scheduleModel->getById($id);
        }

        if (!$schedule) {
            echo "Error: Schedule not found.";
            return;
        }

        if (file_exists(__DIR__ . '/../views/gest/edit.php')) {
            include_once __DIR__ . '/../views/gest/edit.php';
        } else {
            echo "Error: View file not found at " . __DIR__ . '/../views/gest/edit.php';
        }
    }
}
