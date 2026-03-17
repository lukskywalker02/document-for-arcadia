<div class="card  shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h3>
            <?php if (isset($user_to_edit)): ?>
                Edit User <?php echo $user_to_edit->employee_last_name; ?>'s account
            <?php elseif (isset($employee_to_assign)): ?>
                Assign Account to Employee <?php echo $employee_to_assign->last_name; ?>
            <?php else: ?>
                Edit User
            <?php endif; ?>
        </h3>
    </div>
    <div class="card-body">
        <!-- Success/Error Messages -->
        <?php 
        require_once __DIR__ . '/../../../../includes/helpers/messages.php';
        display_alert_message();
        ?>

        <?php if (isset($user_to_edit)) { ?>

            <?php require_once __DIR__ . '/../../../../includes/helpers/csrf.php'; ?>
            
            <form action="/users/gest/edit" method="post">
                <?= csrf_field('user_edit') ?>

                <input type="hidden" name="id" value="<?php echo $user_to_edit->id; ?>">


                <div class="mb-3">
                    <label for="username"
                        class="form-label">Username:
                    </label>

                    <input type="text"
                        class="form-control"
                        id="username"
                        placeholder="<?php echo $user_to_edit->username; ?>"
                        value="<?php echo $user_to_edit->username; ?>"
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
                        placeholder="Leave empty to keep current password"
                        value=""
                        name="psw"
                        aria-describedby="psw-help">
                </div>



                <!-- <div class="mb-3">
                    <label for="psw_confirm"
                        class="form-label">Confirm Password:
                    </label>
                    <input type="text"
                        class="form-control"
                        id="psw_confirm"
                        placeholder="<?php echo $user_to_edit->psw_confirm; ?>"
                        value="<?php echo $user_to_edit->psw_confirm; ?>"
                        name="psw_confirm"
                        aria-describedby="psw_confirm-help"
                        required>
                </div> -->

                <!-- Role Selection -->
                <div class="mb-3">
                    <label for="role" class="form-label">Rol:</label>
                    <select class="form-select" id="role" name="role">
                        <option value="">-- Sin Rol --</option>
                        <?php foreach ($roles as $role) { ?>
                            <option value="<?= $role->id_role; ?>" <?= ($user_to_edit->role_id == $role->id_role) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($role->role_name); ?>
                            </option>
                        <?php }; ?>
                    </select>
                </div>

                <!-- Employee Selection -->
                <div class="mb-3">
                    <label for="employee" class="form-label">Employee Assigned:</label>
                    
                    <?php if (!empty($user_to_edit->employee_id)) : ?>
                        
                        <p class="form-control-plaintext bg-light border rounded px-2 py-1"><?= htmlspecialchars($user_to_edit->employee_last_name ?? 'Employee assigned'); ?></p>
                        <input type="hidden" name="employee" value="<?= htmlspecialchars($user_to_edit->employee_id); ?>">
                        <div class="form-text">The assignment of an employee to an account is permanent.</div>

                    <?php else : ?>

                        <select class="form-select" id="employee" name="employee">
                            <option value="">-- Assign an employee --</option>
                            <?php foreach ($employees as $employee) { ?>
                                <option value="<?= $employee->id_employee; ?>">
                                    <?= htmlspecialchars($employee->last_name); ?>
                                </option>
                            <?php }; ?>
                        </select>
                        <div class="form-text">Once you assign an employee to this account, you cannot change them.</div>

                    <?php endif; ?>
                </div>

                <!-- VIP Permissions Section -->
                <hr class="my-4">
                <h5 class="mb-3">⭐ VIP Permissions</h5>
                <p class="text-muted">Mark the additional permissions you want to assign ONLY to this user. These will be added to the ones he already has by his role.</p>

                <div class="row"></div>
                    <?php
                    // The data now comes from the controller, we no longer need the test data.
                    // The $availableVipPermissions variable contains the permissions that can be assigned.
                    // The $userDirectPermissionIds variable tells us which ones the user already has.
                    ?>

                    <?php foreach ($availableVipPermissions as $permission) : ?>
                        <div class="col-md-6 col-lg-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       value="<?= $permission['id_permission'] ?>" 
                                       id="permission_<?= $permission['id_permission'] ?>" 
                                       name="permissions[]"
                                       <?php if (in_array($permission['id_permission'], $userDirectPermissionIds)) echo 'checked'; ?>>
                                <label class="form-check-label" for="permission_<?= $permission['id_permission'] ?>">
                                    <strong><?= htmlspecialchars(ucwords(str_replace('-', ' ', $permission['permission_name']))) ?></strong>
                                    <small class="text-muted d-block"><?= htmlspecialchars($permission['permission_desc']) ?></small>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- End VIP Permissions Section -->


                <div class="card-footer text-end d-flex justify-content-between align-items-start">
                    <input type="submit" class="btn btn-warning px-4" value="Update User">
                    <a href="/users/gest/view?id=<?php echo $user_to_edit->id; ?>" class="btn btn-sm btn-info text-white">View Details</a>
                    <a href="/users/gest/start#user-<?php echo $user_to_edit->id; ?>" class=" btn btn-primary px-4">Cancel</a>
                </div>
            </form>

        <?php } else if (isset($employee_to_assign)) { ?>

            <form action="/users/gest/assignAccount" method="post">
                <?= csrf_field('user_assign') ?>

                <input type="hidden" name="employee_id" value="<?php echo $employee_to_assign->id; ?>">

                <div class="mb-3">
                    <label for="user_id" class="form-label">Select User Account to Assign to <?php echo $employee_to_assign->last_name; ?>:</label>
                    <select class="form-select" id="user_id" name="user_id" required>
                        <option value="">Select a user:</option>
                        <?php foreach ($unassigned_users as $user) { ?>
                            <option value="<?php echo $user->id_user; ?>"><?php echo $user->username; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="card-footer text-end d-flex justify-content-between align-items-start">
                    <input type="submit" class="btn btn-success px-4" value="Assign Account">
                    <a href="/users/gest/start#employee-<?php echo $employee_to_assign->id; ?>" class="btn btn-primary px-4">Cancel</a>
                    
                </div>
            </form>


        <?php } ?>


    </div>
</div>


<br>
<br>
<br>
<br>
</body>