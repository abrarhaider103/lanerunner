<?php

session_start();

include("../../config.php");
include("ajax_class.php");
extract($_POST);
function roundToNearestMultipleOf50($number)
{
    return round($number / 50) * 50;
}

function genero_datos_chart($dias_previos, $lane_id, $equipment)
{

    global $ac;

    $p_dias = "P" . $dias_previos . "D";
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
            $valor = roundToNearestMultipleOf50($d5d->valor);
        } else {
            $valor = '0';
        }
        $data_5_dias[] = array("fecha" => $fecha_formal, "valor" => $valor);
    }
    return $data_5_dias;
}

$user_id = $_SESSION['customer']->customer_id;

/*
 primero busco si no son de region a region
 */
$main = $origin . " - " . $destination;
$sql = "SELECT lane_id, driving_distance as master_driving_distance, $equipment as master_rate, last_updated  FROM lanes WHERE fantasy_name = '$main'";

$ex = $ac->getThis1($sql);

if ($ex) {
    $res = new stdClass();

    $res->fantasy_name = $main;
    $res->last_updated = date('m-d H:i', strtotime($ex->last_updated));
    $oc = explode(",", $origin);
    $origin_city = $oc[0];
    $origin_state = trim($oc[1]);
    $sql = "SELECT id, lat, lng FROM uscities WHERE city = '$origin_city' AND state_id = '$origin_state'";
    $origin_data = $ac->getThis1($sql);


    $dt = explode(",", $destination);
    $destination_city = $dt[0];
    $destination_state = trim($dt[1]);

    $sql = "SELECT id, lat, lng FROM uscities WHERE city = '$destination_city' AND state_id = '$destination_state'";
    $destination_data = $ac->getThis1($sql);

    $distance_between_requested_cities = $ac->getDrivingDistance($destination_data->lng, $destination_data->lat, $origin_data->lng, $origin_data->lat);
    $res->master_driving_distance = $distance_between_requested_cities;
    $res->distance  = $distance_between_requested_cities;
    $rpm_master = round(($ex->master_rate / $distance_between_requested_cities), 2);


    $directRate = round($ex->master_rate, 0);

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

    $res->rpm_carrier = "$" . round(($rpm_master), 2);
    $res->rpm_shipper = "$" . round(($fairValueBrokerRate / $distance_between_requested_cities), 2);


    $res->carrier = "$" . number_format(roundToNearestMultipleOf50($directRate));
    $res->shipper = "$" . number_format(roundToNearestMultipleOf50($fairValueBrokerRate));


    /*
    0-3000   150 minus 150 plus  EXAMPLE: $2000    1850-2150

3001-7000   200 minus 200 plus

7001-infinity   250 min 250 plus
    */

    if ((int)$directRate <= 3000) {
        $res->slider_min_carrier = number_format(roundToNearestMultipleOf50($directRate - 150));
        $res->slider_max_carrier = number_format(roundToNearestMultipleOf50($directRate + 150));

        $res->slider_min_broker = number_format(roundToNearestMultipleOf50($fairValueBrokerRate - 150));
        $res->slider_max_broker = number_format(roundToNearestMultipleOf50($fairValueBrokerRate + 150));
    } else if ((int)$directRate > 3000 && $directRate  <= 7000) {
        $res->slider_min_carrier = number_format(roundToNearestMultipleOf50($directRate - 200));
        $res->slider_max_carrier = number_format(roundToNearestMultipleOf50($directRate + 200));

        $res->slider_min_broker = number_format(roundToNearestMultipleOf50($fairValueBrokerRate - 200));
        $res->slider_max_broker = number_format(roundToNearestMultipleOf50($fairValueBrokerRate + 200));
    } else {
        $res->slider_min_carrier = number_format(roundToNearestMultipleOf50($directRate - 250));
        $res->slider_max_carrier = number_format(roundToNearestMultipleOf50($directRate + 250));

        $res->slider_min_broker = number_format(roundToNearestMultipleOf50($fairValueBrokerRate - 250));
        $res->slider_max_broker = number_format(roundToNearestMultipleOf50($fairValueBrokerRate + 250));
    }


    $res->lane_id = $ex->lane_id;




    $res->days_5_result = genero_datos_chart(5, $res->lane_id, 'reefer');

    // para un mes
    for ($i = 1; $i < 5; $i++) {
        $date = new DateTime();
        $date->modify('-' . $i . ' week');
        $start = $date->format('Y-m-d');
        $end = $date->modify('+6 days')->format('Y-m-d');

        //echo "Week of $start to $end <br>";

        $sql = "select AVG($equipment) as valor FROM lanes_historic WHERE lane_id = " . $res->lane_id . " AND DATE(last_updated) BETWEEN  '$start' AND '$end'";

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
        $date->modify('-' . $i . ' month');
        $month = $date->format('n');
        $month_name = $date->format('M');
        $year = $date->format('Y');
        $sql = "select AVG($equipment) as valor FROM lanes_historic WHERE lane_id = " . $res->lane_id . " AND MONTH(last_updated) = '$month' AND YEAR(last_updated) = '$year'";
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
        $date->modify('-' . $i . ' month');
        $month = $date->format('n');
        $month_name = $date->format('M');
        $year = $date->format('Y');
        $sql = "select AVG($equipment) as valor FROM lanes_historic WHERE lane_id = " . $res->lane_id . " AND MONTH(last_updated) = '$month' AND YEAR(last_updated) = '$year'";
        $d5d = $ac->getThis1($sql);
        if (is_null($d5d)) {
            $valor = '0';
        } else {

            $valor = $d5d->valor;
        }
        $data_365_dias[] = array("fecha" => $month_name, "valor" => $valor);
    }

    $res->days_365_result = $data_365_dias;
}
// me fijo si no es una linea especial en la tabla nueva.
else {

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
        $last_updated = date('m-d H:i', strtotime('-1 day'));
        $res->last_updated = $last_updated;
    } else {

        $sql = "SELECT lane_id, driving_distance as master_driving_distance, $equipment as master_rate, last_updated  FROM lanes WHERE origin = $origin_id AND destination = $destination_id";
        $res = $ac->getThis1($sql);



        if ((int)$res->master_driving_distance === 0 || $res->master_driving_distance === "") {
            $dd = $ac->getDrivingDistance($lng_from, $lat_from, $lng_to, $lat_to);

            if (intval($dd) === 0) {
            } else {
                $sql = "UPDATE lanes SET driving_distance = '$dd' WHERE lane_id = $res->lane_id";
                $ac->doThis($sql);
                $res->master_driving_distance = $dd;
            }
        }


        $rpm_master = round(($res->master_rate / $res->master_driving_distance), 2);
        $last_updated = date('m-d H:i', strtotime($res->last_updated));
        $res->last_updated = $last_updated;
    }


    // aca ya deberia tener los datos de price y driving distance entre masters para sacar el rpm

    $distance_between_requested_cities = $ac->getDrivingDistance($destination_data->lng, $destination_data->lat, $origin_data->lng, $origin_data->lat);

    $dd = $distance_between_requested_cities;
    $res->distance = $distance_between_requested_cities;

    $directRate = $res->master_rate;

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

    if ((int)$directRate <= 3000) {
        $res->slider_min_carrier = number_format(roundToNearestMultipleOf50($directRate - 150));
        $res->slider_max_carrier = number_format(roundToNearestMultipleOf50($directRate + 150));

        $res->slider_min_broker = number_format(roundToNearestMultipleOf50($fairValueBrokerRate - 150));
        $res->slider_max_broker = number_format(roundToNearestMultipleOf50($fairValueBrokerRate + 150));
    } else if ((int)$directRate > 3000 && $directRate  <= 7000) {
        $res->slider_min_carrier = number_format(roundToNearestMultipleOf50($directRate - 200));
        $res->slider_max_carrier = number_format(roundToNearestMultipleOf50($directRate + 200));

        $res->slider_min_broker = number_format(roundToNearestMultipleOf50($fairValueBrokerRate - 200));
        $res->slider_max_broker = number_format(roundToNearestMultipleOf50($fairValueBrokerRate + 200));
    } else {
        $res->slider_min_carrier = number_format(roundToNearestMultipleOf50($directRate - 250));
        $res->slider_max_carrier = number_format(roundToNearestMultipleOf50($directRate + 250));

        $res->slider_min_broker = number_format(roundToNearestMultipleOf50($fairValueBrokerRate - 250));
        $res->slider_max_broker = number_format(roundToNearestMultipleOf50($fairValueBrokerRate + 250));
    }

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

    $res->rpm_carrier = $rpm_master;
    $res->rpm_shipper = $rpm_shipper;

    $fantasy_name = $origin_res['requested_name'] . " - " . $destination_res['requested_name'];
    $res->fantasy_name = $fantasy_name;




    $res->days_5_result = genero_datos_chart(5, $res->lane_id, $equipment);

    // para un mes
    for ($i = 1; $i < 5; $i++) {
        $date = new DateTime();
        $date->modify('-' . $i . ' week');
        $start = $date->format('Y-m-d');
        $end = $date->modify('+6 days')->format('Y-m-d');

        //echo "Week of $start to $end <br>";

        $sql = "select AVG($equipment) as valor FROM lanes_historic WHERE lane_id = " . $res->lane_id . " AND DATE(last_updated) BETWEEN  '$start' AND '$end'";

        $d5d = $ac->getThis1($sql);
        if ($d5d) {
            $valor = roundToNearestMultipleOf50($d5d->valor);
        } else {
            $valor = '0';
        }
        $data_30_dias[] = array("fecha" => "week $i", "valor" => $valor);
    }
    $res->days_30_result = $data_30_dias;



    for ($i = 0; $i < 6; $i++) {
        $date = new DateTime();
        $date->modify('-' . $i . ' month');
        $month = $date->format('n');
        $month_name = $date->format('M');
        $year = $date->format('Y');
        $sql = "select AVG($equipment) as valor FROM lanes_historic WHERE lane_id = " . $res->lane_id . " AND MONTH(last_updated) = '$month' AND YEAR(last_updated) = '$year'";
        $d5d = $ac->getThis1($sql);
        if ($d5d) {
            $valor = roundToNearestMultipleOf50($d5d->valor);
        } else {
            $valor = '0';
        }
        $data_180_dias[] = array("fecha" => $month_name, "valor" => $valor);
    }

    $res->days_180_result = $data_180_dias;


    for ($i = 0; $i < 12; $i++) {
        $date = new DateTime();
        $date->modify('-' . $i . ' month');
        $month = $date->format('n');
        $month_name = $date->format('M');
        $year = $date->format('Y');
        $sql = "select AVG($equipment) as valor FROM lanes_historic WHERE lane_id = " . $res->lane_id . " AND MONTH(last_updated) = '$month' AND YEAR(last_updated) = '$year'";
        $d5d = $ac->getThis1($sql);
        if (is_null($d5d)) {
            $valor = '0';
        } else {

            $valor = roundToNearestMultipleOf50($d5d->valor);
        }
        $data_365_dias[] = array("fecha" => $month_name, "valor" => $valor);
    }

    $res->days_365_result = $data_365_dias;
}


$res->is_spotter = $ac->get_laner($res->lane_id);

$today = date('Y-m-d');
$sql = "INSERT INTO requested_lanes_history SET fantasy_name = '$res->fantasy_name',
                                            lane_id = $res->lane_id,
                                            driving_distance = '$res->distance',
                                            equipment = '$equipment',
                                            carrier = '$res->carrier',
                                            shipper = '$res->shipper',
                                            rpm_carrier = '$res->rpm_carrier',
                                            rpm_shipper = '$res->rpm_shipper',
                                            user_id = $user_id,
                                            origin_city = '$origin',
                                            destination_city = '$destination',
                                            date_requested = '$today'";

$ac->doThis($sql);


echo json_encode($res);
