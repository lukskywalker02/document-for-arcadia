<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Employees\Controllers
 * 📂 Physical File:   App/employees/controllers/employees_pages_controller.php
 * 
 * 📝 Description:
 * Controller for public or general views of employees.
 * Currently redirects or shows basic views.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Database\Connection (via database/connection.php)
 * - Arcadia\Employees\Views\Gest\Start (via App/employees/views/gest/start.php)
 */

include_once __DIR__ . "/../../../database/connection.php";

DB::createInstance();

class EmployeesPagesController{
    public function start(){
        // thats not more a test since a few branches before :D
        include_once __DIR__ . "/../employees/gest/start.php";
    }
}

?>