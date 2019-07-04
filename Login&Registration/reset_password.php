<?php
include_once 'header.php';
require_once "db.php";
require_once "functions.php";

if (isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    $email = $_GET['email'];
    $hash = $_GET['hash'];
    $sql = "SELECT * FROM `loginsystemusers` WHERE `email` = '$email' AND `hash` = '$hash'";
    $rs = $conn->query($sql);
    $id='';
    if ($rs->num_rows>0){
        $row = $rs->fetch_assoc();
        $id = base64_encode($row['id']);
    }elseif($rs->num_rows==0){
        $_SESSION['message'] = "Something Went Wrong";
        header("Location:error.php");
    }
}
else{
    $_SESSION['message'] = "Incorrect Password Reset Link.";
    header("Location:error.php");
}
if(isset($_POST['submit'])){
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $id = $_POST['id'];
    $id = base64_decode($id);
    if ($password == $confirmPassword){
        $password = password_hash($password, PASSWORD_BCRYPT);
        $sqlUpdate = "UPDATE `loginsystemusers` SET `password` = '$password' WHERE `id` =".$id;
        if ($conn->query($sqlUpdate)){
            $_SESSION['message'] = "Password Reset Done Successfully";
            header("Location:success.php");
        }
    }
}
?>


<div class="container">
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <div class="well" style="margin-top: 100px">
                <p class="text-center lead">
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <div class="form-group">
                            <label for="">Password: </label><input type="password" name="password" placeholder="Enter Password">
                        </div>
                        <div class="form-group">
                            <label for="">Confirm Password: </label><input type="password" name="confirmPassword" placeholder="Confirm Password">
                        </div>
                        <input type="submit" name="submit" value="Reset Password">
                    </form>
                </p>
            </div>
        </div>
    </div>
</div>


<?php include_once 'footer.php';?>
