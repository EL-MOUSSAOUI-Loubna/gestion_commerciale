<?php

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('VIEW_PATH', APP_PATH . '/views');
define('CONTROLLER_PATH', APP_PATH . '/controllers');
define('MODEL_PATH', APP_PATH . '/models');
define('ROUTING_PATH', APP_PATH . '/routing');
define('CONFIG_PATH', ROOT_PATH . '/config');


require_once CONFIG_PATH . '/db.php';
require_once MODEL_PATH . '/BaseModel.php';
require_once MODEL_PATH . '/ClientModel.php';
require_once CONTROLLER_PATH . '/ClientController.php';
//require_once ROUTING_PATH . '/Router.php';
//require_once ROUTING_PATH . '/routes.php';  // This will contain our route definitions


// Database Connection
$db = databaseConnection();

// Autoload Controllers
spl_autoload_register(function($class) {
    $file = APP_PATH . "/controllers/$class.php";
    if (file_exists($file)) require $file;
});

// Route Handling
$request_uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Strip the "/stage" prefix from the request URI
$request_uri = preg_replace('/\/stage/', '', $request_uri, 1);

// Get the path part (without query string)
$uri_parts = parse_url($request_uri);
$path = $uri_parts['path'];

// Remove trailing slash for consistency (except for root path)
if ($path != '/' && substr($path, -1) == '/') {
    $path = rtrim($path, '/');
}

// Simple Routing Table
$routes = [
    'GET /' => 'DashboardController@index',
    'GET /login' => 'DashboardController@login',
    'GET /clients' => 'ClientController@index',
    'GET /clients/add' => 'ClientController@create',
    'POST /clients/store' => 'ClientController@store',
    'GET /clients/edit' => 'ClientController@edit',
    'POST /clients/update' => 'ClientController@update',
    'POST /clients/delete' => 'ClientController@delete',
    'GET /clients/show' => 'ClientController@show'
];

// Find Matching Route - Using exact match
$route_key = "$method $path";
if (isset($routes[$route_key])) {
    list($controller, $action) = explode('@', $routes[$route_key]);
    (new $controller($db))->$action();
    exit;
}

// 404 if no route matches
header("HTTP/1.0 404 Not Found");
include VIEW_PATH . '/errors/404.php';






/*
$dbConnection = databaseConnection();

new BaseModel($dbConnection);
$clientModel = new ClientModel($dbConnection);

/*
// Debug information - keep this for now
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "Script Name: " . $_SERVER['SCRIPT_NAME'] . "<br>";
echo "PHP Self: " . $_SERVER['PHP_SELF'] . "<br>";
echo "Root Path: " . ROOT_PATH . "<br>";
echo "App Path: " . APP_PATH . "<br>";
echo "View Path: " . VIEW_PATH . "<br>";

// Check if view paths exist
echo "Does layouts/main.php exist? " . (file_exists(VIEW_PATH . '/layouts/main.php') ? 'Yes' : 'No') . "<br>";
echo "Does pages/home.php exist? " . (file_exists(VIEW_PATH . '/pages/home.php') ? 'Yes' : 'No') . "<br>";



// Simple routing mechanism
$requestUri = $_SERVER['REQUEST_URI'];
$requestParts = explode('/', trim($requestUri, '/'));

// Default controller and action
/*$controllerName = 'DashboardController';
$actionName = 'index'; *

// Autoload controllers (simple version)
spl_autoload_register(function ($class) {
    $file = ROOT_PATH . '/app/controllers/' . $class . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// Dispatch request
$router = new Router();
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
*/


/*
if (!empty($requestParts[0]) && $requestParts[0] !== 'stage') {
    $controllerName = ucfirst($requestParts[0]) . 'Controller';
}*/


/*switch ($requestParts[1]) {
    case 'clients':
        switch ($requestParts[2]) {
            case '':
                $controllerName = 'ClientController';
                $actionName = 'index';
                break;
            
            case 'add':
                $controllerName = 'ClientController';
                $actionName = 'create';
                break;

            case 'store':
                $controllerName = 'ClientController';
                $actionName = 'store';
                break;

            case 'edit':
                $controllerName = 'ClientController';
                $actionName = 'edit';
                break;

            case 'update':
                $controllerName = 'ClientController';
                $actionName = 'update';
                break;

            case 'delete':
                $controllerName = 'ClientController';
                $actionName = 'delete';
                break;

            default:
                $controllerName = 'DashboardController';
                $actionName = 'index';
                break;
        }
        break;

    case 'login':
        # code...
        break;

    case '':
        $controllerName = 'DashboardController';
        $actionName = 'index';
    
    default:
        $controllerName = 'DashboardController';
        $actionName = 'index';
        break;
}
*/

/*
if ($requestParts[1] === 'login') {
    $controllerName = 'DashboardController';
}

if (!empty($requestParts[0]) && !empty($requestParts[1]) && $requestParts[1] !== 'login') {
    $controllerPrefix = substr($requestParts[1], 0, -1);
    $controllerName = ucfirst($controllerPrefix) . 'Controller';
}

if (!empty($requestParts[2])) {
    $actionName = $requestParts[2];
} elseif (empty($requestParts[2])) {
    $actionName = 'index';
}

// Include the controller file
$controllerFile = CONTROLLER_PATH . '/' . $controllerName . '.php';
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName();
    if (method_exists($controller, $actionName)) {
        $controller->$actionName();
    } else {
        echo "Action not found: " . $actionName;
    }
} else {
    echo "Controller not found: " . $controllerName;
}
*/