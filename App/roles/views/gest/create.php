<!-- Formulario de crear empleado -->

<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h3>Register New Role</h3>
    </div>
    <div class="card-body">
        <!-- Success/Error Messages -->
        <?php 
        require_once __DIR__ . '/../../../../includes/helpers/messages.php';
        display_alert_message();
        ?>

        <?php require_once __DIR__ . '/../../../../includes/helpers/csrf.php'; ?>
        
        <form action="" method="post">
            <?= csrf_field('role_create') ?>

            <div class="mb-3">
                <label for="role_name"
                    class="form-label">Role Name:
                </label>

                <input type="text"
                    class="form-control"
                    id="role_name"
                    placeholder="Enter the name"
                    name="role_name"
                    aria-describedby="role_name-help"
                    required>
            </div>

            <div class="mb-3">
                <label for="role_description"
                    class="form-label">Role Description:
                </label>

                <input type="text"
                    class="form-control"
                    id="role_description"
                    placeholder="Enter the role description"
                    name="role_description"
                    aria-describedby="role_description-help"
                    required>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <input type="submit" class="btn btn-warning px-4" value="Register New Role">
                <a href="/roles/gest/start" class=" px-4 btn btn-primary">Cancel</a>
            </div>
        </form>

    </div>
</div>