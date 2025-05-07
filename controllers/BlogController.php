<?php
class BlogController {
    private $postModel;
    private $commentModel;
    private $userModel;
    
    public function __construct() {
        $this->postModel = new Post();
        $this->commentModel = new Comment();
        $this->userModel = new User();
    }
    
    public function index() {
        $posts = $this->postModel->getPosts();
        $data = [
            'posts' => $posts
        ];
        $this->view('blog/index', $data);
    }
    
    public function show($id) {
        $post = $this->postModel->getPostById($id);
        $comments = $this->commentModel->getCommentsByPostId($id);
        
        $data = [
            'post' => $post,
            'comments' => $comments
        ];
        
        $this->view('blog/show', $data);
    }
    
    public function add() {
        if(!isLoggedIn()) {
            redirect('auth/login');
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'title' => trim($_POST['title']),
                'content' => trim($_POST['content']),
                'featured_image' => $this->uploadImage(),
                'status' => trim($_POST['status']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'content_err' => ''
            ];
            
            // Validate title
            if(empty($data['title'])) {
                $data['title_err'] = 'Please enter title';
            }
            
            // Validate content
            if(empty($data['content'])) {
                $data['content_err'] = 'Please enter content';
            }
            
            // Make sure errors are empty
            if(empty($data['title_err']) && empty($data['content_err'])) {
                // Validated
                if($this->postModel->addPost($data)) {
                    flash('post_message', 'Post Added');
                    redirect('blog');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('blog/add', $data);
            }
        } else {
            $data = [
                'title' => '',
                'content' => '',
                'status' => 'draft'
            ];
            
            $this->view('blog/add', $data);
        }
    }
    
    public function edit($id) {
        if(!isLoggedIn()) {
            redirect('auth/login');
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'content' => trim($_POST['content']),
                'featured_image' => $this->uploadImage(),
                'status' => trim($_POST['status']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'content_err' => ''
            ];
            
            // Validate title
            if(empty($data['title'])) {
                $data['title_err'] = 'Please enter title';
            }
            
            // Validate content
            if(empty($data['content'])) {
                $data['content_err'] = 'Please enter content';
            }
            
            // Make sure errors are empty
            if(empty($data['title_err']) && empty($data['content_err'])) {
                // Validated
                if($this->postModel->updatePost($data)) {
                    flash('post_message', 'Post Updated');
                    redirect('user/dashboard');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('blog/edit', $data);
            }
        } else {
            // Get existing post from model
            $post = $this->postModel->getPostById($id);
            
            // Check for owner
            if($post->user_id != $_SESSION['user_id']) {
                redirect('blog');
            }
            
            $data = [
                'id' => $id,
                'title' => $post->title,
                'content' => $post->content,
                'status' => $post->status,
                'featured_image' => $post->featured_image
            ];
            
            $this->view('blog/edit', $data);
        }
    }
    
    public function delete($id) {
        if(!isLoggedIn()) {
            redirect('auth/login');
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get existing post from model
            $post = $this->postModel->getPostById($id);
            
            // Check for owner
            if($post->user_id != $_SESSION['user_id']) {
                redirect('blog');
            }
            
            if($this->postModel->deletePost($id)) {
                flash('post_message', 'Post Removed');
                redirect('user/dashboard');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('blog');
        }
    }
    
    public function addComment($postId) {
        if(!isLoggedIn()) {
            redirect('auth/login');
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'post_id' => $postId,
                'user_id' => $_SESSION['user_id'],
                'content' => trim($_POST['content']),
                'content_err' => ''
            ];
            
            // Validate content
            if(empty($data['content'])) {
                $data['content_err'] = 'Please enter comment text';
            }
            
            // Make sure errors are empty
            if(empty($data['content_err'])) {
                // Validated
                if($this->commentModel->addComment($data)) {
                    flash('comment_message', 'Comment Added');
                    redirect('blog/show/' . $postId);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $post = $this->postModel->getPostById($postId);
                $comments = $this->commentModel->getCommentsByPostId($postId);
                
                $data = [
                    'post' => $post,
                    'comments' => $comments,
                    'content' => $data['content'],
                    'content_err' => $data['content_err']
                ];
                
                $this->view('blog/show', $data);
            }
        } else {
            redirect('blog');
        }
    }
    
    private function uploadImage() {
        $targetDir = "assets/images/uploads/";
        $targetFile = $targetDir . basename($_FILES["featured_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["featured_image"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                flash('post_message', 'File is not an image.', 'alert alert-danger');
                $uploadOk = 0;
            }
        }
        
        // Check file size
        if ($_FILES["featured_image"]["size"] > 500000) {
            flash('post_message', 'Sorry, your file is too large.', 'alert alert-danger');
            $uploadOk = 0;
        }
        
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            flash('post_message', 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.', 'alert alert-danger');
            $uploadOk = 0;
        }
        
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            return '';
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["featured_image"]["tmp_name"], $targetFile)) {
                return $targetFile;
            } else {
                return '';
            }
        }
    }
    
    // Helper function to load views
    private function view($view, $data = []) {
        require_once '../views/' . $view . '.php';
    }
}
?>