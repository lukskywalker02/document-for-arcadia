<?php

/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\VetReports\Models
 * 📂 Physical File:   App/vet_reports/models/healthStateReport.php
 * 
 * 📝 Description:
 * Model for interacting with the 'health_state_report' database table.
 * Handles CRUD operations for veterinary health reports.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Database\Connection (via database/connection.php)
 */

require_once __DIR__ . '/../../../database/connection.php';

class HealthStateReport
{
    private $db;

    public function __construct()
    {
        $this->db = DB::createInstance();
    }

    /**
     * Create a new health state report.
     * @param int $fullAnimalId ID from animal_full
     * @param string $state Health state (ENUM value)
     * @param string $reviewDate Date of review (Y-m-d format)
     * @param string $vetObs Veterinary observations
     * @param int|string|null $checkedBy User ID who created the report (will be converted to null if empty or 0)
     * @param string|null $optDetails Optional details (will be converted to null if empty)
     * @return int|array The ID of the new report on success, or array with 'error' and 'code' keys on failure.
     */
    public function create($fullAnimalId, $state, $reviewDate, $vetObs, $checkedBy = null, $optDetails = null)
    {
        try {
            // Handle NULL checked_by properly - if it's 0 or empty, set to NULL
            if (empty($checkedBy) || $checkedBy === 0) {
                $checkedBy = null;
            }

            // Handle empty opt_details
            if (empty($optDetails)) {
                $optDetails = null;
            }

            // CRITICAL: Clean state value completely before any operation
            $state = trim($state);
            $state = strtolower($state);
            $state = preg_replace('/[^a-z_]/', '', $state); // Only allow lowercase letters and underscore

            // Final validation - ensure state matches ENUM EXACTLY
            $allowedStates = ['healthy', 'sick', 'quarantined', 'injured', 'happy', 'sad', 'depressed', 'terminal', 'infant', 'hungry', 'well', 'good_condition', 'angry', 'aggressive', 'nervous', 'anxious', 'recovering', 'pregnant', 'malnourished', 'dehydrated', 'stressed'];

            if (!in_array($state, $allowedStates, true)) {
                error_log("CRITICAL: State '$state' failed final validation in model! Length: " . strlen($state));
                error_log("State bytes: " . bin2hex($state));
                error_log("Allowed states: " . implode(', ', $allowedStates));
                return ['error' => "Invalid state value: '$state'", 'code' => 'INVALID_STATE'];
            }

            // Use direct value binding with explicit type
            $sql = "INSERT INTO health_state_report (full_animal_id, hsr_state, review_date, vet_obs, checked_by, opt_details) 
                    VALUES (:animal_id, :state, :review_date, :vet_obs, :checked_by, :opt_details)";
            $stmt = $this->db->prepare($sql);

            // Bind parameters with explicit types
            $stmt->bindValue(':animal_id', (int)$fullAnimalId, PDO::PARAM_INT);
            $stmt->bindValue(':state', $state, PDO::PARAM_STR);
            $stmt->bindValue(':review_date', $reviewDate, PDO::PARAM_STR);
            $stmt->bindValue(':vet_obs', $vetObs, PDO::PARAM_STR);
            if ($checkedBy === null) {
                $stmt->bindValue(':checked_by', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':checked_by', (int)$checkedBy, PDO::PARAM_INT);
            }
            if ($optDetails === null || $optDetails === '') {
                $stmt->bindValue(':opt_details', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':opt_details', $optDetails, PDO::PARAM_STR);
            }

            // Log parameters for debugging
            error_log("Creating health report - State: '$state' (hex: " . bin2hex($state) . ", len: " . strlen($state) . ")");
            error_log("Full params - animal_id: $fullAnimalId, state: '$state', review_date: $reviewDate, checked_by: " . ($checkedBy ?? 'NULL'));

            $result = $stmt->execute();

            if ($result) {
                return $this->db->lastInsertId();
            } else {
                $errorInfo = $stmt->errorInfo();
                error_log("Error creating health state report - SQL Error: " . print_r($errorInfo, true));
                error_log("SQL State Code: " . ($errorInfo[0] ?? 'N/A'));
                error_log("SQL Error Code: " . ($errorInfo[1] ?? 'N/A'));
                error_log("SQL Error Message: " . ($errorInfo[2] ?? 'N/A'));
                error_log("Parameters - animal_id: $fullAnimalId, state: '$state', review_date: $reviewDate, checked_by: " . ($checkedBy ?? 'NULL') . ", opt_details: " . ($optDetails ?? 'NULL'));
                return ['error' => $errorInfo[2] ?? 'Unknown database error', 'code' => $errorInfo[1] ?? null];
            }
        } catch (PDOException $e) {
            error_log("Error creating health state report - PDO Exception: " . $e->getMessage());
            error_log("SQL State: " . $e->getCode());
            error_log("Error Code: " . $e->errorInfo[1] ?? 'N/A');
            error_log("Error Code: " . ($errorInfo[1] ?? 'N/A'));
            error_log("Parameters: full_animal_id=$fullAnimalId, state=$state, review_date=$reviewDate, checked_by=" . ($checkedBy ?? 'NULL'));
            return ['error' => $e->getMessage(), 'code' => $e->getCode()];
        }
    }

