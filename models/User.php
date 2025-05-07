<?php
class User {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }
    
    // Register user
    public function register($data) {
        $this->db->query('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Login user
    public function login($email, $password) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        
        $row = $this->db->single();
        
        if($row) {
            $hashed_password = $row->password;
            if(password_verify($password, $hashed_password)) {
                return $row;
            }
        }
        return false;
    }
    
    // Find user by email
    public function findUserByEmail($email) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();
        
        if($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    // Get user by ID
    public function getUserById($id) {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Get all users (for admin)
    public function getAllUsers() {
        $this->db->query('SELECT * FROM users ORDER BY created_at DESC');
        return $this->db->resultSet();
    }
    
    // Update user profile
    public function updateProfile($data) {
        $this->db->query('UPDATE users SET username = :username, email = :email WHERE id = :id');
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':id', $data['id']);
        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Change password
    public function changePassword($data) {
        $this->db->query('UPDATE users SET password = :password WHERE id = :id');
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':id', $data['id']);
        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Add this method to your User class
    public function deleteUser($id) {
        // Prevent deleting yourself
        if($id == $_SESSION['user_id']) {
            return false;
        }
        
        $this->db->query('DELETE FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }

}
?>