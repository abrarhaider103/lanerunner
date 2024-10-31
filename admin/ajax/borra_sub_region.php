<?php
extract($_POST);
include("../../config.php");
include("../adminClass.php");

$sql = "DELETE FROM sub_regions_zones WHERE sub_region_zone_id = $region_id";

$adm->doThis($sql);
