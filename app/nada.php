<?php

include("config.php");
include("registration_class.php");

//$rp->upd();
exit;

for($i=15;$i<=17;$i++){

    $email = "guest".$i."@lanerunner.com";
    $pass = "guest".$i;



    $rp->addo_customer($email,$pass);
}
//exit;