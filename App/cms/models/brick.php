<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\CMS\Models
 * 📂 Physical File:   App/cms/models/brick.php
 * 
 * 📝 Description:
 * Model for interacting with the 'bricks' database table.
 * Handles CRUD operations for content blocks.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Database\Connection (via database/connection.php)
 */

require_once __DIR__ . '/../../../database/connection.php';

class Brick {
    private $db;

    public function __construct() {
        $this->db = DB::createInstance();
    }

    /**
     * Get all bricks with their associated media.
     * @return array List of bricks as objects.
     */
    public function getAll() {
        $sql = "SELECT b.*, m.media_path, m.media_path_medium, m.media_path_large 
                FROM bricks b
                LEFT JOIN media_relations mr ON b.id_brick = mr.related_id AND mr.related_table = 'bricks'
                LEFT JOIN media m ON mr.media_id = m.id_media
                ORDER BY b.title ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get a single brick by ID with its image.
     * @param int $id
     * @return object|false
     */
    public function getById($id) {
        $sql = "SELECT b.*, m.media_path, m.media_path_medium, m.media_path_large 
                FROM bricks b
                LEFT JOIN media_relations mr ON b.id_brick = mr.related_id AND mr.related_table = 'bricks'
                LEFT JOIN media m ON mr.media_id = m.id_media
                WHERE b.id_brick = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Get a brick by page name.
     * @param string $pageName
     * @return object|false
     */
    public function getByPage($pageName) {
        $sql = "SELECT b.*, m.media_path, m.media_path_medium, m.media_path_large 
                FROM bricks b
                LEFT JOIN media_relations mr ON b.id_brick = mr.related_id AND mr.related_table = 'bricks'
                LEFT JOIN media m ON mr.media_id = m.id_media
                WHERE b.page_name = :page";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':page' => $pageName]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Create a new brick.
     * @param string $title
     * @param string $description
     * @param string $link
     * @param string $pageName
     * @return int|false The ID of the new brick or false on failure.
     */
    public function create($title, $description, $link, $pageName) {
        try {
            $sql = "INSERT INTO bricks (title, description, link, page_name) 
                    VALUES (:title, :desc, :link, :page)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':title' => $title,
                ':desc' => $description,
                ':link' => $link,
                ':page' => $pageName
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating brick: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update a brick.
     * @param int $id
     * @param string $title
     * @param string $description
     * @param string $link
     * @param string $pageName
     * @return bool True on success.
     */
    public function update($id, $title, $description, $link, $pageName) {
        try {
            $sql = "UPDATE bricks SET 
                        title = :title, 
                        description = :desc, 
                        link = :link, 
                        page_name = :page 
                    WHERE id_brick = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':title' => $title,
                ':desc' => $description,
                ':link' => $link,
                ':page' => $pageName,
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            error_log("Error updating brick: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a brick.
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM bricks WHERE id_brick = :id");
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Get the last brick created or modified
     * @return object|false
     */
    public function getLast() {
        $sql = "SELECT b.*, m.media_path, m.media_path_medium, m.media_path_large 
                FROM bricks b
                LEFT JOIN media_relations mr ON b.id_brick = mr.related_id AND mr.related_table = 'bricks'
                LEFT JOIN media m ON mr.media_id = m.id_media
                ORDER BY b.id_brick DESC
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}


