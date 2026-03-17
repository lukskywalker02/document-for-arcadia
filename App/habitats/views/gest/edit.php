<?php
// App/habitats/views/gest/edit.php
$isEdit = ($action === 'edit');
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0"><?= $isEdit ? 'Modificar Hábitat' : 'Crear Nuevo Hábitat' ?></h4>
                </div>
                <div class="card-body">
                    <!-- Success/Error Messages -->
                    <?php 
                    require_once __DIR__ . '/../../../../includes/helpers/messages.php';
                    display_alert_message();
                    display_error_variable($error ?? null);
                    ?>

                    <?php require_once __DIR__ . '/../../../../includes/helpers/csrf.php'; ?>
                    
                    <form method="POST" action="/habitats/gest/save" enctype="multipart/form-data">
                        <?= csrf_field('habitat_save') ?>
                        
                        <!-- Hidden ID for Update -->
                        <?php if ($isEdit && isset($habitat->id_habitat)): ?>
                            <input type="hidden" name="id_habitat" value="<?= $habitat->id_habitat ?>">
                        <?php endif; ?>

                        <!-- Nombre del Hábitat -->
                        <div class="mb-3">
                            <label for="habitat_name" class="form-label fw-bold">Habitat Name</label>
                            <input type="text" class="form-control" id="habitat_name" name="habitat_name" 
                                   value="<?= $isEdit && isset($habitat) ? htmlspecialchars($habitat->habitat_name) : '' ?>" 
                                   placeholder="E.g., Savannah, Jungle, Swamp" required>
                            <div class="form-text">Enter the habitat name.</div>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-3">
                            <label for="description_habitat" class="form-label fw-bold">Description</label>
                            <textarea class="form-control" id="description_habitat" name="description_habitat" 
                                      rows="3" placeholder="Brief description of the habitat..."><?= $isEdit && isset($habitat) ? htmlspecialchars($habitat->description_habitat ?? '') : '' ?></textarea>
                            <div class="form-text">Brief description of the habitat (optional).</div>
                        </div>

                        <!-- HERO SECTION -->
                        <div class="card mb-3 border-primary">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="bi bi-image"></i> Hero Section (Page Header)</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted small">Configure the Hero/Header that appears when viewing this specific habitat page.</p>
                                
                                <!-- Hero Title -->
                                <div class="mb-3">
                                    <label for="hero_title" class="form-label fw-bold">Hero Title</label>
                                    <input type="text" class="form-control" id="hero_title" name="hero_title" 
                                           value="<?= $isEdit && isset($habitatHero) ? htmlspecialchars($habitatHero->hero_title ?? '') : '' ?>" 
                                           placeholder="E.g., SAVANNAH ANIMALS">
                                    <div class="form-text">Title displayed in the Hero section (optional).</div>
                                </div>

                                <!-- Hero Subtitle -->
                                <div class="mb-3">
                                    <label for="hero_subtitle" class="form-label fw-bold">Hero Subtitle</label>
                                    <input type="text" class="form-control" id="hero_subtitle" name="hero_subtitle" 
                                           value="<?= $isEdit && isset($habitatHero) ? htmlspecialchars($habitatHero->hero_subtitle ?? '') : '' ?>" 
                                           placeholder="E.g., EXPERIENCE THE WILD MAJESTY OF SAVANNAH">
                                    <div class="form-text">Subtitle displayed below the title (optional).</div>
                                </div>

                                <!-- Hero Images -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Hero Images (Responsive)</label>
                                    
                                    <!-- Hero Mobile Image -->
                                    <div class="mb-2">
                                        <label for="hero_image" class="form-label small">Hero Image (Mobile/Default)</label>
                                        <input type="file" class="form-control form-control-sm" id="hero_image" name="hero_image" accept="image/*">
                                        <?php if ($isEdit && isset($habitatHero) && !empty($habitatHero->media_path)): ?>
                                            <div class="mt-1 p-1 bg-white border rounded">
                                                <img src="<?= htmlspecialchars($habitatHero->media_path) ?>" alt="Hero Mobile" height="60" class="rounded">
                                                <span class="badge bg-success ms-1 small">Current</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Hero Tablet Image -->
                                    <div class="mb-2">
                                        <label for="hero_image_tablet" class="form-label small">Hero Image (Tablet - Optional)</label>
                                        <input type="file" class="form-control form-control-sm" id="hero_image_tablet" name="hero_image_tablet" accept="image/*">
                                        <?php if ($isEdit && isset($habitatHero) && !empty($habitatHero->media_path_medium)): ?>
                                            <div class="mt-1 p-1 bg-white border rounded">
                                                <img src="<?= htmlspecialchars($habitatHero->media_path_medium) ?>" alt="Hero Tablet" height="60" class="rounded">
                                                <span class="badge bg-success ms-1 small">Current</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Hero Desktop Image -->
                                    <div class="mb-2">
                                        <label for="hero_image_desktop" class="form-label small">Hero Image (Desktop - Optional)</label>
                                        <input type="file" class="form-control form-control-sm" id="hero_image_desktop" name="hero_image_desktop" accept="image/*">
                                        <?php if ($isEdit && isset($habitatHero) && !empty($habitatHero->media_path_large)): ?>
                                            <div class="mt-1 p-1 bg-white border rounded">
                                                <img src="<?= htmlspecialchars($habitatHero->media_path_large) ?>" alt="Hero Desktop" height="60" class="rounded">
                                                <span class="badge bg-success ms-1 small">Current</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- HABITAT IMAGES SECTION -->
                        <div class="card mb-3 border-light bg-light">
                            <div class="card-body">
                                <h5 class="card-title text-muted mb-3"><i class="bi bi-images"></i> Habitat Images (For Cards/Listings)</h5>
                                
                                <!-- Mobile Image (Main) -->
                                <div class="mb-3">
                                    <label for="image" class="form-label fw-bold">Main Image (Mobile/Default)</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*" <?= $isEdit ? '' : 'required' ?>>
                                    <div class="form-text"><?= $isEdit ? 'Leave empty to keep current image.' : 'Required. Used for mobile and as fallback.' ?></div>
                                    <?php if ($isEdit && !empty($habitat->media_path)): ?>
                                        <div class="mt-2 p-2 bg-white border rounded">
                                            <img src="<?= htmlspecialchars($habitat->media_path) ?>" alt="Mobile" height="80" class="rounded">
                                            <span class="badge bg-success ms-2">Current</span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Tablet Image -->
                                <div class="mb-3">
                                    <label for="image_tablet" class="form-label fw-bold">Tablet Image (Optional)</label>
                                    <input type="file" class="form-control" id="image_tablet" name="image_tablet" accept="image/*">
                                    <div class="form-text">Width ~744px. Recommended for better tablet experience.</div>
                                    <?php if ($isEdit && !empty($habitat->media_path_medium)): ?>
                                        <div class="mt-2 p-2 bg-white border rounded">
                                            <img src="<?= htmlspecialchars($habitat->media_path_medium) ?>" alt="Tablet" height="80" class="rounded">
                                            <span class="badge bg-success ms-2">Current</span>
                                        </div>
                                    <?php else: ?>
                                        <?php if ($isEdit): ?>
                                            <div class="mt-1 text-muted small fst-italic">No tablet image</div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>

                                <!-- Desktop Image -->
                                <div class="mb-3">
                                    <label for="image_desktop" class="form-label fw-bold">Desktop Image (Optional)</label>
                                    <input type="file" class="form-control" id="image_desktop" name="image_desktop" accept="image/*">
                                    <div class="form-text">Width ~1280px+. Recommended for high-quality desktop display.</div>
                                    <?php if ($isEdit && !empty($habitat->media_path_large)): ?>
                                        <div class="mt-2 p-2 bg-white border rounded">
                                            <img src="<?= htmlspecialchars($habitat->media_path_large) ?>" alt="Desktop" height="80" class="rounded">
                                            <span class="badge bg-success ms-2">Current</span>
                                        </div>
                                    <?php else: ?>
                                        <?php if ($isEdit): ?>
                                            <div class="mt-1 text-muted small fst-italic">No desktop image</div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="/habitats/gest/start" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> <?= $isEdit ? 'Save Changes' : 'Create Habitat' ?>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>



