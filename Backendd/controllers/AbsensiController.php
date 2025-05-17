<?php
require_once '../middleware/AuthMiddleware.php';
require_once '../models/Absensi.php';
require_once '../helpers/ResponseHandler.php';

class AbsensiController {
    private $absensi;

    public function __construct() {
        $this->absensi = new Absensi();
    }

    public function getAllAbsensi() {
        $auth = AuthMiddleware::authenticate();
        $absensi = $this->absensi->getAllAbsensi();
        ResponseHandler::sendResponse($absensi);
    }

    public function getAbsensiByDateRange($start_date, $end_date) {
        // [FIXED] Validasi parameter tanggal
    if (empty($_GET['start']) || empty($_GET['end'])) {
        return ResponseHandler::sendError('Start and end date are required', 400);
    }

    try {
        $absensi = $this->absensi->getAbsensiByDateRange(
            $_GET['start'],
            $_GET['end']
        );
        return ResponseHandler::sendResponse($absensi);
    } catch (Exception $e) {
        return ResponseHandler::sendError('Invalid date format', 400);
    }
}
}
?>