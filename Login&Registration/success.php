<?php
include_once 'header.php';
error_reporting(0);
session_start();
$msg="";
if ($_SESSION['message'])
{   $msg = $_SESSION['message'];
    unset($_SESSION['message']);
}
else{
    $msg =  "Dont Access This page Directly";
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <div class="well" style="margin-top: 100px">
                <p class="text-center lead">
                    <?php echo $msg;?>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include_once 'footer.php';?>