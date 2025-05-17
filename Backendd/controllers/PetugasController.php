<?php
require_once '../middleware/PetugasMiddleware.php';
require_once '../models/Petugas.php';
require_once '../models/Mahasiswa.php';
require_once '../models/MataKuliah.php';
require_once '../helpers/ResponseHandler.php';

class PetugasController {
    private $petugas;
    private $mahasiswa;
    private $matkul;

    public function __construct() {
        $this->petugas = new Petugas();
        $this->mahasiswa = new Mahasiswa();
        $this->matkul = new MataKuliah();
    }

    public function recordAbsensi($data) {
        $requiredFields = ['mahasiswa_id', 'matkul_id', 'dosen_id', 'tanggal', 'status'];
    foreach ($requiredFields as $field) {
        if (empty($data[$field])) {
            return ResponseHandler::sendError("Field $field is required", 400);
        }
    }

    // Validasi status
    $allowedStatus = ['hadir', 'izin', 'sakit', 'alpa'];
    if (!in_array($data['status'], $allowedStatus)) {
        return ResponseHandler::sendError('Invalid status value', 400);
    }

    try {
        $result = $this->petugas->recordAbsensi($data);
        return ResponseHandler::sendResponse(null, 'Absensi recorded', 201);
    } catch (PDOException $e) {
        return ResponseHandler::sendError('Failed to record attendance', 500);
    }
    }

    public function getMahasiswaList() {
        $auth = PetugasMiddleware::isPetugas();
        // Implementasi untuk mendapatkan daftar mahasiswa
        // (Anda perlu membuat method di model Mahasiswa)
    }

    public function getMatkulList() {
        $auth = PetugasMiddleware::isPetugas();
        $matkul = $this->matkul->getAllMatkul();
        ResponseHandler::sendResponse($matkul);
    }
}
?>