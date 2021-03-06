<?php

namespace App\Models;

use App\Models\Connection;

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

    public function get_page($page = 1){

      if(intval($page)){
        $page = intval($page);
        return $page;
      }else{
        $page = 1;
        return $page;
      }

    }

    public function get_sort_param($sort_param = 'id'){

        $paramsArray = $this->sortFields;       
        if(in_array($sort_param, $paramsArray)){
          $validParam = $sort_param;
          return $validParam;
        }else{
          $validParam = 'id';
          return $validParam;
        }

    }

    public function get_sort_type($sort_type = 'ASC'){

        $paramsArray = ['ASC', 'DESC'];       
        if(in_array($sort_type, $paramsArray)){
          $validParam = $sort_type;
          return $validParam;
        }else{
          $validParam = 'ASC';
          return $validParam;
        }

    }

    public function get_page_content($page_usr = 1, $sort_param_usr = 'id', $sort_type_usr = 'ASC'){

      $connection = new Connection();
      $pdo = $connection->dbConnect();        

      $allRecords = $pdo->prepare("SELECT COUNT(*) FROM " . $this->tableName);
      $allRecords->execute();
      
      $page = $this->get_page($page_usr);
      $sort_param = $this->get_sort_param($sort_param_usr);
      $sort_type = $this->get_sort_type($sort_type_usr);
      $this_page_first_result = ($page - 1) * $this->num;
      
      $sql = "SELECT * FROM " . $this->tableName . " ORDER BY $sort_param $sort_type LIMIT :num OFFSET :firts_result";       
      
      $statement = $pdo->prepare($sql);
      // $statement->bindValue(':sort_param', $sort_param, \PDO::PARAM_STR); 
      // $statement->bindValue(':sort_type', $sort_type, \PDO::PARAM_STR); 
      $statement->bindValue(':firts_result', $this_page_first_result, \PDO::PARAM_INT); 
      $statement->bindValue(':num', $this->num, \PDO::PARAM_INT);         

      $statement->execute(); 

      $number_of_results = $allRecords->fetchColumn();
      $number_of_pages = ceil($number_of_results/$this->num);

      $result_array['records'] = $statement->fetchAll();        
      $result_array['number_of_pages'] = $number_of_pages;

      return $result_array;
  }
}

?>