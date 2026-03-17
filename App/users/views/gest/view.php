<?php
// Include functions to use hasPermission()
require_once __DIR__ . '/../../../../includes/functions.php';
?>
<!-- App/users/views/gest/view.php -->
<div class="container-fluid pt-4 px-4">
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
            <h3 class="mb-0">User details: <?= htmlspecialchars($user->username) ?></h3>
        </div>
        <div class="card-body">
            <!-- Section of the Role -->
            <h5 class="card-title">Assigned Role</h5>
            <?php if ($role) : ?>
                <p class="card-text mb-4">
                    <strong><?= htmlspecialchars($role->role_name) ?>:</strong>
                    <?= htmlspecialchars($role->role_description) ?>
                </p>
            <?php else : ?>
                <div class="alert alert-secondary" role="alert">
                    This user <?= htmlspecialchars($user->username) ?> has no role assigned directly.
                </div>
            <?php endif; ?>

            <hr>
            <h5 class="card-title">Assigned Employee:</h5>
            <?php if (!empty($user->employee_email)) : ?>
                <p class="card-text mb-4">
                    <strong>Employee email:</strong>
                    <?= htmlspecialchars($user->employee_email) ?>
                </p>
            <?php else : ?>
                <div class="alert alert-secondary" role="alert">
                    This user <?= htmlspecialchars($user->username) ?> has no employee assigned.
                </div>
            <?php endif; ?>

            <hr>

            <!-- Section of VIP Permissions -->
            <h5 class="card-title mt-4">⭐ VIP Permissions Assigned to <?= htmlspecialchars($user->username) ?></h5>
            <p class="text-muted">This is a list of additional permissions, specific to this user.</p>

            <?php
            // We create an array that only contains the IDs of the permissions of the ROLE
            // to be able to easily search if a VIP permission is already in the role.
            $rolePermissionIds = array_column($rolePermissions, 'id_permission');
            ?>

            <?php if (!empty($permissions)) : ?>
                <div class="list-group">
                    <?php foreach ($permissions as $permission) : ?>
                        <div class="list-group-item">
                            <strong><?= htmlspecialchars(ucwords(str_replace('-', ' ', $permission['permission_name']))) ?></strong>
                            
                            
                            <?php if (in_array($permission['id_permission'], $rolePermissionIds)) : ?>
                                <span class="badge bg-primary ms-2">Included in his role</span>
                            <?php endif; ?>
                            
                            <br>
                            <small class="text-muted"><?= htmlspecialchars($permission['permission_desc']) ?></small>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="alert alert-warning" role="alert">
                    The user <?= htmlspecialchars($user->username) ?> has no VIP permissions assigned.
                </div>
            <?php endif; ?>
        </div>
        <div class="card-footer text-end d-flex justify-content-between align-items-start">
            <a href="/users/gest/start#user-<?= htmlspecialchars($user->id) ?>" class="btn btn-primary">Back to the list</a>
            <?php 
            // Only show Edit button if user has users-edit permission or is Admin
            $isAdmin = isset($_SESSION['user']['role_name']) && $_SESSION['user']['role_name'] === 'Admin';
            if ($isAdmin || hasPermission('users-edit')): 
            ?>
                <a href="/users/gest/edit?id=<?= htmlspecialchars($user->id) ?>" class="btn btn-primary">Edit</a>
            <?php endif; ?>
        </div>
    </div>
</div>
