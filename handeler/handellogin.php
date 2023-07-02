<?php
session_start();
require_once '../core/functions.php' ;
require_once '../core/validation.php';
$errors =[];
$users =[];
$user =[];
$success ;
if(checkRequestMethod("POST") && checkPostInput('email')){
    foreach($_POST as $key => $value){
        $$key = santzieInput($value);
    }
    $users [] = json_decode(file_get_contents("../data/users.json"), true);
    if(!requireVal($email))
    {$errors [] = "Email is required";
    }elseif (!emailVal($email)){
        $errors [] = "Type a valid email " ;
    }
    
    if(!requireVal($password))
    {$errors [] = "Password is required";}

    if(!empty($email)){
        foreach($users as $user){       
             foreach($user as $use){

        if($use['email']==$email && $use['password']== sha1($password)){
            $name = $use['name'];
              $success = "Login Successfully";
              continue ;
             }}}
    if(empty($success)){$errors []= "email and password didnt match";
       }}


    if (!empty($errors)){
        $_SESSION['errors'] = $errors;
            redirect("../login.php");
        die ;
    }else {
        $_SESSION['success'] = $success;
        $_SESSION['auth']= [$name , $email];
        redirect("../profile.php");
        die ;
    }

}