<?php

namespace App;

use App\Connection;

class Pagination
{
    private $num;
    private $tableName;
    private $sortFields;

    public function __construct($num, $tableName, $sortFields)
    {
        $this->num = $num;
        $this->tableName = $tableName;
        $this->sortFields = $sortFields;
    }

    public function get_page(){

        if(!isset($_GET['page'])){
            $page = 1;
            return $page;
          }else{          
            if(intval($_GET['page'])){
              $page = intval($_GET['page']);
              return $page;
            }else{
              $page = 1;
              return $page;
            }
          }
    }

    public function get_sort_param(){

      if(!isset($_GET['sort_param'])){
        $sort_param = 'id';
        return $sort_param;
      }else{
        $paramsArray = $this->sortFields;
        $sort_param = $_GET['sort_param'];       
        if(in_array($sort_param, $paramsArray)){
          $validParam = $sort_param;
          return $validParam;
        }else{
          $validParam = 'id';
          return $validParam;
        }
      }

    }

    public function get_sort_type(){

      if(!isset($_GET['sort_type'])){
        $sort_type = 'ASC';
        return $sort_type;
      }else{
        $paramsArray = ['ASC', 'DESC'];
        $sort_type = $_GET['sort_type'];       
        if(in_array($sort_type, $paramsArray)){
          $validParam = $sort_type;
          return $validParam;
        }else{
          $validParam = 'ASC';
          return $validParam;
        }
      }

    }

    public function get_page_content(){

        $connection = new Connection();
        $pdo = $connection->dbConnect();        

        $result4 = $pdo->query("SELECT * FROM " . $this->tableName);
        
        $page = $this->get_page();
        $sort_param = $this->get_sort_param();
        $sort_type = $this->get_sort_type();
        $this_page_first_result = ($page - 1) * $this->num;

        $sql = "SELECT * FROM " . $this->tableName . " ORDER BY " . $sort_param . " " . $sort_type  . " LIMIT " . $this_page_first_result . ',' . $this->num;
        $result2 = $pdo->query($sql);
        $number_of_results = $result4->rowCount();
        $number_of_pages = ceil($number_of_results/$this->num);

        $result_array['records'] = $result2;        
        $result_array['number_of_pages'] = $number_of_pages;

        return $result_array;
    }
}

?>