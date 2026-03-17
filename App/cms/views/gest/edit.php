<?php
// App/cms/views/gest/edit.php
$isEdit = ($action === 'edit');
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0"><?= $isEdit ? 'Modify Service' : 'Create New Service' ?></h4>
                </div>
                <div class="card-body">
                    <?php require_once __DIR__ . '/../../../../includes/helpers/csrf.php'; ?>
                    
                    <form action="/cms/gest/save" method="POST" enctype="multipart/form-data">
                        <?= csrf_field('service_save') ?>
                        
                        <!-- Hidden ID for Update (CRITICAL) -->
                        <?php if ($isEdit && isset($service->id_service)): ?>
                            <input type="hidden" name="id_service" value="<?= $service->id_service ?>">
                        <?php endif; ?>

                        <!-- Service Title -->
                        <div class="mb-3">
                            <label for="service_title" class="form-label fw-bold">Service Title</label>
                            <input type="text" class="form-control" id="service_title" name="service_title" 
                                   value="<?= $isEdit ? htmlspecialchars($service->service_title) : '' ?>" 
                                   placeholder="E.g., Zoo Restaurant" required>
                        </div>

                        <!-- Service Type -->
                        <div class="mb-3">
                            <label for="type" class="form-label fw-bold">Content Type</label>
                            <select class="form-select" id="type" name="type">
                                <option value="service" <?= ($isEdit && $service->type === 'service') ? 'selected' : '' ?>>Regular Service</option>
                                <option value="habitat" <?= ($isEdit && $service->type === 'habitat') ? 'selected' : '' ?>>Habitat Card</option>
                                <option value="featured" <?= ($isEdit && $service->type === 'featured') ? 'selected' : '' ?>>Homepage Feature</option>
                            </select>
                            <div class="form-text">Choose where this content belongs.</div>
                        </div>

                        <!-- Link URL -->
                        <div class="mb-3">
                            <label for="link" class="form-label fw-bold">Link URL (for "MORE" button)</label>
                            <input type="text" class="form-control" id="link" name="link" 
                                   value="<?= $isEdit ? htmlspecialchars($service->link ?? '') : '' ?>" 
                                   placeholder="E.g., /habitats/pages/habitats">
                            <div class="form-text">Leave empty if no button is needed.</div>
                        </div>

                        <!-- RESPONSIVE IMAGES -->
                        <div class="card mb-3 border-light bg-light">
                            <div class="card-body">
                                <h5 class="card-title text-muted mb-3"><i class="bi bi-images"></i> Responsive Images</h5>
                                
                                <!-- Mobile Image (Main) -->
                                <div class="mb-3">
                                    <label for="image" class="form-label fw-bold">Main Image (Mobile/Default)</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*" <?= $isEdit ? '' : 'required' ?>>
                                    <div class="form-text">Required. Used for mobile and as fallback.</div>
                                    <?php if ($isEdit && !empty($service->media_path)): ?>
                                        <div class="mt-2 p-2 bg-white border rounded">
                                            <img src="<?= $service->media_path ?>" alt="Mobile" height="80" class="rounded">
                                            <span class="badge bg-success ms-2">Current</span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Tablet Image -->
                                <div class="mb-3">
                                    <label for="image_tablet" class="form-label fw-bold">Tablet Image (Optional)</label>
                                    <input type="file" class="form-control" id="image_tablet" name="image_tablet" accept="image/*">
                                    <div class="form-text">Width ~744px.</div>
                                    <?php if ($isEdit && !empty($service->media_path_medium)): ?>
                                        <div class="mt-2 p-2 bg-white border rounded">
                                            <img src="<?= $service->media_path_medium ?>" alt="Tablet" height="80" class="rounded">
                                            <span class="badge bg-success ms-2">Current</span>
                                        </div>
                                    <?php else: ?>
                                        <div class="mt-1 text-muted small fst-italic">No tablet image</div>
                                    <?php endif; ?>
                                </div>

                                <!-- Desktop Image -->
                                <div class="mb-3">
                                    <label for="image_desktop" class="form-label fw-bold">Desktop Image (Optional)</label>
                                    <input type="file" class="form-control" id="image_desktop" name="image_desktop" accept="image/*">
                                    <div class="form-text">Width ~1280px+.</div>
                                    <?php if ($isEdit && !empty($service->media_path_large)): ?>
                                        <div class="mt-2 p-2 bg-white border rounded">
                                            <img src="<?= $service->media_path_large ?>" alt="Desktop" height="80" class="rounded">
                                            <span class="badge bg-success ms-2">Current</span>
                                        </div>
                                    <?php else: ?>
                                        <div class="mt-1 text-muted small fst-italic">No desktop image</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Service Description -->
                        <div class="mb-4">
                            <label for="service_description" class="form-label fw-bold">Description</label>
                            <textarea class="form-control" id="service_description" name="service_description" 
                                      rows="4" placeholder="Describe the service..." required><?= $isEdit ? htmlspecialchars($service->service_description) : '' ?></textarea>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="/cms/gest/start" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> <?= $isEdit ? 'Save Changes' : 'Create Service' ?>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
