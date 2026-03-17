<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\VReports\Controllers
 * 📂 Physical File:   App/vreports/controllers/vreports_gest_controller.php
 * 
 * 📝 Description:
 * Controller for managing health state reports (CRUD).
 * Handles creation, listing, editing, and management of veterinary health reports.
 * 
 * 🔗 Dependencies:
 * - Arcadia\VReports\Models\HealthStateReport (via App/vreports/models/healthStateReport.php)
 * - Arcadia\Animals\Models\AnimalFull (via App/animals/models/animalFull.php)
 * - Arcadia\Users\Models\User (via App/users/models/user.php)
 * - Arcadia\Includes\Functions (via includes/functions.php)
 */

require_once __DIR__ . "/../models/healthStateReport.php";
require_once __DIR__ . "/../../animals/models/animalFull.php";
require_once __DIR__ . "/../../users/models/user.php";
require_once __DIR__ . "/../../../includes/functions.php";
require_once __DIR__ . "/../../../includes/helpers/csrf.php";

class VreportsGestController
{
    /**
     * Dashboard: List all health state reports
     */
    public function start()
    {
        // Check if user has permission to view reports
        if (!hasPermission('vet_reports-view')) {
            header('Location: /home/pages/start?msg=error&error=You do not have permission to view health reports');
            exit();
        }

        $reportModel = new HealthStateReport();
        $animalModel = new AnimalFull();
        
        $reports = $reportModel->getAll();
        $animals = $animalModel->getAll();
        
        if (file_exists(__DIR__ . '/../views/gest/start.php')) {
            include_once __DIR__ . '/../views/gest/start.php';
        } else {
            echo "Error: View file not found at " . __DIR__ . '/../views/gest/start.php';
        }
    }

    /**
     * Show form to create a new health state report
     * Only users with vet_reports-create permission can create reports
     */
    public function create()
    {
        // Check if user has permission to create
        if (!hasPermission('vet_reports-create')) {
            header('Location: /vreports/gest/start?msg=error&error=You do not have permission to create health reports');
            exit();
        }

        $animalModel = new AnimalFull();
        $animals = $animalModel->getAll();
        
        // Get user ID from session (veterinarian who will create the report)
        $userId = $_SESSION['user']['id_user'] ?? null;
        
        if (file_exists(__DIR__ . '/../views/gest/create.php')) {
            include_once __DIR__ . '/../views/gest/create.php';
        } else {
            echo "Error: View file not found at " . __DIR__ . '/../views/gest/create.php';
        }
    }

