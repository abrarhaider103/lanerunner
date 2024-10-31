<?php
session_start();

include("../../config.php");
include("ajax_class.php");


$sql = "DELETE FROM requested_lanes_history WHERE driving_distance = 0;";
$ac->doThis($sql);

exit;
function roundToNearestMultipleOf50($number)
{
    return round($number / 50) * 50;
}

/*
$sql = "update uscities SET lng = '-89.40123', lat = '43.07305' WHERE  id = 1840002915;";
$ac->doThis($sql);

exit;
*/
/*
30.3005
-97.7522


43.07305

-89.40123
*/
$origin = "Madison, WI";
$destination =  "Austin, TX";
$equipment = 'reefer';

$sql = "SELECT region_id, coordinates, center_lat, center_lng, region_name FROM master_regions WHERE 1 ";
$every_region = $ac->getThisAll($sql);

// trabajo origin

$oc = explode(",", $origin);
$origin_city = $oc[0];
$origin_state = trim($oc[1]);

$sql = "SELECT id, lat, lng FROM uscities WHERE city = '$origin_city' AND state_id = '$origin_state'";
$origin_data = $ac->getThis1($sql);
$origin_point = $origin_data->lat . " " . $origin_data->lng;

foreach ($every_region as $v) {
    $pol = [];
    $cp = explode("/", $v->coordinates);
    array_pop($cp);
    foreach ($cp as $a) {
        $d = str_replace(",", " ", $a);
        $aq = explode(" ", $d);
        $pol[] = $aq[1] . " " . $aq[0];
    }
    if ($ac->pointInPolygon($origin_point, $pol) === 1) {
        $origin_res['region_id'] = $v->region_id;
        $origin_res['requested_name'] = $origin;
        $origin_res['requested_lat'] = $origin_data->lat;
        $origin_res['requested_lng'] = $origin_data->lng;
        $origin_res['master_region_name'] = $v->region_name;
        $origin_res['master_region_id'] = $v->region_id;
        $origin_res['master_region_center_lat'] = $v->center_lat;
        $origin_res['master_region_center_lng'] = $v->center_lng;
        break;
    } else {
    }
}

// trabajo destination

$dt = explode(",", $destination);
$destination_city = $dt[0];
$destination_state = trim($dt[1]);

$sql = "SELECT id, lat, lng FROM uscities WHERE city = '$destination_city' AND state_id = '$destination_state'";
$destination_data = $ac->getThis1($sql);
$destination_point = $destination_data->lat . " " . $destination_data->lng;

foreach ($every_region as $v) {
    $pol = [];
    $cp = explode("/", $v->coordinates);
    array_pop($cp);
    foreach ($cp as $a) {
        $d = str_replace(",", " ", $a);
        $aq = explode(" ", $d);
        $pol[] = $aq[1] . " " . $aq[0];
    }
    if ($ac->pointInPolygon($destination_point, $pol) === 1) {
        $destination_res['region_id'] = $v->region_id;
        $destination_res['requested_name'] = $destination;
        $destination_res['requested_lat'] = $destination_data->lat;
        $destination_res['requested_lng'] = $destination_data->lng;
        $destination_res['master_region_name'] = $v->region_name;
        $destination_res['master_region_id'] = $v->region_id;
        $destination_res['master_region_center_lat'] = $v->center_lat;
        $destination_res['master_region_center_lng'] = $v->center_lng;

        break;
    } else {
    }
}

if (!$origin_res || !$destination_res) {
    echo json_encode(0);
    exit;
}

$origin_id = $origin_res['region_id'];
$lng_from =  $origin_res['requested_lng'];
$lat_from =  $origin_res['requested_lat'];


$destination_id = $destination_res['region_id'];
$lng_to =  $destination_res['requested_lng'];
$lat_to =  $destination_res['requested_lat'];

