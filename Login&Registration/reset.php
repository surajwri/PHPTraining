<?php
include_once 'header.php';
require_once "db.php";
require_once "functions.php";

if (isset($_POST['submit'])){
    $email = $_POST['email'];
    $sql = "SELECT * FROM `loginsystemusers` WHERE `email` = '$email'";
    $rs = $conn->query($sql);

    $subject = "Demo Login System";
    $message= "Dear ".$fname;
    $message.="<p>Your are successfully Registered On this System</p>";
    $message.="<p><a href='http://localhost/PHPTraining/PHP/Login&Registration/verify.php?email=$email&hash=$hash'>Click Here </a>To Activate Your Account</p>";
    $message.= "<p>Thanks For Testing</p>";
    if (SendThisMail($email, $subject, $message)){
        $_SESSION['message'] = "You are Registered Successfully. Please check your email to Activate Your Account";
        header("Location: success.php");
    }else{
        $_SESSION['message'] = "You are Registered Successfully | Activation Link Not Sent";
        header("Location: success.php");
    }

    if ($rs->num_rows>0){
       $row = $rs->fetch_assoc();
        $message= "<p>Dear ".$row['fname'];
        $message.="</p><p>Please click the link to reset your password. <a href='http://localhost/PHPTraining/PHP/Login&Registration/reset_password.php?email=suraj6472@gmail.com&hash=67d96d458abdef21792e6d8e590244e7'>Click Here</a></p>";
        $message.="<p><a href='http://localhost/PHPTraining/PHP/Login&Registration/verify.php?email=$email&hash=$hash'>Click Here </a>To Activate Your Account</p>";
        $message.= "<p>Thanks For Testing</p>";
        if(SendThisMail($email,'Login System-Password Reset Link',$msg)){
            $_SESSION['message'] = "Password Reset Link Is Sent TO Registered Email Account. Please Check.";
            header('location:success.php');
        }

    }
    else{
        $_SESSION['message'] = "You Are Not Registered";
       header('location:error.php');
    }
}



?>
<div class="container">
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <div class="well" style="margin-top: 100px">
                <h3>Reset Password</h3>
                <p class="text-center lead">
                <form action="" method="POST" class="form-inline">
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Enter Registered Email Id"> <input type="Submit" name="submit" class="form-control btn btn-info" value="Send Me Reset Link">
                    </div>
                </form>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include_once 'footer.php';?>