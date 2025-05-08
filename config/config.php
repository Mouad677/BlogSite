<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'blog_db');

// Site configuration
// define('SITE_URL', 'http://localhost/blog_project');
define('SITE_NAME', 'My Awesome Blog');

// Error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();
?>