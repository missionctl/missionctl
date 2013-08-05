<?php
    // Capture request
    if(isset($_GET['request'])) {
        $request = $_GET['request'];
    } else {
        $request = 'page/display/home';
    }

    // Define path constants
    define('APPROOT', dirname(__FILE__));
    define('WEBROOT', rtrim('http://' . $_SERVER['HTTP_HOST'] . 
        str_replace($request, '', $_SERVER['REQUEST_URI']), '/'));

    // Set up autoloading
    spl_autoload_register(function($class) {
        $class = APPROOT . '/app/classes/' . $class . '.php';

        if(file_exists($class)) {
            require_once($class);
        } else {
            // TODO: Make this pretty
            die('Required class not found: ' . $class);
        }
    });

    // Parse request
    $parts = explode('/', $request);
    $model = $parts[0];
    $action = $parts[1];
    $params = array_splice($parts, 2);

    // Handle request
    $page = APPROOT . '/app/models/' . $model . '/' . $action . '.php';

    if(file_exists($page)) {
        require_once($page);
    } else {
        die('Required page not found: ' . $page);
    }
?>