<?php
extract($_POST);
include("../../config.php");
include("../adminClass.php");

$sql = "DELETE FROM master_regions WHERE region_id = $region_id";

$adm->doThis($sql);


// tengo que borrar si la region esta asignada a algun lane

$sql = "SELECT id, regions_assigned_to_zone FROM lane_regions WHERE FIND_IN_SET($region_id, regions_assigned_to_zone)";
$er = $adm->getThisAll($sql);
foreach($er as $v){
    $cadena = $region_id.",";
    $replaced = str_replace($cadena,"", $v->regions_assigned_to_zone);

    $sql = "UPDATE lane_regions SET regions_assigned_to_zone = '$replaced' WHERE id = $v->id";
    $adm->doThis($sql);
}