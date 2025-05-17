<?php
require_once '../helpers/JwtHandler.php';

class AuthMiddleware {
    public static function authenticate() {
        $headers = getallheaders();
        if(!isset($headers['Authorization'])) {
            http_response_code(401);
            echo json_encode(['message' => 'Access denied. No token provided.']);
            exit;
        }

        $authHeader = $headers['Authorization'];
        $arr = explode(" ", $authHeader);
        $token = $arr[1] ?? '';

        try {
            $jwt = new JwtHandler();
            $decoded = $jwt->jwtDecode($token);
            return $decoded;
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(['message' => 'Access denied. Invalid token.', 'error' => $e->getMessage()]);
            exit;
        }
    }
}
?>