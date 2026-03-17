<?php
// Include functions to use hasPermission()
require_once __DIR__ . '/../../../../includes/functions.php';
?>
<!-- App/roles/views/gest/view.php -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h3 class="mb-0">Rol details: <?= htmlspecialchars($role->role_name) ?></h3>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Description</h5>
                    <p class="card-text mb-4">
                        <?= htmlspecialchars($role->role_description) ?>
                    </p>

                    <hr>

                    <h5 class="card-title mt-4">Permissions Assigned</h5>
                    <p class="text-muted">This is a read-only list of the actions that this role can perform.</p>

                    <?php if (!empty($permissions)) : ?>
                        <div class="list-group">
                            <?php foreach ($permissions as $permission) : ?>
                                <div class="list-group-item">
                                    <strong><?= htmlspecialchars(ucwords(str_replace('-', ' ', $permission['permission_name']))) ?></strong>
                                    <br>
                                    <small class="text-muted"><?= htmlspecialchars($permission['permission_desc']) ?></small>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <div class="alert alert-warning" role="alert">
                            This role has no permissions assigned currently.
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer text-end d-flex justify-content-between align-items-start">
                    <a href="/roles/gest/start" class="btn btn-primary">Back to the list</a>
                    <?php 
                    // Only show Edit button if user has roles-edit permission or is Admin
                    $isAdmin = isset($_SESSION['user']['role_name']) && $_SESSION['user']['role_name'] === 'Admin';
                    if ($isAdmin || hasPermission('roles-edit')): 
                    ?>
                        <a href="/roles/gest/edit?id=<?= htmlspecialchars($role->id_role) ?>" class="btn btn-primary">Edit</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
