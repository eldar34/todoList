<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Validate;
use App\CreateRecord;


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



if (in_array('error', $status_arr)) {
    echo json_encode($result);
    exit;
}else {
    
    $create = new CreateRecord();
    $createReacord =  $create->addRecord($name, $email, $task);
    array_push($result, $createReacord);
    echo json_encode($result);
    exit;
} 