if ($origin_id === $destination_id) {
    $rpm_master = 2;
    $last_updated = date('Y-m-d', strtotime('-1 day'));
} else {
    $sql = "SELECT lane_id, driving_distance as master_driving_distance, $equipment as master_rate, last_updated  FROM lanes WHERE origin = $origin_id AND destination = $destination_id";
    $res = $ac->getThis1($sql);

    if ($res->master_driving_distance === "0" || $res->master_driving_distance === "") {
        $dd = $ac->getDrivingDistance($lng_from, $lat_from, $lng_to, $lat_to);
        if (intval($dd) === 0) {
        } else {
            $sql = "UPDATE lanes SET driving_distance = '$dd' WHERE lane_id = $res->lane_id";
            $ac->doThis($sql);
            $res->master_driving_distance = $dd;
        }
    }
    $rpm_master = round(($res->master_rate / $res->master_driving_distance), 2);
    $last_updated = $res->last_updated;
}

// aca ya deberia tener los datos de price y driving distance entre masters para sacar el rpm

// ahora tengo que buscar la distancia entre las ciudades reales y multiplicar por el rpm
$sql = "SELECT distance FROM distance_between_cities WHERE (origin = $origin_data->id AND destination = $destination_data->id) OR (origin = $destination_data->id AND destination = $origin_data->id)";
$dic_cities = $ac->getThis1($sql);

if (!$dic_cities || $dic_cities->distance === "0") {
    $distance_between_requested_cities = $ac->getDrivingDistance($destination_data->lng, $destination_data->lat, $origin_data->lng, $origin_data->lat);
    $sql = "INSERT INTO distance_between_cities SET distance = '$distance_between_requested_cities',
                                                    origin = $origin_data->id,
                                                    destination = $destination_data->id";
    $ac->doThis($sql);



    if (intval($distance_between_requested_cities) === 0) {
        $distance_between_requested_cities = 1;
    }
} else {

    $distance_between_requested_cities = $dic_cities->distance;
}
$dd = $distance_between_requested_cities;
$res->distance = $distance_between_requested_cities;

$directRate = round(($rpm_master * $distance_between_requested_cities), 0);

if ($directRate >= 0 && $directRate <= 1200) {
    $fairValueBrokerRate = $directRate + 200;
} elseif ($directRate >= 1201 && $directRate <= 2000) {
    $fairValueBrokerRate = $directRate + 250;
} elseif ($directRate >= 2001 && $directRate <= 3600) {
    $fairValueBrokerRate = $directRate + 300;
} elseif ($directRate >= 3601 && $directRate <= 5000) {
    $fairValueBrokerRate = $directRate + 350;
} elseif ($directRate >= 5001 && $directRate <= 6500) {
    $fairValueBrokerRate = $directRate + 400;
} elseif ($directRate >= 6501 && $directRate <= 7800) {
    $fairValueBrokerRate = $directRate + 450;
} elseif ($directRate >= 7801 && $directRate <= 9000) {
    $fairValueBrokerRate = $directRate + 500;
} elseif ($directRate >= 9001 && $directRate <= 10200) {
    $fairValueBrokerRate = $directRate + 550;
} elseif ($directRate >= 10201 && $directRate <= 11500) {
    $fairValueBrokerRate = $directRate + 600;
} else {
    $fairValueBrokerRate = $directRate + 700;
}

if ($equipment === "van") {
    $fairValueBrokerRate = $fairValueBrokerRate - 50;
}
if ($equipment === "flat") {
    $fairValueBrokerRate = $fairValueBrokerRate + 50;
}

$res->carrier = "$" . number_format(roundToNearestMultipleOf50($directRate));
$res->shipper = "$" . number_format(roundToNearestMultipleOf50($fairValueBrokerRate));



$carrier_price = str_replace("$", "", $res->carrier);
$carrier_price = str_replace(",", "", $carrier_price);

$shipper_price = str_replace("$", "", $res->shipper);
$shipper_price = str_replace(",", "", $shipper_price);



if (intval($dd) === 0) {
    $rpm_carrier = "-";
    $rpm_shipper = "-";
} else {

    $rpm_carrier = "$" . round(($carrier_price / $dd), 2);
    $rpm_shipper = "$" . round(($shipper_price / $dd), 2);
}

$res->rpm_carrier = $rpm_carrier;
$res->rpm_shipper = $rpm_shipper;

$fantasy_name = $origin_res['requested_name'] . " - " . $destination_res['requested_name'];
$res->fantasy_name = $fantasy_name;
$today = date('Y-m-d');






echo "<pre>";
print_r($res);