    /**
     * Get all health state reports with animal and user info.
     * @return array List of health state reports (array of objects).
     */
    public function getAll()
    {
        $sql = "SELECT hsr.*, 
                       ag.animal_name, 
                       ag.gender,
                       s.specie_name,
                       c.category_name,
                       h.habitat_name,
                       u.username AS checked_by_username,
                       r.role_name,
                       m.media_path, 
                       m.media_path_medium, 
                       m.media_path_large
                FROM health_state_report hsr
                JOIN animal_full af ON hsr.full_animal_id = af.id_full_animal
                JOIN animal_general ag ON af.animal_g_id = ag.id_animal_g
                JOIN specie s ON ag.specie_id = s.id_specie
                LEFT JOIN category c ON s.category_id = c.id_category
                LEFT JOIN habitats h ON af.habitat_id = h.id_habitat
                LEFT JOIN users u ON hsr.checked_by = u.id_user
                LEFT JOIN roles r ON u.role_id = r.id_role
                LEFT JOIN media_relations mr ON af.id_full_animal = mr.related_id AND mr.related_table = 'animal_full'
                LEFT JOIN media m ON mr.media_id = m.id_media
                ORDER BY hsr.review_date DESC, hsr.updated_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get health state reports for a specific animal.
     * @param int $fullAnimalId ID from animal_full
     * @return array List of health state reports for the animal (array of objects).
     */
    public function getByAnimalId($fullAnimalId)
    {
        $sql = "SELECT hsr.*, 
                       ag.animal_name, 
                       ag.gender,
                       s.specie_name,
                       c.category_name,
                       h.habitat_name,
                       u.username AS checked_by_username,
                       r.role_name
                FROM health_state_report hsr
                JOIN animal_full af ON hsr.full_animal_id = af.id_full_animal
                JOIN animal_general ag ON af.animal_g_id = ag.id_animal_g
                JOIN specie s ON ag.specie_id = s.id_specie
                LEFT JOIN category c ON s.category_id = c.id_category
                LEFT JOIN habitats h ON af.habitat_id = h.id_habitat
                LEFT JOIN users u ON hsr.checked_by = u.id_user
                LEFT JOIN roles r ON u.role_id = r.id_role
                WHERE hsr.full_animal_id = :animal_id
                ORDER BY hsr.review_date DESC, hsr.updated_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':animal_id' => $fullAnimalId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get the latest health state report for a specific animal.
     * @param int $fullAnimalId ID from animal_full
     * @return object|false Report object if found, false otherwise.
     */
    public function getLatestByAnimalId($fullAnimalId)
    {
        $sql = "SELECT hsr.*, 
                       ag.animal_name, 
                       ag.gender,
                       s.specie_name,
                       c.category_name,
                       h.habitat_name,
                       u.username AS checked_by_username,
                       r.role_name
                FROM health_state_report hsr
                JOIN animal_full af ON hsr.full_animal_id = af.id_full_animal
                JOIN animal_general ag ON af.animal_g_id = ag.id_animal_g
                JOIN specie s ON ag.specie_id = s.id_specie
                LEFT JOIN category c ON s.category_id = c.id_category
                LEFT JOIN habitats h ON af.habitat_id = h.id_habitat
                LEFT JOIN users u ON hsr.checked_by = u.id_user
                LEFT JOIN roles r ON u.role_id = r.id_role
                WHERE hsr.full_animal_id = :animal_id
                ORDER BY hsr.review_date DESC, hsr.updated_at DESC
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':animal_id' => $fullAnimalId]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Get a single health state report by ID.
     * @param int $id Report ID (id_hs_report)
     * @return object|false Report object if found, false otherwise.
     */
    public function getById($id)
    {
        $sql = "SELECT hsr.*, 
                       ag.animal_name, 
                       ag.gender,
                       s.specie_name,
                       c.category_name,
                       h.habitat_name,
                       u.username AS checked_by_username,
                       r.role_name,
                       af.id_full_animal
                FROM health_state_report hsr
                JOIN animal_full af ON hsr.full_animal_id = af.id_full_animal
                JOIN animal_general ag ON af.animal_g_id = ag.id_animal_g
                JOIN specie s ON ag.specie_id = s.id_specie
                LEFT JOIN category c ON s.category_id = c.id_category
                LEFT JOIN habitats h ON af.habitat_id = h.id_habitat
                LEFT JOIN users u ON hsr.checked_by = u.id_user
                LEFT JOIN roles r ON u.role_id = r.id_role
                WHERE hsr.id_hs_report = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Update a health state report.
     * @param int $id Report ID
     * @param string $state Health state (ENUM value)
     * @param string $reviewDate Date of review (Y-m-d format)
     * @param string $vetObs Veterinary observations
     * @param int|string|null $checkedBy User ID who updated the report (will be converted to null if empty or 0)
     * @param string|null $optDetails Optional details (will be converted to null if empty)
     * @return bool|array true on success, or array with 'error' and 'code' keys on failure.
     */
    public function update($id, $state, $reviewDate, $vetObs, $checkedBy = null, $optDetails = null)
    {
        try {
            // Handle NULL checked_by properly - if it's 0 or empty, set to NULL
            if (empty($checkedBy) || $checkedBy === 0) {
                $checkedBy = null;
            }

            // Handle empty opt_details
            if (empty($optDetails)) {
                $optDetails = null;
            }

            // CRITICAL: Clean state value completely before any operation
            $state = trim($state);
            $state = strtolower($state);
            $state = preg_replace('/[^a-z_]/', '', $state); // Only allow lowercase letters and underscore

            // Final validation - ensure state matches ENUM EXACTLY
            $allowedStates = ['healthy', 'sick', 'quarantined', 'injured', 'happy', 'sad', 'depressed', 'terminal', 'infant', 'hungry', 'well', 'good_condition', 'angry', 'aggressive', 'nervous', 'anxious', 'recovering', 'pregnant', 'malnourished', 'dehydrated', 'stressed'];

            if (!in_array($state, $allowedStates, true)) {
                error_log("CRITICAL: State '$state' failed final validation in update()! Length: " . strlen($state));
                error_log("State bytes: " . bin2hex($state));
                error_log("Allowed states: " . implode(', ', $allowedStates));
                return ['error' => "Invalid state value: '$state'", 'code' => 'INVALID_STATE'];
            }

            $sql = "UPDATE health_state_report 
                    SET hsr_state = :state, 
                        review_date = :review_date, 
                        vet_obs = :vet_obs, 
                        checked_by = :checked_by, 
                        opt_details = :opt_details
                    WHERE id_hs_report = :id";
            $stmt = $this->db->prepare($sql);

            $params = [
                ':id' => (int)$id,
                ':state' => $state,
                ':review_date' => $reviewDate,
                ':vet_obs' => $vetObs,
                ':checked_by' => $checkedBy,
                ':opt_details' => $optDetails
            ];

            // Log parameters for debugging
            error_log("Updating health report with params: " . print_r($params, true));

            $result = $stmt->execute($params);

            if ($result) {
                return true;
            } else {
                $errorInfo = $stmt->errorInfo();
                error_log("Error updating health state report - SQL Error: " . print_r($errorInfo, true));
                return ['error' => $errorInfo[2] ?? 'Unknown database error', 'code' => $errorInfo[1] ?? null];
            }
        } catch (PDOException $e) {
            error_log("Error updating health state report - PDO Exception: " . $e->getMessage());
            error_log("SQL State: " . $e->getCode());
            return ['error' => $e->getMessage(), 'code' => $e->getCode()];
        }
    }

    /**
     * Delete a health state report.
     * @param int $id Report ID (id_hs_report)
     * @return bool true on success, false on failure.
     */
    public function delete($id)
    {
        try {
            $sql = "DELETE FROM health_state_report WHERE id_hs_report = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting health state report: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get the last health state report (most recent by review_date and updated_at).
     * @return object|false Report object if found, false otherwise.
     */
    public function getLast()
    {
        $sql = "SELECT hsr.*, 
                       ag.animal_name,
                       u.username AS checked_by_username
                FROM health_state_report hsr
                JOIN animal_full af ON hsr.full_animal_id = af.id_full_animal
                JOIN animal_general ag ON af.animal_g_id = ag.id_animal_g
                LEFT JOIN users u ON hsr.checked_by = u.id_user
                ORDER BY hsr.review_date DESC, hsr.updated_at DESC
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
