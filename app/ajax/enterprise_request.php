<?php
include("../../config.php");
include("ajax_class.php");

$ac->storeFormValues($_POST);
echo $ac->grabo_enterprise_request();


