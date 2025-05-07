<?php
class AdminController {
    private $userModel;
    private $postModel;
    
    public function __construct() {
        $this->userModel = new User();
        $this->postModel = new Post();
    }
    
    public function dashboard() {
        if(!isAdmin()) {
            redirect('blog');
        }
        
        $usersCount = count($this->userModel->getAllUsers());
        $postsCount = count($this->postModel->getPosts());
        
        $data = [
            'users_count' => $usersCount,
            'posts_count' => $postsCount
        ];
        
        $this->view('admin/dashboard', $data);
    }
    
    public function users() {
        if(!isAdmin()) {
            redirect('blog');
        }
        
        $users = $this->userModel->getAllUsers();
        
        $data = [
            'users' => $users
        ];
        
        $this->view('admin/users', $data);
    }
    
    public function posts() {
        if(!isAdmin()) {
            redirect('blog');
        }
        
        $posts = $this->postModel->getPosts();
        
        $data = [
            'posts' => $posts
        ];
        
        $this->view('admin/posts', $data);
    }
    
    public function deleteUser($id) {
        if(!isAdmin()) {
            redirect('blog');
        }
        
        // Prevent CSRF attacks
        if($_SERVER['REQUEST_METHOD'] == 'POST') {  
            try {
                if($this->userModel->deleteUser($id)) {
                    flash('admin_message', 'User successfully deleted', 'alert alert-success');
                } else {
                    flash('admin_message', 'Failed to delete user or you tried to delete yourself', 'alert alert-danger');
                }
            } catch (PDOException $e) {
                flash('admin_message', 'Error: ' . $e->getMessage(), 'alert alert-danger');
            }
            
            redirect('admin/users');
        } else {
            // If not POST request, redirect
            redirect('admin/users');
        }
    }
    
    // Helper function to load views
    private function view($view, $data = []) {
        require_once '../views/' . $view . '.php';
    }
}
?>