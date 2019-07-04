<?php
require_once "header.php";
require_once "db.php";
extract($_POST);


if(isset($submit)){

    $rs = $conn->query("SELECT email FROM `loginSystemUsers` WHERE `email` = '$email'");

    if ($rs->num_rows>0){
        $_SESSION['message'] = "Email Already Registered";
        header("Location:error.php");
    }else{
        $password = password_hash($password, PASSWORD_BCRYPT);
        $hash = md5(rand(500,1000));
        $sql = "INSERT INTO `loginSystemUsers` (`fname`, `lname`, `email`, `password`, `hash`) 
                VALUES ('$fname', '$lname', '$email', '$password', '$hash')";
        if($conn->query($sql)){
            $subject = "Demo Login System";
            $message= "<p>Dear ".$fname;
            $message.="</p><p>Your are successfully Registered On this System</p>";
            $message.="<p><a href='http://localhost/PHPTraining/PHP/Login&Registration/verify.php?email=$email&hash=$hash'>Click Here </a>To Activate Your Account</p>";
            $message.= "<p>Thanks For Testing</p>";
            if (SendThisMail($email, $subject, $message)){
                $_SESSION['message'] = "You are Registered Successfully. Please check your email to Activate Your Account";
                header("Location: success.php");
            }else{
                $_SESSION['message'] = "You are Registered Successfully | Activation Link Not Sent";
                header("Location: success.php");
            }
        }
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <div class="well" style="margin-top: 50px">
                    <h3>Register Here</h3>
                    <form action="register.php" method="post">
                        <div class="form-group">
                            <label for="">First Name: </label><input type="text" name="fname" class="form-control" required>
                            <label for="">Last Name:</label> <input type="text" name="lname" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Email: </label><input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Password: </label><input type="password" name="password" class="form-control" required>
                        </div>
                        <input type="submit" name="submit" class="form-control" value="Register">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
