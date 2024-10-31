<?php

include("../../config.php");
include("../adminClass.php");

extract($_POST);

$sql = "UPDATE lanes SET reefer = '".$reefer_new_val."', flat  = '".$flat_new_val."', van  = '".$van_new_val."', last_updated = NOW() WHERE lane_id =  ".$lane_id_val;
$adm->doThis($sql);
echo $sql;

/*
    [reefer_new_val] => 3103
    [flat_new_val] => 2600
    [van_new_val] => 2650
    [lane_id_val] => 6079
 */