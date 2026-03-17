<?php
// App/hero/views/gest/slide_edit.php
$isEdit = ($action === 'edit');
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-gradient bg-primary text-white p-4">
                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-images me-2"></i> <?= $isEdit ? 'Edit Slide' : 'Add New Slide' ?>
                    </h4>
                </div>
                <div class="card-body p-4">
                    <!-- Success/Error Messages -->
                    <?php 
                    require_once __DIR__ . '/../../../../includes/helpers/messages.php';
                    display_alert_message();
                    ?>
                    
                    <?php require_once __DIR__ . '/../../../../includes/helpers/csrf.php'; ?>
                    
                    <form action="/hero/slides/save" method="POST" enctype="multipart/form-data">
                        <?= csrf_field('slide_save') ?>
                        
                        <!-- Hidden IDs -->
                        <input type="hidden" name="hero_id" value="<?= $heroId ?>">
                        <?php if ($isEdit): ?>
                            <input type="hidden" name="id_slide" value="<?= $slide->id_slide ?>">
                        <?php endif; ?>

                        <!-- Title Caption -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="title_caption" name="title_caption" 
                                   value="<?= $isEdit ? htmlspecialchars($slide->title_caption) : '' ?>" 
                                   placeholder="Title" required>
                            <label for="title_caption">Title Caption</label>
                        </div>

                        <!-- Description Caption -->
                        <div class="form-floating mb-4">
                            <textarea class="form-control" id="description_caption" name="description_caption" 
                                      placeholder="Description" style="height: 100px" required><?= $isEdit ? htmlspecialchars($slide->description_caption) : '' ?></textarea>
                            <label for="description_caption">Description Caption</label>
                        </div>

                        <!-- RESPONSIVE SLIDE IMAGES -->
                        <div class="card mb-4 bg-light border-0">
                            <div class="card-body">
                                <h6 class="card-title text-muted mb-3"><i class="bi bi-display"></i> Responsive Images</h6>
                                
                                <!-- Mobile Image (Main) -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-uppercase">Mobile / Default</label>
                                    <input type="file" class="form-control form-control-sm" name="image" accept="image/*" <?= $isEdit ? '' : 'required' ?>>
                                    <?php if ($isEdit && !empty($slide->media_path)): ?>
                                        <div class="mt-2 p-2 bg-white border rounded d-inline-block">
                                            <img src="<?= $slide->media_path ?>" height="50" class="rounded">
                                            <span class="badge bg-success ms-1">Current</span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Tablet Image -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-uppercase">Tablet (Optional)</label>
                                    <input type="file" class="form-control form-control-sm" name="image_tablet" accept="image/*">
                                    <?php if ($isEdit && !empty($slide->media_path_medium)): ?>
                                        <div class="mt-2 p-2 bg-white border rounded d-inline-block">
                                            <img src="<?= $slide->media_path_medium ?>" height="50" class="rounded">
                                            <span class="badge bg-success ms-1">Current</span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Desktop Image -->
                                <div class="mb-0">
                                    <label class="form-label fw-bold small text-uppercase">Desktop (Optional)</label>
                                    <input type="file" class="form-control form-control-sm" name="image_desktop" accept="image/*">
                                    <?php if ($isEdit && !empty($slide->media_path_large)): ?>
                                        <div class="mt-2 p-2 bg-white border rounded d-inline-block">
                                            <img src="<?= $slide->media_path_large ?>" height="50" class="rounded">
                                            <span class="badge bg-success ms-1">Current</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="/hero/gest/edit?id=<?= $heroId ?>" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">
                                <?= $isEdit ? 'Save Changes' : 'Add Slide' ?> <i class="bi bi-check-lg ms-2"></i>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
