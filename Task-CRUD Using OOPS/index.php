<?php
include_once "DB.php";
$db = new DB();
$db->connect();
//===================Show Records=======================

    $result  = $db->getQuery('posts');

//===================Insert Records=======================

   /* $result=$db->insertQuery('posts',array(
            'category_id'=>'12123',
            'title'=>'Title123',
            'body'=>'This is New  body from Oops script123',
            'author'=>'New PHP123'
    ));*/

//===================Delete Records=======================

    //$result  = $db->deleteQuery('posts',"id=50");

//===================Update Records=======================

    /*$result=$db->UpdateQuery('posts',array(
        'category_id'=>'50',
        'title'=>'Update From OOPS',
        'body'=>'This is updated body from Oops script',
        'author'=>'PHP'
    ),'id=50');*/

echo "<pre>";
print_r($result);
echo "</pre>";
?>