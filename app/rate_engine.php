<?php
error_reporting(0);
include("login_check.php");
include("config.php");
include("assets/php/quote_class.php");
include("assets/php/svg_class.php");
include("../helpers/location.helper.php");
include("ajax/ajax_class.php");


if (isset($_GET['cityQuery'])) {
    $cityQuery = $_GET['cityQuery'];
    $options = searchCities($cityQuery);
    header('Content-Type: application/json');
    die(json_encode($options));
}

$sql = "SELECT region_id, region_name FROM master_regions";
$re = $quote->getThisAll($sql);

$regions = '';
foreach ($re as $v) {
    $regions .= '"' . $v->region_name . '", ';
}
$regions = substr($regions, 0, -2);

$ci = $_SESSION['customer']->customer_id;

$date = date('Y-m-d H:i:s');
$currentDateTime = new DateTime($date);

/*
$sql = "UPDATE lanes SET  $equipment = '".$rate."' WHERE origin = $origin AND destination = $destination";
$res = $adm->doThis($sql);
*/


$sql0 = "SELECT * from requested_lanes_history WHERE user_id = $ci ORDER BY req_id DESC LIMIT 10";
$pre = $quote->getThisAll($sql0);

$history = []; // Array to store the fetched results

foreach ($pre as $c => $v) {
    $history[] = $v;
}

/*
echo "<pre>";
print_r($history);
exit;


$sql0 = "SELECT DISTINCT(lane_id) as lane_id from requested_lanes_history WHERE user_id = $ci ORDER BY req_id DESC LIMIT 15;";
$pre = $quote->getThisAll($sql0);



foreach ($pre as $v) {
    $sql = "SELECT  fantasy_name,
                driving_distance,
                equipment,
                carrier,
                shipper,
                rpm_carrier,
                rpm_shipper,
                date_requested,
                req_id,
                lane_id,
                user_id
        from requested_lanes_history WHERE
            lane_id = $v->lane_id
        AND user_id = $ci
        AND ( driving_distance != 0 OR carrier != '$nan' OR shipper != '$nan') ;";

    $history[] = $quote->getThis1($sql);
}
*/

$sql = 'SELECT population, CONCAT(city,", ",state_id) as city FROM uscities order by population DESC';
$all_c = $quote->getThisAll($sql);

//este es ejemplo del porcentaje que se debe calcular para mostrar en search history
//$sql = "SELECT *,
//((van_loads_0 - van_loads_1) / ((van_loads_0 + van_loads_1) / 2)) * 100 AS percentage,
//((flat_loads_0 - flat_loads_1) / ((flat_loads_0 + flat_loads_1) / 2)) * 100 AS percentage_or FROM load_counts WHERE id = 1";
//$ta = $quote->getThis1($sql);

$sql = "SELECT * FROM market_conditions_data WHERE id = 1";
$este = $quote->getThis1($sql);
$texto = urldecode($este->market_conditions_text);

