<?php
include("config.php");
include("assets/php/quote_class.php");

extract($_GET);

$sql = "DELETE FROM rate_change_alert WHERE alert_id = $alert";
$quote->doThis($sql);
