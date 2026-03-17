<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Hero\Controllers
 * 📂 Physical File:   App/hero/controllers/slides_gest_controller.php
 * 
 * 📝 Description:
 * Controller for managing Slides within a Hero.
 * Handles image uploads and slide CRUD.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Hero\Models\Slide (via App/hero/models/Slide.php)
 * - Arcadia\Medias\Models\Cloudinary (via App/medias/models/cloudinary.php)
 * - Arcadia\Medias\Models\Media (via App/medias/models/media.php)
 */

require_once __DIR__ . '/../models/Slide.php';
require_once __DIR__ . '/../../medias/models/cloudinary.php';
require_once __DIR__ . '/../../medias/models/Media.php';
require_once __DIR__ . '/../../../includes/helpers/csrf.php';

class SlidesGestController {

    // Show Create Form for a specific Hero
    public function create() {
        $heroId = $_GET['hero_id'] ?? null;
        if (!$heroId) {
            // If no hero ID, go back to heroes list
            header('Location: /hero/gest/start');
            exit;
        }

        $action = 'create';
        $slide = null;
        
        // Check limit before showing form (UX improvement)
        $slideModel = new Slide();
        if ($slideModel->countByHero($heroId) >= 5) {
            echo "<div class='alert alert-warning m-4'>Limit reached: This Hero already has 5 slides. Delete one first. <a href='/hero/gest/edit?id=$heroId'>Back</a></div>";
            return;
        }

        if (file_exists(__DIR__ . '/../views/gest/slide_edit.php')) {
            include_once __DIR__ . '/../views/gest/slide_edit.php';
        } else {
            echo "Error: View slide_edit.php not found.";
        }
    }

    // Show Edit Form
    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) { header('Location: /hero/gest/start'); exit; }

        $slideModel = new Slide();
        $slide = $slideModel->getById($id);
        $heroId = $slide->hero_id; // To keep context
        $action = 'edit';

        if (!$slide) { echo "Slide not found."; return; }

        if (file_exists(__DIR__ . '/../views/gest/slide_edit.php')) {
            include_once __DIR__ . '/../views/gest/slide_edit.php';
        }
    }

    // Save (Create or Update)
    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verify CSRF token
            if (!csrf_verify('slide_save')) {
                $heroId = $_POST['hero_id'] ?? '';
                header('Location: /hero/slides/create?hero_id=' . $heroId . '&msg=error&error=Invalid request. Please try again.');
                exit;
            }

            $id = $_POST['id_slide'] ?? null;
            $heroId = $_POST['hero_id'];
            $title = $_POST['title_caption'];
            $desc = $_POST['description_caption'];

            $slideModel = new Slide();
            $cloudinary = new Cloudinary();
            $mediaModel = new Media();

            try {
                if ($id) {
                    // UPDATE
                    $slideModel->update($id, $title, $desc);
                    $slideId = $id;
                } else {
                    // CREATE
                    $slideId = $slideModel->create($heroId, $title, $desc);
                    if (!$slideId) {
                        throw new Exception("Failed to create slide (maybe limit reached?).");
                    }
                }

                // 1. Upload Mobile Image
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
                    
                    $base = $urlMobile ?? $urlDesktop ?? $urlTablet;

                    $mediaId = $mediaModel->create($base, 'image', "Slide: $title", $urlTablet, $urlDesktop);
                    
                    if ($mediaId) {
                        // UNLINK OLD & LINK NEW !important to keep in mind for our experience!
                        $mediaModel->unlink('slides', $slideId);
                        $mediaModel->link($mediaId, 'slides', $slideId);
                    }
                }

                // Redirect back to the Hero Edit page
                header("Location: /hero/gest/edit?id=$heroId&msg=slide_saved");
                exit;

            } catch (Exception $e) {
                echo "Error saving slide: " . $e->getMessage();
            }
        }
    }

    // Delete
    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $slideModel = new Slide();
            // Get slide first to know where to redirect
            $slide = $slideModel->getById($id);
            if ($slide) {
                $heroId = $slide->hero_id;
                $slideModel->delete($id);
                header("Location: /hero/gest/edit?id=$heroId&msg=slide_deleted");
                exit;
            }
        }
        header('Location: /hero/gest/start');
    }
}

