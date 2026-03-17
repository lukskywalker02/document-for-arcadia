<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Permissions\Models
 * 📂 Physical File:   App/permissions/models/permission.php
 * 
 * 📝 Description:
 * Model that manages permissions (RBAC).
 * Defines the granular capabilities that can be assigned.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Database\Connection (via database/connection.php)
 */

// Defines the Permission class to interact with the database.

require_once __DIR__ . '/../../../database/connection.php';


class Permission {
    // This is our QUERY (Query) to read data

    // Attributes that the permission will have when creating it from this template instantiating it
    public $id;
    public $permission_name;
    public $permission_desc;
    public $created_at;
    public $updated_at;

    // Constructor of the Permission class, that points with this to the same attributes of the class without ($)
    public function __construct($id, $permission_name, $permission_desc, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->permission_name = $permission_name;
        $this->permission_desc = $permission_desc;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    // method to get all the permissions from the database
    public static function check()
    {
        // Create an instance of the database connection
        $connectionDB = DB::createInstance();

        // Create the query to the database, that will return all the permissions
        $query = "SELECT * FROM permissions ORDER BY permission_name ASC";
                
        // Execute the query to the database
        $sql = $connectionDB->prepare($query);

        // Execute the query already prepared previously
        $sql->execute();

        
        // Return all the results as an associative array
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}
