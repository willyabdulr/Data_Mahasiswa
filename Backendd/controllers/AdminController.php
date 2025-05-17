<?php
require_once '../config/database.php';
require_once '../middleware/AdminMiddleware.php';
require_once '../models/Admin.php';
require_once '../helpers/ResponseHandler.php';

class AdminController {
    private $admin;

    public function __construct() {
        $this->admin = new Admin();
    }

    public function getAllUsers() {
        $auth = AdminMiddleware::isAdmin();
        $users = $this->admin->getAllUsers();
        ResponseHandler::sendResponse($users);
    }

    public function createUser($data) {
        if (empty($data['username']) || empty($data['password']) || empty($data['role'])) {
            return ResponseHandler::sendError('Username, password, and role are required', 400);
        }

        // Validasi role
        $allowedRoles = ['admin', 'petugas', 'mahasiswa'];
        if (!in_array($data['role'], $allowedRoles)) {
            return ResponseHandler::sendError('Invalid role. Allowed: admin, petugas, mahasiswa', 400);
        }

        try {
            $userId = $this->admin->createUser(
                $data['username'],
                $data['password'],
                $data['role']
            );
            return ResponseHandler::sendResponse(['id' => $userId], 'User created', 201);
        } catch (PDOException $e) {
            return ResponseHandler::sendError('Username already exists', 409);
        }
    }

    // Method lainnya (getAllUsers, deleteUser) tetap seperti sebelumnya

    public function deleteUser($id) {
        $auth = AdminMiddleware::isAdmin();
        
        if(empty($id)) {
            ResponseHandler::sendError('User ID is required', 400);
            return;
        }

        $result = $this->admin->deleteUser($id);
        if($result) {
            ResponseHandler::sendResponse(null, 'User deleted successfully');
        } else {
            ResponseHandler::sendError('Failed to delete user', 500);
        }
    }
}
?>