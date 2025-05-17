<?php
require_once 'User.php';

class Petugas extends User {
    public function getProfile($user_id) {
        $query = "SELECT p.*, u.username, u.role 
                  FROM petugas p 
                  JOIN users u ON p.user_id = u.id 
                  WHERE p.user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function recordAbsensi($data) {
        $query = "INSERT INTO absensi 
                  (mahasiswa_id, matkul_id, dosen_id, tanggal, status, keterangan, petugas_id) 
                  VALUES 
                  (:mahasiswa_id, :matkul_id, :dosen_id, :tanggal, :status, :keterangan, :petugas_id)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':mahasiswa_id', $data['mahasiswa_id']);
        $stmt->bindParam(':matkul_id', $data['matkul_id']);
        $stmt->bindParam(':dosen_id', $data['dosen_id']);
        $stmt->bindParam(':tanggal', $data['tanggal']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':keterangan', $data['keterangan']);
        $stmt->bindParam(':petugas_id', $data['petugas_id']);

        return $stmt->execute();
    }
}
?>