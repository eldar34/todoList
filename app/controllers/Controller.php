<?php

namespace App\Controllers;

use App\Models\Pagination;
use App\Models\Auth;
use App\Models\Validate;
use App\Models\CreateRecord;

class Controller {

    private $loader;
    private $twig;

    public function __construct()
    {
        $this->loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../views');
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

    public function postCheckauth()
    {
        $auth = new Auth();
        $reusult = $auth->loginAjax(); //функция входа на сайт 
        return json_encode($reusult);      
    }

    public function postCreatetask()
    {
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
        }
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
        }
        if (isset($_POST['task'])) {
            $task = $_POST['task'];
        }
        
        $result = [];

        $validate = new Validate();
        $validName = $validate->forName('staticName', $name);
        array_push($result, $validName);
        $validEmail = $validate->forEmail('createEmail', $email);
        array_push($result, $validEmail);
        $validTask = $validate->forTask('staticTask', $task);
        array_push($result, $validTask);

        $status_arr = array_column($result, 'status');

        // Checking validation results
        if (in_array('error', $status_arr)) {
            echo json_encode($result);
            exit;
        }else {
            
            $create = new CreateRecord();
            $createReacord =  $create->addRecord($name, $email, $task);
            array_push($result, $createReacord);
            return json_encode($result);
            // echo json_encode($result);
            // exit;
        } 
    }

}