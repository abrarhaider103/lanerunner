<?php
session_start();
include("../../config.php");
include("ajax_class.php");;

extract($_GET);

$sql = "SELECT b.region_name FROM master_regions b JOIN lanes a ON b.region_id = a.origin WHERE a.lane_id = $sec";
$or = $ac->getThis1($sql);

$sql = "SELECT b.region_name FROM master_regions b JOIN lanes a ON b.region_id = a.destination WHERE a.lane_id = $sec";
$de = $ac->getThis1($sql);

$res = array("origin" => $or->region_name, "destination" => $de->region_name);

echo json_encode($res);