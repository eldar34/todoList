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

        $interimRecords = $result['records'];

        foreach($interimRecords as &$value){                              
            $value['task'] = $this->tagsHelper($value['task']);                  
        }

        // $this->pr($interimRecords);        

        $records = $interimRecords;
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

        $interimRecords = $result['records'];

        foreach($interimRecords as &$value){                              
            $value['task'] = $this->tagsHelper($value['task']);                  
        }

        $records = $interimRecords;
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

            case '503':
                $code = '503';
                $errorTitle = ' Service Unavailable';
                $message = 'Something wrong with connection to Database!';
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

     /**
     * 
     * Helper for fields vith html tags
     * 
     * @param string $stringTag
     * @return string
     */

    private function tagsHelper($stringTag){
        $result = html_entity_decode($stringTag, ENT_QUOTES | ENT_HTML5, "UTF-8");        
        return $result;
     }

}