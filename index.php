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
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <!-- Metadata -->
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Document</title>

        <!-- Styles -->
        <link rel="stylesheet" href="lib/vendors/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="lib/vendors/font-awesome/css/font-awesome.css" />
        <link rel="stylesheet" href="web/styles/master.css" />

        <!-- Scripts -->
        <script src="lib/vendors/jquery/jquery.min.js"></script>
        <script src="lib/vendors/bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <button type="button" class="navbar-toggle">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="nav-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">Robot <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Manage...</a></li>
                            </ul>
                        <li><a href="#">Status</a></li>
                        <li><a href="#">Control</a></li>
                        <li><a href="#">Params</a></li>
                        <li><a href="#">Topics</a></li>
                        <li><a href="#">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <header class="container">
            <h1>MissionCTL <small>Control your ROS robot via the web</small></h1>
        </header>
        <section class="container">
            <?php 
                if(file_exists($page)) {
                    require_once($page);
                } else {
                    // TODO: Make this pretty
                    die('Required page not found: ' . $page);
                }
            ?>     
        </section>
    </body>
</html>