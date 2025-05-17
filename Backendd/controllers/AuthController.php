<?php
require_once '../models/User.php';
require_once '../helpers/JwtHandler.php';
require_once '../helpers/ResponseHandler.php';

class AuthController {
    private $user;

    public function __construct() {
        $this->user = new User();
    }

    public function login($data) {
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        if(empty($username) || empty($password)) {
            ResponseHandler::sendError('Username and password are required', 400);
            return;
        }

        $user = $this->user->login($username, $password);
        if($user) {
            $jwt = new JwtHandler();
            $token = $jwt->jwtEncode([
                'iss' => JWT_ISSUER,
                'aud' => JWT_AUD,
                'iat' => time(),
                'exp' => time() + (60 * 60 * 24), // 1 day
                'data' => [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role']
                ]
            ]);

            ResponseHandler::sendResponse([
                'token' => $token,
                'user' => [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role']
                ]
            ], 'Login successful');
        } else {
            ResponseHandler::sendError('Invalid username or password', 401);
        }
    }

    public function getProfile($user_id) {
        try {
            // [FIXED] Validasi token
            if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
                return ResponseHandler::sendError('Token not provided', 401);
            }
    
            $token = str_replace('Bearer ', '', $_SERVER['HTTP_AUTHORIZATION']);
            $jwt = new JwtHandler();
            $decoded = $jwt->jwtDecode($token);
    
            // Dapatkan data user
            $user = $this->user->getUserById($decoded->data->id);
            if (!$user) {
                return ResponseHandler::sendError('User not found', 404);
            }
    
            return ResponseHandler::sendResponse($user);
        } catch (Exception $e) {
            return ResponseHandler::sendError('Invalid token', 401);
        }
    }
}
?>