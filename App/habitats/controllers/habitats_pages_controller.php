<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Habitats\Controllers
 * 📂 Physical File:   App/habitats/controllers/habitats_pages_controller.php
 * 
 * 📝 Description:
 * Controller for the public Habitats pages.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Habitats\Models\Habitat (via App/habitats/models/habitat.php)
 * - Arcadia\Hero\Models\Hero (via App/hero/models/Hero.php)
 * - Arcadia\Hero\Models\Slide (via App/hero/models/Slide.php)
 * - Arcadia\Animals\Models\AnimalFull (via App/animals/models/animalFull.php)
 * - Arcadia\Animals\Models\Specie (via App/animals/models/specie.php)
 * - Arcadia\Animals\Models\Nutrition (via App/animals/models/nutrition.php)
 * - Arcadia\VReports\Models\HealthStateReport (via App/vreports/models/healthStateReport.php)
 * 
 */

require_once __DIR__ . '/../models/habitat.php';
require_once __DIR__ . '/../../hero/models/Hero.php';
require_once __DIR__ . '/../../hero/models/Slide.php';
require_once __DIR__ . '/../../animals/models/animalFull.php';
require_once __DIR__ . '/../../animals/models/specie.php';
require_once __DIR__ . '/../../animals/models/nutrition.php';
require_once __DIR__ . '/../../vreports/models/healthStateReport.php';

class HabitatsPagesController {

    public function habitats() {
        // 1. Get all habitats from Habitat model
        $habitatModel = new Habitat();
        $habitats = $habitatModel->getAll();

        // 2. Get Hero for Habitats Page
        $heroModel = new Hero();
        $hero = $heroModel->getByPage('habitats');
        $slides = [];

        if ($hero && $hero->has_sliders) {
            $slideModel = new Slide();
            $slides = $slideModel->getByHeroId($hero->id_hero);
        }

        // 3. Load the view
        if (file_exists(__DIR__ . '/../views/pages/habitats.php')) {
            include_once __DIR__ . '/../views/pages/habitats.php';
        } else {
            echo "Error: View habitats.php not found.";
        }
    }

    public function habitat1() {
        // Get habitat ID from URL parameter
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: /habitats/pages/habitats');
            exit;
        }

        // 1. Get habitat by ID
        $habitatModel = new Habitat();
        $habitat = $habitatModel->getById($id);
        
        if (!$habitat) {
            header('Location: /habitats/pages/habitats');
            exit;
        }

        // 2. Get animals in this habitat
        $animals = $habitatModel->getAnimalsByHabitatId($id);

        // 2.5. Get latest health state for each animal
        $healthReportModel = new HealthStateReport();
        foreach ($animals as $animal) {
            $latestReport = $healthReportModel->getLatestByAnimalId($animal->id_full_animal);
            $animal->latest_health_state = $latestReport->hsr_state ?? null;
        }

        // 3. Get filter data (without habitat since we're already in a specific habitat)
        $specieModel = new specie();
        $nutritionModel = new Nutrition();
        
        $species = $specieModel->getAll();
        $nutritions = $nutritionModel->getAll();

        // 3.5. Define allowed health states (matching back office)
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

        // 4. Get Hero for this specific habitat (if exists), otherwise use generic habitats hero
        $heroModel = new Hero();
        $hero = $heroModel->getByHabitatId($id);
        
        // If no specific hero for this habitat, use the generic habitats hero
        if (!$hero) {
            $hero = $heroModel->getByPage('habitats');
        }
        
        $slides = [];
        if ($hero && $hero->has_sliders) {
            $slideModel = new Slide();
            $slides = $slideModel->getByHeroId($hero->id_hero);
        }

        // 5. Load the view
        if (file_exists(__DIR__ . '/../views/pages/habitat1.php')) {
            include_once __DIR__ . '/../views/pages/habitat1.php';
        } else {
            echo "Error: View habitat1.php not found.";
        }
    }
}
