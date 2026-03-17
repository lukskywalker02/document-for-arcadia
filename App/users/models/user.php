<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Users\Models
 * 📂 Physical File:   App/users/models/user.php
 * 
 * 📝 Description:
 * Model that represents a user of the system (Login).
 * Manages authentication, roles and relationship with employees.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Database\Connection (via database/connection.php)
 * - Arcadia\Roles\Models\Role (via App/roles/models/role.php)
 */

require_once __DIR__ . '/../../../database/connection.php';
require_once __DIR__ . '/../../roles/models/role.php';

class User
{

    // Attributes the user will have when instantiated from this class
    public $id;
    public $username;
    public $psw;
    public $role_id;
    public $role_name;
    public $employee_id;
    public $employee_last_name;
    public $employee_email;
    public $is_active;
    public $created_at;
    public $updated_at;

    // Constructor for the User class.
    public function __construct($id_user, $username, $psw, $role_id, $role_name, $employee_id, $last_name, $employee_email, $is_active, $created_at, $updated_at)
    {
        $this->id = $id_user;
        $this->username = $username;
        $this->psw = $psw;
        $this->role_id = $role_id;
        $this->role_name = $role_name;
        $this->employee_id = $employee_id;
        $this->employee_last_name = $last_name;
        $this->employee_email = $employee_email;
        $this->is_active = $is_active;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    // Method to get all users from the database.
    public static function check()
    {
        // Create an empty array to store the users.
        $usersList = [];

        // Instantiate the database connection.
        $connectionDB = DB::createInstance();

        // Create the query to the DB, which will return all users.
        $sql = $connectionDB->query("SELECT e.last_name, e.email AS employee_email, e.id_employee, 
                                            u.id_user, u.username, u.psw, u.is_active, u.created_at, u.updated_at, u.role_id,
                                            r.role_name
                                     FROM employees e
                                     LEFT JOIN users u ON u.employee_id = e.id_employee
                                     LEFT JOIN roles r ON u.role_id = r.id_role

                                     -- Employees with or without users
                                     
                                     UNION
                                     
                                     -- Users without employees
                                     SELECT NULL as last_name, NULL as employee_email, NULL as id_employee, 
                                            u.id_user, u.username, u.psw, u.is_active, u.created_at, u.updated_at, u.role_id,
                                            r.role_name
                                     FROM users u
                                     LEFT JOIN roles r ON u.role_id = r.id_role
                                     WHERE u.employee_id IS NULL
                                     
                                     ORDER BY id_employee, id_user");

        // Iterate through the users obtained from the DB and store them in the $usersList array.
        // For each query result, a new User object is created and added to the $usersList array.
        foreach ($sql->fetchAll() as $user) {

            // We store the users from the DB in this array to be able to display them in the controller.
            $usersList[] = new User($user["id_user"], $user["username"], $user["psw"], $user["role_id"], $user["role_name"], $user["id_employee"], $user["last_name"], $user["employee_email"], $user["is_active"], $user["created_at"], $user["updated_at"]);
        }

        // Return the array of users.
        return $usersList;
    }

    /**
     * Find a user by ID
     * @param int $id_user The ID of the user
     * @return object|null The user object if found, null otherwise
     */
    public static function find($id_user)
    {
        // Instantiate the database connection.
        $connectionDB = DB::createInstance();

        // Create the query to the DB.
        $query = "SELECT u.*, e.id_employee, e.last_name, e.email AS employee_email, r.role_name, r.id_role
                  FROM users u
                  LEFT JOIN employees e 
                  ON e.id_employee = u.employee_id
                  LEFT JOIN roles r ON r.id_role = u.role_id
                  WHERE u.id_user = ?";

        // Prepare the DB connection for the query.
        $sql = $connectionDB->prepare($query);

        // Execute the previously prepared query.
        $sql->execute([$id_user]);

        // Store the first result of the query in a variable.
        $user = $sql->fetch();

        // Check if user was found before creating the object
        if (!$user) {
            return null;
        }

        // Return the query result.
        return new User($user["id_user"], $user["username"], $user["psw"], $user["role_id"], $user["role_name"], $user["employee_id"], $user["last_name"], $user["employee_email"], $user["is_active"], $user["created_at"], $user["updated_at"]);
    }

    /**
     * Check if a username already exists in the database
     * 
     * This method is important to avoid creating duplicate users.
     * Before creating a new user, we must check that the username
     * (which can be an email) is not already registered in the users table.
     * 
     * @param string $username The username to check (can be an email)
     * @return bool true if the username already exists, false if it is available
     */
    public static function usernameExists($username)
    {
        // Instantiate the database connection.
        $connectionDB = DB::createInstance();

        // Create the query to the DB.
        $query = "SELECT COUNT(*) as count FROM users WHERE username = ? LIMIT 1";

        // Prepare the DB connection for the query.
        $sql = $connectionDB->prepare($query);

        // Execute the previously prepared query.
        $sql->execute([$username]);

        // Store the first result of the query in a variable.
        $result = $sql->fetch(PDO::FETCH_ASSOC);

        // If count is greater than 0, it means that the username already exists
        // Return true if it exists, false if it does not exist
        return (int)$result['count'] > 0;
    }
    
    /**
     * Create a new user in the DB
     * @param string $username The username of the user
     * @param string $psw The password of the user
     * @param int|null $role_id The ID of the role
     * @param int|null $employee_id The ID of the employee
     * @return int The ID of the created user
     */
    public static function create($username, $psw, $role_id, $employee_id)
    {
        $connectionDB = DB::createInstance();

        
        $query = "INSERT INTO users (username, psw, role_id, employee_id) VALUES (?, ?, ?, ?)";
        $sql = $connectionDB->prepare($query);
        $sql->execute([$username, $psw, $role_id, $employee_id]);

        return $connectionDB->lastInsertId();
    }

    
    /**
     * Delete a user from the DB
     * @param int $id_user The ID of the user
     * @return bool true if the user was deleted successfully, false otherwise
     */
    public static function delete($id_user)
    {
        // Instantiate the database connection.
        $connectionDB = DB::createInstance();

        // Create the query to the DB.
        $query = "DELETE FROM users WHERE id_user = ?";

        // Prepare the DB connection for the query.
        $sql = $connectionDB->prepare($query);

        // Execute the previously prepared query.
       return $sql->execute([$id_user]);
    }

    /**
     * Toggle the active status of a user
     * @param int $id_user The ID of the user
     * @return bool true if the active status was toggled successfully, false otherwise
     */
    public static function toggleActive($id_user) {
        
        $connectionDB = DB::createInstance();

        $query = "UPDATE users 
                  SET is_active = NOT is_active, 
                  updated_at = NOW() 
                  WHERE id_user = ?";

        $sql = $connectionDB->prepare($query);
        return $sql->execute([$id_user]);
                 
    }


    /**
     * Get all users without an employee
     * @return array Array of users without an employee like [{id_user: 1, username: 'user1'}, ...]
     */
    public static function withoutEmployeeUser()
    {

        $usersList = [];
        
        // Instantiate the database connection.
        $connectionDB = DB::createInstance();

        // Create the query to the DB.
        $query = "SELECT u.id_user, u.username
                  FROM users u
                  LEFT JOIN employees e ON u.employee_id = e.id_employee
                  WHERE e.id_employee IS NULL";

        // Prepare the DB connection for the query.
        $sql = $connectionDB->prepare($query);

        // Execute the previously prepared query.
        $sql->execute();

        // Store the first result of the query in a variable.
        return $sql->fetchAll(PDO::FETCH_OBJ);

    }

    /**
     * Update a user in the DB
     * @param string $username The username of the user
     * @param string $psw The password of the user
     * @param int|null $role_id The ID of the role
     * @param int|null $employee_id The ID of the employee
     * @param int $id_user The ID of the user
     * @return bool true if the user was updated successfully, false otherwise
     */
    public static function update($username, $psw, $role_id, $employee_id, $id_user)
    {
        // Instantiate the database connection.
        $connectionDB = DB::createInstance();

        // Create the query to the DB.
        $query = "UPDATE users SET username = ?, psw = ?, role_id = ?, employee_id = ?, updated_at = NOW() WHERE id_user = ?";

        // Prepare the DB connection for the query.
        $sql = $connectionDB->prepare($query);

        // Execute the previously prepared query and return the result.
        return $sql->execute([$username, $psw, $role_id, $employee_id, $id_user]);
    }

    /**
     * Assign an account to an employee
     * @param int $employee_id The ID of the employee
     * @param int $user_id The ID of the user
     * @return bool true if the account was assigned successfully, false otherwise
     */
    public static function assignAccount($employee_id, $user_id) {
        $connectionDB = DB::createInstance();

        $query = "UPDATE users SET employee_id = ? WHERE id_user = ?";
        $sql = $connectionDB->prepare($query);
        return $sql->execute([$employee_id, $user_id]);

    }

    /**
     * Get the role of the user
     * @return object|null The role object if found, null otherwise
     */
    public function getRole()
    {
        if ($this->role_id) {
            return Role::find($this->role_id);
        }
        return null;
    }

    /**
     * Get the details of the VIP permissions assigned to the user
     * @param int $id_user The ID of the user
     * @return array Array of permission details like [{id_permission: 1, permission_name: 'permission1', permission_desc: 'description1'}, ...]
     */
    public static function getUserVipPermissionsDetails($id_user)
    {
        $connectionDB = DB::createInstance();
        $query = "SELECT p.id_permission, p.permission_name, p.permission_desc
                  FROM permissions p 
                  JOIN users_permissions up ON p.id_permission = up.permission_id 
                  WHERE up.user_id = ?
                  ORDER BY p.permission_name ASC";
        $sql = $connectionDB->prepare($query);
        $sql->execute([$id_user]);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get the IDs of the VIP permissions assigned to the user
     * @return array Array of permission IDs like [1, 2, 3]
     */
    public function getVipPermissionsIdsUserHasAssigned()
    {
        $connectionDB = DB::createInstance();


        $query = "SELECT permission_id FROM users_permissions WHERE user_id = ?";
        $sql = $connectionDB->prepare($query);
        $sql->execute([$this->id]);
        return $sql->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Overwrite the VIP permissions for a user
     * @param array $permissionIds The IDs of the permissions to assign to the user
     * @return bool true if the permissions were overwritten successfully, false otherwise
     */
    public function overwriteVipPermissionsIdsUserHasAssigned(array $permissionIds)
    {
        $connectionDB = DB::createInstance();
        $connectionDB->beginTransaction();

        try {
            // Step 1: Delete all old VIP permissions for this user.
            $deleteQuery = "DELETE FROM users_permissions WHERE user_id = ?";
            $deleteSql = $connectionDB->prepare($deleteQuery);
            $deleteSql->execute([$this->id]);

            // Step 2: Insert the new permissions, if any were selected.
            if (!empty($permissionIds)) {
                $insertQuery = "INSERT INTO users_permissions (user_id, permission_id) VALUES (?, ?)";
                $insertSql = $connectionDB->prepare($insertQuery);

                foreach ($permissionIds as $permissionId) {
                    $insertSql->execute([$this->id, $permissionId]);
                }
            }

            // If everything went well, we commit the changes.
            $connectionDB->commit();
            return true;

        } catch (Exception $e) {
            // If something fails, we roll back everything.
            $connectionDB->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Get all permissions for a user (role permissions + VIP permissions)
     * Returns a simple array of permission names (strings)
     * @param int $userId The user ID
     * @return array Array of permission names like ['users-view', 'animals-create', ...]
     */
    public static function getAllUserPermissions($userId)
    {
        $connectionDB = DB::createInstance();
        $permissions = [];

        // Get permissions from role
        $roleQuery = "SELECT p.permission_name
                      FROM permissions p
                      JOIN roles_permissions rp ON p.id_permission = rp.permission_id
                      JOIN users u ON rp.role_id = u.role_id
                      WHERE u.id_user = ?";
        $roleSql = $connectionDB->prepare($roleQuery);
        $roleSql->execute([$userId]);
        $rolePermissions = $roleSql->fetchAll(PDO::FETCH_COLUMN);
        
        // Get VIP permissions (direct user permissions)
        $vipQuery = "SELECT p.permission_name
                     FROM permissions p
                     JOIN users_permissions up ON p.id_permission = up.permission_id
                     WHERE up.user_id = ?";
        $vipSql = $connectionDB->prepare($vipQuery);
        $vipSql->execute([$userId]);
        $vipPermissions = $vipSql->fetchAll(PDO::FETCH_COLUMN);

        // Combine both arrays and remove duplicates
        $permissions = array_unique(array_merge($rolePermissions, $vipPermissions));

        return array_values($permissions); // Re-index array
    }

    /**
     * Get the last user created or modified
     * @return object|false
     */
    public static function getLast() {
        $connectionDB = DB::createInstance();
        $sql = $connectionDB->query("SELECT e.last_name, e.email AS employee_email, e.id_employee, 
                                            u.id_user, u.username, u.psw, u.is_active, u.created_at, u.updated_at, u.role_id,
                                            r.role_name
                                     FROM users u
                                     LEFT JOIN employees e ON u.employee_id = e.id_employee
                                     LEFT JOIN roles r ON u.role_id = r.id_role
                                     ORDER BY COALESCE(u.updated_at, u.created_at) DESC, u.id_user DESC
                                     LIMIT 1");
        $user = $sql->fetch();
        if ($user) {
            return new User($user["id_user"], $user["username"], $user["psw"], $user["role_id"], $user["role_name"], $user["id_employee"], $user["last_name"], $user["employee_email"], $user["is_active"], $user["created_at"], $user["updated_at"]);
        }
        return false;
    }

}
