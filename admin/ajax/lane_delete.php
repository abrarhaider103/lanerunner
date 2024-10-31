<?php
include("../../config.php");
include("../adminClass.php");

extract($_GET);

$sql = "DELETE FROM lanes WHERE lane_id = $lane_id";
$adm->doThis($sql);


$sql = "DELETE FROM lane_regions WHERE lane_id = $lane_id";
$adm->doThis($sql);


header("location:../all_lanes.php");