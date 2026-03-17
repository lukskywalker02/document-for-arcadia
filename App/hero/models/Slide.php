<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Hero\Models
 * 📂 Physical File:   App/hero/models/Slide.php
 * 
 * 📝 Description:
 * Model for interacting with the 'slides' database table.
 * Handles CRUD operations for carousel slides.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Database\Connection (via database/connection.php)
 * 
 */

require_once __DIR__ . '/../../../database/connection.php';

class Slide {
    private $db;

    public function __construct() {
        $this->db = DB::createInstance();
    }

    /**
     * Get all slides for a specific hero.
     * @param int $heroId
     * @return array List of slides with their media path.
     */
    public function getByHeroId($heroId) {
        // JOIN to get the image URL from media/media_relations
        $sql = "SELECT s.*, m.media_path, m.media_path_medium, m.media_path_large 
                FROM slides s
                LEFT JOIN media_relations mr ON s.id_slide = mr.related_id AND mr.related_table = 'slides'
                LEFT JOIN media m ON mr.media_id = m.id_media
                WHERE s.hero_id = :hero_id
                ORDER BY s.id_slide ASC"; // Or order by a specific order column if added later
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':hero_id' => $heroId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get a single slide by ID.
     * @param int $id
     * @return object|false
     */
    public function getById($id) {
        $sql = "SELECT s.*, m.media_path, m.media_path_medium, m.media_path_large 
                FROM slides s
                LEFT JOIN media_relations mr ON s.id_slide = mr.related_id AND mr.related_table = 'slides'
                LEFT JOIN media m ON mr.media_id = m.id_media
                WHERE s.id_slide = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Create a new slide.
     * @param int $heroId
     * @param string $title
     * @param string $description
     * @return int|false The ID of the new slide or false on failure.
     */
    public function create($heroId, $title, $description) {
        try {
            // Check limit of 5 slides per hero (Optional but requested)
            $currentSlides = $this->getByHeroId($heroId);
            if (count($currentSlides) >= 5) {
                return false; // Limit reached
            }

            $sql = "INSERT INTO slides (hero_id, title_caption, description_caption) 
                    VALUES (:hero_id, :title, :desc)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':hero_id' => $heroId,
                ':title' => $title,
                ':desc' => $description
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating slide: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update a slide.
     * @param int $id
     * @param string $title
     * @param string $description
     * @return bool True on success.
     */
    public function update($id, $title, $description) {
        try {
            $sql = "UPDATE slides SET 
                        title_caption = :title, 
                        description_caption = :desc 
                    WHERE id_slide = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':title' => $title,
                ':desc' => $description,
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            error_log("Error updating slide: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a slide.
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM slides WHERE id_slide = :id");
        return $stmt->execute([':id' => $id]);
    }
    
    /**
     * Count slides for a hero.
     */
    public function countByHero($heroId) {
        $sql = "SELECT COUNT(*) FROM slides WHERE hero_id = :hero_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':hero_id' => $heroId]);
        return $stmt->fetchColumn();
    }
}

