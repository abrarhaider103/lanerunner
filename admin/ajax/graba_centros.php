<?php

include("../../config.php");
include("../adminClass.php");

extract($_GET);


$sql = "UPDATE master_regions SET center_lat = '$lat', center_lng = '$lng', centered = 1 WHERE region_id = $region_id";
$reg = $adm->doThis($sql);

echo json_encode($reg);
