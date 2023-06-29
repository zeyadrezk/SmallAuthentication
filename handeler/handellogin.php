<?php
session_start();
require_once '../core/functions.php' ;
require_once '../core/validation.php';
$errors =[];
$users =[];
$user =[];
if(checkRequestMethod("POST") && checkPostInput('email')){
    foreach($_POST as $key => $value){
        $$key = santzieInput($value);
    }
    $users = json_decode(file_get_contents("../data/users.json"), true);
    if(!requireVal($email))
    {$errors [] = "Email is required";
    }elseif (!emailVal($email)){
        $errors [] = "Type a valid email " ;
    }
    
    if(!requireVal($password))
    {$errors [] = "Password is required";}

    if(!empty($email)){
        foreach($users as $user){
        if($user['email']==$email && $user['password']== sha1($password)){
              $success = "Login Successfully";
    }}if(!empty($success)){$errors [] = "email and password didnt match";}

}
    if (!empty($errors)){
        $_SESSION['errors'] = $errors;
        redirect("../login.php");
        die ;
    }else {
        $_SESSION['success'] = $success;
        $_SESSION['auth']= [$user['name'] , $email];
        redirect("../profile.php");
        die ;
    }

}