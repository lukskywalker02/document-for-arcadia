<?php
// App/animals/views/feeding/view.php
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Feeding History: <?= htmlspecialchars($animal->animal_name ?? 'N/A') ?></h1>
            <p class="text-muted mb-0">
                <?= htmlspecialchars($animal->specie_name ?? 'N/A') ?> 
                <?php if ($animal->habitat_name): ?>
                    | Habitat: <?= htmlspecialchars($animal->habitat_name) ?>
                <?php endif; ?>
            </p>
        </div>
        <div>
            <?php 
                // Include functions to use hasPermission()
                require_once __DIR__ . '/../../../../includes/functions.php';
                
                // Only users with animal_feeding-assign permission can create feeding logs
                if (hasPermission('animal_feeding-assign')): 
            ?>
                <a href="/animals/feeding/create?animal_id=<?= $animal->id_full_animal ?>" class="btn btn-primary me-2">
                    <i class="bi bi-plus-circle"></i> Record New Feeding
                </a>
            <?php endif; ?>
            <a href="/animals/feeding/start" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <!-- Nutrition Plan Info -->
    <?php if ($animal->nutrition_id): ?>
        <div class="alert alert-info mb-4">
            <h5 class="alert-heading">
                <i class="bi bi-clipboard-check"></i> Nutrition Plan
            </h5>
            <p class="mb-0">
                <strong>Type:</strong> <?= htmlspecialchars(ucfirst($animal->nutrition_type ?? 'N/A')) ?><br>
                <strong>Food:</strong> <?= htmlspecialchars(ucfirst($animal->nutrition_food_type ?? 'N/A')) ?><br>
                <strong>Quantity:</strong> <?= number_format($animal->nutrition_food_qtty ?? 0) ?>g
            </p>
        </div>
    <?php else: ?>
        <div class="alert alert-warning mb-4">
            <i class="bi bi-exclamation-triangle"></i> This animal has no nutrition plan assigned.
        </div>
    <?php endif; ?>

    <!-- Last Feeding Summary -->
    <?php if ($lastFeeding): ?>
        <div class="card mb-4 border-primary">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-clock-history"></i> Last Feeding
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <strong>Date & Time:</strong><br>
                        <?php 
                            $date = new DateTime($lastFeeding->food_date);
                            echo $date->format('Y-m-d H:i');
                        ?>
                    </div>
                    <div class="col-md-3">
                        <strong>Food Type:</strong><br>
                        <span class="badge bg-info"><?= htmlspecialchars(ucfirst($lastFeeding->food_type ?? 'N/A')) ?></span>
                    </div>
                    <div class="col-md-3">
                        <strong>Quantity:</strong><br>
                        <span class="fw-bold"><?= number_format($lastFeeding->food_qtty ?? 0) ?>g</span>
                    </div>
                    <div class="col-md-3">
                        <strong>Fed By:</strong><br>
                        <?= htmlspecialchars($lastFeeding->fed_by_username ?? 'Unknown') ?>
                    </div>
                </div>
                <?php if ($animal->nutrition_id && $lastFeeding->plan_food_qtty): ?>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <strong>Comparison with Plan:</strong>
                            <?php 
                                $diff = $lastFeeding->food_qtty - $lastFeeding->plan_food_qtty;
                                $diffPercent = $lastFeeding->plan_food_qtty > 0 ? round(($diff / $lastFeeding->plan_food_qtty) * 100, 1) : 0;
                            ?>
                            <?php if ($diff > 0): ?>
                                <span class="badge bg-warning text-dark">
                                    +<?= number_format($diff) ?>g more than plan (+<?= abs($diffPercent) ?>%)
                                </span>
                            <?php elseif ($diff < 0): ?>
                                <span class="badge bg-danger">
                                    <?= number_format($diff) ?>g less than plan (<?= abs($diffPercent) ?>%)
                                </span>
                            <?php else: ?>
                                <span class="badge bg-success">
                                    Exactly as planned (0%)
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Feeding Logs Table -->
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">All Feeding Records</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">ID</th>
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
                                            // Delete button: visible if user has animal_feeding-delete OR animal_feeding-assign
                                            if (hasPermission('animal_feeding-delete') || hasPermission('animal_feeding-assign')): 
                                        ?>
                                            <a href="/animals/feeding/delete?id=<?= $feeding->id_feeding_log ?>&animal_id=<?= $animal->id_full_animal ?>" 
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
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox"></i> No feeding records found for this animal.
                                    <?php 
                                        // Only users with animal_feeding-assign permission can create feeding logs
                                        if (hasPermission('animal_feeding-assign')): 
                                    ?>
                                        <a href="/animals/feeding/create?animal_id=<?= $animal->id_full_animal ?>">Create the first one!</a>
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

