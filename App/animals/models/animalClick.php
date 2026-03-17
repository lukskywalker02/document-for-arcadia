<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Animals\Models
 * 📂 Physical File:   App/animals/models/animalClick.php
 * 
 * 📝 Description:
 * Model for interacting with the 'animal_clicks' database table.
 * Handles click statistics for animals aggregated by month and year.
 */

require_once __DIR__ . '/../../../database/connection.php';

class AnimalClick
{
    private $db;

    public function __construct()
    {
        $this->db = DB::createInstance();
    }

    /**
     * Register or increment a click for an animal in the current month/year.
     * Uses INSERT ... ON DUPLICATE KEY UPDATE to handle monthly aggregation.
     * 
     * @param int $animal_g_id The ID of the animal
     * @return bool True on success
     */
    public function registerClick($animal_g_id)
    {
        try {
            $year = (int)date('Y');
            $month = (int)date('n'); // 1-12 without leading zeros

            $sql = "INSERT INTO animal_clicks (animal_g_id, year, month, click_count) 
                    VALUES (:animal_id, :year, :month, 1)
                    ON DUPLICATE KEY UPDATE 
                    click_count = click_count + 1,
                    updated_at = CURRENT_TIMESTAMP";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':animal_id' => $animal_g_id,
                ':year' => $year,
                ':month' => $month
            ]);
        } catch (PDOException $e) {
            error_log("Error registering click: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all click statistics with animal information.
     * 
     * @return array List of click records with animal details
     */
    public function getAllStats()
    {
        $sql = "SELECT ac.*, ag.animal_name, s.specie_name, c.category_name
                FROM animal_clicks ac
                INNER JOIN animal_general ag ON ac.animal_g_id = ag.id_animal_g
                LEFT JOIN specie s ON ag.specie_id = s.id_specie
                LEFT JOIN category c ON s.category_id = c.id_category
                ORDER BY ac.year DESC, ac.month DESC, ac.click_count DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get statistics for a specific animal.
     * 
     * @param int $animal_g_id
     * @return array List of click records for the animal
     */
    public function getStatsByAnimal($animal_g_id)
    {
        $sql = "SELECT ac.*, ag.animal_name
                FROM animal_clicks ac
                INNER JOIN animal_general ag ON ac.animal_g_id = ag.id_animal_g
                WHERE ac.animal_g_id = :animal_id
                ORDER BY ac.year DESC, ac.month DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':animal_id' => $animal_g_id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get statistics for the current month.
     * 
     * @return array List of click records for current month
     */
    public function getCurrentMonthStats()
    {
        $year = (int)date('Y');
        $month = (int)date('n');

        $sql = "SELECT ac.*, ag.animal_name, s.specie_name, c.category_name
                FROM animal_clicks ac
                INNER JOIN animal_general ag ON ac.animal_g_id = ag.id_animal_g
                LEFT JOIN specie s ON ag.specie_id = s.id_specie
                LEFT JOIN category c ON s.category_id = c.id_category
                WHERE ac.year = :year AND ac.month = :month
                ORDER BY ac.click_count DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':year' => $year,
            ':month' => $month
        ]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get statistics for the last N months.
     * 
     * @param int $months Number of months to retrieve (default: 6)
     * @return array List of click records
     */
    public function getLastMonthsStats($months = 6)
    {
        $sql = "SELECT ac.*, ag.animal_name, s.specie_name, c.category_name
                FROM animal_clicks ac
                INNER JOIN animal_general ag ON ac.animal_g_id = ag.id_animal_g
                LEFT JOIN specie s ON ag.specie_id = s.id_specie
                LEFT JOIN category c ON s.category_id = c.id_category
                WHERE (ac.year * 12 + ac.month) >= (YEAR(CURDATE()) * 12 + MONTH(CURDATE()) - :months)
                ORDER BY ac.year DESC, ac.month DESC, ac.click_count DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':months' => $months]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get total clicks for all animals (sum of all click_count).
     * 
     * @return int Total number of clicks
     */
    public function getTotalClicks()
    {
        $sql = "SELECT SUM(click_count) as total FROM animal_clicks";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return (int)($result->total ?? 0);
    }

    /**
     * Get top N animals by clicks (all time).
     * 
     * @param int $limit Number of top animals to return (default: 10)
     * @return array List of top animals
     */
    public function getTopAnimals($limit = 10)
    {
        $sql = "SELECT 
                    ac.animal_g_id,
                    ag.animal_name,
                    s.specie_name,
                    c.category_name,
                    SUM(ac.click_count) as total_clicks
                FROM animal_clicks ac
                INNER JOIN animal_general ag ON ac.animal_g_id = ag.id_animal_g
                LEFT JOIN specie s ON ag.specie_id = s.id_specie
                LEFT JOIN category c ON s.category_id = c.id_category
                GROUP BY ac.animal_g_id, ag.animal_name, s.specie_name, c.category_name
                ORDER BY total_clicks DESC
                LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}

