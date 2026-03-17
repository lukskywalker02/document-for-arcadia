<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Hero\Controllers
 * 📂 Physical File:   App/hero/controllers/hero_gest_controller.php
 * 
 * 📝 Description:
 * Controller for managing Hero Headers (CRUD).
 * 
 * 🔗 Dependencies:
 * - Arcadia\Hero\Models\Hero (via App/hero/models/Hero.php)
 * - Arcadia\Hero\Models\Slide (via App/hero/models/Slide.php)
 * - Arcadia\Medias\Models\Cloudinary (via App/medias/models/cloudinary.php)
 * - Arcadia\Medias\Models\Media (via App/medias/models/media.php)
 * - Arcadia\Includes\Functions (via includes/functions.php)
 * 
 */

// DEBUG: Show errors explicitly
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once __DIR__ . '/../models/Hero.php';
require_once __DIR__ . '/../models/Slide.php'; 
require_once __DIR__ . '/../../medias/models/cloudinary.php';
require_once __DIR__ . '/../../medias/models/Media.php';
require_once __DIR__ . '/../../../includes/functions.php';
require_once __DIR__ . '/../../../includes/helpers/csrf.php';

class HeroGestController {
    
    // Dashboard: List all heroes (page headers in back office)
    public function start() {
        $heroModel = new Hero();
        $heroes = $heroModel->getAll();
        
        if (file_exists(__DIR__ . '/../views/gest/start.php')) {
            include_once __DIR__ . '/../views/gest/start.php';
        } else {
            echo "Error: View file not found at " . __DIR__ . '/../views/gest/start.php';
        }
    }

    // Show Create Form
    public function create() {
        // Hero (Page Headers) can only be managed by Admin
        $isAdmin = isset($_SESSION['user']['role_name']) && $_SESSION['user']['role_name'] === 'Admin';
        if (!$isAdmin) {
            header('Location: /hero/gest/start?msg=error&error=You do not have permission to create page headers');
            exit;
        }

        $action = 'create';
        $hero = null;
        $slides = []; 
        if (file_exists(__DIR__ . '/../views/gest/edit.php')) {
            include_once __DIR__ . '/../views/gest/edit.php';
        }
    }

    // Show Edit Form
    public function edit() {
        // Hero (Page Headers) can only be managed by Admin
        $isAdmin = isset($_SESSION['user']['role_name']) && $_SESSION['user']['role_name'] === 'Admin';
        if (!$isAdmin) {
            header('Location: /hero/gest/start?msg=error&error=You do not have permission to edit page headers');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) { header('Location: /hero/gest/start'); exit; }

        $heroModel = new Hero();
        $hero = $heroModel->getById($id);
        
        // DEBUG EXTREME: What does the database return
        // echo "<pre>"; var_dump($hero); echo "</pre>"; exit; 

        $action = 'edit';

        if (!$hero) { echo "Hero not found."; return; }

        // Load Slides if hero exists
        $slideModel = new Slide();
        $slides = $slideModel->getByHeroId($id);

        if (file_exists(__DIR__ . '/../views/gest/edit.php')) {
            include_once __DIR__ . '/../views/gest/edit.php';
        }
    }

    // Save (Create or Update)
    public function save() {
        // Hero (Page Headers) can only be managed by Admin
        $isAdmin = isset($_SESSION['user']['role_name']) && $_SESSION['user']['role_name'] === 'Admin';
        if (!$isAdmin) {
            header('Location: /hero/gest/start?msg=error&error=You do not have permission to save page headers');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verify CSRF token
            if (!csrf_verify('hero_save')) {
                header('Location: /hero/gest/start?msg=error&error=Invalid request. Please try again.');
                exit;
            }

            $id = $_POST['id_hero'] ?? null;
            $title = $_POST['hero_title'];
            $subtitle = $_POST['hero_subtitle'];
            $pageName = $_POST['page_name'];
            $hasCarousel = isset($_POST['has_sliders']) ? 1 : 0;

            $heroModel = new Hero();
            $cloudinary = new Cloudinary();
            $mediaModel = new Media();

            try {
                $heroId = false;

                if ($id) {
                    // UPDATE
                    if ($heroModel->update($id, $title, $subtitle, $pageName, $hasCarousel)) {
                        $heroId = $id;
                    }
                } else {
                    // CREATE
                    $heroId = $heroModel->create($title, $subtitle, $pageName, $hasCarousel);
                }

                if (!$heroId) {
                    throw new Exception("Failed to save Hero in DB.");
                }

                // 1. Upload Main Image (Mobile)
                $urlMobile = null;
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $urlMobile = $cloudinary->upload($_FILES['image']);
                }

                // 2. Upload Tablet Image
                $urlTablet = null;
                if (isset($_FILES['image_tablet']) && $_FILES['image_tablet']['error'] === UPLOAD_ERR_OK) {
                    $urlTablet = $cloudinary->upload($_FILES['image_tablet']);
                }

                // 3. Upload Desktop Image
                $urlDesktop = null;
                if (isset($_FILES['image_desktop']) && $_FILES['image_desktop']['error'] === UPLOAD_ERR_OK) {
                    $urlDesktop = $cloudinary->upload($_FILES['image_desktop']);
                }

                // Handle Image Upload logic
                if ($urlMobile || $urlTablet || $urlDesktop) {
                    
                    // Fallback logic: if only desktop is uploaded, use it as base? 
                    // For now, we need at least one base URL. 
                    // Let's assume if they update responsive, they update mobile too OR we fetch existing?
                    // Simplified: We use whatever new URL is available as base if mobile is missing.
                    
                    $base = $urlMobile ?? $urlDesktop ?? $urlTablet;

                    $mediaId = $mediaModel->create($base, 'image', "Hero: $title", $urlTablet, $urlDesktop);
                    
                    if ($mediaId) {
                        // UNLINK OLD & LINK NEW
                        $mediaModel->unlink('heroes', $heroId);
                        $mediaModel->link($mediaId, 'heroes', $heroId);
                    }
                }

                header('Location: /hero/gest/start?msg=saved');
                exit;

            } catch (Exception $e) {
                echo "Error saving hero: " . $e->getMessage();
            }
        }
    }
    
    // Delete
    public function delete() {
        // Hero (Page Headers) can only be managed by Admin
        $isAdmin = isset($_SESSION['user']['role_name']) && $_SESSION['user']['role_name'] === 'Admin';
        if (!$isAdmin) {
            header('Location: /hero/gest/start?msg=error&error=You do not have permission to delete page headers');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $heroModel = new Hero();
            $heroModel->delete($id);
        }
        header('Location: /hero/gest/start?msg=deleted');
        exit;
    }
}
