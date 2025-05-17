<?php
require_once 'AuthMiddleware.php';

class MahasiswaMiddleware {
    public static function isMahasiswa() {
        $auth = AuthMiddleware::authenticate();
        if($auth->data->role !== 'mahasiswa') {
            http_response_code(403);
            echo json_encode(['message' => 'Access denied. Mahasiswa privileges required.']);
            exit;
        }
        return $auth;
    }
}
?>