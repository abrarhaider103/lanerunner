<?php

include("../loginCheck.php");
include("../../config.php");
include("../adminClass.php");

    if($_POST['form_type']=='insert_customer')
    {
        $adm->addCustomer($_POST);
        header("location:../customerslist.php");
    }

    if($_POST['form_type']=='update_customer')
    {
        $adm->updateCustomer($_POST);
        header("location:../customerslist.php");
    }
    if($_GET['type']=='cdelete')
    {
        $adm->deleteCustomer($_GET['cid']);
        header("location:../customerslist.php");
    }

    if($_POST['form_type']=='insert_team')
    {
        $adm->addTeam($_POST);
        header("location:../teamlist.php");
    }

    if($_POST['form_type']=='update_team')
    {
        $adm->updateTeam($_POST);
        header("location:../teamlist.php");
    }

    if($_GET['type']=='tdelete')
    {
        $adm->deleteTeam($_GET['tid']);
        header("location:../teamlist.php");
    }

?>