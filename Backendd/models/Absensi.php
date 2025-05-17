<?php
require_once '../config/database.php';

class Absensi {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAllAbsensi() {
        $query = "SELECT a.*, m.nama as nama_mahasiswa, mk.nama_matkul, d.nama as nama_dosen, p.nama as nama_petugas
                  FROM absensi a
                  JOIN mahasiswa m ON a.mahasiswa_id = m.id
                  JOIN mata_kuliah mk ON a.matkul_id = mk.id
                  JOIN dosen d ON a.dosen_id = d.id
                  LEFT JOIN petugas p ON a.petugas_id = p.id
                  ORDER BY a.tanggal DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAbsensiByDateRange($start_date, $end_date) {
        $query = "SELECT a.*, m.nama as nama_mahasiswa, mk.nama_matkul, d.nama as nama_dosen
                  FROM absensi a
                  JOIN mahasiswa m ON a.mahasiswa_id = m.id
                  JOIN mata_kuliah mk ON a.matkul_id = mk.id
                  JOIN dosen d ON a.dosen_id = d.id
                  WHERE a.tanggal BETWEEN :start_date AND :end_date
                  ORDER BY a.tanggal DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>