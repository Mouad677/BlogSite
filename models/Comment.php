<?php
class Comment {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }
    
    // Add comment
    public function addComment($data) {
        $this->db->query('INSERT INTO comments (post_id, user_id, content) VALUES (:post_id, :user_id, :content)');
        $this->db->bind(':post_id', $data['post_id']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':content', $data['content']);
        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Get comments by post ID
    public function getCommentsByPostId($postId) {
        $this->db->query('SELECT comments.*, users.username 
                         FROM comments 
                         INNER JOIN users 
                         ON comments.user_id = users.id 
                         WHERE post_id = :post_id 
                         ORDER BY comments.created_at DESC');
        $this->db->bind(':post_id', $postId);
        return $this->db->resultSet();
    }
    
    // Delete comment
    public function deleteComment($id) {
        $this->db->query('DELETE FROM comments WHERE id = :id');
        $this->db->bind(':id', $id);
        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>