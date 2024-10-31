<?php
include("loginCheck.php");
include("../config.php");
include("adminClass.php");

$date = date('Y-m-d');

foreach($_POST as $c => $v){
    $e = explode("-",$c);
    $state = $e[1];
    
    $sql = "SELECT COUNT(*) as habia FROM load_to_truck WHERE date = '$date' AND state_id = $state";
    $ex = $adm->getThis1($sql);
    if($ex->habia === "1"){
    $sql = "UPDATE load_to_truck SET load_to_truck_val = '$v' WHERE date = '$date' AND state_id = $state";
       
    } else {
    $sql = "INSERT INTO load_to_truck SET date = '$date', state_id = $state, load_to_truck_val = '$v'";
    
    }
    
    $adm->doThis($sql);
    
}

header("location:dashboard.php");
