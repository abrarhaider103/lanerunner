<?php
extract($_GET);
include("loginCheck.php");
include("../config.php");
include("adminClass.php");

$sql = "DELETE FROM main_quotes WHERE origin = $origin";
$adm->doThis($sql);

header("location:dashboard.php");