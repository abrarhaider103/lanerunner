<?php
session_start();
include("../../config.php");
include("ajax_class.php");

extract($_GET);



for ($i = 1; $i <= 30; $i++) {
    $email = "spotmarket$i@lanerunner.com";
    $sql = "SELECT count(*) as tiene, b.laner_id as new_laner_id FROM lanes_assigned a JOIN laners b ON a.laner_id = b.laner_id WHERE b.email = '$email'";
    $tot = $ac->getThis1($sql);

    if ((int)$tot->tiene < 300) {
        // tiene menos de 300, asigno a este

        $sql = "SELECT laner_id as new_laner_id FROM laners WHERE email = '$email'";
        $est = $ac->getThis1($sql);


        $sql = "UPDATE lanes_assigned SET previous_laner = laner_id WHERE lane_id =  $lane ";
        $ac->doThis($sql);

        $nl = $tot->new_laner_id;
        $sql = "UPDATE lanes_assigned SET laner_id = $est->new_laner_id WHERE lane_id =  $lane ";
        $ac->doThis($sql);

        break;
    }
}
$_SESSION['want_to_learn'] = $_SESSION['want_to_learn'] - 1;

$customer = $_SESSION['customer']->customer_id;
$sql = "UPDATE customers SET want_to_learn = (want_to_learn - 1) WHERE customer_id = $customer";
$ac->doThis($sql);

echo json_encode(1);
