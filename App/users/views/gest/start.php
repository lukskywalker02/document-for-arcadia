<div class="card container-fluid overflow-auto">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title">Users</h2>
        
        <?php 
        // 🛡️ Only users with users-create permission can create users
        $isAdmin = (isset($_SESSION['user']['role_name']) && $_SESSION['user']['role_name'] === 'Admin');
        if ($isAdmin || hasPermission('users-create')): 
        ?>
            <a name="users" id="" class="btn btn-success mb-2 mt-2" href="/users/gest/create" role="button">+ Create new Account</a>
        <?php endif; ?>
    </div>
    
    <!-- Show success, error or warning messages -->
    <?php 
    require_once __DIR__ . '/../../../../includes/helpers/messages.php';
    display_alert_message();
    ?>
    
    <div class="card-body container-fluid overflow-auto">

        <div class="table-responsive">
            <table class="table table-hover table-striped dataTable">
                <thead class="table-dark">
                    <tr>
                        <th class="text-nowrap border border-start-3 border-end-0 rounded-start-3 text-center align-middle" scope="col">ID</th>
                        <th class="text-nowrap border border-start-3 border-end-0 rounded-start-3 text-center align-middle" scope="col">Username</th>
                        <th class="text-nowrap border border-start-1 border-end-1 text-center align-middle" scope="col">Activated ?</th>
                        <th class="text-nowrap border border-start-1 border-end-1 text-center align-middle" scope="col">Role</th>
                        <th class="text-nowrap border border-start-1 border-end-1 text-center align-middle" scope="col">Employee-Name</th>
                        <th class="text-nowrap border border-start-1 border-end-1 text-center align-middle" scope="col">Created-At</th>
                        <th class="text-nowrap border border-start-1 border-end-1 text-center align-middle" scope="col">Updated-At</th>
                        <th class="text-nowrap border border-end-3 rounded-end-3 text-center align-middle" scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $rowNumber = 0;

                    foreach ($users as $user) {

                        // LOGIC OF VISIBILITY: 
                        // If I am not Admin and the user is deactivated... SKIP!
                        if (!$isAdmin && $user->is_active == 0) {
                            continue; 
                        }

                        $rowNumber++;
                    ?>
                        <?php 
                            // Determine the ID for the anchor. If it is a user, we use their ID.
                            // If it is an employee without a user, we use the employee's ID.
                            $anchor_id = '';
                            if (isset($user->id) && $user->id != null) {
                                $anchor_id = 'user-' . htmlspecialchars($user->id);
                            } else if (isset($user->employee_id) && $user->employee_id != null) {
                                $anchor_id = 'employee-' . htmlspecialchars($user->employee_id);
                            }
                        ?>
                        <tr id="<?= $anchor_id ?>" class="<?php echo get_row_class($rowNumber); ?> " >
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>"> <?php echo $user->id; ?> </td>
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>"> <?php echo $user->username; ?> </td>
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>">
                                <div class="btn-group" role="group" aria-label="">
                                    <?php if ($user->is_active == 1): ?>
                                        <span class="btn btn-sm bg-success text-white">Activated</span>
                                        
                                        <?php 
                                        // PROTECTION 1: Am I myself?
                                        $isMe = (isset($_SESSION['user']['id_user']) && $_SESSION['user']['id_user'] == $user->id);
                                        
                                        if ($isMe): 
                                        ?>
                                            <button class="btn btn-sm btn-secondary" disabled title="You cannot deactivate yourself">Deactivate</button>
                                        <?php elseif ($isAdmin): ?>
                                            <a href="/users/gest/toggleActivation?id=<?php echo $user->id; ?>" class="btn btn-sm btn-warning">Deactivate</a>
                                        <?php else: ?>
                                            <!-- If I am not Admin, I do not see the button -->
                                            <button class="btn btn-sm btn-secondary" disabled title="Only Admins can deactivate users">Deactivate</button>
                                        <?php endif; ?>

                                    <?php else: ?>
                                        
                                        <?php 
                                        if ($isAdmin):
                                        ?>
                                            <a href="/users/gest/toggleActivation?id=<?php echo $user->id; ?>" class="btn btn-sm btn-primary text-white">Activate</a>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-secondary" disabled title="Only Admins can activate users">Activate</button>
                                        <?php endif; ?>

                                        <span class="btn btn-sm bg-danger text-white">Deactivated</span>
                                    <?php endif; ?>


                                </div>
                                <?php echo $user->is_active; ?>
                            </td>
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>"> <?php echo $user->role_name; ?> </td>
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>"> <?php echo $user->employee_last_name; ?> </td>
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>"> <?php echo $user->created_at; ?> </td>
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>"> <?php echo $user->updated_at; ?> </td>
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>">

                                <div class="btn-group" role="group" aria-label="">

                                    <?php if (isset($user->id) && $user->id != null): ?>
                                        <!-- Is a user account, we send his ID to edit him -->
                                        
                                        <!-- View Details: VISIBLE FOR ALL -->
                                        <a href="/users/gest/view?id=<?php echo $user->id; ?>" class="btn btn-sm btn-info text-white">View Details</a>
                                        
                                        <?php if ($isAdmin || hasPermission('users-edit')): ?>
                                            <a href="/users/gest/edit?id=<?php echo $user->id; ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <?php endif; ?>
                                        
                                        <?php if ($isAdmin || hasPermission('users-delete')): ?>
                                            <a href="/users/gest/delete?id=<?php echo $user->id; ?>" class="btn btn-sm btn-danger">Delete</a>
                                        <?php endif; ?>

                                    <?php else: ?>
                                        <!-- Is an employee -->
                                        <?php if ($isAdmin): ?>
                                            <a href="/users/gest/edit?assign_to_employee=<?php echo $user->employee_id; ?>" class="btn btn-sm btn-info">Assign</a>
                                        <?php else: ?>
                                            <span class="text-muted fst-italic">Not Assigned</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
                                </div>

                            </td>
                        </tr>

                    <?php
                    }
                    ?>

                </tbody>
            </table>



        </div>
    </div>
</div>