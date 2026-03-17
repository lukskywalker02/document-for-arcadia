<?php
// App/cms/views/gest/bricks_edit.php
$isEdit = ($action === 'edit');
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow mb-5">
                <div class="card-header bg-secondary text-white">
                    <h4 class="mb-0"><?= $isEdit ? 'Modify Content Block' : 'Create New Brick' ?></h4>
                </div>
                <div class="card-body">
                    <?php require_once __DIR__ . '/../../../../includes/helpers/csrf.php'; ?>
                    
                    <form action="/cms/bricks/save" method="POST" enctype="multipart/form-data">
                        <?= csrf_field('brick_save') ?>

                        <?php if ($isEdit): ?>
                            <input type="hidden" name="id_brick" value="<?= $brick->id_brick ?>">
                        <?php endif; ?>

                        <!-- Page Assignment -->
                        <div class="mb-3">
                            <label for="page_name" class="form-label fw-bold">Page where this block appears:</label>
                            <select class="form-select" id="page_name" name="page_name" required>
                                <option value="" disabled <?= !$isEdit ? 'selected' : '' ?>>Select a page...</option>
                                <option value="home" <?= ($isEdit && $brick->page_name === 'home') ? 'selected' : '' ?>>Home</option>
                                <option value="about" <?= ($isEdit && $brick->page_name === 'about') ? 'selected' : '' ?>>About Us</option>
                                <option value="services" <?= ($isEdit && $brick->page_name === 'services') ? 'selected' : '' ?>>Services</option>
                                <option value="habitats" <?= ($isEdit && $brick->page_name === 'habitats') ? 'selected' : '' ?>>Habitats</option>
                                <option value="animals" <?= ($isEdit && $brick->page_name === 'animals') ? 'selected' : '' ?>>Animals</option>
                                <option value="contact" <?= ($isEdit && $brick->page_name === 'contact') ? 'selected' : '' ?>>Contact</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">Block Title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="<?= $isEdit ? htmlspecialchars($brick->title) : '' ?>"
                                placeholder="E.g., More About Us" required>
                        </div>

                        <div class="mb-3">
                            <label for="link" class="form-label fw-bold">Button Link (Optional)</label>
                            <input type="text" class="form-control" id="link" name="link"
                                value="<?= $isEdit ? htmlspecialchars($brick->link ?? '') : '' ?>"
                                placeholder="E.g., /about/pages/about">
                            <div class="form-text">Leave empty if no button is needed.</div>
                        </div>

                        <!-- RESPONSIVE IMAGES -->
                        <div class="card mb-3 border-light bg-light">
                            <div class="card-body">
                                <h5 class="card-title text-muted mb-3"><i class="bi bi-images"></i> Block Image (Optional)</h5>

                                <!-- Mobile Image (Main) -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-uppercase">Main Image</label>
                                    <input type="file" class="form-control" name="image" accept="image/*">
                                    <?php if ($isEdit && !empty($brick->media_path)): ?>
                                        <div class="mt-2 p-2 bg-white border rounded d-inline-block">
                                            <img src="<?= $brick->media_path ?>" height="60" class="rounded">
                                            <span class="badge bg-success ms-1">Current</span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Tablet Image -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-uppercase">Tablet</label>
                                    <input type="file" class="form-control" name="image_tablet" accept="image/*">
                                    <?php if ($isEdit && !empty($brick->media_path_medium)): ?>
                                        <div class="mt-2 p-2 bg-white border rounded d-inline-block">
                                            <img src="<?= $brick->media_path_medium ?>" height="60" class="rounded">
                                            <span class="badge bg-success ms-1">Current</span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Desktop Image -->
                                <div class="mb-0">
                                    <label class="form-label fw-bold small text-uppercase">Desktop</label>
                                    <input type="file" class="form-control" name="image_desktop" accept="image/*">
                                    <?php if ($isEdit && !empty($brick->media_path_large)): ?>
                                        <div class="mt-2 p-2 bg-white border rounded d-inline-block">
                                            <img src="<?= $brick->media_path_large ?>" height="60" class="rounded">
                                            <span class="badge bg-success ms-1">Current</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">Description / Content</label>
                            <textarea class="form-control" id="description" name="description"
                                rows="6" placeholder="Enter text content here..." required><?= $isEdit ? htmlspecialchars($brick->description ?? '') : '' ?>
                            </textarea>

                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/cms/bricks/start" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Save Changes
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>