<?php

namespace App;

use App\Connection;

class CrudTask
{

    public function getTask($taskId)
    {
        $response = [];
        $errors = [];
        try {
                
                $connection = new Connection();
                $pdo = $connection->dbConnect();                               
                $sql = "SELECT * FROM `tasks` WHERE `id` = :taskId;";
                //$pdo->exec("INSERT INTO tasks (name, email, task) 
                // VALUES ('$name', '$email', '$task')");                
                $statement = $pdo->prepare($sql);
                $statement->execute([':taskId' => $taskId]);                
                
        } catch (\Exception $e) {
            

            if ($e->getCode() == '23000') {
                array_push($errors, ' already registered');
                array_push($errors, ' уже зарегестрирован');
                $response['status'] = 'error';
                $response['field'] = 'staticEmail';
                $response['errors'] = $errors;
                return $response;
                exit;
            }
            //array_push($errors, "Ошибка: " . $e->getMessage());
            //array_push($errors, "Error");
            array_push($errors, ' error writing to database');
            array_push($errors, ' ошибка записи в базу данных');
            $response['status'] = 'error';
            $response['field'] = 'staticDB';
            $response['errors'] = $errors;
            return $response;
            exit;
        }
        $fields = $statement->fetch();
        $response['status'] = 'success';
        $response['fields'] = $fields;
        return $response;
        exit;
    }

    public function updateTask($taskId, $name, $email, $task, $status)
    {
        $response = [];
        $errors = [];
        try {
                $taskChars = htmlspecialchars($task, ENT_HTML5);
                $connection = new Connection();
                $pdo = $connection->dbConnect();
                $pdo->beginTransaction();                
                $sql = "UPDATE `tasks` SET `name` = :name,  `email` = :email, 
                `task` = :task, `status` = :status 
                WHERE `id` = :taskId;";
                              
                $statement = $pdo->prepare($sql);
                $statement->execute([':taskId' => $taskId, ':name' => $name, 
                ':email' => $email, ':task' => $taskChars, ':status' => $status]);                
                $pdo->commit();
        } catch (\Exception $e) {
            $pdo->rollBack();

            if ($e->getCode() == '23000') {
                array_push($errors, ' already registered');
                array_push($errors, ' уже зарегестрирован');
                $response['status'] = 'error';
                $response['field'] = 'staticEmail';
                $response['errors'] = $errors;
                return $response;
                exit;
            }
           
            array_push($errors, ' error writing to database');
            array_push($errors, ' ошибка записи в базу данных');
            $response['status'] = 'error';
            $response['field'] = 'staticDB';
            $response['errors'] = $errors;
            return $response;
            exit;
        }
        $response['status'] = 'success';
        $response['field'] = $taskId;
        return $response;
        exit;
    }

    public function deleteTask($taskId)
    {
        $response = [];
        $errors = [];
        try {
                
                $connection = new Connection();
                $pdo = $connection->dbConnect();
                $pdo->beginTransaction();                
                $sql = "DELETE FROM `tasks` WHERE `id` = :taskId;";
                               
                $statement = $pdo->prepare($sql);
                $statement->execute([':taskId' => $taskId]);                
                $pdo->commit();
        } catch (\Exception $e) {
            $pdo->rollBack();

            if ($e->getCode() == '23000') {
                array_push($errors, ' already registered');
                array_push($errors, ' уже зарегестрирован');
                $response['status'] = 'error';
                $response['field'] = 'staticEmail';
                $response['errors'] = $errors;
                return $response;
                exit;
            }
            
            array_push($errors, ' error writing to database');
            array_push($errors, ' ошибка записи в базу данных');
            $response['status'] = 'error';
            $response['field'] = 'staticDB';
            $response['errors'] = $errors;
            return $response;
            exit;
        }
        $response['status'] = 'success';
        $response['field'] = $taskId;
        return $response;
        exit;
    }
}