<?php
include_once 'header.php';
?>
<div class="container">
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <div class="well" style="margin-top: 100px">
                <h1 style="text-align: center;">Welcome To The System</h1>
                <dl class="dl-horizontal">
                    <dt>Name</dt>
                    <dd><?php echo $_SESSION['fname']." ".$_SESSION['lname'];?></dd>
                    <dt>Email</dt>
                    <dd><?php echo $_SESSION['email'];?></dd>
                </dl>
            </div>
        </div>
    </div>
</div>
<?php include_once 'footer.php';?>