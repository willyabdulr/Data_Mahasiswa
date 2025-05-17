<?php
require_once '../config/database.php';

class MataKuliah {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAllMatkul() {
        $query = "SELECT * FROM mata_kuliah ORDER BY nama_matkul";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMatkulById($id) {
        $query = "SELECT * FROM mata_kuliah WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>