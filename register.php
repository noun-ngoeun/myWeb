<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <?php
        //print_r($_POST);
        if(isset($_POST["submit"])){
            $fullname=$_POST["fullname"];
            $email=$_POST["email"];
            $phoneNo=$_POST["phone"];
            $password=$_POST["password"];
            $repeadPass=$_POST["repead_password"];

            $passwordHash =password_hash($password,PASSWORD_DEFAULT);
            // $repeadpassdHash =password_hash($repeadPass,PASSWORD_DEFAULT);
            $errors=array();
            if(empty($fullname)OR empty($email)OR empty($password)){
                array_push($errors,"All fields are required!");
            }
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                array_push($errors,"Email is not validate!");
            }
            if(strlen($password)<8){
                array_push($errors,"Password must be at least 8 character long!");
            }
            if($password !==$repeadPass){
                array_push($errors,"Password dosen't match!");
            }
            // check email exist or not?
            require_once "config/config.php";
            $sql="SELECT * FROM tbluser WHERE email='$email'";
            $result=mysqli_query($connection,$sql);
            $rowCount=mysqli_num_rows($result);
            if($rowCount>0){
                array_push($errors,"This Mail already exixt");
            }
            if(count($errors)>0){
               foreach($errors as $error){
                    echo "<div class='alert alert-danger'>$error</div>";
               }
            }
            else{ // record will insert data into database
                //require_once "config/config.php";
                //echo "<div class='alert alert-success'>You have successfully registered!</div>";
                $sql="INSERT INTO tbluser(full_name,email,phone_number,password,confirm_password) VALUES( ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($connection);
                $preparestmt=    mysqli_stmt_prepare($stmt,$sql);
                if($preparestmt){
                    mysqli_stmt_bind_param($stmt,"sssss",$fullname,$email,$phoneNo,$passwordHash, $repeadPass);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'>Your are Registered Succsessfully<br>$fullname</div>";
                }else{
                    die("Register is not success!");
                }
            }
        }
    
        ?>
        <form action="register.php" method="post">
            <div class="form-group">
            <center class="form-title"><h1>Register Form<hr>
            </h1></center>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Full name:">
                <!-- <?php echo $fullname;?> -->
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email:">
                <!-- <?php echo $email;?> -->
            </div>
            <div class="form-group">
                <input type="number" class="form-control" name="phone" placeholder="Phone Number:">
                <!-- <?php echo $phoneNo?> -->
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password:">
                <!-- <?php echo $password?> -->
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repead_password" placeholder="Repead password:">
                <!-- <?php echo $repeadPass;?> -->
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" name="submit" value="Register">
                <input type="submit" class="btn btn-danger" name="reset" value="Reset">
                <a href="login.php">Already have an account</a>
            </div>
        </form>
    </div>
</body>
</html>