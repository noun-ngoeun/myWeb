<?php 
    session_start();
    $_SESSION['Name']="Jonh";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <?php
            if(isset($_POST["login"])){
                $email=$_POST["email"];
                $password=$_POST["password"];

                require_once "config/config.php";
                $sql="SELECT *FROM tbluser WHERE email='$email'";
                $result=mysqli_query($connection,$sql);
                $user=mysqli_fetch_array($result,MYSQLI_ASSOC);
                if($user){
                    if(password_verify($password,$user["password"])){
                        header("Location: index.php");
                        //die();
                    }else{
                        echo "<div class='alert alert-danger'>Password dosen't match!</div>";
                    }
                }else{
                    echo "<div class='alert alert-danger'>User dosen't match!</div>";
                }
            }
        ?>
        <form action="login.php" method="post">
        <div class="form-group">
            <center class="form-title"><h1>Register Form<hr>
            </h1></center>
            </div>
            
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="E-mail:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password:">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" name="login" value="Login">
                <!-- <input type="submit" class="btn btn-danger" name="reset" value="Reset"> -->
                <a href="register.php">Don't have an account</a>
            </div>
        </form>
    </div>
</body>
</html>