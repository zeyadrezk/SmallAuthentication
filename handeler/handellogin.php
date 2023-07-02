<?php
session_start();
require_once '../core/functions.php' ;
require_once '../core/validation.php';
$errors =[];
$success ;
if(checkRequestMethod("POST") && checkPostInput('email')){
    foreach($_POST as $key => $value){
        $$key = santzieInput($value);
    }
    if(!requireVal($email))
    {$errors [] = "Email is required";
    }elseif (!emailVal($email)){
        $errors [] = "Type a valid email " ;
    }
    if(!requireVal($password))
    {$errors [] = "Password is required";}

    if(!empty($email)){
            $conn = mysqli_connect("localhost","root","","authentication");
            if(!$conn){
                 echo mysqli_connect_error($conn);
                    }
                    $hashedPassword = sha1($password); 
                    $sql="SELECT * FROM `user` WHERE `email` ='$email'and `password` ='$hashedPassword'";
                    $result = mysqli_query($conn , $sql);
                

            if(mysqli_affected_rows($conn)){

              $success = "Login Successfully";}else{
                $errors []= "email and password didnt match";
              }
                }
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