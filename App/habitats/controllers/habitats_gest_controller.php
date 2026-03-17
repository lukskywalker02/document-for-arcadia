<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Habitats\Controllers
 * 📂 Physical File:   App/habitats/controllers/habitats_gest_controller.php
 * 
 * 📝 Description:
 * Controller for managing habitats (CRUD).
 * 
 * 🔗 Dependencies:
 * - Arcadia\Habitats\Models\Habitat (via App/habitats/models/habitat.php)
 * - Arcadia\Medias\Models\Cloudinary (via App/medias/models/cloudinary.php)
 * - Arcadia\Medias\Models\Media (via App/medias/models/media.php)
 * - Arcadia\Hero\Models\Hero (via App/hero/models/Hero.php)
 * - Arcadia\Includes\Functions (via includes/functions.php)
 * 
 */

require_once __DIR__ . '/../models/habitat.php';
require_once __DIR__ . '/../../medias/models/cloudinary.php';
require_once __DIR__ . '/../../medias/models/Media.php';
require_once __DIR__ . '/../../hero/models/Hero.php';
require_once __DIR__ . '/../../../includes/functions.php';
require_once __DIR__ . '/../../../includes/helpers/csrf.php';

class HabitatsGestController {
    
    public function start() {
        $habitatModel = new Habitat();
        // Include animal count (in model function getAll we have animal count)
        $habitats = $habitatModel->getAll(true); 
        
        if (file_exists(__DIR__ . '/../views/gest/start.php')) {
            include_once __DIR__ . '/../views/gest/start.php';
        } else {
            echo "Error: View file not found at " . __DIR__ . '/../views/gest/start.php';
        }
    }

    public function create() {
        // Check if user has permission to create habitats
        if (!hasPermission('habitats-create')) {
            header('Location: /habitats/gest/start?msg=error&error=You do not have permission to create habitats');
            exit;
        }

        $action = 'create';
        $habitat = null;
        $habitatHero = null;
        
        if (file_exists(__DIR__ . '/../views/gest/edit.php')) {
            include_once __DIR__ . '/../views/gest/edit.php';
        } else {
            echo "Error: View file not found at " . __DIR__ . '/../views/gest/edit.php';
        }
    }

