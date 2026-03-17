<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Animals\Models
 * 📂 Physical File:   App/animals/models/animalGeneral.php
 * 
 * 📝 Description:
 * Model for interacting with the 'animal_general' database table.
 * Handles the basic identity of an animal (Name, specie , Gender).
 */

require_once __DIR__ . '/../../../database/connection.php';

class AnimalGeneral
{
    private $db;

    public function __construct()
    {
        $this->db = DB::createInstance();
    }

    /**
     * Get all general animal records with specie  info.
     * @return array List of animals.
     */
    public function getAll()
    {
        $sql = "SELECT ag.*, s.specie_name, c.category_name 
                FROM animal_general ag
                LEFT JOIN specie s ON ag.specie_id = s.id_specie 
                LEFT JOIN category c ON s.category_id = c.id_category
                ORDER BY ag.animal_name ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get a single animal by ID.
     * @param int $id
     * @return object|false
     */
    public function getById($id)
    {
        $sql = "SELECT ag.*, s.specie_name 
                FROM animal_general ag
                LEFT JOIN specie s ON ag.specie_id = s.id_specie 
                WHERE ag.id_animal_g = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Create a new animal general record.
     * @param string $name
     * @param int $specie_id
     * @param string $gender ('male' or 'female')
     * @return int|false The ID of the new record or false on failure.
     */
    public function create($name, $specie_id, $gender)
    {
        try {
            $sql = "INSERT INTO animal_general (animal_name, specie_id, gender) 
                    VALUES (:name, :sid, :gender)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':sid' => $specie_id,
                ':gender' => $gender
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating animal: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update an animal general record.
     * @param int $id
     * @param string $name
     * @param int $specie_id
     * @param string $gender
     * @return bool True on success.
     */
    public function update($id, $name, $specie_id, $gender)
    {
        try {
            $sql = "UPDATE animal_general 
                    SET animal_name = :name, specie_id = :sid, gender = :gender 
                    WHERE id_animal_g = :id";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':name' => $name,
                ':sid' => $specie_id,
                ':gender' => $gender,
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            error_log("Error updating animal: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete an animal general record.
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM animal_general WHERE id_animal_g = :id");
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting animal: " . $e->getMessage());
            return false;
        }
    }
}