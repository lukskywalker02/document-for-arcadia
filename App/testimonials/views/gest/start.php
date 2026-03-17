<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Testimonials\Views\Gest
 * 📂 Physical File:   App/testimonials/views/gest/start.php
 * 
 * 📝 Description:
 * Back office view for managing testimonials.
 * Displays all testimonials with filtering and action buttons.
 */
?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Testimonials Management</h1>
            </div>

            <!-- Success/Error Messages -->
            <?php 
            require_once __DIR__ . '/../../../../includes/helpers/messages.php';
            display_alert_message();
            ?>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3"> 
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">Total</h5>
                            <h2 class="mb-0"><?= $stats->total ?? 0 ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <h5 class="card-title">Pending</h5>
                            <h2 class="mb-0"><?= $stats->pending ?? 0 ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Validated</h5>
                            <h2 class="mb-0"><?= $stats->validated ?? 0 ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-danger">
                        <div class="card-body">
                            <h5 class="card-title">Rejected</h5>
                            <h2 class="mb-0"><?= $stats->rejected ?? 0 ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Buttons -->
            <div class="mb-3">
                <a href="/testimonials/gest/start" class="btn btn-sm btn-outline-secondary <?= !isset($_GET['status']) ? 'active' : '' ?>">
                    All
                </a>
                <a href="/testimonials/gest/start?status=pending" class="btn btn-sm btn-outline-warning <?= (isset($_GET['status']) && $_GET['status'] === 'pending') ? 'active' : '' ?>">
                    Pending
                </a>
                <a href="/testimonials/gest/start?status=validated" class="btn btn-sm btn-outline-success <?= (isset($_GET['status']) && $_GET['status'] === 'validated') ? 'active' : '' ?>">
                    Validated
                </a>
                <a href="/testimonials/gest/start?status=rejected" class="btn btn-sm btn-outline-danger <?= (isset($_GET['status']) && $_GET['status'] === 'rejected') ? 'active' : '' ?>">
                    Rejected
                </a>
            </div>

            <!-- Testimonials Table -->
            <div class="card">
                <div class="card-body">
                    <?php if (!empty($testimonials)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover" id="testimonialsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">ID</th>
                                        <th>Pseudo</th>
                                        <th style="width: 100px;">Rating</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Validated By</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($testimonials as $testimonial): ?>
                                        <tr>
                                            <!-- ID -->
                                            <td class="fw-bold text-muted">#<?= $testimonial->id_testimonial ?? 'N/A' ?></td>

                                            <!-- Pseudo -->
                                            <td class="fw-bold"><?= htmlspecialchars($testimonial->pseudo ?? 'N/A') ?></td>

                                            <!-- Rating (Stars) -->
                                            <td>
                                                <?php
                                                $rating = (int)($testimonial->rating ?? 0);
                                                for ($i = 1; $i <= 5; $i++):
                                                    if ($i <= $rating):
                                                ?>
                                                        <span class="text-warning">★</span>
                                                    <?php else: ?>
                                                        <span class="text-muted">★</span>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                                <small class="text-muted">(<?= $rating ?>/5)</small>
                                            </td>

                                            <!-- Message (truncated) -->
                                            <td>
                                                <?php
                                                $message = htmlspecialchars($testimonial->message ?? '');
                                                $truncated = strlen($message) > 100 ? substr($message, 0, 100) . '...' : $message;
                                                ?>
                                                <span title="<?= htmlspecialchars($testimonial->message ?? '') ?>">
                                                    <?= $truncated ?>
                                                </span>
                                            </td>

                                            <!-- Status Badge -->
                                            <td>
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
                                            </td>

                                            <!-- Created Date -->
                                            <td>
                                                <small class="text-muted">
                                                    <?php
                                                    if (isset($testimonial->created_at)) {
                                                        $date = new DateTime($testimonial->created_at);
                                                        echo $date->format('Y-m-d H:i');
                                                    } else {
                                                        echo 'N/A';
                                                    }
                                                    ?>
                                                </small>
                                            </td>

                                            <!-- Validated By -->
                                            <td>
                                                <?php if ($testimonial->validator_username): ?>
                                                    <small class="text-muted">
                                                        <?= htmlspecialchars($testimonial->validator_username) ?>
                                                        <?php if ($testimonial->validator_role): ?>
                                                            <br><span class="badge bg-secondary"><?= htmlspecialchars($testimonial->validator_role) ?></span>
                                                        <?php endif; ?>
                                                    </small>
                                                <?php else: ?>
                                                    <small class="text-muted">-</small>
                                                <?php endif; ?>
                                            </td>

                                            <!-- Actions -->
                                            <td class="text-end">
                                                <div class="btn-group" role="group">
                                                    <?php 
                                                    // Both Admin and Employee can validate, reject, edit, and delete
                                                    $roleName = $_SESSION["user"]["role_name"] ?? '';
                                                    if ($roleName === 'Admin' || $roleName === 'Employee'): 
                                                    ?>
                                                        <?php if ($testimonial->status === 'pending' || $testimonial->status === 'rejected'): ?>
                                                            <a href="/testimonials/gest/validate?id=<?= $testimonial->id_testimonial ?>" 
                                                               class="btn btn-sm btn-success" 
                                                               title="Validate"
                                                               onclick="return confirm('Are you sure you want to validate this testimonial?');">
                                                                Validate
                                                            </a>
                                                        <?php endif; ?>
                                                        
                                                        <?php if ($testimonial->status === 'pending' || $testimonial->status === 'validated'): ?>
                                                            <a href="/testimonials/gest/reject?id=<?= $testimonial->id_testimonial ?>" 
                                                               class="btn btn-sm btn-danger" 
                                                               title="Reject"
                                                               onclick="return confirm('Are you sure you want to reject this testimonial?');">
                                                                Reject
                                                            </a>
                                                        <?php endif; ?>

                                                        <a href="/testimonials/gest/edit?id=<?= $testimonial->id_testimonial ?>" 
                                                           class="btn btn-sm btn-primary" 
                                                           title="Edit">
                                                            Edit
                                                        </a>

                                                        <a href="/testimonials/gest/delete?id=<?= $testimonial->id_testimonial ?>" 
                                                           class="btn btn-sm btn-danger" 
                                                           title="Delete"
                                                           onclick="return confirm('Are you sure you want to delete this testimonial? This action cannot be undone.');">
                                                            Delete
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted py-4">
                            <i class="bi bi-inbox"></i> No testimonials found.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize DataTables if available
    // Wait for all scripts to load (including DataTables)
    window.addEventListener('load', function() {
        // Double check jQuery and DataTables are available
        if (typeof jQuery === 'undefined' || typeof jQuery.fn.DataTable === 'undefined') {
            console.error('jQuery or DataTables not loaded!');
            return;
        }
        
        const $ = jQuery;
        const table = $('#testimonialsTable');
        
        if (table.length) {
            // Check if DataTables is already initialized
            if ($.fn.DataTable.isDataTable('#testimonialsTable')) {
                // Get existing instance
                const dataTable = table.DataTable();
                console.log('Using existing DataTable instance');
            } else {
                // Initialize new instance
                table.DataTable({
                    order: [[5, 'desc']], // Sort by created date descending
                    pageLength: 25,
                    language: {
                        search: "Search:",
                        lengthMenu: "Show _MENU_ entries",
                        info: "Showing _START_ to _END_ of _TOTAL_ testimonials",
                        infoEmpty: "No testimonials available",
                        infoFiltered: "(filtered from _TOTAL_ total testimonials)"
                    }
                });
                console.log('DataTables initialized');
            }
        }
    });
</script>

