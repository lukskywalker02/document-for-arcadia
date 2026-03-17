<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Hero\Models
 * 📂 Physical File:   App/hero/models/Hero.php
 * 
 * 📝 Description:
 * Model for interacting with the 'heroes' database table.
 * Handles CRUD operations for header/hero sections.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Database\Connection (via database/connection.php)
 * 
 */

require_once __DIR__ . '/../../../database/connection.php';

class Hero {
    private $db;

    public function __construct() {
        $this->db = DB::createInstance();
    }

    /**
     * Get all heroes with their associated main image.
     * @return array List of heroes as objects.
     */
    public function getAll() {
        $sql = "SELECT h.*, m.media_path, m.media_path_medium, m.media_path_large 
                FROM heroes h
                LEFT JOIN media_relations mr ON h.id_hero = mr.related_id AND mr.related_table = 'heroes'
                LEFT JOIN media m ON mr.media_id = m.id_media
                ORDER BY h.hero_title ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get a single hero by ID with its image.
     * @param int $id
     * @return object|false
     */
    public function getById($id) {
        $sql = "SELECT h.*, m.media_path, m.media_path_medium, m.media_path_large 
                FROM heroes h
                LEFT JOIN media_relations mr ON h.id_hero = mr.related_id AND mr.related_table = 'heroes'
                LEFT JOIN media m ON mr.media_id = m.id_media
                WHERE h.id_hero = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Get a hero by its page name (identifier) with its image.
     * @param string $pageName (e.g. 'home', 'about')
     * @return object|false
     */
    public function getByPage($pageName) {
        $sql = "SELECT h.*, m.media_path, m.media_path_medium, m.media_path_large 
                FROM heroes h
                LEFT JOIN media_relations mr ON h.id_hero = mr.related_id AND mr.related_table = 'heroes'
                LEFT JOIN media m ON mr.media_id = m.id_media
                WHERE h.page_name = :page AND h.habitat_id IS NULL";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':page' => $pageName]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Get a hero by habitat ID with its image.
     * @param int $habitatId
     * @return object|false
     */
    public function getByHabitatId($habitatId) {
        $sql = "SELECT h.*, m.media_path, m.media_path_medium, m.media_path_large 
                FROM heroes h
                LEFT JOIN media_relations mr ON h.id_hero = mr.related_id AND mr.related_table = 'heroes'
                LEFT JOIN media m ON mr.media_id = m.id_media
                WHERE h.habitat_id = :habitat_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':habitat_id' => $habitatId]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Create a new hero.
     * @param string $title
     * @param string|null $subtitle
     * @param string $pageName
     * @param bool $hasCarousel
     * @param int|null $habitatId Optional habitat ID for habitat-specific heroes
     * @return int|false The ID of the new hero or false on failure.
     */
    public function create($title, $subtitle, $pageName, $hasCarousel, $habitatId = null) {
        try {
            $sql = "INSERT INTO heroes (hero_title, hero_subtitle, page_name, has_sliders, habitat_id) 
                    VALUES (:title, :subtitle, :page, :has_carousel, :habitat_id)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':title' => $title,
                ':subtitle' => $subtitle,
                ':page' => $pageName,
                ':has_carousel' => $hasCarousel ? 1 : 0,
                ':habitat_id' => $habitatId
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating hero: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update a hero.
     * @param int $id
     * @param string $title
     * @param string|null $subtitle
     * @param string $pageName
     * @param bool $hasCarousel
     * @param int|null $habitatId Optional habitat ID for habitat-specific heroes
     * @return bool True on success.
     */
    public function update($id, $title, $subtitle, $pageName, $hasCarousel, $habitatId = null) {
        try {
            $sql = "UPDATE heroes SET 
                        hero_title = :title, 
                        hero_subtitle = :subtitle, 
                        page_name = :page,
                        has_sliders = :has_carousel,
                        habitat_id = :habitat_id
                    WHERE id_hero = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':title' => $title,
                ':subtitle' => $subtitle,
                ':page' => $pageName,
                ':has_carousel' => $hasCarousel ? 1 : 0,
                ':habitat_id' => $habitatId,
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            error_log("Error updating hero: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a hero.
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM heroes WHERE id_hero = :id");
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Get the last hero/page header created or modified
     * @return object|false
     */
    public function getLast() {
        $sql = "SELECT h.*, m.media_path, m.media_path_medium, m.media_path_large 
                FROM heroes h
                LEFT JOIN media_relations mr ON h.id_hero = mr.related_id AND mr.related_table = 'heroes'
                LEFT JOIN media m ON mr.media_id = m.id_media
                ORDER BY h.id_hero DESC
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
