<?php
        include("../../config.php");
        include("../adminClass.php");
        extract($_POST);

echo "<pre>";
print_r($_POST);
exit;
if (isset($user_assigned)) {
    $users_assigned_list =  implode(',', $user_assigned);
} else {
    $users_assigned_list = '';
}

$zone1_regions = json_decode($regions_zone1);
$zone2_regions = json_decode($regions_zone2);
$zone3_regions = json_decode($regions_zone3);
$zone4_regions = json_decode($regions_zone4);
$zone5_regions = json_decode($regions_zone5);
$zone6_regions = json_decode($regions_zone6);


    $sql = "INSERT INTO lanes SET  lane_cost = '$main_quote', user_assigned = '$users_assigned_list', fantasy_name = '$fantasy_name'";
    $lane_id = $adm->insertReturnLastId($sql);



if(is_array($zone1_regions) && !empty($zone1_regions)) {
    $z1r = implode(",",$zone1_regions);
    $sql = "INSERT INTO lane_regions SET lane_id = $lane_id, zone_number = 1, regions_assigned_to_zone = '$z1r', zone_discount = '$zone1'";
    $adm->doThis($sql);
}

if(is_array($zone2_regions) && !empty($zone2_regions)) {
    $z2r = implode(",",$zone2_regions);
    $sql = "INSERT INTO lane_regions SET lane_id = $lane_id, zone_number = 2, regions_assigned_to_zone = '$z2r', zone_discount = '$zone2'";
    $adm->doThis($sql);
}

if(is_array($zone3_regions) && !empty($zone3_regions)) {
    $z3r = implode(",",$zone3_regions);
    $sql = "INSERT INTO lane_regions SET lane_id = $lane_id, zone_number = 3, regions_assigned_to_zone = '$z3r', zone_discount = '$zone3'";
    $adm->doThis($sql);
}

if(is_array($zone4_regions) && !empty($zone4_regions)) {
    $z4r = implode(",",$zone4_regions);
    $sql = "INSERT INTO lane_regions SET lane_id = $lane_id, zone_number = 4, regions_assigned_to_zone = '$z4r', zone_discount = '$zone4'";
    $adm->doThis($sql);
}

if(is_array($zone5_regions) && !empty($zone5_regions)) {
    $z5r = implode(",",$zone5_regions);
    $sql = "INSERT INTO lane_regions SET lane_id = $lane_id, zone_number = 5, regions_assigned_to_zone = '$z5r', zone_discount = '$zone5'";
    $adm->doThis($sql);
}

if(is_array($zone6_regions) && !empty($zone6_regions)) {
    $z6r = implode(",",$zone6_regions);
    $sql = "INSERT INTO lane_regions SET lane_id = $lane_id, zone_number = 6, regions_assigned_to_zone = '$z6r', zone_discount = '$zone6'";
    $adm->doThis($sql);
}
exit;

echo 1;
