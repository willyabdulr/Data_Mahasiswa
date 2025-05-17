<?php
require_once '../middleware/MahasiswaMiddleware.php';
require_once '../models/Mahasiswa.php';
require_once '../helpers/ResponseHandler.php';

class MahasiswaController {
    private $mahasiswa;

    public function __construct() {
        $this->mahasiswa = new Mahasiswa();
    }

    public function getProfile($user_id) {
        $auth = MahasiswaMiddleware::isMahasiswa();
        $profile = $this->mahasiswa->getProfile($user_id);
        ResponseHandler::sendResponse($profile);
    }

    public function getAbsensi($mahasiswa_id) {
        try {
            $token = str_replace('Bearer ', '', $_SERVER['HTTP_AUTHORIZATION']);
            $jwt = new JwtHandler();
            $decoded = $jwt->jwtDecode($token);
    
            // Pastikan mahasiswa hanya akses data sendiri
            if ($decoded->data->role !== 'mahasiswa' || $decoded->data->id != $mahasiswa_id) {
                return ResponseHandler::sendError('Unauthorized access', 403);
            }
    
            $absensi = $this->mahasiswa->getAbsensi($mahasiswa_id);
            return ResponseHandler::sendResponse($absensi);
        } catch (Exception $e) {
            return ResponseHandler::sendError('Invalid token', 401);
        }
    }
}
?>