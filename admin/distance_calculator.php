<?php
include("../config.php");
include("adminClass.php");


$s = "SELECT region_id, center_lat, center_lng FROM master_regions WHERE canada = 0 AND region_name != '' AND distanced = 0 ORDER BY region_id LIMIT 1";
$main = $adm->getThis1($s);


$primary_region_id = $main->region_id;
$primary_lat = $main->center_lat;
$primary_lng = $main->center_lng;


$s = "SELECT region_id, center_lat, center_lng FROM master_regions WHERE canada = 0 AND region_name != '' AND region_id != $primary_region_id";
$rest = $adm->getThisAll($s);

echo "<pre>";
foreach($rest as $v) {
            $distancia = getDistance($primary_lat, $primary_lng, $v->center_lat, $v->center_lng);
            echo $distancia."<br>";
            $rt = $v->region_id;
            $sql = "INSERT INTO distance_between_regions SET region_from = $primary_region_id, region_to = $rt,distance = '$distancia'";
            $adm->doThis($sql);
}


$s = "UPDATE master_regions SET distanced = 1 WHERE region_id = $primary_region_id";
$adm->doThis($s);


function getDistance($latitude1, $longitude1, $latitude2, $longitude2) {
    
    $earth_radius = 3959;
 
    $dLat = deg2rad($latitude2 - $latitude1);
    $dLon = deg2rad($longitude2 - $longitude1);
 
    $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);
    $c = 2 * asin(sqrt($a));
    $d = $earth_radius * $c;
 
    return round($d,2);
    
}