<?php

namespace App\Models;

use App\Models\Connection;

class Task
{

    public function createTask($name, $email, $task)
    {
        $response = [];
        
        $taskChars = htmlentities($task, ENT_QUOTES | ENT_HTML5, "UTF-8");
        $sql = "INSERT INTO tasks (name, email, task) values(:name, :email, :task);";
        $params = [
            ':name' => $name, 
            ':email' => $email, 
            ':task' => $taskChars
        ];

        $result = $this->query_result($sql, $params);

        if(is_array($result)){
            return $result;
        }else{ 
            $response['status'] = 'success';
            $response['field'] = 'staticDB';
            return $response;
        }    
        
    }

    public function readTask($taskId)
    {
        $response = [];
        $errors = [];

        $sql = "SELECT * FROM tasks WHERE id = :taskId;";
        $params = [
            ':taskId' => $taskId
        ];

        $fields = $this->query_result($sql, $params, 'read');

        // Bad solution
        if(count($fields)>4){
            /** 
            *   Dangerous
            */   
            $fields['task'] = html_entity_decode($fields['task'], ENT_QUOTES | ENT_HTML5, "UTF-8");        
            $response['status'] = 'success';
            $response['fields'] = $fields;
            return $response;
        }else{
            return $fields;
        }
    }

    public function updateTask($taskId, $name, $email, $task, $status)
    {
        
        $taskChars = htmlentities($task, ENT_QUOTES | ENT_HTML5, "UTF-8");
        $sql = "UPDATE tasks SET name = :name,  email = :email, 
                task = :task, status = :status, updated_by = :updated_by 
                WHERE id = :taskId;";
        $params = [
            ':taskId' => $taskId,
            ':name' => $name, 
            ':email' => $email, 
            ':task' => $taskChars, 
            ':status' => $status, 
            'updated_by' => 1
        ];

        $result = $this->query_result($sql, $params);

        if(is_array($result)){
            return $result;
        }else{ 
            $response['status'] = 'success';
            $response['field'] = $taskId;
            return $response;
        } 

    }

    public function deleteTask($taskId)
    {
        $sql = "DELETE FROM tasks WHERE id = :taskId;";
        $params = [
            ':taskId' => $taskId
        ];

        $result = $this->query_result($sql, $params);

        if(is_array($result)){
            return $result;
        }else{ 
            $response['status'] = 'success';
            $response['field'] = $taskId;
            return $response;
        } 
        
    }

    private function query_result($sql, $params, $action=null){

        $response = [];
        $errors = [];
            
        try {
                
                $connection = new Connection();
                $pdo = $connection->dbConnect();
                $pdo->beginTransaction();                
                
                //$pdo->exec("INSERT INTO tasks (name, email, task) 
                // VALUES ('$name', '$email', '$task')");                
                $statement = $pdo->prepare($sql);
                $statement->execute($params);                

        } catch (\PDOException $e) {
            $pdo->rollBack();

            if ($e->getCode() == '23000') {
                array_push($errors, ' already registered');
                array_push($errors, ' уже зарегестрирован');
                $response['status'] = 'error';
                $response['field'] = 'staticEmail';
                $response['errors'] = $errors;
                return $response;
                
            }
            //array_push($errors, "Ошибка: " . $e->getMessage());
            //array_push($errors, "Error");
            array_push($errors, $e->getMessage());
            array_push($errors, ' ошибка записи в базу данных');
            $response['status'] = 'error';
            $response['field'] = 'staticDB';
            $response['errors'] = $errors;
            return $response;
            
        }
        if($action=='read'){
            return $statement->fetch();
        }else{
            return $pdo->commit();
        }
        
    }
}