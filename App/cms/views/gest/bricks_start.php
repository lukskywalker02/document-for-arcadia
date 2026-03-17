<?php
// App/cms/views/gest/bricks_start.php
// Include functions to use hasPermission()
require_once __DIR__ . '/../../../../includes/functions.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Content Blocks (Bricks)</h1>
        <?php if (hasPermission('services-create')): ?>
            <a href="/cms/bricks/create" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Create New Brick
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
                            <th>Page</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($bricks)): ?>
                            <?php foreach ($bricks as $brick): ?>
                                <tr>
                                    <td class="text-muted">#<?= $brick->id_brick ?></td>
                                    
                                    <!-- Image Column -->
                                    <td style="width: 80px;">
                                        <?php if (!empty($brick->media_path)): ?>
                                            <img src="<?= $brick->media_path ?>" class="rounded" style="width: 60px; height: 40px; object-fit: cover;" loading="lazy">
                                        <?php else: ?>
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 40px; font-size: 0.8rem;">
                                                No Img
                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <td><span class="badge bg-info text-dark"><?= ucfirst($brick->page_name) ?></span></td>
                                    <td class="fw-bold"><?= htmlspecialchars($brick->title) ?></td>
                                    <td><?= nl2br(htmlspecialchars(substr($brick->description, 0, 60))) ?>...</td>
                                    
                                    <td class="text-end">
                                        <?php if (hasPermission('services-edit')): ?>
                                            <a href="/cms/bricks/edit?id=<?= $brick->id_brick ?>" class="btn btn-sm btn-warning me-1">
                                                <i class="bi bi-pencil">Edit</i> 
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if (hasPermission('services-delete')): ?>
                                            <a href="/cms/bricks/delete?id=<?= $brick->id_brick ?>" 
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Are you sure you want to delete this brick?');">
                                                <i class="bi bi-trash">delete</i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?> 
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No content blocks found. Create one for your pages (Home, About, etc.).
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

