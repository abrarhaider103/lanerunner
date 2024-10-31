<?php
include("../../config.php");
include("../adminClass.php");

$adm->storeFormValues($_POST);
$adm->save_mob_and_mockup();
// header("location:../app_and_membership_mockup.php");
