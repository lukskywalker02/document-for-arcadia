<?php
// App/medias/views/gest/test_upload.php
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4>Test Cloudinary Upload</h4>
                </div>
                <div class="card-body">
                    <form action="/medias/gest/upload" method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Select Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Upload to Cloud</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

