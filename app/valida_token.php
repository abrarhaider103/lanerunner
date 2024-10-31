<?php
include("config.php");
include("registration_class.php");
if (isset($_GET['token']) && trim($_GET['token']) !== '') {
    $rp->storeFormValues($_GET);
    $customer = $rp->login_token();
    if (!$customer) {
        header("location:401.php");
    } else {
        session_start();
        $_SESSION['logged'] = 1;
        $_SESSION['customer'] = $customer;
        $_SESSION['want_to_learn'] = $_SESSION['customer']->want_to_learn; 
        
        header("location:dashboard.php");
    }
} else {
    header("location:401.php");
}
