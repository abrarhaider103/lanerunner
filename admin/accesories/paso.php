<?php

include("../../config.php");
include("../adminClass.php");

$circ = $adm->getThisAll("SELECT * FROM main_areas WHERE 1");
$reg = $adm->getThisAll("SELECT * FROM region_main_zones WHERE 1");

/*
 [0] => stdClass Object
        (
            [main_area_id] => 1
            [location] => 42.361495715294275,-122.8835776818821
            [radio] => 106714.23076768518
            [region_main_zone_id] => 61
        )

        [0] => stdClass Object
        (
            [region_id] => 1
            [coordinates] => -118.757712,48.054385/-118.51801,46.937648/-116.215876,47.308019/-116.949962,48.436821/-118.757712,48.054385/
            [region_main_zone_id] => 52
        )

        */

        foreach($circ as $v){
            $sql = "INSERT INTO sub_regions_zones SET master_region_id = $v->region_main_zone_id , 
                                                     sub_region_center = '$v->location', 
                                                     sub_region_radius = '$v->radio'";

            $adm->doThis($sql);
        }

        foreach($reg as $v){
            $sql = "INSERT INTO sub_regions_zones SET master_region_id = $v->region_main_zone_id , 
                                                     sub_region_polygon = '$v->coordinates'";

            $adm->doThis($sql);
        }