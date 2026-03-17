<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Roles\Controllers
 * 📂 Physical File:   App/roles/controllers/roles_gest_controller.php
 * 
 * 📝 Descripción:
 * Controller for the management of roles and their permissions.
 * Defines what each type of user can do.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Roles\Models\Role (via App/roles/models/role.php)
 * - Arcadia\Database\Connection (via database/connection.php)
 * - Arcadia\Includes\Functions (via includes/functions.php)
 */

require_once __DIR__ . "/../models/role.php";
require_once __DIR__ . "/../../../database/connection.php";
require_once __DIR__ . "/../../../includes/functions.php";
require_once __DIR__ . "/../../../includes/helpers/csrf.php";

DB::createInstance();

class RolesGestController
{
    public function start()
    {
        $roles = Role::check();

        include_once __DIR__ . "/../views/gest/start.php";
    }
    public function create()
    {
        // Check if user is Admin or has roles-create permission
        $isAdmin = isset($_SESSION['user']['role_name']) && $_SESSION['user']['role_name'] === 'Admin';
        if (!$isAdmin && !hasPermission('roles-create')) {
            header('Location: /roles/gest/start?msg=error&error=You do not have permission to create roles');
            exit;
        }

        if ($_POST) {
            // Verify CSRF token
            if (!csrf_verify('role_create')) {
                header('Location: /roles/gest/create?msg=error&error=Invalid request. Please try again.');
                exit;
            }

            // print_r($_POST);
            $role_name = $_POST['role_name'];
            $description = $_POST['role_description'];
            $role_id = Role::create($role_name, $description);
            // print_r("<br>" . $employee_id);
            // redirect to the start page
            header("Location: /roles/gest/start");
            exit();
        }
        include_once __DIR__ . "/../views/gest/create.php";
    }

    public function delete()
    {
        // Check if user is Admin or has roles-delete permission
        $isAdmin = isset($_SESSION['user']['role_name']) && $_SESSION['user']['role_name'] === 'Admin';
        if (!$isAdmin && !hasPermission('roles-delete')) {
            header('Location: /roles/gest/start?msg=error&error=You do not have permission to delete roles');
            exit();
        }

        $id = $_GET['id'];

        // Get result with information
        $result = Role::delete($id);

        // If it is successful: redirect
        if (!$result['success']) {
            // Save the message in the session

            $_SESSION["error_message"] = $result["message"];
        } else {
            $_SESSION["success_message"] = $result["message"];
        }

        header("Location: /roles/gest/start");
        exit();
    }


    public function edit()
    {
        // Check if user is Admin or has roles-edit permission
        $isAdmin = isset($_SESSION['user']['role_name']) && $_SESSION['user']['role_name'] === 'Admin';
        if (!$isAdmin && !hasPermission('roles-edit')) {
            header('Location: /roles/gest/start?msg=error&error=You do not have permission to edit roles');
            exit;
        }

        // we get the ID of the role from the URL. This variable is the only source of truth for the ID.
        $id_role = $_GET["id"];

        // if we receive data by POST, we process the form.
        if ($_POST) {
            // Verify CSRF token
            if (!csrf_verify('role_edit')) {
                header('Location: /roles/gest/edit?id=' . $id_role . '&msg=error&error=Invalid request. Please try again.');
                exit;
            }

            // 1. we update the name and description of the role.
            $role_name = $_POST['role_name'];
            $description = $_POST['role_description'];
            Role::update($id_role, $role_name, $description);

            // 2. we get the list of IDs of the marked permissions.
            // if none is marked, it will be an empty array.
            $permissionIds = $_POST['permissions'] ?? [];

            // 3. we search the Role object to be able to call its synchronization method.
            $role = Role::find($id_role);
            $role->savePermissions($permissionIds);

            // 4. we redirect to the list.
            header("Location: /roles/gest/start");
            exit();
        }

        // if there is no POST, it means we are showing the form.
        // we prepare the data for the view.
        $role = Role::find($id_role);

        require_once __DIR__ . '/../../permissions/models/permission.php';
        $allPermissions = Permission::check();

        $rolePermissionIds = $role->getPermissionIds();

        include_once __DIR__ . "/../views/gest/edit.php";
    }

    public function view()
    {
        // 1. we get the ID of the role from the URL
        $id_role = $_GET['id'];

        // 2. we search the role in the database to have its details (name, description)
        $role = Role::find($id_role);

        // 3. use the new model method to get the list of permissions
        $permissions = Role::getPermissions($id_role);

        // 4. load the details view that we created before
        require_once __DIR__ . '/../views/gest/view.php';
    }
}
