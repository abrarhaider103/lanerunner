<?php
include("config.php");
include("../class/class_customer.php");

session_start();

$ui = $_SESSION['customer']->customer_id;

// Get data from form 
$firstName = stripslashes(strip_tags($_POST['firstName']));
$lastName = stripslashes(strip_tags($_POST['lastName']));
$phone = stripslashes(strip_tags($_POST['phone']));
$email = stripslashes(strip_tags($_POST['email']));

$sql = "UPDATE customers
        SET customer_firstName = '$firstName',
            customer_lastName = '$lastName',
            customer_phone = '$phone',
            customer_email = '$email'
        WHERE customer_id = $ui";

$customer->do_this($sql);