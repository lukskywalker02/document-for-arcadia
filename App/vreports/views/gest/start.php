<?php
// App/vet_reports/views/gest/start.php
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
        <h1>Health State Reports</h1>
        <?php 
        // Only users with vet_reports-create permission can create reports
        if (hasPermission('vet_reports-create')): 
        ?>
            <a href="/vreports/gest/create" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Create New Report
            </a>
        <?php endif; ?>
    </div>

    <?php 
    require_once __DIR__ . '/../../../../includes/helpers/messages.php';
    display_alert_message('Action completed successfully!', [
        'saved' => 'Health report created successfully!',
        'updated' => 'Health report updated successfully!',
        'deleted' => 'Health report deleted successfully!'
    ]);
    ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="vreportsTable" class="table table-hover align-middle dataTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <th style="width: 80px;">Image</th>
                            <th>Animal</th>
                            <th>Species</th>
                            <th>State</th>
                            <th>Review Date</th>
                            <th>Veterinarian</th>
                            <th>Last Updated</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($reports)): ?>
                            <?php foreach ($reports as $report): ?>
                                <tr>
                                    <!-- ID Column -->
                                    <td class="fw-bold text-muted" data-order="<?= $report->id_hs_report ?? 0 ?>">#<?= $report->id_hs_report ?? 'N/A' ?></td>

                                    <!-- Image Column -->
                                    <td style="width: 80px;">
                                        <?php if (!empty($report->media_path)): ?>
                                            <img src="<?= htmlspecialchars($report->media_path) ?>" alt="Animal Photo" 
                                                 class="rounded" style="width: 60px; height: 60px; object-fit: cover;" loading="lazy">
                                        <?php else: ?>
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 60px;">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Animal Name -->
                                    <td class="fw-bold">
                                        <a href="/vreports/gest/view?id=<?= $report->id_hs_report ?>" class="text-decoration-none">
                                            <?= htmlspecialchars($report->animal_name ?? 'N/A') ?>
                                        </a>
                                        <?php if ($report->habitat_name): ?>
                                            <br><small class="text-muted"><?= htmlspecialchars($report->habitat_name) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <!-- Species -->
                                    <td data-species="<?= htmlspecialchars($report->specie_name ?? 'N/A') ?>">
                                        <span class="badge bg-secondary">
                                            <?= htmlspecialchars($report->specie_name ?? 'N/A') ?>
                                        </span>
                                    </td>

                                    <!-- State with badge -->
                                    <td data-state="<?= htmlspecialchars($report->hsr_state ?? '') ?>">
                                        <span class="badge bg-<?= getStateBadgeClass($report->hsr_state) ?>">
                                            <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $report->hsr_state))) ?>
                                        </span>
                                    </td>

                                    <!-- Review Date -->
                                    <td data-order="<?= strtotime($report->review_date ?? '1970-01-01') ?>">
                                        <?php 
                                            $date = new DateTime($report->review_date);
                                            echo $date->format('Y-m-d');
                                        ?>
                                    </td>

                                    <!-- Veterinarian -->
                                    <td data-veterinarian="<?= htmlspecialchars($report->checked_by_username ?? 'Unknown') ?>">
                                        <?= htmlspecialchars($report->checked_by_username ?? 'Unknown') ?>
                                        <?php if ($report->role_name): ?>
                                            <br><small class="text-muted"><?= htmlspecialchars($report->role_name) ?></small>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Last Updated -->
                                    <td data-order="<?= strtotime($report->updated_at ?? '1970-01-01') ?>">
                                        <?php 
                                            $updated = new DateTime($report->updated_at);
                                            echo $updated->format('Y-m-d H:i');
                                        ?>
                                    </td>

                                    <!-- Actions -->
                                    <td class="text-end">
                                        <?php 
                                        // Only users with vet_reports-view permission can view reports
                                        if (hasPermission('vet_reports-view')): 
                                        ?>
                                            <a href="/vreports/gest/view?id=<?= $report->id_hs_report ?>" 
                                               class="btn btn-sm btn-outline-primary me-1" 
                                               title="View Report">
                                                <i class="bi bi-eye">view</i>
                                            </a>
                                        <a href="/vreports/gest/generatePDF?id=<?= $report->id_hs_report ?>" 
                                               class="btn btn-sm btn-outline-danger me-1" 
                                               title="Generate PDF"
                                               target="_blank">
                                                <i class="bi bi-file-pdf">generate</i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php 
                                        // Only users with vet_reports-edit permission can edit reports
                                        if (hasPermission('vet_reports-edit')): 
                                        ?>
                                            <a href="/vreports/gest/edit?id=<?= $report->id_hs_report ?>" 
                                               class="btn btn-sm btn-warning me-1" 
                                               title="Edit Report">
                                                <i>edit</i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php 
                                        // Only users with vet_reports-edit permission or Admin can delete reports
                                        $isAdmin = isset($_SESSION['user']['role_name']) && $_SESSION['user']['role_name'] === 'Admin';
                                        if (hasPermission('vet_reports-edit') || $isAdmin): 
                                        ?>
                                            <a href="/vreports/gest/delete?id=<?= $report->id_hs_report ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Are you sure you want to delete this health report?');"
                                               title="Delete Report">
                                                <i>delete</i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox"></i> No health reports found.
                                    <?php 
                                    // Only users with vet_reports-create permission can create reports
                                    if (hasPermission('vet_reports-create')): 
                                    ?>
                                        <a href="/vreports/gest/create">Create the first one!</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="/build/js/vreports.js" defer></script>