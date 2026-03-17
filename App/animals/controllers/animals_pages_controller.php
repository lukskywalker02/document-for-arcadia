<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Animals\Controllers
 * 📂 Physical File:   App/animals/controllers/animals_pages_controller.php
 * 
 * 📝 Description:
 * Controller for the public Animals pages.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Hero\Models\Hero (via App/hero/models/Hero.php)
 * - Arcadia\Hero\Models\Slide (via App/hero/models/Slide.php)
 * - Arcadia\Animals\Models\AnimalFull (via App/animals/models/animalFull.php)
 * - Arcadia\Animals\Models\Specie (via App/animals/models/specie.php)
 * - Arcadia\Habitats\Models\Habitat (via App/habitats/models/habitat.php)
 * - Arcadia\Animals\Models\Nutrition (via App/animals/models/nutrition.php)
 * - Arcadia\VReports\Models\HealthStateReport (via App/vreports/models/healthStateReport.php)
 * - Arcadia\Animals\Models\AnimalClick (via App/animals/models/animalClick.php)
 */

require_once __DIR__ . '/../../hero/models/Hero.php';
require_once __DIR__ . '/../../hero/models/Slide.php';
require_once __DIR__ . '/../models/animalFull.php';
require_once __DIR__ . '/../models/specie.php';
require_once __DIR__ . '/../../habitats/models/habitat.php';
require_once __DIR__ . '/../models/nutrition.php';
require_once __DIR__ . '/../../vreports/models/healthStateReport.php';
require_once __DIR__ . '/../models/animalClick.php';

class AnimalsPagesController {
    
    // ALL ANIMALS PAGE
    public function allanimals() {
        // 1. Get Hero for Animals Page
        $heroModel = new Hero();
        $hero = $heroModel->getByPage('animals');
        $slides = [];

        if ($hero && $hero->has_sliders) {
            $slideModel = new Slide();
            $slides = $slideModel->getByHeroId($hero->id_hero);
        }

        // 2. Get all animals
        $animalModel = new AnimalFull();
        $animals = $animalModel->getAll();

        // 2.5. Get latest health state for each animal
        $healthReportModel = new HealthStateReport();
        foreach ($animals as $animal) {
            $latestReport = $healthReportModel->getLatestByAnimalId($animal->id_full_animal);
            $animal->latest_health_state = $latestReport ? $latestReport->hsr_state : null;
        }

        // 3. Get filter data
        $specieModel = new specie();
        $habitatModel = new Habitat();
        $nutritionModel = new Nutrition();
        
        $species = $specieModel->getAll();
        $habitats = $habitatModel->getAll();
        $nutritions = $nutritionModel->getAll();

        // 4. Define allowed health states (matching back office)
        $allowedStates = [
            'healthy' => 'Healthy',
            'sick' => 'Sick',
            'quarantined' => 'Quarantined',
            'injured' => 'Injured',
            'happy' => 'Happy',
            'sad' => 'Sad',
            'depressed' => 'Depressed',
            'terminal' => 'Terminal',
            'infant' => 'Infant',
            'hungry' => 'Hungry',
            'well' => 'Well',
            'good_condition' => 'Good Condition',
            'angry' => 'Angry',
            'aggressive' => 'Aggressive',
            'nervous' => 'Nervous',
            'anxious' => 'Anxious',
            'recovering' => 'Recovering',
            'pregnant' => 'Pregnant',
            'malnourished' => 'Malnourished',
            'dehydrated' => 'Dehydrated',
            'stressed' => 'Stressed'
        ];

        if (file_exists(__DIR__ . '/../views/pages/allanimals.php')) {
            include_once __DIR__ . '/../views/pages/allanimals.php';
        } else {
            echo "Error: View allanimals.php not found.";
        }
    }

    
    // ANIMAL PICKED PAGE
    public function animalpicked() {
        // Get animal ID from URL parameter
        $id = $_GET['id'] ?? null;
        
        
        if (!$id) {
            header('Location: /animals/pages/allanimals');
            exit;
        }

        // Get animal data by ID
        $animalModel = new AnimalFull();
        $animal = $animalModel->getById($id);
        
        if (!$animal) {
            header('Location: /animals/pages/allanimals');
            exit;
        }
        
        // Get the latest health state report for this animal
        $healthReportModel = new HealthStateReport();
        $latestReport = $healthReportModel->getLatestByAnimalId($id);
        
        // Register click for statistics (only once per session per animal to avoid spam)
        if ($animal && isset($animal->animal_g_id)) {
            // Initialize session array for tracking clicked animals if it doesn't exist
            if (!isset($_SESSION['animal_clicks'])) {
                $_SESSION['animal_clicks'] = [];
            }
            
            // Check if this animal has already been clicked in this session
            $animal_g_id = $animal->animal_g_id;
            if (!in_array($animal_g_id, $_SESSION['animal_clicks'])) {
                // Register the click
                $clickModel = new AnimalClick();
                $clickModel->registerClick($animal_g_id);
                
                // Mark this animal as clicked in this session
                $_SESSION['animal_clicks'][] = $animal_g_id;
            }
            // If already clicked in this session, do nothing (prevents spam)
        }
        
        if (file_exists(__DIR__ . '/../views/pages/animalpicked.php')) {
            include_once __DIR__ . '/../views/pages/animalpicked.php';
        } else {
            echo "Error: View animalpicked.php not found.";
        }
    }
}
