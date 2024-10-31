<?php
include("loginCheck.php");
include("../config.php");
include("adminClass.php");

$adm->storeFormValues($_POST);
$new_user = $adm->addUser();

header("location:dashboard.php");
