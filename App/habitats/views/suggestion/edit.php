<?php
// App/habitats/views/suggestion/edit.php
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Edit Habitat Suggestion</h1>
        <a href="/habitats/suggestion/start" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    <?php 
    require_once __DIR__ . '/../../../../includes/helpers/messages.php';
    display_alert_message();
    ?>

    <?php if ($suggestion->status !== 'pending'): ?>
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle"></i> 
            This suggestion has been <?= htmlspecialchars($suggestion->status) ?> and cannot be edited. 
            You can only edit pending suggestions.
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <?php require_once __DIR__ . '/../../../../includes/helpers/csrf.php'; ?>
                    
                    <form method="POST" action="/habitats/suggestion/update">
                        <?= csrf_field('habitat_suggestion_update') ?>
                        <input type="hidden" name="id_hab_suggestion" value="<?= $suggestion->id_hab_suggestion ?>">
                        
                        <!-- Habitat (Read-only, cannot be changed) -->
                        <div class="mb-3">
                            <label for="habitat_id" class="form-label fw-bold">Habitat</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="habitat_id" 
                                   value="<?= htmlspecialchars($suggestion->habitat_name ?? 'N/A') ?>" 
                                   readonly>
                            <small class="form-text text-muted">The habitat cannot be changed. If you need to suggest for a different habitat, create a new suggestion.</small>
                        </div>

                        <!-- Status (Read-only) -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <div>
                                <?php
                                    $status = $suggestion->status ?? 'pending';
                                    $badgeClass = '';
                                    if ($status === 'accepted') {
                                        $badgeClass = 'bg-success';
                                    } elseif ($status === 'rejected') {
                                        $badgeClass = 'bg-danger';
                                    } else {
                                        $badgeClass = 'bg-warning text-dark';
                                    }
                                ?>
                                <span class="badge <?= $badgeClass ?> fs-6">
                                    <?= htmlspecialchars(ucfirst($status)) ?>
                                </span>
                            </div>
                            <small class="form-text text-muted">Current status of your suggestion.</small>
                        </div>

                        <!-- Details -->
                        <div class="mb-3">
                            <label for="details" class="form-label fw-bold">Suggestion Details <span class="text-danger">*</span></label>
                            <textarea class="form-control" 
                                      id="details" 
                                      name="details" 
                                      rows="6" 
                                      required
                                      <?= $suggestion->status !== 'pending' ? 'readonly' : '' ?>
                                      placeholder="Describe your suggestion for improving this habitat..."><?= htmlspecialchars($suggestion->details ?? '') ?></textarea>
                            <small class="form-text text-muted">
                                <?php if ($suggestion->status === 'pending'): ?>
                                    You can edit the details while the suggestion is pending.
                                <?php else: ?>
                                    This suggestion has been reviewed and cannot be edited.
                                <?php endif; ?>
                            </small>
                        </div>

                        <!-- Proposed On (Read-only) -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Proposed On</label>
                            <input type="text" 
                                   class="form-control" 
                                   value="<?php 
                                       $date = new DateTime($suggestion->proposed_on);
                                       echo $date->format('Y-m-d H:i');
                                   ?>" 
                                   readonly>
                        </div>

                        <?php if ($suggestion->reviewed_on): ?>
                            <!-- Reviewed On (Read-only) -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Reviewed On</label>
                                <input type="text" 
                                       class="form-control" 
                                       value="<?php 
                                           $date = new DateTime($suggestion->reviewed_on);
                                           echo $date->format('Y-m-d H:i');
                                       ?>" 
                                       readonly>
                            </div>
                        <?php endif; ?>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="/habitats/suggestion/start" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                            <?php if ($suggestion->status === 'pending'): ?>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Update Suggestion
                                </button>
                            <?php else: ?>
                                <button type="button" class="btn btn-secondary" disabled>
                                    <i class="bi bi-lock"></i> Cannot Edit (<?= htmlspecialchars(ucfirst($suggestion->status)) ?>)
                                </button>
                            <?php endif; ?>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

