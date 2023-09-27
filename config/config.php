<?php
$localhost="localhost";
$username="root";
$password="";
$dbName="login-register";
    $connection=mysqli_connect($localhost,$username,$password,$dbName);
    if(!$connection){
        die("Connection failed!");
    }
    else{
        //echo "Connected";
    }
?>