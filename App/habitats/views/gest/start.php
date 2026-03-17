<?php
// App/habitats/views/gest/start.php
// Include functions to use hasPermission()
require_once __DIR__ . '/../../../../includes/functions.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Habitats</h1>
        <?php 
        // Only users with habitats-create permission can create habitats
        if (hasPermission('habitats-create')): 
        ?>
            <a href="/habitats/gest/create" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Create New Habitat
            </a>
        <?php endif; ?>
    </div>

    <?php 
    require_once __DIR__ . '/../../../../includes/helpers/messages.php';
    display_alert_message('Action completed successfully!', [
        'saved' => 'Action completed successfully!',
        'deleted' => 'Habitat deleted successfully!'
    ]);
    ?>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <th>Image</th>
                            <th>Habitat Name</th>
                            <th>Description</th>
                            <th>Animals</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($habitats)): ?>
                            <?php foreach ($habitats as $habitat): ?>
                                <tr>
                                    <td class="fw-bold text-muted">#<?= $habitat->id_habitat ?></td>
                                    
                                    <!-- Image Column -->
                                    <td style="width: 80px;">
                                        <?php if (!empty($habitat->media_path)): ?>
                                            <img src="<?= htmlspecialchars($habitat->media_path) ?>" alt="Habitat Photo" 
                                                 class="rounded" style="width: 60px; height: 60px; object-fit: cover;" loading="lazy">
                                        <?php else: ?>
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 60px;">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="fw-bold"><?= htmlspecialchars($habitat->habitat_name) ?></td>
                                    <td><?= htmlspecialchars($habitat->description_habitat ?? 'No description') ?></td>
                                    <td>
                                        <span class="badge bg-info"><?= $habitat->animal_count ?? 0 ?></span>
                                    </td>
                                    <td class="text-end">
                                        <?php if (hasPermission('habitats-edit')): ?>
                                            <a href="/habitats/gest/edit?id=<?= $habitat->id_habitat ?>" class="btn btn-sm btn-warning me-1">
                                                <i>edit</i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if (hasPermission('habitats-delete')): ?>
                                            <a href="/habitats/gest/delete?id=<?= $habitat->id_habitat ?>" 
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Are you sure you want to delete this habitat?');">
                                                <i>delete</i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No habitats found. Click "Create New Habitat" to add one.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



