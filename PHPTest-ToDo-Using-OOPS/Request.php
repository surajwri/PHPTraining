<?php

include_once "Task.php";
include_once "DB.php";

$task = new Task();

//============================= Create Task =======================================================

if (isset($_POST['submit'])) {
    unset($_POST['submit']);
    $data = $task->createTask('tasks',$_POST);
    print_r(json_encode($data));die(); // ERROR : Not showing and this when returning the data
    //return $data;

//============================= Delete Task======================================================

} elseif (isset($_POST['delete'])) {
    $data = $task->deleteTask('tasks',"id=".$_POST['id']);
    print_r(json_encode($data));die(); // ERROR : Not showing and this when returning the data
    //return $data;

//============================ Pagination ========================================================

} elseif (isset($_GET['GetTask'])) {
    if (!isset($_GET['offset'])){
        $offset = 1;
        $page = 1;
        $rpp = 5; // pagination record per page
    }else{
        $offset = $_GET['offset'];
        $page = $_GET['page'];
        $rpp = $_GET['rpp'];
    }
    $offset =($offset-1)*$rpp;
    $data['task'] = $task->getTask('tasks','1','LIMIT '.$offset.', '.$rpp);
    $data['pagination'] = $task->getTaskPagination('tasks');
    $data['pagination']['currentPage'] = $page;
    print_r(json_encode($data));die(); // ERROR : Not showing and this when returning the data
    //return $data;

//============================== Status Change ======================================================

} elseif (isset($_POST['status'])) {
    $data = $task->taskStatus('tasks',$_POST['id']);
    print_r(json_encode($data));die(); // ERROR : Not showing and this when returning the data
    //return $data;

} else {
    echo "Dont Access this page Directly";
}


