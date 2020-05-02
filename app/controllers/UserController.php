<?php

namespace App\Controllers;

use App\Models\Pagination;
use App\Models\Auth;
use App\Models\Validate;
use App\Models\CreateRecord;

class UserController {
    private $loader;
    private $twig;

    public function __construct()
    {
        $this->loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../views');
        $this->twig = new \Twig\Environment($this->loader);        
    }

    public function Login()
    {
        $auth = new Auth();
        
        if (isset($_POST['staticEmailLogin'])) {
            $login = $_POST['staticEmailLogin'];
        }
        if (isset($_POST['inputPasswordLogin'])) {
            $pass = $_POST['inputPasswordLogin'];
        }
        
        $result = [];

        // bad solution
        if($login == 'admin' && $pass == '123'){
            $loginValid = ['status' => 'success', 'field' => 'staticEmailLogin'];
            array_push($result, $loginValid);
            $passValid = ['status' => 'success', 'field' => 'Pass'];
            array_push($result, $passValid);    
        }else{
        $validate = new Validate();

        $validEmail = $validate->forEmail('staticEmailLogin', $login);
        array_push($result, $validEmail);
        $validPass = $validate->forPass('Pass', $pass, $pass);
        array_push($result, $validPass);
        }

        // Checking validation results
        $status_arr = array_column($result, 'status');

        if (in_array('error', $status_arr)) {
            return json_encode($result);            
        }

        if ($auth->login()) {
            $UID = $_SESSION['id'];
        
            $response['auth'] = 'login';
            $response['session_id'] = $UID;
            return json_encode($response);            
        } else {
            if (isset($_POST['log_in'])) {
        
                $error = $auth->enter($login, $pass); //функция входа на сайт
        
                if (count($error) == 0) //если ошибки отсутствуют, авторизируем пользователя
                {
                    $UID = $_SESSION['id'];
        
                    $response['auth'] = 'login';
                    $response['session_id'] = $UID;
                    return json_encode($response);                   
        
                    // $admin = is_admin($UID);
                } else {
                    $response['auth'] = 'logout';
                    $response['errors'] = $error;
                    return json_encode($response);                    
                }
            }
        }
    }

    public function Logout()
    {
        $auth = new Auth();

        if (isset($_GET['action'])) {
            if ($_GET['action'] == "out") {
                $result = $auth->logout();
                echo json_encode($result);
                exit;
            }
        }
    }
}