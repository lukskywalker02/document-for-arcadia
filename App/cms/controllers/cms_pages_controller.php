<?php

/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Cms\Controllers
 * 📂 Physical File:   App/cms/controllers/cms_pages_controller.php
 * 
 * 📝 Description:
 * Controller for the public CMS pages (Services).
 * 
 * 🔗 Dependencies:
 * - Arcadia\Cms\Models\Service (via App/cms/models/service.php)
 * - Arcadia\Hero\Models\Hero (via App/hero/models/Hero.php)
 * - Arcadia\Hero\Models\Slide (via App/hero/models/Slide.php)
 */

require_once __DIR__ . '/../models/service.php';
require_once __DIR__ . '/../../hero/models/Hero.php';
require_once __DIR__ . '/../../hero/models/Slide.php';

class CmsPagesController {
    
    /**
     * Displays the public services page.
     * It fetches all services from the database and passes them to the view.
     */
    public function cms() {
        // 1. Get Regular Services
        $serviceModel = new Service();
        $services = $serviceModel->getRegularServices();

        // 2. Get Hero for Services Page
        $heroModel = new Hero();
        $hero = $heroModel->getByPage('services');
        $slides = [];

        if ($hero && $hero->has_sliders) {
            $slideModel = new Slide();
            $slides = $slideModel->getByHeroId($hero->id_hero);
        }
        
        // 3. Load the view and pass variables
        if (file_exists(__DIR__ . '/../views/pages/cms.php')) {
            include_once __DIR__ . '/../views/pages/cms.php';
        } else {
            echo "Error: The view 'cms.php' was not found.";
        }
    }
}
