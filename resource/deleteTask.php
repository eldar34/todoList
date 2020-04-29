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
    

    $result = [];

    $validate = new Validate();
    $validId = $validate->forNumber('taskId', $taskId);
    array_push($result, $validId);

    $status_arr = array_column($result, 'status');

    if (in_array('error', $status_arr)) {
        echo json_encode($result);
        exit;
    }else {
        
        $deleteDetail = new CrudTask();
        $deletedTask =  $deleteDetail->deleteTask($taskId);
        array_push($result, $deletedTask);
        echo json_encode($result);
        exit;
    } 

}else{
    $response['auth'] = 'logout';
    $response['errors'] = 'Permission denied';
    echo json_encode($response);
    exit;
}
