<?php
class AuthController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    public function register() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            
            // Validate username
            if(empty($data['username'])) {
                $data['username_err'] = 'Please enter username';
            }
            
            // Validate email
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } else {
                if($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already taken';
                }
            }
            
            // Validate password
            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif(strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }
            
            // Validate confirm password
            if(empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }
            
            // Make sure errors are empty
            if(empty($data['username_err']) && empty($data['email_err']) && 
               empty($data['password_err']) && empty($data['confirm_password_err'])) {
                
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                
                // Register user
                if($this->userModel->register($data)) {
                    flash('register_success', 'You are registered and can log in');
                    redirect('auth/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('auth/register', $data);
            }
        } else {
            // Init data
            $data = [
                'username' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            
            // Load view
            $this->view('auth/register', $data);
        }
    }
    
    public function login() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];
            
            // Validate email
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            }
            
            // Validate password
            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }
            
            // Check for user/email
            if($this->userModel->findUserByEmail($data['email'])) {
                // User found
            } else {
                $data['email_err'] = 'No user found';
            }
            
            // Make sure errors are empty
            if(empty($data['email_err']) && empty($data['password_err'])) {
                // Validated
                // Check and set logged in user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                
                if($loggedInUser) {
                    // Create session
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Password incorrect';
                    $this->view('auth/login', $data);
                }
            } else {
                // Load view with errors
                $this->view('auth/login', $data);
            }
        } else {
            // Init data
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];
            
            // Load view
            $this->view('auth/login', $data);
        }
    }
    
    public function createUserSession($user) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->username;
        $_SESSION['user_role'] = $user->role;
        
        if($user->role == 'admin') {
            redirect('admin/dashboard');
        } else {
            redirect('user/dashboard');
        }
    }
    
    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        session_destroy();
        redirect('auth/login');
    }
    
    // Helper function to load views
    private function view($view, $data = []) {
        require_once '../views/' . $view . '.php';
    }
}
?>