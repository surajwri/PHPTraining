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
        text-decoration: line-through;
    }
    body{
        background-color: darkgrey;
    }
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
        //Showing Tasks
        getTasks();

        //----------------------- Show Data ------------------

        function Showdata(response) {
            response =JSON.parse(response);
            //console.log(response);
            responseTask =response.task;
            responsePages =response.pagination;
            if (response['status']!=null){
                if(response['status']=='pass'){
                    alertify.success(response['message']);
                }else{
                    alertify.error(response['message']);
                }
            }else{
                var showData = "";
                for (var i=0;i<responseTask.length;i++){
                    $status = (responseTask[i]['status']== 1) ? 'checked' : "";
                    $statusClass = (responseTask[i]['status']== 1) ? 'highlight' : "";
                    showData += '<tr>';
                    showData += '<td><input type="checkbox" id="' + responseTask[i]['id'] + '" class="done" style="width:25px;" ' + $status + '></td>';
                    showData += '<td id="task'  + responseTask[i]['id']+  '" class="task ' + $statusClass + '">'  + responseTask[i]['task'] +  '</td>';
                    showData += '<td><button id="' + responseTask[i]['id'] + '" class="btn btn-danger remove">X</button></td>';
                    showData += '</tr>';
                }
                showData += '<tr>';
                showData += '<td colspan="3">';
                showData +='<ul class="pagination">';
                for (var i=1;i<=responsePages.np;i++){
                    if(i==responsePages.currentPage){
                        active ="active";
                    }else{
                        active="";
                    }
                    showData += '<li class="'+active+'"><a offset="'+i+'" rpp="'+responsePages.rpp+'" class="pages">'+i+'</a></li>';
                }
                showData += '</ul>';
                showData += '</td>';
                showData += '</tr>';

                $('#tasklist').html(showData);
            }

        }

        //----------------------- Ajax Request ------------------

        function AjaxRequest(url, method,data){
                $.ajax({
                url:url,
                method:method,
                data:data,
                success:function (response) {
                    Showdata(response);
                }
            });
        }
        //-----------------------Get All Task List ------------------

        function getTasks(){
            console.log("ok");
            AjaxRequest('Request.php','GET',"GetTask=Task");
        }

        //-----------------------  Pagination ------------------
        $('table').on('click','.pages',function () {
            var offset = $(this).attr('offset');
            var rpp = $(this).attr('rpp');
            var page = $(this).text();
            AjaxRequest('Request.php','GET','offset='+offset+'&rpp='+rpp+'&page='+page+'&GetTask=true');

        });

        //----------------------- Status Update ------------------

        $('table').on('change','.done',function () {
            var id = $(this).attr('id');
            AjaxRequest('Request.php','POST','id='+id+'&status=status');
            $('#task'+id).toggleClass('highlight');
        });

        //----------------------- Create A Task ------------------

        $('#submit').on('click',function (e) {
            e.preventDefault();
            var task = $('#task').val();
            AjaxRequest('Request.php','POST','task='+task+'&submit=submit');
            $('#task').val("");
            getTasks();

        });


        //----------------------- Delete A Task ------------------


        $('table').on('click','.remove',function () {
            var id = $(this).attr('id');
            AjaxRequest('Request.php','POST','id='+id+'&delete=submit');
            $(this).parent().parent().remove();
        });

        //----------------------- Script End ------------------
    });
</script>
</body>
</html>