<div class="card container-fluid overflow-auto">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title">Employees</h2>
        
        <?php 
        // Only Admin can create employees
        $isAdmin = (isset($_SESSION['user']['role_name']) && $_SESSION['user']['role_name'] === 'Admin');
        if ($isAdmin): 
        ?>
            <a name="employees" id="" class="btn btn-success mb-2 mt-2" href="/employees/gest/create" role="button">+ Create New Employee</a>
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
                        <th class="text-nowrap border border-start-3 border-end-0 rounded-start-3 text-center align-middle" scope="col">Name</th>
                        <th class="text-nowrap border border-start-1 border-end-1 text-center align-middle" scope="col">Last Name</th>
                        <th class="text-nowrap border border-start-1 border-end-1 text-center align-middle" scope="col">Birthdate</th>
                        <th class="text-nowrap border border-start-1 border-end-1 text-center align-middle" scope="col">Phone</th>
                        <th class="text-nowrap border border-start-1 border-end-1 text-center align-middle" scope="col">Email</th>
                        <th class="text-nowrap border border-start-1 border-end-1 text-center align-middle" scope="col">Address</th>
                        <th class="text-nowrap border border-start-1 border-end-1 text-center align-middle" scope="col">City</th>
                        <th class="text-nowrap border border-start-1 border-end-1 text-center align-middle" scope="col">Zip Code</th>
                        <th class="text-nowrap border border-start-1 border-end-1 text-center align-middle" scope="col">Country</th>
                        <th class="text-nowrap border border-start-1 border-end-1 text-center align-middle" scope="col">Gender</th>
                        <th class="text-nowrap border border-start-1 border-end-1 text-center align-middle" scope="col">Marital Status</th>
                        <th class="text-nowrap border border-start-1 border-end-1 text-center align-middle" scope="col">Role</th>
                        <th class="text-nowrap border border-start-1 border-end-1 text-center align-middle" scope="col">Created at</th>
                        <th class="text-nowrap border border-start-1 border-end-1 text-center align-middle" scope="col">Updated at</th>
                        
                        <?php if ($isAdmin): ?>
                            <th class="text-nowrap border border-end-3 rounded-end-3 text-center align-middle" scope="col">Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    // Initialize the row number to draw the table rows, thanks to the file, that includes the get_row_class() and get_cell_border_class() functions in the functions.php file in /includes folder
                    $rowNumber = 0;

                    // Iterate through the employees and add them to the table, thanks to the $employees array (defined in the controller employees_gest_controller.php)
                    foreach ($employees as $employee) {

                        // Increment the row number
                        $rowNumber++;
                    ?>
                        <!-- Draw the table row, thanks to the get_row_class() function in the functions.php file in /includes folder -->
                        <tr class="<?php echo get_row_class($rowNumber); ?> ">
                            <!-- Draw the table cell, thanks to the get_cell_border_class() function in the functions.php file in /includes folder -->
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>"> <?php echo $employee->first_name; ?> </td>
                            <!-- Draw the table cell, thanks to the get_cell_border_class() function in the functions.php file in /includes folder -->
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>"> <?php echo $employee->last_name; ?> </td>
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>"> <?php echo $employee->birthdate; ?> </td>
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>"> <?php echo $employee->phone; ?> </td>
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>"> <?php echo $employee->email; ?> </td>
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>"> <?php echo $employee->address; ?> </td>
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>"> <?php echo $employee->city; ?> </td>
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>"> <?php echo $employee->zip_code; ?> </td>
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>"> <?php echo $employee->country; ?> </td>
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>"> <?php echo $employee->gender; ?> </td>
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>"> <?php echo $employee->marital_status; ?> </td>
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>"> <?php echo $employee->role_name; ?> </td>
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>"> <?php echo $employee->created_at; ?> </td>
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>"> <?php echo $employee->updated_at; ?> </td>
                            
                            <?php if ($isAdmin): ?>
                                <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>">

                                    <div class="btn-group" role="group" aria-label="">

                                        <a href="/employees/gest/edit?id=<?php echo $employee->id; ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $employee->id; ?>">Delete</button>
                                    </div>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteModal<?php echo $employee->id; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $employee->id; ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel<?php echo $employee->id; ?>">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete the employee <strong><?php echo htmlspecialchars($employee->first_name . ' ' . $employee->last_name); ?></strong>?</p>
                                                    <p class="text-danger"><small>This action cannot be undone.</small></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <a href="/employees/gest/delete?id=<?php echo $employee->id; ?>" class="btn btn-danger">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            <?php endif; ?>
                        </tr>

                    <?php
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>