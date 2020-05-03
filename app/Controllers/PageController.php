<?php

namespace App\Controllers;

use App\Controllers\Controller;

use App\Models\Pagination;

class PageController extends Controller {

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
        
        return $this->twig->render('index.html', [
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

        if($page_usr > $number_of_pages){
            return $this->getError('404');
        }
        
        return $this->twig->render('index.html', [
            'records' => $records, 
            'number_of_pages' => $number_of_pages,
            'page' => $page,
            'sort_params' => $sort_params,
            'sort_type' => $sort_type
            ]);        
    }

    public function getError($errorCode)
    {
        switch($errorCode){
            case '405':
                $code = '405';
                $errorTitle = ' Method Not Allowed';
                $message = 'Requested method not allowed!';
            break;

            default:
                $code = '404';
                $errorTitle = ' Not Found';
                $message = 'Sorry, an error has occured. Requested page not found!';
        }

        return $this->twig->render('error.html', [
            'code' => $code, 
            'errorTitle' => $errorTitle, 
            'message' => $message, 
            ]); 
        

     }

}