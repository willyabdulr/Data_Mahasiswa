<?php
require_once 'User.php';

class Admin extends User {
    public function getAllUsers() {
        $query = "SELECT id, username, role, created_at FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser($username, $password, $role) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO users (username, password, role) VALUES (:username, :password, :role)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':role', $role);
        return $stmt->execute() ? $this->db->lastInsertId() : false;
    }

    public function deleteUser($id) {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>