<?php


include("/opt/bitnami/apache2/htdocs/config.php");
include("/opt/bitnami/apache2/htdocs/app/ajax/ajax_class.php");



$sql = "SELECT *  FROM lanes WHERE medida = 0 LIMIT 30";
$cada = $ac->getThisAll($sql);



/*
    what happens here is that we have a table called lanes, and we have a column called medida.

    [8880] => stdClass Object
        (
            [lane_id] => 10676
            [fantasy_name] => Wichita, KS - Nashville, TN
            [origin] => 78
            [destination] => 224
            [reefer] => 2454
            [van] => 1750
            [flat] => 1953
            [last_updated] => 2023-07-26 14:08:58
            [driving_distance] => 0
            [medida] => 0
        )
        /*
        */

        foreach($cada as $v) {

            $sql = "SELECT center_lat, center_lng FROM master_regions WHERE region_id = $v->origin";
            $or = $ac->getThis1($sql);

            $sql = "SELECT center_lat, center_lng FROM master_regions WHERE region_id = $v->destination";
            $de = $ac->getThis1($sql);


            $distancia = $ac->getDrivingDistance($or->center_lng, $or->center_lat, $de->center_lng, $de->center_lat);

            if (is_float($distancia) && $distancia !== 0.0) {
                $sql = "UPDATE lanes set driving_distance = '$distancia', medida = 1 WHERE lane_id = $v->lane_id";
                $ac->doThis($sql);
               
                


            } else {
                $distancia_recta = $ac->getDistance($or->center_lat, $or->center_lng, $de->center_lat, $de->center_lng);
                $sql = "UPDATE lanes set driving_distance = '$distancia_recta', medida = 2 WHERE lane_id = $v->lane_id";
                $ac->doThis($sql);
            }
            
            


        }