<?php
session_start();
include("../../config.php");
include("../adminClass.php");


$sql = "SELECT * FROM news_table WHERE 1";

$cuenta = $adm->get_this_all($sql);

$re = array();
foreach($cuenta as $v){
   
    $re[] = array(
        "start" => $v->news_date,
        "title"=> $v->news_title,
        "id"=> $v->id,
        "news_date"=> $v->news_date,
        "edit_news_text"=> $v->news_text
    );

}
echo json_encode($re);

