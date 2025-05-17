<?php
require_once 'User.php';

class Mahasiswa extends User {
    public function getProfile($user_id) {
        $query = "SELECT m.*, u.username, u.role 
                  FROM mahasiswa m 
                  JOIN users u ON m.user_id = u.id 
                  WHERE m.user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAbsensi($mahasiswa_id) {
        $query = "SELECT a.*, mk.nama_matkul, d.nama as nama_dosen 
                  FROM absensi a
                  JOIN mata_kuliah mk ON a.matkul_id = mk.id
                  JOIN dosen d ON a.dosen_id = d.id
                  WHERE a.mahasiswa_id = :mahasiswa_id
                  ORDER BY a.tanggal DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':mahasiswa_id', $mahasiswa_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>