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
*/


// Simple routing mechanism
$requestUri = $_SERVER['REQUEST_URI'];
$requestParts = explode('/', trim($requestUri, '/'));

// Default controller and action
$controllerName = 'DashboardController';
$actionName = 'index';

/*
if (!empty($requestParts[0]) && $requestParts[0] !== 'stage') {
    $controllerName = ucfirst($requestParts[0]) . 'Controller';
}*/

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
