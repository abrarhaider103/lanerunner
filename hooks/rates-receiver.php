<?php
include("../config.php");
include("../app/ajax/ajax_class.php");


function logData($requestType, $data) {
    $logFile = 'hook_log.txt';

    $logMessage = date('Y-m-d H:i:s') . " - Request Type: " . $requestType . " - Data: " . $data . PHP_EOL;

    file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
}
$requestType = $_SERVER['REQUEST_METHOD'];


$data = $_REQUEST;

$equipmentMapper = [
    'Van' => 'van',
    'Reefer' => 'reefer',
    'Flatbed' => 'flat'
];

logData("Ratee: ", $data['rate']);
logData("eq_typee: ", $data['eq_type']);

if (isset($data['rate']) && isset($equipmentMapper[$data['eq_type']])) {

    $equipment = $equipmentMapper[$data['eq_type']];
    $origin = $data['origin'];
    $destination = $data['destination'];
    $rate = (float) str_replace(['$', ','], '', $data['rate']);
    if (!$rate) {
        die(json_encode(['status' => 'error', 'message' => 'Invalid rate']));
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

        die(json_encode(['status' => 'success', 'action' => 'insert']));
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

    die(json_encode(['status' => 'success', 'action' => 'update']));
}
