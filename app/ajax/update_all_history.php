<?php
session_start();

include("../../config.php");
include("ajax_class.php");

global $ac;
$con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$history_names = [];
$resultData = array();
$jsonData = $_POST['allFantasyNames'];
$allFantasyNames = json_decode($jsonData, true);

foreach ($allFantasyNames as $fantasyName) {
    $origin = $fantasyName['origin'];
    $destination = $fantasyName['destination'];
    $equipment = $fantasyName['equipment'];

    $history_names[] = [
        'origin' => $origin,
        'destination' => $destination,
        'rental_type' => $equipment
    ];
}

$curlResponse = array();
$curlHandles = array();
$apiEndpoint = 'http://161.35.216.210:5000/api/scrape';
$headers = array(
    'Content-Type: application/json',
    'X-API-Key:1yjelvQ23WSVxZOyASfviZcRngSQ06qL3nVxzfYN'
);
// initialize multi_curl
$multiHandle = curl_multi_init();
foreach ($history_names as $record) {
    $curlHandle = curl_init($apiEndpoint);
    curl_setopt($curlHandle, CURLOPT_POST, true);
    curl_setopt($curlHandle, CURLOPT_POSTFIELDS, json_encode($record));
    curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curlHandle, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);

    curl_multi_add_handle($multiHandle, $curlHandle);
    $curlHandles[] = $curlHandle;
}
// Execute the multi-request
do {
    $status = curl_multi_exec($multiHandle, $active);
    if ($status > 0) {
        echo "cURL multi-exec error: " . curl_multi_strerror($status);
    }
    curl_multi_select($multiHandle);
} while ($status === CURLM_CALL_MULTI_PERFORM || $active);

foreach ($curlHandles as $curlHandle) {
    $curlResponse = curl_multi_getcontent($curlHandle);
    $responseData = json_decode($curlResponse, true);

    if (isset($responseData)) {
        $response = $responseData["task"]["data"];
        $rate = $responseData["task"]["rate"];
        if ($rate < 0) {
            continue;
        }

        $origin = $response["origin"];
        $destination = $response["destination"];
        $equipment = $response["rental_type"];
        $result = updateRates($rate, $origin, $destination, $equipment, $ac, $con);
        $resultData[] = $result;
    } else {
        echo "No Data Found";
    }
    curl_multi_remove_handle($multiHandle, $curlHandle);
    curl_close($curlHandle);
}

curl_multi_close($multiHandle);
echo json_encode($resultData);

function updateRates($rate, $origin, $destination, $equipment, $ac, $con)
{
    $unformattedDate = new DateTime();
    $date = $unformattedDate->format('Y-m-d H:i:s');
    $brokerColumnName = "cambio_" . $equipment;
    $fairValueBrokerRate = $ac->dame_fair_value_rate($rate, $equipment);

    $lane = $ac->getLaneRates($origin, $destination, $equipment, $ac);

    $percentageDifference = 0;
    if ($lane->directRate) {
        $difference = $rate - $lane->directRate;
        $percentageDifference = ($difference / $lane->directRate) * 100;
    }

    $lane->directRate = $rate;
    $lane->brokerRate = $fairValueBrokerRate;
    $lane->change_percentage = $percentageDifference;
    $lane->last_updated = $date;

    $percentageColumn = $equipment . '_change_percentage';
    $sql = "UPDATE lanes SET $equipment = :rate, $brokerColumnName = :broker_rate, $percentageColumn = :percentage_difference, last_updated = :last_updated, rates_requested=0 WHERE lane_id = :laneId";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':rate', $rate);
    $stmt->bindParam(':broker_rate', $fairValueBrokerRate);
    $stmt->bindParam(':percentage_difference', $percentageDifference);
    $stmt->bindParam(':laneId', $lane->lane_id);
    $stmt->bindParam(':last_updated', $date);
    $stmt->execute();

    return $lane;
}

    