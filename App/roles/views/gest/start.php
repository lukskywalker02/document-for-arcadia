<?php
// Include functions to use hasPermission()
require_once __DIR__ . '/../../../../includes/functions.php';
?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title">Roles</h2>
        
        <?php 
        // Only Admin or users with roles-create permission can create roles
        $isAdmin = (isset($_SESSION['user']['role_name']) && $_SESSION['user']['role_name'] === 'Admin');
        // roles create from permission list
        if ($isAdmin || hasPermission('roles-create')): 
        ?>
            <a name="roles" id="" class="btn btn-success mb-2 mt-2" href="/roles/gest/create" role="button">+ Add New Role</a>
        <?php endif; ?>
    </div>
    <div class="card-body">

        <!-- Mostrar mensaje de error/success desde URL (msg=error) -->
        <?php 
        require_once __DIR__ . '/../../../../includes/helpers/messages.php';
        display_alert_message();
        ?>

        <!-- Mostrar mensaje de error si existe en sesión -->
        <?php if (isset($_SESSION['error_message'])): ?>
            <div id="error-message" class="alert alert-danger">
                <strong>Error:</strong> <?php echo htmlspecialchars($_SESSION['error_message']); ?>
            </div>
            <script>
                setTimeout(function() {
                    document.getElementById('error-message').style.display = 'none';
                }, 6000);
            </script>
            <?php unset($_SESSION['error_message']); // Delete it after showing it
            ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div id="success-message" class="alert alert-success">
                <strong>Success:</strong> <?php echo htmlspecialchars($_SESSION['success_message']); ?>
            </div>
            <script>
                setTimeout(function() {
                    document.getElementById('success-message').style.display = 'none';
                }, 6000);
            </script>
            <?php unset($_SESSION['success_message']); // Delete it after showing it
            ?>
        <?php endif; ?>



        <div class="table-responsive">
            <!-- table to display the roles -->
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th class="text-nowrap border border-start-3 border-end-0 rounded-start-3 text-center align-middle" scope="col">ID</th>
                        <th class="text-nowrap border border-start-1 border-end-1 text-center align-middle" scope="col">Role-Name</th>
                        <th class="text-nowrap border border-start-1 border-end-1 text-center align-middle" scope="col">Role-Description</th>
                        <th class="text-nowrap border border-start-1 border-end-1 text-center align-middle" scope="col">Created at</th>
                        <th class="text-nowrap border border-start-1 border-end-1 text-center align-middle" scope="col">Updated at</th>
                        <th class="text-nowrap border border-end-3 rounded-end-3 text-center align-middle" scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $rowNumber = 0;

                    foreach ($roles as $role) {

                        $rowNumber++;
                    ?>

                        <tr class="<?php echo get_row_class($rowNumber); ?>">
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?> ">  #<?php echo $role->id_role; ?> </td>
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?> ">   <?php echo $role->role_name; ?> </td>
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?> ">   <?php echo $role->role_description; ?> </td>
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>">   <?php echo $role->created_at; ?> </td>
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>">   <?php echo $role->updated_at; ?> </td>
                            
                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>"> 

                                <div class="btn-group" role="group" aria-label="">

                                    <!-- View Details: VISIBLE PARA TODOS -->
                                    <a href="/roles/gest/view?id=<?php echo $role->id_role; ?>" class="btn btn-sm btn-info text-white">View Details</a>

                                    <?php if ($isAdmin || hasPermission('roles-edit')): ?>
                                        <a href="/roles/gest/edit?id=<?php echo $role->id_role; ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <?php endif; ?>
                                    
                                    <?php if ($isAdmin || hasPermission('roles-delete')): ?>
                                        <a href="/roles/gest/delete?id=<?php echo $role->id_role; ?>" class="btn btn-sm btn-danger">Delete</a>
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