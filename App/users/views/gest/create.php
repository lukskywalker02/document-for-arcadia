<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h3>Create Account</h3>
    </div>
    <div class="card-body">
        <!-- Success/Error Messages -->
        <?php 
        require_once __DIR__ . '/../../../../includes/helpers/messages.php';
        display_alert_message();
        ?>

        <?php require_once __DIR__ . '/../../../../includes/helpers/csrf.php'; ?>
        
        <form action="" method="post">
            <?= csrf_field('user_create') ?>

            <div class="mb-3">
                <label for="username"
                    class="form-label">Username:
                </label>

                <input type="text"
                    class="form-control"
                    id="username"
                    placeholder="Enter a username"
                    name="username"
                    aria-describedby="username-help"
                    required>
            </div>

            <div class="mb-3">
                <label for="psw"
                    class="form-label">Password:
                </label>

                <input type="text"
                    class="form-control"
                    id="psw"
                    placeholder="********"
                    name="psw"
                    aria-describedby="psw-help"
                    required>
            </div>

            <div class="mb-3">
                <label for="psw_confirm"
                    class="form-label">Confirm Password:
                </label>

                <input type="text"
                    class="form-control"
                    id="psw_confirm"
                    placeholder="********"
                    name="psw_confirm"
                    aria-describedby="psw_confirm-help"
                    required>
            </div>

            <div class="mb-3">
                <label for="role"
                    class="form-label">Role:
                </label>
                <select class="form-select"
                    id="role"
                    name="role"
                    aria-describedby="role-help"
                    >

                    <option selected value="">
                        Select a role:
                    </option>
                    <?php foreach ($roles as $role) { ?>

                        <option value="<?php echo $role->id_role; ?>">
                            <?php echo $role->role_name; ?>
                        </option>

                    <?php }; ?>

                </select>
            </div>

            
            <div class="mb-3">
                <label for="employee"
                    class="form-label">Employee:
                </label>
                <select class="form-select"
                    id="employee"
                    name="employee"
                    aria-describedby="employee-help"
                    >

                    <option selected value="">
                        Asign employee to the account created:
                    </option>
                    <?php foreach ($employees as $employee) { ?>

                        <option value="<?php echo $employee->id_employee; ?>">
                            <?php echo $employee->last_name; ?>
                        </option>

                    <?php }; ?>

                </select>
            </div>



            <div class="card-footer d-flex justify-content-between align-items-center">
                <input type="submit" class="btn btn-warning px-4" value="Register Account">
                <a href="/users/gest/start" class=" px-4 btn btn-primary">Cancel</a>
            </div>
        </form>

    </div>
</div>