    public function edit() {
        // Check if user has permission to edit habitats
        if (!hasPermission('habitats-edit')) {
            header('Location: /habitats/gest/start?msg=error&error=You do not have permission to edit habitats');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) { 
            header('Location: /habitats/gest/start'); 
            exit; 
        }

        $habitatModel = new Habitat();
        $habitat = $habitatModel->getById($id);
        $action = 'edit';

        if (!$habitat) { 
            echo "Hábitat no encontrado."; 
            return; 
        }

        // Load Hero for this habitat (if exists)
        $habitatHero = null;
        try {
            $heroModel = new Hero();
            $habitatHero = $heroModel->getByHabitatId($id);
        } catch (Exception $e) {
            // If habitat_id column doesn't exist yet, $habitatHero will remain null
            $habitatHero = null;
        }

        if (file_exists(__DIR__ . '/../views/gest/edit.php')) {
            include_once __DIR__ . '/../views/gest/edit.php';
        } else {
            echo "Error: View file not found at " . __DIR__ . '/../views/gest/edit.php';
        }
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verify CSRF token
            if (!csrf_verify('habitat_save')) {
                $id = $_POST['id_habitat'] ?? '';
                if ($id) {
                    header('Location: /habitats/gest/edit?id=' . $id . '&msg=error&error=Invalid request. Please try again.');
                } else {
                    header('Location: /habitats/gest/create?msg=error&error=Invalid request. Please try again.');
                }
                exit;
            }

            $id = $_POST['id_habitat'] ?? null;
            
            // Check permissions based on whether it's create or update
            if ($id) {
                // UPDATE - requires habitats-edit permission
                if (!hasPermission('habitats-edit')) {
                    header('Location: /habitats/gest/start?msg=error&error=You do not have permission to edit habitats');
                    exit;
                }
            } else {
                // CREATE - requires habitats-create permission
                if (!hasPermission('habitats-create')) {
                    header('Location: /habitats/gest/start?msg=error&error=You do not have permission to create habitats');
                    exit;
                }
            }
            $name = trim($_POST['habitat_name'] ?? '');
            $description = trim($_POST['description_habitat'] ?? '');

            if (empty($name)) {
                header('Location: /habitats/gest/start?msg=error&error=Habitat name is required');
                exit;
            }

            $habitatModel = new Habitat();
            $cloudinary = new Cloudinary();
            $mediaModel = new Media();

            try {
                $habitatId = false;

                if ($id) {
                    // UPDATE
                    $updateResult = $habitatModel->update($id, $name, $description);
                    if ($updateResult !== false) {
                        $habitatId = $id;
                    }
                } else {
                    // CREATE
                    $habitatId = $habitatModel->create($name, $description);
                }

                if ($habitatId === false) {
                    throw new Exception("Failed to create/update habitat in Database.");
                }

                // Handle image uploads (responsive: mobile, tablet, desktop)
                $urlMobile = null;
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $urlMobile = $cloudinary->upload($_FILES['image']);
                }

                $urlTablet = null;
                if (isset($_FILES['image_tablet']) && $_FILES['image_tablet']['error'] === UPLOAD_ERR_OK) {
                    $urlTablet = $cloudinary->upload($_FILES['image_tablet']);
                }

                $urlDesktop = null;
                if (isset($_FILES['image_desktop']) && $_FILES['image_desktop']['error'] === UPLOAD_ERR_OK) {
                    $urlDesktop = $cloudinary->upload($_FILES['image_desktop']);
                }

                // If at least one image uploaded, create media record and link it
                if ($urlMobile || $urlTablet || $urlDesktop) {
                    $base = $urlMobile ?? $urlDesktop ?? $urlTablet;
                    
                    $mediaId = $mediaModel->create($base, 'image', "Habitat: $name", $urlTablet, $urlDesktop);
                    
                    if ($mediaId) {
                        // Unlink old media if updating
                        if ($id) {
                            $mediaModel->unlink('habitats', $habitatId);
                        }
                        // Link new media
                        $mediaModel->link($mediaId, 'habitats', $habitatId);
                    }
                }

                // Handle Hero creation/update for this habitat (optional, don't fail if it errors)
                $heroTitle = trim($_POST['hero_title'] ?? '');
                $heroSubtitle = trim($_POST['hero_subtitle'] ?? '');
                
                if (!empty($heroTitle)) {
                    try {
                        $heroModel = new Hero();
                        $existingHero = $heroModel->getByHabitatId($habitatId);
                        
                        // Handle Hero images (separate from habitat images)
                        $heroUrlMobile = null;
                        if (isset($_FILES['hero_image']) && $_FILES['hero_image']['error'] === UPLOAD_ERR_OK) {
                            $heroUrlMobile = $cloudinary->upload($_FILES['hero_image']);
                        }

                        $heroUrlTablet = null;
                        if (isset($_FILES['hero_image_tablet']) && $_FILES['hero_image_tablet']['error'] === UPLOAD_ERR_OK) {
                            $heroUrlTablet = $cloudinary->upload($_FILES['hero_image_tablet']);
                        }

                        $heroUrlDesktop = null;
                        if (isset($_FILES['hero_image_desktop']) && $_FILES['hero_image_desktop']['error'] === UPLOAD_ERR_OK) {
                            $heroUrlDesktop = $cloudinary->upload($_FILES['hero_image_desktop']);
                        }

                        $heroId = false;
                        if ($existingHero) {
                            $updateResult = $heroModel->update(
                                $existingHero->id_hero,
                                $heroTitle,
                                $heroSubtitle,
                                'habitats',
                                false,
                                $habitatId
                            );
                            if ($updateResult) {
                                $heroId = $existingHero->id_hero;
                            }
                        } else {
                            $heroId = $heroModel->create(
                                $heroTitle,
                                $heroSubtitle,
                                'habitats',
                                false,
                                $habitatId
                            );
                        }

                        // Handle Hero images
                        if ($heroId && ($heroUrlMobile || $heroUrlTablet || $heroUrlDesktop)) {
                            $heroBase = $heroUrlMobile ?? $heroUrlDesktop ?? $heroUrlTablet;
                            $heroMediaId = $mediaModel->create($heroBase, 'image', "Hero for Habitat: $name", $heroUrlTablet, $heroUrlDesktop);
                            
                            if ($heroMediaId) {
                                if ($existingHero) {
                                    $mediaModel->unlink('heroes', $heroId);
                                }
                                $mediaModel->link($heroMediaId, 'heroes', $heroId);
                            }
                        }
                    } catch (Exception $heroError) {
                        error_log("Error saving habitat hero: " . $heroError->getMessage());
                    }
                }

                header('Location: /habitats/gest/start?msg=saved');
                exit;

            } catch (Exception $e) {
                echo "<div class='alert alert-danger'><strong>Error saving habitat:</strong> " . htmlspecialchars($e->getMessage()) . "</div>";
            }
        }
    }

    public function delete() {
        // Check if user has permission to delete habitats
        if (!hasPermission('habitats-delete')) {
            header('Location: /habitats/gest/start?msg=error&error=You do not have permission to delete habitats');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $habitatModel = new Habitat();
            $mediaModel = new Media();
            
            // Delete media relation first
            $mediaModel->unlink('habitats', $id);
            
            // Delete habitat
            $habitatModel->delete($id);
        }
        header('Location: /habitats/gest/start?msg=deleted');
        exit;
    }
}
