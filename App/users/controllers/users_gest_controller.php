<?php
/**
 * 🏛️ ARQUITECTURA ARCADIA (Código Simulativo Namespace)
 * ----------------------------------------------------
 * 📍 Ubicación Lógica: Arcadia\Users\Controllers
 * 📂 Archivo Físico:   App/users/controllers/users_gest_controller.php
 * 
 * 📝 Descripción:
 * Controlador para la gestión administrativa de usuarios.
 * Implementa lógica de permisos (RBAC) y CRUD.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Users\Models\User (via App/users/models/user.php)
 * - Arcadia\Employees\Models\Employee (via App/employees/models/employee.php)
 * - Arcadia\Roles\Models\Role (via App/roles/models/role.php)
 * - Arcadia\Database\Connection (via database/connection.php)
 * - Arcadia\Includes\Functions (via includes/functions.php)
 * - Arcadia\Includes\Helpers\EmailHelper (via includes/helpers/EmailHelper.php)
 */

require_once __DIR__ . "/../models/user.php";
require_once __DIR__ . "/../../employees/models/employee.php";
require_once __DIR__ . "/../../roles/models/role.php";

// Include the file that has the DB class to be able to connect to the database.
require_once __DIR__ . "/../../../database/connection.php";
require_once __DIR__ . "/../../../includes/functions.php";
// Include the email helper to be able to send emails when a user is created
require_once __DIR__ . "/../../../includes/helpers/EmailHelper.php";
require_once __DIR__ . "/../../../includes/helpers/csrf.php";

DB::createInstance();

class UsersGestController
{
    public function start()
    {

        $users = User::check();

        include_once __DIR__ . "/../views/gest/start.php";
    }


    /**
     * Create a new user
     * @return void
     */
    public function create()
    {
        // Check if the user has permission to create users
        // Only administrators or users with the 'users-create' permission can create users
        $isAdmin = isset($_SESSION['user']['role_name']) && $_SESSION['user']['role_name'] === 'Admin';
        if (!$isAdmin && !hasPermission('users-create')) {
            header('Location: /users/gest/start?msg=error&error=You do not have permission to create users');
            exit;
        }

        // Load available roles and employees to display in the form
        $roles = Role::check();
        $employees = Employee::freeEmployees();

        // If the form was submitted (POST method), process the creation of the user
        if ($_POST) {
            // Verify CSRF token
            if (!csrf_verify('user_create')) {
                header('Location: /users/gest/create?msg=error&error=Invalid request. Please try again.');
                exit;
            }

            // Get the data from the form
            // trim() removes whitespace from the beginning and end of the text
            $username = trim($_POST['username']);
            $password = $_POST['psw'];
            $role = $_POST['role'];
            $employee = $_POST['employee'];

            // Step 1: CHECK FOR DUPLICATES
            // Before creating the user, check if the username already exists in the database
            // This prevents creating duplicate users and possible errors
            if (User::usernameExists($username)) {
                // If the username already exists, redirect with an error message
                // The message will be displayed on the users start page
                header("Location: /users/gest/start?msg=error&error=the username '{$username}' already exists. Please choose another username.");
                exit;
            }

            // Convert empty strings to NULL for employee_id and role_id
            // This is important because in the database, these fields can be NULL
            $role_id = empty($role) ? null : (int)$role;
            $employee_id = empty($employee) ? null : (int)$employee;

            // Step 2: CREATE THE USER IN THE DATABASE
            // If we get here, the username does not exist, so we can create the user
            $user_id = User::create($username, $password, $role_id, $employee_id);

            // Step 3: SEND INFORMATIVE EMAIL
            // According to the TP statement, we must send an email to the user with their username
            // (but NOT the password, which must be delivered in person by the administrator)
            
            // First, determine to which email to send the message:
            $emailToSend = null; // Initialize as null to validate later
            
            // If the user is associated with an employee, use the employee's email
            // The employee's email is more reliable than the username
            if ($employee_id) {
                $employeeData = Employee::find($employee_id);
                if ($employeeData && !empty($employeeData->email)) {
                    $emailToSend = $employeeData->email;
                }
            } else {
                // If there is no employee associated, check if the username is a valid email
                // filter_var() checks if the username has email format
                if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
                    // If the username is a valid email, use it to send the email
                    $emailToSend = $username;
                }
                // If the username is not a valid email, $emailToSend remains null
            }

            // Get the role name to include it in the email
            $roleName = 'Sin rol'; // Default value
            if ($role_id) {
                $roleData = Role::find($role_id);
                if ($roleData) {
                    $roleName = $roleData->role_name;
                }
            }

            // Try to send the email only if we have a valid email
            if ($emailToSend) {
                // The method returns an array with 'success' and 'message' for better error handling
                $emailResult = EmailHelper::sendAccountCreationEmail($emailToSend, $username, $roleName);
                
                // Prepare the redirect message according to the result of the email sending
                if ($emailResult['success']) {
                    // If the email was sent successfully, show success message
                    $redirectMessage = "User created successfully. Email sent to: {$emailToSend}";
                } else {
                    // If the email failed, show a warning message
                    // The user was created, but the email could not be sent
                    $redirectMessage = "User created successfully, but email could not be sent: " . $emailResult['message'];
                    // Also log it for debugging
                    error_log("Email sending failed for user {$username}: " . $emailResult['message']);
                }
            } else {
                // If there is no valid email (no employee nor username as email), inform the admin
                $redirectMessage = "User created successfully, but no email was sent. " . 
                                 ($employee_id ? "Employee has no email configured." : 
                                  "Username '{$username}' is not a valid email address. " .
                                  "To send an email, either associate an employee with an email or use an email as username.");
            }

            // Redirect to the users start page with the appropriate message
            // Determine the type of message according to whether the email was sent or not
            $msgType = 'success'; // Default is success (the user was created)
            if (isset($emailResult) && !$emailResult['success']) {
                // If we tried to send the email but failed, it is a warning
                $msgType = 'warning';
            } elseif (!isset($emailResult)) {
                // If we did not try to send the email (no valid email), it is also a warning
                $msgType = 'warning';
            }
            
            // Use urlencode to ensure that special characters in the message are handled correctly
            header("Location: /users/gest/start?msg={$msgType}&message=" . urlencode($redirectMessage));
            exit;
        }

