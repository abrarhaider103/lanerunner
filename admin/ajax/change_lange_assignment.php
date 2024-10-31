<?php
include("../../config.php");
include("../adminClass.php");

extract($_POST);

for ($i = 1; $i <= 30; $i++) {
    $email = "spotmarket$i@lanerunner.com";
    $sql = "SELECT count(*) as tiene, b.laner_id as new_laner_id FROM lanes_assigned a JOIN laners b ON a.laner_id = b.laner_id WHERE b.email = '$email'";
    $tot = $adm->getThis1($sql);

    if ((int)$tot->tiene  < 300) {
        // tiene menos de 300, asigno a este

        $sql = "SELECT laner_id as new_laner_id FROM laners WHERE email = '$email'";
        $est = $adm->getThis1($sql);


        $sql = "UPDATE lanes_assigned SET previous_laner = laner_id WHERE lane_id =  $lane ";
        $adm->doThis($sql);

        $nl = $tot->new_laner_id;
        $sql = "UPDATE lanes_assigned SET laner_id = $est->new_laner_id WHERE lane_id =  $lane ";
        $adm->doThis($sql);

        break;
    }
}
