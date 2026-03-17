<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Animals\Controllers
 * 📂 Physical File:   App/animals/controllers/animals_stats_controller.php
 * 
 * 📝 Description:
 * Controller for viewing animal click statistics.
 * Implements permission checks (RBAC) for viewing stats.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Animals\Models\AnimalClick (via App/animals/models/animalClick.php)
 * - Arcadia\Includes\Functions (via includes/functions.php)
 */

require_once __DIR__ . '/../models/animalClick.php';
require_once __DIR__ . '/../../../includes/functions.php';

class AnimalsStatsController
{
    /**
     * Display statistics dashboard.
     * Shows current month stats, top animals, and historical data.
     */
    public function start()
    {
        // Check permission
        if (!hasPermission('animal_stats-view')) {
            header('Location: /auth/pages/login?msg=error&error=You do not have permission to view animal statistics');
            exit;
        }

        $animalClickModel = new AnimalClick();

        // Get number of months to display (from GET parameter, default 6)
        $monthsToShow = isset($_GET['months']) ? (int)$_GET['months'] : 6;
        // Validate: must be between 1 and 12
        if ($monthsToShow < 1 || $monthsToShow > 12) {
            $monthsToShow = 6;
        }

        // Get statistics data
        $currentMonthStats = $animalClickModel->getCurrentMonthStats();
        $topAnimals = $animalClickModel->getTopAnimals(10);
        $lastMonthsStats = $animalClickModel->getLastMonthsStats($monthsToShow);
        $totalClicks = $animalClickModel->getTotalClicks();

        // Calculate current month total
        $currentMonthTotal = 0;
        foreach ($currentMonthStats as $stat) {
            $currentMonthTotal += $stat->click_count;
        }

        // Get current month name
        $currentMonthName = date('F Y'); // e.g., "December 2025"

        if (file_exists(__DIR__ . '/../views/gest/stats.php')) {
            include_once __DIR__ . '/../views/gest/stats.php';
        } else {
            echo "Error: View stats.php not found.";
        }
    }
}

