<?php
// App/hero/views/gest/edit.php
$isEdit = ($action === 'edit');
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <!-- HERO FORM -->
            <div class="card shadow mb-5">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0"><?= $isEdit ? 'Modify Hero' : 'Create New Hero' ?></h4>
                </div>
                <div class="card-body">
                    <!-- Success/Error Messages -->
                    <?php 
                    require_once __DIR__ . '/../../../../includes/helpers/messages.php';
                    display_alert_message();
                    ?>
                    
                    <?php require_once __DIR__ . '/../../../../includes/helpers/csrf.php'; ?>
                    
                    <form action="/hero/gest/save" method="POST" enctype="multipart/form-data">
                        <?= csrf_field('hero_save') ?>
                        
                        <?php if ($isEdit): ?>
                            <input type="hidden" name="id_hero" value="<?= $hero->id_hero ?>">
                        <?php endif; ?>

                        <!-- Page Assignment -->
                        <div class="mb-3">
                            <label for="page_name" class="form-label fw-bold">This Header belongs to Page:</label>
                            <select class="form-select" id="page_name" name="page_name" required>
                                <option value="" disabled <?= !$isEdit ? 'selected' : '' ?>>Select a page...</option>
                                <option value="home" <?= ($isEdit && $hero->page_name === 'home') ? 'selected' : '' ?>>Home</option>
                                <option value="about" <?= ($isEdit && $hero->page_name === 'about') ? 'selected' : '' ?>>About Us</option>
                                <option value="services" <?= ($isEdit && $hero->page_name === 'services') ? 'selected' : '' ?>>Services (CMS)</option>
                                <option value="habitats" <?= ($isEdit && $hero->page_name === 'habitats') ? 'selected' : '' ?>>Habitats</option>
                                <option value="animals" <?= ($isEdit && $hero->page_name === 'animals') ? 'selected' : '' ?>>Animals</option>
                                <option value="contact" <?= ($isEdit && $hero->page_name === 'contact') ? 'selected' : '' ?>>Contact</option>
                            </select>
                            <div class="form-text text-danger">Each page can only have ONE Hero header.</div>
                        </div>

                        <div class="mb-3">
                            <label for="hero_title" class="form-label fw-bold">Hero Title</label>
                            <input type="text" class="form-control" id="hero_title" name="hero_title" 
                                   value="<?= $isEdit ? htmlspecialchars($hero->hero_title) : '' ?>" 
                                   placeholder="E.g., ZOO ARCADIA" required>
                            <div class="form-text">The main big title on the page header.</div>
                        </div>

                        <div class="mb-3">
                            <label for="hero_subtitle" class="form-label fw-bold">Subtitle</label>
                            <input type="text" class="form-control" id="hero_subtitle" name="hero_subtitle" 
                                   value="<?= $isEdit ? htmlspecialchars($hero->hero_subtitle) : '' ?>" 
                                   placeholder="E.g., Where all animals love to live">
                        </div>

                        <!-- RESPONSIVE IMAGES (Only if No Carousel) -->
                        <div class="card mb-3 border-light bg-light">
                            <div class="card-body">
                                <h5 class="card-title text-muted mb-3"><i class="bi bi-images"></i> Background Image (If no Carousel)</h5>
                                
                                <!-- Mobile Image (Main) -->
                                <div class="mb-3">
                                    <label for="image" class="form-label fw-bold">Main Image (Mobile)</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    <?php if ($isEdit && !empty($hero->media_path)): ?>
                                        <div class="mt-2 p-2 bg-white border rounded">
                                            <img src="<?= $hero->media_path ?>" height="80" class="rounded">
                                            <span class="badge bg-success ms-2">Current</span>
                                        </div>
                                    <?php else: ?>
                                        <div class="mt-1 text-muted small fst-italic">No image uploaded</div>
                                    <?php endif; ?>
                                </div>

                                <!-- Tablet Image -->
                                <div class="mb-3">
                                    <label for="image_tablet" class="form-label fw-bold">Tablet Image (Optional)</label>
                                    <input type="file" class="form-control" id="image_tablet" name="image_tablet" accept="image/*">
                                    <?php if ($isEdit && !empty($hero->media_path_medium)): ?>
                                        <div class="mt-2 p-2 bg-white border rounded">
                                            <img src="<?= $hero->media_path_medium ?>" height="80" class="rounded">
                                            <span class="badge bg-success ms-2">Current</span>
                                        </div>
                                    <?php else: ?>
                                        <div class="mt-1 text-muted small fst-italic">No tablet image (Using default)</div>
                                    <?php endif; ?>
                                </div>

                                <!-- Desktop Image -->
                                <div class="mb-3">
                                    <label for="image_desktop" class="form-label fw-bold">Desktop Image (Optional)</label>
                                    <input type="file" class="form-control" id="image_desktop" name="image_desktop" accept="image/*">
                                    <?php if ($isEdit && !empty($hero->media_path_large)): ?>
                                        <div class="mt-2 p-2 bg-white border rounded">
                                            <img src="<?= $hero->media_path_large ?>" height="80" class="rounded">
                                            <span class="badge bg-success ms-2">Current</span>
                                        </div>
                                    <?php else: ?>
                                        <div class="mt-1 text-muted small fst-italic">No desktop image (Using default)</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="has_sliders" name="has_sliders" value="1" <?= ($isEdit && $hero->has_sliders) ? 'checked' : '' ?>>
                            <label class="form-check-label fw-bold" for="has_sliders">Has Carousel (Slides)?</label>
                            <div class="form-text">If checked, these images will be ignored and Slides will be used instead.</div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/hero/gest/start" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Save Changes
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            <!-- SLIDES MANAGEMENT (Only if Edit Mode + Has Carousel) -->
            <?php if ($isEdit && $hero->has_sliders): ?>
                <div class="card shadow border-info">
                    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Manage Slides</h5>
                        <a href="/hero/slides/create?hero_id=<?= $hero->id_hero ?>" class="btn btn-sm btn-light text-primary fw-bold">
                            <i class="bi bi-plus-lg"></i> Add Slide
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Image</th>
                                    <th>Caption</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($slides)): ?>
                                    <?php foreach ($slides as $slide): ?>
                                        <tr>
                                            <td>
                                                <?php if ($slide->media_path): ?>
                                                    <img src="<?= $slide->media_path ?>" class="rounded" style="width: 80px; height: 50px; object-fit: cover;">
                                                <?php else: ?>
                                                    <span class="text-muted">No img</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <strong><?= htmlspecialchars($slide->title_caption) ?></strong><br>
                                                <small class="text-muted"><?= substr(htmlspecialchars($slide->description_caption), 0, 50) ?>...</small>
                                            </td>
                                            <td class="text-end">
                                                <a href="/hero/slides/edit?id=<?= $slide->id_slide ?>" class="btn btn-sm btn-warning">edit<i class="bi bi-pencil"></i></a>
                                                <a href="/hero/slides/delete?id=<?= $slide->id_slide ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete slide?');"><i class="bi bi-trash">delete</i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-3 text-muted">No slides yet. Add one!</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
