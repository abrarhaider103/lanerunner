<?php
session_start();
$sessionVariable = $_SESSION['customer']->customer_dismiss_modal;
echo $sessionVariable;