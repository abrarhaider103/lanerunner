<?php
error_reporting(0);
include("login_check.php");
include("config.php");
include("assets/php/quote_class.php");
include("assets/php/svg_class.php");
include("ajax/ajax_class.php");
$ci = $_SESSION['customer']->customer_id;

$sql0 = "SELECT * from requested_lanes_history WHERE user_id = $ci ORDER BY req_id DESC LIMIT 15;";
$pre = $quote->getThisAll($sql0);

$history = []; // Array to store the fetched results
$count = 0; // Counter variable for number of keys

$date = date('Y-m-d H:i:s');
$currentDateTime = new DateTime($date);

foreach ($pre as $c => $v) {
    if ($count >= 15) {
        break; // Exit the loop once 15 different keys are reached
    }

    $fantasy_name = $v->fantasy_name;
    if (!isset($history[$fantasy_name])) {
        $history[$fantasy_name] = $v;
        $count++;
    }
}

$res = '';

if (empty($history)) {
} else {
    foreach ($history as $v) {

        if ((int)$v->driving_distance === 0 || $v->carrier === "$nan" || $v->shipper === "$nan") {
        } else {

            $valor_actual2 = str_replace("$", "", $v->carrier);
            $valor_actual = str_replace(",", "", $valor_actual2);

            $percentageChangeColumn = $v->equipment . '_change_percentage';
            $sql = "SELECT lane_id, $v->equipment as master_rate, $percentageChangeColumn as percentage_change, last_updated  FROM lanes WHERE fantasy_name = '$v->fantasy_name' limit 1";
            $lane = $quote->getThis1($sql);
            $change = $lane->percentage_change;

            /*$sql = "SELECT $v->equipment as valor_previo FROM lanes_historic WHERE lane_id = $v->lane_id ORDER BY last_updated DESC LIMIT 1";
            $pr = $quote->getThis1($sql);
            $valor_previo = $pr->valor_previo;
            $change = round((($valor_actual - $valor_previo) / $valor_previo * 100), 2);*/

            $lastUpdatedDateTime = new DateTime($lane->last_updated);
            $difference = $currentDateTime->diff($lastUpdatedDateTime);
            $hoursDifference = $difference->h + ($difference->days * 24);
            $updatedRates = $lane && $hoursDifference < 2;
            [$origin, $destination] = explode(" - ", $v->fantasy_name);
            $updateBtn = '';
            if ($updatedRates) {
                $updateBtn = '<button class="btn btn-success btn-sm mt-2 btn-update" disabled>Updated</button>';
            } else {
                $updateBtn = '<button class="btn btn-danger btn-sm mt-2 btn-update" onclick="send_rate_request(\'' . $origin . '\', \'' . $destination . '\', \'' . $v->equipment . '\', null, this)">Update</button>';
            }

            $timeAgo = $lane->last_updated ? $ac->timeAgo($lane->last_updated) : '-';


            $res .= '
<div class="row my-1 history-records">
    <div class="col-md-3">
        <div class="d-flex align-items-sm-center mb-1">
            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                <div class="me-2">
                    <span class="text-primary fw-bold d-block fs-4 fantasy_name" id="">' . $v->fantasy_name . '</span>
                </div>
                <span class="badge badge-lg badge-light-success fw-bold my-2" id=""></span>
            </div>
        </div>
    </div>
    <div class="col-md-1">
        <div class="d-flex align-items-sm-center mb-1">
            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                <div class="flex-grow-1 me-2">
                    <span class="text-gray-800 d-block fs-6 align-middle equipment" id="">' . $v->equipment . '</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="timeline">
            <div class="timeline-item align-items-center mb-1">
                <div class="timeline-content m-0">
                    <span class="fs-6 fw-bold text-gray-800" id="rpm_div_broker_">RPM ' . $v->rpm_shipper . '</span>
                </div>
            </div>
            <div class="timeline-item align-items-center">
                <div class="timeline-content m-0">
                    <span class="fs-6 fw-bold text-gray-800" id="distance_div_broker_">DIST ' . round($v->driving_distance, 2) . ' mi</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        Direct Rate:<span class="text-gray-800 fw-bold d-block fs-1 direct-rate"> ' . $v->carrier . '</span>
    </div>
    <div class="col-md-2">
        Broker Rate:<span class="text-gray-800 fw-bold d-block fs-1 broker-rate"> ' . $v->shipper . '</span>
    </div>
    <div class="col-md-1 d-flex flex-column flex-center">
        <div class="px-2">
            <span class="fw-bold text-gray-800 times-ago "> '. $timeAgo .' </span>
        </div>';

            if ($change < 0) { //red
                $svg_icon = "danger";
                $svg_file = "arr065";
                $svg_textcolor = "danger";

                $res .= '
        <div class="px-2">
            <!--begin::Label-->
            <span class="badge badge-light-' . $svg_icon . ' fs-base ' . $svg_textcolor . '">' .
                    getSvgIcon('assets/media/icons/duotune/arrows/' . $svg_file . '.svg', 'svg-icon-2 svg-icon-' . $svg_textcolor) . ' ' . $change . ' % </span>
            <!--end::Label-->
        </div>';
            } else if ($change > 0) { //green
                $svg_icon = "success";
                $svg_file = "arr066";
                $svg_textcolor = "success";

                $res .= '
        <div class="px-2">
            <!--begin::Label-->
            <span class="badge badge-light-' . $svg_icon . ' fs-base ' . $svg_textcolor . '">' .
                    getSvgIcon('assets/media/icons/duotune/arrows/' . $svg_file . '.svg', 'svg-icon-2 svg-icon-' . $svg_textcolor) . ' ' . $change . ' % </span>
            <!--end::Label-->
        </div>';
            } else { // yellow
                $svg_icon = "warning";
                $svg_file = "arr090";
                $svg_textcolor = "text-gray-700";

                $res .= '
        <div class="px-2">
            <!--begin::Label-->
            <span class="badge badge-light-' . $svg_icon . ' fs-base ' . $svg_textcolor . '">' .
                    getSvgIcon('assets/media/icons/duotune/arrows/' . $svg_file . '.svg', 'svg-icon-2 svg-icon-' . $svg_textcolor) . ' ' . $change . ' % </span>
            <!--end::Label-->
        </div>';
            }

            $res .= '
        </div>
        <div class="col-1">'.$updateBtn.'</div>
        </div>
        <div class="separator separator-dashed my-2"></div>';
        }
    }
}

echo $res;
