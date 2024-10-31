<?php

class Ajax_class
{

    private $customer_dismiss_modal;
    private $customer_id;

    public function __construct($data = array())
    {

        if (isset($data['customer_dismiss_modal'])) {
            $this->customer_dismiss_modal = stripslashes(strip_tags($data['customer_dismiss_modal']));
        }
        if (isset($data['customer_id'])) {
            $this->customer_id = stripslashes(strip_tags($data['customer_id']));
        }
    }

    public function storeFormValues($params)
    {
        $this->__construct($params);
    }

    public function genero_datos_chart($dias_previos, $lane_id, $equipment)
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
                $valor = self::roundToNearestMultipleOf50($d5d->valor);
            } else {
                $valor = '0';
            }
            $data_5_dias[] = array("fecha" => $fecha_formal, "valor" => $valor);
        }
        return $data_5_dias;
    }

    public function roundToNearestMultipleOf50($number)
    {
        return number_format(round($number / 50) * 50);
    }

    public function get_laner($lane_id)
    {
        $sql = "SELECT a.is_spotter FROM laners a JOIN lanes_assigned b ON a.laner_id = b.laner_id WHERE b.lane_id = $lane_id";
        $da = self::getThis1($sql);
        return $da->is_spotter;
    }


    public function region_pertenece($ciudad)
    {
        $oc = explode(",", $ciudad);
        $origin_city = $oc[0];
        $origin_state = trim($oc[1]);

        $sql = "SELECT id, lat, lng FROM uscities WHERE city = '$origin_city' AND state_id = '$origin_state'";
        $origin_data = self::getThis1($sql);
        $origin_point = $origin_data->lat . " " . $origin_data->lng;


        $sql = "SELECT region_id, coordinates, center_lat, center_lng, region_name FROM master_regions WHERE 1 ";
        $every_region = self::getThisAll($sql);

        foreach ($every_region as $v) {
            $pol = [];
            $cp = explode("/", $v->coordinates);
            array_pop($cp);
            foreach ($cp as $a) {
                $d = str_replace(",", " ", $a);
                $aq = explode(" ", $d);
                $pol[] = $aq[1] . " " . $aq[0];
            }
            if (self::pointInPolygon($origin_point, $pol) === 1) {
                $origin_res['region_id'] = $v->region_id;
                $origin_res['requested_lat'] = $origin_data->lat;
                $origin_res['requested_lng'] = $origin_data->lng;
                $origin_res['master_region_name'] = $v->region_name;
                return $origin_res;
            } else {
            }
        }
    }


    public function rpm($lane_id, $driving_distance, $equipment)
    {
        $sql = "SELECT lane_id, driving_distance as master_driving_distance, $equipment as master_rate, last_updated  FROM lanes WHERE lane_id = $lane_id";
        $ex = self::getThis1($sql);
        $master_rpm = round($ex->master_rate / $ex->master_driving_distance, 3);
        return $master_rpm;
    }


    public function update_show_option()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE customers SET customer_dismiss_modal = :customer_dismiss_modal
            WHERE customer_id = :customer_id";

            $stmt = $con->prepare($sql);
            $stmt->bindValue("customer_dismiss_modal", $this->customer_dismiss_modal, PDO::PARAM_INT);
            $stmt->bindValue("customer_id", $_SESSION['customer']->customer_id, PDO::PARAM_INT);
            $stmt->execute();
            return 1;
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "add customer function error";
        }
    }

    public function add_customer()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT IGNORE INTO customers SET customer_name = :customer_name,  
                                                     customer_password  = AES_ENCRYPT(:customer_password, '" . PWHASH . "'), 
                                                     customer_email = :customer_email, 
                                                     customer_active = 1,
                                                     customer_registered_on = CURDATE()";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("customer_name", $this->customer_name, PDO::PARAM_STR);
            $stmt->bindValue("customer_password", $this->customer_password, PDO::PARAM_STR);
            $stmt->bindValue("customer_email", $this->customer_email, PDO::PARAM_STR);
            $stmt->execute();
            $nUser =  $con->lastInsertId();
            return $nUser;
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "add customer function error";
        }
    }

    public function doThis($sql)
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare($sql);
            $stmt->execute();
            return 1;
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "doThis error";
            return 0;
        }
    }

    public function dame_fair_value_rate($directRate, $equipment)
    {
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
        return $fairValueBrokerRate;
    }

    public function dame_slider($tipo, $rate)
    {

        if ((int)$rate <= 3000) {
            if ($tipo === 'min') {
                return self::roundToNearestMultipleOf50($rate - 150);
            }
            if ($tipo === 'max') {
                return self::roundToNearestMultipleOf50($rate + 150);
            }
        } else if ((int)$rate > 3000 && $rate  <= 7000) {
            if ($tipo === 'min') {
                return self::roundToNearestMultipleOf50($rate - 200);
            }
            if ($tipo === 'max') {
                return self::roundToNearestMultipleOf50($rate + 200);
            }
        } else {
            if ($tipo === 'min') {
                return self::roundToNearestMultipleOf50($rate - 250);
            }
            if ($tipo === 'max') {
                return self::roundToNearestMultipleOf50($rate + 250);
            }
        }
    }

    public function getThis1($sql)
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $valid = $stmt->fetch(PDO::FETCH_OBJ);
            return $valid;
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo $sql;
            return 0;
        }
    }

    public static function getThisAll($sql)
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $valid = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $valid;
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo $sql;
            return 0;
        }
    }

    public function getThis1Array($sql)
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $valid = $stmt->fetch(PDO::FETCH_ASSOC);
            return $valid;
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo $sql;
            return 0;
        }
    }

    public function getThisAllArray($sql)
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $valid = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $valid;
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo $sql;
            return 0;
        }
    }

    public function dame_coordenadas($ciudad)
    {
        $oc = explode(",", $ciudad);
        $city = $oc[0];
        $state = trim($oc[1]);
        $sql = "SELECT id, lat, lng FROM uscities WHERE city = '$city' AND state_id = '$state'";
        $data = self::getThis1($sql);
        return $data;
    }




    public function getDrivingDistance($lng_from, $lat_from, $lng_to, $lat_to)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/v2/directions/driving-car?api_key=5b3ce3597851110001cf6248e5487bc1a0c8407cbefaa6fdd3dca833&start=$lng_from,$lat_from&end=$lng_to,$lat_to&units=mi");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Accept: application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8"
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        //return $response;
        $data = json_decode($response);
        if (isset($data->features[0]->properties->summary->distance)) {
            $dist = $data->features[0]->properties->summary->distance * 0.000621371;
        } else {
            $dist = 0;
        }
        return round($dist, 2);
    }


    /* 
    esto use para conseguir el centro de los poligonos

    $sql = "select * from master_regions WHERE center_lat = '' limit 5;";
$er = $ac->getThisAll($sql);

foreach ($er as $v) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'http://api.geonames.org/searchJSON?name=Dover&adminCode1=DE&country=US&username=gutibs');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);

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
    $r = json_decode($result);
    $lat = $r->geonames[0]->lat;
    $lng = $r->geonames[0]->lng;

    $sql = "UPDATE master_regions SET center_lat = '$lat', center_lng = '$lng' WHERE region_id = ".$v->region_id;
    $ac->doThis($sql);

}

*/

    function pointInPolygon($point, $polygon, $pointOnVertex = true)
    {
        $this->pointOnVertex = $pointOnVertex;

        // Transform string coordinates into arrays with x and y values
        $point = $this->pointStringToCoordinates($point);
        $vertices = array();
        foreach ($polygon as $vertex) {
            $vertices[] = $this->pointStringToCoordinates($vertex);
        }

        // Check if the point sits exactly on a vertex
        if ($this->pointOnVertex == true and $this->pointOnVertex($point, $vertices) == true) {
            //return "vertex";
            return 1;
        }

        // Check if the point is inside the polygon or on the boundary
        $intersections = 0;
        $vertices_count = count($vertices);

        for ($i = 1; $i < $vertices_count; $i++) {
            $vertex1 = $vertices[$i - 1];
            $vertex2 = $vertices[$i];
            if ($vertex1['y'] == $vertex2['y'] and $vertex1['y'] == $point['y'] and $point['x'] > min($vertex1['x'], $vertex2['x']) and $point['x'] < max($vertex1['x'], $vertex2['x'])) { // Check if point is on an horizontal polygon boundary
                //return "boundary";
                return 1;
            }
            if ($point['y'] > min($vertex1['y'], $vertex2['y']) and $point['y'] <= max($vertex1['y'], $vertex2['y']) and $point['x'] <= max($vertex1['x'], $vertex2['x']) and $vertex1['y'] != $vertex2['y']) {
                $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x'];
                if ($xinters == $point['x']) { // Check if point is on the polygon boundary (other than horizontal)
                    //return "boundary";
                    return 1;
                }
                if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
                    $intersections++;
                }
            }
        }
        // If the number of edges we passed through is odd, then it's in the polygon. 
        if ($intersections % 2 != 0) {
            //return "inside";
            return 1;
        } else {
            //return "outside";
            return 0;
        }
    }
    function pointOnVertex($point, $vertices)
    {
        foreach ($vertices as $vertex) {
            if ($point == $vertex) {
                return true;
            }
        }
    }

    function pointStringToCoordinates($pointString)
    {
        $coordinates = explode(" ", $pointString);
        return array("x" => $coordinates[0], "y" => $coordinates[1]);
    }



    public function getDistance($latitude1, $longitude1, $latitude2, $longitude2)
    {
        $earth_radius = 6371;

        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * asin(sqrt($a));
        $d = $earth_radius * $c;

        return $d;
    }
}
$ac = new Ajax_class;
