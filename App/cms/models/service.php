<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\CMS\Models
 * 📂 Physical File:   App/cms/models/service.php
 * 
 * 📝 Description:
 * Model for interacting with the 'services' database table.
 * Handles CRUD operations and audit logging.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Database\Connection (via database/connection.php)
 */

require_once __DIR__ . '/../../../database/connection.php';

class Service {
    private $db;

    public function __construct() {
        $this->db = DB::createInstance();
    }

    /**
     * Get all services with their associated media.
     * @return array List of services as objects.
     */
    public function getAll() {
        // JOIN with media_relations and media to get the image URL
        $sql = "SELECT s.*, m.media_path, m.media_path_medium, m.media_path_large 
                FROM services s
                LEFT JOIN media_relations mr ON s.id_service = mr.related_id AND mr.related_table = 'services'
                LEFT JOIN media m ON mr.media_id = m.id_media
                ORDER BY s.service_title ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get only featured services for the homepage.
     * @return array List of featured services.
     */
    public function getFeatured() {
        $sql = "SELECT s.*, m.media_path, m.media_path_medium, m.media_path_large 
                FROM services s
                LEFT JOIN media_relations mr ON s.id_service = mr.related_id AND mr.related_table = 'services'
                LEFT JOIN media m ON mr.media_id = m.id_media
                WHERE s.type = 'featured'
                ORDER BY s.id_service ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get only services of type 'habitat'.
     * @return array List of habitat services.
     */
    public function getHabitats() {
        $sql = "SELECT s.*, m.media_path, m.media_path_medium, m.media_path_large 
                FROM services s
                LEFT JOIN media_relations mr ON s.id_service = mr.related_id AND mr.related_table = 'services'
                LEFT JOIN media m ON mr.media_id = m.id_media
                WHERE s.type = 'habitat'
                ORDER BY s.service_title ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get only non-featured services for the main services page.
     * @return array List of regular services.
     */
    public function getRegularServices() {
        $sql = "SELECT s.*, m.media_path, m.media_path_medium, m.media_path_large 
                FROM services s
                LEFT JOIN media_relations mr ON s.id_service = mr.related_id AND mr.related_table = 'services'
                LEFT JOIN media m ON mr.media_id = m.id_media
                WHERE s.type = 'service'
                ORDER BY s.service_title ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get a single service by ID.
     * @param int $id
     * @return object|false
     */
    public function getById($id) {
        $sql = "SELECT s.*, m.media_path, m.media_path_medium, m.media_path_large 
                FROM services s
                LEFT JOIN media_relations mr ON s.id_service = mr.related_id AND mr.related_table = 'services'
                LEFT JOIN media m ON mr.media_id = m.id_media
                WHERE s.id_service = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Create a new service and log the action.
     * @param string $title
     * @param string $description
     * @param string $link
     * @param string $type
     * @param int $userId
     * @return int|false The ID of the new service or false on failure
     */
    public function create($title, $description, $link, $type, $userId) {
        try {
            // STEP 1: START TRANSACTION
            // Ensure data integrity by wrapping operations in a transaction.
            $this->db->beginTransaction();

            // STEP 2: INSERT SERVICE
            // Insert the main service record into the database.
            $sql = "INSERT INTO services (service_title, service_description, link, type) VALUES (:title, :desc, :link, :type)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':title' => $title, ':desc' => $description, ':link' => $link, ':type' => $type]);
            $serviceId = $this->db->lastInsertId();

            // STEP 3: LOG ACTION
            // Record the creation event in the audit log.
            $this->logChange($serviceId, $userId, 'create', null, 'New Service Created', $title);

            // STEP 4: COMMIT TRANSACTION
            // If all operations succeeded, commit changes to the database.
            $this->db->commit();
            return $serviceId;

        } catch (Exception $e) {
            // ROLLBACK ON FAILURE
            // If any operation fails, revert all changes to maintain data consistency.
            $this->db->rollBack();
            error_log("Error creating service: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update an existing service and log specific changes.
     * @param int $id Service ID
     * @param string $title New title
     * @param string $description New description
     * @param int $userId ID of the user making the change
     * @return bool True on success
     */
    public function update($id, $title, $description, $link, $type, $userId) {
        try {
            // Get current data to compare
            $current = $this->getById($id);
            if (!$current) return false;

            $this->db->beginTransaction();

            // Check and log Title change
            if ($current->service_title !== $title) {
                $this->logChange($id, $userId, 'update', 'service_title', $current->service_title, $title);
            }

            // Check and log Description change
            if ($current->service_description !== $description) {
                $this->logChange($id, $userId, 'update', 'service_description', $current->service_description, $description);
            }

            // Execute Update
            $sql = "UPDATE services SET service_title = :title, service_description = :desc, link = :link, type = :type WHERE id_service = :id";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([':title' => $title, ':desc' => $description, ':link' => $link, ':type' => $type, ':id' => $id]);

            $this->db->commit();
            return $result;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error updating service: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Helper to log changes in service_logs table.
     */
    private function logChange($serviceId, $userId, $action, $fieldName, $oldVal, $newVal) {
        $sql = "INSERT INTO service_logs (service_id, changed_by, action, field_name, previous_value, new_value) 
                VALUES (:sid, :uid, :action, :field, :old, :new)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':sid' => $serviceId,
            ':uid' => $userId,
            ':action' => $action,
            ':field' => $fieldName, // Can be NULL for creates
            ':old' => (string)$oldVal, // Cast to string to avoid errors if null
            ':new' => (string)$newVal
        ]);
    }
    
    /**
     * Delete a service.
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM services WHERE id_service = :id");
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Get all service change logs.
     * @return array List of log records.
     */
    public function getLogs() {
        $sql = "SELECT 
                    sl.change_date,
                    s.service_title,
                    u.username,
                    sl.action,
                    sl.field_name,
                    sl.previous_value,
                    sl.new_value
                FROM service_logs sl
                LEFT JOIN services s ON sl.service_id = s.id_service
                LEFT JOIN users u ON sl.changed_by = u.id_user
                ORDER BY sl.change_date DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get the last service created or modified
     * @return object|false
     */
    public function getLast() {
        $sql = "SELECT s.*, m.media_path, m.media_path_medium, m.media_path_large 
                FROM services s
                LEFT JOIN media_relations mr ON s.id_service = mr.related_id AND mr.related_table = 'services'
                LEFT JOIN media m ON mr.media_id = m.id_media
                ORDER BY s.id_service DESC
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Get the last service log entry
     * @return object|false
     */
    public function getLastLog() {
        $sql = "SELECT sl.*, s.service_title, u.username
                FROM service_logs sl
                LEFT JOIN services s ON sl.service_id = s.id_service
                LEFT JOIN users u ON sl.changed_by = u.id_user
                ORDER BY sl.change_date DESC
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}

