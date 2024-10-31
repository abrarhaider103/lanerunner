<?php
session_start();
include("../../config.php");
include("ajax_class.php");;
$user_id = $_SESSION['customer']->customer_id;


extract($_POST);


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

        break;
    } else {
    }
}

/*
echo "<pre>";
print_r($origin_res);
print_r($destination_res);
*/


$sql = "SELECT region_id, center_lat, center_lng FROM master_regions WHERE region_name = '$origin'";
$or = $ac->getThis1($sql);

if (!$origin_res || !$destination_res) {
    echo "Entra aca";

    echo json_encode(0);
    exit;
}



$origin_id = $origin_res['region_id'];
$lng_from =  $origin_res['requested_lng'];
$lat_from =  $origin_res['requested_lat'];

$sql = "SELECT region_id, center_lat, center_lng FROM master_regions WHERE region_name = '$destination'";
$de = $ac->getThis1($sql);



$destination_id = $destination_res['region_id'];
$lng_to =  $destination_res['requested_lng'];
$lat_to =  $destination_res['requested_lat'];


$sql = "SELECT lane_id, driving_distance, $equipment as directRate  FROM lanes WHERE origin = $origin_id AND destination = $destination_id";
$res = $ac->getThis1($sql);

$directRate = $res->directRate;

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

$res->carrier = "$" . number_format($directRate);
$res->shipper = "$" . number_format($fairValueBrokerRate);

if ($res->driving_distance === "0") {
    $dd = $ac->getDrivingDistance($lng_from, $lat_from, $lng_to, $lat_to);

    if (intval($dd) === 0) {
    } else {
        $sql = "UPDATE lanes SET driving_distance = '$dd' WHERE lane_id = $res->lane_id";
        $ac->doThis($sql);
    }
} else {
    $dd = $res->driving_distance;
}

$carrier_price = str_replace("$", "", $res->carrier);
$carrier_price = str_replace(",", "", $carrier_price);

$shipper_price = str_replace("$", "", $res->shipper);
$shipper_price = str_replace(",", "", $shipper_price);


$res->distance = $dd;

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
$sql = "INSERT INTO requested_lanes_history SET fantasy_name = '$res->fantasy_name',
                                                lane_id = $res->lane_id,
                                                driving_distance = '$dd',
                                                equipment = '$equipment',
                                                carrier = '$res->carrier',
                                                shipper = '$res->shipper',
                                                rpm_carrier = '$res->rpm_carrier',
                                                rpm_shipper = '$res->rpm_shipper',
                                                user_id = $user_id,
                                                date_requested = '$today'";

$ac->doThis($sql);


function genero_datos_chart($dias_previos, $lane_id, $equipment)
{

    global $ac;

    $p_dias = "P".$dias_previos."D";
    $current_date = new DateTime();
    $current_date->sub(new DateInterval($p_dias));
    $cinco_dias_atras = $current_date->format('Y-m-d');

    $start_date = new DateTime($cinco_dias_atras);
    $end_date = new DateTime();
    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($start_date, $interval, $end_date);

    foreach ($daterange as $date) {
        $fecha_buscar = $date->format("Y-m-d");
        $fecha_formal = $date->format("m-d");
        $sql = "select $equipment as valor FROM lanes_historic WHERE lane_id = $lane_id AND DATE(last_updated) = '$fecha_buscar'";

        $d5d = $ac->getThis1($sql);
        if ($d5d) { 
            $valor = $d5d->valor;
        } else {
            $valor = '0';
        }
        $data_5_dias[] = array("fecha" => $fecha_formal, "valor" => $valor);
    }
    return $data_5_dias;
}

$res->days_5_result = genero_datos_chart(5,$res->lane_id,$equipment);

// para un mes
for ($i = 1; $i < 5; $i++) {
    $date = new DateTime();
    $date->modify('-' . $i . ' week');
    $start = $date->format('Y-m-d');
    $end = $date->modify('+6 days')->format('Y-m-d');

    //echo "Week of $start to $end <br>";

    $sql = "select AVG($equipment) as valor FROM lanes_historic WHERE lane_id = ".$res->lane_id." AND DATE(last_updated) BETWEEN  '$start' AND '$end'";

        $d5d = $ac->getThis1($sql);
        if ($d5d) { 
            $valor = $d5d->valor;
        } else {
            $valor = '0';
        }
        $data_30_dias[] = array("fecha" => "week $i", "valor" => $valor);

}
$res->days_30_result = $data_30_dias;



for ($i = 0; $i < 6; $i++) {
    $date = new DateTime();
    $date->modify('-'.$i.' month');
    $month = $date->format('n');
    $month_name = $date->format('M');
    $year = $date->format('Y');
    $sql = "select AVG($equipment) as valor FROM lanes_historic WHERE lane_id = ".$res->lane_id." AND MONTH(last_updated) = '$month' AND YEAR(last_updated) = '$year'";
    $d5d = $ac->getThis1($sql);
    if ($d5d) { 
        $valor = $d5d->valor;
    } else {
        $valor = '0';
    }
    $data_180_dias[] = array("fecha" => $month_name, "valor" => $valor);
}

$res->days_180_result = $data_180_dias;


for ($i = 0; $i < 12; $i++) {
    $date = new DateTime();
    $date->modify('-'.$i.' month');
    $month = $date->format('n');
    $month_name = $date->format('M');
    $year = $date->format('Y');
    $sql = "select AVG($equipment) as valor FROM lanes_historic WHERE lane_id = ".$res->lane_id." AND MONTH(last_updated) = '$month' AND YEAR(last_updated) = '$year'";
    $d5d = $ac->getThis1($sql);
    if (is_null($d5d)) { 
        $valor = '0';
    } else {
        
        $valor = $d5d->valor;
    }
    $data_365_dias[] = array("fecha" => $month_name, "valor" => $valor);
}

$res->days_365_result = $data_365_dias;






echo json_encode($res);
