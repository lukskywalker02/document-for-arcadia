<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Contact\Models
 * 📂 Physical File:   App/contact/models/formContact.php
 * 
 * 📝 Description:
 * Model for managing contact form submissions.
 * Handles database operations for contact forms: create, read, mark as sent.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Database\Connection (via database/connection.php)
 */

require_once __DIR__ . '/../../../database/connection.php';

class FormContact
{
    private $db;

    public function __construct()
    {
        $this->db = DB::createInstance();
    }

    /**
     * Create a new contact form submission
     * @param string $firstName - Visitor's first name
     * @param string $lastName - Visitor's last name
     * @param string $email - Visitor's email
     * @param string $subject - Subject of the message
     * @param string $message - Message content
     * @return int|false - ID of created contact form or false on failure
     */
    public function create($firstName, $lastName, $email, $subject, $message)
    {
        try {
            // Sanitize inputs
            $firstName = trim($firstName);
            $lastName = trim($lastName);
            $email = trim($email);
            $subject = trim($subject);
            $message = trim($message);

            // Validate required fields
            if (empty($firstName) || empty($lastName) || empty($email) || empty($message)) {
                return false;
            }

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return false;
            }

            // Limit field lengths
            if (strlen($firstName) > 50) {
                $firstName = substr($firstName, 0, 50);
            }
            if (strlen($lastName) > 50) {
                $lastName = substr($lastName, 0, 50);
            }
            if (strlen($email) > 100) {
                $email = substr($email, 0, 100);
            }
            if (strlen($subject) > 100) {
                $subject = substr($subject, 0, 100);
            }

            $sql = "INSERT INTO form_contact (ff_name, fl_name, f_email, f_subject, f_message, email_sent) 
                    VALUES (:first_name, :last_name, :email, :subject, :message, FALSE)";

            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                ':first_name' => $firstName,
                ':last_name' => $lastName,
                ':email' => $email,
                ':subject' => $subject,
                ':message' => $message
            ]);

            if ($result) {
                return $this->db->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error creating contact form: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all contact form submissions (for admin/employee)
     * @param bool|null $emailSent - Filter by email_sent status (true, false, or null for all)
     * @return array - Array of contact form objects
     */
    public function getAll($emailSent = null)
    {
        try {
            $sql = "SELECT * FROM form_contact";

            if ($emailSent !== null) {
                $sql .= " WHERE email_sent = :email_sent";
            }

            $sql .= " ORDER BY f_sent_date DESC";

            $stmt = $this->db->prepare($sql);
            if ($emailSent !== null) {
                $stmt->execute([':email_sent' => $emailSent ? 1 : 0]);
            } else {
                $stmt->execute();
            }

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error getting contact forms: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get a contact form by ID
     * @param int $id - Contact form ID
     * @return object|false - Contact form object or false if not found
     */
    public function getById($id)
    {
        try {
            $sql = "SELECT * FROM form_contact WHERE id_form = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result ? $result : false;
        } catch (PDOException $e) {
            error_log("Error getting contact form by ID: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Mark a contact form as email sent
     * @param int $id - Contact form ID
     * @return bool - Success status
     */
    public function markAsSent($id)
    {
        try {
            $sql = "UPDATE form_contact 
                    SET email_sent = TRUE 
                    WHERE id_form = :id";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error marking contact form as sent: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Mark a contact form as pending (revert sent status)
     * @param int $id - Contact form ID
     * @return bool - Success status
     */
    public function markAsPending($id)
    {
        try {
            $sql = "UPDATE form_contact 
                    SET email_sent = FALSE 
                    WHERE id_form = :id";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error marking contact form as pending: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a contact form (admin action)
     * @param int $id - Contact form ID
     * @return bool - Success status
     */
    public function delete($id)
    {
        try {
            $sql = "DELETE FROM form_contact WHERE id_form = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting contact form: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get statistics about contact forms
     * @return object - Statistics object with counts
     */
    public function getStats()
    {
        try {
            $sql = "SELECT 
                        COUNT(*) as total,
                        SUM(CASE WHEN email_sent = TRUE THEN 1 ELSE 0 END) as sent,
                        SUM(CASE WHEN email_sent = FALSE THEN 1 ELSE 0 END) as pending
                    FROM form_contact";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error getting contact form stats: " . $e->getMessage());
            return (object)[
                'total' => 0,
                'sent' => 0,
                'pending' => 0
            ];
        }
    }

    /**
     * Get the last contact form submission
     * @return object|false
     */
    public function getLast() {
        $sql = "SELECT * FROM form_contact 
                ORDER BY f_sent_date DESC, id_form DESC
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}

