<?php

namespace App;

use App\Connection;

class CreateRecord
{
    
    public function addRecord($name, $email, $task)
    {
        $response = [];
        $errors = [];
        try {
                $taskChars = htmlspecialchars($task, ENT_HTML5);

                $connection = new Connection();
                $pdo = $connection->dbConnect();
                $pdo->beginTransaction();                
                $sql = "INSERT INTO `tasks` (`name`, `email`, `task`) values(:name, :email, :task);";
                //$pdo->exec("INSERT INTO tasks (name, email, task) 
                // VALUES ('$name', '$email', '$task')");                
                $statement = $pdo->prepare($sql);
                $statement->execute([':name' => $name, ':email' => $email, ':task' => $taskChars]);                
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
        $response['status'] = 'success';
        $response['field'] = 'staticDB';
        return $response;
        exit;
    }
}
