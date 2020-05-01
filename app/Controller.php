<?php

namespace App;

use App\Pagination;

class Controller {

    private $loader;
    private $twig;

    public function __construct()
    {
        $this->loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../views');
        $this->twig = new \Twig\Environment($this->loader);        
    }
   

    public function getIndex()
    {
        $sortFields = ['name', 'status', 'email', 'id'];
        $pagination = new Pagination(3, 'tasks', $sortFields);

        $page = $pagination->get_page();
        $sort_params = $pagination->get_sort_param();
        $sort_type = $pagination->get_sort_type();
        $result = $pagination->get_page_content();
        

        $records = $result['records'];
        $number_of_pages = $result['number_of_pages'];
        
        echo $this->twig->render('index.html', [
            'records' => $records, 
            'number_of_pages' => $number_of_pages,
            'page' => $page,
            'sort_params' => $sort_params,
            'sort_type' => $sort_type
            ]);        
    }

    public function getPagination($page_usr, $sort_param_usr, $sort_type_usr)
    {
        $sortFields = ['name', 'status', 'email', 'id'];
        $pagination = new Pagination(3, 'tasks', $sortFields);
        
        $page = $pagination->get_page($page_usr);
        $sort_params = $pagination->get_sort_param($sort_param_usr);
        $sort_type = $pagination->get_sort_type($sort_type_usr);
        $result = $pagination->get_page_content($page_usr, $sort_param_usr, $sort_type_usr);

        $records = $result['records'];
        $number_of_pages = $result['number_of_pages'];
        
        echo $this->twig->render('index.html', [
            'records' => $records, 
            'number_of_pages' => $number_of_pages,
            'page' => $page,
            'sort_params' => $sort_params,
            'sort_type' => $sort_type
            ]);        
    }

}