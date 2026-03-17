<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Employees\Models
 * 📂 Physical File:   App/employees/models/employee.php
 * 
 * 📝 Description:
 * Model that manages the employee data.
 * Manages the personal and labor information of the staff.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Database\Connection (via database/connection.php)
 */

class Employee
{

    // attributes that the employee will have when creating it from this template instantiating it
    public $id;
    public $first_name;
    public $last_name;
    public $birthdate;
    public $phone;
    public $email;
    public $address;
    public $city;
    public $zip_code;
    public $country;
    public $gender;
    public $marital_status;
    public $role_name;
    public $created_at;
    public $updated_at;

    // constructor of the employee class, that points with this to the same attributes of the class without ($)
    public function __construct($id_employee, $first_name, $last_name, $birthdate, $phone, $email, $address, $city, $zip_code, $country, $gender, $marital_status, $r_role_name, $created_at, $updated_at)
    {
        $this->id = $id_employee;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->birthdate = $birthdate;
        $this->phone = $phone;
        $this->email = $email;
        $this->address = $address;
        $this->city = $city;
        $this->zip_code = $zip_code;
        $this->country = $country;
        $this->gender = $gender;
        $this->marital_status = $marital_status;
        $this->role_name = $r_role_name;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    // method to get all the employees from the database
    public static function check()
    {
        // create an empty array to store the employees
        $employeesList = [];

        // instantiate the connection to the database, since if we don't do it, we won't be able to access the database to recover anything
        $connectionDB = DB::createInstance();

        // create the query to the database, that will return all the employees of the database
        $sql = $connectionDB->query("SELECT e.*, r.role_name, r.id_role
                                     FROM employees e
                                     LEFT JOIN users u 
                                     ON u.employee_id = e.id_employee 
                                     LEFT JOIN roles r ON r.id_role = u.role_id");

        // iterate through the employees obtained from the database, and store them in the $employeesList array
        // for each query iteration, a new Employee object is created and added to the $employeesList array
        foreach ($sql->fetchAll() as $employee) {

            // store the employees of the database in this array to be able to display them in the controller
            $employeesList[] = new Employee($employee["id_employee"], $employee["first_name"], $employee["last_name"], $employee["birthdate"], $employee["phone"], $employee["email"], $employee["address"], $employee["city"], $employee["zip_code"], $employee["country"], $employee["gender"], $employee["marital_status"], $employee["role_name"], $employee["created_at"], $employee["updated_at"]);
        }

        // return the array of employees
        return $employeesList;
    }

    // method to create a new employee in the database
    public static function create($first_name, $last_name, $birthdate, $phone, $email, $address, $city, $zip_code, $country, $gender, $marital_status)
    {
        // instantiate the connection to the database
        $connectionDB = DB::createInstance();

        // create the query to the database
        $query = "INSERT INTO employees (first_name, last_name, birthdate, phone, email, address, city, zip_code, country, gender, marital_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // prepare the connection to the database
        $sql = $connectionDB->prepare($query);

        // execute the query already prepared previously
        $sql->execute([$first_name, $last_name, $birthdate, $phone, $email, $address, $city, $zip_code, $country, $gender, $marital_status]);

        // return the id of the created employee
        return $connectionDB->lastInsertId();
    }


    // method to delete an employee from the database
    public static function delete($id_employee)
    {
        // instantiate the connection to the database
        $connectionDB = DB::createInstance();


        // create the query to the database
        $query = "DELETE FROM employees WHERE id_employee = ?";

        // prepare the connection to the database
        $sql = $connectionDB->prepare($query);

        // execute the query already prepared previously
        $sql->execute([$id_employee]);
    }


    // method to find an employee from the database
    public static function find($id_employee)
    {
        // instantiate the connection to the database
        $connectionDB = DB::createInstance();

        // create the query to the database
        $query = "SELECT e.*, r.role_name, r.id_role
                    FROM employees e
                    LEFT JOIN users u 
                    ON u.employee_id = e.id_employee 
                    LEFT JOIN roles r ON r.id_role = u.role_id
                    WHERE e.id_employee = ?";

        // prepare the connection to the database
        $sql = $connectionDB->prepare($query);

        // execute the query already prepared previously
        $sql->execute([$id_employee]);

        // store the first result of the query in a variable
        $employee = $sql->fetch();

        // return the result of the query
        return new Employee($employee["id_employee"], $employee["first_name"], $employee["last_name"], $employee["birthdate"], $employee["phone"], $employee["email"], $employee["address"], $employee["city"], $employee["zip_code"], $employee["country"], $employee["gender"], $employee["marital_status"], $employee["role_name"], $employee["created_at"], $employee["updated_at"]);
    }

    // method to get all the employees without users from the database
    public static function freeEmployees()
    {
        // create an empty array to store the employees without users
        $employeesList = [];
        
        // instantiate the connection to the database
        $connectionDB = DB::createInstance();

        // create the query to the database
        $query = "SELECT e.id_employee, e.last_name
                  FROM employees e
                  LEFT JOIN users u ON e.id_employee = u.employee_id
                  WHERE u.employee_id IS NULL";

        // prepare the connection to the database
        $sql = $connectionDB->prepare($query);

        // execute the query already prepared previously
        $sql->execute();

        // store the first result of the query in a variable
        return $sql->fetchAll(PDO::FETCH_OBJ);

    }


    // method to update an employee from the database
    public static function update($id_employee, $first_name, $last_name, $birthdate, $phone, $email, $address, $city, $zip_code, $country, $gender, $marital_status)
    {
        // instantiate the connection to the database
        $connectionDB = DB::createInstance();

        // create the query to the database
        $query = "UPDATE employees SET first_name = ?, last_name = ?, birthdate = ?, phone = ?, email = ?, address = ?, city = ?, zip_code = ?, country = ?, gender = ?, marital_status = ?, updated_at = NOW() WHERE id_employee = ?";

        // prepare the connection to the database
        $sql = $connectionDB->prepare($query);

        // execute the query already prepared previously
        $sql->execute([$first_name, $last_name, $birthdate, $phone, $email, $address, $city, $zip_code, $country, $gender, $marital_status, $id_employee]);
    }

    /**
     * Get the last employee created or modified
     * @return object|false
     */
    public static function getLast() {
        $connectionDB = DB::createInstance();
        $sql = $connectionDB->query("SELECT e.*, r.role_name, r.id_role
                                     FROM employees e
                                     LEFT JOIN users u ON u.employee_id = e.id_employee 
                                     LEFT JOIN roles r ON r.id_role = u.role_id
                                     ORDER BY COALESCE(e.updated_at, e.created_at) DESC, e.id_employee DESC
                                     LIMIT 1");
        $employee = $sql->fetch(PDO::FETCH_ASSOC);
        if ($employee) {
            return new Employee($employee["id_employee"], $employee["first_name"], $employee["last_name"], $employee["birthdate"], $employee["phone"], $employee["email"], $employee["address"], $employee["city"], $employee["zip_code"], $employee["country"], $employee["gender"], $employee["marital_status"], $employee["role_name"], $employee["created_at"], $employee["updated_at"]);
        }
        return false;
    }
}
