<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Roles\Models
 * 📂 Physical File:   App/roles/models/role.php
 * 
 * 📝 Description:
 * Model that defines the security roles (RBAC).
 * Manages the assignment of permissions to user groups.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Database\Connection (via database/connection.php)
 * 
 */

require_once __DIR__ . '/../../../database/connection.php';


class Role
{

    // attributes that the role will have when creating it from this template instantiating it
    public $id_role;
    public $role_name;
    public $role_description;
    public $created_at;
    public $updated_at;

    // constructor of the role class, that points with this to the same attributes of the class without ($)
    public function __construct($id_role, $role_name, $role_description, $created_at, $updated_at)
    {
        $this->id_role = $id_role;
        $this->role_name = $role_name;
        $this->role_description = $role_description;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    // Method to get all the roles from the database
    public static function check()
    {


        // create an empty array to store the roles
        $rolesList = [];

        // instantiate the connection to the database, since if we don't do it, we won't be able to access the database to recover anything
        $connectionDB = DB::createInstance();

        // create the query to the database, that will return all the roles from the database
        $sql = $connectionDB->query("SELECT * FROM roles");

        // iterate through the roles obtained from the database, and save them in the $rolesList array, we have to store them somewhere right?
        // for each iteration of the query, a new Role object is created and added to the $rolesList array
        foreach ($sql->fetchAll() as $role) {

            // save the roles from the database in this array to be able to show them in the controller
            $rolesList[] = new Role($role["id_role"], $role["role_name"], $role["role_description"], $role["created_at"], $role["updated_at"]);
        }

        // return the array of roles
        return $rolesList;
    }

    // Method to create a new role in the database
    public static function create($role_name, $role_description)
    {
        // instantiate the connection to the database
        $connectionDB = DB::createInstance();

        // create the query to the database
        $query = "INSERT INTO roles (role_name, role_description) VALUES (?, ?)";

        // prepare the connection to the database for the query
        $sql = $connectionDB->prepare($query);

        // execute the query already prepared previously
        $sql->execute([$role_name, $role_description]);

        // return the id of the role created
        return $connectionDB->lastInsertId();
    }

    private static function getRole($id_role)
    {
        $connectionDB = DB::createInstance();

        $query = "SELECT 
                r.role_name,
                (SELECT count(*) FROM users u WHERE u.role_id = r.id_role)
                as employeesHasRoles
                FROM 
                roles r
                WHERE 
                r.id_role = ?";

        $sql = $connectionDB->prepare($query);
        $sql->execute([$id_role]);

        $result = $sql->fetch();

        return $result;
    }


    public static function delete($id_role)
    {

        // instantiate the connection to the database
        $connectionDB = DB::createInstance();

        $usersCount = self::getRole($id_role);


        if ($usersCount && $usersCount["employeesHasRoles"] > 0) {
            return [
                'success' => false,
                'message' => "No se puede borrar: {$usersCount['employeesHasRoles']} colaborador/es tienen el rol de {$usersCount['role_name']}"
            ]; // Returns array with INFORMATION
        } else {
            // create the query to the database
            $query = "DELETE FROM roles WHERE id_role = ?";

            // prepare the connection to the database for the query
            $sql = $connectionDB->prepare($query);

            // execute the query already prepared previously
            $sql->execute([$id_role]);

            return [
                'success' => true,
                'message' => "Rol de {$usersCount['role_name']} eliminado correctamente por que hay 0 colaborador/es con ese rol"
            ];
        }
    }



    public static function find($id_role)
    {
        // instantiate the connection to the database
        $connectionDB = DB::createInstance();

        // create the query to the database
        $query = "SELECT * FROM roles WHERE id_role = ?";

        // prepare the connection to the database for the query
        $sql = $connectionDB->prepare($query);

        // execute the query already prepared previously
        $sql->execute([$id_role]);

        // save the first result of the query in a variable
        $role = $sql->fetch();

        // If no role found, return null
        if (!$role) {
            return null;
        }

        // return the result of the query
        return new Role($role["id_role"], $role["role_name"], $role["role_description"], $role["created_at"], $role["updated_at"]);
    }


    public static function update($id_role, $role_name, $role_description)
    {
        // instantiate the connection to the database
        $connectionDB = DB::createInstance();

        // create the query to the database
        $query = "UPDATE roles SET role_name = ?, role_description = ?, updated_at = NOW() WHERE id_role = ?";

        // prepare the connection to the database for the query
        $sql = $connectionDB->prepare($query);

        // execute the query already prepared previously
        $sql->execute([$role_name, $role_description, $id_role]);
    }


    /**
     * Returns a simple array with the IDs of the permissions assigned to this role.
     * @return array
     */
    public function getPermissionIds()
    {
        $connectionDB = DB::createInstance();
        $query = "SELECT permission_id 
                  FROM roles_permissions 
                  WHERE role_id = ?";

        $sql = $connectionDB->prepare($query);

        $sql->execute([$this->id_role]);

        
        return $sql->fetchAll(PDO::FETCH_COLUMN);
    }



    public static function getPermissions($id_role)
    {
        $connectionDB = DB::createInstance();

        $query = "SELECT p.id_permission, p.permission_name, p.permission_desc
                  FROM permissions p 
                  JOIN roles_permissions rp 
                  ON p.id_permission = rp.permission_id 
                  WHERE rp.role_id = ?
                  ORDER BY p.permission_name ASC";

        $sql = $connectionDB->prepare($query);
        $sql->execute([$id_role]);

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function savePermissions(array $permissionIds)
    {
        $connectionDB = DB::createInstance();

        //  we start a transaction. This is like saying: "If everything goes well... well done, if not... nothing happens" (with native pdo beginTransaction method).
        $connectionDB->beginTransaction();

        try {
            // --- STEP 1: DELETE OLD PERMISSIONS ---
            // We prepare a query to delete all rows in the pivot table
            // that belong to THIS role.
            $deleteSql = $connectionDB->prepare("DELETE FROM roles_permissions WHERE role_id = ?");
            $deleteSql->execute([$this->id_role]);

            // --- STEP 2: INSERT NEW PERMISSIONS ---
            // We only try to insert if we have permissions.
            if (!empty($permissionIds)) {
                // We prepare the insertion query. It will be the same for all.
                $insertSql = $connectionDB->prepare("INSERT INTO roles_permissions (role_id, permission_id) VALUES (?, ?)");

                //  we iterate through the list of IDs that the controller has passed to us.
                foreach ($permissionIds as $permissionId) {
                    // For each ID, we execute the insertion query.
                    $insertSql->execute([$this->id_role, $permissionId]);
                }
            }

            // if we have reached here without errors, everything has gone well!
            // we make the changes permanent (with native pdo commit method).
            $connectionDB->commit();
            return true;

        } catch (Exception $e) {
            // ¡UPS! Something has failed (the database crashed, a query was wrong...).
            // We roll back ALL the changes we made from the beginTransaction.
            $connectionDB->rollBack();
            // Optional: we can save the error in a log to debug (with native error_log method).
            error_log($e->getMessage());
            return false;
        }
    }
    
    
}
