<?php
require_once 'AuthMiddleware.php';

class AdminMiddleware {
    public static function isAdmin() {
        $auth = AuthMiddleware::authenticate();
        if($auth->data->role !== 'admin') {
            http_response_code(403);
            echo json_encode(['message' => 'Access denied. Admin privileges required.']);
            exit;
        }
        return $auth;
    }
}
?>