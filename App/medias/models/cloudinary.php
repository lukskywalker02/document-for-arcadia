<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Medias\Models
 * 📂 Physical File:   App/medias/models/cloudinaryServices.php
 * 
 * 📝 Description:
 * Model for managing media uploads via Cloudinary.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Dotenv\Dotenv (via vendor/autoload.php)
 * - Arcadia\Cloudinary\Configuration\Configuration (via vendor/autoload.php)
 * - Arcadia\Cloudinary\Api\Upload\UploadApi (via vendor/autoload.php)
 */

require_once __DIR__ . '/../../../vendor/autoload.php';

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
use Dotenv\Dotenv;

class Cloudinary {
    
    public function __construct() {
        // 1. Load environment variables from .env file
        // Pointing to project root (3 levels up)
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
        $dotenv->safeLoad();

        // 2. Configure Cloudinary
        // The CLOUDINARY_URL env var is parsed automatically by the library if present,
        // but explicit configuration ensures control.
        if (isset($_ENV['CLOUDINARY_URL'])) {
            Configuration::instance($_ENV['CLOUDINARY_URL']);
        }
    }

    /**
     * Upload an image to Cloudinary
     * @param array $file The $_FILES['image'] array
     * @param string $folder Optional folder name in Cloudinary
     * @return string|false The secure URL or false on failure
     */
    public function upload($file, $folder = 'arcadia_uploads') {
        try {
            // Basic validation
            if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
                return false;
            }

            // Upload to Cloudinary
            $upload = new UploadApi();
            $result = $upload->upload($file['tmp_name'], [
                'folder' => $folder,
                'resource_type' => 'auto'
            ]);

            // Return the secure URL
            return $result['secure_url'];

        } catch (Exception $e) {
            // error_log("Cloudinary Upload Error: " . $e->getMessage());
            return false;
        }
    }
}