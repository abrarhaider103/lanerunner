<?php
session_start();
include("../../config.php");
include("ajax_class.php");

/*
Array ( [logged] => 1
[customer] => stdClass Object (
[customer_id] => 1
[customer_firstName] => Guti
[customer_lastName] => Benito
[customer_email] => gutibs@gmail.com
[customer_active] => 1
[customer_dismiss_modal] => 1
[customer_stripe_customer] =>
[customer_stripe_plan] =>
[customer_phone] => 60028405
[customer_type_subscription] =>
[want_to_learn] => 50
[customer_registered_on] => 2023-10-01
[number_of_searches] => 0 )
[want_to_learn] => 50
[contar_busquedas] => 1
[busquedas] => 0 )
*/

// if($_SESSION['contar_busquedas'] === 1){
// // tengo que buscar en la tabla cuantas le quedan y restar una y hacer un update a la tabla, o restar una del session, hacer el update y actualizar la tabla
// $customer_id = $_SESSION['customer']->customer_id;

// $sql = "SELECT number_of_searches FROM customers WHERE customer_id = $customer_id";
//     $busquedas = $ac->getThis1($sql);
//     $busquedas_quedan = 7 - $busquedas->number_of_searches;
//     $res = array("quedan" => $busquedas_quedan);

//     $sql = "UPDATE customers SET number_of_searches = (number_of_searches + 1) WHERE customer_id = $customer_id";
//     $ac->doThis($sql);

//     $_SESSION['busquedas'] = 7 - $busquedas->number_of_searches;
//     echo json_encode($res);

// }