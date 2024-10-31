<?php
        include("../../config.php");
        include("../adminClass.php");

          
/*
Array
(
    [fantasy_name] => miami FL to Seattle WA
    [origin] => 44
    [main_quote] => 25000
    [zone_1] => 20000
    [regions_zone1] => ["45"]
    [zone_2] => 15000
    [regions_zone2] => ["110"]
    [zone_3] => 10000
    [regions_zone3] => ["77"]
    [zone_4] => 5000
    [regions_zone4] => ["59"]
    [zone_5] => 3000
    [regions_zone5] => ["53","52"]
    [zone_6] => 0
    [regions_zone6] => ["51"]
    [user_assigned] => Array
        (
            [0] => 20
        )

        */



        extract($_POST);



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


    $sql = "UPDATE lanes SET origin = '$origin', lane_cost = '$main_quote', user_assigned = '$users_assigned_list', fantasy_name = '$fantasy_name' WHERE lane_id = $lane_id";
    $adm->doThis($sql);



if(is_array($zone1_regions) && !empty($zone1_regions)) {
    $z1r = implode(",",$zone1_regions);
    $sql = "UPDATE  lane_regions SET  regions_assigned_to_zone = '$z1r', zone_discount = '$zone_1' WHERE lane_id = $lane_id AND zone_number = 1";
    $adm->doThis($sql);
} else {
    $sql = "UPDATE  lane_regions SET  regions_assigned_to_zone = '', zone_discount = '$zone_1' WHERE lane_id = $lane_id AND zone_number = 1";
    $adm->doThis($sql);
}

if(is_array($zone2_regions) && !empty($zone2_regions)) {
    $z2r = implode(",",$zone2_regions);
    $sql = "UPDATE  lane_regions SET  regions_assigned_to_zone = '$z2r', zone_discount = '$zone_2' WHERE lane_id = $lane_id AND zone_number = 2";
    $adm->doThis($sql);
} else {
    $sql = "UPDATE  lane_regions SET  regions_assigned_to_zone = '', zone_discount = '$zone_2' WHERE lane_id = $lane_id AND zone_number = 2";
    $adm->doThis($sql);
}

if(is_array($zone3_regions) && !empty($zone3_regions)) {
    $z3r = implode(",",$zone3_regions);
    $sql = "UPDATE  lane_regions SET  regions_assigned_to_zone = '$z3r', zone_discount = '$zone_3' WHERE lane_id = $lane_id AND zone_number = 3";
    $adm->doThis($sql);
} else {
    $sql = "UPDATE  lane_regions SET  regions_assigned_to_zone = '', zone_discount = '$zone_3' WHERE lane_id = $lane_id AND zone_number = 3";
    $adm->doThis($sql);
}

if(is_array($zone4_regions) && !empty($zone4_regions)) {
    $z4r = implode(",",$zone4_regions);
    $sql = "UPDATE  lane_regions SET  regions_assigned_to_zone = '$z4r', zone_discount = '$zone_4' WHERE lane_id = $lane_id AND zone_number = 4";
    $adm->doThis($sql);
} else {
    $sql = "UPDATE  lane_regions SET  regions_assigned_to_zone = '', zone_discount = '$zone_4' WHERE lane_id = $lane_id AND zone_number = 4";
    $adm->doThis($sql);
}

if(is_array($zone5_regions) && !empty($zone5_regions)) {
    $z5r = implode(",",$zone5_regions);
    $sql = "UPDATE  lane_regions SET  regions_assigned_to_zone = '$z5r', zone_discount = '$zone_5' WHERE lane_id = $lane_id AND zone_number = 5";
    $adm->doThis($sql);
} else {
    $sql = "UPDATE  lane_regions SET  regions_assigned_to_zone = '', zone_discount = '$zone_5' WHERE lane_id = $lane_id AND zone_number = 5";
    $adm->doThis($sql);
}

if(is_array($zone6_regions) && !empty($zone6_regions)) {
    $z6r = implode(",",$zone6_regions);
    $sql = "UPDATE  lane_regions SET  regions_assigned_to_zone = '$z6r', zone_discount = '$zone_6' WHERE lane_id = $lane_id AND zone_number = 6";
    $adm->doThis($sql);
} else {
    $sql = "UPDATE  lane_regions SET  regions_assigned_to_zone = '', zone_discount = '$zone_6' WHERE lane_id = $lane_id AND zone_number = 6";
    $adm->doThis($sql);
}
echo 1;
