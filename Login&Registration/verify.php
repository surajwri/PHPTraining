<?php
session_start();
require_once "db.php";

if (isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    $sql = "SELECT * FROM `loginsystemusers` WHERE `email` = '".$_GET['email']."'";
    $rs1 = $conn->query($sql);
    if ($rs1->num_rows > 0){
        $row = $rs1->fetch_assoc();
        if ($row['hash']==$_GET['hash']){
            $sqlActivate = "UPDATE `loginsystemusers` SET `active` = '1' WHERE `id` = ".$row['id'];
            if ($conn->query($sqlActivate)){
                $_SESSION['message'] = "Your Account Is Successfully Activated";
                header("Location: success.php");
            }
        }else{
            $_SESSION['message'] = "You are not Autherised";
            header("Location: error.php");
        }
    }else{
        $_SESSION['message'] = "You are not Autherised";
       header("Location: error.php");
    }
}
else{
    echo "Something is not good";
}

?>