<?php
session_start();

include("../../vendor/autoload.php");
include("../../config.php");
include("ajax_class.php");

// Pilibos Ranch, CA - Brooklyn, NY
$res = new stdClass();
extract($_POST);

$user_id = $_SESSION['customer']->customer_id;

/*
 primero busco si no son de region a region
 */

$main = $origin . " - " . $destination;
//$sql = "SELECT lane_id, driving_distance as master_driving_distance, $equipment as master_rate, last_updated  FROM lanes WHERE fantasy_name = '$main'";

function updateOrInsertRates($origin, $destination, $equipment, $ac) {
    $rate = $ac->fetchRate($origin, $destination, $equipment);
    if ($rate == false) {
        return $rate;
    }

    $brokerColumnName = "cambio_" . $equipment;
    $fairValueBrokerRate = $ac->dame_fair_value_rate($rate, $equipment);
    $fantasyName = $origin . " - " . $destination;

    $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT lane_id, reefer, van, flat  FROM lanes WHERE fantasy_name = :fantasyName";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':fantasyName', $fantasyName);
    $stmt->execute();
    $lane = $stmt->fetch(PDO::FETCH_OBJ);
    $date = date('Y-m-d H:i:s');

    if (!isset($lane) || !$lane) {
        $co = $ac->dame_coordenadas($origin);
        $cd = $ac->dame_coordenadas($destination);
        $drivingDistance = ($co->lng && $co->lat && $cd->lng && $cd->lat) ?
            $ac->getDrivingDistance($co->lng, $co->lat, $cd->lng, $cd->lat)
            : 0;

        $sql = "SELECT region_id FROM master_regions WHERE region_name = :origin";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':origin', $origin);
        $stmt->execute();
        $masterOriginObj = $stmt->fetch(PDO::FETCH_OBJ);
        $originId = @$masterOriginObj->region_id ?? 0;

        $sql = "SELECT region_id FROM master_regions WHERE region_name = :destination";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':destination', $destination);
        $stmt->execute();
        $masterDestinationObj = $stmt->fetch(PDO::FETCH_OBJ);
        $destinationId = @$masterDestinationObj->region_id ?? 0;

        $medida = 1;
        $sql = "INSERT INTO lanes SET fantasy_name = :fantasyName, origin = :origin, destination = :destination, driving_distance = :driving_distance, $equipment = :rate, $brokerColumnName = :broker_rate, medida = :medida, last_updated = :last_updated";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':fantasyName', $fantasyName);
        $stmt->bindParam(':origin', $originId);
        $stmt->bindParam(':destination', $destinationId);
        $stmt->bindParam(':driving_distance', $drivingDistance);
        $stmt->bindParam(':rate', $rate);
        $stmt->bindParam(':broker_rate', $fairValueBrokerRate);
        $stmt->bindParam(':last_updated', $date);
        $stmt->bindParam(':medida', $medida);
        $stmt->execute();

        return true;
    }


    $percentageDifference = 0;
    if ($lane->{$equipment}) {
        $difference = $rate - $lane->{$equipment};
        $percentageDifference = ($difference / $lane->{$equipment}) * 100;
    }

    $percentageColumn = $equipment . '_change_percentage';
    $sql = "UPDATE lanes SET $equipment = :rate, $brokerColumnName = :broker_rate, $percentageColumn = :percentage_difference, last_updated = :last_updated, rates_requested=0 WHERE lane_id = :laneId";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':rate', $rate);
    $stmt->bindParam(':broker_rate', $fairValueBrokerRate);
    $stmt->bindParam(':percentage_difference', $percentageDifference);
    $stmt->bindParam(':laneId', $lane->lane_id);
    $stmt->bindParam(':last_updated', $date);
    $stmt->execute();

    return true;
}

$action = updateOrInsertRates($origin, $destination, $equipment, $ac);
if (!$action) {
    $ac->reportRateError();

    $res = new stdClass();
    $res->error = 1;
    $res->message = "Our rate system requires a deeper search to secure your spot market rate. Please initiate another search.";
    die(json_encode($res));
}

$res = $ac->getLaneRates($origin, $destination, $equipment, $ac);

//if ($pull_rates) {
//    $res = longPollRates($origin, $destination, $equipment, $ac);
//} else {
//    $laneRates = getLaneRates($origin, $destination, $equipment, $ac);
//    $res = empty($laneRates) ? longPollRates($origin, $destination, $equipment, $ac) : $laneRates;
//}

$res->days_5_result = $ac->genero_datos_chart(5, $res->lane_id, 'reefer');

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

$res->is_spotter = $ac->get_laner($res->lane_id);
$today = date('Y-m-d');

if ($pull_rates == 'false') {
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
}
function checkAndDeleteHistoryEntries($ac) {
    $user_id = $_SESSION['customer']->customer_id;
    $count_sql = "SELECT COUNT(*) as count FROM requested_lanes_history";
    $count_result = $ac->getThis1($count_sql);
    $count = $count_result->count;
    if ($count > 10) {
$sql = "DELETE FROM requested_lanes_history WHERE user_id = $user_id AND req_id NOT IN (SELECT req_id FROM ( SELECT req_id FROM requested_lanes_history where user_id = $user_id ORDER BY req_id DESC LIMIT 11) AS last_11 )";
$req_res = $ac->doThis($sql);
}
}
checkAndDeleteHistoryEntries($ac);


echo json_encode($res);
