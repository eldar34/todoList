<?php

namespace App\Controllers;

use App\Controllers\Controller;

use App\Models\Validate;
use App\Models\CreateRecord;
use App\Models\CrudTask;

class TaskController extends Controller
{

    public function CreateTask()
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
        } else {

            $create = new CreateRecord();
            $createReacord =  $create->addRecord($name, $email, $task);
            array_push($result, $createReacord);
            return json_encode($result);
            // echo json_encode($result);
            // exit;
        }
    }

    public function ReadTask()
    {
        if (isset($_POST['taskId'])) {
            $taskId = $_POST['taskId'];
        }

        $result = [];

        $validate = new Validate();
        $validId = $validate->forNumber('taskId', $taskId);
        array_push($result, $validId);

        // Checking validation results
        $status_arr = array_column($result, 'status');

        if (in_array('error', $status_arr)) {
            return json_encode($result);
        } else {

            $getDetail = new CrudTask();
            $getTask =  $getDetail->getTask($taskId);
            array_push($result, $getTask);
            return json_encode($result);
        }
    }

    public function UpdateTask()
    {

        if (isset($_POST['taskId'])) {
            $taskId = $_POST['taskId'];
        }
        if (isset($_POST['updateName'])) {
            $name = $_POST['updateName'];
        }
        if (isset($_POST['updateEmail'])) {
            $email = $_POST['updateEmail'];
        }
        if (isset($_POST['updateTask'])) {
            $task = $_POST['updateTask'];
        }
        if (isset($_POST['updateStatus'])) {
            $status = $_POST['updateStatus'];
        }

        $result = [];

        $validate = new Validate();
        $validId = $validate->forNumber('taskId', $taskId);
        array_push($result, $validId);
        $validName = $validate->forName('updateName', $name);
        array_push($result, $validName);
        $validEmail = $validate->forEmail('updateEmail', $email);
        array_push($result, $validEmail);
        $validTask = $validate->forTask('updateTask', $task);
        array_push($result, $validTask);
        $validStatus = $validate->forStatus('updateStatus', $status);
        array_push($result, $validStatus);

        // Checking validation results
        $status_arr = array_column($result, 'status');

        if (in_array('error', $status_arr)) {
            return json_encode($result);
        } else {

            $update = new CrudTask();
            $updateTask =  $update->updateTask($taskId, $name, $email, $task, $status);
            array_push($result, $updateTask);
            return json_encode($result);
        }
    }

    public function DeleteTask()
    {

        if (isset($_POST['taskId'])) {
            $taskId = $_POST['taskId'];
        }

        $result = [];

        $validate = new Validate();
        $validId = $validate->forNumber('taskId', $taskId);
        array_push($result, $validId);

        $status_arr = array_column($result, 'status');

        if (in_array('error', $status_arr)) {
            return json_encode($result);            
        } else {
            $deleteDetail = new CrudTask();
            $deletedTask =  $deleteDetail->deleteTask($taskId);
            array_push($result, $deletedTask);
            return json_encode($result);           
        }
    }
}
