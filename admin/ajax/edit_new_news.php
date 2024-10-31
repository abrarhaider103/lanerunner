<?php
session_start();
include("../../config.php");
include("../adminClass.php");

extract($_POST);

/*
$sql = "UPDATE news_table set news_date = '$new_date', news_title = '$new_title', news_from = '$new_from', news_to = '$new_to' WHERE id = $new_id";
$adm->doThis($sql);
*/

try {
    $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE news_table set news_date = '$new_date', news_title = :new_title,  news_text = :new_text WHERE id = $new_id";
    $stmt = $con->prepare($sql);
    $stmt->bindValue("new_title", $new_title, PDO::PARAM_STR);
    $stmt->bindValue("new_text", $new_text, PDO::PARAM_STR);
    $stmt->execute();
} catch (PDOException $e) {
    echo $e->getMessage();
    
}


/* new_date: $("#edit_new_date").val(),
                    new_title: $("#edit_new_title").val(),
                    new_text: $("#edit_news_text").val(),
                    new_id: $("#edit_new_id").val()
                    */


