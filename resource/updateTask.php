<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Auth;
use App\Validate;
use App\CrudTask;

$auth = new Auth();

if ($auth->login()) {

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

    $status_arr = array_column($result, 'status');

    if (in_array('error', $status_arr)) {
        echo json_encode($result);
        exit;
    }else {
        
        $update = new CrudTask();
        $updateTask =  $update->updateTask($taskId, $name, $email, $task, $status);
        array_push($result, $updateTask);
        echo json_encode($result);
        exit;
    } 

}else{
    $response['auth'] = 'logout';
    $response['errors'] = 'Permission denied';
    echo json_encode($response);
    exit;
}

