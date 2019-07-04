<?php

    //$_POST['update']="xss";
    $conn = new mysqli('localhost','root','','phptraining');
    if (isset($_POST['submit'])){
        if (strlen($_POST['task'])==""){
            echo "Please Enter Task";
        }else{
            if (strlen($_POST['task'])>2){
                $string = trim($_POST['task']);

                if($string != strip_tags($string)) {
                    echo "Html Tags Are Aot Allowed";
                    die();
                }
                $task = trim(htmlentities($_POST['task'], ENT_QUOTES, "UTF-8"));

                $taskCheck = "SELECT * FROM `tasks` WHERE `task` = '$task'";
                $rs = $conn->query($taskCheck);
                if ($rs->num_rows>0){
                    echo "Task Already Exist";
                }else{
                    $sqlInsert = "INSERT INTO `tasks` (`id`, `task`, `created_on`, `status`) VALUES (NULL, '$task', CURRENT_TIMESTAMP, '0')";
                    if ($conn->query($sqlInsert)){
                        echo 1/*"Task Is Created Succeesfully"*/;
                    }else{
                        echo "Something Went Wrong";
                    }
                }
            }
            else{
                echo "Task Title Is Too Short. Please Try Again";
            }
        }

    }elseif (isset($_GET['id'])){
        $sqlDelete = "DELETE FROM `tasks` WHERE `id` = ".$_GET['id'];
        if ($conn->query($sqlDelete)){
            echo "Task Is Deleted Succeesfully";
        }else{
            echo "Something Went Wrong";
        }
    }elseif (isset($_GET['tasks'])){
        $sql = "SELECT * FROM `tasks` ORDER BY `id` DESC LIMIT 5";
        $rs = $conn->query($sql);
        $data='';
        //'<input type="checkbox" id="" class="done" style="width:25px;"'.($row['status']==1)?'."checked".':''.'>'
        //'';
        if ($rs->num_rows>0){
            while ($row = $rs->fetch_assoc()) {
                $status = ($row['status']==1)?'checked':"";
                $statusClass = ($row['status']==1)?'highlight':"";
                $data.='<tr>';
                $data.='<td><input type="checkbox" id="'.$row['id'].'" class="done" style="width:25px;" '.$status.'></td>';
                $data.='<td id="task'.$row['id'].'" class="task '.$statusClass.'">'.$row['task'].'</td>';
                $data.='<td><button id="'.$row['id'].'" class="btn btn-danger remove">X</button></td>';
                $data.='</tr>';
            }
        }else{
            $data = '<tr><td colspan="3" style="text-align: center;font-size: 18px;">No Task Found. Create Task One</tr>';
        }
        echo $data;
    }elseif (isset($_POST['update'])){
        $id =$_POST['id'];
       // $id =8;
        $sqlUpdate = "UPDATE `tasks` SET `status` = '1' WHERE `id` = $id";
        if ($conn->query($sqlUpdate)){
            echo "Task Is Completed";
        }else{
            echo "Something Went Wrong";
        }
    }elseif(isset($_POST['count'])){
        $sqlCount = "SELECT id FROM `tasks` ORDER BY `id` DESC";
        $rs = $conn->query($sqlCount);
        $entries = $rs->num_rows;
        $data ='<ul class="pagination">';
        /*$data.='<li><a  class="currentPage"><<</a></li>';*/

        if ($entries<=5){
            $data.='<li class="disabled"  class="currentPage"><a f="1" t="5">1</a></li>';
        }else{
            $perPage = 5;
            $i=0;
            while($entries>0){
                $data.='<li><a offset="'.($perPage*$i).'" class="currentPage">'.($i+1).'</a></li>';
                $i++;
                $entries-=5;
            }
        }
        /*$data.='<li><a class="currentPage">>></a></li>';*/
        $data.='</ul>';
        echo $data;
    }elseif(isset($_POST['pagination'])){
        $offest = $_POST['offset'];
        $sqlPages = "SELECT * FROM `tasks` ORDER BY `id` DESC  LIMIT $offest, 5";
        //echo $sqlPages;die();
        $rs = $conn->query($sqlPages);
        $data="";
        while ($row = $rs->fetch_assoc()) {
            $status = ($row['status']==1)?'checked':"";
            $statusClass = ($row['status']==1)?'highlight':"";
            $data.='<tr>';
            $data.='<td><input type="checkbox" id="'.$row['id'].'" class="done" style="width:25px;" '.$status.'></td>';
            $data.='<td id="task'.$row['id'].'" class="task '.$statusClass.'">'.$row['task'].'</td>';
            $data.='<td><button id="'.$row['id'].'" class="btn btn-danger remove">X</button></td>';
            $data.='</tr>';
        }
        echo $data;


    }else{
        echo "Dont Access this page Directly";
    }


?>