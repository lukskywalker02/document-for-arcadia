<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Animals\Models
 * 📂 Physical File:   App/animals/models/nutrition.php
 * 
 * 📝 Description:
 * Model for interacting with the 'nutrition' database table.
 * Handles CRUD operations for nutrition plans (diet types, food types, quantities).
 */

require_once __DIR__ . '/../../../database/connection.php';

class Nutrition {
    private $db;

    public function __construct() {
        $this->db = DB::createInstance();
    }

    /**
     * Get all nutrition plans ordered by nutrition_type.
     * @return array List of nutrition plans as objects.
     */
    public function getAll() {
        $sql = "SELECT * 
                FROM nutrition 
                ORDER BY nutrition_type ASC, food_type ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get a single nutrition plan by ID.
     * @param int $id
     * @return object|false
     */
    public function getById($id) {
        $sql = "SELECT * FROM nutrition WHERE id_nutrition = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Create a new nutrition plan.
     * @param string $nutritionType ('carnivorous', 'herbivorous', 'omnivorous')
     * @param string $foodType ('meat', 'fruit', 'legumes', 'insect')
     * @param int $foodQty Quantity in grams
     * @return int|false The ID of the new nutrition plan or false on failure.
     */
    public function create($nutritionType, $foodType, $foodQty) {
        try {
            $sql = "INSERT INTO nutrition (nutrition_type, food_type, food_qtty) 
                    VALUES (:type, :food, :qty)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':type' => $nutritionType,
                ':food' => $foodType,
                ':qty' => $foodQty
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating nutrition plan: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update a nutrition plan.
     * @param int $id
     * @param string $nutritionType
     * @param string $foodType
     * @param int $foodQty
     * @return bool True on success.
     */
    public function update($id, $nutritionType, $foodType, $foodQty) {
        try {
            $sql = "UPDATE nutrition 
                    SET nutrition_type = :type, food_type = :food, food_qtty = :qty 
                    WHERE id_nutrition = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':type' => $nutritionType,
                ':food' => $foodType,
                ':qty' => $foodQty,
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            error_log("Error updating nutrition plan: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a nutrition plan.
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        try {
            $sql = "DELETE FROM nutrition WHERE id_nutrition = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting nutrition plan: " . $e->getMessage());
            return false;
        }
    }
}

