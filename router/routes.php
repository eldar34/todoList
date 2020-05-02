<?php

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpMethodNotAllowedException;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;

use App\Models\Auth;

function processInput($uri){
    $uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        return $uri;
}

function processOutput($response){
    echo $response;
}

$router = new RouteCollector();

$router->filter('check-auth', function(){   
    
    $auth = new Auth();
    if (!$auth->login()) {
        $response['auth'] = 'logout';
        $response['errors'] = 'Permission denied';
        return json_encode($response);    
    }
      
});

$router->controller('/', 'App\Controllers\\PageController');
$router->controller('/pagination/{page:i}/{sort_param:a}/{sort_type:a}', 'App\Controllers\\PageController');

$router->post('/user-auth', ['App\Controllers\UserController', 'userAuth']);
$router->post('/login', ['App\Controllers\UserController', 'login']);
$router->get('/logout', ['App\Controllers\UserController', 'logout']);

$router->post('/create-task', ['App\Controllers\TaskController', 'createTask']);
$router->post('/read-task', ['App\Controllers\TaskController', 'readTask'], ['before' => 'check-auth']);
$router->post('/update-task', ['App\Controllers\TaskController', 'updateTask'], ['before' => 'check-auth']);
$router->post('/delete-task', ['App\Controllers\TaskController', 'deleteTask'], ['before' => 'check-auth']);


$dispatcher =  new Dispatcher($router->getData());

try {

    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], processInput($_SERVER['REQUEST_URI']));

} catch (HttpRouteNotFoundException $e) {

    var_dump($e->getMessage());
    die();

} catch (HttpMethodNotAllowedException $e) {

    var_dump($e->getMessage());
    die();

}

processOutput($response);