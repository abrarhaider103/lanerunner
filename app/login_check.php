<?php
include("config.php");
include("registration_class.php");

session_start();


/*
 * $date1 = "2023-09-15";
$date2 = "2023-09-25";

// Create DateTime objects from the date strings
$datetime1 = new DateTime($date1);
$datetime2 = new DateTime($date2);

// Calculate the difference between the two dates
$interval = $datetime1->diff($datetime2);

// Get the number of days
$days = $interval->days;

// Output the result
echo "The number of days between $date1 and $date2 is: $days days";

 */

if (empty($_SESSION) || empty($_SESSION['customer'])) {
    session_destroy();
    unset($_SESSION);
    header("location:index.php");
} else if (isset($_SESSION['customer'])) {
//    $result_loginToken = $rp->getLoginToken($_SESSION['customer']->customer_id);
//    if (isset($result_loginToken->customer_token) && ($result_loginToken->customer_token != "")) {
//        $loginToken = $result_loginToken->customer_token;
//
//        if ($_SESSION['loginToken'] != $loginToken) {
//            session_destroy();
//            unset($_SESSION);
//            header("location:index.php");
//        }
//    }

    $customerAuthSessionId = $rp->getAuthSessionId($_SESSION['customer']->customer_id);
    if (session_id() != $customerAuthSessionId) {
        session_destroy();
        unset($_SESSION);
        header("location:index.php");
    }

    $inicio_el = $_SESSION['customer']->customer_registered_on;
    $hoy = date('Y-m-d');
    $datetime1 = new DateTime($inicio_el);
    $datetime2 = new DateTime($hoy);
    $interval = $datetime2->diff($datetime1);
    $days = $interval->days;
    // if((int)$days < 3){
    //     $_SESSION['contar_busquedas'] = 1;
    //     $_SESSION['busquedas'] = (int)$_SESSION['customer']->number_of_searches;
    // } else {
    $_SESSION['contar_busquedas'] = 0;
    // }
}
