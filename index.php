<?php

require_once __DIR__ . '/vendor/autoload.php';

if(!getenv('LOCAL_ENV')){
    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ );
    $dotenv->load();
}

require_once __DIR__ . '/router/routes.php';

?>