    /**
     * Save health state report (create new record)
     * Only users with vet_reports-create permission can save reports
     */
    public function save()
    {
        // Check if user has permission to create
        if (!hasPermission('vet_reports-create')) {
            header('Location: /vreports/gest/start?msg=error&error=You do not have permission to create health reports');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /vreports/gest/start?msg=error&error=Invalid request method');
            exit();
        }

        // Verify CSRF token
        if (!csrf_verify('vreport_create')) {
            header('Location: /vreports/gest/create?msg=error&error=Invalid request. Please try again.');
            exit();
        }

        $fullAnimalId = $_POST['full_animal_id'] ?? null;
        $stateRaw = $_POST['hsr_state'] ?? '';
        $reviewDate = $_POST['review_date'] ?? null;
        $vetObs = trim($_POST['vet_obs'] ?? '');
        $optDetails = trim($_POST['opt_details'] ?? '');
        
        // Get user ID from session (veterinarian who created the report)
        $userId = $_SESSION['user']['id_user'] ?? null;

        // Validate user ID is present
        if ($userId === null || $userId === 0) {
            error_log("Error: user_id is null or 0 when creating health report. Session user data: " . print_r($_SESSION['user'] ?? [], true));
            header('Location: /vreports/gest/create?msg=error&error=User session error. Please log in again.');
            exit();
        }

        // Validate state enum FIRST - must match exactly with database ENUM
        $allowedStates = ['healthy', 'sick', 'quarantined', 'injured', 'happy', 'sad', 'depressed', 'terminal', 'infant', 'hungry', 'well', 'good_condition', 'angry', 'aggressive', 'nervous', 'anxious', 'recovering', 'pregnant', 'malnourished', 'dehydrated', 'stressed'];
        
        // Clean and validate state IMMEDIATELY - only allow lowercase letters and underscore
        $state = strtolower(trim($stateRaw));
        $state = preg_replace('/[^a-z_]/', '', $state); // Only allow lowercase letters and underscore
        
        // Log for debugging
        error_log("State validation - Raw: '" . bin2hex($stateRaw) . "' | Cleaned: '" . bin2hex($state) . "' | Value: '$state'");
        
        if (empty($state) || !in_array($state, $allowedStates, true)) {
            error_log("Invalid health state: '$state' (raw: '$stateRaw', hex: " . bin2hex($stateRaw) . ")");
            header('Location: /vreports/gest/create?msg=error&error=Invalid health state selected. Please select a valid state.');
            exit();
        }

        // Validation
        if (!$fullAnimalId || !$state || !$reviewDate || !$vetObs) {
            header('Location: /vreports/gest/create?msg=error&error=All required fields must be filled');
            exit();
        }

        // Validate that the animal exists
        $animalModel = new AnimalFull();
        $animal = $animalModel->getById($fullAnimalId);
        if (!$animal) {
            header('Location: /vreports/gest/create?msg=error&error=Selected animal does not exist. Please select a valid animal.');
            exit();
        }

        // Validate that the user exists (if checked_by is required)
        $user = User::find($userId);
        if (!$user) {
            error_log("Error: user_id $userId does not exist in database when creating health report.");
            header('Location: /vreports/gest/create?msg=error&error=User account error. Please log in again.');
            exit();
        }

        // Validate date format
        $dateObj = DateTime::createFromFormat('Y-m-d', $reviewDate);
        if (!$dateObj || $dateObj->format('Y-m-d') !== $reviewDate) {
            header('Location: /vreports/gest/create?msg=error&error=Invalid date format');
            exit();
        }

        // Convert fullAnimalId to integer to ensure proper type
        $fullAnimalId = (int)$fullAnimalId;
        $userId = (int)$userId;

        $reportModel = new HealthStateReport();
        $result = $reportModel->create($fullAnimalId, $state, $reviewDate, $vetObs, $userId, $optDetails);

        if ($result && is_numeric($result)) {
            header('Location: /vreports/gest/start?msg=saved');
            exit();
        } else {
            // Log detailed error for debugging
            error_log("Failed to save health report. Parameters: full_animal_id=$fullAnimalId, state=$state, review_date=$reviewDate, user_id=$userId");
            
            // Get specific error message if available
            $errorMsg = "Failed to save health report. Please verify that the animal exists and try again.";
            if (is_array($result) && isset($result['error'])) {
                $dbError = $result['error'];
                error_log("Database error: " . $dbError);
                
                // Provide more specific error messages
                if (strpos($dbError, 'foreign key') !== false || strpos($dbError, '1452') !== false) {
                    $errorMsg = "Failed to save: The selected animal or user does not exist in the database.";
                } elseif (strpos($dbError, 'Duplicate entry') !== false) {
                    $errorMsg = "Failed to save: A report with this information already exists.";
                } else {
                    $errorMsg = "Failed to save health report: " . htmlspecialchars($dbError);
                }
            }
            
            header('Location: /vreports/gest/create?msg=error&error=' . urlencode($errorMsg));
            exit();
        }
    }

    /**
     * Show form to edit an existing health state report
     * Only users with vet_reports-edit permission can edit reports
     */
    public function edit()
    {
        // Check if user has permission to edit
        if (!hasPermission('vet_reports-edit')) {
            header('Location: /vreports/gest/start?msg=error&error=You do not have permission to edit health reports');
            exit();
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /vreports/gest/start?msg=error&error=Report ID is required');
            exit();
        }

        $reportModel = new HealthStateReport();
        $animalModel = new AnimalFull();
        
        $report = $reportModel->getById($id);
        $animals = $animalModel->getAll();
        
        if (!$report) {
            header('Location: /vreports/gest/start?msg=error&error=Health report not found');
            exit();
        }

        // Get user ID from session (veterinarian who will update the report)
        $userId = $_SESSION['user']['id_user'] ?? null;

        if (file_exists(__DIR__ . '/../views/gest/edit.php')) {
            include_once __DIR__ . '/../views/gest/edit.php';
        } else {
            echo "Error: View file not found at " . __DIR__ . '/../views/gest/edit.php';
        }
    }

