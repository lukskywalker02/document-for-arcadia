<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Testimonials\Views\Gest
 * 📂 Physical File:   App/testimonials/views/gest/edit.php
 * 
 * 📝 Description:
 * Back office view for editing testimonials.
 * Allows admin/employee to edit testimonial content before validation (useful for cleaning inappropriate content).
 */
?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12 col-md-8 offset-md-2">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Edit Testimonial</h1>
                <a href="/testimonials/gest/start" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>

            <!-- Success/Error Messages -->
            <?php 
            require_once __DIR__ . '/../../../../includes/helpers/messages.php';
            display_alert_message();
            ?>

            <!-- Edit Form -->
            <div class="card">
                <div class="card-body">
                    <?php require_once __DIR__ . '/../../../../includes/helpers/csrf.php'; ?>
                    
                    <form method="POST" action="/testimonials/gest/update">
                        <?= csrf_field('testimonial_update') ?>
                        <input type="hidden" name="id" value="<?= $testimonial->id_testimonial ?>">

                        <!-- Pseudo Field -->
                        <div class="mb-3">
                            <label for="pseudo" class="form-label">Pseudonym <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control" 
                                   id="pseudo" 
                                   name="pseudo" 
                                   value="<?= htmlspecialchars($testimonial->pseudo ?? '') ?>" 
                                   required 
                                   maxlength="100">
                            <small class="form-text text-muted">Maximum 100 characters</small>
                        </div>

                        <!-- Rating Field -->
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                            <div class="rating-input">
                                <?php
                                $currentRating = (int)($testimonial->rating ?? 0);
                                for ($i = 1; $i <= 5; $i++):
                                ?>
                                    <label class="rating-star" style="cursor: pointer; font-size: 2rem; color: <?= $i <= $currentRating ? '#ffc107' : '#ccc' ?>;">
                                        <input type="radio" name="rating" value="<?= $i ?>" <?= $i == $currentRating ? 'checked' : '' ?> required style="display: none;">
                                        ★
                                    </label>
                                <?php endfor; ?>
                            </div>
                            <small class="form-text text-muted">Select rating from 1 to 5 stars</small>
                        </div>

                        <!-- Message Field -->
                        <div class="mb-3">
                            <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                            <textarea class="form-control" 
                                      id="message" 
                                      name="message" 
                                      rows="6" 
                                      required><?= htmlspecialchars($testimonial->message ?? '') ?></textarea>
                            <small class="form-text text-muted">Edit the testimonial message. Remove any inappropriate content.</small>
                        </div>

                        <!-- Current Status Info -->
                        <div class="mb-3">
                            <label class="form-label">Current Status</label>
                            <div>
                                <?php
                                $status = $testimonial->status ?? 'pending';
                                $badgeClass = '';
                                switch ($status) {
                                    case 'validated':
                                        $badgeClass = 'bg-success';
                                        break;
                                    case 'rejected':
                                        $badgeClass = 'bg-danger';
                                        break;
                                    default:
                                        $badgeClass = 'bg-warning';
                                }
                                ?>
                                <span class="badge <?= $badgeClass ?>"><?= ucfirst($status) ?></span>
                                <?php if ($testimonial->created_at): ?>
                                    <small class="text-muted ms-2">
                                        Created: <?= date('Y-m-d H:i', strtotime($testimonial->created_at)) ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Validate After Edit Checkbox -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" 
                                   class="form-check-input" 
                                   id="validate_after_edit" 
                                   name="validate_after_edit" 
                                   value="1">
                            <label class="form-check-label" for="validate_after_edit">
                                Validate testimonial after saving (recommended if you've cleaned up the content)
                            </label>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="/testimonials/gest/start" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Interactive star rating
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.rating-star');
        
        stars.forEach((star, index) => {
            star.addEventListener('click', function() {
                const rating = index + 1;
                
                // Update all stars
                stars.forEach((s, i) => {
                    const radio = s.querySelector('input[type="radio"]');
                    if (i < rating) {
                        s.style.color = '#ffc107';
                        if (i === rating - 1) {
                            radio.checked = true;
                        }
                    } else {
                        s.style.color = '#ccc';
                    }
                });
            });

            star.addEventListener('mouseenter', function() {
                const rating = index + 1;
                stars.forEach((s, i) => {
                    if (i < rating) {
                        s.style.color = '#ffc107';
                    }
                });
            });
        });

        // Reset on mouse leave
        const ratingInput = document.querySelector('.rating-input');
        ratingInput.addEventListener('mouseleave', function() {
            const checkedRating = document.querySelector('input[name="rating"]:checked')?.value || 0;
            stars.forEach((s, i) => {
                if (i < checkedRating) {
                    s.style.color = '#ffc107';
                } else {
                    s.style.color = '#ccc';
                }
            });
        });
    });
</script>

