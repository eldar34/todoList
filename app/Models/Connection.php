<?php

namespace App\Models;

use Exception;

class Connection {
    
    private $dsn = "";

    private $opt = array(
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
    );

    public function __construct(){
        set_exception_handler(array($this, 'exception_db'));
    }

    public function exception_db($exception){

        // error_reporting(E_ALL); 
        // ini_set('display_errors', 1);
        // exit;
        echo $exception->getMessage();  
        exit;      

        $host  = $_SERVER['HTTP_HOST'];
        $protocol  = $_SERVER['SERVER_PROTOCOL'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $redirloc = strtolower(
            substr(
                $_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/')
                )
            ).'://';
        header("Location: " . $redirloc . $host . '/error/503');
        
    }

    public function dbConnect(){

        $adapter= getenv('DB_ADAPTER') !== "" ? getenv('DB_ADAPTER') : 'mysql';
        $host= getenv('DB_HOST') !== "" ? getenv('DB_HOST') : 'db';
        $db= getenv('DB_NAME') !== "" ? getenv('DB_NAME') : 'yourdatabase';
        $myname= getenv('DB_USER_NAME') !== "" ? getenv('DB_USER_NAME') : 'eldar';
        $psc= getenv('DB_PASSWORD') !== "" ? getenv('DB_PASSWORD') : 'changepass';

        $this->dsn = $adapter . ":host=$host;dbname=$db";       

        try {
            $pdo = new \PDO($this->dsn, $myname, $psc, $this->opt);
        } catch (\PDOException $e) {           
            // echo "<pre>";
            // print_r($e->getMessage());
            // echo "</pre>";
            // exit;    
            return $pdo;       
        }

        // throw new Exception('gfgf');
        
        return $pdo;        
    }
}

?>