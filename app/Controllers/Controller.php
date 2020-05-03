<?php

namespace App\Controllers;

class Controller {

    protected $loader;
    protected $twig;

    function __construct()
    {
        $this->loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../views');
        $this->twig = new \Twig\Environment($this->loader);   
            
    }

    /**
     * 
     * Helper for print_r result
     * 
     * @param string $var
     * @return string
     */

    protected function pr($var){
        echo "<pre>";
        print_r($var);
        echo "</pre>";
        exit;
    }

}