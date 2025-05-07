<?php
class UserController {
    private $userModel;
    private $postModel;
    
    public function __construct() {
        $this->userModel = new User();
        $this->postModel = new Post();
    }
    
    public function dashboard() {
        if(!isLoggedIn()) {
            redirect('auth/login');
        }
        
        $userId = $_SESSION['user_id'];
        $posts = $this->postModel->getPostsByUserId($userId);
        
        $data = [
            'posts' => $posts
        ];
        
        $this->view('user/dashboard', $data);
    }
    
    public function profile() {
        if(!isLoggedIn()) {
            redirect('auth/login');
        }
        
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->getUserById($userId);
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'id' => $userId,
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'username_err' => '',
                'email_err' => ''
            ];
            
            // Validate username
            if(empty($data['username'])) {
                $data['username_err'] = 'Please enter username';
            }
            
            // Validate email
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } else {
                // Check if email changed
                if($data['email'] != $user->email) {
                    if($this->userModel->findUserByEmail($data['email'])) {
                        $data['email_err'] = 'Email is already taken';
                    }
                }
            }
            
            // Make sure errors are empty
            if(empty($data['username_err']) && empty($data['email_err'])) {
                // Validated
                if($this->userModel->updateProfile($data)) {
                    flash('profile_message', 'Profile Updated');
                    redirect('user/profile');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('user/profile', $data);
            }
        } else {
            $data = [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email
            ];
            
            $this->view('user/profile', $data);
        }
    }
    
    public function changePassword() {
        if(!isLoggedIn()) {
            redirect('auth/login');
        }
        
        $userId = $_SESSION['user_id'];
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'id' => $userId,
                'current_password' => trim($_POST['current_password']),
                'new_password' => trim($_POST['new_password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'current_password_err' => '',
                'new_password_err' => '',
                'confirm_password_err' => ''
            ];
            
            // Validate current password
            if(empty($data['current_password'])) {
                $data['current_password_err'] = 'Please enter current password';
            } else {
                $user = $this->userModel->getUserById($userId);
                if(!password_verify($data['current_password'], $user->password)) {
                    $data['current_password_err'] = 'Current password is incorrect';
                }
            }
            
            // Validate new password
            if(empty($data['new_password'])) {
                $data['new_password_err'] = 'Please enter new password';
            } elseif(strlen($data['new_password']) < 6) {
                $data['new_password_err'] = 'Password must be at least 6 characters';
            }
            
            // Validate confirm password
            if(empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if($data['new_password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }
            
            // Make sure errors are empty
            if(empty($data['current_password_err']) && empty($data['new_password_err']) && 
               empty($data['confirm_password_err'])) {
                
                // Hash password
                $data['password'] = password_hash($data['new_password'], PASSWORD_DEFAULT);
                
                // Change password
                if($this->userModel->changePassword($data)) {
                    flash('profile_message', 'Password Changed', 'alert alert-success');
                    redirect('user/profile');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $user = $this->userModel->getUserById($userId);
                $data['username'] = $user->username;
                $data['email'] = $user->email;
                $this->view('user/profile', $data);
            }
        } else {
            redirect('user/profile');
        }
    }
    
    // Helper function to load views
    private function view($view, $data = []) {
        require_once '../views/' . $view . '.php';
    }
}
?>