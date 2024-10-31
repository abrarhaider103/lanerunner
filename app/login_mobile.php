<?php
header('Content-Type: application/json');
include("config.php");
include("registration_class.php");
$rp->storeFormValues($_POST);
$customer = $rp->login_customer();


if (!$customer) {
    $res = array("token" => "", "error" => 1);
} else {
    session_start();
    $_SESSION['logged'] = 1;
    $_SESSION['customer'] = $customer;
    $_SESSION['want_to_learn'] = $customer->want_to_learn;
    $token = md5(uniqid(mt_rand(), true));
    $rp->set_token($token, $customer->customer_id);
    $res = array("token" => $token, "error" => 0);
}

echo json_encode($res);