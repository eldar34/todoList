<?php

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpMethodNotAllowedException;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;

use App\Controller;

function processInput($uri){
    $uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        return $uri;
}

function processOutput($response){
    echo $response;
}


$router = new RouteCollector();

$router->controller('/', 'App\\Controller');

// $router->get('/', function(){
//     global $loader, $twig;

//     $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../views');
//     $twig = new \Twig\Environment($loader);
   
//     echo $twig->render('index.html', ['name' => 'Fabien']);
// });

$router->post('/resource/test', function(){
    $result = [];
    $first = ['status' => 'success', 'field' => 'staticName'];
    array_push($result, $first);
    $second = ['status' => 'error', 'field' => 'staticEmail'];
    array_push($result, $second);
    
    return json_encode($result);
});

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