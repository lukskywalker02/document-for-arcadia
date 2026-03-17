<?php
// App/cms/views/gest/logs.php
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Service Change Log</h1>
        <a href="/cms/gest/start" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Services
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>User</th>
                            <th>Service</th>
                            <th>Action</th>
                            <th>Field</th>
                            <th>Old Value</th>
                            <th>New Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($logs)): ?>
                            <?php foreach ($logs as $log): ?>
                                <tr>
                                    <td class="text-muted"><small><?= $log->change_date ?></small></td>
                                    <td><span class="badge bg-info text-dark"><?= htmlspecialchars($log->username ?? 'N/A') ?></span></td>
                                    <td><?= htmlspecialchars($log->service_title ?? 'N/A') ?></td>
                                    <td>
                                        <?php 
                                            $badge_class = 'secondary';
                                            if ($log->action === 'create') $badge_class = 'success';
                                            if ($log->action === 'delete') $badge_class = 'danger';
                                            if ($log->action === 'update') $badge_class = 'warning';
                                        ?>
                                        <span class="badge bg-<?= $badge_class ?>"><?= htmlspecialchars($log->action) ?></span>
                                    </td>
                                    <td><em><?= htmlspecialchars($log->field_name ?? 'N/A') ?></em></td>
                                    <td class="text-danger"><small><?= htmlspecialchars($log->previous_value ?? 'N/A') ?></small></td>
                                    <td class="text-success"><small><?= htmlspecialchars($log->new_value ?? 'N/A') ?></small></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    No service changes have been logged yet.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
