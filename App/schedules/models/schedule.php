<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Schedules\Models
 * 📂 Physical File:   App/schedules/models/schedule.php
 * 
 * 📝 Description:
 * Model for interacting with the 'opening' table (Schedules).
 * 
 * 🔗 Dependencies:
 * - Arcadia\Database\Connection (via database/connection.php)
 */

require_once __DIR__ . '/../../../database/connection.php';

class Schedule {
    private $db;
    

    public function __construct() {
        $this->db = DB::createInstance();
    }

    /**
     * Get all schedules
     * @return array List of schedules as objects.
     */
    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM opening ORDER BY id_opening ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }



    /**
     * Get a schedule by ID
     * @param int $id
     * @return object|false
     */
    // Get a schedule by ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM opening WHERE id_opening = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }


    /**
     * Update an existing schedule
     * @param int $id
     * @param array $data
     * @return bool
     */
    // Update an existing schedule
    public function update($id, $data) {
        $sql = "UPDATE opening SET 
                time_slot = :time_slot,
                opening_time = :opening_time,
                closing_time = :closing_time,
                status = :status
                WHERE id_opening = :id";
        
        $stmt = $this->db->prepare($sql);
        
        try {
            return $stmt->execute([
                ':time_slot' => $data['time_slot'],
                ':opening_time' => $data['opening_time'],
                ':closing_time' => $data['closing_time'],
                ':status' => $data['status'],
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            // Log error or handle it as needed
            error_log("Error updating schedule: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get the last schedule modified
     * @return object|false
     */
    public function getLast() {
        // Note: opening table might not have updated_at, so we check by id_opening DESC
        $stmt = $this->db->prepare("SELECT * FROM opening ORDER BY id_opening DESC LIMIT 1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
