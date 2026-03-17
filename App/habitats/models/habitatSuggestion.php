<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Habitats\Models
 * 📂 Physical File:   App/habitats/models/habitatSuggestion.php
 * 
 * 📝 Description:
 * Model for interacting with the 'habitat_suggestion' database table.
 * Handles CRUD operations for habitat improvement suggestions.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Database\Connection (via database/connection.php)
 */

require_once __DIR__ . '/../../../database/connection.php';

class HabitatSuggestion {
    private $db;

    public function __construct() {
        $this->db = DB::createInstance();
    }

    /**
     * Get all habitat suggestions with habitat and user info.
     * Filters out suggestions deleted by admin (soft delete).
     * @return array List of suggestions.
     */
    public function getAll() {
        $sql = "SELECT hs.*, 
                       h.habitat_name,
                       u_suggest.username AS suggested_by_username,
                       u_review.username AS reviewed_by_username
                FROM habitat_suggestion hs
                JOIN habitats h ON hs.habitat_id = h.id_habitat
                LEFT JOIN users u_suggest ON hs.suggested_by = u_suggest.id_user
                LEFT JOIN users u_review ON hs.reviewed_by = u_review.id_user
                WHERE hs.deleted_by_admin = 0
                ORDER BY hs.proposed_on DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get all suggestions by a specific veterinarian.
     * Filters out suggestions deleted by veterinarian (soft delete).
     * @param int $userId ID of the veterinarian
     * @return array List of suggestions.
     */
    public function getByVeterinarian($userId) {
        $sql = "SELECT hs.*, 
                       h.habitat_name,
                       u_suggest.username AS suggested_by_username,
                       u_review.username AS reviewed_by_username
                FROM habitat_suggestion hs
                JOIN habitats h ON hs.habitat_id = h.id_habitat
                LEFT JOIN users u_suggest ON hs.suggested_by = u_suggest.id_user
                LEFT JOIN users u_review ON hs.reviewed_by = u_review.id_user
                WHERE hs.suggested_by = :user_id 
                  AND hs.deleted_by_veterinarian = 0
                ORDER BY hs.proposed_on DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get a single suggestion by ID.
     * @param int $id
     * @return object|false
     */
    public function getById($id) {
        $sql = "SELECT hs.*, 
                       h.habitat_name,
                       u_suggest.username AS suggested_by_username,
                       u_review.username AS reviewed_by_username
                FROM habitat_suggestion hs
                JOIN habitats h ON hs.habitat_id = h.id_habitat
                LEFT JOIN users u_suggest ON hs.suggested_by = u_suggest.id_user
                LEFT JOIN users u_review ON hs.reviewed_by = u_review.id_user
                WHERE hs.id_hab_suggestion = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Create a new habitat suggestion.
     * @param int $habitatId ID from habitats
     * @param int $suggestedBy ID from users (veterinarian)
     * @param string $details Details of the suggestion
     * @return int|false The ID of the new suggestion or false on failure.
     */
    public function create($habitatId, $suggestedBy, $details) {
        try {
            $sql = "INSERT INTO habitat_suggestion (habitat_id, suggested_by, details, status) 
                    VALUES (:habitat_id, :suggested_by, :details, 'pending')";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':habitat_id' => $habitatId,
                ':suggested_by' => $suggestedBy,
                ':details' => $details
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating habitat suggestion: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update a habitat suggestion (only details, only if status is 'pending').
     * @param int $id
     * @param string $details
     * @return bool True on success.
     */
    public function update($id, $details) {
        try {
            $sql = "UPDATE habitat_suggestion 
                    SET details = :details 
                    WHERE id_hab_suggestion = :id AND status = 'pending'";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':details' => $details,
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            error_log("Error updating habitat suggestion: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Accept or reject a suggestion (Admin only).
     * @param int $id
     * @param string $status 'accepted' or 'rejected'
     * @param int $reviewedBy ID from users (admin)
     * @return bool True on success.
     */
    public function review($id, $status, $reviewedBy) {
        try {
            $sql = "UPDATE habitat_suggestion 
                    SET status = :status, reviewed_by = :reviewed_by, reviewed_on = NOW() 
                    WHERE id_hab_suggestion = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':status' => $status,
                ':reviewed_by' => $reviewedBy,
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            error_log("Error reviewing habitat suggestion: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Soft delete a habitat suggestion by role.
     * Marks the suggestion as deleted for the specific role (admin or veterinarian).
     * @param int $id Suggestion ID
     * @param string $roleName 'Admin' or 'Veterinary'
     * @return bool
     */
    public function delete($id, $roleName) {
        try {
            if ($roleName === 'Admin') {
                $sql = "UPDATE habitat_suggestion 
                        SET deleted_by_admin = 1 
                        WHERE id_hab_suggestion = :id";
            } elseif ($roleName === 'Veterinary') {
                $sql = "UPDATE habitat_suggestion 
                        SET deleted_by_veterinarian = 1 
                        WHERE id_hab_suggestion = :id";
            } else {
                error_log("Invalid role for soft delete: " . $roleName);
                return false;
            }
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error soft deleting habitat suggestion: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get the last habitat suggestion
     * @return object|false
     */
    public function getLast() {
        $sql = "SELECT hs.*, 
                       h.habitat_name,
                       u_suggest.username AS suggested_by_username,
                       u_review.username AS reviewed_by_username
                FROM habitat_suggestion hs
                JOIN habitats h ON hs.habitat_id = h.id_habitat
                LEFT JOIN users u_suggest ON hs.suggested_by = u_suggest.id_user
                LEFT JOIN users u_review ON hs.reviewed_by = u_review.id_user
                WHERE hs.deleted_by_admin = 0 AND hs.deleted_by_veterinarian = 0
                ORDER BY hs.proposed_on DESC
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}