        // If there is no POST, show the creation form
        include_once __DIR__ . "/../views/gest/create.php";
    }

    /**
     * Delete a user
     * @return void
     */
    public function delete()
    {
        // Check if user has permission to delete users
        $isAdmin = isset($_SESSION['user']['role_name']) && $_SESSION['user']['role_name'] === 'Admin';
        if (!$isAdmin && !hasPermission('users-delete')) {
            header('Location: /users/gest/start?msg=error&error=You do not have permission to delete users');
            exit;
        }

        $id_user = $_GET['id'];
        User::delete($id_user);
        header("Location: /users/gest/start");
        exit();
    }


    /**
     * Toggle the activation status of a user (activate or deactivate)
     * @return void
     */
    public function toggleActivation()
    {
        $id_user = $_GET["id"];
        User::toggleActive($id_user);
        header("Location: /users/gest/start#user-" . $id_user);
        exit();
    }


    /**
     * Edit a user
     * @return void
     */
    public function edit()
    {
        // Check if user has permission to edit users
        $isAdmin = isset($_SESSION['user']['role_name']) && $_SESSION['user']['role_name'] === 'Admin';
        if (!$isAdmin && !hasPermission('users-edit')) {
            header('Location: /users/gest/start?msg=error&error=You do not have permission to edit users');
            exit();
        }

        $roles = Role::check();

        if (isset($_GET['id'])) {
            // We edit an existing user that if it exists with an existing employee
            $id_user = $_GET["id"];
            $user_to_edit = User::find($id_user);


            // Corrected to use our function name
            $employees = Employee::freeEmployees();

            if (isset($user_to_edit->employee_id) && $user_to_edit->employee_id != null) {
                $assigned_employee = Employee::find($user_to_edit->employee_id);
                array_unshift($employees, $assigned_employee);
            }

            // DATA PREPARATION FOR THE VIEW (GET)

            // 1. Load the full permission catalog
            require_once __DIR__ . '/../../permissions/models/permission.php';
            $allPermissions = Permission::check();

            // 2. Get the permissions the user already has from their ROLE
            $rolePermissions = [];
            if ($user_to_edit->role_id) {
                $rolePermissions = Role::getPermissions($user_to_edit->role_id);
            }

            // 3. Create an array with only the ROLE's permission IDs for easy searching
            $rolePermissionIds = array_column($rolePermissions, 'id_permission');

            // 4. FILTER the full catalog to remove those already included in the ROLE
            $availableVipPermissions = array_filter($allPermissions, function ($permission) use ($rolePermissionIds) {
                return !in_array($permission['id_permission'], $rolePermissionIds);
            });

            // 5. Get the IDs of the VIP permissions that the user already has directly assigned
            $userDirectPermissionIds = $user_to_edit->getVipPermissionsIdsUserHasAssigned();
        } elseif (isset($_GET["assign_to_employee"])) {


            $id_employee = $_GET['assign_to_employee'];
            $employee_to_assign = Employee::find($id_employee);

            $unassigned_users = User::withoutEmployeeUser();
        }

        // Logic of the POST for the UPDATE of a user
        if ($_POST && isset($_POST['id'])) {
            // Verify CSRF token
            if (!csrf_verify('user_edit')) {
                header('Location: /users/gest/edit?id=' . $_POST['id'] . '&msg=error&error=Invalid request. Please try again.');
                exit;
            }

            $id_user = $_POST['id'];
            $username = $_POST['username'];
            $pswInput = trim($_POST['psw'] ?? '');

            // 🛡️ PASSWORD UPDATE LOGIC
            // We need to fetch the current user to decide what to do with the password
            $currentUser = User::find($id_user);
            
            if (!empty($pswInput)) {
                // Case 1: Admin typed a NEW password -> We HASH it securely
                $psw = password_hash($pswInput, PASSWORD_DEFAULT);
            } else {
                // Case 2: Admin left the field empty -> We keep the EXISTING password (hash or plain)
                $psw = $currentUser->psw;
            }

            // Clean up role_id and employee_id before sending them to the model.
            // An empty string '' from the form is converted to NULL for the database. This is the definitive fix.
            $role_id = empty($_POST['role']) ? null : (int)$_POST['role'];
            $employee_id = empty($_POST['employee']) ? null : (int)$_POST['employee'];

            User::update($username, $psw, $role_id, $employee_id, $id_user);

            // Sincronize VIP Permissions

            // 1. Get the IDs of the marked checkboxes. If none is marked, it will be an empty array.
            $permissionIds = $_POST['permissions'] ?? [];

            // 2. We need the User object to call its method.
            $user = User::find($id_user);

            // 3. Ask the object to synchronize its VIP permissions.
            $user->overwriteVipPermissionsIdsUserHasAssigned($permissionIds);

            // Final Redirect
            header("Location: /users/gest/start#user-" . $id_user);
            exit();
        }



        include_once __DIR__ . "/../views/gest/edit.php";
    }


    /**
     * Assign an account to an employee
     * @return void
     */
    public function assignAccount()
    {
        if ($_POST) {
            // Verify CSRF token
            if (!csrf_verify('user_assign')) {
                header('Location: /users/gest/start?msg=error&error=Invalid request. Please try again.');
                exit;
            }

            $employee_id = $_POST['employee_id'];
            $user_id = $_POST['user_id'];

            // Assign the user to the employee in the database
            // This method updates the users table to link the user_id with the employee_id
            User::assignAccount($employee_id, $user_id);

            // Step 2: SEND INFORMATIVE EMAIL TO THE EMPLOYEE
            // When a user is assigned to an employee, we must notify them by email
            // This is important because the employee needs to know that they have a created account
            
            // Get the user data to know their username and role
            $user = User::find($user_id);
            
            // Get the employee data to know their email
            $employeeData = Employee::find($employee_id);
            
            // Check if the employee has an email before trying to send
            if ($employeeData && !empty($employeeData->email)) {
                // Get the role name of the user
                $roleName = 'Sin rol'; // Default value
                if ($user->role_id) {
                    $roleData = Role::find($user->role_id);
                    if ($roleData) {
                        $roleName = $roleData->role_name;
                    }
                }

                // Send the email to the employee with their username and role
                // The email informs that an account has been assigned to them
                $emailResult = EmailHelper::sendAccountCreationEmail(
                    $employeeData->email,  // Employee's email (from human resources)
                    $user->username,       // Username assigned to them
                    $roleName              // Role assigned
                );
                
                // If the email could not be sent, log it but do not block the assignment
                if (!$emailResult['success']) {
                    error_log("Could not send the email of account assignment for user ID: {$user_id}, employee ID: {$employee_id}. Error: " . $emailResult['message']);
                }
            }

            // Redirect to the users start page
            // If the email was sent, the success message will indicate it
            header("Location: /users/gest/start?msg=success&message=Account assigned to employee successfully" . 
                   (isset($employeeData->email) ? ". Email sent to: {$employeeData->email}" : ""));
            exit();
        }
    }


    /**
     * View a user
     * @return void
     */
    public function view()
    {
        // Get the ID of the user from the URL
        $id_user = $_GET['id'];

        // Find the user
        $user = User::find($id_user);

        // Get the user's role (if they have one)
        $role = $user->getRole();
        $rolePermissions = [];
        if ($role) {
            // If they have a role, get the permissions for that role
            $rolePermissions = Role::getPermissions($role->id_role);
        }

        // Get the user's VIP (direct) permissions
        $permissions = User::getUserVipPermissionsDetails($id_user);

        // var_dump($user);
        // die();
        // Load the view with all the information
        require_once __DIR__ . '/../views/gest/view.php';
    }
}
