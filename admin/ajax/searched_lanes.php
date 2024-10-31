<?php
include("../../config.php");
include("../adminClass.php");

if (isset($_POST['searchLane'])) {
    $fantasyName = filter_input(INPUT_POST, 'fantasyName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $sql = "select concat(c.customer_firstName, ' ', c.customer_lastName) as customer_name, c.customer_email, h.fantasy_name, DATE_FORMAT(h.date_requested, '%d %b %Y') as date_requested
                from requested_lanes_history as h left join customers c on h.user_id = c.customer_id
                where fantasy_name = '$fantasyName' order by h.req_id desc;";

    $results = $adm->get_this_all($sql);

    echo json_encode(['data' => $results]);
}