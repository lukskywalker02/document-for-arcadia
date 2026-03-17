<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Auth\Controllers
 * 📂 Physical File:   App/auth/controllers/auth_pages_controller.php
 * 
 * 📝 Description:
 * Public controller for authentication.
 * Manages the login and logout of users.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Database\Connection (via database/connection.php)
 * - Arcadia\Auth\Views\Pages\Login (via App/auth/views/pages/login.php)
 * - Arcadia\Database\Connection (via database/connection.php)
 */

include_once __DIR__ . "/../../../database/connection.php";
// Include the file that has the DB class to be able to connect to the database.
// Include User model to get permissions
require_once __DIR__ . '/../../users/models/user.php';
require_once __DIR__ . '/../../roles/models/role.php';
require_once __DIR__ . '/../../../includes/helpers/csrf.php';

DB::createInstance();
// Call the static method createInstance() of the DB class.
// This method returns a PDO connection ready to use, following the Singleton pattern.
// If it is the first time it is called, it creates the connection. If it already exists, it reuses the same one.

class AuthPagesController{
    public function login(){
        

        if ($_POST) {
            // Verify CSRF token before processing login
            if (!csrf_verify('login_form')) {
                $_SESSION["login_error"] = "Invalid request. Please try again.";
                header('Location: /auth/pages/login');
                exit();
            }

            $connectionDB = DB::createInstance();

            // 1. We search ONLY by user/email. We don't put the password here! (i think that if we put the psw here can be risky!, AT THIS MOMENT I DON'T KNO WHY but i'm sure of it, my instinct says me that can i model it in another way to make it more secure)
            // IMPROVE SECURITY: We need to bring the role_name by doing JOIN with roles
            $query = "SELECT u.*, e.email, r.role_name
                      FROM users u 
                      LEFT JOIN employees e ON u.employee_id = e.id_employee 
                      LEFT JOIN roles r ON u.role_id = r.id_role
                      WHERE u.username = :login OR e.email = :login";

            $sql = $connectionDB->prepare($query);

            $loginInput = $_POST['email'] ?? ''; // We get what the user wrote (email or username)
            $passwordInput = $_POST['password'] ?? '';

            // Security: Sanitize and validate input
            // PDO prepared statements already protect against SQL injection, but we add extra validation
            $loginInput = trim($loginInput);
            $loginInput = substr($loginInput, 0, 255); // Limit length to prevent buffer issues
            
            // Basic validation: ensure input is not empty
            if (empty($loginInput)) {
                $_SESSION["login_error"] = "Username or email is required.";
                header('Location: /auth/pages/login');
                exit();
            }

            // Use bindValue instead of bindParam for better security (binds the value, not the variable reference)
            $sql->bindValue(":login", $loginInput, PDO::PARAM_STR);

            $sql->execute();
            // We fetch the user from the database
            $user = $sql->fetch(PDO::FETCH_ASSOC);

            // 2. Now PHP makes the detective (how?), well.. comparing if the user exists or not, and if the password is correct or not.
            if ($user) {
                // SECURITY UPGRADE: PASSWORD VERIFICATION (Hash + check old text plain psw)
                
                $storedPassword = $user['psw']; // Password from DB (can be hash or plain text)
                
                $loginSuccessful = false;
                $shouldUpdateHash = false;

                // 1. Try secure verification (Standard PHP password_verify)
                // This checks if the input matches the BCrypt/Argon2 hash
                if (password_verify($passwordInput, $storedPassword)) {
                    $loginSuccessful = true;
                    
                    // Check if the hash needs to be updated to a newer algorithm (maintenance)
                    if (password_needs_rehash($storedPassword, PASSWORD_DEFAULT)) {
                        $shouldUpdateHash = true;
                    }
                }
                // 2. Fallback: Try plain text verification (Legacy Migration for old users)
                // If the user hasn't logged in since the security update, their password is still plain text.
                elseif ($storedPassword === $passwordInput) {
                    $loginSuccessful = true;
                    $shouldUpdateHash = true; // Mark for immediate upgrade to Hash
                }

                if ($loginSuccessful) {
                    // AUTO-MIGRATION: Upgrade insecure password to Hash silently
                    if ($shouldUpdateHash) {
                        $newHash = password_hash($passwordInput, PASSWORD_DEFAULT);
                        try {
                            $updateQuery = "UPDATE users SET psw = :new_psw WHERE id_user = :id";
                            $updateStmt = $connectionDB->prepare($updateQuery);
                            $updateStmt->execute([
                                ':new_psw' => $newHash,
                                ':id' => $user['id_user']
                            ]);
                        } catch (Exception $e) {
                            // If update fails, we log it but allow login to proceed (don't block the user)
                            error_log("Failed to update password hash for user ID " . $user['id_user']);
                        }
                    }
                    // 🚀 SESSION CREATION (Original Logic)
                    
                    // NEW LOGIC: Check if the account is active
                    if ($user['is_active'] == 0) {
                        // if ACCOUNT INACTIVE: Don't pass
                        $_SESSION["login_error"] = "Your account is deactivated. Please contact the administrator.";
                        header('Location: /auth/pages/login');
                        exit();
                    } else {
                        // if ACCOUNT ACTIVE: Go ahead
                        $_SESSION["user"] = $user;
                        $_SESSION["loggedin"] = true;
                        $_SESSION["last_activity"] = time(); // Set session activity timestamp
                        
                        // Load all user permissions (role + VIP) into session
                        $_SESSION["user"]["permissions"] = User::getAllUserPermissions($user['id_user']);
                        
                        header('Location: /home/pages/start');
                        exit();
                    }

                } else {
                    // Password incorrect (ni hash ni texto plano)
                    $_SESSION["loggedin"] = false;
                    $_SESSION["login_error"] = "User not found or password incorrect.";
                    header('Location: /auth/pages/login');
                    exit();
                }
            } else {

                $_SESSION["login_error"] = "User not found or password incorrect.";
                header('Location: /auth/pages/login');
                exit();
            }

            // print_r($user);
            // echo "<br>";
            // echo "<br>";
        }

        // Include the view to display the login page
        include_once __DIR__ . "/../views/pages/login.php";
    }


    public function logout() {
        // We don't need session_start() because it is already in the router, 
        // but for security to destroy the session we can let it there or check the status.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Destroy all session variables (empty the session).
        $_SESSION = array();

        // If we want to destroy the session completely, also delete the session cookie (if it is used).
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session (completely).
        session_destroy();

        // Redirect to login
        header("Location: /auth/pages/login");
        exit();
    }
  
}

?>