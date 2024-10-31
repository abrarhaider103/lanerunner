<?php
session_start();
include("../../config.php");
include("../adminClass.php");

extract($_POST);

$sql = "DELETE FROM news_table WHERE id = $new_id";
$adm->doThis($sql);


