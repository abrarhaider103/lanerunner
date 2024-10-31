<?php
include("../../config.php");
include("../adminClass.php");


extract($_POST);

print_r($_POST);
exit;
/*
Array
(
    [fantasy_name] => from a to B
    [origin] => 142
    [main_quote] => 500
    [regions_zone1] => ["145","188","77"]
    [zone_2] => 
    [regions_zone2] => []
    [zone_3] => 
    [regions_zone3] => []
    [zone_4] => 
    [regions_zone4] => []
    [zone_5] => 
    [regions_zone5] => []
    [zone_6] => 
    [regions_zone6] => []
    [user_assigned] => Array
        (
            [0] => 1
        )

)
*/

if (isset($users_assigned)) {
    $users_assigned_list =  implode(',', $users_assigned);
} else {
    $users_assigned_list = '';
}

$zone1_regions = json_decode($regions_zone1);
$zone2_regions = json_decode($regions_zone2);
$zone3_regions = json_decode($regions_zone3);
$zone4_regions = json_decode($regions_zone4);
$zone5_regions = json_decode($regions_zone5);
$zone6_regions = json_decode($regions_zone6);

if ($zone_2 !== '') {
    $region2_price = round(($main_quote - $zone_2), 2);
}
if ($zone_3 !== '') {
    $region3_price = round(($main_quote - $zone_3), 2);
}
if ($zone_4 !== '') {
    $region4_price = round(($main_quote - $zone_4), 2);
}
if ($zone_5 !== '') {
    $region5_price = round(($main_quote - $zone_5), 2);
}
if ($zone_6 !== '') {
    $region6_price = round(($main_quote - $zone_6), 2);
}


if (isset($quote_assignment)) {
    $sql = "DELETE FROM main_quotes WHERE  quote_assignment = $quote_assignment ";
    $adm->doThis($sql);

    $sql = "UPDATE quote_assignment SET origin = '$origin', user_assigned = '$users_assigned_list' WHERE  quote_assignment = $quote_assignment ";
    $adm->doThis($sql);
} else {
    $sql = "INSERT INTO quote_assignment SET origin = '$origin', user_assigned = '$users_assigned_list', fantasy_name = '$fantasy_name'";
    $quote_assignment = $adm->insertReturnLastId($sql);
}

foreach ($zone1_regions as $destination1) {
    $sql = "INSERT INTO main_quotes SET quote_assignment = $quote_assignment, origin = $origin, destination = $destination1, quote = '$main_quote', zone = 1, user_assigned = '$users_assigned_list'";
    $ver2 = $adm->doThis($sql);
}
if (!empty($zone2_regions)) {
    foreach ($zone2_regions as $destination2) {
        $sql = "INSERT INTO main_quotes SET quote_assignment = $quote_assignment, origin = $origin, destination = $destination2, quote = $region2_price, zone = 2, user_assigned = '$users_assigned_list'";
        $ver2 = $adm->doThis($sql);
    }
}

if (!empty($zone3_regions)) {
    foreach ($zone3_regions as $destination3) {
        $sql = "INSERT INTO main_quotes SET quote_assignment = $quote_assignment, origin = $origin, destination = $destination3, quote = $region3_price, zone = 3, user_assigned = '$users_assigned_list'";
        $ver2 = $adm->doThis($sql);
    }
}

if (!empty($zone4_regions)) {
    foreach ($zone4_regions as $destination4) {
        $sql = "INSERT INTO main_quotes SET quote_assignment = $quote_assignment, origin = $origin, destination = $destination4, quote = $region4_price, zone = 4, user_assigned = '$users_assigned_list'";
        $ver2 = $adm->doThis($sql);
    }
}

if (!empty($zone5_regions)) {
    foreach ($zone5_regions as $destination5) {
        $sql = "INSERT INTO main_quotes SET quote_assignment = $quote_assignment, origin = $origin, destination = $destination5, quote = $region5_price, zone = 5, user_assigned = '$users_assigned_list'";
        $ver2 = $adm->doThis($sql);
    }
}

if (!empty($zone6_regions)) {
    foreach ($zone6_regions as $destination6) {
        $sql = "INSERT INTO main_quotes SET quote_assignment = $quote_assignment, origin = $origin, destination = $destination6, quote = $region6_price, zone = 6, user_assigned = '$users_assigned_list'";
        $ver2 = $adm->doThis($sql);
    }
}




echo 1;
