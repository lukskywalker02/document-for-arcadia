<?php
// App/animals/views/gest/edit.php
$isEdit = ($action === 'edit');
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0"><?= $isEdit ? 'Modify Animal' : 'Create New Animal' ?></h4>
                </div>
                <div class="card-body">
                    <!-- Success/Error Messages -->
                    <?php 
                    require_once __DIR__ . '/../../../../includes/helpers/messages.php';
                    display_alert_message();
                    ?>
                    
                    <?php require_once __DIR__ . '/../../../../includes/helpers/csrf.php'; ?>
                    
                    <form action="/animals/gest/save" method="POST" enctype="multipart/form-data">
                        <?= csrf_field('animal_save') ?>
                        
                        <!-- Hidden ID for Update (CRITICAL) -->
                        <?php if ($isEdit && isset($animal->id_full_animal)): ?>
                            <input type="hidden" name="id_full_animal" value="<?= $animal->id_full_animal ?>">
                        <?php endif; ?>

                        <!-- Animal Name -->
                        <div class="mb-3">
                            <label for="animal_name" class="form-label fw-bold">Animal Name</label>
                            <input type="text" class="form-control" id="animal_name" name="animal_name" 
                                   value="<?= $isEdit ? htmlspecialchars($animal->animal_name ?? '') : '' ?>" 
                                   placeholder="E.g., Simba (León), Nala (León)" required>
                            <div class="form-text">The individual name of this animal + common species name in parentheses.</div>
                        </div>

                        <!-- Species -->
                        <div class="mb-3">
                            <label for="specie_id" class="form-label fw-bold">Species</label>
                            <select class="form-select" id="specie_id" name="specie_id" required>
                                <option value="" disabled <?= !$isEdit ? 'selected' : '' ?>>Select a species...</option>
                                <?php if (!empty($species)): ?>
                                    <?php foreach ($species as $specie): ?>
                                        <option value="<?= $specie->id_specie ?>" 
                                                <?= ($isEdit && isset($animal->specie_id) && $animal->specie_id == $specie->id_specie) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($specie->specie_name) ?> 
                                            <?php if (!empty($specie->category_name)): ?>
                                                (<?= htmlspecialchars($specie->category_name) ?>)
                                            <?php endif; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option disabled>No species available. Please create species first.</option>
                                <?php endif; ?>
                            </select>
                            <div class="form-text">The biological species of this animal.</div>
                        </div>

                        <!-- Gender -->
                        <div class="mb-3">
                            <label for="gender" class="form-label fw-bold">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="" disabled <?= !$isEdit ? 'selected' : '' ?>>Select gender...</option>
                                <option value="male" <?= ($isEdit && isset($animal->gender) && $animal->gender === 'male') ? 'selected' : '' ?>>Male</option>
                                <option value="female" <?= ($isEdit && isset($animal->gender) && $animal->gender === 'female') ? 'selected' : '' ?>>Female</option>
                            </select>
                        </div>

                        <!-- Habitat -->
                        <div class="mb-3">
                            <label for="habitat_id" class="form-label fw-bold">Habitat</label>
                            <select class="form-select" id="habitat_id" name="habitat_id">
                                <option value="">No habitat assigned</option>
                                <?php if (!empty($habitats)): ?>
                                    <?php foreach ($habitats as $habitat): ?>
                                        <option value="<?= $habitat->id_habitat ?>" 
                                                <?= ($isEdit && isset($animal->habitat_id) && $animal->habitat_id == $habitat->id_habitat) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($habitat->habitat_name) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option disabled>No habitats available. Please create habitats first.</option>
                                <?php endif; ?>
                            </select>
                            <div class="form-text">The habitat where this animal lives. Optional but recommended.</div>
                        </div>

                        <!-- Nutrition -->
                        <div class="mb-3">
                            <label for="nutrition_id" class="form-label fw-bold">Nutrition Plan</label>
                            <select class="form-select" id="nutrition_id" name="nutrition_id">
                                <option value="">No nutrition plan assigned</option>
                                <?php if (!empty($nutritions)): ?>
                                    <?php foreach ($nutritions as $nutrition): ?>
                                        <option value="<?= $nutrition->id_nutrition ?>" 
                                                <?= ($isEdit && isset($animal->nutrition_id) && $animal->nutrition_id == $nutrition->id_nutrition) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars(ucfirst($nutrition->nutrition_type)) ?> - 
                                            <?= htmlspecialchars(ucfirst($nutrition->food_type)) ?> 
                                            (<?= $nutrition->food_qtty ?>g)
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option disabled>No nutrition plans available. Please create nutrition plans first.</option>
                                <?php endif; ?>
                            </select>
                            <div class="form-text">The nutrition plan for this animal. Optional but recommended.</div>
                        </div>

                        <!-- RESPONSIVE IMAGES -->
                        <div class="card mb-3 border-light bg-light">
                            <div class="card-body">
                                <h5 class="card-title text-muted mb-3"><i class="bi bi-images"></i> Animal Photos (Responsive)</h5>
                                
                                <!-- Mobile Image (Main) -->
                                <div class="mb-3">
                                    <label for="image" class="form-label fw-bold">Main Image (Mobile/Default)</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*" <?= $isEdit ? '' : 'required' ?>>
                                    <div class="form-text"><?= $isEdit ? 'Leave empty to keep current image.' : 'Required. Used for mobile and as fallback.' ?></div>
                                    <?php if ($isEdit && !empty($animal->media_path)): ?>
                                        <div class="mt-2 p-2 bg-white border rounded">
                                            <img src="<?= htmlspecialchars($animal->media_path) ?>" alt="Mobile" height="80" class="rounded">
                                            <span class="badge bg-success ms-2">Current</span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Tablet Image -->
                                <div class="mb-3">
                                    <label for="image_tablet" class="form-label fw-bold">Tablet Image (Optional)</label>
                                    <input type="file" class="form-control" id="image_tablet" name="image_tablet" accept="image/*">
                                    <div class="form-text">Width ~744px. Recommended for better tablet experience.</div>
                                    <?php if ($isEdit && !empty($animal->media_path_medium)): ?>
                                        <div class="mt-2 p-2 bg-white border rounded">
                                            <img src="<?= htmlspecialchars($animal->media_path_medium) ?>" alt="Tablet" height="80" class="rounded">
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
                                    <?php if ($isEdit && !empty($animal->media_path_large)): ?>
                                        <div class="mt-2 p-2 bg-white border rounded">
                                            <img src="<?= htmlspecialchars($animal->media_path_large) ?>" alt="Desktop" height="80" class="rounded">
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
                            <a href="/animals/gest/start" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> <?= $isEdit ? 'Save Changes' : 'Create Animal' ?>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

