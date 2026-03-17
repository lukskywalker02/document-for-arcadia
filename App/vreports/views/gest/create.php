<?php
// App/vet_reports/views/gest/create.php
// Include functions to use hasPermission()
require_once __DIR__ . '/../../../../includes/functions.php';

// Get user ID from session
$userId = $_SESSION['user']['id_user'] ?? null;
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Create New Health Report</h1>
        <a href="/vreports/gest/start" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Reports
        </a>
    </div>

    <?php 
    require_once __DIR__ . '/../../../../includes/helpers/messages.php';
    display_alert_message();
    ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <?php require_once __DIR__ . '/../../../../includes/helpers/csrf.php'; ?>
            
            <form action="/vreports/gest/save" method="POST">
                <?= csrf_field('vreport_create') ?>
                <!-- Animal Selection -->
                <div class="mb-3">
                    <label for="full_animal_id" class="form-label fw-bold">Animal <span class="text-danger">*</span></label>
                    <select class="form-select" id="full_animal_id" name="full_animal_id" required>
                        <option value="" disabled selected>Select an animal...</option>
                        <?php if (!empty($animals)): ?>
                            <?php foreach ($animals as $animal): ?>
                                <option value="<?= $animal->id_full_animal ?>">
                                    <?= htmlspecialchars($animal->animal_name ?? 'N/A') ?> 
                                    (<?= htmlspecialchars($animal->specie_name ?? 'N/A') ?>)
                                    <?php if ($animal->habitat_name): ?>
                                        - <?= htmlspecialchars($animal->habitat_name) ?>
                                    <?php endif; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option disabled>No animals available. Create an animal first!</option>
                        <?php endif; ?>
                    </select>
                    <div class="form-text">Select the animal for this health report.</div>
                </div>

                <!-- Health State -->
                <div class="mb-3">
                    <label for="hsr_state" class="form-label fw-bold">Health State <span class="text-danger">*</span></label>
                    <select class="form-select" id="hsr_state" name="hsr_state" required>
                        <option value="" disabled selected>Select health state...</option>
                        <optgroup label="Good States">
                            <option value="healthy">Healthy</option>
                            <option value="well">Well</option>
                            <option value="good_condition">Good Condition</option>
                            <option value="happy">Happy</option>
                        </optgroup>
                        <optgroup label="Warning States">
                            <option value="quarantined">Quarantined</option>
                            <option value="recovering">Recovering</option>
                            <option value="hungry">Hungry</option>
                            <option value="sad">Sad</option>
                            <option value="depressed">Depressed</option>
                            <option value="stressed">Stressed</option>
                            <option value="nervous">Nervous</option>
                            <option value="anxious">Anxious</option>
                        </optgroup>
                        <optgroup label="Critical States">
                            <option value="sick">Sick</option>
                            <option value="injured">Injured</option>
                            <option value="malnourished">Malnourished</option>
                            <option value="dehydrated">Dehydrated</option>
                            <option value="terminal">Terminal</option>
                            <option value="angry">Angry</option>
                            <option value="aggressive">Aggressive</option>
                        </optgroup>
                        <optgroup label="Other States">
                            <option value="pregnant">Pregnant</option>
                            <option value="infant">Infant</option>
                        </optgroup>
                    </select>
                    <div class="form-text">Select the current health state of the animal.</div>
                </div>

                <!-- Review Date -->
                <div class="mb-3">
                    <label for="review_date" class="form-label fw-bold">Review Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="review_date" name="review_date" 
                           value="<?= date('Y-m-d') ?>" required>
                    <div class="form-text">Date when the health review was performed.</div>
                </div>

                <!-- Veterinary Observations -->
                <div class="mb-3">
                    <label for="vet_obs" class="form-label fw-bold">Veterinary Observations <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="vet_obs" name="vet_obs" rows="6" 
                              placeholder="Enter detailed observations about the animal's health condition..." required></textarea>
                    <div class="form-text">Detailed observations and notes from the veterinarian.</div>
                </div>

                <!-- Optional Details -->
                <div class="mb-3">
                    <label for="opt_details" class="form-label fw-bold">Optional Details</label>
                    <input type="text" class="form-control" id="opt_details" name="opt_details" 
                           placeholder="Additional optional information (max 255 characters)" 
                           maxlength="255">
                    <div class="form-text">Optional additional details or notes (for PDF generation, etc.).</div>
                </div>

                <!-- Hidden field for user ID -->
                <input type="hidden" name="checked_by" value="<?= $userId ?>">

                <!-- Submit Button -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="/vreports/gest/start" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Create Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