    /**
     * Update health state report
     * Only users with vet_reports-edit permission can update reports
     */
    public function update()
    {
        // Check if user has permission to edit
        if (!hasPermission('vet_reports-edit')) {
            header('Location: /vreports/gest/start?msg=error&error=You do not have permission to edit health reports');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /vreports/gest/start?msg=error&error=Invalid request method');
            exit();
        }

        // Verify CSRF token
        if (!csrf_verify('vreport_edit')) {
            $id = $_GET['id'] ?? '';
            header('Location: /vreports/gest/edit?id=' . $id . '&msg=error&error=Invalid request. Please try again.');
            exit();
        }

        $id = $_POST['id_hs_report'] ?? null;
        $fullAnimalId = $_POST['full_animal_id'] ?? null;
        $state = trim($_POST['hsr_state'] ?? ''); // Trim whitespace
        $reviewDate = $_POST['review_date'] ?? null;
        $vetObs = trim($_POST['vet_obs'] ?? ''); // Trim whitespace
        $optDetails = trim($_POST['opt_details'] ?? ''); // Trim whitespace
        
        // Get user ID from session (veterinarian who updated the report)
        $userId = $_SESSION['user']['id_user'] ?? null;

        // Validate user ID is present
        if ($userId === null) {
            error_log("Error: user_id is null when updating health report. Session user data: " . print_r($_SESSION['user'] ?? [], true));
            header('Location: /vreports/gest/edit?id=' . $id . '&msg=error&error=User session error. Please log in again.');
            exit();
        }

        // Validation
        if (!$id || !$fullAnimalId || !$state || !$reviewDate || !$vetObs) {
            header('Location: /vreports/gest/edit?id=' . $id . '&msg=error&error=All required fields must be filled');
            exit();
        }

        // SECURITY: Verify that the animal ID matches the original report
        // An existing health report cannot be reassigned to a different animal (historical integrity)
        $reportModel = new HealthStateReport();
        $existingReport = $reportModel->getById($id);
        if (!$existingReport) {
            header('Location: /vreports/gest/start?msg=error&error=Health report not found');
            exit();
        }
        
        if ($existingReport->id_full_animal != $fullAnimalId) {
            error_log("Security warning: Attempt to change animal ID in health report. Report ID: $id, Original animal: {$existingReport->id_full_animal}, Attempted animal: $fullAnimalId");
            header('Location: /vreports/gest/edit?id=' . $id . '&msg=error&error=Cannot change the animal for an existing health report. This is a historical record.');
            exit();
        }

        // Validate state enum - must match exactly with database ENUM
        $allowedStates = ['healthy', 'sick', 'quarantined', 'injured', 'happy', 'sad', 'depressed', 'terminal', 'infant', 'hungry', 'well', 'good_condition', 'angry', 'aggressive', 'nervous', 'anxious', 'recovering', 'pregnant', 'malnourished', 'dehydrated', 'stressed'];
        
        // Clean and validate state IMMEDIATELY - only allow lowercase letters and underscore
        $stateRaw = $state;
        $state = strtolower(trim($state));
        $state = preg_replace('/[^a-z_]/', '', $state); // Only allow lowercase letters and underscore
        
        // Log for debugging
        error_log("State validation in update() - Raw: '" . bin2hex($stateRaw) . "' | Cleaned: '" . bin2hex($state) . "' | Value: '$state'");
        
        if (empty($state) || !in_array($state, $allowedStates, true)) {
            error_log("Invalid health state received in update: '$state' (raw: '$stateRaw', hex: " . bin2hex($stateRaw) . ")");
            header('Location: /vreports/gest/edit?id=' . $id . '&msg=error&error=Invalid health state selected. Please select a valid state.');
            exit();
        }

        // Validate date format
        $dateObj = DateTime::createFromFormat('Y-m-d', $reviewDate);
        if (!$dateObj || $dateObj->format('Y-m-d') !== $reviewDate) {
            header('Location: /vreports/gest/edit?id=' . $id . '&msg=error&error=Invalid date format');
            exit();
        }

        $reportModel = new HealthStateReport();
        $result = $reportModel->update($id, $state, $reviewDate, $vetObs, $userId, $optDetails);

        if ($result === true) {
            header('Location: /vreports/gest/start?msg=updated');
            exit();
        } else {
            // Log detailed error for debugging
            error_log("Failed to update health report. Parameters: id=$id, state=$state, review_date=$reviewDate, user_id=$userId");
            
            // Get specific error message if available
            $errorMsg = "Failed to update health report. Please verify the data and try again.";
            if (is_array($result) && isset($result['error'])) {
                $dbError = $result['error'];
                error_log("Database error: " . $dbError);
                
                // Provide more specific error messages
                if (strpos($dbError, 'foreign key') !== false || strpos($dbError, '1452') !== false) {
                    $errorMsg = "Failed to update: The selected animal or user does not exist in the database.";
                } elseif (strpos($dbError, 'Duplicate entry') !== false) {
                    $errorMsg = "Failed to update: A report with this information already exists.";
                } elseif (strpos($dbError, 'Invalid state') !== false) {
                    $errorMsg = "Failed to update: Invalid health state value.";
                } else {
                    $errorMsg = "Failed to update health report: " . htmlspecialchars($dbError);
                }
            }
            
            header('Location: /vreports/gest/edit?id=' . $id . '&msg=error&error=' . urlencode($errorMsg));
            exit();
        }
    }

