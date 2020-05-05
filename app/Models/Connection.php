<?php

namespace App\Models;

class Connection {
    
    private $dsn = "";

    private $opt = array(
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
    );

    public function dbConnect(){

        $host= getenv('DB_HOST') !== "" ? getenv('DB_HOST') : 'db';
        $db= getenv('DB_NAME') !== "" ? getenv('DB_NAME') : 'yourdatabase';
        $myname= getenv('DB_USER_NAME') !== "" ? getenv('DB_USER_NAME') : 'eldar';
        $psc= getenv('DB_PASSWORD') !== "" ? getenv('DB_PASSWORD') : 'changepass';

        $this->dsn = "mysql:host=$host;dbname=$db";
        $pdo = new \PDO($this->dsn, $myname, $psc, $this->opt);
        return $pdo;        
    }
}

?>