?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <?php include("includes/head.php"); ?>

    <link rel="stylesheet" href="assets/css/jquery.typeahead.min.css">
    <link href="assets/apex.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="assets/css/custom.res.css">


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <style>
        .history-records:hover {
            /*border-radius: 4px;*/
            border-top: 1px solid grey;
            border-bottom: 1px solid grey !important;
            /*box-shadow: 0px 9px 4px -6px grey;*/
            background-color: var(--kt-highlight-tr);
        }

        .d-w-110.btn-danger:disabled {
            width: 110px;
        }

        /*        .set-loader-1{*/
        /*            display: none;*/
        /*    position: fixed;*/
        /*    left: 0;*/
        /*    top: 0;*/
        /*    height: 100vh;*/
        /*    width: 100%;*/
        /*    background-color: #FFF;*/
        /*    z-index: 99999999;*/
        /*    flex-direction: column;*/
        /*    align-items: center;*/
        /*    justify-content: center;*/
        /*}*/
        /*.set-loader-row-1{*/
        /*    justify-content:center;*/
        /*}*/
        /*.set-loader-div-1 img{*/
        /*    width:100%;*/
        /*}*/
        /*.set-loader-div-1 h2{*/
        /*    color:#000;*/
        /*    font-size: 2vw;*/
        /*    text-align:center;*/
        /*    margin:0;*/
        /*}*/
        /*.set-loader-1.setloaderdiv.setloaderdivactive{*/
        /*  display:flex !important;*/
        /*}*/

        .set-loader-1 {
            display: flex;
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            /* background-color: #FFF; */
            z-index: 99999999;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: none;
        }

        .set-loader-row-1 {
            justify-content: center;
        }

        .set-loader-div-1 img {
            width: 40%;
            animation: slideRight 20s linear infinite;
        }

        @keyframes slideRight {
            0% {
                transform: translateX(-163%);
            }
            100% {
                transform: translateX(164%);
            }
        }

        .set-loader-div-1 h2 {
            color: #000;
            font-size: 2vw;
            text-align: center;
            margin: 2rem 0 0 0;
        }

        .set-loader-div-2 {
            background-color: #f9f6f2;
            width: 100%;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
        }

        .set-loader-div-3 {
            background-color: #00847d;
            height: 10px;
            animation: slideLoading 20s linear 1;
        }

        @keyframes slideLoading {
            0% {
                width: 0%;
            }
            100% {
                width: 100%;
            }
        }


        .typeahead__list {
            height: 160px;
            overflow: scroll;
            scrollbar-color: #c1c1c1 #f1f1f1;
        }

        .typeahead__list:hover {
            height: 160px;
            overflow: scroll;
            scrollbar-color: #c1c1c1 #f1f1f1;
        }

        .typeahead__list::-webkit-scrollbar-thumb {
            background-color: #c1c1c1;
        }

        .typeahead__list::-webkit-scrollbar-track {
            background-color: #f1f1f1;
        }

        .typeahead__list::-webkit-scrollbar-thumb:hover {
            background-color: #c1c1c1 !important;
        }

        .p-show-1, .p-show-2, .p-show-3 {
            /* height:60px; */
            line-height: 1;
            font-size: 14px;
        }

        .set-the-height-1 {
            height: auto !important;
        }

        @media only screen and (min-width: 320px) and (max-width: 529px) {
            .set-loader-div-1 h2 {
                font-size: 4vw;
            }
        }

        @media only screen and (min-width: 375px) and (max-width: 424px) {
        }

        @media only screen and (min-width: 414px) and (max-width: 425px) {
        }

        @media only screen and (min-width: 425px) and (max-width: 529px) {
        }

        @media only screen and (min-width: 530px) and (max-width: 767px) {
            .set-loader-div-1 img {
                width: 25%;
            }

            .set-loader-div-1 h2 {
                font-size: 3vw;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .set-loader-div-1 img {
                width: 25%;
            }

            .set-loader-div-1 h2 {
                font-size: 3vw;
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1199px) {
            .set-loader-div-1 img {
                width: 30%;
            }

            .card .card-body {
                padding: 1rem 1rem;
            }

            .set-the-col-div-1 {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                width: 16.66666667%;
            }

            .set-the-col-div-2 {
                width: 16.66666667%;
            }
        }

        @media only screen and (min-width: 1260px) and (max-width: 1365px) {
            .set-loader-div-1 h2 {
                font-size: 1vw;
            }
        }

        @media only screen and (min-width: 1366px) and (max-width: 1439px) {
            .set-loader-div-1 h2 {
                font-size: 1vw;
            }
        }

        @media only screen and (min-width: 1440px) and (max-width: 1599px) {
            .set-loader-div-1 h2 {
                font-size: 1vw;
            }
        }

        @media only screen and (min-width: 1600px) and (max-width: 1800px) {
            .set-loader-div-1 h2 {
                font-size: 1vw;
            }
        }

        @media only screen and (min-width: 1680px) and (max-width: 1919px) {
        }

        @media only screen and (min-width: 1920px) and (max-width: 2100px) {
            .set-loader-div-1 h2 {
                font-size: 1vw;
            }
        }

        @media only screen and (min-width: 2560px) {
        }
    </style>

</head>
<!--end::Head-->
<!--begin::Body-->

<body data-kt-name="good" id="kt_app_body" data-kt-app-layout="light-sidebar" data-kt-app-sidebar-enabled="true"
      data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
      data-kt-app-sidebar-push-footer="true" class="app-default">

<!--<div class="set-loader-1 setloaderdiv">-->
<!--    <div class="container">-->
<!--        <div class="row set-loader-row-1">-->
<!--            <div class="col-lg-2 col-lg-2 col-sm-2 col-2">-->
<!--                <div class="set-loader-div-1">-->
<!--                <img src="../images/loaderlogo.png" alt="">-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="row set-loader-row-1">-->
<!--            <div class="col-lg-2 col-lg-2 col-sm-2 col-2">-->
<!--                <div class="set-loader-div-1">-->
<!--                <img src="../images/truck.gif" alt="">-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="row set-loader-row-1">-->
<!--            <div class="col-lg-12 col-lg-12 col-sm-12 col-12">-->
<!--                <div class="set-loader-div-1">-->
<!--                    <h2>Your spot market rate is on its way...</h2>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!--begin::Theme mode setup on page load-->
<script>
    var defaultThemeMode = "light";
    var themeMode;
    if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-theme-mode");
        } else {
            if (localStorage.getItem("data-theme") !== null) {
                themeMode = localStorage.getItem("data-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }
        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-theme", themeMode);
    }
</script>
<!--end::Theme mode setup on page load-->
<!--begin::App-->
<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <!--begin::Page-->
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        <?php include("includes/header.php"); ?>
        <!--begin::Wrapper-->
        <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
            <!--begin::sidebar-->
            <?php include("includes/left_bar.php"); ?>
            <!--end::sidebar-->
            <!--begin::Main-->
            <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                <!--begin::Content wrapper-->
                <div class="d-flex flex-column flex-column-fluid">
                    <!--begin::Content-->
                    <div id="kt_app_content" class="app-content flex-column-fluid">
                        <!--begin::Content container-->
                        <div id="kt_app_content_container" class="app-container container-fluid">
                            <!-- the content -->


                            <div class="row g-5 g-xl-10">

                                <?php
                                for ($i = 1; $i < 3; $i++) {
                                    ?>

                                    <!--begin::Col-->
                                    <div class="col-xl-6 mb-xl-10">
                                        <!--begin::List widget 10-->
                                        <div class="card card-flush set-the-height-1 overflow-hidden position-relative">
                                            <!--begin::Header-->

                                            <div class="row">
                                                <div class="card-header pt-7">
                                                    <div class="col-12">
                                                        <!--begin::Title-->
                                                        <h3 class="card-title">
                                                            <span class="card-label fw-bold text-gray-800">Search #<?php echo $i; ?></span>
                                                        </h3>
                                                        <!--end::Title-->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="card-header pt-7">
                                                    <div class="col-12">
                                                        <div class="typeahead__container">
                                                            <label for="origin_<?php echo $i; ?>"
                                                                   class="required form-label">Origin</label>
                                                            <div class="typeahead__field">
                                                                <div class="typeahead__query">
                                                                    <input class="form-control form-control-solid js-typeahead-country_v1"
                                                                           id="origin_<?php echo $i; ?>"
                                                                           placeholder="Search" autocomplete="off">
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mt-2">
                                                        <div class="typeahead__container">
                                                            <label for="destination_<?php echo $i; ?>"
                                                                   class="required form-label">Destination</label>
                                                            <div class="typeahead__field">
                                                                <div class="typeahead__query">
                                                                    <input class="form-control form-control-solid js-typeahead-country_v1"
                                                                           id="destination_<?php echo $i; ?>"
                                                                           placeholder="Search" autocomplete="off">
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-10">
                                                            <label for="exampleFormControlInput1"
                                                                   class="required form-label">Equipment</label>
                                                            <select class="form-select"
                                                                    id="equipment_<?php echo $i; ?>">
                                                                <option value="">Select</option>
                                                                <option value="reefer">Reefer</option>
                                                                <option value="van">Van</option>
                                                                <option value="flat">Flatbed</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-10 text-end">
                                                            <!--button type="button" role="button" class="btn btn-primary" id="search_<?php echo $i; ?>_btn">Search
                                                                </button-->
                                                            <button type="button" role="button"
                                                                    class="btn btn-primary me-10"
                                                                    id="search_<?php echo $i; ?>_btn"
                                                                    onclick="changeLoaderText(<?= $i; ?>)">
                                                                    <span class="indicator-label">
                                                                        Search
                                                                    </span>

                                                                <span class="indicator-progress">
                                                                        <!--Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>-->
                                                                        <div class="card card-flush set-loader-1">
                                                                            <div class="container">

                                                                                <div class="row set-loader-row-1 mb-4">
                                                                                    <div class="col-lg-12 col-lg-12 col-sm-12 col-12">
                                                                                        <div class="set-loader-div-1">
                                                                                        <img src="<?= BASE_URL ?>images/truck.gif"
                                                                                             alt="">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row set-loader-row-1 mb-5">
                                                                                    <div class="col-lg-12 col-lg-12 col-sm-12 col-12">
                                                                                        <div class="set-loader-div-2">
                                                                                            <div class="set-loader-div-3">

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                                                                                </div>
                                                                                <div class="row set-loader-row-1">
                                                                                    <div class="col-lg-12 col-lg-12 col-sm-12 col-12">
                                                                                        <div class="set-loader-div-1">
                                                                                        <div style="color:black"></div>
                                                                                        <h1 style="color:black;"
                                                                                            class="text-gray-800 p-show-<?= $i; ?>"></h1>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                        </div>
                                                                    </span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Body-->
                                            <div id="res_div_<?php echo $i; ?>" style="display:none">
                                                <div class="card-body">
                                                    <!--start custom result-->
                                                    <div>
                                                        <div>
                                                            <div class="row set-cus-res-2">
                                                                <div class="col-xl-4">
                                                                    <div class="set-res-div-1">
                                                                        <div>
                                                                            <h5>Direct Rate</h5>
                                                                            <h2 id="carrier_div_<?php echo $i; ?>"></h2>
                                                                            <p id="slider_carrier_div_<?php echo $i; ?>"
                                                                               class="set-res-p-1"></p>
                                                                            <p class="set-res-p-2">Intraday Range</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-4">
                                                                    <div class="set-res-div-2">
                                                                        <h2><span></span>
                                                                            <p id="doc-rate"></p></h2>
                                                                        <div></div>
                                                                        <h2><span></span>
                                                                            <p id="bro-rate"></p></h2>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-4">
                                                                    <div class="set-res-div-1">
                                                                        <div>
                                                                            <h5>Broker Rate</h5>
                                                                            <h2 id="broker_div_<?php echo $i; ?>"></h2>
                                                                            <p class="set-res-p-1"
                                                                               id="slider_broker_div_<?php echo $i; ?>"></p>
                                                                            <p class="set-res-p-2">Intraday Range</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-12">
                                                                    <div class="set-res-div-img">
                                                                        <p id="equipment-val"></p>
                                                                        <img src="../images/final-mockup-rates-2.png"
                                                                             alt="">
                                                                        <img id="truck_<?php echo $i; ?>" src="" alt="">
                                                                        <span id="magnitude_div_<?php echo $i; ?>"
                                                                              class="set-percent">
                                                                            </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row set-cus-res-1">
                                                                <div class="col-xl-7">
                                                                    <div class="set-res-div-3">
                                                                        <div>
                                                                            <div class="set-res-div-4">
                                                                                <h5>Miles</h5>
                                                                                <span class="set-res-span-1"></span>
                                                                                <span class="set-res-span-2"></span>
                                                                                <h6 id="distance_div_<?php echo $i; ?>"></h6>
                                                                            </div>
                                                                            <div class="set-res-div-5">

                                                                            </div>
                                                                            <div class="set-res-div-4">
                                                                                <h5>RPM</h5>
                                                                                <span class="set-res-span-1"></span>
                                                                                <span class="set-res-span-2"></span>
                                                                                <h6 id="rpm_div_<?php echo $i; ?>"></h6>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-5">
                                                                    <div class="set-res-div-6">
                                                                        <button id="alert_<?php echo $i; ?>_btn">SET
                                                                            ALERT
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end custom result-->
                                                    <!--begin::Nav-->
                                                    <ul style="display:none"
                                                        class="nav nav-pills nav-pills-custom row position-relative mx-0 mb-9">
                                                        <!--begin::Item-->
                                                        <li class="nav-item col-6 mx-0 p-0">
                                                            <!--begin::Link-->
                                                            <a class="nav-link active d-flex justify-content-center w-100 border-0 h-100"
                                                               data-bs-toggle="pill"
                                                               href="#kt_list_widget_10_tab_1_<?php echo $i; ?>">
                                                                <!--begin::Subtitle-->
                                                                <div class="d-inline"><span
                                                                            class="nav-text text-gray-800 fw-bold fs-6 mb-3">Direct Rate
                                                                            <i class="bi bi-question-circle "
                                                                               data-bs-toggle="tooltip"
                                                                               data-bs-placement="top"
                                                                               title="This is the direct rate to trucks and shippers without broker fees."></i>
                                                                        </span></div>
                                                                <!--end::Subtitle-->
                                                                <!--begin::Bullet-->
                                                                <span class="bullet-custom position-absolute z-index-2 bottom-0 w-100 h-4px bg-primary rounded"></span>
                                                                <!--end::Bullet-->
                                                            </a>
                                                            <!--end::Link-->
                                                        </li>
                                                        <!--end::Item-->
                                                        <!--begin::Item-->
                                                        <li class="nav-item col-6 mx-0 px-0">
                                                            <!--begin::Link-->
                                                            <a class="nav-link d-flex justify-content-center w-100 border-0 h-100"
                                                               data-bs-toggle="pill"
                                                               href="#kt_list_widget_10_tab_2_<?php echo $i; ?>">
                                                                <!--begin::Subtitle-->
                                                                <div class="d-inline"><span
                                                                            class="nav-text text-gray-800 fw-bold fs-6 mb-3">Fair Value Broker Rate
                                                                            <i class="bi bi-question-circle "
                                                                               data-bs-toggle="tooltip"
                                                                               data-bs-placement="top"
                                                                               title="This is the rate a shipper should expect a broker to charge with their services included."></i>
                                                                        </span></div>

                                                                <!--end::Subtitle-->
                                                                <!--begin::Bullet-->
                                                                <span class="bullet-custom position-absolute z-index-2 bottom-0 w-100 h-4px bg-warning rounded"></span>
                                                                <!--end::Bullet-->
                                                            </a>
                                                            <!--end::Link-->
                                                        </li>
                                                        <!--end::Item-->

                                                        <!--begin::Bullet-->
                                                        <span class="position-absolute z-index-1 bottom-0 w-100 h-4px bg-light rounded"></span>
                                                        <!--end::Bullet-->
                                                    </ul>
                                                    <div style="display:none" class="tab-content">
                                                        <div class="tab-pane fade show active"
                                                             id="kt_list_widget_10_tab_1_<?php echo $i; ?>">
                                                            <div class="m-0">
                                                                <!--begin::Wrapper-->
                                                                <div class="d-flex justify-content-center mb-3">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-grow-1 me-2">
                                                                            <span class="badge bg-light-warning text-gray-800 fw-bold fs-3"
                                                                                  id="fantasy_name_div_<?php echo $i; ?>"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="d-flex justify-content-center py-2">
                                                                            <span class="text-gray-800 fw-bold fs-1"
                                                                                  id="carrier_div_<?php echo $i; ?>"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="d-flex justify-content-center py-2">
                                                                            <!--                                                                                <span class="fw-bold is_spotter_div_-->
                                                                            <?php //echo $i; ?><!--"></span>-->
                                                                            <div class="d-inline">
                                                                                    <span data-bs-toggle="tooltip">

<!--                                                                                        <i class="bi bi-question-circle tooltip_spot_on_-->
                                                                                        <?php //echo $i; ?><!-- tooltip_spot_on_le_-->
                                                                                        <?php //echo $i; ?><!--" data-bs-toggle="tooltip" data-bs-placement="top" title="This lane has already been learned by our Spot Market, Spot On AI algorithm."></i>-->
                                                                                        <!--<i class="bi bi-question-circle tooltip_spot_on_<?php echo $i; ?> tooltip_spot_on_ai_<?php echo $i; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Select 'Request Lane' down below to add this lane. Please allow up to 24 hours for this rate to become Spot Market, Spot On!"></i>-->

                                                                                    </span>
                                                                                <!--i class="bi bi-question-circle tooltip_spot_on_<?php echo $i; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title=""></i-->
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="d-flex justify-content-center py-2">
                                                                            <div class="d-inline">
                                                                                <span class="badge badge-lg badge-light-success fw-bold my-2 fs-base"
                                                                                      id="slider_carrier_div_<?php echo $i; ?>"></span>
                                                                                <i class="bi bi-question-circle "
                                                                                   data-bs-toggle="tooltip"
                                                                                   data-bs-placement="top"
                                                                                   title="This represents the current range of rates for today, spanning from the lowest to the highest."></i>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="d-flex justify-content-center py-2">
                                                                            <div class="d-flex flex-column">
                                                                                <!--<span class="badge badge-light fs-base text-gray-700 px-2">24hr</span>-->
                                                                                <span class="badge fs-base text-center"
                                                                                      id="magnitude_div_<?php echo $i; ?>"></span><br>
                                                                                <span class="badge badge-light fs-base text-gray-700 px-2">Just Now</span>
                                                                                <!--end::Label-->
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row p-5">
                                                                    <div class="col-12">
                                                                        <div class="d-flex justify-content-center p-2">
                                                                            <!--begin::Timeline-->
                                                                            <div class="timeline">
                                                                                <!--begin::Timeline item-->
                                                                                <div class="timeline-item align-items-center mb-7">
                                                                                    <!--begin::Timeline line-->
                                                                                    <div class="timeline-line w-40px mt-6 mb-n12"></div>
                                                                                    <!--end::Timeline line-->
                                                                                    <!--begin::Timeline icon-->
                                                                                    <div class="timeline-icon"
                                                                                         style="margin-left: 11px">
                                                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen015.svg-->
                                                                                        <span class="svg-icon svg-icon-2 svg-icon-danger">
                                                                                                <svg width="24"
                                                                                                     height="24"
                                                                                                     viewBox="0 0 24 24"
                                                                                                     fill="none"
                                                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                                                    <path opacity="0.3"
                                                                                                          d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 10C10.9 10 10 10.9 10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10ZM6.39999 9.89999C6.99999 8.19999 8.40001 6.9 10.1 6.4C10.6 6.2 10.9 5.7 10.7 5.1C10.5 4.6 9.99999 4.3 9.39999 4.5C7.09999 5.3 5.29999 7 4.39999 9.2C4.19999 9.7 4.5 10.3 5 10.5C5.1 10.5 5.19999 10.6 5.39999 10.6C5.89999 10.5 6.19999 10.2 6.39999 9.89999ZM14.8 19.5C17 18.7 18.8 16.9 19.6 14.7C19.8 14.2 19.5 13.6 19 13.4C18.5 13.2 17.9 13.5 17.7 14C17.1 15.7 15.8 17 14.1 17.6C13.6 17.8 13.3 18.4 13.5 18.9C13.6 19.3 14 19.6 14.4 19.6C14.5 19.6 14.6 19.6 14.8 19.5Z"
                                                                                                          fill="currentColor"/>
                                                                                                    <path d="M16 12C16 14.2 14.2 16 12 16C9.8 16 8 14.2 8 12C8 9.8 9.8 8 12 8C14.2 8 16 9.8 16 12ZM12 10C10.9 10 10 10.9 10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10Z"
                                                                                                          fill="currentColor"/>
                                                                                                </svg>
                                                                                            </span>
                                                                                        <!--end::Svg Icon-->
                                                                                    </div>
                                                                                    <!--end::Timeline icon-->
                                                                                    <!--begin::Timeline content-->
                                                                                    <div class="timeline-content m-0">
                                                                                        <!--begin::Title-->
                                                                                        <span class="fs-base fw-bold text-gray-800"
                                                                                              id="rpm_div_<?php echo $i; ?>"></span>
                                                                                        <!--end::Title-->
                                                                                    </div>
                                                                                    <!--end::Timeline content-->
                                                                                </div>
                                                                                <!--end::Timeline item-->
                                                                                <!--begin::Timeline item-->
                                                                                <div class="timeline-item align-items-center">
                                                                                    <!--begin::Timeline line-->
                                                                                    <div class="timeline-line w-40px"></div>
                                                                                    <!--end::Timeline line-->
                                                                                    <!--begin::Timeline icon-->
                                                                                    <div class="timeline-icon"
                                                                                         style="margin-left: 11px">
                                                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen018.svg-->
                                                                                        <span class="svg-icon svg-icon-2 svg-icon-info">
                                                                                                <svg width="24"
                                                                                                     height="24"
                                                                                                     viewBox="0 0 24 24"
                                                                                                     fill="none"
                                                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                                                    <path opacity="0.3"
                                                                                                          d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z"
                                                                                                          fill="currentColor"/>
                                                                                                    <path d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z"
                                                                                                          fill="currentColor"/>
                                                                                                </svg>
                                                                                            </span>
                                                                                        <!--end::Svg Icon-->
                                                                                    </div>
                                                                                    <!--end::Timeline icon-->
                                                                                    <!--begin::Timeline content-->
                                                                                    <div class="timeline-content m-0">
                                                                                        <!--begin::Title-->
                                                                                        <span class="fs-base fw-bold text-gray-800"
                                                                                              id="distance_div_<?php echo $i; ?>"></span>
                                                                                        <!--end::Title-->
                                                                                    </div>
                                                                                    <!--end::Timeline content-->
                                                                                </div>
                                                                                <!--end::Timeline item-->
                                                                            </div>
                                                                            <!--end::Timeline-->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row p-2 do_you_want_div_<?php echo $i; ?>">
                                                                    <div class="col-12">
                                                                        <div class="d-flex justify-content-center">
                                                                            <!--                                                                                <button type="button" role="button" class="btn btn-primary btn-sm abre_modal_learn cual_es_-->
                                                                            <?php //echo $i; ?><!--" id="">Request Lane</button>-->
                                                                            <!--div class="do_you_want_div_<?php echo $i; ?> d-inline">
                                                                                    <br><span style="cursor: pointer; display:none" class="abre_modal_learn cual_es_<?php echo $i; ?>" data-lane="">Click here to add this lane</span>
                                                                                </div-->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row p-2">
                                                                    <div class="col-12">
                                                                        <div class="d-flex justify-content-center">
                                                                            <button type="button" role="button"
                                                                                    class="btn btn-primary btn-sm"
                                                                                    data-alert-fantasy=""
                                                                                    data-alert-direct=""
                                                                                    data-alert-broker=""
                                                                                    data-alert-lane-id=""
                                                                                    data-alert-lane=""
                                                                                    id="alert_<?php echo $i; ?>_btn">Set
                                                                                Alert
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row p-2">
                                                                    <div class="col-12 d-none">
                                                                        <div class="d-flex justify-content-center">
                                                                            <button type="button" role="button"
                                                                                    class="btn btn-primary btn_enlarge btn-sm"
                                                                                    id="btn_enlarge_<?php echo $i; ?>"
                                                                                    data-col="<?php echo $i; ?>"
                                                                                    data-fantasy-name=""
                                                                                    data-last-updated="" data-rpm=""
                                                                                    data-distance=""
                                                                                    data-direct-quote=""
                                                                                    data-direct-porcentaje=""
                                                                                    data-fair-quote=""
                                                                                    data-slider-direct=""
                                                                                    data-slider-broker="">
                                                                                <i class="bi bi-arrows-fullscreen"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="separator separator-dashed my-6"></div>
                                                        </div>


                                                        <div class="tab-pane fade"
                                                             id="kt_list_widget_10_tab_2_<?php echo $i; ?>">
                                                            <div class="m-0">
                                                                <!--begin::Wrapper-->
                                                                <div class="d-flex justify-content-center mb-3">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-grow-1 me-2">
                                                                            <span class="badge bg-light-warning text-gray-800 fw-bold fs-4"
                                                                                  id="fantasy_name_div_broker_<?php echo $i; ?>"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="d-flex justify-content-center py-2">
                                                                            <span class="text-gray-800 fw-bold  fs-1"
                                                                                  id="broker_div_<?php echo $i; ?>"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="d-flex justify-content-center py-2">
                                                                            <!--                                                                                <span class="fw-bold is_spotter_div_-->
                                                                            <?php //echo $i; ?><!--"></span>-->
                                                                            <div class="d-inline">
                                                                                    <span data-bs-toggle="tooltip">

<!--                                                                                        <i class="bi bi-question-circle tooltip_spot_on_-->
                                                                                        <?php //echo $i; ?><!-- tooltip_spot_on_le_-->
                                                                                        <?php //echo $i; ?><!--" data-bs-toggle="tooltip" data-bs-placement="top" title="This lane has already been learned by our Spot Market, Spot On AI algorithm."></i>-->
                                                                                        <i class="bi bi-question-circle tooltip_spot_on_<?php echo $i; ?> tooltip_spot_on_ai_<?php echo $i; ?>"
                                                                                           data-bs-toggle="tooltip"
                                                                                           data-bs-placement="top"
                                                                                           title="Select 'Request Lane' down below to add this lane. Please allow up to 24 hours for this rate to become Spot Market, Spot On!"></i>

                                                                                    </span>
                                                                                <!--i class="bi bi-question-circle tooltip_spot_on_<?php echo $i; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title=""></i-->
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="d-flex justify-content-center py-2">
                                                                            <div class="d-inline">
                                                                                <span class="badge badge-lg badge-light-success fw-bold my-2 fs-base"
                                                                                      id="slider_broker_div_<?php echo $i; ?>"></span>
                                                                                <i class="bi bi-question-circle "
                                                                                   data-bs-toggle="tooltip"
                                                                                   data-bs-placement="top"
                                                                                   title="This represents the current range of rates for today, spanning from the lowest to the highest."></i>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="d-flex justify-content-center py-2">
                                                                            <div class="d-flex flex-column">
                                                                                <!--<span class="badge badge-light fs-base text-gray-700 px-2">24hr</span>-->
                                                                                <span class="badge fs-base"
                                                                                      id="magnitude_div_broker_<?php echo $i; ?>"></span><br>
                                                                                <span class="badge badge-light fs-base text-gray-700 px-2">Just Now</span>
                                                                                <!--end::Label-->
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row p-5">
                                                                    <div class="col-12">
                                                                        <div class="d-flex justify-content-center p-2">
                                                                            <!--begin::Timeline-->
                                                                            <div class="timeline">
                                                                                <!--begin::Timeline item-->
                                                                                <div class="timeline-item align-items-center mb-7">
                                                                                    <!--begin::Timeline line-->
                                                                                    <div class="timeline-line w-40px mt-6 mb-n12"></div>
                                                                                    <!--end::Timeline line-->
                                                                                    <!--begin::Timeline icon-->
                                                                                    <div class="timeline-icon"
                                                                                         style="margin-left: 11px">
                                                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen015.svg-->
                                                                                        <span class="svg-icon svg-icon-2 svg-icon-danger">
                                                                                                <svg width="24"
                                                                                                     height="24"
                                                                                                     viewBox="0 0 24 24"
                                                                                                     fill="none"
                                                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                                                    <path opacity="0.3"
                                                                                                          d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 10C10.9 10 10 10.9 10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10ZM6.39999 9.89999C6.99999 8.19999 8.40001 6.9 10.1 6.4C10.6 6.2 10.9 5.7 10.7 5.1C10.5 4.6 9.99999 4.3 9.39999 4.5C7.09999 5.3 5.29999 7 4.39999 9.2C4.19999 9.7 4.5 10.3 5 10.5C5.1 10.5 5.19999 10.6 5.39999 10.6C5.89999 10.5 6.19999 10.2 6.39999 9.89999ZM14.8 19.5C17 18.7 18.8 16.9 19.6 14.7C19.8 14.2 19.5 13.6 19 13.4C18.5 13.2 17.9 13.5 17.7 14C17.1 15.7 15.8 17 14.1 17.6C13.6 17.8 13.3 18.4 13.5 18.9C13.6 19.3 14 19.6 14.4 19.6C14.5 19.6 14.6 19.6 14.8 19.5Z"
                                                                                                          fill="currentColor"/>
                                                                                                    <path d="M16 12C16 14.2 14.2 16 12 16C9.8 16 8 14.2 8 12C8 9.8 9.8 8 12 8C14.2 8 16 9.8 16 12ZM12 10C10.9 10 10 10.9 10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10Z"
                                                                                                          fill="currentColor"/>
                                                                                                </svg>
                                                                                            </span>
                                                                                        <!--end::Svg Icon-->
                                                                                    </div>
                                                                                    <!--end::Timeline icon-->
                                                                                    <!--begin::Timeline content-->
                                                                                    <div class="timeline-content m-0">
                                                                                        <!--begin::Title-->
                                                                                        <span class="fs-base fw-bold text-gray-800"
                                                                                              id="rpm_div_broker_<?php echo $i; ?>"></span>
                                                                                        <!--end::Title-->
                                                                                    </div>
                                                                                    <!--end::Timeline content-->
                                                                                </div>
                                                                                <!--end::Timeline item-->
                                                                                <!--begin::Timeline item-->
                                                                                <div class="timeline-item align-items-center">
                                                                                    <!--begin::Timeline line-->
                                                                                    <div class="timeline-line w-40px"></div>
                                                                                    <!--end::Timeline line-->
                                                                                    <!--begin::Timeline icon-->
                                                                                    <div class="timeline-icon"
                                                                                         style="margin-left: 11px">
                                                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen018.svg-->
                                                                                        <span class="svg-icon svg-icon-2 svg-icon-info">
                                                                                                <svg width="24"
                                                                                                     height="24"
                                                                                                     viewBox="0 0 24 24"
                                                                                                     fill="none"
                                                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                                                    <path opacity="0.3"
                                                                                                          d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z"
                                                                                                          fill="currentColor"/>
                                                                                                    <path d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z"
                                                                                                          fill="currentColor"/>
                                                                                                </svg>
                                                                                            </span>
                                                                                        <!--end::Svg Icon-->
                                                                                    </div>
                                                                                    <!--end::Timeline icon-->
                                                                                    <!--begin::Timeline content-->
                                                                                    <div class="timeline-content m-0">
                                                                                        <!--begin::Title-->
                                                                                        <span class="fs-base fw-bold text-gray-800"
                                                                                              id="distance_div_broker_<?php echo $i; ?>"></span>
                                                                                        <!--end::Title-->
                                                                                    </div>
                                                                                    <!--end::Timeline content-->
                                                                                </div>
                                                                                <!--end::Timeline item-->
                                                                            </div>
                                                                            <!--end::Timeline-->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row p-2 do_you_want_div_<?php echo $i; ?>">
                                                                    <div class="col-12">
                                                                        <div class="d-flex justify-content-center">
                                                                            <!--                                                                                <button type="button" role="button" class="btn btn-primary btn-sm abre_modal_learn cual_es_-->
                                                                            <?php //echo $i; ?><!--" id="">Request Lane</button>-->
                                                                            <!--div class="do_you_want_div_<?php echo $i; ?> d-inline">
                                                                                    <br><span style="cursor: pointer; display:none" class="abre_modal_learn cual_es_<?php echo $i; ?>" data-lane="">Click here to add this lane</span>
                                                                                </div-->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row p-2">
                                                                    <div class="col-12">
                                                                        <!-- rate alerts -->
                                                                        <div class="d-flex justify-content-center">
                                                                            <button type="button" role="button"
                                                                                    class="btn btn-primary btn-sm"
                                                                                    data-alert-fantasy=""
                                                                                    data-alert-direct=""
                                                                                    data-alert-broker=""
                                                                                    data-alert-lane-id=""
                                                                                    data-alert-lane=""
                                                                                    id="alert_<?php echo $i; ?>_broker_btn">
                                                                                Set Alert
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row p-2">
                                                                    <div class="col-12 d-none">
                                                                        <div class="d-flex justify-content-center">
                                                                            <button type="button" role="button"
                                                                                    class="btn btn-primary btn_enlarge btn-sm"
                                                                                    id="btn_enlarge_<?php echo $i; ?>_broker_btn"
                                                                                    data-col="<?php echo $i; ?>"
                                                                                    data-fantasy-name="" data-lane-id=""
                                                                                    data-last-updated="" data-rpm=""
                                                                                    data-distance=""
                                                                                    data-direct-quote=""
                                                                                    data-direct-porcentaje=""
                                                                                    data-fair-quote=""
                                                                                    data-slider-direct=""
                                                                                    data-slider-broker="">
                                                                                <i class="bi bi-arrows-fullscreen"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="separator separator-dashed my-6"></div>
                                                        </div>
                                                    </div>
                                                    <!--begin::Item-->
                                                    <div class="m-0 d-none">

                                                        <div id="chart_div_sa_<?php echo $i; ?>">
                                                            <!-- empiezo a pegar lo del chart container -->

                                                            <!--begin::Body-->
                                                            <div class="card-body py-0 px-0">
                                                                <!--begin::Nav-->
                                                                <ul class="nav d-flex justify-content-between mb-3 mx-9">
                                                                    <!--begin::Item-->
                                                                    <li class="nav-item mb-3">
                                                                        <!--begin::Link-->
                                                                        <a class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px active  cambia_chart chart_<?php echo $i; ?>"
                                                                           data-search-numero="<?php echo $i; ?>"
                                                                           data-time-range="5">5d</a>
                                                                        <!--end::Link-->
                                                                    </li>
                                                                    <!--end::Item-->
                                                                    <!--begin::Item-->
                                                                    <li class="nav-item mb-3">
                                                                        <!--begin::Link-->
                                                                        <a class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px  cambia_chart chart_<?php echo $i; ?>"
                                                                           data-search-numero="<?php echo $i; ?>"
                                                                           data-time-range="30">1m</a>
                                                                        <!--end::Link-->
                                                                    </li>
                                                                    <!--end::Item-->
                                                                    <!--begin::Item-->
                                                                    <li class="nav-item mb-3">
                                                                        <!--begin::Link-->
                                                                        <a class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px  cambia_chart chart_<?php echo $i; ?>"
                                                                           data-search-numero="<?php echo $i; ?>"
                                                                           data-time-range="180">6m</a>
                                                                        <!--end::Link-->
                                                                    </li>
                                                                    <!--end::Item-->
                                                                    <!--begin::Item-->
                                                                    <li class="nav-item mb-3">
                                                                        <!--begin::Link-->
                                                                        <a class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px  cambia_chart chart_<?php echo $i; ?>"
                                                                           data-search-numero="<?php echo $i; ?>"
                                                                           data-time-range="365">1y</a>
                                                                        <!--end::Link-->
                                                                    </li>
                                                                    <!--end::Item-->
                                                                </ul>
                                                                <!--end::Nav-->
                                                                <!--begin::Tab Content-->
                                                                <div class="tab-content mt-n6">
                                                                    <!--begin::Tap pane-->
                                                                    <div class="tab-pane fade active show">
                                                                        <!--begin::Chart-->
                                                                        <div id="chart_search_result_<?php echo $i; ?>"
                                                                             data-kt-chart-color="primary"
                                                                             style="height: 200px;"
                                                                             class="min-h-auto h-200px ps-3 pe-6"></div>
                                                                        <!--end::Chart-->
                                                                    </div>
                                                                    <!--end::Tap pane-->

                                                                </div>
                                                                <!--end::Tab Content-->
                                                            </div>
                                                            <!--end::Body-->

                                                            <!-- el chart container -->
                                                        </div>
                                                    </div>
                                                    <!--end::Item-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <?php
                                }
                                ?>
                                <div class="modal fade" tabindex="-1" id="alert_modal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title">Set alert</h3>
                                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                     data-bs-dismiss="modal" aria-label="Close">
                                                    <span class="svg-icon svg-icon-1"></span>
                                                </div>
                                            </div>
                                            <div class="modal-body">

                                                <div class="mb-0">
                                                    <div class="pt-5">

                                                        <label class="form-label">An alert will be activated when the
                                                            spot market rate experiences a change either above or below
                                                            the specified amount.</label>
                                                        <!--begin::Dialer-->
                                                        <div class="input-group w-md-300px justify-content-center"
                                                             data-kt-dialer="true" data-kt-dialer-min="100"
                                                             data-kt-dialer-max="3000" data-kt-dialer-step="100"
                                                             data-kt-dialer-prefix="$">

                                                            <!--begin::Decrease control-->
                                                            <button class="btn btn-icon btn-outline btn-active-color-primary"
                                                                    type="button" data-kt-dialer-control="decrease">
                                                                <i class="bi bi-dash fs-1"></i>
                                                            </button>
                                                            <!--end::Decrease control-->

                                                            <!--begin::Input control-->
                                                            <input type="text" id="alert_valor" class="form-control"
                                                                   readonly placeholder="Amount" value="$300"
                                                                   data-kt-dialer-control="input"/>
                                                            <!--end::Input control-->

                                                            <!--begin::Increase control-->
                                                            <button class="btn btn-icon btn-outline btn-active-color-primary"
                                                                    type="button" data-kt-dialer-control="increase">
                                                                <i class="bi bi-plus fs-1"></i>
                                                            </button>
                                                            <!--end::Increase control-->
                                                        </div>
                                                        <!--end::Dialer-->
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>If you want to get an email on this alert,
                                                                        please set it here.</label>
                                                                    <input class="form-control" type="email"
                                                                           name="alert_email" id="alert_email">
                                                                    <input class="form-control" type="hidden"
                                                                           name="alert_direct" id="alert_direct">
                                                                    <input class="form-control" type="hidden"
                                                                           name="alert_broker" id="alert_broker">
                                                                    <input class="form-control" type="hidden"
                                                                           name="alert_fantasy" id="alert_fantasy">
                                                                    <input class="form-control" type="hidden"
                                                                           name="alert_lane_id" id="alert_lane_id">

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="button" class="btn btn-primary set_alert_btn" id="">
                                                    Confirm Alert
                                                </button>
                                                <input type="hidden" id="btn_tocado">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="modal fade" tabindex="-1" id="chart_modal">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title">Search Result</h3>
                                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                     data-bs-dismiss="modal" aria-label="Close">
                                                    <span class="svg-icon svg-icon-1"></span>
                                                </div>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <!--begin::Nav-->
                                                    <ul class="nav nav-pills nav-pills-custom row position-relative mx-0 mb-9">
                                                        <!--begin::Item-->
                                                        <li class="nav-item col-6 mx-0 p-0">
                                                            <!--begin::Link-->
                                                            <a class="nav-link active d-flex justify-content-center w-100 border-0 h-100"
                                                               data-bs-toggle="pill" href="#kt_list_widget_10_tab_1_5">
                                                                <!--begin::Subtitle-->
                                                                <span class="nav-text text-gray-800 fw-bold fs-6 mb-3">Direct Rate</span>
                                                                <!--end::Subtitle-->
                                                                <!--begin::Bullet-->
                                                                <span class="bullet-custom position-absolute z-index-2 bottom-0 w-100 h-4px bg-primary rounded"></span>
                                                                <!--end::Bullet-->
                                                            </a>
                                                            <!--end::Link-->
                                                        </li>
                                                        <!--end::Item-->
                                                        <!--begin::Item-->
                                                        <li class="nav-item col-6 mx-0 px-0">
                                                            <!--begin::Link-->
                                                            <a class="nav-link d-flex justify-content-center w-100 border-0 h-100"
                                                               data-bs-toggle="pill" href="#kt_list_widget_10_tab_2_5">
                                                                <!--begin::Subtitle-->
                                                                <span class="nav-text text-gray-800 fw-bold fs-6 mb-3">Fair Value Broker Rate</span>
                                                                <!--end::Subtitle-->
                                                                <!--begin::Bullet-->
                                                                <span class="bullet-custom position-absolute z-index-2 bottom-0 w-100 h-4px bg-warning rounded"></span>
                                                                <!--end::Bullet-->
                                                            </a>
                                                            <!--end::Link-->
                                                        </li>
                                                        <!--end::Item-->

                                                        <!--begin::Bullet-->
                                                        <span class="position-absolute z-index-1 bottom-0 w-100 h-4px bg-light rounded"></span>
                                                        <!--end::Bullet-->
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div class="tab-pane fade show active"
                                                             id="kt_list_widget_10_tab_1_5">
                                                            <div class="m-0">
                                                                <!--begin::Wrapper-->
                                                                <div class="d-flex align-items-sm-center mb-5">
                                                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                                                        <div class="flex-grow-1 me-2">
                                                                            <span class="badge bg-light-warning text-gray-800 fw-bold fs-4"
                                                                                  id="fantasy_name_div_5"></span>
                                                                        </div>
                                                                        <!-- <span class="badge badge-lg badge-light-success fw-bold my-2" id="last_updated_div_5"></span> -->
                                                                        <span class="badge badge-lg badge-light-success fw-bold my-2"
                                                                              id="modal_slider_direct_div">este direct</span>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <!--begin::Timeline-->
                                                                        <div class="timeline">
                                                                            <!--begin::Timeline item-->
                                                                            <div class="timeline-item align-items-center mb-7">
                                                                                <!--begin::Timeline line-->
                                                                                <div class="timeline-line w-40px mt-6 mb-n12"></div>
                                                                                <!--end::Timeline line-->
                                                                                <!--begin::Timeline icon-->
                                                                                <div class="timeline-icon"
                                                                                     style="margin-left: 11px">
                                                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen015.svg-->
                                                                                    <span class="svg-icon svg-icon-2 svg-icon-danger">
                                                                                            <svg width="24" height="24"
                                                                                                 viewBox="0 0 24 24"
                                                                                                 fill="none"
                                                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                                                <path opacity="0.3"
                                                                                                      d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 10C10.9 10 10 10.9 10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10ZM6.39999 9.89999C6.99999 8.19999 8.40001 6.9 10.1 6.4C10.6 6.2 10.9 5.7 10.7 5.1C10.5 4.6 9.99999 4.3 9.39999 4.5C7.09999 5.3 5.29999 7 4.39999 9.2C4.19999 9.7 4.5 10.3 5 10.5C5.1 10.5 5.19999 10.6 5.39999 10.6C5.89999 10.5 6.19999 10.2 6.39999 9.89999ZM14.8 19.5C17 18.7 18.8 16.9 19.6 14.7C19.8 14.2 19.5 13.6 19 13.4C18.5 13.2 17.9 13.5 17.7 14C17.1 15.7 15.8 17 14.1 17.6C13.6 17.8 13.3 18.4 13.5 18.9C13.6 19.3 14 19.6 14.4 19.6C14.5 19.6 14.6 19.6 14.8 19.5Z"
                                                                                                      fill="currentColor"/>
                                                                                                <path d="M16 12C16 14.2 14.2 16 12 16C9.8 16 8 14.2 8 12C8 9.8 9.8 8 12 8C14.2 8 16 9.8 16 12ZM12 10C10.9 10 10 10.9 10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10Z"
                                                                                                      fill="currentColor"/>
                                                                                            </svg>
                                                                                        </span>
                                                                                    <!--end::Svg Icon-->
                                                                                </div>
                                                                                <!--end::Timeline icon-->
                                                                                <!--begin::Timeline content-->
                                                                                <div class="timeline-content m-0">
                                                                                    <!--begin::Title-->
                                                                                    <span class="fs-6 fw-bold text-gray-800"
                                                                                          id="rpm_div_5"></span>
                                                                                    <!--end::Title-->
                                                                                </div>
                                                                                <!--end::Timeline content-->
                                                                            </div>
                                                                            <!--end::Timeline item-->
                                                                            <!--begin::Timeline item-->
                                                                            <div class="timeline-item align-items-center">
                                                                                <!--begin::Timeline line-->
                                                                                <div class="timeline-line w-40px"></div>
                                                                                <!--end::Timeline line-->
                                                                                <!--begin::Timeline icon-->
                                                                                <div class="timeline-icon"
                                                                                     style="margin-left: 11px">
                                                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen018.svg-->
                                                                                    <span class="svg-icon svg-icon-2 svg-icon-info">
                                                                                            <svg width="24" height="24"
                                                                                                 viewBox="0 0 24 24"
                                                                                                 fill="none"
                                                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                                                <path opacity="0.3"
                                                                                                      d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z"
                                                                                                      fill="currentColor"/>
                                                                                                <path d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z"
                                                                                                      fill="currentColor"/>
                                                                                            </svg>
                                                                                        </span>
                                                                                    <!--end::Svg Icon-->
                                                                                </div>
                                                                                <!--end::Timeline icon-->
                                                                                <!--begin::Timeline content-->
                                                                                <div class="timeline-content m-0">
                                                                                    <!--begin::Title-->
                                                                                    <span class="fs-6 fw-bold text-gray-800"
                                                                                          id="distance_div_5"></span>
                                                                                    <!--end::Title-->
                                                                                </div>
                                                                                <!--end::Timeline content-->
                                                                            </div>
                                                                            <!--end::Timeline item-->
                                                                        </div>
                                                                    </div>
                                                                    <!--end::Timeline-->
                                                                    <div class="col-6">
                                                                        <span class="text-gray-800 fw-bold d-block fs-1"
                                                                              id="carrier_div_5"></span>
                                                                        <?php
                                                                        //segun el %en 24 hs dibuja en verde, amarillo o rojo
                                                                        if ($ta->percentage < 0) { //red
                                                                            $svg_icon = "danger";
                                                                            $svg_file = "arr065";
                                                                            $svg_textcolor = "danger";
                                                                        } else if ($ta->percentage > 0) { //green
                                                                            $svg_icon = "success";
                                                                            $svg_file = "arr066";
                                                                            $svg_textcolor = "success";
                                                                        } else { // yellow
                                                                            $svg_icon = "warning";
                                                                            $svg_file = "arr090";
                                                                            $svg_textcolor = "text-gray-700";
                                                                        }
                                                                        ?>
                                                                        <!--begin::Label-->
                                                                        <span class="badge badge-light-<?php echo $svg_icon; ?> fs-base <?php echo $svg_textcolor; ?>">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/<?php echo $svg_file; ?>.svg-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/' . $svg_file . '.svg', 'svg-icon-2 svg-icon-' . $svg_textcolor);
                                                                                ?>
                                                                            <?php echo round($ta->percentage, 2); ?>
                                                                                %
                                                                            </span>
                                                                        <span class="badge fs-base"
                                                                              id="magnitude_div_5_<?php echo $i; ?>"></span>
                                                                        <!--end::Label-->
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="separator separator-dashed my-6"></div>
                                                        </div>
                                                        <div class="tab-pane fade" id="kt_list_widget_10_tab_2_5">
                                                            <div class="m-0">
                                                                <!--begin::Wrapper-->
                                                                <div class="d-flex align-items-sm-center mb-5">
                                                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                                                        <div class="flex-grow-1 me-2">
                                                                            <span class="badge bg-light-warning text-gray-800 fw-bold fs-4"
                                                                                  id="fantasy_name_div_broker_5"></span>
                                                                        </div>
                                                                        <!--   <span class="badge badge-lg badge-light-success fw-bold my-2" id="last_updated_div_broker_5"></span> -->
                                                                        <span class="badge badge-lg badge-light-success fw-bold my-2"
                                                                              id="modal_slider_fair_div"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <!--begin::Timeline-->
                                                                        <div class="timeline">
                                                                            <!--begin::Timeline item-->
                                                                            <div class="timeline-item align-items-center mb-7">
                                                                                <!--begin::Timeline line-->
                                                                                <div class="timeline-line w-40px mt-6 mb-n12"></div>
                                                                                <!--end::Timeline line-->
                                                                                <!--begin::Timeline icon-->
                                                                                <div class="timeline-icon"
                                                                                     style="margin-left: 11px">
                                                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen015.svg-->
                                                                                    <span class="svg-icon svg-icon-2 svg-icon-danger">
                                                                                            <svg width="24" height="24"
                                                                                                 viewBox="0 0 24 24"
                                                                                                 fill="none"
                                                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                                                <path opacity="0.3"
                                                                                                      d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 10C10.9 10 10 10.9 10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10ZM6.39999 9.89999C6.99999 8.19999 8.40001 6.9 10.1 6.4C10.6 6.2 10.9 5.7 10.7 5.1C10.5 4.6 9.99999 4.3 9.39999 4.5C7.09999 5.3 5.29999 7 4.39999 9.2C4.19999 9.7 4.5 10.3 5 10.5C5.1 10.5 5.19999 10.6 5.39999 10.6C5.89999 10.5 6.19999 10.2 6.39999 9.89999ZM14.8 19.5C17 18.7 18.8 16.9 19.6 14.7C19.8 14.2 19.5 13.6 19 13.4C18.5 13.2 17.9 13.5 17.7 14C17.1 15.7 15.8 17 14.1 17.6C13.6 17.8 13.3 18.4 13.5 18.9C13.6 19.3 14 19.6 14.4 19.6C14.5 19.6 14.6 19.6 14.8 19.5Z"
                                                                                                      fill="currentColor"/>
                                                                                                <path d="M16 12C16 14.2 14.2 16 12 16C9.8 16 8 14.2 8 12C8 9.8 9.8 8 12 8C14.2 8 16 9.8 16 12ZM12 10C10.9 10 10 10.9 10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10Z"
                                                                                                      fill="currentColor"/>
                                                                                            </svg>
                                                                                        </span>
                                                                                    <!--end::Svg Icon-->
                                                                                </div>
                                                                                <!--end::Timeline icon-->
                                                                                <!--begin::Timeline content-->
                                                                                <div class="timeline-content m-0">
                                                                                    <!--begin::Title-->
                                                                                    <span class="fs-6 fw-bold text-gray-800"
                                                                                          id="rpm_div_broker_5"></span>
                                                                                    <!--end::Title-->
                                                                                </div>
                                                                                <!--end::Timeline content-->
                                                                            </div>
                                                                            <!--end::Timeline item-->
                                                                            <!--begin::Timeline item-->
                                                                            <div class="timeline-item align-items-center">
                                                                                <!--begin::Timeline line-->
                                                                                <div class="timeline-line w-40px"></div>
                                                                                <!--end::Timeline line-->
                                                                                <!--begin::Timeline icon-->
                                                                                <div class="timeline-icon"
                                                                                     style="margin-left: 11px">
                                                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen018.svg-->
                                                                                    <span class="svg-icon svg-icon-2 svg-icon-info">
                                                                                            <svg width="24" height="24"
                                                                                                 viewBox="0 0 24 24"
                                                                                                 fill="none"
                                                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                                                <path opacity="0.3"
                                                                                                      d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z"
                                                                                                      fill="currentColor"/>
                                                                                                <path d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z"
                                                                                                      fill="currentColor"/>
                                                                                            </svg>
                                                                                        </span>
                                                                                    <!--end::Svg Icon-->
                                                                                </div>
                                                                                <!--end::Timeline icon-->
                                                                                <!--begin::Timeline content-->
                                                                                <div class="timeline-content m-0">
                                                                                    <!--begin::Title-->
                                                                                    <span class="fs-6 fw-bold text-gray-800"
                                                                                          id="distance_div_broker_5"></span>
                                                                                    <!--end::Title-->
                                                                                </div>
                                                                                <!--end::Timeline content-->
                                                                            </div>
                                                                            <!--end::Timeline item-->
                                                                        </div>
                                                                    </div>
                                                                    <!--end::Timeline-->
                                                                    <div class="col-6">
                                                                        <span class="text-gray-800 fw-bold d-block fs-1"
                                                                              id="carrier_div_broker_5"></span>
                                                                        <?php
                                                                        //segun el %en 24 hs dibuja en verde, amarillo o rojo
                                                                        if ($ta->percentage < 0) { //red
                                                                            $svg_icon = "danger";
                                                                            $svg_file = "arr065";
                                                                            $svg_textcolor = "danger";
                                                                        } else if ($ta->percentage > 0) { //green
                                                                            $svg_icon = "success";
                                                                            $svg_file = "arr066";
                                                                            $svg_textcolor = "success";
                                                                        } else { // yellow
                                                                            $svg_icon = "warning";
                                                                            $svg_file = "arr090";
                                                                            $svg_textcolor = "text-gray-700";
                                                                        }
                                                                        ?>
                                                                        <!--begin::Label-->
                                                                        <span class="badge badge-light-<?php echo $svg_icon; ?> fs-base  <?php echo $svg_textcolor; ?>">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/<?php echo $svg_file; ?>.svg-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/' . $svg_file . '.svg', 'svg-icon-2 svg-icon-' . $svg_textcolor);
                                                                                ?>
                                                                            <?php echo round($ta->percentage, 2); ?>
                                                                                %
                                                                            </span>
                                                                        <span class="badge fs-base"
                                                                              id="magnitude_div_broker_5_<?php echo $i; ?>"></span>
                                                                        <!--end::Label-->
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="separator separator-dashed my-6"></div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="m-0">
                                                    <!-- empiezo a pegar lo del chart container -->

                                                    <!--begin::Body-->
                                                    <div class="card-body py-0 px-0">
                                                        <!--begin::Nav-->
                                                        <ul class="nav d-flex justify-content-between mb-3 mx-9">
                                                            <!--begin::Item-->
                                                            <li class="nav-item mb-3">
                                                                <!--begin::Link-->
                                                                <a class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px active  cambia_chart_modal chart_4 mod_5"
                                                                   data-search-numero="4" data-time-range="5">5d</a>
                                                                <!--end::Link-->
                                                            </li>
                                                            <!--end::Item-->
                                                            <!--begin::Item-->
                                                            <li class="nav-item mb-3">
                                                                <!--begin::Link-->
                                                                <a class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px  cambia_chart_modal chart_4 mod_30"
                                                                   data-search-numero="4" data-time-range="30">1m</a>
                                                                <!--end::Link-->
                                                            </li>
                                                            <!--end::Item-->
                                                            <!--begin::Item-->
                                                            <li class="nav-item mb-3">
                                                                <!--begin::Link-->
                                                                <a class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px  cambia_chart_modal chart_4 mod_180"
                                                                   data-search-numero="4" data-time-range="180">6m</a>
                                                                <!--end::Link-->
                                                            </li>
                                                            <!--end::Item-->
                                                            <!--begin::Item-->
                                                            <li class="nav-item mb-3">
                                                                <!--begin::Link-->
                                                                <a class="nav-link btn btn-flex flex-center btn-active-danger btn-color-gray-600 btn-active-color-white rounded-2 w-45px h-35px  cambia_chart_modal chart_4 mod_365"
                                                                   data-search-numero="4" data-time-range="365">1y</a>
                                                                <!--end::Link-->
                                                            </li>
                                                            <!--end::Item-->
                                                        </ul>
                                                        <!--end::Nav-->
                                                        <!--begin::Tab Content-->
                                                        <div class="tab-content mt-n6">
                                                            <!--begin::Tap pane-->
                                                            <div class="tab-pane fade active show">
                                                                <!--begin::Chart-->
                                                                <div id="chart_search_result_4"
                                                                     data-kt-chart-color="primary" style="height: 280px"
                                                                     class="ps-3 pe-6"></div>
                                                                <!--end::Chart-->
                                                            </div>
                                                            <!--end::Tap pane-->
                                                        </div>
                                                        <!--end::Tab Content-->
                                                    </div>
                                                    <!--end::Body-->

                                                    <!-- el chart container -->

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>


                            <div class="row g-5 g-xl-10 mt-2">
                                <div class="col  d-flex justify-content-between mb-2">
                                    <span class="text-gray-800 fw-bold fs-1 pb-2">Search History</span>
                                    <button class="btn btn-danger d-none" id="btn-update-all" onclick="updateAllRecords()">
                                        Update All
                                    </button>
                                </div>
                                <!-- <div>

                                </div> -->
                            </div>
                            <div class=" row g-5 g-xl-10">
                                <!--begin::Col search history-->
                                <div class="col-md-12 mb-xl-10">
                                    <!--begin::List widget 8-->
                                    <div class="card card-flush h-lg-100">
                                        <!--begin::Header>
                                    <div class="card-header">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bold text-gray-800">Title</span>
                                        </h3>
                                    </div>
                                    end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body pt-2">
                                            <div id="search_history_div">
                                                <?php
                                                if (empty($history)) {
                                                } else {
                                                    $count = 1;
                                                    foreach ($history as $v) {

                                                        if ((int)$v->driving_distance === 0 || $v->carrier === "$nan" || $v->shipper === "$nan") {
                                                        } else {

                                                            [$origin, $destination] = explode(" - ", $v->fantasy_name);

                                                            $valor_actual2 = str_replace("$", "", $v->carrier);
                                                            $valor_actual = str_replace(",", "", $valor_actual2);

                                                            $percentageChangeColumn = $v->equipment . '_change_percentage';
                                                            $sql = "SELECT lane_id, $v->equipment as master_rate, $percentageChangeColumn as percentage_change, last_updated  FROM lanes WHERE fantasy_name = '$v->fantasy_name' limit 1";
                                                            $lane = $quote->getThis1($sql);
                                                            $change = $lane->percentage_change;
                                                            $directRate = round($lane->master_rate, 0);
                                                            $fairValueBrokerRate = $ac->dame_fair_value_rate($directRate, $v->equipment);
                                                            $formattedDirectRate = number_format($directRate);
                                                            $formattedDirectRate = $ac->roundToNearestMultipleOf50($directRate);
                                                            $formattedfairValueBrokerRate = number_format($fairValueBrokerRate);
                                                            $formattedfairValueBrokerRate = $ac->roundToNearestMultipleOf50($fairValueBrokerRate);
                                                            ?>
                                                            <div class="row my-1 history-records">
                                                                <div class="set-the-col-div-2 col-md-3">
                                                                    <div class="d-flex align-items-sm-center mb-1">
                                                                        <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                                                            <div class="me-2">
                                                                                <span class="text-primary fw-bold d-block fs-4 fantasy_name"
                                                                                      id=""><?php echo $v->fantasy_name; ?></span>
                                                                            </div>
                                                                            <span class="badge badge-lg badge-light-success fw-bold my-2"
                                                                                  id=""></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <div class="d-flex align-items-sm-center mb-1">
                                                                        <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                                                            <div class="flex-grow-1 me-2">
                                                                                <span class="text-gray-800 d-block fs-6 align-middle equipment"
                                                                                      id=""><?php echo $v->equipment; ?></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="timeline">
                                                                        <div class="timeline-item align-items-center mb-1">
                                                                            <div class="timeline-content m-0">
                                                                                <span class="fs-6 fw-bold text-gray-800"
                                                                                      id="rpm_div_broker_">RPM <?php echo $v->rpm_shipper; ?></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="timeline-item align-items-center">
                                                                            <div class="timeline-content m-0">
                                                                                <span class="fs-6 fw-bold text-gray-800"
                                                                                      id="distance_div_broker_">DIST <?php echo round($v->driving_distance, 2); ?> mi</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    Direct Rate:<span
                                                                            class="text-gray-800 fw-bold d-block fs-1 direct-rate"> $<?php echo $formattedDirectRate; ?></span>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    Broker Rate:<span
                                                                            class="text-gray-800 fw-bold d-block fs-1 broker-rate"> $<?php echo $formattedfairValueBrokerRate; ?></span>
                                                                </div>
                                                                <div class="col-md-1 d-flex flex-column flex-center">
                                                                    <div class="px-2">
                                                                        <span class="fw-bold text-gray-800 times-ago"><?= $lane->last_updated ? $ac->timeAgo($lane->last_updated) : '-' ?></span>
                                                                    </div>
                                                                    <?php
                                                                    //segun el %en 24 hs dibuja en verde, amarillo o rojo
                                                                    if ($change < 0) { //red
                                                                        $svg_icon = "danger";
                                                                        $svg_file = "arr065";
                                                                        $svg_textcolor = "danger";
                                                                        ?>
                                                                        <div class="px-2 change_percentage_class">
                                                                            <!--begin::Label-->
                                                                            <span class="badge badge-light-<?php echo $svg_icon; ?> fs-base <?php echo $svg_textcolor; ?>">
                                                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/<?php echo $svg_file; ?>.svg-->
                                                                                    <?php
                                                                                    echo getSvgIcon('assets/media/icons/duotune/arrows/' . $svg_file . '.svg', 'svg-icon-2 svg-icon-' . $svg_textcolor);
                                                                                    ?>
                                                                                <?php echo $change; ?>
                                                                                    %
                                                                                </span>
                                                                            <!--end::Label-->
                                                                        </div>
                                                                        <?php
                                                                    } else if ($change > 0) { //green
                                                                        $svg_icon = "success";
                                                                        $svg_file = "arr066";
                                                                        $svg_textcolor = "success";
                                                                        ?>
                                                                        <div class="px-2 change_percentage_class">
                                                                            <!--begin::Label-->
                                                                            <span class="badge badge-light-<?php echo $svg_icon; ?> fs-base <?php echo $svg_textcolor; ?>">
                                                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/<?php echo $svg_file; ?>.svg-->
                                                                                    <?php
                                                                                    echo getSvgIcon('assets/media/icons/duotune/arrows/' . $svg_file . '.svg', 'svg-icon-2 svg-icon-' . $svg_textcolor);
                                                                                    ?>
                                                                                <?php echo $change; ?>
                                                                                    %
                                                                                </span>
                                                                            <!--end::Label-->
                                                                        </div>
                                                                        <?php
                                                                    } else { // yellow
                                                                        $svg_icon = "warning";
                                                                        $svg_file = "arr090";
                                                                        $svg_textcolor = "text-gray-700";
                                                                        ?>
                                                                        <div class="px-2 change_percentage_class">
                                                                            <!--begin::Label-->
                                                                            <span class="badge badge-light-<?php echo $svg_icon; ?> fs-base <?php echo $svg_textcolor; ?>">
                                                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/<?php echo $svg_file; ?>.svg-->
                                                                                    <?php
                                                                                    echo getSvgIcon('assets/media/icons/duotune/arrows/' . $svg_file . '.svg', 'svg-icon-2 svg-icon-' . $svg_textcolor);
                                                                                    ?>
                                                                                <?php echo $change; ?>
                                                                                    %
                                                                                </span>
                                                                            <!--end::Label-->
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <div class="set-the-col-div-1 col-md-1 col-1 p-0">
                                                                    <?php
                                                                    $lastUpdatedDateTime = new DateTime($lane->last_updated);
                                                                    $difference = $currentDateTime->diff($lastUpdatedDateTime);
                                                                    $hoursDifference = $difference->h + ($difference->days * 24);
                                                                    //                                                                        if ($v->fantasy_name == 'Los Angeles, CA - New York, NY') {
                                                                    //                                                                            var_dump($hoursDifference);
                                                                    //                                                                            exit;
                                                                    //                                                                        }
                                                                    $updatedRates = $lane && $hoursDifference < 2;
                                                                    ?>
                                                                    <?php if ($updatedRates): ?>
                                                                        <button class="btn btn-success btn-sm mt-2 btn-update"
                                                                                disabled>Updated
                                                                        </button>
                                                                    <?php else: ?>
                                                                        <button class="btn btn-danger btn-sm mt-2 d-w-110 btn-update"
                                                                                onclick="send_rate_request('<?= $origin ?>', '<?= $destination ?>', '<?= $v->equipment ?>', null, this)">
                                                                            Update
                                                                        </button>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            <div class="separator separator-dashed my-2"></div>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </div>

                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::LIst widget 8-->
                                </div>
                                <!--end::Col-->
                            </div>


                            <!--div class="row g-5 g-xl-10 mt-3">
                                    <?php
                            foreach ($history as $v) {
                                ?>

                                    <?php
                            }
                            ?>
                                </div-->


                            <!-- the content -->
                        </div>
                        <!--end::Content container-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Content wrapper-->
                <!--begin::Footer-->
                <?php include("includes/footer.php"); ?>
                <!--end::Footer-->
            </div>
            <!--end:::Main-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<!--end::App-->
<!--begin::Drawers-->


<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
    <span class="svg-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)"
                      fill="currentColor"/>
                <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                      fill="currentColor"/>
            </svg>
        </span>
    <!--end::Svg Icon-->
</div>
<!--end::Scrolltop-->


<div class="modal fade" tabindex="-1" id="learn_lane">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Do you want to have our AI learn this lane?</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                     aria-label="Close">
                    <span class="svg-icon svg-icon-1"></span>
                </div>
            </div>
            <div class="modal-body">

                <div class="mb-0">
                    <div class="pt-5">
                        <label class="form-label">
                            Once this lane transitions to Spot Market, Spot ON- we will notify you via email. Our
                            advanced software ensures 100% accuracy in identifying this lane permanently. During the
                            learning phase, please allow up to 24 hours for the system to acquire complete proficiency.
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        You have <p id="cuantos_quedan_p" style="display:inline;"></p> out of 50 lanes remaining.
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="button" class="btn btn-primary" data-lane="" id="confirma_aprender">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</div>


<!--begin::Javascript-->

<script>
    var hostUrl = "assets/";
</script>

<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="assets/plugins/global/plugins.bundle.js"></script>
<script src="assets/js/scripts.bundle.js"></script>
<script src="assets/js/lanerunner.js"></script>
<!--end::Global Javascript Bundle-->


<!--begin::Vendors Javascript(used by this page)-->
<!--script src="assets/plugins/custom/datatables/datatables.bundle.js"></script-->
<script src="assets/plugins/custom/datatables/datatables.bundle.min.js"></script>
<script src="assets/plugins/custom/vis-timeline/vis-timeline.bundle.js"></script>
<!--end::Vendors Javascript-->


<!--begin::Custom Javascript(used by this page)-->
<script src="assets/js/widgets.bundle.js"></script>
<script src="assets/js/custom/widgets.js"></script>
<script src="assets/js/jquery.typeahead.min.js"></script>


<!--end::Javascript-->
<!-- Include SweetAlert2 from a CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="assets/js/common.js"></script>

<script type="text/javascript">

    function resetUpdateAllButton() {
        $button = $('#btn-update-all');
        let allUpdated = true;
        $('.btn-update').each(function () {
            if (!$(this).hasClass('btn-success')) {
                allUpdated = false;
                return false;
            }
        });

        if (allUpdated) {
            $button.removeClass('btn-danger').addClass('btn-success').text('Updated').prop('disabled', true);
        }
    }

    resetUpdateAllButton();

    function changeLoaderText(num) {
        var count = 0;
        var data = ['Collecting Data', 'Analyzing Data', 'Your Rate is on the way!'];

        function changeValue() {
            if (count < 3) {
                var divElement = document.querySelector(`.set-loader-div-1 .p-show-${num}`);
                divElement.textContent = data[count];
                count++;
                setTimeout(changeValue, 5000);
            }
        }

        changeValue();
    }

    function changeFieldsWithAjaxResponse(data, col, selector) {
        let rowSelector = null;
        if (selector) {
            selector = $(selector);
            rowSelector = selector.closest('.row');
        }

        if (col) {
            var este_valor

            resultados_charts.col[col][5].length = 0
            resultados_charts.col[col][30].length = 0
            resultados_charts.col[col][180].length = 0
            resultados_charts.col[col][365].length = 0

            data.days_5_result.forEach(function (d5d) {
                resultados_charts.col[col][5].push({
                    "x": d5d.fecha,
                    "y": d5d.valor
                })
            });

            data.days_30_result.forEach(function (d30d) {
                if (d30d.valor === null) {
                    este_valor = 0
                } else {
                    este_valor = parseFloat(d30d.valor)
                }

                resultados_charts.col[col][30].push({
                    "x": d30d.fecha,
                    "y": este_valor
                })
            });

            data.days_180_result.forEach(function (d180d) {
                if (d180d.valor === null) {
                    este_valor = 0
                } else {
                    este_valor = parseFloat(d180d.valor)
                }
                resultados_charts.col[col][180].push({
                    "x": d180d.fecha,
                    "y": este_valor
                })
            });

            data.days_365_result.forEach(function (d7d) {
                if (d7d.valor === null) {
                    este_valor = 0
                } else {
                    este_valor = parseFloat(d7d.valor)
                }
                resultados_charts.col[col][365].push({
                    "x": d7d.fecha,
                    "y": este_valor
                })
            });

            armo_chart(col)

            $("#slider_broker_div_" + col).text('$' + data.slider_min_broker + '-  $' + data.slider_max_broker)
            $("#fantasy_name_div_" + col).text(data.fantasy_name)
            $("#rpm_div_" + col).text(data.rpm_carrier + "RPM")
            $("#distance_div_" + col).text(data.distance + " mi")
            $("#carrier_div_" + col).text(data.carrier)

            var bdgcolor = '';
            var iconSVG
            if (data.change_percentage < 0) {
                bdgcolor = "danger"
                iconSVG = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                    '<rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="red"/>' +
                    '<path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="red"/>' +
                    '</svg>';
            } else if (data.change_percentage > 0) {
                bdgcolor = "success"
                var iconSVG = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                    '<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="green"/>' +
                    '<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="green"/>' +
                    '</svg>';
            } else {
                bdgcolor = "warning";
                iconSVG = '';
                data.change_percentage = 0;
            }
            $("#magnitude_div_" + col).addClass('badge-light-' + bdgcolor)
            $("#magnitude_div_" + col).addClass(bdgcolor)
            $("#magnitude_div_" + col).html(iconSVG + " " + data.change_percentage + " %");

            $("#slider_carrier_div_" + col).text('$' + data.slider_min_carrier + '-  $' + data.slider_max_carrier)
            $("#fantasy_name_div_broker_" + col).text(data.fantasy_name)
            $("#rpm_div_broker_" + col).text(data.rpm_shipper + "/mi")
            $("#distance_div_broker_" + col).text(data.distance + " mi")
            $("#broker_div_" + col).text(data.shipper)

            $("#magnitude_div_broker_" + col).addClass('badge-light-' + bdgcolor)
            $("#magnitude_div_broker_" + col).addClass(bdgcolor)
            $("#magnitude_div_broker_" + col).html(iconSVG + " " + data.change_percentage + " %");

            $("#res_div_" + col).css('display', 'block')

            $("#btn_enlarge_" + col).attr('data-fantasy-name', data.fantasy_name);
            $("#btn_enlarge_" + col).attr('data-last-updated', 'Last updated:' + data.last_updated);
            $("#btn_enlarge_" + col).attr('data-rpm', data.rpm_carrier + "/mi");
            $("#btn_enlarge_" + col).attr('data-distance', data.distance + " mi");
            $("#btn_enlarge_" + col).attr('data-direct-quote', data.carrier);
            $("#btn_enlarge_" + col).attr('data-direct-porcentaje', '9,52%');
            $("#btn_enlarge_" + col).attr('data-fair-quote', data.shipper);

            $("#btn_enlarge_" + col).attr('data-slider-broker', '$' + data.slider_min_broker + '-  $' + data.slider_max_broker);
            $("#btn_enlarge_" + col).attr('data-slider-direct', '$' + data.slider_min_carrier + '-  $' + data.slider_max_carrier);

            $('.cual_es_' + col).data('lane', data.lane_id);

            //    data-alert-fantasy="" data-alert-direct="" data-alert-broker="" data-alert-lane="" id="alert_<?php echo $i; ?>_btn"

            $("#alert_" + col + "_btn").data("alert-fantasy", data.fantasy_name)
            $("#alert_" + col + "_btn").data("alert-direct", data.carrier)
            $("#alert_" + col + "_btn").data("alert-broker", data.shipper)
            $("#alert_" + col + "_btn").data("alert-lane-id", data.lane_id)


            var is_spotter_text
            if (parseInt(data.is_spotter) === 0) {
                // is_spotter_text = "AI Learning Mode"

                $('.tooltip_spot_on_ai_' + col).css('display', 'block')
                $('.tooltip_spot_on_le_' + col).css('display', 'none')

                $(".do_you_want_div_" + col).css('display', 'block')

            } else {
                // is_spotter_text = "Spot Market \n Spot on !"

                $('.tooltip_spot_on_ai_' + col).css('display', 'none')
                $('.tooltip_spot_on_le_' + col).css('display', 'block')

                //$('.tooltip_spot_on_' + col).attr('title', 'This lane has already been learned by our Spot Market, Spot On AI algorithm.');
                //$('.tooltip_spot_on_' + col).prop('title', 'This lane has already been learned by our Spot Market, Spot On AI algorithm.');
                $(".do_you_want_div_" + col).css('display', 'none')
            }
            // $(".is_spotter_div_" + col).text(is_spotter_text)

            $('#search_' + col + '_btn').prop('disabled', false);
            stopFlashing(col)

            // Wait for 2 seconds (2000 milliseconds) and then trigger the function
            setTimeout(re_armo_search(), 2000);

            if ($('#res_div_1').css('display') === 'block') {
                button.removeAttribute("data-kt-indicator");
                $("#search_1_btn").css("pointer-events", "unset");
                $("#origin_1").css("pointer-events", "unset");
                $("#destination_1").css("pointer-events", "unset");
                $("#equipment_1").css("pointer-events", "unset");
            }

            if ($('#res_div_2').css('display') === 'block') {
                button2.removeAttribute("data-kt-indicator");
                $("#search_2_btn").css("pointer-events", "unset");
                $("#origin_2").css("pointer-events", "unset");
                $("#destination_2").css("pointer-events", "unset");
                $("#equipment_2").css("pointer-events", "unset");
            }

            // if ($('#res_div_3').css('display') === 'block') {
            // button3.removeAttribute("data-kt-indicator");
            //$("#search_3_btn").css("pointer-events", "unset");
            //$("#origin_3").css("pointer-events", "unset");
            // $("#destination_3").css("pointer-events", "unset");
            //  $("#equipment_3").css("pointer-events", "unset");
            //}
        }

        if (rowSelector) {
            rowSelector.find('.direct-rate').text(`$${data.directRate}`);
            rowSelector.find('.broker-rate').text(`$${data.brokerRate}`);
            rowSelector.find('.times-ago').text(`Just now`);
            if (data.change_percentage < 0) {
    // bdgcolor = "danger"
    iconSVG = '<svg width="18" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">' +
        '<rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="red"/>' +
        '<path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="red"/>' +
        '</svg>';
        rowSelector.find('.change_percentage_class').css(
            {
                'border-radius': '5px',
                'display': 'flex',
                'width': 'max-content',
                "background-color": "#fcefec",
                "color": "#F64E60",
                "align-items": "center"
                
            }).html(iconSVG + " " + data.change_percentage + "%");
        rowSelector.find('.change_percentage_class > span').css("font-size", "1rem");
} else if (data.change_percentage > 0) {
    // bdgcolor = "success"
    var iconSVG = '<svg width="18" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">' +
        '<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="green"/>' +
        '<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="green"/>' +
        '</svg>';
        rowSelector.find('.change_percentage_class').css(
            {
                'border-radius': '5px',
                'display': 'flex',
                'width': 'max-content',
                "color": "#36B37E",
                "background-color": "#f4fbdb",
                "align-items": "center"
                
            }).html(iconSVG + " " + data.change_percentage + "%");
        rowSelector.find('.change_percentage_class > span').css("font-size", "1rem");

} else {
    // bdgcolor = "#fcf4d6";
    iconSVG = `<span class="svg-icon svg-icon-2 svg-icon-text-gray-700"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
</svg></span>`;
    data.change_percentage = 0;
    rowSelector.find('.change_percentage_class').css(
            {
                'border-radius': '5px',
                'display': 'flex',
                'width': 'max-content',
                "background-color": "#fcf4d6",
                "align-items": "center"
                
            }).html(iconSVG + " " + data.change_percentage + ".00%");
        rowSelector.find('.change_percentage_class > span').css("font-size", "1rem");
}

            setTimeout(() => {
                selector.removeClass('btn-danger').addClass('btn-success').text('Updated').prop('disabled', true);
            }, 500);

        }

        dataFunction();
        dataFunction1();
    }

    // [contar_busquedas] => 1
    //    [busquedas] => 0

    // search_<?php echo $i; ?>_btn

    // <?php
    // if($_SESSION['contar_busquedas'] === 1){
    //     ?>

    //     $(document).ready(function(){

    //         const url = 'ajax/cuenta_busquedas.php';
    //         fetch(url)
    //             .then((response) => {
    //                 if (!response.ok) {
    //                     throw new Error(`HTTP error! Status: ${response.status}`);
    //                 }
    //                 // Parse the response body as JSON
    //                 return response.json();
    //             })
    //             .then((data) => {

    //                 if(parseInt(data.quedan) <= 0){
    //                     Swal.fire("You are in trial mode and you have reached the max amount of searches allowed.");
    //                     $("#search_1_btn, #search_2_btn, #search_3_btn").prop('disabled', true)
    //                 } else {
    //                     Swal.fire("You are in trial mode and you have " + data.quedan + " searches remaining.");
    //                 }
    //             })
    //             .catch((error) => {
    //                 // Handle errors
    //                 console.error('Fetch Error:', error);
    //             });


    //         $("#search_1_btn, #search_2_btn, #search_3_btn").on('click', function(){
    //             const url = 'ajax/cuenta_busquedas.php';
    //             fetch(url)
    //                 .then((response) => {
    //                     if (!response.ok) {
    //                         throw new Error(`HTTP error! Status: ${response.status}`);
    //                     }
    //                     // Parse the response body as JSON
    //                     return response.json();
    //                 })
    //                 .then((data) => {
    //                     // Handle the JSON data
    //                     if(parseInt(data.quedan) <= 4){
    //                         Swal.fire("You are in trial mode and you have "+data.quedan+" searches remaining.");
    //                     }
    //                     if(parseInt(data.quedan) <= 0){
    //                         Swal.fire("You are in trial mode and you have reached the max amount of searches allowed.");
    //                         $("#search_1_btn, #search_2_btn, #search_3_btn").prop('disabled', true)
    //                     }
    //                 })
    //                 .catch((error) => {
    //                     // Handle errors
    //                     console.error('Fetch Error:', error);
    //                 });
    //         })

    //     })
    // <?php
    // }
    // ?>


    const modal_mirando_chart = {
        cual: 0
    }

    const cuantas = {
        quedan:  <?php echo isset($_SESSION['want_to_learn']); ?>
    }

    $("#confirma_aprender").on('click', function () {
        let cual_f_lane = $(this).data('lane')
        $.ajax({
            url: 'ajax/confirma_aprender.php?lane=' + cual_f_lane,
            dataType: 'json',
            success: function (data) {
                cuantas.quedan = parseInt(cuantas.quedan) - 1
                $("#learn_lane").modal('hide')
                // console.log(cuantas.quedan)
            },
            error: function () {
                alert('Please refresh page.');
            }
        });
    })


    // #search_1_btn
    var button = document.querySelector("#search_1_btn");
    // Handle button click event
    button.addEventListener("click", function () {
        // Activate indicator
        button.setAttribute("data-kt-indicator", "on");
        // $("#search_1_btn").css("pointer-events", "none");
        // $("#origin_1").css("pointer-events", "none");
        // $("#destination_1").css("pointer-events", "none");
        // $("#equipment_1").css("pointer-events", "none");
        // Disable indicator after 7 seconds
        // setTimeout(function() {
        //     button.removeAttribute("data-kt-indicator");
        // }, 7000);
    });
    $("#search_1_btn").on('click', function () {
        var origin_1 = $("#origin_1").val()
        var destination_1 = $("#destination_1").val()
        var equipment_1 = $("#equipment_1").val()
        if (origin_1 !== '' && destination_1 !== '' && equipment_1 !== '') {
            send_rate_request(origin_1, destination_1, equipment_1, 1)
            //$('#search_1_btn').prop('disabled', true);
            //startFlashing(1)
        }
    })

    // #search_2_btn
    var button2 = document.querySelector("#search_2_btn");
    // Handle button click event
    button2.addEventListener("click", function () {
        // Activate indicator
        button2.setAttribute("data-kt-indicator", "on");
        // $("#search_2_btn").css("pointer-events", "none");
        // $("#origin_2").css("pointer-events", "none");
        // $("#destination_2").css("pointer-events", "none");
        // $("#equipment_2").css("pointer-events", "none");
        // Disable indicator after 7 seconds
        // setTimeout(function() {
        //     button2.removeAttribute("data-kt-indicator");
        // }, 7000);
    });
    $("#search_2_btn").on('click', function () {
        var origin_2 = $("#origin_2").val()
        var destination_2 = $("#destination_2").val()
        var equipment_2 = $("#equipment_2").val()
        if (origin_2 !== '' && destination_2 !== '' && equipment_2 !== '') {
            send_rate_request(origin_2, destination_2, equipment_2, 2)
            //$('#search_2_btn').prop('disabled', true);
            //startFlashing(2)
        }
    })

    // #search_3_btn
    // var button3 = document.querySelector("#search_3_btn");
    // Handle button click event
    // button3.addEventListener("click", function() {
    // Activate indicator
    // button3.setAttribute("data-kt-indicator", "on");
    //  $("#search_3_btn").css("pointer-events", "none");
    //  $("#origin_3").css("pointer-events", "none");
    //  $("#destination_3").css("pointer-events", "none");
    // $("#equipment_3").css("pointer-events", "none");
    // Disable indicator after 7 seconds
    // setTimeout(function() {
    //     button3.removeAttribute("data-kt-indicator");
    // }, 7000);
    //  });
    // $("#search_3_btn").on('click', function() {
    // var origin_3 = $("#origin_3").val()
    //var destination_3 = $("#destination_3").val()
    // var equipment_3 = $("#equipment_3").val()
    // if (origin_3 !== '' && destination_3 !== '' && equipment_3 !== '') {
    //  send_rate_request(origin_3, destination_3, equipment_3, 3)
    //$('#search_3_btn').prop('disabled', true);
    //startFlashing(3)
    // }
    //})


    document.addEventListener('DOMContentLoaded', function () {
        $('.js-typeahead-country_v1').typeahead({
            source: [
                <?php
                foreach ($all_c as $v) {
                ?> "<?php echo $v->city; ?>",
                <?php
                }
                ?>
            ]
        });

        /*
        $('.js-typeahead-country_v1').typeahead({
        offset: true,
        input: '.js-typeahead-country_v1',
        hint: true,
        source: {
            data: [
        <?php
        foreach ($all_c as $v) {
        ?> "<?php echo $v->city; ?>",
                    <?php
        }
        ?>
                ]
            },
            callback: {
                onInit: function(node) {
                    console.log('Typeahead Initiated on ' + node.selector);
                }
            }
            });
            */
    });


    $(".abre_modal_learn").on('click', function () {

        $("#cuantos_quedan_p").text(cuantas.quedan)

        let que_lane = $(this).data('lane');
        $("#confirma_aprender").data('lane', que_lane)
        $("#learn_lane").modal('show')
    })

    $(".btn_enlarge").on('click', function () {
        $('.chart_4').removeClass('active');
        $('.mod_5').addClass('active');
        var columna_modal = parseInt($(this).attr('data-col'))
        modal_mirando_chart.cual = parseInt(columna_modal)
        chart_modal(5)

        var fantasy_name = $("#btn_enlarge_" + columna_modal).attr('data-fantasy-name');
        var rpm_carrier = $("#btn_enlarge_" + columna_modal).attr('data-rpm');
        var distance = $("#btn_enlarge_" + columna_modal).attr('data-distance');
        var direct_quote = $("#btn_enlarge_" + columna_modal).attr('data-direct-quote');
        var direct_porcentaje = $("#btn_enlarge_" + columna_modal).attr('data-direct-porcentaje');
        var fair_quote = $("#btn_enlarge_" + columna_modal).attr('data-fair-quote');
        var slider_direct = $("#btn_enlarge_" + columna_modal).attr('data-slider-direct');
        var slider_broker = $("#btn_enlarge_" + columna_modal).attr('data-slider-broker');


        $("#modal_slider_direct_div").text(slider_direct)
        $("#modal_slider_fair_div").text(slider_broker)

        $("#fantasy_name_div_5").text(fantasy_name)

        $("#rpm_div_5").text(rpm_carrier + "/mi")
        $("#distance_div_5").text(distance + " mi")
        $("#carrier_div_5").text(direct_quote)

        $("#last_updated_div_broker_5").text('Last updated 45 min ago')
        $("#fantasy_name_div_broker_5").text(fantasy_name)
        $("#rpm_div_broker_5").text(rpm_carrier + "/mi")
        $("#distance_div_broker_5").text(distance + " mi")
        $("#carrier_div_broker_5").text(fair_quote)

        $("#chart_modal").modal('show')
    })

    $(".cambia_chart_modal").on('click', function () {
        var rango_busca = parseInt($(this).attr('data-time-range'))
        $('.chart_4').removeClass('active');
        $(this).addClass('active');
        chart_modal(rango_busca)
    })


    $(".cambia_chart").on('click', function () {
        var columna = parseInt($(this).attr('data-search-numero'))
        var rango_busca = parseInt($(this).attr('data-time-range'))
        $('.chart_' + columna).removeClass('active');
        $(this).addClass('active');
        actualizo_chart(columna, rango_busca)
    })


    $("#alert_1_btn").on('click', function () {
        $("#alert_direct").val($(this).data("alert-direct"))
        $("#alert_broker").val($(this).data("alert-broker"))
        $("#alert_fantasy").val($(this).data("alert-fantasy"))
        $("#alert_lane_id").val($(this).data("alert-lane-id"))

        $("#btn_tocado").val("alert_1_btn")
        $("#alert_modal").modal('show')
    })

    $("#alert_1_broker_btn").on('click', function () {
        $("#alert_direct").val($(this).data("alert-direct"))
        $("#alert_broker").val($(this).data("alert-broker"))
        $("#alert_fantasy").val($(this).data("alert-fantasy"))
        $("#alert_lane_id").val($(this).data("alert-lane-id"))

        $("#btn_tocado").val("alert_1_broker_btn")
        $("#alert_modal").modal('show')
    })

    $("#alert_2_btn").on('click', function () {
        $("#alert_direct").val($(this).data("alert-direct"))
        $("#alert_broker").val($(this).data("alert-broker"))
        $("#alert_fantasy").val($(this).data("alert-fantasy"))
        $("#alert_lane_id").val($(this).data("alert-lane-id"))

        $("#btn_tocado").val("alert_2_btn")
        $("#alert_modal").modal('show')
    })

    $("#alert_2_broker_btn").on('click', function () {
        $("#alert_direct").val($(this).data("alert-direct"))
        $("#alert_broker").val($(this).data("alert-broker"))
        $("#alert_fantasy").val($(this).data("alert-fantasy"))
        $("#alert_lane_id").val($(this).data("alert-lane-id"))

        $("#btn_tocado").val("alert_2_broker_btn")
        $("#alert_modal").modal('show')
    })

    $("#alert_3_btn").on('click', function () {
        $("#alert_direct").val($(this).data("alert-direct"))
        $("#alert_broker").val($(this).data("alert-broker"))
        $("#alert_fantasy").val($(this).data("alert-fantasy"))
        $("#alert_lane_id").val($(this).data("alert-lane-id"))

        $("#btn_tocado").val("alert_3_btn")
        $("#alert_modal").modal('show')
    })

    $("#alert_3_broker_btn").on('click', function () {
        $("#alert_direct").val($(this).data("alert-direct"))
        $("#alert_broker").val($(this).data("alert-broker"))
        $("#alert_fantasy").val($(this).data("alert-fantasy"))
        $("#alert_lane_id").val($(this).data("alert-lane-id"))

        $("#btn_tocado").val("alert_3_broker_btn")
        $("#alert_modal").modal('show')
    })


    $(".set_alert_btn").on('click', function () {
        var cual = $("#btn_tocado").val()
        var myButton = $('#' + cual);
        var equipment;
        // Change the text of the button
        myButton.text('Alert Set');

        // Remove the old button class and add the new one
        myButton.removeClass('btn-success');
        myButton.addClass('btn-secondary');

        var alert_valor = $("#alert_valor").val()
        var alert_email = $("#alert_email").val()
        var alert_direct = $("#alert_direct").val()
        var alert_broker = $("#alert_broker").val()
        var alert_fantasy = $("#alert_fantasy").val()
        var alert_lane_id = $("#alert_lane_id").val()

        if ($("#equipment_1").val()) {
            equipment = $("#equipment_1").val();
        } else if ($("#equipment_2").val()) {
            equipment = $("#equipment_2").val();
        } else if ($("#equipment_3").val()) {
            equipment = $("#equipment_3").val();
        } else {
            // If none of the elements have a value set, you can set a default value or handle it as needed
            equipment = "reefer";
        }
        console.log('valor', alert_valor)
        if (alert_email.trim() === '') {
            Swal.fire("Oops...", "Something went wrong.  Please fill in alert email field", "error");
            return;
        }

        $.ajax({
            url: 'seteo_alert.php',
            type: 'POST',
            data: {
                alert_valor: alert_valor,
                alert_email: alert_email,
                alert_direct: alert_direct,
                alert_broker: alert_broker,
                alert_fantasy: alert_fantasy,
                alert_lane_id: alert_lane_id,
                equipment: equipment,
            },
            success: function (data) {
                // Replace the content of a div with the parsed data
                // console.log(data)
                if(data){
                    alert("You Have Reached Your Limit");
                }
            },
            error: function () {
                // Handle error if the AJAX request fails
                console.log('Error occurred while fetching JSON data');
            }
        });

        $("#alert_modal").modal('hide')
    })


    const resultados_charts = {
        col: []
    }
    resultados_charts.col[1] = []
    resultados_charts.col[1][5] = []
    resultados_charts.col[1][30] = []
    resultados_charts.col[1][180] = []
    resultados_charts.col[1][365] = []

    resultados_charts.col[2] = []
    resultados_charts.col[2][5] = []
    resultados_charts.col[2][30] = []
    resultados_charts.col[2][180] = []
    resultados_charts.col[2][365] = []

    resultados_charts.col[3] = []
    resultados_charts.col[3][5] = []
    resultados_charts.col[3][30] = []
    resultados_charts.col[3][180] = []
    resultados_charts.col[3][365] = []


    function send_rate_request(origin, destination, equipment, col, selector = null) {
        const data = {
            origin: origin,
            destination: destination,
            equipment: equipment,
            pull_rates: !col
        }

        $.ajax({
            url: 'ajax/make_quote.php',
            dataType: 'json',
            type: 'POST',
            data: data,
            beforeSend: function () {
                if (selector) {
                    // var $button = $(selector);
                    // buttonLoader($button, 'loading');
                    buttonLoader($(selector), 'loading');
                }

                $('.btn-update').prop('disabled', true);
                $(`#res_div_${col}`).hide();
            },
            success: function (data) {
                // console.log('data',data);
                if (data.error === 1) {
                    stopFlashing(col)
                    alert(data.message)
                    return
                }
                changeFieldsWithAjaxResponse(data, col, selector);

            },
            error: function () {
                alert('Please check every field.');
                stopFlashing(col);
            },
            complete: function () {
                if (selector) {
                    buttonLoader($(selector), 'reset');
                }

                $('.btn-update').prop('disabled', false);
            }
        });
    }

    function re_armo_search() {
        console.log("aca")
        $.ajax({
            url: 'add_1_history_lane.php',
            type: 'GET',
            success: function (data) {
                // Replace the content of a div with the parsed data
                $('#search_history_div').html(data);
            },
            error: function () {
                // Handle error if the AJAX request fails
                console.log('Error occurred while fetching JSON data');
            }
        });
    }

    let intervalId

    function startFlashing(col) {
        intervalId = setInterval(function () {
            $('#search_' + col + '_btn').fadeOut(500).fadeIn(500);
        }, 1000);
    }

    function stopFlashing(col) {
        clearInterval(intervalId);
        $('#search_' + col + '_btn').stop().fadeIn().show();
        $(`#search_${col}_btn`).removeAttr("data-kt-indicator");
    }


    document.addEventListener("DOMContentLoaded", function () {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const myParam = urlParams.get('sec');
        const myEq = urlParams.get('eq');
        var equipment

        if (myEq === "1") {
            equipment = 'reefer'
        }
        if (myEq === "3") {
            equipment = 'flat'
        }
        if (myEq === "2") {
            equipment = 'van'
        }

        if (myParam) {
            $.ajax({
                url: 'ajax/traigo_section.php?sec=' + myParam,
                dataType: 'json',
                success: function (data) {
                    $("#origin_1").val(data.origin)
                    $("#destination_1").val(data.destination)
                    $("#equipment_1").val(equipment)
                    const myButton = document.getElementById('search_1_btn');
                    myButton.click();

                },
                error: function () {
                    alert('Please refresh page.');
                }
            });
        }
    });


    function actualizo_chart(col, rango) {
        if (col === 1) {
            chart_search_result_1.updateSeries([{
                name: 'Rate',
                data: resultados_charts.col[col][rango]
            }])
        }

        if (col === 2) {
            chart_search_result_2.updateSeries([{
                name: 'Rate',
                data: resultados_charts.col[col][rango]
            }])
        }

        if (col === 3) {
            chart_search_result_3.updateSeries([{
                name: 'Rate',
                data: resultados_charts.col[col][rango]
            }])
        }


    }


    function chart_modal(rango) {

        chart_search_result_4.updateSeries([{
            name: 'Rate',
            data: resultados_charts.col[modal_mirando_chart.cual][rango]
        }])

    }

    function armo_chart(col) {

        if (col === 1) {
            chart_search_result_1.updateSeries([{
                name: 'Rate',
                data: resultados_charts.col[col][5]
            }])
        }

        if (col === 2) {
            chart_search_result_2.updateSeries([{
                name: 'Rate',
                data: resultados_charts.col[col][5]
            }])
        }

        if (col === 3) {
            chart_search_result_3.updateSeries([{
                name: 'Rate',
                data: resultados_charts.col[col][5]
            }])
        }

    }


    //begin chart
    var element = document.getElementById('chart_search_result_1');
    var height = parseInt(KTUtil.css(element, 'height'));
    var element2 = document.getElementById('chart_search_result_2');
    var element3 = document.getElementById('chart_search_result_3');
    var element4 = document.getElementById('chart_search_result_4');


    var labelColor = KTUtil.getCssVariableValue('--kt-gray-500');
    var borderColor = KTUtil.getCssVariableValue('--kt-gray-200');
    var baseColor = KTUtil.getCssVariableValue('--kt-info');
    var lightColor = KTUtil.getCssVariableValue('--kt-info-light');

    var options_todos_los_charts = {
        series: [],
        chart: {
            height: 300,
            fontFamily: 'inherit',
            type: 'area',
            height: height,
            toolbar: {
                show: false
            }
        },
        plotOptions: {},
        legend: {
            show: false
        },
        dataLabels: {
            enabled: false
        },
        fill: {
            type: 'solid',
            opacity: 1
        },
        stroke: {
            curve: 'smooth',
            show: true,
            width: 3,
            colors: [baseColor]
        },
        xaxis: {

            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            labels: {
                style: {
                    colors: labelColor,
                    fontSize: '12px'
                }
            },
            crosshairs: {
                position: 'front',
                stroke: {
                    color: baseColor,
                    width: 1,
                    dashArray: 3
                }
            },
            tooltip: {
                enabled: true,
                formatter: undefined,
                offsetY: 0,
                style: {
                    fontSize: '12px'
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: labelColor,
                    fontSize: '12px'
                },
                formatter: function (val) {
                    return "$" + val.toString();
                }
            }
        },
        states: {
            normal: {
                filter: {
                    type: 'none',
                    value: 0
                }
            },
            hover: {
                filter: {
                    type: 'none',
                    value: 0
                }
            },
            active: {
                allowMultipleDataPointsSelection: false,
                filter: {
                    type: 'none',
                    value: 0
                }
            }
        },
        tooltip: {
            style: {
                fontSize: '12px'
            },
            y: {
                formatter: function (val) {
                    return '$' + val
                }
            }
        },
        colors: [lightColor],
        grid: {
            borderColor: borderColor,
            strokeDashArray: 4,
            yaxis: {
                lines: {
                    show: true
                }
            }
        },
        markers: {
            strokeColor: baseColor,
            strokeWidth: 3
        },
        noData: {
            text: 'Loading...'
        }
    };


    var options_todos_los_charts_modal = {
        series: [],
        chart: {
            height: height,
            fontFamily: 'inherit',
            type: 'area',
            toolbar: {
                show: false
            }
        },
        plotOptions: {},
        legend: {
            show: false
        },
        dataLabels: {
            enabled: false
        },
        fill: {
            type: 'solid',
            opacity: 1
        },
        stroke: {
            curve: 'smooth',
            show: true,
            width: 3,
            colors: [baseColor]
        },
        xaxis: {

            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            labels: {
                style: {
                    colors: labelColor,
                    fontSize: '12px'
                }
            },
            crosshairs: {
                position: 'front',
                stroke: {
                    color: baseColor,
                    width: 1,
                    dashArray: 3
                }
            },
            tooltip: {
                enabled: true,
                formatter: undefined,
                offsetY: 0,
                style: {
                    fontSize: '12px'
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: labelColor,
                    fontSize: '12px'
                },
                formatter: function (val) {
                    return "$" + val.toString();
                }
            }
        },
        states: {
            normal: {
                filter: {
                    type: 'none',
                    value: 0
                }
            },
            hover: {
                filter: {
                    type: 'none',
                    value: 0
                }
            },
            active: {
                allowMultipleDataPointsSelection: false,
                filter: {
                    type: 'none',
                    value: 0
                }
            }
        },
        tooltip: {
            style: {
                fontSize: '12px'
            },
            y: {
                formatter: function (val) {
                    return '$' + val
                }
            }
        },
        colors: [lightColor],
        grid: {
            borderColor: borderColor,
            strokeDashArray: 4,
            yaxis: {
                lines: {
                    show: true
                }
            }
        },
        markers: {
            strokeColor: baseColor,
            strokeWidth: 3
        },
        noData: {
            text: 'Loading...'
        }
    };

    var chart_search_result_1 = new ApexCharts(document.querySelector("#chart_search_result_1"), options_todos_los_charts);
    chart_search_result_1.render();

    var chart_search_result_2 = new ApexCharts(document.querySelector("#chart_search_result_2"), options_todos_los_charts);
    chart_search_result_2.render();

    var chart_search_result_3 = new ApexCharts(document.querySelector("#chart_search_result_3"), options_todos_los_charts);
    chart_search_result_3.render();

    var chart_search_result_4 = new ApexCharts(document.querySelector("#chart_search_result_4"), options_todos_los_charts_modal);
    chart_search_result_4.render();


    var inactivityTimeLimit = 3600000;
    var inactivityTimer;

    function startInactivityTimer() {
        inactivityTimer = setTimeout(logOutUser, inactivityTimeLimit);
    }

    function resetInactivityTimer() {
        clearTimeout(inactivityTimer);
        startInactivityTimer();
    }

    function logOutUser() {
        window.location.href = "log_out.php";
    }

    $(document).ready(function () {
        startInactivityTimer();
    });
    $(document).on("mousemove keypress mousedown touchstart", function () {
        resetInactivityTimer();
    });

    function dataFunction() {
        var directRate = document.getElementById("fantasy_name_div_1").innerHTML
        var brokerRate = document.getElementById("fantasy_name_div_broker_1").innerHTML
        var valueequipment = document.getElementById("equipment_1").value
        var [firstPart, secondPart] = directRate.split(' - ');
        var docRate = document.querySelector("#res_div_1 #doc-rate").innerHTML = firstPart
        var broRate = document.querySelector("#res_div_1 #bro-rate").innerHTML = secondPart
        var equipmentVal = document.querySelector("#res_div_1 #equipment-val").innerHTML = valueequipment
        if (valueequipment === "van") {
            $("#truck_1").css("display", "block");
            $("#truck_1").attr("src", `<?= BASE_URL ?>images/${valueequipment}.png`);
        } else if (valueequipment === "reefer") {
            $("#truck_1").css("display", "block");
            $("#truck_1").attr("src", `<?= BASE_URL ?>images/${valueequipment}.png`);
        } else if (valueequipment === "flat") {
            $("#truck_1").css("display", "block");
            $("#truck_1").attr("src", `<?= BASE_URL ?>images/${valueequipment}.png`);
        } else {
            console.log("not");
        }

    }

    function dataFunction1() {
        var directRate1 = document.getElementById("fantasy_name_div_2").innerHTML
        var brokerRate1 = document.getElementById("fantasy_name_div_broker_2").innerHTML
        var valueequipment1 = document.getElementById("equipment_2").value
        var [firstPart1, secondPart1] = directRate1.split(' - ');
        var docRate1 = document.querySelector("#res_div_2 #doc-rate").innerHTML = firstPart1
        var broRate1 = document.querySelector("#res_div_2 #bro-rate").innerHTML = secondPart1
        var equipmentVal1 = document.querySelector("#res_div_2 #equipment-val").innerHTML = valueequipment1

        if (valueequipment1 === "van") {
            $("#truck_2").css("display", "block");
            $("#truck_2").attr("src", `<?= BASE_URL ?>images/${valueequipment1}.png`);
        } else if (valueequipment1 === "reefer") {
            $("#truck_2").css("display", "block");
            $("#truck_2").attr("src", `<?= BASE_URL ?>images/${valueequipment1}.png`);
        } else if (valueequipment1 === "flat") {
            $("#truck_2").css("display", "block");
            $("#truck_2").attr("src", `<?= BASE_URL ?>images/${valueequipment1}.png`);
        } else {
            console.log("not");
        }
    }

    const getMatchedRows = (fantasyName, equipment) => {
        let matchedRows = [];
        $('#search_history_div .history-records').each(function () {
            const rowFantasyName = $(this).find('.fantasy_name').text();
            const rowEquipment = $(this).find('.equipment').text();
            if (rowFantasyName === fantasyName && rowEquipment === equipment) {
                matchedRows.push($(this));
            }
        });

        return matchedRows;
    }

    function updateAllRecords() {
        var allFantasyNames = [];
        var uniqueFantasyNames = {};

        $('.fantasy_name').each(function (index) {
            var fullName = $(this).text();
            var splitName = fullName.split('-');
            var origin = splitName[0].trim();
            var destination = splitName[1].trim();
            var equipment = $('.equipment').eq(index).text().trim();
            var directRate = $('.direct-rate').eq(index).text().trim();
            var key = origin + '-' + destination + '-' + equipment;

            if (!uniqueFantasyNames[key]) {
                allFantasyNames.push({
                    origin: origin,
                    destination: destination,
                    equipment: equipment,
                    fullName: fullName,
                    directRate: directRate
                });
                uniqueFantasyNames[key] = true;
            }
        });

        const $button = $('#btn-update-all');

        $.ajax({
            url: 'ajax/update_all_history.php',
            type: 'POST',
            data: {allFantasyNames: JSON.stringify(allFantasyNames)},
            beforeSend: function () {
                buttonLoader($button, 'loading');
            },
            success: function (response) {
                console.log('server response', response);

                if (response.includes('No Data Found')) {
                    console.log('No data found.');
                } else {
                    var data = JSON.parse(response);

                    data.forEach(element => {
                        const matchedRows = getMatchedRows(element.fantasy_name, element.equipment);
                        matchedRows.forEach(row => {
                            const buttonSelector = row.find('.btn-update');
                            changeFieldsWithAjaxResponse(element, null, buttonSelector);
                        })
                    });
                }

                setTimeout(() => {
                    resetUpdateAllButton();
                }, 600);
            },
            error: function () {
                console.log('Error occurred while fetching JSON data');
            },
            complete: function () {
                buttonLoader($button, 'reset');
            }
        });
    }
</script>


</body>
<!--end::Body-->

</html>