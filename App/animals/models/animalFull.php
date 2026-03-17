<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Animals\Models
 * 📂 Physical File:   App/animals/models/animalFull.php
 * 
 * 📝 Description:
 * Model for interacting with the 'animal_full' database table.
 * Links the general animal info with its habitat and handles media (photos).
 */

require_once __DIR__ . '/../../../database/connection.php';

class AnimalFull {
    private $db;

    public function __construct() {
        $this->db = DB::createInstance();
    }

    /**
     * Get all full animal profiles with habitat, nutrition and image info.
     * @return array List of full animal profiles.
     */
    public function getAll() {
        $sql = "SELECT af.*, ag.animal_name, ag.gender, s.specie_name, c.category_name, h.habitat_name, 
                       n.nutrition_type, n.food_type AS nutrition_food_type, n.food_qtty AS nutrition_food_qtty,
                       m.media_path, m.media_path_medium, m.media_path_large
                FROM animal_full af
                JOIN animal_general ag ON af.animal_g_id = ag.id_animal_g
                JOIN specie s ON ag.specie_id = s.id_specie 
                JOIN category c ON s.category_id = c.id_category
                LEFT JOIN habitats h ON af.habitat_id = h.id_habitat
                LEFT JOIN nutrition n ON af.nutrition_id = n.id_nutrition
                LEFT JOIN media_relations mr ON af.id_full_animal = mr.related_id AND mr.related_table = 'animal_full'
                LEFT JOIN media m ON mr.media_id = m.id_media
                LEFT JOIN health_state_report hsr ON hsr.full_animal_id = af.id_full_animal
                GROUP BY af.id_full_animal
                ORDER BY ag.animal_name ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get a single full animal profile by ID.
     * @param int $id
     * @return object|false
     */
    public function getById($id) {
        $sql = "SELECT af.*, ag.animal_name, ag.gender, ag.specie_id, s.specie_name, c.category_name, h.habitat_name, 
                       n.nutrition_type, n.food_type AS nutrition_food_type, n.food_qtty AS nutrition_food_qtty,
                       m.media_path, m.media_path_medium, m.media_path_large
                FROM animal_full af
                JOIN animal_general ag ON af.animal_g_id = ag.id_animal_g
                JOIN specie s ON ag.specie_id = s.id_specie
                LEFT JOIN category c ON s.category_id = c.id_category
                LEFT JOIN habitats h ON af.habitat_id = h.id_habitat
                LEFT JOIN nutrition n ON af.nutrition_id = n.id_nutrition
                LEFT JOIN media_relations mr ON af.id_full_animal = mr.related_id AND mr.related_table = 'animal_full'
                LEFT JOIN media m ON mr.media_id = m.id_media
                WHERE af.id_full_animal = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Create a new full animal profile.
     * @param int $animalGeneralId ID from animal_general
     * @param int $habitatId ID from habitats (can be null)
     * @param int $nutritionId ID from nutrition (can be null)
     * @return int|false The ID of the new record or false on failure.
     */
    public function create($animalGeneralId, $habitatId = null, $nutritionId = null) {
        try {
            $sql = "INSERT INTO animal_full (animal_g_id, habitat_id, nutrition_id) VALUES (:gid, :hid, :nid)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':gid' => $animalGeneralId, 
                ':hid' => $habitatId,
                ':nid' => $nutritionId
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating animal full profile: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update an animal full profile.
     * @param int $id
     * @param int $habitatId (can be null)
     * @param int $nutritionId (can be null)
     * @return bool True on success.
     */
    public function update($id, $habitatId = null, $nutritionId = null) {
        try {
            $sql = "UPDATE animal_full SET habitat_id = :hid, nutrition_id = :nid WHERE id_full_animal = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':hid' => $habitatId, 
                ':nid' => $nutritionId,
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            error_log("Error updating animal full profile: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete an animal full profile.
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        try {
            $sql = "DELETE FROM animal_full WHERE id_full_animal = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting animal full profile: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get the last animal created or modified
     * @return object|false
     */
    public function getLast() {
        $sql = "SELECT af.*, ag.animal_name, ag.gender, s.specie_name, c.category_name, h.habitat_name, 
                       n.nutrition_type, n.food_type AS nutrition_food_type, n.food_qtty AS nutrition_food_qtty,
                       m.media_path, m.media_path_medium, m.media_path_large 
                FROM animal_full af
                JOIN animal_general ag ON af.animal_g_id = ag.id_animal_g
                JOIN specie s ON ag.specie_id = s.id_specie 
                LEFT JOIN category c ON s.category_id = c.id_category
                LEFT JOIN habitats h ON af.habitat_id = h.id_habitat
                LEFT JOIN nutrition n ON af.nutrition_id = n.id_nutrition
                LEFT JOIN media_relations mr ON af.id_full_animal = mr.related_id AND mr.related_table = 'animal_full'
                LEFT JOIN media m ON mr.media_id = m.id_media
                ORDER BY af.id_full_animal DESC
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}

