<?php

/**
 * 🏛️ ARQUITECTURA ARCADIA (Código Simulativo Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Animals\Controllers
 * 📂 Physical File:   App/animals/controllers/animals_gest_controller.php
 * 
 * 📝 Description:
 * Controller for the administrative management of animals.
 * Implements permission logic (RBAC) and CRUD.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Animals\Models\AnimalFull (via App/animals/models/animalFull.php)
 * - Arcadia\Animals\Models\AnimalGeneral (via App/animals/models/animalGeneral.php)
 * - Arcadia\Animals\Models\Category (via App/animals/models/category.php)
 * - Arcadia\Animals\Models\Specie (via App/animals/models/specie.php)
 * - Arcadia\Animals\Models\Nutrition (via App/animals/models/nutrition.php)
 * - Arcadia\Animals\Models\FeedingLog (via App/animals/models/feedingLog.php)
 * - Arcadia\Habitats\Models\Habitat (via App/habitats/models/habitat.php)
 * - Arcadia\Medias\Models\Cloudinary (via App/medias/models/cloudinary.php)
 * - Arcadia\Medias\Models\Media (via App/medias/models/media.php)
 * - Arcadia\Includes\Functions (via includes/functions.php)
 */

require_once __DIR__ . "/../models/animalFull.php";
require_once __DIR__ . "/../models/animalGeneral.php";
require_once __DIR__ . "/../models/category.php";
require_once __DIR__ . "/../models/specie.php";
require_once __DIR__ . "/../models/nutrition.php";
require_once __DIR__ . "/../models/feedingLog.php";
require_once __DIR__ . "/../../habitats/models/habitat.php";
require_once __DIR__ . "/../../medias/models/cloudinary.php";
require_once __DIR__ . "/../../medias/models/Media.php";
require_once __DIR__ . "/../../../includes/functions.php";
require_once __DIR__ . "/../../../includes/helpers/csrf.php";

class AnimalsGestController
{
    /**
     * Dashboard: List all animals, categories and species
     */
    public function start()
    {
        $animalModel = new AnimalFull();
        $categoryModel = new category();
        $specieModel = new specie();
        $nutritionModel = new Nutrition();
        $feedingModel = new FeedingLog();
        
        $animals = $animalModel->getAll();
        $categories = $categoryModel->getAll();
        $species = $specieModel->getAll();
        $nutritions = $nutritionModel->getAll();
        $feedings = $feedingModel->getAll();
        
        if (file_exists(__DIR__ . '/../views/gest/start.php')) {
            include_once __DIR__ . '/../views/gest/start.php';
        } else {
            echo "Error: View file not found at " . __DIR__ . '/../views/gest/start.php';
        }
    }

    /**
     * Save category (create or update)
     */
    public function saveCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verify CSRF token
            if (!csrf_verify('animal_save_category')) {
                header('Location: /animals/gest/start?msg=error&error=Invalid request. Please try again.');
                exit;
            }

            $id = $_POST['id_category'] ?? null;
            
            // Check permissions based on whether it's create or update
            if ($id) {
                // UPDATE - requires animals-edit permission
                if (!hasPermission('animals-edit')) {
                    header('Location: /animals/gest/start?msg=error&error=You do not have permission to edit categories');
                    exit;
                }
            } else {
                // CREATE - requires animals-create permission
                if (!hasPermission('animals-create')) {
                    header('Location: /animals/gest/start?msg=error&error=You do not have permission to create categories');
                    exit;
                }
            }
            
            $name = trim($_POST['category_name'] ?? '');
            
            if (empty($name)) {
                header('Location: /animals/gest/start?msg=error&error=Category name is required');
                exit;
            }
            
            $categoryModel = new category();
            
            if ($id) {
                // UPDATE
                $result = $categoryModel->update($id, $name);
            } else {
                // CREATE
                $result = $categoryModel->create($name);
            }
            
