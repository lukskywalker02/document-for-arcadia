<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Roles\Controllers
 * 📂 Physical File:   App/roles/controllers/roles_pages_controller.php
 * 
 * 📝 Description:
 * Controller for general pages of roles.
 * Manages redirects and error views related to roles.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Database\Connection (via database/connection.php)
 */

include_once __DIR__ . "/../../../database/connection.php";

DB::createInstance();

class RolesPagesController{
    public function start(){
        include_once __DIR__ . "/../views/pages/start.php";
    }
    public function error(){
        include_once __DIR__ . "/../views/pages/error.php";

    }

}

?>