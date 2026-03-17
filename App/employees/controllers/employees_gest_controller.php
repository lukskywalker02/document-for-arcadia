<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Employees\Controllers
 * 📂 Physical File:   App/employees/controllers/employees_gest_controller.php
 * 
 * 📝 Description:
 * Controller for the administrative management of employees.
 * Manages the CRUD of employees in the administration area.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Employees\Models\Employee (via App/employees/models/employee.php)
 * - Arcadia\Roles\Models\Role (via App/roles/models/role.php)
 * - Arcadia\Database\Connection (via database/connection.php)
 * - Arcadia\Employees\Views\Gest\Start (via App/employees/views/gest/start.php)
 * - Arcadia\Employees\Views\Gest\Create (via App/employees/views/gest/create.php)
 * - Arcadia\Employees\Views\Gest\Edit (via App/employees/views/gest/edit.php)
 */

require_once __DIR__ . "/../models/employee.php";

require_once __DIR__ . "/../../roles/models/role.php";

require_once __DIR__ . "/../../../database/connection.php";
require_once __DIR__ . "/../../../includes/helpers/csrf.php";

DB::createInstance();

class EmployeesGestController
{

    // method to display the start page, showing all the employees
    public function start()
    {

        // Get all the employees from model Employee, thanks to the method check()
        $employees = Employee::check();

        // Include the view to display the start page
        include_once __DIR__ . "/../views/gest/start.php";
    }


    // method to display the create page, to create a new employee
    public function create()
    {

        // Define the genders and marital status options
        $genders = ["male", "female"];
        $marital_status = ["Single", "Married", "Divorced", "Widowed"];

        // Get all the roles from model Role, thanks to the method check(), and thanks to bringing "require_once __DIR__ . "/../../roles/models/role.php";" we can use the Role class
        $roles = Role::check();

        // If the form is submitted (in create.php form), create a new employee
        if ($_POST) {
            // Verify CSRF token
            if (!csrf_verify('employee_create')) {
                header('Location: /employees/gest/create?msg=error&error=Invalid request. Please try again.');
                exit;
            }

            $first_name = $_POST['firstname'];
            $last_name = $_POST['lastname'];
            $birthdate = $_POST['birthdate'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $zip_code = $_POST['zip_code'];
            $country = $_POST['country'];
            $gender = $_POST['gender'];
            $marital_status = $_POST['marital_status'];

            // Create the new employee in the database
            $employee_id = Employee::create($first_name, $last_name, $birthdate, $phone, $email, $address, $city, $zip_code, $country, $gender, $marital_status);
            
            // Redirect to the start page
            header("Location: /employees/gest/start");
            exit();
        }

        // Include the view to display the create page
        include_once __DIR__ . "/../views/gest/create.php";
    }

    // method to display the delete page, to delete an employee from the database
    public function delete()
    {
        // Get the ID of the employee from the URL (thanks to the GET method)
        $id_employee = $_GET["id"];

        // Delete the employee from the database, thanks to the method delete( from the Employee model)
        Employee::delete($id_employee);

        // Redirect to the start page
        header("Location: /employees/gest/start");
        exit();
    }


    // method to display the edit page, to edit an employee from the database
    public function edit()
    {

        // Define the genders and marital status options
        $genders = ["male", "female"];
        $marital_status = ["single", "married", "divorced", "widowed"];

        // Get the ID of the employee from the URL (thanks to the GET method)
        $id_employee = $_GET["id"];

        // Find the employee from the database, thanks to the method find (from the Employee model)
        $employee = Employee::find($id_employee);


        // Get all the roles from model Role, thanks to the method check(), and thanks to bringing "require_once __DIR__ . "/../../roles/models/role.php";" we can use the Role class
        $roles = Role::check();

        // If the form is submitted (in edit.php form), update the employee
        if ($_POST) {
            // Verify CSRF token
            if (!csrf_verify('employee_edit')) {
                $id = $_POST['id'] ?? '';
                header('Location: /employees/gest/edit?id=' . $id . '&msg=error&error=Invalid request. Please try again.');
                exit;
            }

            // Get the data from the form
            $id_employee = $_POST['id'];
            $first_name = $_POST['firstname'];
            $last_name = $_POST['lastname'];
            $birthdate = $_POST['birthdate'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $zip_code = $_POST['zip_code'];
            $country = $_POST['country'];
            $gender = $_POST['gender'];
            $marital_status = $_POST['marital_status'];

            // Update the employee in the database, thanks to the method update( from the Employee model)
            $employee_id = Employee::update($id_employee, $first_name, $last_name, $birthdate, $phone, $email, $address, $city, $zip_code, $country, $gender, $marital_status);
            
            // Redirect to the start page
            header("Location: /employees/gest/start");
            exit();
        }


        // Include the view to display the edit page
        include_once __DIR__ . "/../views/gest/edit.php";
    }
}
