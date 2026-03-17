<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Users\Controllers
 * 📂 Physical File:   App/users/controllers/users_pages_controller.php
 * 
 * 📝 Description:
 * Controller for general pages of users.
 * Manages redirects and error views related to users.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Database\Connection (via database/connection.php)
 */

include_once __DIR__ . "/../../../database/connection.php";

DB::createInstance();

class UsersPagesController{
    public function start(){
        include_once __DIR__ . "/../views/pages/start.php";
    }
    public function error(){
        include_once __DIR__ . "/../views/pages/error.php";

    }

}

?>