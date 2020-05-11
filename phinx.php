<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ );
$dotenv->load();

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/phinxDB/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/phinxDB/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'pgsql',
            'host' => getenv('DB_HOST'),
            'name' => getenv('DB_NAME'),
            'user' => getenv('DB_USER_NAME'),
            'pass' => getenv('DB_PASSWORD'),
            'port' => '5432',
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'pgsql',
            'host' => getenv('DEV_DB_HOST'),
            'name' => getenv('DEV_DB_NAME'),
            'user' => getenv('DEV_DB_USERNAME'),
            'pass' => getenv('DEV_DB_PASSWORD'),
            'port' => '5432',
            'charset' => 'utf8',            
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => getenv('TES_DB_HOST'),
            'name' => getenv('TES_DB_NAME'),
            'user' => getenv('TES_DB_USERNAME'),
            'pass' => getenv('TES_DB_PASSWORD'),
            'port' => '3306',
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
