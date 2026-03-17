<?php
// App/schedules/views/gest/start.php
// Include functions to use hasPermission()
require_once __DIR__ . '/../../../../includes/functions.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Opening Hours</h1>
    </div>

    <!-- Success/Error Messages -->
    <?php 
    require_once __DIR__ . '/../../../../includes/helpers/messages.php';
    display_alert_message();
    ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Time Slot / Day</th>
                            <th>Opening Time</th>
                            <th>Closing Time</th>
                            <th>Status</th>
                            <th>Last Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($schedules)): ?>
                            <?php foreach ($schedules as $schedule): ?>
                                <tr>
                                    <td><?= $schedule->id_opening ?></td>
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            <?= ucfirst($schedule->time_slot) ?>
                                        </span>
                                    </td>
                                    <td><?= substr($schedule->opening_time, 0, 5) ?></td>
                                    <td><?= substr($schedule->closing_time, 0, 5) ?></td>
                                    <td>
                                        <?php if ($schedule->status === 'open'): ?>
                                            <span class="badge bg-success">Open</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Closed</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $schedule->updated_at ?></td>
                                    <td>
                                        <?php if (hasPermission('schedules-edit')): ?>
                                            <a href="/schedules/gest/edit?id=<?= $schedule->id_opening ?>" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">No schedules found in the database.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
