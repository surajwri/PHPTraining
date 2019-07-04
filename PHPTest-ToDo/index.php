<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="alertifyjs/alertify.core.css">
    <link rel="stylesheet" href="alertifyjs/alertify.default.css">
    <script src="alertifyjs/alertify.min.js"></script>



    <title>To-Do</title>
</head>
<style>
    td{
        vertical-align: middle !important;
    }
    .highlight{
        color:rebeccapurple;
        font-weight: bold;
        font-size: 18px;
        text-decoration: line-through;
    }
    body{
        background-color: darkgrey;
    }
    /* h3{
         margin-top: 5px;
         margin-bottom: 5px;
     }*/
</style>
<body>
<div class="container">
    <div class="row">
        <h3>Add Task</h3>
        <form action="" class="form-horizontal">
            <div class="form-group">
                <div class="col-md-8 col-lg-8 col-sm-8 col-xs-8">
                    <input type="text" class="form-control" id="task" required>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3">
                    <input type="submit" value="Add Task" class="btn btn-success btn-block pull-right" id="submit" name="submit">
                </div>
            </div>
        </form>
        <hr style="border-top: 2px solid #1e7e34;">
    </div>

    <div class="row">

        <h3 style="text-align: center;margin-top: 0px">Task List</h3>
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Tasks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tasklist">
            </tbody>
            <tfoot id="pagination">
            </tfoot>
        </table>


    </div>
</div>
<script>


    $(document).ready(function () {

        //Functions
        function pagination(){
            $.ajax({
                url:'server.php',
                method:'POST',
                data:"count=true",
                success:function (response) {
                    $('#pagination').html(response);
                }
            });
        }

        function getTasks(){
            $.ajax({
                url:'server.php',
                method:'GET',
                data:"tasks=get",
                success:function (response) {
                    $('#tasklist').html(response);
                }
            });
        }

        $('.table').on('click','.currentPage', function(){
            var offset = $(this).attr('offset');
            $.ajax({
                url:'server.php',
                method:'post',
                data:"pagination=get&offset="+offset,
                success:function (response) {
                    $('#tasklist').html(response);
                }
            });
        });


        //Status Update
        $('table').on('change','.done',function () {
            var id = $(this).attr('id');
            $.ajax({
                url:'server.php',
                method:'POST',
                data:"id="+id+"&update=status",
                success:function (response) {
                    alertify.success(response);
                    $('#task').val("");
                    getTasks();
                    pagination();
                }
            });
        });

        //Showing Tasks
        getTasks();
        pagination()
        // Adding Task
        $('#submit').on('click',function (e) {
            e.preventDefault();
            var task = $('#task').val();
            $.ajax({
                url:'server.php',
                method:'POST',
                data:"task="+task+"&submit=submit",
                success:function (response) {
                    if(response==1){
                        alertify.success("Task Created Successfully");
                    }else{
                        alertify.error(response);
                    }
                    $('#task').val("");
                    getTasks();
                    pagination()
                }
            });
        });


        //Deleting Task
        $('table').on('click','.remove',function () {
            var id = $(this).attr('id');
            $.ajax({
                url:'server.php',
                method:'GET',
                data:"id="+id,
                success:function (response) {
                    alertify.success(response);
                    $(this).parent().parent().remove();
                    getTasks();
                    pagination()
                }
            });
        });
    });
</script>
</body>
</html>