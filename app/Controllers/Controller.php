<?php

namespace App\Controllers;
//

class Controller {

    protected $loader;
    protected $twig;

    function __construct()
    {
        $this->loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../views');
        $this->twig = new \Twig\Environment($this->loader);   
            
    }

}