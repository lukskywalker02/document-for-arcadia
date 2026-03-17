<?php

/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Home\Controllers
 * 📂 Physical File:   App/home/controllers/home_pages_controller.php
 * 
 * 📝 Description:
 * Controller for the public Home page.
 * Handles fetching of dynamic content (Hero, Slides, Featured Services, Content Bricks).
 * 
 * 🔗 Dependencies:
 * - Arcadia\CMS\Models\Service (via App/cms/models/service.php)
 * - Arcadia\CMS\Models\Brick (via App/cms/models/brick.php)
 * - Arcadia\Hero\Models\Hero (via App/hero/models/Hero.php)
 * - Arcadia\Hero\Models\Slide (via App/hero/models/Slide.php)
 * - Arcadia\Testimonials\Models\Testimonial (via App/testimonials/models/testimonial.php)
 * - Arcadia\Users\Models\User (via App/users/models/user.php)
 * - Arcadia\Employees\Models\Employee (via App/employees/models/employee.php)
 * - Arcadia\Schedules\Models\Schedule (via App/schedules/models/schedule.php)
 * - Arcadia\Animals\Models\AnimalFull (via App/animals/models/animalFull.php)
 * - Arcadia\Animals\Models\FeedingLog (via App/animals/models/feedingLog.php)
 * - Arcadia\Habitats\Models\Habitat (via App/habitats/models/habitat.php)
 * - Arcadia\Habitats\Models\HabitatSuggestion (via App/habitats/models/habitatSuggestion.php)
 * - Arcadia\VReports\Models\HealthStateReport (via App/vreports/models/healthStateReport.php)
 * - Arcadia\Contact\Models\FormContact (via App/contact/models/formContact.php)
 * - Arcadia\Includes\Functions (via includes/functions.php)
 */

require_once __DIR__ . '/../../cms/models/service.php';
require_once __DIR__ . '/../../cms/models/brick.php';
require_once __DIR__ . '/../../hero/models/Hero.php';
require_once __DIR__ . '/../../hero/models/Slide.php';
require_once __DIR__ . '/../../testimonials/models/testimonial.php';
require_once __DIR__ . '/../../users/models/user.php';
require_once __DIR__ . '/../../employees/models/employee.php';
require_once __DIR__ . '/../../schedules/models/schedule.php';
require_once __DIR__ . '/../../animals/models/animalFull.php';
require_once __DIR__ . '/../../animals/models/feedingLog.php';
require_once __DIR__ . '/../../habitats/models/habitat.php';
require_once __DIR__ . '/../../habitats/models/habitatSuggestion.php';
require_once __DIR__ . '/../../vreports/models/healthStateReport.php';
require_once __DIR__ . '/../../contact/models/formContact.php';
require_once __DIR__ . '/../../../includes/functions.php';

class HomePagesController
{

    public function index()
    {
        // 1. Get Featured Services (Cards)
        $serviceModel = new Service();
        $featuredServices = $serviceModel->getFeatured();

        // 2. Get Hero for Home Page
        $heroModel = new Hero();
        $hero = $heroModel->getByPage('home');
        $slides = [];

        // 3. Get Slides if Hero exists and has carousel
        if ($hero && $hero->has_sliders) {
            $slideModel = new Slide();
            $slides = $slideModel->getByHeroId($hero->id_hero);
        }

        // 4. Get Home Content Brick (More About Us)
        $brickModel = new Brick();
        $homeBrick = $brickModel->getByPage('home');

        // 5. Get Best Testimonial (highest rating, or most recent if tie)
        $testimonialModel = new Testimonial();
        $bestTestimonial = $testimonialModel->getBest();

        // 6. Load view
        if (file_exists(__DIR__ . '/../views/pages/index.php')) {
            include_once __DIR__ . '/../views/pages/index.php';
        } else {
            echo "Error: View index.php not found.";
        }
    }

    public function start()
    {
        // Get last elements from each model (only if user has permissions)
        $lastItems = [];

        // Users
        if (hasPermission('users-view') || hasPermission('users-create') || hasPermission('users-edit') || hasPermission('users-delete')) {
            $lastItems['user'] = User::getLast();
        }

        // Employees
        if (hasPermission('users-view') || hasPermission('users-create') || hasPermission('users-edit') || hasPermission('users-delete')) {
            $lastItems['employee'] = Employee::getLast();
        }

        // Schedules
        if (hasPermission('schedules-view') || hasPermission('schedules-edit')) {
            $scheduleModel = new Schedule();
            $lastItems['schedule'] = $scheduleModel->getLast();
        }

        // Services
        if (hasPermission('services-view') || hasPermission('services-edit') || hasPermission('services-create') || hasPermission('services-delete')) {
            $serviceModel = new Service();
            $lastItems['service'] = $serviceModel->getLast();
            $lastItems['serviceLog'] = $serviceModel->getLastLog();
        }

        // Content Blocks
        if (hasPermission('services-view') || hasPermission('services-edit') || hasPermission('services-create') || hasPermission('services-delete')) {
            $brickModel = new Brick();
            $lastItems['brick'] = $brickModel->getLast();
        }

        // Animals
        if (hasPermission('animals-view') || hasPermission('animals-create') || hasPermission('animals-edit') || hasPermission('animals-delete')) {
            $animalModel = new AnimalFull();
            $lastItems['animal'] = $animalModel->getLast();
        }

        // Feeding Logs
        if (hasPermission('animal_feeding-view') || hasPermission('animal_feeding-assign')) {
            $feedingModel = new FeedingLog();
            $lastItems['feeding'] = $feedingModel->getLast();
        }

        // Habitats
        if (hasPermission('habitats-view') || hasPermission('habitats-create') || hasPermission('habitats-edit') || hasPermission('habitats-delete')) {
            $habitatModel = new Habitat();
            $lastItems['habitat'] = $habitatModel->getLast();
        }

        // Habitat Suggestions
        if (hasPermission('habitat_suggestions-view') || hasPermission('habitat_suggestions-manage')) {
            $habitatSuggestionModel = new HabitatSuggestion();
            $lastItems['habitatSuggestion'] = $habitatSuggestionModel->getLast();
        }

        // Health Reports
        if (hasPermission('vet_reports-view') || hasPermission('vet_reports-create') || hasPermission('vet_reports-edit')) {
            $healthReportModel = new HealthStateReport();
            $lastItems['healthReport'] = $healthReportModel->getLast();
        }

        // Testimonials
        $isAdmin = isset($_SESSION['user']['role_name']) && $_SESSION['user']['role_name'] === 'Admin';
        $isEmployee = isset($_SESSION['user']['role_name']) && $_SESSION['user']['role_name'] === 'Employee';
        if ($isAdmin || $isEmployee) {
            $testimonialModel = new Testimonial();
            $lastItems['testimonial'] = $testimonialModel->getLast();
        }

        // Contact Forms
        if ($isAdmin || $isEmployee) {
            $contactModel = new FormContact();
            $lastItems['contact'] = $contactModel->getLast();
        }

        // Page Headers (Hero)
        if (isset($_SESSION['user']['role_name']) && $_SESSION['user']['role_name'] === 'Admin') {
            $heroModel = new Hero();
            $lastItems['hero'] = $heroModel->getLast();
        }

        if (file_exists(__DIR__ . '/../views/gest/start.php')) {
            include_once __DIR__ . '/../views/gest/start.php';
        } else {
            echo "Error: View not found at " . __DIR__ . '/../views/gest/start.php';
        }
    }
}
