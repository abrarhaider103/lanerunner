<?php

/*
  NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR
  NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR
  NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR
  NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR
  NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR
  NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR
  NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR
  NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR
  NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR
  NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.openrouteservice.org/v2/directions/driving-hgv');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"coordinates\":[[-68.49575272381487,45.37138055888466],[-66.78446052904513,45.87819266148914]],\"radiuses\":[50000,50000],\"units\":\"mi\"}");

$headers = array();
$headers[] = 'Content-Type: application/json; charset=utf-8';
$headers[] = 'Accept: application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8';
$headers[] = 'Authorization: 5b3ce3597851110001cf6248e5487bc1a0c8407cbefaa6fdd3dca833';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

echo "<pre>";

$data = json_decode($result);

print_r($data->routes[0]->geometry);
$str = str_replace('\\', '\\\\', $data->routes[0]->geometry);
echo "<br>".$str;

  NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR
  NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR
  NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR
  NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR
  NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR
  NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR
  NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR
  NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR
  NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR
  NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR NO BORRAR



*/

// curl 'http://router.project-osrm.org/route/v1/driving/13.388860,52.517037;13.397634,52.529407;13.428555,52.523219?overview=false'


include("/opt/bitnami/apache/htdocs/config.php");
include("/opt/bitnami/apache/htdocs/admin/adminClass.php");

 $sql = "SELECT distance_id, region_from, region_to FROM distance_between_regions WHERE osm_routed = 0 ORDER BY distance_id LIMIT 15";

// $sql = "SELECT distance_id, region_from, region_to FROM distance_between_regions WHERE distance_id = 3384";



$reg = $adm->getThisAll($sql);

$USERAGENT = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.16; rv:85.0) Gecko/20100101 Firefox/85.0';

foreach($reg as $v){

    $sql1 = "SELECT center_lat, center_lng FROM master_regions WHERE region_id = $v->region_from";
    $cO = $adm->getThis1($sql1);
    $lng_from = $cO->center_lng;
    $lat_from = $cO->center_lat;

    $sql2 = "SELECT center_lat, center_lng FROM master_regions WHERE region_id = $v->region_to";
    $cD = $adm->getThis1($sql2);
    $lng_to = $cD->center_lng;
    $lat_to = $cD->center_lat;

    
$travel = $lng_from.",".$lat_from.";".$lng_to.",".$lat_to;
$search_url = "http://router.project-osrm.org/route/v1/driving/$travel?overview=false";

$httpOptions = [
    "http" => [
        "method" => "GET",
        "header" => "User-Agent: USERAGENT"
    ]
];

$streamContext = stream_context_create($httpOptions);
$json = file_get_contents($search_url, false, $streamContext);


$res = json_decode($json);

if($res->code === "Ok"){
    $distance_meters = $res->routes[0]->distance;
    $distance_miles = round(($distance_meters / 1609.34),2);

    $sql = "UPDATE distance_between_regions SET road_distance = '$distance_miles', osm_routed = 1 WHERE distance_id = $v->distance_id";
    echo "SI<br>";
} else {
    $sql = "UPDATE distance_between_regions SET road_distance = '', osm_routed = 2 WHERE distance_id = $v->distance_id";
    echo "NO<br>";
}

$adm->doThis($sql);

} 

