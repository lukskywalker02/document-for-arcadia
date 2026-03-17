<?php
// App/animals/views/feeding/start.php
// Include functions to use hasPermission()
require_once __DIR__ . '/../../../../includes/functions.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Feeding Logs</h1>
        <?php 
            // Only users with animal_feeding-assign permission can create feeding logs
            if (hasPermission('animal_feeding-assign')): 
        ?>
            <a href="/animals/feeding/create" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Record New Feeding
            </a>
        <?php endif; ?>
    </div>

    <?php 
    require_once __DIR__ . '/../../../../includes/helpers/messages.php';
    display_alert_message('Action completed successfully!', [
        'saved' => 'Feeding log saved successfully!',
        'deleted' => 'Feeding log deleted successfully!'
    ]);
    ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <th>Animal</th>
                            <th>Food Type</th>
                            <th>Quantity (g)</th>
                            <th>Plan Base</th>
                            <th>Difference</th>
                            <th>Fed By</th>
                            <th>Date & Time</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($feedings)): ?>
                            <?php foreach ($feedings as $feeding): ?>
                                <tr>
                                    <!-- ID Column -->
                                    <td class="fw-bold text-muted">#<?= $feeding->id_feeding_log ?? 'N/A' ?></td>

                                    <!-- Animal Name -->
                                    <td class="fw-bold">
                                        <a href="/animals/feeding/view?animal_id=<?= $feeding->animal_f_id ?>" class="text-decoration-none">
                                            <?= htmlspecialchars($feeding->animal_name ?? 'N/A') ?>
                                        </a>
                                    </td>

                                    <!-- Food Type -->
                                    <td>
                                        <span class="badge bg-info">
                                            <?= htmlspecialchars(ucfirst($feeding->food_type ?? 'N/A')) ?>
                                        </span>
                                    </td>

                                    <!-- Quantity Given -->
                                    <td class="fw-bold"><?= number_format($feeding->food_qtty ?? 0) ?>g</td>

                                    <!-- Plan Base (from nutrition) -->
                                    <td>
                                        <?php if ($feeding->plan_food_qtty): ?>
                                            <span class="text-muted">
                                                <?= number_format($feeding->plan_food_qtty) ?>g
                                                <small class="d-block text-muted">(<?= htmlspecialchars(ucfirst($feeding->plan_food_type ?? 'N/A')) ?>)</small>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">No plan assigned</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Difference (Real vs Plan) -->
                                    <td>
                                        <?php if ($feeding->plan_food_qtty): ?>
                                            <?php 
                                                $diff = $feeding->food_qtty - $feeding->plan_food_qtty;
                                                $diffPercent = $feeding->plan_food_qtty > 0 ? round(($diff / $feeding->plan_food_qtty) * 100, 1) : 0;
                                            ?>
                                            <?php if ($diff > 0): ?>
                                                <span class="badge bg-warning text-dark">
                                                    +<?= number_format($diff) ?>g (+<?= abs($diffPercent) ?>%)
                                                </span>
                                            <?php elseif ($diff < 0): ?>
                                                <span class="badge bg-danger">
                                                    <?= number_format($diff) ?>g (<?= abs($diffPercent) ?>%)
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-success">
                                                    Exact (0%)
                                                </span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Fed By (User) -->
                                    <td>
                                        <?= htmlspecialchars($feeding->fed_by_username ?? 'Unknown') ?>
                                    </td>

                                    <!-- Date & Time -->
                                    <td>
                                        <?php 
                                            $date = new DateTime($feeding->food_date);
                                            echo $date->format('Y-m-d H:i');
                                        ?>
                                    </td>

                                    <!-- Actions -->
                                    <td class="text-end">
                                        <?php 
                                            // View button: visible if user has animal_feeding-view OR animal_feeding-assign
                                            if (hasPermission('animal_feeding-view') || hasPermission('animal_feeding-assign')): 
                                        ?>
                                            <a href="/animals/feeding/view?animal_id=<?= $feeding->animal_f_id ?>" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="View all feedings for this animal">
                                                <i class="bi bi-eye">view</i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php 
                                            // Delete button: visible if user has animal_feeding-delete OR animal_feeding-assign
                                            if (hasPermission('animal_feeding-delete') || hasPermission('animal_feeding-assign')): 
                                        ?>
                                            <a href="/animals/feeding/delete?id=<?= $feeding->id_feeding_log ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               onclick="return confirm('Are you sure you want to delete this feeding log?')"
                                               title="Delete">
                                                <i class="bi bi-trash">delete</i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox"></i> No feeding logs found.
                                        <?php 
                                            // Only users with animal_feeding-assign permission can create feeding logs
                                            if (hasPermission('animal_feeding-assign')): 
                                        ?>
                                            <a href="/animals/feeding/create">Create the first one!</a>
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

