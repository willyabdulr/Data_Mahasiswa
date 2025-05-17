<?php
require_once 'AuthMiddleware.php';

class PetugasMiddleware {
    public static function isPetugas() {
        $auth = AuthMiddleware::authenticate();
        if($auth->data->role !== 'petugas') {
            http_response_code(403);
            echo json_encode(['message' => 'Access denied. Petugas privileges required.']);
            exit;
        }
        return $auth;
    }
}
?>