    /**
     * View a single health state report
     */
    public function view()
    {
        // Check if user has permission to view reports
        if (!hasPermission('vet_reports-view')) {
            header('Location: /vreports/gest/start?msg=error&error=You do not have permission to view health reports');
            exit();
        }

        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: /vreports/gest/start?msg=error&error=Report ID is required');
            exit();
        }

        $reportModel = new HealthStateReport();
        $report = $reportModel->getById($id);

        if (!$report) {
            header('Location: /vreports/gest/start?msg=error&error=Health report not found');
            exit();
        }

        if (file_exists(__DIR__ . '/../views/gest/view.php')) {
            include_once __DIR__ . '/../views/gest/view.php';
        } else {
            echo "Error: View file not found at " . __DIR__ . '/../views/gest/view.php';
        }
    }

    /**
     * Delete a health state report
     * Only users with vet_reports-edit permission can delete reports (or Admin)
     */
    public function delete()
    {
        // Check if user has permission to delete (using edit permission or Admin)
        $isAdmin = isset($_SESSION['user']['role_name']) && $_SESSION['user']['role_name'] === 'Admin';
        if (!hasPermission('vet_reports-edit') && !$isAdmin) {
            header('Location: /vreports/gest/start?msg=error&error=You do not have permission to delete health reports');
            exit();
        }

        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: /vreports/gest/start?msg=error&error=Report ID is required');
            exit();
        }

        $reportModel = new HealthStateReport();
        $result = $reportModel->delete($id);

        if ($result) {
            header('Location: /vreports/gest/start?msg=deleted');
        } else {
            header('Location: /vreports/gest/start?msg=error&error=Failed to delete health report');
        }
        exit();
    }

    /**
     * Generate PDF for a health state report
     * Accessible to users with vet_reports-view permission
     */
    public function generatePDF()
    {
        // Check if user has permission to view reports
        if (!hasPermission('vet_reports-view')) {
            header('Location: /vreports/gest/start?msg=error&error=You do not have permission to view health reports');
            exit();
        }

        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: /vreports/gest/start?msg=error&error=Report ID is required');
            exit();
        }

        $reportModel = new HealthStateReport();
        $report = $reportModel->getById($id);

        if (!$report) {
            header('Location: /vreports/gest/start?msg=error&error=Health report not found');
            exit();
        }

        // Format dates
        $reviewDate = new DateTime($report->review_date);
        $updatedDate = new DateTime($report->updated_at);
        
        // Format state name
        $stateName = ucfirst(str_replace('_', ' ', $report->hsr_state));

        // Generate PDF content
        $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Health Report #' . $report->id_hs_report . '</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #0066cc;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #0066cc;
            margin: 0;
        }
        .info-section {
            margin-bottom: 25px;
            padding: 15px;
            background-color: #f9f9f9;
            border-left: 4px solid #0066cc;
        }
        .info-section h3 {
            margin-top: 0;
            color: #0066cc;
        }
        .info-row {
            margin: 10px 0;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
        }
        .badge-success { background-color: #28a745; color: white; }
        .badge-danger { background-color: #dc3545; color: white; }
        .badge-warning { background-color: #ffc107; color: #333; }
        .badge-info { background-color: #17a2b8; color: white; }
        .badge-secondary { background-color: #6c757d; color: white; }
        .observation-box {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 15px;
            margin-top: 10px;
            border-radius: 4px;
            white-space: pre-wrap;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        
        .print-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #0066cc;
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .print-button:hover {
            background-color: #0052a3;
            transform: scale(1.1);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
        }
        .print-button:active {
            transform: scale(0.95);
        }
        /* Hide button when printing */
        @media print {
            .print-button {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>ZOO ARCADIA</h1>
        <h2>Health State Report</h2>
    </div>

    <div class="info-section">
        <h3>Report Information</h3>
        <div class="info-row">
            <span class="info-label">Report ID:</span>
            #' . $report->id_hs_report . '
        </div>
        <div class="info-row">
            <span class="info-label">Animal:</span>
            ' . htmlspecialchars($report->animal_name ?? 'N/A') . '
        </div>
        <div class="info-row">
            <span class="info-label">Species:</span>
            ' . htmlspecialchars($report->specie_name ?? 'N/A') . 
            ($report->category_name ? ' (' . htmlspecialchars($report->category_name) . ')' : '') . '
        </div>
        ' . ($report->habitat_name ? '<div class="info-row">
            <span class="info-label">Habitat:</span>
            ' . htmlspecialchars($report->habitat_name) . '
        </div>' : '') . '
        ' . ($report->gender ? '<div class="info-row">
            <span class="info-label">Gender:</span>
            ' . htmlspecialchars(ucfirst($report->gender)) . '
        </div>' : '') . '
    </div>

    <div class="info-section">
        <h3>Health Status</h3>
        <div class="info-row">
            <span class="info-label">Date Of Check-Up:</span>
            ' . $reviewDate->format('F j, Y') . '
        </div>
        <div class="info-row">
            <span class="info-label">Mood Animal:</span>
            <span class="badge badge-' . $this->getStateBadgeType($report->hsr_state) . '">' . $stateName . '</span>
        </div>
    </div>

    <div class="info-section">
        <h3>Veterinary Observation</h3>
        <div class="observation-box">' . htmlspecialchars($report->vet_obs) . '</div>
    </div>

    ' . ($report->opt_details ? '<div class="info-section">
        <h3>Optional Animal Details</h3>
        <div class="observation-box">' . htmlspecialchars($report->opt_details) . '</div>
    </div>' : '') . '

    <div class="info-section">
        <h3>Veterinarian Information</h3>
        <div class="info-row">
            <span class="info-label">Veterinarian:</span>
            ' . htmlspecialchars($report->checked_by_username ?? 'Unknown') . 
            ($report->role_name ? ' (' . htmlspecialchars($report->role_name) . ')' : '') . '
        </div>
        <div class="info-row">
            <span class="info-label">Last Updated:</span>
            ' . $updatedDate->format('F j, Y \a\t g:i A') . '
        </div>
    </div>

    <div class="footer">
        <p>Generated on ' . date('F j, Y \a\t g:i A') . '</p>
        <p>Zoo Arcadia - Health State Report System</p>
    </div>

    <!-- Botón flotante de impresión -->
    <button class="print-button" onclick="window.print()" title="Imprimir (Ctrl+P)">
        🖨️
    </button>

    <script>
        // Also allows using Ctrl+P to print
        document.addEventListener("keydown", function(event) {
            if (event.ctrlKey && event.key === "p") {
                event.preventDefault();
                window.print();
            }
        });
    </script>
</body>
</html>';

        // Set headers for PDF download
        header('Content-Type: text/html; charset=UTF-8');
        header('Content-Disposition: inline; filename="health_report_' . $report->id_hs_report . '.html"');
        
        // Output HTML (can be printed as PDF using browser print function)
        echo $html;
        exit();
    }

    /**
     * Helper method to get badge type for PDF styling
     */
    private function getStateBadgeType($state) {
        $stateTypes = [
            'healthy' => 'success',
            'well' => 'success',
            'good_condition' => 'success',
            'happy' => 'success',
            'sick' => 'danger',
            'injured' => 'danger',
            'malnourished' => 'danger',
            'dehydrated' => 'danger',
            'quarantined' => 'warning',
            'terminal' => 'warning',
            'recovering' => 'info',
            'pregnant' => 'info',
            'sad' => 'warning',
            'depressed' => 'warning',
            'stressed' => 'warning',
            'nervous' => 'warning',
            'anxious' => 'warning',
            'hungry' => 'warning',
            'angry' => 'danger',
            'aggressive' => 'danger',
            'infant' => 'secondary'
        ];
        
        return $stateTypes[$state] ?? 'secondary';
    }
}

