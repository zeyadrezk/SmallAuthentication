<?php
session_start();
require_once '../core/functions.php' ;
require_once '../core/validation.php';

$errors = [];
if(checkRequestMethod("POST") && checkPostInput('name')){
    foreach($_POST as $key => $value){
        $$key = santzieInput($value);
    }


 //name validation required => min:3 , max:15
if(!requireVal($name))
{$errors [] = "name is required";
}elseif (minVal($name , 3)||maxVal($name,15)){
    $errors [] = "Name must be between 3 and 15 chars";
}

// email validation required , email
if(!requireVal($email))
{$errors [] = "Email is required";
}elseif (!emailVal($email)){
    $errors [] = "Type a valid email " ;
}

// password required ,  min:6 , max:20
if(!requireVal($password))
{$errors [] = "Password is required";
}elseif (minVal($password , 6)||maxVal($password,20)){
    $errors [] = "Password must be between 6 and 20 chars";
}


if(!requireVal($confirm_password))
{$errors [] = "Confirm password is required";
}elseif (!confirmVal($password , $confirm_password)){
    $errors [] = "Confirm password must be identical to password";
}




if (empty($errors)){
    $store =[];
    foreach($_POST as $key =>$value){
        if($key == "password"||$key == "confirm_password"){
            $store[$key]= sha1($value);
            $hashed= sha1($value);
        }else {
            $store[$key]= $value;
            
        }
    }
    $conn = mysqli_connect("localhost","root","","authentication");
            if(!$conn){
                 echo mysqli_connect_error($conn);
                    }
    $sql="INSERT INTO `user`(`name`,`email`,`password` ,`confirmPassword`) values('$store[name]','$store[email]','$store[password]','$store[confirm_password]')";
    $result = mysqli_query($conn , $sql);


   $_SESSION['success'] = "data has been successfully added";
   $_SESSION['auth']= [$name , $email];
   redirect("../index.php");
   die;
}else{
    $_SESSION['errors']= $errors ;
    redirect('../register.php');
    die;
}

}
?>