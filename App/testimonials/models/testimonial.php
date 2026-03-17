<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Testimonials\Models
 * 📂 Physical File:   App/testimonials/models/testimonial.php
 * 
 * 📝 Description:
 * Model for managing testimonials (visitor feedback).
 * Handles database operations for testimonials: create, read, update, validate, reject.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Database\Connection (via database/connection.php)
 */

require_once __DIR__ . '/../../../database/connection.php';

class Testimonial
{
    private $db;

    public function __construct()
    {
        $this->db = DB::createInstance();
    }

    /**
     * Create a new testimonial (only for non-employee visitors)
     * @param string $pseudo - Visitor's pseudonym
     * @param string $message - Testimonial message
     * @param int $rating - Rating from 1 to 5
     * @return int|false - ID of created testimonial or false on failure
     */
    public function create($pseudo, $message, $rating)
    {
        try {
            // Validate rating is between 1 and 5
            $rating = (int)$rating;
            if ($rating < 1 || $rating > 5) {
                error_log("Testimonial create: Invalid rating value: $rating");
                return false;
            }

            // Sanitize inputs
            $pseudo = trim($pseudo);
            $message = trim($message);

            // Validate required fields
            if (empty($pseudo)) {
                error_log("Testimonial create: Pseudo is empty");
                return false;
            }

            if (empty($message)) {
                error_log("Testimonial create: Message is empty");
                return false;
            }

            // Limit pseudo length
            if (strlen($pseudo) > 100) {
                $pseudo = substr($pseudo, 0, 100);
            }

            $sql = "INSERT INTO testimonials (pseudo, message, rating, status) 
                    VALUES (:pseudo, :message, :rating, 'pending')";

            $stmt = $this->db->prepare($sql);
            
            if (!$stmt) {
                $errorInfo = $this->db->errorInfo();
                error_log("Testimonial create: SQL prepare failed: " . print_r($errorInfo, true));
                return false;
            }

            $result = $stmt->execute([
                ':pseudo' => $pseudo,
                ':message' => $message,
                ':rating' => $rating
            ]);

            if ($result) {
                $insertId = $this->db->lastInsertId();
                error_log("Testimonial create: Success! ID: $insertId");
                return $insertId;
            } else {
                $errorInfo = $stmt->errorInfo();
                error_log("Testimonial create: SQL execute failed: " . print_r($errorInfo, true));
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error creating testimonial: " . $e->getMessage());
            error_log("Error trace: " . $e->getTraceAsString());
            return false;
        }
    }

    /**
     * Get all testimonials (for admin)
     * @param string|null $status - Filter by status ('pending', 'validated', 'rejected')
     * @return array - Array of testimonial objects
     */
    public function getAll($status = null)
    {
        try {
            $sql = "SELECT t.*, 
                           u.username AS validator_username,
                           r.role_name AS validator_role
                    FROM testimonials t
                    LEFT JOIN users u ON t.validated_by = u.id_user
                    LEFT JOIN roles r ON u.role_id = r.id_role";

            if ($status) {
                $sql .= " WHERE t.status = :status";
            }

            $sql .= " ORDER BY t.created_at DESC";

            $stmt = $this->db->prepare($sql);
            if ($status) {
                $stmt->execute([':status' => $status]);
            } else {
                $stmt->execute();
            }

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error getting testimonials: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get only validated testimonials (for public display)
     * @return array - Array of validated testimonial objects
     */
    public function getValidated()
    {
        try {
            $sql = "SELECT * FROM testimonials 
                    WHERE status = 'validated' 
                    ORDER BY created_at DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error getting validated testimonials: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get a testimonial by ID
     * @param int $id - Testimonial ID
     * @return object|false - Testimonial object or false if not found
     */
    public function getById($id)
    {
        try {
            $sql = "SELECT t.*, 
                           u.username AS validator_username,
                           r.role_name AS validator_role
                    FROM testimonials t
                    LEFT JOIN users u ON t.validated_by = u.id_user
                    LEFT JOIN roles r ON u.role_id = r.id_role
                    WHERE t.id_testimonial = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result ? $result : false;
        } catch (PDOException $e) {
            error_log("Error getting testimonial by ID: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update a testimonial (admin can edit message/pseudo/rating)
     * Useful for cleaning up inappropriate content before validation
     * @param int $id - Testimonial ID
     * @param string $pseudo - Updated pseudonym
     * @param string $message - Updated message
     * @param int $rating - Updated rating (1-5)
     * @return bool - Success status
     */
    public function update($id, $pseudo, $message, $rating)
    {
        try {
            // Validate rating
            $rating = (int)$rating;
            if ($rating < 1 || $rating > 5) {
                return false;
            }

            // Sanitize inputs
            $pseudo = trim($pseudo);
            $message = trim($message);

            if (empty($pseudo) || empty($message)) {
                return false;
            }

            if (strlen($pseudo) > 100) {
                $pseudo = substr($pseudo, 0, 100);
            }

            $sql = "UPDATE testimonials 
                    SET pseudo = :pseudo, 
                        message = :message, 
                        rating = :rating,
                        updated_at = CURRENT_TIMESTAMP
                    WHERE id_testimonial = :id";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':pseudo' => $pseudo,
                ':message' => $message,
                ':rating' => $rating,
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            error_log("Error updating testimonial: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Validate a testimonial (admin action)
     * @param int $id - Testimonial ID
     * @param int $validatorId - ID of the user validating
     * @return bool - Success status
     */
    public function validate($id, $validatorId)
    {
        try {
            $sql = "UPDATE testimonials 
                    SET status = 'validated',
                        validated_at = CURRENT_TIMESTAMP,
                        validated_by = :validator_id,
                        updated_at = CURRENT_TIMESTAMP
                    WHERE id_testimonial = :id";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':validator_id' => $validatorId,
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            error_log("Error validating testimonial: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Reject a testimonial (admin action)
     * @param int $id - Testimonial ID
     * @param int $validatorId - ID of the user rejecting
     * @return bool - Success status
     */
    public function reject($id, $validatorId)
    {
        try {
            $sql = "UPDATE testimonials 
                    SET status = 'rejected',
                        validated_at = CURRENT_TIMESTAMP,
                        validated_by = :validator_id,
                        updated_at = CURRENT_TIMESTAMP
                    WHERE id_testimonial = :id";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':validator_id' => $validatorId,
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            error_log("Error rejecting testimonial: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a testimonial (admin action)
     * @param int $id - Testimonial ID
     * @return bool - Success status
     */
    public function delete($id)
    {
        try {
            $sql = "DELETE FROM testimonials WHERE id_testimonial = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting testimonial: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get the best testimonial (highest rating, or most recent if tie)
     * For display on home page
     * @return object|false - Best testimonial object or false if none found
     */
    public function getBest()
    {
        try {
            // Get the testimonial with highest rating
            // If multiple have the same rating, get the most recent one
            $sql = "SELECT * FROM testimonials 
                    WHERE status = 'validated' 
                    ORDER BY rating DESC, created_at DESC 
                    LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result ? $result : false;
        } catch (PDOException $e) {
            error_log("Error getting best testimonial: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get statistics about testimonials
     * @return object - Statistics object with counts
     */
    public function getStats()
    {
        try {
            // e.g if status pending, then sum up all the testimonials with status pending... a brief explanation of the query... 
            // to remind me of what the query does quickly
            $sql = "SELECT 
                        COUNT(*) as total,
                        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                        SUM(CASE WHEN status = 'validated' THEN 1 ELSE 0 END) as validated,
                        SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected,
                        AVG(rating) as avg_rating
                    FROM testimonials";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error getting testimonial stats: " . $e->getMessage());
            return (object)[
                'total' => 0,
                'pending' => 0,
                'validated' => 0,
                'rejected' => 0,
                'avg_rating' => 0
            ];
        }
    }

    /**
     * Get the last testimonial
     * @return object|false
     */
    public function getLast() {
        $sql = "SELECT * FROM testimonials 
                WHERE status = 'validated'
                ORDER BY created_at DESC, id_testimonial DESC
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}

