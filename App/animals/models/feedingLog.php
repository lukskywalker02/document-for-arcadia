<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Animals\Models
 * 📂 Physical File:   App/animals/models/feedingLog.php
 * 
 * 📝 Description:
 * Model for interacting with the 'feeding_logs' database table.
 * Handles CRUD operations for feeding records (what was actually fed to animals).
 */

require_once __DIR__ . '/../../../database/connection.php';

class FeedingLog {
    private $db;

    public function __construct() {
        $this->db = DB::createInstance();
    }

    /**
     * Create a new feeding log entry.
     * @param int $animalFullId ID from animal_full
     * @param string $foodType ('meat', 'fruit', 'legumes', 'insect')
     * @param int $foodQty Quantity in grams
     * @param int|null $userId ID from users (employee who fed, can be null)
     * @param string|null $foodDate Custom date/time (optional, defaults to NOW)
     * @return int|false The ID of the new log entry or false on failure.
     */
    public function create($animalFullId, $foodType, $foodQty, $userId = null, $foodDate = null) {
        try {
            if ($foodDate) {
                $sql = "INSERT INTO feeding_logs (animal_f_id, user_id, food_type, food_qtty, food_date) 
                        VALUES (:animal_id, :user_id, :food_type, :food_qtty, :food_date)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    ':animal_id' => $animalFullId,
                    ':user_id' => $userId,
                    ':food_type' => $foodType,
                    ':food_qtty' => $foodQty,
                    ':food_date' => $foodDate
                ]);
            } else {
                $sql = "INSERT INTO feeding_logs (animal_f_id, user_id, food_type, food_qtty) 
                        VALUES (:animal_id, :user_id, :food_type, :food_qtty)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    ':animal_id' => $animalFullId,
                    ':user_id' => $userId,
                    ':food_type' => $foodType,
                    ':food_qtty' => $foodQty
                ]);
            }
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating feeding log: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all feeding logs with animal and nutrition plan info (for comparison).
     * @return array List of feeding logs with plan comparison.
     */
    public function getAll() {
        $sql = "SELECT fl.*, 
                       ag.animal_name, 
                       af.nutrition_id,
                       n.food_type AS plan_food_type, 
                       n.food_qtty AS plan_food_qtty,
                       n.nutrition_type,
                       u.username AS fed_by_username
                FROM feeding_logs fl
                JOIN animal_full af ON fl.animal_f_id = af.id_full_animal
                JOIN animal_general ag ON af.animal_g_id = ag.id_animal_g
                LEFT JOIN nutrition n ON af.nutrition_id = n.id_nutrition
                LEFT JOIN users u ON fl.user_id = u.id_user
                ORDER BY fl.food_date DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get feeding logs for a specific animal.
     * @param int $animalFullId
     * @return array List of feeding logs for the animal.
     */
    public function getByAnimalId($animalFullId) {
        $sql = "SELECT fl.*, 
                       ag.animal_name, 
                       af.nutrition_id,
                       n.food_type AS plan_food_type, 
                       n.food_qtty AS plan_food_qtty,
                       n.nutrition_type,
                       u.username AS fed_by_username
                FROM feeding_logs fl
                JOIN animal_full af ON fl.animal_f_id = af.id_full_animal
                JOIN animal_general ag ON af.animal_g_id = ag.id_animal_g
                LEFT JOIN nutrition n ON af.nutrition_id = n.id_nutrition
                LEFT JOIN users u ON fl.user_id = u.id_user
                WHERE fl.animal_f_id = :animal_id
                ORDER BY fl.food_date DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':animal_id' => $animalFullId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get the last feeding log for a specific animal.
     * @param int $animalFullId
     * @return object|false
     */
    public function getLastFeeding($animalFullId) {
        $sql = "SELECT fl.*, 
                       ag.animal_name, 
                       af.nutrition_id,
                       n.food_type AS plan_food_type, 
                       n.food_qtty AS plan_food_qtty,
                       n.nutrition_type,
                       u.username AS fed_by_username
                FROM feeding_logs fl
                JOIN animal_full af ON fl.animal_f_id = af.id_full_animal
                JOIN animal_general ag ON af.animal_g_id = ag.id_animal_g
                LEFT JOIN nutrition n ON af.nutrition_id = n.id_nutrition
                LEFT JOIN users u ON fl.user_id = u.id_user
                WHERE fl.animal_f_id = :animal_id
                ORDER BY fl.food_date DESC
                LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':animal_id' => $animalFullId]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Get a single feeding log by ID.
     * @param int $id
     * @return object|false
     */
    public function getById($id) {
        $sql = "SELECT fl.*, 
                       ag.animal_name, 
                       af.nutrition_id,
                       n.food_type AS plan_food_type, 
                       n.food_qtty AS plan_food_qtty,
                       n.nutrition_type,
                       u.username AS fed_by_username
                FROM feeding_logs fl
                JOIN animal_full af ON fl.animal_f_id = af.id_full_animal
                JOIN animal_general ag ON af.animal_g_id = ag.id_animal_g
                LEFT JOIN nutrition n ON af.nutrition_id = n.id_nutrition
                LEFT JOIN users u ON fl.user_id = u.id_user
                WHERE fl.id_feeding_log = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Delete a feeding log entry.
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        try {
            $sql = "DELETE FROM feeding_logs WHERE id_feeding_log = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting feeding log: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get the last feeding log entry
     * @return object|false
     */
    public function getLast() {
        $sql = "SELECT fl.*, 
                       ag.animal_name, 
                       u.username AS fed_by_username
                FROM feeding_logs fl
                JOIN animal_full af ON fl.animal_f_id = af.id_full_animal
                JOIN animal_general ag ON af.animal_g_id = ag.id_animal_g
                LEFT JOIN users u ON fl.user_id = u.id_user
                ORDER BY fl.food_date DESC, fl.id_feeding_log DESC
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}

