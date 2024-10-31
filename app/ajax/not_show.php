<?php
session_start();
include("../../config.php");
include("ajax_class.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $ac->storeFormValues($data);
    $ac->update_show_option();
    $_SESSION['customer']->customer_dismiss_modal = $data['customer_dismiss_modal'];
}
