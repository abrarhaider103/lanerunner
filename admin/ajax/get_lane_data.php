<?php

include("../../config.php");
include("../adminClass.php");

extract($_POST);
$res = new stdClass();
$main = $origin . " - " . $destination;
$sql = "SELECT * FROM lanes WHERE fantasy_name = '$main'";
$ex = $adm->getThis1($sql);

if ($ex) {
    // es un main region to main region


    $sql = "SELECT b.laner_name, b.full_name, b.email FROM lanes_assigned a JOIN laners b ON a.laner_id = b.laner_id 
            WHERE a.lane_id = " . $ex->lane_id;

    $dedo = $adm->getThis1($sql);

    $res->is_main_to_main = 1;
    $res->lane_id = $ex->lane_id;
    $res->reefer = $ex->reefer;
    $res->van = $ex->van;
    $res->flat = $ex->flat;
    $res->last_updated = $ex->last_updated;
    $res->laner_email = $dedo->email;
    $res->laner_name = $dedo->laner_name;
    $res->full_name = $dedo->full_name;
} else {
    $res->is_main_to_main = 0;
    // no es main region to main region
    // pero primero me fijo en la tabla si no esta definida

    $sql = "SELECT * FROM special_lanes WHERE origin = '$origin' AND destination = '$destination'";
    $sl = $adm->getThis1($sql);

    if ($sl) {
        // ya estaba seteado el special lane este
        /*




*/

        $res = $sl;
    } else {
        // no estaba seteado, tengo que seguir con la busqueda
        $sql = "SELECT region_id, coordinates, center_lat, center_lng, region_name FROM master_regions WHERE 1 ";
        $every_region = $adm->getThisAll($sql);

        $oc = explode(",", $origin);
        $origin_city = $oc[0];
        $origin_state = trim($oc[1]);

        $sql = "SELECT id, lat, lng FROM uscities WHERE city = '$origin_city' AND state_id = '$origin_state'";
        $origin_data = $adm->getThis1($sql);
        $origin_point = $origin_data->lat . " " . $origin_data->lng;
        $res->origin_city_code = $origin_data->id;

        foreach ($every_region as $v) {
            $pol = [];
            $cp = explode("/", $v->coordinates);
            array_pop($cp);
            foreach ($cp as $a) {
                $d = str_replace(",", " ", $a);
                $aq = explode(" ", $d);
                $pol[] = $aq[1] . " " . $aq[0];
            }
            if ($adm->pointInPolygon($origin_point, $pol) === 1) {
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
        $destination_data = $adm->getThis1($sql);
        $destination_point = $destination_data->lat . " " . $destination_data->lng;
        $res->destination_city_code = $destination_data->id;

        foreach ($every_region as $v) {
            $pol = [];
            $cp = explode("/", $v->coordinates);
            array_pop($cp);
            foreach ($cp as $a) {
                $d = str_replace(",", " ", $a);
                $aq = explode(" ", $d);
                $pol[] = $aq[1] . " " . $aq[0];
            }
            if ($adm->pointInPolygon($destination_point, $pol) === 1) {
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

        $res->origin_main_region = $origin_res['master_region_name'];
        $res->destination_main_region = $destination_res['master_region_name'];


        $sql = "SELECT * FROM lanes WHERE origin = " . $origin_res['master_region_id'] . " AND destination = " . $destination_res['master_region_id'];
        $ex = $adm->getThis1($sql);

        $res->lane_id = $ex->lane_id;
        $res->reefer = $ex->reefer;
        $res->van = $ex->van;
        $res->flat = $ex->flat;
        $res->last_updated = $ex->last_updated;

        $sql = "SELECT b.laner_name, b.full_name, b.email FROM lanes_assigned a JOIN laners b ON a.laner_id = b.laner_id 
            WHERE a.lane_id = " . $ex->lane_id;

        $dedo = $adm->getThis1($sql);

        $res->laner_email = $dedo->email;
        $res->laner_name = $dedo->laner_name;
        $res->full_name = $dedo->full_name;
    }
}

header('Content-Type: application/json; charset=utf-8');
$jsonData = json_encode($res);
echo $jsonData;
