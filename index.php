<?php
// Initialize the application
define('SITE_URL', 'http://'.$_SERVER['HTTP_HOST'].'/blog_project');
require_once 'config/config.php';
require_once 'helpers.php';

// Autoload Core Libraries
spl_autoload_register(function($className) {
    require_once 'models/' . $className . '.php';
});

// Get URL parameters
$url = isset($_GET['url']) ? $_GET['url'] : 'home';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Route the request
$controllerName = ucfirst($url[0]) . 'Controller';
$actionName = isset($url[1]) ? $url[1] : 'index';
$params = array_slice($url, 2);

// Check if controller file exists
$controllerFile = 'controllers/' . $controllerName . '.php';
if(file_exists($controllerFile)) {
    require_once $controllerFile;
    
    // Instantiate controller
    $controller = new $controllerName;
    
    // Check if method exists
    if(method_exists($controller, $actionName)) {
        // Call the method with parameters if any
        if(!empty($params)) {
            call_user_func_array([$controller, $actionName], $params);
        } else {
            $controller->$actionName();
        }
    } else {
        // Method doesn't exist
        require_once 'views/errors/404.php';
    }
} else {
    // Controller doesn't exist
    require_once 'views/errors/404.php';
}
?>