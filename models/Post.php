<?php
class Post {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }
    
    // Get all posts
    public function getPosts() {
        $this->db->query('SELECT *, 
                         posts.id as postId, 
                         users.id as userId 
                         FROM posts 
                         INNER JOIN users 
                         ON posts.user_id = users.id 
                         ORDER BY posts.created_at DESC');
        return $this->db->resultSet();
    }
    
    // Get post by ID
    public function getPostById($id) {
        $this->db->query('SELECT *, 
                         posts.id as postId, 
                         users.id as userId 
                         FROM posts 
                         INNER JOIN users 
                         ON posts.user_id = users.id 
                         WHERE posts.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Add post
    public function addPost($data) {
        $this->db->query('INSERT INTO posts (user_id, title, slug, content, featured_image, status) 
                         VALUES (:user_id, :title, :slug, :content, :featured_image, :status)');
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':slug', $this->createSlug($data['title']));
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':featured_image', $data['featured_image']);
        $this->db->bind(':status', $data['status']);
        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Update post
    public function updatePost($data) {
        $this->db->query('UPDATE posts SET 
                         title = :title,
                         slug = :slug,
                         content = :content,
                         featured_image = :featured_image,
                         status = :status
                         WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':slug', $this->createSlug($data['title']));
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':featured_image', $data['featured_image']);
        $this->db->bind(':status', $data['status']);
        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Delete post
    public function deletePost($id) {
        $this->db->query('DELETE FROM posts WHERE id = :id');
        $this->db->bind(':id', $id);
        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Create URL slug
    private function createSlug($string) {
        $slug = strtolower(trim($string));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', "-", $slug);
        return $slug;
    }
    
    // Get posts by user ID
    public function getPostsByUserId($userId) {
        $this->db->query('SELECT * FROM posts WHERE user_id = :user_id ORDER BY created_at DESC');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }
}
?>