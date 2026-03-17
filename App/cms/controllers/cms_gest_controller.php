<?php

/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\CMS\Controllers
 * 📂 Physical File:   App/cms/controllers/cms_gest_controller.php
 * 
 * 📝 Description:
 * Controller for managing Zoo Services (CMS).
 * Handles CRUD operations and image uploads via Cloudinary.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Cms\Models\Service (via App/cms/models/service.php)
 * - Arcadia\Medias\Models\Cloudinary (via App/medias/models/cloudinary.php)
 * - Arcadia\Medias\Models\Media (via App/medias/models/media.php)
 * - Arcadia\Includes\Functions (via includes/functions.php)
 */

require_once __DIR__ . '/../models/service.php';
require_once __DIR__ . '/../../medias/models/cloudinary.php';
require_once __DIR__ . '/../../medias/models/Media.php';
require_once __DIR__ . '/../../../includes/functions.php';

class CmsGestController
{

    // Dashboard: List all services
    public function start()
    {
        $serviceModel = new Service();
        $services = $serviceModel->getAll();

        if (file_exists(__DIR__ . '/../views/gest/start.php')) {
            include_once __DIR__ . '/../views/gest/start.php';
        } else {
            echo "Error: View file not found at " . __DIR__ . '/../views/gest/start.php';
        }
    }

    public function create()
    {
        // Check if user has permission to create services
        if (!hasPermission('services-create')) {
            header('Location: /cms/gest/start?msg=error&error=You do not have permission to create services');
            exit;
        }

        $action = 'create';
        $service = null;
        if (file_exists(__DIR__ . '/../views/gest/edit.php')) {
            include_once __DIR__ . '/../views/gest/edit.php';
        }
    }

    public function edit()
    {
        // Check if user has permission to edit services
        if (!hasPermission('services-edit')) {
            header('Location: /cms/gest/start?msg=error&error=You do not have permission to edit services');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /cms/gest/start');
            exit;
        }

        $serviceModel = new Service();
        $service = $serviceModel->getById($id);
        $action = 'edit';

        if (!$service) {
            echo "Service not found.";
            return;
        }

        if (file_exists(__DIR__ . '/../views/gest/edit.php')) {
            include_once __DIR__ . '/../views/gest/edit.php';
        }
    }

    // Save (Create or Update)
    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/../../../includes/helpers/csrf.php';
            
            // Verify CSRF token
            if (!csrf_verify('service_save')) {
                header('Location: /cms/gest/start?msg=error&error=Invalid request. Please try again.');
                exit;
            }

            $id = $_POST['id_service'] ?? null;

            // Check permissions based on whether it's create or update
            if ($id) {
                // UPDATE - requires services-edit permission
                if (!hasPermission('services-edit')) {
                    header('Location: /cms/gest/start?msg=error&error=You do not have permission to edit services');
                    exit;
                }
            } else {
                // CREATE - requires services-create permission
                if (!hasPermission('services-create')) {
                    header('Location: /cms/gest/start?msg=error&error=You do not have permission to create services');
                    exit;
                }
            }
            $title = $_POST['service_title'];
            $desc = $_POST['service_description'];
            $link = $_POST['link'] ?? '';
            $type = $_POST['type'] ?? 'service';

            // Get logged user ID or fallback to 1 (Admin/Dev)
            $userId = $_SESSION['user']['id_user'] ?? 1;

            $serviceModel = new Service();
            $cloudinary = new Cloudinary();
            $mediaModel = new Media();

            try {
                $serviceId = false;

                if ($id) {
                    // UPDATE
                    $updateResult = $serviceModel->update($id, $title, $desc, $link, $type, $userId);
                    if ($updateResult !== false) {
                        $serviceId = $id;
                    }
                } else {
                    // CREATE
                    $serviceId = $serviceModel->create($title, $desc, $link, $type, $userId);
                }

                if ($serviceId === false) {
                    throw new Exception("Failed to create/update service in Database.");
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

                // If at least one image uploaded
                if ($urlMobile || $urlTablet || $urlDesktop) {
                    // Use Mobile as base image (first priority), then Tablet, then Desktop as fallback
                    $base = $urlMobile ?? $urlTablet ?? $urlDesktop;

                    $mediaId = $mediaModel->create($base, 'image', "Service: $title", $urlTablet, $urlDesktop);

                    if ($mediaId) {
                        // Unlink old
                        $mediaModel->unlink('services', $serviceId);
                        // Link new
                        $mediaModel->link($mediaId, 'services', $serviceId);
                    }
                }

                header('Location: /cms/gest/start?msg=saved');
                exit;
            } catch (Exception $e) {
                echo "<div class='alert alert-danger'><strong>Error saving service:</strong> " . $e->getMessage() . "</div>";
            }
        }
    }

    // Delete
    public function delete()
    {
        // Check if user has permission to delete services
        if (!hasPermission('services-delete')) {
            header('Location: /cms/gest/start?msg=error&error=You do not have permission to delete services');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $serviceModel = new Service();
            $serviceModel->delete($id);
        }
        header('Location: /cms/gest/start?msg=deleted');
        exit;
    }

    // Show Service Logs
    public function logs()
    {
        $serviceModel = new Service();
        $logs = $serviceModel->getLogs();

        if (file_exists(__DIR__ . '/../views/gest/logs.php')) {
            include_once __DIR__ . '/../views/gest/logs.php';
        } else {
            echo "Error: View logs.php not found.";
        }
    }
}
