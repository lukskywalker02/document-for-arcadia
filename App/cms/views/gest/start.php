<?php
// App/cms/views/gest/start.php
// Include functions to use hasPermission()
require_once __DIR__ . '/../../../../includes/functions.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Zoo Services</h1>
        <?php if (hasPermission('services-create')): ?>
            <a href="/cms/gest/create" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Create New Service
            </a>
        <?php endif; ?>
    </div>

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
                            <th style="width: 50px;">ID</th>
                            <th>Img</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($services)): ?>
                            <?php foreach ($services as $service): ?>
                                <tr>
                                    <!-- ID Column -->
                                    <td class="fw-bold text-muted">#<?= $service->id_service ?></td>

                                    <!-- Image Column -->
                                    <td style="width: 80px;">
                                        <?php if (!empty($service->media_path)): ?>
                                            <img src="<?= $service->media_path ?>" alt="Service Img" 
                                                 class="rounded" style="width: 60px; height: 60px; object-fit: cover;" loading="lazy">
                                        <?php else: ?>
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 60px;">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <!-- Title -->
                                    <td class="fw-bold"><?= htmlspecialchars($service->service_title) ?></td>
                                    
                                    <!-- Description (Truncated) -->
                                    <td>
                                        <?= nl2br(htmlspecialchars(substr($service->service_description, 0, 100))) ?>...
                                    </td>
                                    
                                    <!-- Actions -->
                                    <td class="text-end">
                                        <?php if (hasPermission('services-edit')): ?>
                                            <a href="/cms/gest/edit?id=<?= $service->id_service ?>" class="btn btn-sm btn-warning me-1">
                                                <i>edit</i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if (hasPermission('services-delete')): ?>
                                            <a href="/cms/gest/delete?id=<?= $service->id_service ?>" 
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Are you sure you want to delete this service?');">
                                                <i>delete</i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No services found. Click "Create New Service" to add one.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
