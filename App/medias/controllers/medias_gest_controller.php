<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Medias\Controllers
 * 📂 Physical File:   App/medias/controllers/medias_gest_controller.php
 * 
 * 📝 Description:
 * Controller for Media Management (Upload & Gallery).
 * 
 * 🔗 Dependencies:
 * - Arcadia\Medias\Models\Cloudinary
 * - Arcadia\Medias\Models\Media
 */

require_once __DIR__ . '/../models/cloudinary.php';
require_once __DIR__ . '/../models/Media.php';

class MediasGestController {
    
    // Test the upload form
    public function test() {
        include_once __DIR__ . '/../views/gest/test_upload.php';
    }

    // Upload the image to Cloudinary and save to the database
    public function upload() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
            
            // 1. Upload to Cloudinary
            $cloudinary = new Cloudinary();
            $url = $cloudinary->upload($_FILES['image']);

            if ($url) {
                // 2. Save to Database (Media table)
                $mediaModel = new Media();
                $id = $mediaModel->create($url, 'image', 'Uploaded via Media Manager');

                if ($id) {
                    echo "<div class='alert alert-success'>
                            <strong>Success!</strong> Image uploaded and saved to DB.<br>
                            <strong>Cloud URL:</strong> <a href='$url' target='_blank'>Link</a><br>
                            <strong>DB ID:</strong> $id<br>
                            <img src='$url' style='max-width: 300px; margin-top: 10px;'>
                          </div>";
                } else {
                    echo "<div class='alert alert-warning'>
                            <strong>Warning!</strong> Image uploaded to Cloud, but DB insert failed.
                          </div>";
                }

            } else {
                echo "<div class='alert alert-danger'><strong>Error!</strong> Upload to Cloudinary failed.</div>";
            }
        } else {
            echo "No file received.";
        }
    }
}
