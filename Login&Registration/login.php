<?php

require_once "header.php";
require_once "db.php";

extract($_POST);
if (isset($login)){
    $sql = "SELECT * FROM `loginSystemUsers` WHERE `email` = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows >0){
        $user = $result->fetch_assoc();
        if (password_verify($password,$user['password'])){
            $_SESSION['fname'] = $user['fname'];
            $_SESSION['lname'] = $user['lname'];
            $_SESSION['email'] = $user['email'];
            if ($user['active']==0){
                $_SESSION['message']="You Are Logged In. But Your Account is not activated.<b>Check your Email Now</b>";
                header("location:success.php");
            }else{
                header("location:profile.php");
            }
        }
    }else{
        $_SESSION['message'] = "You Are Not Registered";
        header('location:error.php');
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <div class="well" style="margin-top: 100px">
                <div id="loginForm">
                    <h3>Login Now</h3>
                    <form action="login.php" method="post">
                        <div class="form-group">
                            <label for="">Email: </label><input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Password: </label><input type="password" name="password" class="form-control" required>
                        </div>
                        <span class="pull-right" style="margin-bottom: 3px;color: #0e90ff!important;"><a href="reset.php">Reset Password</a></span>
                        <input type="submit" name="login" class="form-control" value="Login">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
