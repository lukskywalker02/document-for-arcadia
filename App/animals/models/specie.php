<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Animals\Models
 * 📂 Physical File:   App/animals/models/specie.php
 * 
 * 📝 Description:
 * Model for interacting with the 'specie ' database table.
 * Handles CRUD operations for animal specie s (Lion, Tiger, etc.).
 */

require_once __DIR__ . '/../../../database/connection.php';

class specie
{
    private $db;

    public function __construct()
    {
        $this->db = DB::createInstance();
    }

    /**
     * Get all species with their category name.
     * @return array List of specie s as objects.
     */
    public function getAll()
    {
        $sql = "SELECT s.*, c.category_name 
                FROM specie s
                LEFT JOIN category c ON s.category_id = c.id_category
                ORDER BY s.specie_name ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get a single species by its unique ID.
     * @param int $id
     * @return object|false
     */
    public function getById($id)
    {
        // Consultamos la tabla 'specie' para un animal concreto
        $sql = "SELECT * FROM specie s 
                WHERE s.id_specie = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Get ALL species that belong to a specific category.
     * @param int $categoryId
     * @return array
     */
    public function getByCategoryId($categoryId)
    {
        // ¡IMPORTANTE!: Consultamos 'specie', no 'category'.
        // Queremos los animales que tienen ese 'category_id'.
        $sql = "SELECT * FROM specie s 
                WHERE s.category_id = :cid 
                ORDER BY s.specie_name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':cid' => $categoryId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Create a new species.
     * @param int $categoryId  <-- Esto es lo que une al animal con su grupo (Mamíferos, etc.)
     * @param string $name     <-- El nombre del animal (León, Tigre...)
     * @return int|false The ID of the new species or false on failure.
     */
    public function create($categoryId, $name)
    {
        try {
            // We use 'category_id' that is the foreign key in our 'specie' table
            $sql = "INSERT INTO specie (category_id, specie_name) 
                    VALUES (:cid, :name)";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':cid' => $categoryId,
                ':name' => $name
            ]);

            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating species: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update a species record.
     * @param int $id           <-- El ID único del animal (id_specie)
     * @param int $categoryId   <-- El ID del grupo (Mamífero, Ave...)
     * @param string $name      <-- El nombre (León, Tigre...)
     * @return bool
     */
    public function update($id, $categoryId, $name)
    {
        try {
            // Update the name and its category using the main ID
            $sql = "UPDATE specie s
                    SET category_id = :cid, 
                        specie_name = :name 
                    WHERE id_specie = :id";
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':cid' => $categoryId, 
                ':name' => $name, 
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            error_log("Error updating species: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a specie .
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        try {
            $sql = "DELETE FROM specie WHERE id_specie = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([":id" => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting specie : " . $e->getMessage());
            return false;
        }
    }
}
