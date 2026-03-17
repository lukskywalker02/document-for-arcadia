<?php
// App/habitats/views/suggestion/create.php
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Create Habitat Suggestion</h1>
        <a href="/habitats/suggestion/start" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    <?php 
    require_once __DIR__ . '/../../../../includes/helpers/messages.php';
    display_alert_message();
    ?>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <?php require_once __DIR__ . '/../../../../includes/helpers/csrf.php'; ?>
                    
                    <form method="POST" action="/habitats/suggestion/save">
                        <?= csrf_field('habitat_suggestion_save') ?>
                        
                        <!-- Habitat Selection -->
                        <div class="mb-3">
                            <label for="habitat_id" class="form-label fw-bold">Habitat <span class="text-danger">*</span></label>
                            <select class="form-select" id="habitat_id" name="habitat_id" required>
                                <option value="">-- Select a habitat --</option>
                                <?php if (!empty($habitats)): ?>
                                    <?php foreach ($habitats as $habitat): ?>
                                        <option value="<?= $habitat->id_habitat ?>">
                                            <?= htmlspecialchars($habitat->habitat_name ?? 'N/A') ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <small class="form-text text-muted">Select the habitat for which you want to suggest improvements.</small>
                        </div>

                        <!-- Details -->
                        <div class="mb-3">
                            <label for="details" class="form-label fw-bold">Suggestion Details <span class="text-danger">*</span></label>
                            <textarea class="form-control" 
                                      id="details" 
                                      name="details" 
                                      rows="6" 
                                      required
                                      placeholder="Describe your suggestion for improving this habitat..."></textarea>
                            <small class="form-text text-muted">Provide detailed information about your suggestion for the habitat improvement.</small>
                        </div>

                        <!-- Info Alert -->
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> 
                            <strong>Note:</strong> Your suggestion will be reviewed by an administrator. 
                            You will be able to edit it only while it's pending. Once reviewed, you can delete it if needed.
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="/habitats/suggestion/start" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Submit Suggestion
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

