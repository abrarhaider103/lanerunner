<?php

include("../../config.php");
include("../adminClass.php");

extract($_POST);

$sql = "SELECT region_id, region_name FROM master_regions WHERE region_id NOT IN (SELECT region_id_destination FROM regions_assigned WHERE region_id_origin = $cual) AND canada = 0 AND region_name != '' ORDER BY RIGHT(region_name, 2) ASC";
$reg = $adm->getThisAllArray($sql);

echo json_encode($reg);