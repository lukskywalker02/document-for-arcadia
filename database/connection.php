<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Database
 * 📂 Physical File:   database/connection.php
 * 
 * 📝 Description:
 * Singleton class for database connection (PDO).
 * Manages the unique and persistent connection to MySQL.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Config (via config.php)
 */

include_once __DIR__ . "/../config.php";

class DB {
    // Here I am declaring a class that will be responsible for connecting to the database.
    
    private static $instance = null;
    // This here is a static property. I put it to null at the beginning because there is no connection yet.
    // I only want one connection for the entire project, so I will use this same variable all the time.

    public static function createInstance() {
    // This function I will call from outside without the need to create an object (because it is static).
    // And it will return me the connection ready to use.

        if (!isset(self::$instance)) {
        // Check if there is already a connection created.
        // Use `self::` because I am inside the class and want to access its static variable.
        // If there is no connection yet, I enter and create it.

            $optionsPDO[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            // This tells PDO that if something goes wrong, don't tell me with a strange number, 
            // but throw an exception to be able to capture the error.

            self::$instance = new PDO(
                // Here I create the PDO connection.
                // self::$instance saves the connection I am creating to be able to reuse it later.
                
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                // Here I build the string with the host (server), database name and encoding.
                // Using utf8mb4 to support emojis and full Unicode characters (4 bytes).
                
                DB_USER,
                // User to connect to (this is defined in another file, as a constant).
                
                DB_PASS,
                // Password of that user.
                
                $optionsPDO
                // And I pass the options I defined above, like the exceptions.
            );
            
            // Set connection charset to utf8mb4 explicitly
            self::$instance->exec("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");

            // echo "<br> Connected to the database!!!! <br> ";
            // This is only to make sure I am connected well (useful in tests).
        }

        return self::$instance;
        // Return the connection, whether it is the one I just created or one that already existed before.
        // So I can use it in any part of the code without repeating the creation.
    }
}