            if ($result) {
                header('Location: /animals/gest/start?msg=saved');
            } else {
                header('Location: /animals/gest/start?msg=error&error=Failed to save category');
            }
            exit;
        }
    }

    /**
     * Delete category
     */
    public function deleteCategory()
    {
        if (!hasPermission('animals-delete')) {
            header('Location: /animals/gest/start?msg=error&error=You do not have permission to delete categories');
            exit;
        }
        
        $id = $_GET['id'] ?? null;
        if ($id) {
            $categoryModel = new category();
            $categoryModel->delete($id);
        }
        header('Location: /animals/gest/start?msg=deleted');
        exit;
    }

    /**
     * Save species (create or update)
     */
    public function saveSpecies()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verify CSRF token
            if (!csrf_verify('animal_save_species')) {
                header('Location: /animals/gest/start?msg=error&error=Invalid request. Please try again.');
                exit;
            }

            $id = $_POST['id_specie'] ?? null;
            
            // Check permissions based on whether it's create or update
            if ($id) {
                // UPDATE - requires animals-edit permission
                if (!hasPermission('animals-edit')) {
                    header('Location: /animals/gest/start?msg=error&error=You do not have permission to edit species');
                    exit;
                }
            } else {
                // CREATE - requires animals-create permission
                if (!hasPermission('animals-create')) {
                    header('Location: /animals/gest/start?msg=error&error=You do not have permission to create species');
                    exit;
                }
            }
            
            $categoryId = $_POST['category_id'] ?? null;
            $name = trim($_POST['specie_name'] ?? '');
            
            if (empty($name) || empty($categoryId)) {
                header('Location: /animals/gest/start?msg=error&error=Species name and category are required');
                exit;
            }
            
            $specieModel = new specie();
            
            if ($id) {
                // UPDATE
                $result = $specieModel->update($id, $categoryId, $name);
            } else {
                // CREATE
                $result = $specieModel->create($categoryId, $name);
            }
            
            if ($result) {
                header('Location: /animals/gest/start?msg=saved');
            } else {
                header('Location: /animals/gest/start?msg=error&error=Failed to save species');
            }
            exit;
        }
    }

    /**
     * Delete species
     */
    public function deleteSpecies()
    {
        if (!hasPermission('animals-delete')) {
            header('Location: /animals/gest/start?msg=error&error=You do not have permission to delete species');
            exit;
        }
        
        $id = $_GET['id'] ?? null;
        if ($id) {
            $specieModel = new specie();
            $specieModel->delete($id);
        }
        header('Location: /animals/gest/start?msg=deleted');
        exit;
    }

    /**
     * Save nutrition (create or update)
     */
    public function saveNutrition()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verify CSRF token
            if (!csrf_verify('animal_save_nutrition')) {
                header('Location: /animals/gest/start?msg=error&error=Invalid request. Please try again.');
                exit;
            }

            $id = $_POST['id_nutrition'] ?? null;
            
            // Check permissions based on whether it's create or update
            if ($id) {
                // UPDATE - requires animals-edit permission
                if (!hasPermission('animals-edit')) {
                    header('Location: /animals/gest/start?msg=error&error=You do not have permission to edit nutrition plans');
                    exit;
                }
            } else {
                // CREATE - requires animals-create permission
                if (!hasPermission('animals-create')) {
                    header('Location: /animals/gest/start?msg=error&error=You do not have permission to create nutrition plans');
                    exit;
                }
            }
            
            $nutritionType = $_POST['nutrition_type'] ?? '';
            $foodType = $_POST['food_type'] ?? '';
            $foodQty = $_POST['food_qtty'] ?? null;
            
            if (empty($nutritionType) || empty($foodType) || empty($foodQty)) {
                header('Location: /animals/gest/start?msg=error&error=All nutrition fields are required');
                exit;
            }
            
            $nutritionModel = new Nutrition();
            
            if ($id) {
                // UPDATE
                $result = $nutritionModel->update($id, $nutritionType, $foodType, (int)$foodQty);
            } else {
                // CREATE
                $result = $nutritionModel->create($nutritionType, $foodType, (int)$foodQty);
            }
            
            if ($result) {
                header('Location: /animals/gest/start?msg=saved');
            } else {
                header('Location: /animals/gest/start?msg=error&error=Failed to save nutrition plan');
            }
            exit;
        }
    }

    /**
     * Delete nutrition
     */
    public function deleteNutrition()
    {
        if (!hasPermission('animals-delete')) {
            header('Location: /animals/gest/start?msg=error&error=You do not have permission to delete nutrition plans');
            exit;
        }
        
        $id = $_GET['id'] ?? null;
        if ($id) {
            $nutritionModel = new Nutrition();
            $nutritionModel->delete($id);
        }
        header('Location: /animals/gest/start?msg=deleted');
        exit;
    }

    /**
     * Show form to create a new animal
     */
    public function create()
    {
        // Check if user has permission to create animals
        if (!hasPermission('animals-create')) {
            header('Location: /animals/gest/start?msg=error&error=You do not have permission to create animals');
            exit;
        }

        $action = 'create';
        $animal = null;
        
        // Load data for dropdowns
        $categoryModel = new category();
        $specieModel = new specie();
        $habitatModel = new Habitat();
        $nutritionModel = new Nutrition();
        
        $categories = $categoryModel->getAll();
        $species = $specieModel->getAll();
        $habitats = $habitatModel->getAll();
        $nutritions = $nutritionModel->getAll();
        
        if (file_exists(__DIR__ . '/../views/gest/edit.php')) {
            include_once __DIR__ . '/../views/gest/edit.php';
        } else {
            echo "Error: View file not found at " . __DIR__ . '/../views/gest/edit.php';
        }
    }

    /**
     * Show form to edit an existing animal
     */
    public function edit()
    {
        // Check if user has permission to edit animals
        if (!hasPermission('animals-edit')) {
            header('Location: /animals/gest/start?msg=error&error=You do not have permission to edit animals');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /animals/gest/start');
            exit;
        }

        $animalFullModel = new AnimalFull();
        $animal = $animalFullModel->getById($id);
        
        if (!$animal) {
            echo "Animal not found.";
            return;
        }

        $action = 'edit';
        
        // Load data for dropdowns
        $categoryModel = new category();
        $specieModel = new specie();
        $habitatModel = new Habitat();
        $nutritionModel = new Nutrition();
        
        $categories = $categoryModel->getAll();
        $species = $specieModel->getAll();
        $habitats = $habitatModel->getAll();
        $nutritions = $nutritionModel->getAll();
        
        if (file_exists(__DIR__ . '/../views/gest/edit.php')) {
            include_once __DIR__ . '/../views/gest/edit.php';
        } else {
            echo "Error: View file not found at " . __DIR__ . '/../views/gest/edit.php';
        }
    }

    /**
     * Save (Create or Update) animal
     */
    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verify CSRF token
            if (!csrf_verify('animal_save')) {
                $id = $_POST['id_full_animal'] ?? '';
                if ($id) {
                    header('Location: /animals/gest/edit?id=' . $id . '&msg=error&error=Invalid request. Please try again.');
                } else {
                    header('Location: /animals/gest/create?msg=error&error=Invalid request. Please try again.');
                }
                exit;
            }

            $id = $_POST['id_full_animal'] ?? null;
            
            // Check permissions based on whether it's create or update
            if ($id) {
                // UPDATE - requires animals-edit permission
                if (!hasPermission('animals-edit')) {
                    header('Location: /animals/gest/start?msg=error&error=You do not have permission to edit animals');
                    exit;
                }
            } else {
                // CREATE - requires animals-create permission
                if (!hasPermission('animals-create')) {
                    header('Location: /animals/gest/start?msg=error&error=You do not have permission to create animals');
                    exit;
                }
            }
            $animalName = $_POST['animal_name'] ?? '';
            $specieId = $_POST['specie_id'] ?? null;
            $gender = $_POST['gender'] ?? '';
            $habitatId = $_POST['habitat_id'] ?? null;
            $nutritionId = $_POST['nutrition_id'] ?? null;

            $animalGeneralModel = new AnimalGeneral();
            $animalFullModel = new AnimalFull();
            $cloudinary = new Cloudinary();
            $mediaModel = new Media();

            try {
                $animalGeneralId = false;
                $animalFullId = false;

                if ($id) {
                    // UPDATE MODE
                    // Get existing animal_full to get animal_g_id
                    $existingAnimal = $animalFullModel->getById($id);
                    if (!$existingAnimal) {
                        throw new Exception("Animal not found for update.");
                    }
                    
                    $animalGeneralId = $existingAnimal->animal_g_id;
                    
                    // Update animal_general
                    $updateGeneral = $animalGeneralModel->update($animalGeneralId, $animalName, $specieId, $gender);
                    if (!$updateGeneral) {
                        throw new Exception("Failed to update animal general info.");
                    }
                    
                    // Update animal_full (habitat and nutrition)
                    $updateFull = $animalFullModel->update($id, $habitatId, $nutritionId);
                    if (!$updateFull) {
                        throw new Exception("Failed to update animal full profile.");
                    }
                    
                    $animalFullId = $id;
                } else {
                    // CREATE MODE
                    // 1. Create animal_general
                    $animalGeneralId = $animalGeneralModel->create($animalName, $specieId, $gender);
                    if ($animalGeneralId === false) {
                        throw new Exception("Failed to create animal general record.");
                    }
                    
                    // 2. Create animal_full
                    $animalFullId = $animalFullModel->create($animalGeneralId, $habitatId, $nutritionId);
                    if ($animalFullId === false) {
                        throw new Exception("Failed to create animal full profile.");
                    }
                }

                // 3. Handle image uploads (responsive: mobile, tablet, desktop)
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
                    
                    $mediaId = $mediaModel->create($base, 'image', "Animal: $animalName", $urlTablet, $urlDesktop);
                    
                    if ($mediaId) {
                        // Unlink old media if updating
                        if ($id) {
                            $mediaModel->unlink('animal_full', $animalFullId);
                        }
                        // Link new media
                        $mediaModel->link($mediaId, 'animal_full', $animalFullId);
                    }
                }

                header('Location: /animals/gest/start?msg=saved');
                exit;

            } catch (Exception $e) {
                echo "<div class='alert alert-danger'><strong>Error saving animal:</strong> " . htmlspecialchars($e->getMessage()) . "</div>";
            }
        }
    }

    /**
     * Delete an animal
     */
    public function delete()
    {
        // Check if user has permission to delete animals
        if (!hasPermission('animals-delete')) {
            header('Location: /animals/gest/start?msg=error&error=You do not have permission to delete animals');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $animalFullModel = new AnimalFull();
            $animalFull = $animalFullModel->getById($id);
            
            if ($animalFull) {
                // Delete media relation first
                $mediaModel = new Media();
                $mediaModel->unlink('animal_full', $id);
                
                // Delete animal_full (this should cascade to animal_general if FK is set)
                $animalFullModel->delete($id);
                
                // Also delete animal_general explicitly (if cascade not set)
                $animalGeneralModel = new AnimalGeneral();
                $animalGeneralModel->delete($animalFull->animal_g_id);
            }
        }
        header('Location: /animals/gest/start?msg=deleted');
        exit;
    }
}
