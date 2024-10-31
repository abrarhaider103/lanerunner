<?php
include("login_check.php");

include("assets/php/quote_class.php");

$ui = $_SESSION['customer']->customer_id;

$sql = "SELECT COUNT(*) AS record_count  FROM rate_change_alert WHERE user_id = $ui";
$res = $quote->getThisAll($sql);

if($res[0]->record_count <= 5 ){
    $fantasy_name = $_POST['alert_fantasy'];
    $direct_rate = str_replace("$", "", $_POST['alert_direct']);
    $direct_rate = str_replace(",", "", $direct_rate);

    $broker_rate = str_replace("$", "", $_POST['alert_broker']);
    $broker_rate = str_replace(",", "", $broker_rate);

    $price_fluctuation = str_replace("$", "", $_POST['alert_valor']);

    $destination_email = $_POST['alert_email'];
    $equipment = $_POST['equipment'];
    if($equipment == 'flat'){
        $equipment = "flatbed";
    }

    $sql = "INSERT INTO rate_change_alert SET user_id = $ui, 
                                              fantasy_name = '$fantasy_name', 
                                              direct_rate = '$direct_rate', 
                                              broker_rate = '$broker_rate',
                                              price_fluctuation = '$price_fluctuation',
                                              destination_email = '$destination_email',
                                              equipment = '$equipment'";

    $quote->doThis($sql);
}else{
    echo 1;
}

/*
<pre>Array
(
    [alert_valor] => $300
    [alert_email] => gutibs@gmail.com
    [alert_direct] => $3,550
    [alert_broker] => $3,800
    [alert_fantasy] => Tulsa, OK - Trenton, NJ
    [alert_lane_id] => 10368
)
*/
