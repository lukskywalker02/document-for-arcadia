<?php
// App/vet_reports/views/gest/view.php
// Include functions to use hasPermission()
require_once __DIR__ . '/../../../../includes/functions.php';

// Helper function to get badge color for health state
function getStateBadgeClass($state) {
    $stateColors = [
        'healthy' => 'success',
        'well' => 'success',
        'good_condition' => 'success',
        'happy' => 'success',
        'sick' => 'danger',
        'injured' => 'danger',
        'malnourished' => 'danger',
        'dehydrated' => 'danger',
        'quarantined' => 'warning',
        'terminal' => 'warning',
        'recovering' => 'info',
        'pregnant' => 'info',
        'sad' => 'warning',
        'depressed' => 'warning',
        'stressed' => 'warning',
        'nervous' => 'warning',
        'anxious' => 'warning',
        'hungry' => 'warning',
        'angry' => 'danger',
        'aggressive' => 'danger',
        'infant' => 'secondary'
    ];
    
    return $stateColors[$state] ?? 'secondary';
}
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Health Report Details</h1>
        <div class="d-flex gap-2">
            <?php if (hasPermission('vet_reports-edit')): ?>
                <a href="/vreports/gest/edit?id=<?= $report->id_hs_report ?>" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit Report
                </a>
            <?php endif; ?>
            <a href="/vreports/gest/start" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Reports
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Report Information -->
        <div class="col-md-8">
            <!-- Date of Check-Up Card -->
            <div class="card shadow-sm mb-4" style="background-color: #8B4513; border: 2px solid #0066cc; border-radius: 10px;">
                <div class="card-body text-white">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="text-white mb-2">Date Of Check-Up:</label>
                            <div class="text-info fs-5">
                                <?php 
                                    $date = new DateTime($report->review_date);
                                    echo $date->format('F j, Y');
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Veterinary Observations -->
            <div class="card shadow-sm mb-4" style="background-color: #8B4513; border: 2px solid #0066cc; border-radius: 10px;">
                <div class="card-body text-white">
                    <h5 class="text-warning mb-3"><i class="bi bi-clipboard-check"></i> Veterinary Observation</h5>
                    <div class="bg-dark p-3 rounded" style="min-height: 150px; white-space: pre-wrap; color: #90EE90;">
                        <?= htmlspecialchars($report->vet_obs) ?>
                    </div>
                    <div class="mt-3">
                        <label class="text-white mb-2">Mood Animal:</label>
                        <div class="text-info fs-5">
                            <span class="badge bg-<?= getStateBadgeClass($report->hsr_state) ?> fs-6">
                                <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $report->hsr_state))) ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Optional Animal Details -->
            <div class="card shadow-sm mb-4" style="background-color: #8B4513; border: 2px solid #0066cc; border-radius: 10px;">
                <div class="card-body text-white">
                    <h5 class="text-warning mb-3"><i class="bi bi-info-circle"></i> Optional Animal Details</h5>
                    <div class="bg-dark p-3 rounded" style="min-height: 100px; white-space: pre-wrap; color: #90EE90;">
                        <?= $report->opt_details ? htmlspecialchars($report->opt_details) : '<em class="text-muted">No additional details provided.</em>' ?>
                    </div>
                </div>
            </div>

            <!-- Additional Report Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-file-medical"></i> Report Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Report ID:</strong>
                        </div>
                        <div class="col-md-8">
                            #<?= $report->id_hs_report ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Animal:</strong>
                        </div>
                        <div class="col-md-8">
                            <h5 class="mb-0"><?= htmlspecialchars($report->animal_name ?? 'N/A') ?></h5>
                            <small class="text-muted">
                                <?= htmlspecialchars($report->specie_name ?? 'N/A') ?>
                                <?php if ($report->category_name): ?>
                                    (<?= htmlspecialchars($report->category_name) ?>)
                                <?php endif; ?>
                            </small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Veterinarian:</strong>
                        </div>
                        <div class="col-md-8">
                            <?= htmlspecialchars($report->checked_by_username ?? 'Unknown') ?>
                            <?php if ($report->role_name): ?>
                                <br><small class="text-muted"><?= htmlspecialchars($report->role_name) ?></small>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ($report->habitat_name): ?>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Habitat:</strong>
                        </div>
                        <div class="col-md-8">
                            <?= htmlspecialchars($report->habitat_name) ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Last Updated:</strong>
                        </div>
                        <div class="col-md-8">
                            <?php 
                                $updated = new DateTime($report->updated_at);
                                echo $updated->format('F j, Y \a\t g:i A');
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="/vreports/gest/generatePDF?id=<?= $report->id_hs_report ?>" 
                           class="btn btn-primary" 
                           target="_blank">
                            <i class="bi bi-file-pdf"></i> Generate PDF
                        </a>
                        
                        <?php if (hasPermission('vet_reports-edit')): ?>
                            <a href="/vreports/gest/edit?id=<?= $report->id_hs_report ?>" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> Edit Report
                            </a>
                        <?php endif; ?>
                        
                        <?php 
                        $isAdmin = isset($_SESSION['user']['role_name']) && $_SESSION['user']['role_name'] === 'Admin';
                        if (hasPermission('vet_reports-edit') || $isAdmin): 
                        ?>
                            <a href="/vreports/gest/delete?id=<?= $report->id_hs_report ?>" 
                               class="btn btn-danger"
                               onclick="return confirm('Are you sure you want to delete this health report?');">
                                <i class="bi bi-trash"></i> Delete Report
                            </a>
                        <?php endif; ?>
                        
                        <a href="/vreports/gest/start" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>

            <!-- Animal Quick Info -->
            <div class="card shadow-sm mt-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Animal Information</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>Name:</strong><br>
                        <?= htmlspecialchars($report->animal_name ?? 'N/A') ?>
                    </p>
                    <p class="mb-2">
                        <strong>Species:</strong><br>
                        <?= htmlspecialchars($report->specie_name ?? 'N/A') ?>
                    </p>
                    <?php if ($report->category_name): ?>
                    <p class="mb-2">
                        <strong>Category:</strong><br>
                        <?= htmlspecialchars($report->category_name) ?>
                    </p>
                    <?php endif; ?>
                    <?php if ($report->gender): ?>
                    <p class="mb-2">
                        <strong>Gender:</strong><br>
                        <?= htmlspecialchars(ucfirst($report->gender)) ?>
                    </p>
                    <?php endif; ?>
                    <?php if ($report->habitat_name): ?>
                    <p class="mb-0">
                        <strong>Habitat:</strong><br>
                        <?= htmlspecialchars($report->habitat_name) ?>
                    </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

