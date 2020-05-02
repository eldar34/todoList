<?php

namespace App\Models;

class Validate
{
    public function forName($fieldName, $props){
        $response = [];
        $errors = [];
        $len = strlen($props);

        if($len<=250){
            if(preg_match('/^[a-zA-Zа-яА-Я]+$/ui', $props)){
                $response['status'] = 'success';
                $response['field'] = $fieldName;
                return $response;
            }else{
                array_push($errors,' must be string');
                array_push($errors,' должно быть строкой');
                $response['status'] = 'error';
                $response['field'] = $fieldName;
                $response['errors'] = $errors;
                return $response;
            }
        }else{
            array_push($errors,' must be string <= 250 chars');
            array_push($errors,' строка должна содержать меньше 250 символов');
            $response['status'] = 'error';
            $response['field'] = $fieldName;
            $response['errors'] = $errors;
            return $response;
        }
    }

    public function forEmail($fieldName, $props){
        $response = [];
        $errors = [];

        if (filter_var($props, FILTER_VALIDATE_EMAIL)) {
            $response['status'] = 'success';
            $response['field'] = $fieldName;
            return $response;
        }else {
            array_push($errors,' not valid');
            array_push($errors,' не валидно');
            $response['status'] = 'error';
            $response['field'] = $fieldName;
            $response['errors'] = $errors;
            return $response;
        }
    }

    public function forPass($fieldName, $props, $conf){
        $response = [];
        $errors = [];

        if($props == $conf){
            if(preg_match('/^(?=.*[a-z])(?=.*\d)[a-zA-Z\d]{4,12}$/', $props)){
                //^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{4,12}$
                $response['status'] = 'success';
                $response['field'] = $fieldName;
                return $response;
            }else{
                array_push($errors,' length must be more then 4, with chars(a-Z) and numbers(0-9)');
                array_push($errors,' должен быть длинее 4 символов и содержать буквы(a-Z) и цифры(0-9)');
                $response['status'] = 'error';
                $response['field'] = $fieldName;
                $response['errors'] = $errors;
                return $response;
            }
        }else{
                array_push($errors,' doesnt much');
                array_push($errors,' не совпадают');
                $response['status'] = 'error';
                $response['field'] = $fieldName;
                $response['errors'] = $errors;
                return $response;
        }      
    }
    
    public function forTask($fieldName, $props){

        $response = [];
        $errors = [];

        $taskChars = htmlentities($props, ENT_QUOTES | ENT_HTML5, "UTF-8");
        $len = strlen($taskChars);

        if($len<=250){
            $response['status'] = 'success';
            $response['field'] = $fieldName;
            return $response;
        }else{
            array_push($errors,' must be string <= 250 chars');
            array_push($errors,' строка должна содержать меньше 250 символов');
            $response['status'] = 'error';
            $response['field'] = $fieldName;
            $response['errors'] = $errors;
            return $response;
        }       
    }

    public function forStatus($fieldName, $props){

        $response = [];
        $errors = [];
        $statusArray = ['New', 'Complete'];

        if(in_array($props, $statusArray)){
            $response['status'] = 'success';
            $response['field'] = $fieldName;
            return $response;
        }else{
            array_push($errors,' must be string New or Complete. NotValid = '.$props);
            array_push($errors,' должно быть строкой New или Complete');
            $response['status'] = 'error';
            $response['field'] = $fieldName;
            $response['errors'] = $errors;
            return $response;
        }       
    }

    public function forNumber($fieldName, $props){

        $response = [];
        $errors = [];
        $pattern = '#^[0-9]+$#';

        if(preg_match($pattern, $props)){
            $response['status'] = 'success';
            $response['field'] = $fieldName;
            return $response;
        }
        else{
            array_push($errors,' must be a number');
            array_push($errors,' должно быть числом');
            $response['status'] = 'error';
            $response['field'] = $fieldName;
            $response['errors'] = $errors;
            return $response;
        }       
    }

}