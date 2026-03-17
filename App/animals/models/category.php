<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Animals\Models
 * 📂 Physical File:   App/animals/models/category.php
 * 
 * 📝 Description:
 * Model for interacting with the 'category' database table.
 * Handles CRUD operations for animal categorys (Mammal, Reptile, etc.).
 */

require_once __DIR__ . '/../../../database/connection.php';

class category {
    private $db;

    public function __construct() {
        $this->db = DB::createInstance();
    }

    /**
     * Get all categorys ordered by name.
     * @return array List of categorys as objects.
     */
    public function getAll() {
        $sql = "SELECT * 
                FROM category 
                ORDER BY category_name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get a single category by ID.
     * @param int $id
     * @return object|false
     */
    public function getById($id) {
        $sql = "SELECT * FROM category WHERE id_category = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Create a new category.
     * @param string $name
     * @return int|false The ID of the new category or false on failure.
     */
    public function create($name) {
        try {
            $sql = "INSERT INTO category (category_name) VALUES (:name)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':name' => $name]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating category: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update a category.
     * @param int $id
     * @param string $name
     * @return bool True on success.
     */
    public function update($id, $name) {
        try {
            $sql = "UPDATE category 
                    SET category_name = :name 
                    WHERE id_category = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':name' => $name, ':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error updating category: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a category.
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        try {
            $sql = "DELETE FROM category WHERE id_category = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            // Likely a foreign key constraint error (category s depend on this category)
            error_log("Error deleting category: " . $e->getMessage());
            return false;
        }
    }
}