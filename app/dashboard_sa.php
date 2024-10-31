<?php
include("login_check.php");
include("config.php");
include("assets/php/quote_class.php");
include("assets/php/svg_class.php");

$reefer_hot_lanes = $quote->getHotLanes('reefer');
$reefer_cold_lanes = $quote->getLowLanes('reefer');

$van_hot_lanes = $quote->getHotLanes('van');
$van_cold_lanes = $quote->getLowLanes('van');

$flat_hot_lanes = $quote->getHotLanes('flat');
$flat_cold_lanes = $quote->getLowLanes('flat');


$sql = "SELECT *, 
((van_loads_0 - van_loads_1) / ((van_loads_0 + van_loads_1) / 2)) * 100 AS percentage_van,
((reefer_loads_0 - reefer_loads_1) / ((reefer_loads_0 + reefer_loads_1) / 2)) * 100 AS percentage_reefer,
((flat_loads_0 - flat_loads_1) / ((flat_loads_0 + flat_loads_1) / 2)) * 100 AS percentage_flat,
((power_loads_0 - power_loads_1) / ((power_loads_0 + power_loads_1) / 2)) * 100 AS percentage_power,
((heavy_loads_0 - heavy_loads_1) / ((heavy_loads_0 + heavy_loads_1) / 2)) * 100 AS percentage_heavy,
((van_loads_picking_0 - van_loads_picking_1) / ((van_loads_picking_0 + van_loads_picking_1) / 2)) * 100 AS percentage_van_picking,
((reefer_loads_picking_0 - reefer_loads_picking_1) / ((reefer_loads_picking_0 + reefer_loads_picking_1) / 2)) * 100 AS percentage_reefer_picking,
((flat_loads_picking_0 - flat_loads_picking_1) / ((flat_loads_picking_0 + flat_loads_picking_1) / 2)) * 100 AS percentage_flat_picking,
((power_loads_picking_0 - power_loads_picking_1) / ((power_loads_picking_0 + power_loads_picking_1) / 2)) * 100 AS percentage_power_picking,
((heavy_loads_picking_0 - heavy_loads_picking_1) / ((heavy_loads_picking_0 + heavy_loads_picking_1) / 2)) * 100 AS percentage_picking_heavy, 
((van_loads_dropping_0 - van_loads_dropping_1) / ((van_loads_dropping_0 + van_loads_dropping_1) / 2)) * 100 AS percentage_van_dropping,
((reefer_loads_dropping_0 - reefer_loads_dropping_1) / ((reefer_loads_dropping_0 + reefer_loads_dropping_1) / 2)) * 100 AS percentage_reefer_dropping,
((flat_loads_dropping_0 - flat_loads_dropping_1) / ((flat_loads_dropping_0 + flat_loads_dropping_1) / 2)) * 100 AS percentage_flat_dropping,
((power_loads_dropping_0 - power_loads_dropping_1) / ((power_loads_dropping_0 + power_loads_dropping_1) / 2)) * 100 AS percentage_power_dropping,
((heavy_loads_dropping_0 - heavy_loads_dropping_1) / ((heavy_loads_dropping_0 + heavy_loads_dropping_1) / 2)) * 100 AS percentage_dropping_heavy
FROM load_counts WHERE id = 1";
$ta = $quote->getThis1($sql);


$sumRat_v1 = 12;
$sumRat_v2 = -7;
$sumRat_v3 = -10;
$sumRat_v4 = 0;

?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <?php include("includes/head.php"); ?>

    <style>
        #flier_div {
            background-image: url("imgs/flier.jpg");
            background-size: cover;
            background-position: center center;
            cursor: pointer;
            border-radius: 10px;
        }

        #modal_flyer_img {
            background-image: url("imgs/flier.jpg");
            background-size: cover;
            background-position: center center;
        }


        table tbody tr:hover {
            /*.table.table-row-gray-300 tr:hover {*/
            border-radius: 4px;
            border-top: 1px solid grey;
            border-bottom: 1px solid grey;
            box-shadow: 0px 9px 4px -6px grey;
            background-color: rgb(255 255 133 / 40%);

            font-size: 15px;
        }

        tr .badge.badge-light-danger.fs-base:hover {
            font-size: 15px;
        }

        tr .badge.badge-light-success.fs-base:hover {
            font-size: 15px;
        }

        .text-gray-400:hover {
            font-size: 14px;
        }


        .hidden {
            display: none;
        }
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body data-kt-name="good" id="kt_app_body" data-kt-app-layout="light-sidebar" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" class="app-default">
    <!--begin::Theme mode setup on page load --- modified function recovering theme values-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            localStorage.setItem("data-theme-mode", localStorage.getItem("data-theme-imode"));
            localStorage.setItem("data-theme", localStorage.getItem("data-theme-i"));
            localStorage.removeItem("data-theme-imode");
            localStorage.removeItem("data-theme-i");

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

                                <!--begin::Row-->
                                <div class="row g-5 g-xl-10">
                                    <!--begin::Col-->
                                    <div class="col-xl-6 mb-xl-6">
                                        <!--begin::Lists Widget 19-->
                                        <div class="summary h-100">
                                            <div class="card card-flush h-xl-100">
                                                <!--begin::Heading-->
                                                <!--div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-250px" style="background-image:url('assets/media/svg/shapes/top-green.png" data-theme="light"-->
                                                <div class="card-header rounded pt-5">
                                                    <!--begin::Title-->
                                                    <h3 class="card-title align-items-start flex-column">
                                                        <span class="card-label fw-bold text-dark">WEEKLY SUMMARY</span>
                                                    </h3>
                                                </div>
                                                <!--end::Heading-->
                                                <!--begin::Body-->
                                                <div class="card-body" data-theme="light">
                                                    <!--begin::Row-->
                                                    <div class="row g-3 g-lg-6">
                                                        <!--begin::Col-->
                                                        <div class="col-6">
                                                            <!--begin::Items-->
                                                            <div class="bg-gray-100 bg-opacity-70 rounded-2 px-3 py-3 text-center">
                                                                <span class="text-dark fw-semibold fs-base">National Spot Market Rates</span>
                                                                <!--begin::Stats-->
                                                                <?php
                                                                $sql = "SELECT * FROM rates_table";
                                                                $sr = $quote->getThis1($sql);
                                                                ?>
                                                                <div class="row m-0">
                                                                    <div class="d-flex flex-center">
                                                                        <!--begin::Number-->
                                                                        <span class="text-gray-700 fw-bolder fs-2qx lh-1 ls-n1 mb-1">$<?php echo $sr->spot_market_rate; ?></span>
                                                                        <span class="text-dark fs-7">&nbsp;&nbsp;($<?php echo ($sr->spot_market_rate_diff / 100); ?>)</span>
                                                                        <!--end::Number-->
                                                                    </div>
                                                                    <div class="d-flex flex-center">
                                                                        <!--begin::Desc-->
                                                                        <?php
                                                                        //segun el % dibuja en verde, amarillo o rojo
                                                                        if ($sr->spot_market_rate_perc < "0") { //red
                                                                            $svg_icon = "danger";
                                                                            $svg_file = "arr065";
                                                                        } else if ($sr->spot_market_rate_perc > "0") { //green
                                                                            $svg_icon = "success";
                                                                            $svg_file = "arr066";
                                                                        } else { // yellow
                                                                            $svg_icon = "warning";
                                                                            $svg_file = "arr090";
                                                                        }
                                                                        ?>
                                                                        <!--begin::Label-->
                                                                        <span class="badge badge-light-<?php echo $svg_icon; ?> fs-6">
                                                                            <!--begin::Svg Icon | path: icons/duotune/arrows/<?php echo $svg_file; ?>.svg-->
                                                                            <?php
                                                                            echo getSvgIcon('assets/media/icons/duotune/arrows/' . $svg_file . '.svg', 'svg-icon-2 svg-icon-' . $svg_icon . ' ms-n1');
                                                                            ?>
                                                                            <?php echo round($sr->spot_market_rate_perc, 2); ?>
                                                                            %
                                                                        </span>
                                                                        <!--end::Label-->
                                                                        <!--end::Desc-->
                                                                    </div>
                                                                </div>
                                                                <!--end::Stats-->
                                                            </div>
                                                            <!--end::Items-->
                                                        </div>
                                                        <!--end::Col-->
                                                        <!--begin::Col-->
                                                        <div class="col-6">
                                                            <!--begin::Items-->
                                                            <div class="bg-gray-100 bg-opacity-70 rounded-2 px-3 py-3 text-center">
                                                                <span class="text-dark fw-semibold fs-base">National Contract Rates</span>
                                                                <!--begin::Stats-->
                                                                <div class="row m-0">
                                                                    <div class="d-flex flex-center">
                                                                        <!--begin::Number-->
                                                                        <span class="text-gray-700 fw-bolder fs-2qx lh-1 ls-n1 mb-1">$<?php echo $sr->contract_rate; ?></span>
                                                                        <span class="text-dark fs-7">&nbsp;&nbsp;($<?php echo ($sr->contract_rate_diff / 100); ?>)</span>
                                                                        <!--end::Number-->
                                                                    </div>
                                                                    <div class="d-flex flex-center">
                                                                        <!--begin::Desc-->
                                                                        <?php
                                                                        //segun el % dibuja en verde, amarillo o rojo
                                                                        if ($sr->contract_rate_perc < 0) { //red
                                                                            $svg_icon = "danger";
                                                                            $svg_file = "arr065";
                                                                        } else if ($sr->contract_rate_perc > 0) { //green
                                                                            $svg_icon = "success";
                                                                            $svg_file = "arr066";
                                                                        } else { // yellow
                                                                            $svg_icon = "warning";
                                                                            $svg_file = "arr090";
                                                                        }
                                                                        ?>
                                                                        <!--begin::Label-->
                                                                        <span class="badge badge-light-<?php echo $svg_icon; ?> fs-6">
                                                                            <!--begin::Svg Icon | path: icons/duotune/arrows/<?php echo $svg_file; ?>.svg-->
                                                                            <?php
                                                                            echo getSvgIcon('assets/media/icons/duotune/arrows/' . $svg_file . '.svg', 'svg-icon-2 svg-icon-' . $svg_icon . ' ms-n1');
                                                                            ?>
                                                                            <?php echo round($sr->contract_rate_perc, 2); ?>
                                                                            %
                                                                        </span>
                                                                        <!--end::Label-->
                                                                        <!--end::Desc-->
                                                                    </div>
                                                                </div>
                                                                <!--end::Stats-->
                                                            </div>
                                                            <!--end::Items-->
                                                        </div>
                                                        <!--end::Col-->
                                                        <!--begin::Col-->
                                                        <div class="col-6">
                                                            <!--begin::Items-->
                                                            <div class="bg-gray-100 bg-opacity-70 rounded-2 px-3 py-3 text-center">
                                                                <span class="text-dark fw-semibold fs-base">National Fuel Surcharge</span>
                                                                <!--begin::Stats-->
                                                                <div class="row m-0">
                                                                    <div class="d-flex flex-center">
                                                                        <!--begin::Number-->
                                                                        <span class="text-gray-700 fw-bolder fs-2qx lh-1 ls-n1 mb-1">$<?php echo $sr->fuel_surcharge; ?></span>
                                                                        <span class="text-dark fs-7">&nbsp;&nbsp;($<?php echo ($sr->fuel_surcharge_diff / 100); ?>)</span>
                                                                        <!--end::Number-->
                                                                    </div>
                                                                    <div class="d-flex flex-center">
                                                                        <!--begin::Desc-->
                                                                        <?php
                                                                        //segun el % dibuja en verde, amarillo o rojo
                                                                        if ($sr->fuel_surcharge_perc < "0") { //red
                                                                            $svg_icon = "danger";
                                                                            $svg_file = "arr065";
                                                                        } else if ($sr->fuel_surcharge_perc > "0") { //green
                                                                            $svg_icon = "success";
                                                                            $svg_file = "arr066";
                                                                        } else { // yellow
                                                                            $svg_icon = "warning";
                                                                            $svg_file = "arr090";
                                                                        }
                                                                        ?>
                                                                        <!--begin::Label-->
                                                                        <span class="badge badge-light-<?php echo $svg_icon; ?> fs-6">
                                                                            <!--begin::Svg Icon | path: icons/duotune/arrows/<?php echo $svg_file; ?>.svg-->
                                                                            <?php
                                                                            echo getSvgIcon('assets/media/icons/duotune/arrows/' . $svg_file . '.svg', 'svg-icon-2 svg-icon-' . $svg_icon . ' ms-n1');
                                                                            ?>
                                                                            <?php echo round($sr->fuel_surcharge_perc, 2); ?>
                                                                            %
                                                                        </span>
                                                                        <!--end::Label-->
                                                                        <!--end::Desc-->
                                                                    </div>
                                                                </div>
                                                                <!--end::Stats-->
                                                            </div>
                                                            <!--end::Items-->
                                                        </div>
                                                        <!--end::Col-->
                                                        <!--begin::Col-->
                                                        <div class="col-6">
                                                            <!--begin::Items-->
                                                            <div class="bg-gray-100 bg-opacity-70 rounded-2 px-3 py-3 text-center">
                                                                <span class="text-dark fw-semibold fs-base">National Diesel Fuel Avg</span>
                                                                <!--begin::Stats-->
                                                                <div class="row m-0">
                                                                    <div class="d-flex flex-center">
                                                                        <!--begin::Number-->
                                                                        <span class="text-gray-700 fw-bolder fs-2qx lh-1 ls-n1 mb-1">$<?php echo $sr->diesel_fuel_avg; ?></span>
                                                                        <span class="text-dark fs-7">&nbsp;&nbsp;($<?php echo ($sr->diesel_fuel_diff / 100); ?>)</span>
                                                                        <!--end::Number-->
                                                                    </div>
                                                                    <div class="d-flex flex-center">
                                                                        <!--begin::Desc-->
                                                                        <?php
                                                                        //segun el % dibuja en verde, amarillo o rojo
                                                                        if ($sr->diesel_fuel_avg_perc < "0") { //red
                                                                            $svg_icon = "danger";
                                                                            $svg_file = "arr065";
                                                                            $svg_text = round($sr->diesel_fuel_avg_perc, 2) . '%';
                                                                        } else if ($sr->diesel_fuel_avg_perc > "0") { //green
                                                                            $svg_icon = "success";
                                                                            $svg_file = "arr066";
                                                                            $svg_text = round($sr->diesel_fuel_avg_perc, 2) . '%';
                                                                        } else { // yellow
                                                                            $svg_icon = "warning";
                                                                            $svg_file = "arr090";
                                                                            $svg_text = '<span class="text-gray-500 fw-semibold">' . $sr->diesel_fuel_avg_perc . ' %</span>';
                                                                        }
                                                                        ?>
                                                                        <!--begin::Label-->
                                                                        <span class="badge badge-light-<?php echo $svg_icon; ?> fs-6">
                                                                            <!--begin::Svg Icon | path: icons/duotune/arrows/<?php echo $svg_file; ?>.svg-->
                                                                            <?php
                                                                            echo getSvgIcon('assets/media/icons/duotune/arrows/' . $svg_file . '.svg', 'svg-icon-2 svg-icon-' . $svg_icon . ' ms-n1');
                                                                            ?>
                                                                            <?php echo round($sr->diesel_fuel_avg_perc, 2); ?>
                                                                            %
                                                                        </span>
                                                                        <!--end::Label-->
                                                                        <!--end::Desc-->
                                                                    </div>
                                                                </div>
                                                                <!--end::Stats-->
                                                            </div>
                                                            <!--end::Items-->
                                                        </div>
                                                        <!--end::Col-->
                                                    </div>
                                                    <!--end::Row-->
                                                    <!--end::Title-->
                                                </div>
                                                <!--end::Body-->

                                                <?php /* ?>
                                                <!--begin::Body-->
                                                <div class="card-body mt-n10">
                                                    <!--begin::Stats-->
                                                    <div class="mt-n10 position-relative">
                                                        <!--begin::Row-->
                                                        <div class="row g-3 g-lg-6">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Items-->
                                                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                                                    National Spot Market Rates
                                                                    <!--begin::Stats-->
                                                                    <div class="row m-0">
                                                                        <div class="col-6">
                                                                            <!--begin::Number-->
                                                                            <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">15</span>
                                                                            <!--end::Number-->
                                                                            <!--begin::Desc-->
                                                                            <span class="text-gray-500 fw-semibold fs-6">12%</span>
                                                                            <!--end::Desc-->
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <i class="bi bi-arrow-up text-success fs-5x"></i>
                                                                        </div>
                                                                    </div>
                                                                    <!--end::Stats-->
                                                                </div>
                                                                <!--end::Items-->
                                                            </div>
                                                            <!--end::Col-->
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Items-->
                                                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                                                    National Contract Rates
                                                                    <!--begin::Stats-->
                                                                    <div class="row m-0">
                                                                        <div class="col-6">
                                                                            <!--begin::Number-->
                                                                            <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">22</span>
                                                                            <!--end::Number-->
                                                                            <!--begin::Desc-->
                                                                            <span class="text-gray-500 fw-semibold fs-6">7%</span>
                                                                            <!--end::Desc-->
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <i class="bi bi-arrow-down text-danger fs-5x"></i>
                                                                        </div>
                                                                    </div>
                                                                    <!--end::Stats-->
                                                                </div>
                                                                <!--end::Items-->
                                                            </div>
                                                            <!--end::Col-->
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Items-->
                                                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                                                    National Fuel Surcharges
                                                                    <!--begin::Stats-->
                                                                    <div class="row m-0">
                                                                        <div class="col-6">
                                                                            <!--begin::Number-->
                                                                            <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">37</span>
                                                                            <!--end::Number-->
                                                                            <!--begin::Desc-->
                                                                            <span class="text-gray-500 fw-semibold fs-6">10%</span>
                                                                            <!--end::Desc-->
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <i class="bi bi-arrow-down text-danger fs-5x"></i>
                                                                        </div>
                                                                    </div>
                                                                    <!--end::Stats-->
                                                                </div>
                                                                <!--end::Items-->
                                                            </div>
                                                            <!--end::Col-->
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Items-->
                                                                <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                                                    National Diesel Fuel Avg
                                                                    <!--begin::Stats-->
                                                                    <div class="row m-0">
                                                                        <div class="col-6">
                                                                            <!--begin::Number-->
                                                                            <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">30</span>
                                                                            <!--end::Number-->
                                                                            <!--begin::Desc-->
                                                                            <span class="text-gray-500 fw-semibold fs-6">no change</span>
                                                                            <!--end::Desc-->
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <i class="bi bi-dash text-primary fs-5x"></i>
                                                                        </div>
                                                                    </div>
                                                                    <!--end::Stats-->
                                                                </div>
                                                                <!--end::Items-->
                                                            </div>
                                                            <!--end::Col-->
                                                        </div>
                                                        <!--end::Row-->
                                                    </div>
                                                    <!--end::Stats-->
                                                </div>
                                                <!--end::Body-->
                                                <?php */ ?>

                                            </div>
                                        </div>
                                        <!--end::Lists Widget 19-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <?php include("time_line_section.php"); ?>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->

                                <div class=" row g-5 g-xl-10">
                                    <!--begin::Col hot lanes-->
                                    <div class="col-xl-6 mb-xl-10">
                                        <!--begin::List widget 8-->
                                        <div class="hot-lanes h-100">
                                            <div class="card card-flush h-lg-100">
                                                <!--begin::Header-->
                                                <div class="card-header pt-7 justify-content-between">
                                                    <!--begin::Title-->
                                                    <h3 class="card-title align-items-start flex-column">
                                                        <span class="card-label fw-bold text-gray-800">HIGH REVENUE LANES</span>
                                                        <span class="text-gray-400 mt-1 fw-semibold fs-6">Top lanes this week</span>
                                                    </h3>
                                                    <!--end::Title-->
                                                    <i class="bi bi-question-circle" style="cursor:pointer" data-bs-toggle="popover" data-bs-placement="top" title="HIGH REVENUE LANES" data-bs-content="High Revenue Lanes is designed to help shippers, brokers and carriers identify the most profitable and in-demand shipping routes. This section utilizes data analysis tools and industry expertise to determine which lanes are generating the highest revenue and provide real-time quotes for those lanes. By using this feature, subscribers can make more informed decisions about which routes to take, which carriers to work with, and how to optimize their shipping operations for maximum profitability. The high revenue lanes section is a valuable resource for anyone looking to succeed in the spot market."></i>
                                                </div>
                                                <!--end::Header-->

                                                <div class="card-header mb-2 ">
                                                    <!--begin::Toolbar-->
                                                    <div class="card-toolbardd">
                                                        <select class="form-select form-select-sm text-muted w-auto" id="equipment_hot" data-dropdown-css-class="w-150px" data-control="select2" data-hide-search="true">
                                                            <option value="reefer" selected>Reefer</option>
                                                            <option value="van">Van</option>
                                                            <option value="flat">Flatbed</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Toolbar-->
                                                </div>


                                                <!--begin::Body-->
                                                <div class="card-body pt-0">

                                                    <!--begin::Table Hot Lanes-->
                                                    <div class="table-responsive">
                                                        <table class="table table-row-dashed table-row-gray-300 small w-100 gx-5" id="reefer_hot_lanes">
                                                            <thead>
                                                                <tr class="fw-bold small text-gray-800 bg-light">
                                                                    <th width="40%">Lane</th>
                                                                    <th width="20%">Direct Rate</th>
                                                                    <th width="20%">Broker Rate</th>
                                                                    <th width="20%" class="text-center">24hr</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                foreach ($reefer_hot_lanes as $c => $v) {
                                                                ?>
                                                                    <tr>
                                                                        <td>
                                                                            <a href="rate_engine.php?sec=<?php echo $v->lane_id; ?>&eq=1" class="text-primary fw-bold"><?php echo $v->fantasy_name; ?></a>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo $v->driving_distance; ?> Mi</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-gray-800 fw-bold me-3 d-block"><?php echo $v->carrier; ?></span>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo $v->rpm_carrier; ?> RPM</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-gray-800 fw-bold me-3 d-block"><?php echo $v->shipper; ?></span>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo $v->rpm_shipper; ?> RPM</span>
                                                                        </td>

                                                                        <td>
                                                                            <!--begin::Label-->
                                                                            <span class="badge badge-light-success fs-base">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg flechaarribaverde-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/arr066.svg', 'svg-icon- svg-icon-success ms-');
                                                                                ?>
                                                                                <?php echo $v->magnitude; ?> %
                                                                            </span>
                                                                            <!--end::Label-->
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                        <!-- flat hot lanes -->
                                                        <table class="table table-row-dashed table-row-gray-300 small w-100" id="flat_hot_lanes" style="display:none">
                                                            <thead>
                                                                <tr class="fw-bold small text-gray-800 bg-light">
                                                                    <th width="40%">Lane</th>
                                                                    <th width="20%">Direct Rate</th>
                                                                    <th width="20%">Broker Rate</th>
                                                                    <th width="20%" class="text-center">24hr</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                foreach ($flat_hot_lanes as $c => $v) { ?>
                                                                    <tr>
                                                                        <td>
                                                                            <a href="rate_engine.php?sec=<?php echo $v->lane_id; ?>&eq=3" class="text-primary fw-bold"><?php echo $v->fantasy_name; ?></a>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo $v->driving_distance; ?> Mi</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-gray-800 fw-bold me-3 d-block"><?php echo $v->carrier; ?></span>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo $v->rpm_carrier; ?> RPM</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-gray-800 fw-bold me-3 d-block"><?php echo $v->shipper; ?></span>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo $v->rpm_shipper; ?> RPM</span>
                                                                        </td>

                                                                        <td>
                                                                            <!--begin::Label-->
                                                                            <span class="badge badge-light-success fs-base">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg flechaarribaverde-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/arr066.svg', 'svg-icon- svg-icon-success ms-');
                                                                                ?>
                                                                                <?php echo $v->magnitude; ?> %
                                                                            </span>
                                                                            <!--end::Label-->
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                        <!-- flat hot lanes -->
                                                        <!-- van hot lanes -->
                                                        <table class="table table-row-dashed table-row-gray-300 small w-100" id="van_hot_lanes" style="display:none">
                                                            <thead>
                                                                <tr class="fw-bold small text-gray-800 bg-light">
                                                                    <th width="40%">Lane</th>
                                                                    <th width="20%">Direct Rate</th>
                                                                    <th width="20%">Broker Rate</th>
                                                                    <th width="20%" class="text-center">24hr</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                foreach ($van_hot_lanes as $c => $v) { ?>
                                                                    <tr>
                                                                        <td>
                                                                            <a href="rate_engine.php?sec=<?php echo $v->lane_id; ?>&eq=2" class="text-primary fw-bold"><?php echo $v->fantasy_name; ?></a>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo $v->driving_distance; ?> Mi</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-gray-800 fw-bold me-3 d-block"><?php echo $v->shipper; ?></span>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo $v->rpm_shipper; ?> RPM</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-gray-800 fw-bold me-3 d-block"><?php echo $v->carrier; ?></span>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo $v->rpm_carrier; ?> RPM</span>
                                                                        </td>
                                                                        <td>
                                                                            <!--begin::Label-->
                                                                            <span class="badge badge-light-success fs-base">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg flechaarribaverde-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/arr066.svg', 'svg-icon- svg-icon-success ms-');
                                                                                ?>
                                                                                <?php echo $v->magnitude; ?> %
                                                                            </span>
                                                                            <!--end::Label-->
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>

                                                                <!-- van hot lanes -->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!--end::Table Hot Lanes-->
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                        </div>
                                        <!--end::LIst widget 8-->
                                    </div>
                                    <!--end::Col-->


                                    <!--begin::Col cold lanes-->
                                    <div class="col-xl-6 mb-xl-10">
                                        <!--begin::List widget 8-->
                                        <div class="cold-lanes h-100">
                                            <div class="card card-flush h-lg-100">
                                                <!--begin::Header-->
                                                <div class="card-header pt-7 justify-content-between">
                                                    <!--begin::Title-->
                                                    <h3 class="card-title align-items-start flex-column">
                                                        <span class="card-label fw-bold text-gray-800">LOW REVENUE LANES</span>
                                                        <span class="text-gray-400 mt-1 fw-semibold fs-6">Low paying lanes this week</span>
                                                    </h3>
                                                    <!--end::Title-->
                                                    <i class="bi bi-question-circle" style="cursor:pointer" data-bs-toggle="popover" data-bs-placement="top" title="LOW REVENUE LANES" data-bs-content="The low revenue lanes  help shippers, brokers and carriers identify routes that are currently less profitable or experiencing a downturn in demand. This section utilizes data analysis tools and industry expertise to determine which lanes are generating lower revenue and provide real-time quotes for those lanes. By using this feature, subscribers can adjust their strategies accordingly, potentially exploring alternative routes or carriers that offer better rates. Overall, the low revenue lanes section is a valuable resource for anyone looking to stay informed about market trends and make data-driven decisions.  "></i>
                                                </div>

                                                <div class="card-header mb-2 ">
                                                    <!--begin::Toolbar-->
                                                    <div class="card-toolbardd">
                                                        <select class="form-select form-select-sm text-muted" id="equipment_low" data-dropdown-css-class="w-150px" data-control="select2" data-hide-search="true">
                                                            <option value="reefer" selected>Reefer</option>
                                                            <option value="van">Van</option>
                                                            <option value="flat">Flatbed</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Toolbar-->
                                                </div>

                                                <!--end::Header-->
                                                <!--begin::Body-->
                                                <div class="card-body pt-0">

                                                    <!--begin::Table Cold Lanes-->
                                                    <div class="table-responsive">
                                                        <table class="table table-row-dashed table-row-gray-300 small w-100" id="reefer_cold_lanes">
                                                            <thead>
                                                                <tr class="fw-bold small text-gray-800 bg-light">
                                                                    <th width="40%">Lane</th>
                                                                    <th width="20%">Direct Rate</th>
                                                                    <th width="20%">Broker Rate</th>
                                                                    <th width="20%" class="text-center">24hr</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                foreach ($reefer_cold_lanes as $c => $v) {
                                                                ?>
                                                                    <tr>
                                                                        <td>
                                                                            <a href="rate_engine.php?sec=<?php echo $v->lane_id; ?>&eq=1" class="text-primary fw-bold"><?php echo $v->fantasy_name; ?></a>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo $v->driving_distance; ?> Mi</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-gray-800 fw-bold me-3 d-block"><?php echo $v->shipper; ?></span>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo $v->rpm_shipper; ?> RPM</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-gray-800 fw-bold me-3 d-block"><?php echo $v->carrier; ?></span>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo $v->rpm_carrier; ?> RPM</span>
                                                                        </td>
                                                                        <td>
                                                                            <!--begin::Label-->
                                                                            <span class="badge badge-light-danger fs-base">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg flechaarribaverde-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/arr065.svg', 'svg-icon- svg-icon-danger ms-');
                                                                                ?>
                                                                                <?php echo $v->magnitude; ?> %
                                                                            </span>
                                                                            <!--end::Label-->
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                        <!-- flat hot lanes -->
                                                        <table class="table table-row-dashed table-row-gray-300 small w-100" id="flat_cold_lanes" style="display:none">
                                                            <thead>
                                                                <tr class="fw-bold small text-gray-800 bg-light">
                                                                    <th width="40%">Lane</th>
                                                                    <th width="20%">Direct Rate</th>
                                                                    <th width="20%">Broker Rate</th>
                                                                    <th width="20%" class="text-center">24hr</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                foreach ($flat_cold_lanes as $c => $v) { ?>
                                                                    <tr>
                                                                        <td>
                                                                            <a href="rate_engine.php?sec=<?php echo $v->lane_id; ?>&eq=3" class="text-primary fw-bold"><?php echo $v->fantasy_name; ?></a>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo $v->driving_distance; ?> Mi</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-gray-800 fw-bold me-3 d-block"><?php echo $v->shipper; ?></span>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo $v->rpm_shipper; ?> RPM</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-gray-800 fw-bold me-3 d-block"><?php echo $v->carrier; ?></span>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo $v->rpm_carrier; ?> RPM</span>
                                                                        </td>
                                                                        <td>
                                                                            <!--begin::Label-->
                                                                            <span class="badge badge-light-danger fs-base">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg flechaarribaverde-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/arr065.svg', 'svg-icon- svg-icon-danger ms-');
                                                                                ?>
                                                                                <?php echo $v->magnitude; ?> %
                                                                            </span>
                                                                            <!--end::Label-->
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                        <!-- flat hot lanes -->
                                                        <!-- van hot lanes -->
                                                        <table class="table table-row-dashed table-row-gray-300 small w-100" id="van_cold_lanes" style="display:none">
                                                            <thead>
                                                                <tr class="fw-bold small text-gray-800 bg-light">
                                                                    <th width="40%">Lane</th>
                                                                    <th width="20%">Direct Rate</th>
                                                                    <th width="20%">Broker Rate</th>
                                                                    <th width="20%" class="text-center">24hr</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                foreach ($van_cold_lanes as $c => $v) { ?>
                                                                    <tr>
                                                                        <td>
                                                                            <a href="rate_engine.php?sec=<?php echo $v->lane_id; ?>&eq=2" class="text-primary fw-bold"><?php echo $v->fantasy_name; ?></a>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo $v->driving_distance; ?> Mi</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-gray-800 fw-bold me-3 d-block"><?php echo $v->shipper; ?></span>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo $v->rpm_shipper; ?> RPM</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-gray-800 fw-bold me-3 d-block"><?php echo $v->carrier; ?></span>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo $v->rpm_carrier; ?> RPM</span>
                                                                        </td>
                                                                        <td>
                                                                            <!--begin::Label-->
                                                                            <span class="badge badge-light-danger fs-base">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg flechaarribaverde-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/arr065.svg', 'svg-icon- svg-icon-danger ms-');
                                                                                ?>
                                                                                <?php echo $v->magnitude; ?> %
                                                                            </span>
                                                                            <!--end::Label-->
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>

                                                                <!-- van hot lanes -->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!--end::Table Cold Lanes-->
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                        </div>
                                        <!--end::LIst widget 8-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->


                                <!--begin::Row-->
                                <div class="row g-5 g-xl-10">
                                    <!--begin::Col price change alert -->
                                    <div class="col-xl-6 mb-xl-10">
                                        <!--begin::List widget 25-->
                                        <div class="price-change">
                                            <div class="card card-flush h-lg-100">
                                                <!--begin::Header-->
                                                <div class="card-header pt-7 justify-content-between">
                                                    <!--begin::Title-->
                                                    <h3 class="card-title align-items-start flex-column">
                                                        <span class="card-label fw-bold text-gray-800">PRICE CHANGE ALERTS</span>
                                                        <span class="text-gray-400 mt-1 fw-semibold fs-6">Recently detected price fluctuations</span>
                                                    </h3>
                                                    <!--end::Title-->
                                                    <i class="bi bi-question-circle" style="cursor:pointer" data-bs-toggle="popover" data-bs-placement="top" title="PRICE CHANGE ALERTS" data-bs-content="The Rate Change Alerts  help shippers, brokers and carriers stay up-to-date with changes in pricing for different lanes. This section utilizes data analysis tools to track changes in rates over time and provides real-time updates on any price fluctuations. By using this feature, subscribers can make informed decisions about when to book shipments and which carriers to work with based on current market conditions. Additionally, this feature can help identify emerging trends in the market and potentially forecast future rate changes. "></i>
                                                </div>
                                                <!--end::Header-->
                                                <!--begin::Header-->
                                                <div class="card-header mb-2">
                                                    <!--begin::Toolbar-->
                                                    <div class="card-toolbar">
                                                        <select class="form-select form-select-sm text-muted" id="price_change_alert_selector" data-dropdown-css-class="w-150px" data-control="select2" data-hide-search="true">
                                                            <option value="reefer" selected>Reefer</option>
                                                            <option value="van">Van</option>
                                                            <option value="flat">Flatbed</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Toolbar-->
                                                </div>
                                                <!--end::Header-->

                                                <!--begin::Body-->
                                                <div class="card-body pt-5">

                                                    <!--begin::Table Price Change Alerts-->
                                                    <div class="">
                                                        <div class="table-responsive">
                                                            <table class="table table-row-dashed table-row-gray-300 small">
                                                                <thead>
                                                                    <tr class="fw-bold small text-gray-800 bg-light">
                                                                        <th class="h-auto">Lane</th>
                                                                        <th>Direct Rate</th>
                                                                        <th>Broker Rate</th>
                                                                        <th class="text-center">24hr</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    <?php
                                                                    for ($tipo = 1; $tipo < 4; $tipo++) {
                                                                        if ($tipo === 1) {
                                                                            $equipo = "reefer";
                                                                        }
                                                                        if ($tipo === 2) {
                                                                            $equipo = "van";
                                                                        }
                                                                        if ($tipo === 3) {
                                                                            $equipo = "flat";
                                                                        }

                                                                        $porc_arriba = array();
                                                                        for ($i = 1; $i < 6; $i++) {
                                                                            $porc_arriba[$i] = rand(1, 100);
                                                                        }
                                                                        arsort($porc_arriba);
                                                                        $porc_arriba = array_values($porc_arriba);

                                                                        for ($i = 1; $i <= 5; $i++) {
                                                                            $sql = "SELECT * FROM lanes ORDER BY RAND() LIMIT 1";
                                                                            $la = $quote->getThis1($sql);
                                                                            $precio = rand(1, 10000);
                                                                            $brokerp = ($precio + ($precio * (8 / 100)));
                                                                    ?>
                                                                            <tr class="<?php echo $equipo; ?>">
                                                                                <td>
                                                                                    <a href="mmi.php" class="text-primary fw-bold"><?php echo $la->fantasy_name; ?></a>
                                                                                </td>
                                                                                <td>
                                                                                    <span class="text-gray-800 fw-bold me-3 d-block">$<?php echo number_format($precio); ?></span>
                                                                                </td>
                                                                                <td><span class="text-gray-800 fw-bold me-3 d-block">$<?php echo number_format($brokerp); ?></span></td>
                                                                                <td>
                                                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg flechaarribaverde-->
                                                                                    <?php
                                                                                    echo getSvgIcon('assets/media/icons/duotune/arrows/arr066.svg', 'svg-icon-2 svg-icon-success me-2');
                                                                                    ?>
                                                                                    <span class="text-gray-400 fw-bold">&nbsp;&nbsp;<?php echo $porc_arriba[$i - 1]; ?> %</span>
                                                                                </td>
                                                                            </tr>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        $porc_abajo = array();
                                                                        for ($i = 1; $i < 6; $i++) {
                                                                            $porc_abajo[$i] = rand(1, 100);
                                                                        }
                                                                        asort($porc_abajo);
                                                                        $porc_abajo = array_values($porc_abajo);

                                                                        for ($i = 1; $i <= 5; $i++) {
                                                                            $sql = "SELECT * FROM lanes ORDER BY RAND() LIMIT 1";
                                                                            $la = $quote->getThis1($sql);

                                                                            $precio = rand(1, 10000);
                                                                            $brokerp = ($precio + ($precio * (8 / 100)));
                                                                        ?>
                                                                            <tr class="<?php echo $equipo; ?>">
                                                                                <td>
                                                                                    <a href="mmi.php" class="text-primary fw-bold"><?php echo $la->fantasy_name; ?></a>
                                                                                </td>
                                                                                <td>
                                                                                    <span class="text-gray-800 fw-bold me-3 d-block">$<?php echo number_format($precio); ?></span>
                                                                                </td>
                                                                                <td><span class="text-gray-800 fw-bold me-3 d-block">$<?php echo number_format($brokerp); ?></span></td>
                                                                                <td>
                                                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr065.svg flechaabajoroja-->
                                                                                    <?php
                                                                                    echo getSvgIcon('assets/media/icons/duotune/arrows/arr065.svg', 'svg-icon-2 svg-icon-danger me-2');
                                                                                    ?>
                                                                                    <span class="text-gray-400 fw-bold">&nbsp;&nbsp;<?php echo $porc_abajo[$i - 1]; ?> %</span>
                                                                                </td>
                                                                            </tr>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <!--end::Table Price Change Alerts-->


                                                    <?php /*

                                                    $porc_arriba = array();
                                                    for ($i = 1; $i < 6; $i++) {
                                                        $porc_arriba[$i] = rand(1, 100);
                                                    }
                                                    arsort($porc_arriba);
                                                    $porc_arriba = array_values($porc_arriba);


                                                    for ($i = 1; $i <= 5; $i++) {


                                                        $sql = "SELECT * FROM lanes ORDER BY RAND() LIMIT 1";
                                                        $la = $quote->getThis1($sql);

                                                        $precio = number_format(rand(1, 10000));

                                                    ?>
                                                        <!--begin::Item-->
                                                        <div class="d-flex flex-stack">
                                                            <!--begin::Section-->
                                                            <div class="text-gray-700 fw-semibold fs-6 me-2"><?php echo $la->fantasy_name; ?></div>
                                                            <!--end::Section-->
                                                            <!--begin::Statistics-->
                                                            <div class="d-flex align-items-senter">
                                                                <!--begin::Svg esta es flecha arriba verde-->
                                                                <?php
                                                                    echo getSvgIcon('assets/media/icons/duotune/arrows/arr066.svg', 'svg-icon-2 svg-icon-success me-2');
                                                                ?>
                                                                <!--span class="svg-icon svg-icon-2 svg-icon-success me-2">
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <rect opacity="0.5" x="16.9497" y="8.46448" width="13" height="2" rx="1" transform="rotate(135 16.9497 8.46448)" fill="currentColor" />
                                                                        <path d="M14.8284 9.97157L14.8284 15.8891C14.8284 16.4749 15.3033 16.9497 15.8891 16.9497C16.4749 16.9497 16.9497 16.4749 16.9497 15.8891L16.9497 8.05025C16.9497 7.49797 16.502 7.05025 15.9497 7.05025L8.11091 7.05025C7.52512 7.05025 7.05025 7.52513 7.05025 8.11091C7.05025 8.6967 7.52512 9.17157 8.11091 9.17157L14.0284 9.17157C14.4703 9.17157 14.8284 9.52975 14.8284 9.97157Z" fill="currentColor" />
                                                                    </svg>
                                                                </span-->
                                                                <!--end::Svg Icon-->
                                                                <!--begin::Number-->
                                                                <span class="text-gray-900 fw-bolder fs-6">$ <?php echo $precio; ?> </span>
                                                                <!--end::Number-->
                                                                <span class="text-gray-400 fw-bold fs-6">&nbsp;&nbsp;<?php echo $porc_arriba[$i - 1]; ?> %</span>
                                                            </div>
                                                            <!--end::Statistics-->
                                                        </div>
                                                        <!--end::Item-->
                                                        <!--begin::Separator-->
                                                        <div class="separator separator-dashed my-3"></div>
                                                        <!--end::Separator-->
                                                    <?php
                                                    }
                                                    ?>


                                                    <?php


                                                    $porc_abajo = array();
                                                    for ($i = 1; $i < 6; $i++) {
                                                        $porc_abajo[$i] = rand(1, 100);
                                                    }
                                                    asort($porc_abajo);
                                                    $porc_abajo = array_values($porc_abajo);


                                                    for ($i = 1; $i <= 5; $i++) {

                                                        $sql = "SELECT * FROM lanes ORDER BY RAND() LIMIT 1";
                                                        $la = $quote->getThis1($sql);

                                                        $precio = number_format(rand(1, 10000));

                                                    ?>

                                                        <!--begin::Item-->
                                                        <div class="d-flex flex-stack">
                                                            <!--begin::Section-->
                                                            <div class="text-gray-700 fw-semibold fs-6 me-2"><?php echo $la->fantasy_name; ?></div>
                                                            <!--end::Section-->
                                                            <!--begin::Statistics-->
                                                            <div class="d-flex align-items-senter">
                                                                <!--begin::Svg Icon | flecha abajo roja-->                                                            
                                                                <?php
                                                                    echo getSvgIcon('assets/media/icons/duotune/arrows/arr065.svg', 'svg-icon-2 svg-icon-danger me-2');
                                                                ?>
                                                                <!--span class="svg-icon svg-icon-2 svg-icon-danger me-2">
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <rect opacity="0.5" x="7.05026" y="15.5355" width="13" height="2" rx="1" transform="rotate(-45 7.05026 15.5355)" fill="currentColor" />
                                                                        <path d="M9.17158 14.0284L9.17158 8.11091C9.17158 7.52513 8.6967 7.05025 8.11092 7.05025C7.52513 7.05025 7.05026 7.52512 7.05026 8.11091L7.05026 15.9497C7.05026 16.502 7.49797 16.9497 8.05026 16.9497L15.8891 16.9497C16.4749 16.9497 16.9498 16.4749 16.9498 15.8891C16.9498 15.3033 16.4749 14.8284 15.8891 14.8284L9.97158 14.8284C9.52975 14.8284 9.17158 14.4703 9.17158 14.0284Z" fill="currentColor" />
                                                                    </svg>
                                                                </span-->
                                                                <!--end::Svg Icon-->
                                                                <!--begin::Number-->
                                                                <span class="text-gray-900 fw-bolder fs-6">$ <?php echo $precio; ?> </span>
                                                                <!--end::Number-->
                                                                <span class="text-gray-400 fw-bold fs-6">&nbsp;&nbsp;<?php echo $porc_abajo[$i - 1]; ?> %</span>
                                                            </div>
                                                            <!--end::Statistics-->
                                                        </div>
                                                        <!--end::Item-->
                                                        <!--begin::Separator-->
                                                        <div class="separator separator-dashed my-3"></div>
                                                        <!--end::Separator-->

                                                    <?php
                                                    } */
                                                    ?>



                                                </div>
                                                <!--end::Body-->
                                            </div>
                                        </div>
                                        <!--end::LIst widget 25-->
                                    </div>
                                    <!--end::Col price change alert -->


                                    <!--begin::Col-->
                                    <div class="col-xl-6 mb-xl-10">
                                        <!--begin::Engage widget 1-->
                                        <div class="new-features h-100">
                                            <div class="card h-100">
                                                <!--begin::Body-->
                                                <div class="card-body d-flex flex-column flex-center h-100" id="flier_div">
                                                    <!--img src="imgs/flier.jpg" style="width:100%; height:100%"-->
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                        </div>
                                        <!--end::Engage widget 1-->
                                    </div>
                                    <!--end::Col-->

                                    <div class="modal fade" tabindex="-1" id="modal_flyer">
                                        <div class="modal-dialog modal-xl">">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <img class="img-responsive" src="imgs/flier.jpg">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Row-->



                                <!--begin::Row-->
                                <div class="row g-5 g-xl-10">
                                    <!--begin::Col-->
                                    <div class="col-xl-12 mb-xl-10">
                                        <!--begin::Tables widget 14-->
                                        <div class="load-counts">
                                            <div class="card card-flush h-md-100 bg-light border border-secondary">
                                                <!--begin::Header-->
                                                <div class="card-header pt-7 justify-content-between">
                                                    <!--begin::Title-->
                                                    <h3 class="card-title align-items-start flex-column">
                                                        <span class="card-label fw-bold text-gray-800">LOAD COUNTS</span>
                                                        <span class="text-gray-400 mt-1 fw-semibold fs-6">Daily freight shipments</span>
                                                    </h3>
                                                    <!--end::Title-->
                                                    <!--begin::Toolbar-->
                                                    <i class="bi bi-question-circle" style="cursor:pointer" data-bs-toggle="popover" data-bs-placement="top" title="LOAD COUNTS" data-bs-content="This section provides real-time information on loads that are currently available for shipment which dictates the spot market rates via capacity.  By using this feature, subscribers can get a real feel for the days market conditions. This section is updated in real-time to ensure that the information provided is accurate and up-to-date.  "></i>
                                                    <!--end::Toolbar-->
                                                </div>
                                                <!--end::Header-->
                                                <!--begin::Body-->
                                                <div class="card-body pt-6">
                                                    <!--begin::Table container-->
                                                    <div class="table-responsive">
                                                        <!--begin::Table-->
                                                        <table class="table table-row-dashed align-middle gs-2 gy-3 gx-3 my-0 w-100">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <tr class="fs-7 fw-bold text-gray-400 border-bottom-0 pb-3">
                                                                    <th>ITEM</th>
                                                                    <th>AVAILABLE LOADS</th>
                                                                    <th>24hr CHANGE</th>
                                                                    <th># LOADS PICKING</th>
                                                                    <th>24hr CHANGE</th>
                                                                    <th># LOADS DROPPING</th>
                                                                    <th>24hr CHANGE</th>
                                                                </tr>
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            <?php
                                                            $svg_danger = '<span class="svg-icon svg-icon-5 svg-icon-danger ms-n1">
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
                                                                    <path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="currentColor" />
                                                                    </svg></span>';

                                                            $svg_success = '<span class="svg-icon svg-icon-5 svg-icon-success ms-n1">
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
                                                                    <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
                                                                    </svg></span>';

                                                            $svg_neutro = '<span class="svg-icon svg-icon-5 svg-icon-warning ms-n1"></span>';
                                                            ?>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <span class="text-gray-800 fw-bold mb-1 fs-6">Van</span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-gray-600 fw-bold fs-6"><?php echo $ta->van_loads_0; ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if (floatval($ta->percentage_van) < 0) {
                                                                            $svg_line = '<span class="badge badge-light-danger fs-base">' . $svg_danger . round($ta->percentage_van, 2) . '%</span>';
                                                                        } else if (floatval($ta->percentage_van) > 0) {
                                                                            $svg_line = '<span class="badge badge-light-success fs-base">' . $svg_success . round($ta->percentage_van, 2) . '%</span>';
                                                                        } else {
                                                                            $svg_line = '<span class="badge badge-light-warning fs-base">' . $svg_neutro . round($ta->percentage_van, 2) . '%</span>';
                                                                        }
                                                                        ?>
                                                                        <?php echo $svg_line; ?>
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-gray-600 fw-bold fs-6"><?php echo $ta->van_loads_picking_0; ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if (floatval($ta->percentage_van_picking) < 0) {
                                                                            $svg_percentage_van_picking = '<span class="badge badge-light-danger fs-base">' . $svg_danger . round($ta->percentage_van_picking, 2) . '%</span>';
                                                                        } else if (floatval($ta->percentage_van_picking) > 0) {
                                                                            $svg_percentage_van_picking = '<span class="badge badge-light-success fs-base">' . $svg_success . round($ta->percentage_van_picking, 2) . '%</span>';
                                                                        } else {
                                                                            $svg_percentage_van_picking = '<span class="badge badge-light-warning fs-base">' . $svg_neutro . round($ta->percentage_van_picking, 2) . '%</span>';
                                                                        }
                                                                        ?>
                                                                        <?php echo $svg_percentage_van_picking; ?>
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-gray-600 fw-bold fs-6"><?php echo $ta->van_loads_dropping_0; ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if (floatval($ta->percentage_van_dropping) < 0) {
                                                                            $svg_van_loads_dropping = '<span class="badge badge-light-danger fs-base">' . $svg_danger . round($ta->percentage_van_dropping, 2) . '%</span>';
                                                                        } else if (floatval($ta->percentage_van_dropping) > 0) {
                                                                            $svg_van_loads_dropping = '<span class="badge badge-light-success fs-base">' . $svg_success . round($ta->percentage_van_dropping, 2) . '%</span>';
                                                                        } else {
                                                                            $svg_van_loads_dropping = '<span class="badge badge-light-warning fs-base">' . $svg_neutro . round($ta->percentage_van_dropping, 2) . '%</span>';
                                                                        }
                                                                        ?>
                                                                        <?php echo $svg_van_loads_dropping; ?>
                                                                    </td>

                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                        <span class="text-gray-800 fw-bold mb-1 fs-6">Reefer</span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-gray-600 fw-bold fs-6"><?php echo $ta->reefer_loads_0; ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if (floatval($ta->percentage_reefer) < 0) {
                                                                            $svg_line = '<span class="badge badge-light-danger fs-base">' . $svg_danger . round($ta->percentage_reefer, 2) . '%</span>';
                                                                        } else if (floatval($ta->percentage_reefer) > 0) {
                                                                            $svg_line = '<span class="badge badge-light-success fs-base">' . $svg_success . round($ta->percentage_reefer, 2) . '%</span>';
                                                                        } else {
                                                                            $svg_line = '<span class="badge badge-light-warning fs-base">' . $svg_neutro . round($ta->percentage_reefer, 2) . '%</span>';
                                                                        }
                                                                        ?>
                                                                        <?php echo $svg_line; ?>
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-gray-600 fw-bold fs-6"><?php echo $ta->reefer_loads_picking_0; ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if (floatval($ta->percentage_reefer_picking) < 0) {
                                                                            $svg_percentage_reefer_picking = '<span class="badge badge-light-danger fs-base">' . $svg_danger . round($ta->percentage_reefer_picking, 2) . '%</span>';
                                                                        } else if (floatval($ta->percentage_reefer_picking) > 0) {
                                                                            $svg_percentage_reefer_picking = '<span class="badge badge-light-success fs-base">' . $svg_success . round($ta->percentage_reefer_picking, 2) . '%</span>';
                                                                        } else {
                                                                            $svg_percentage_reefer_picking = '<span class="badge badge-light-warning fs-base">' . $svg_neutro . round($ta->percentage_reefer_picking, 2) . '%</span>';
                                                                        }
                                                                        ?>
                                                                        <?php echo $svg_percentage_reefer_picking; ?>
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-gray-600 fw-bold fs-6"><?php echo $ta->reefer_loads_dropping_0; ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if (floatval($ta->percentage_reefer_dropping) < 0) {
                                                                            $svg_reefer_loads_dropping = '<span class="badge badge-light-danger fs-base">' . $svg_danger . round($ta->percentage_reefer_dropping, 2) . '%</span>';
                                                                        } else if (floatval($ta->percentage_reefer_dropping) > 0) {
                                                                            $svg_reefer_loads_dropping = '<span class="badge badge-light-success fs-base">' . $svg_success . round($ta->percentage_reefer_dropping, 2) . '%</span>';
                                                                        } else {
                                                                            $svg_reefer_loads_dropping = '<span class="badge badge-light-warning fs-base">' . $svg_neutro . round($ta->percentage_reefer_dropping, 2) . '%</span>';
                                                                        }
                                                                        ?>
                                                                        <?php echo $svg_reefer_loads_dropping; ?>
                                                                    </td>

                                                                </tr>


                                                                <tr>
                                                                    <td>
                                                                        <span class="text-gray-800 fw-bold mb-1 fs-6">Flatbed</span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-gray-600 fw-bold fs-6"><?php echo $ta->flat_loads_0; ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if (floatval($ta->percentage_flat) < 0) {
                                                                            $svg_line = '<span class="badge badge-light-danger fs-base">' . $svg_danger . round($ta->percentage_flat, 2) . '%</span>';
                                                                        } else if (floatval($ta->percentage_flat) > 0) {
                                                                            $svg_line = '<span class="badge badge-light-success fs-base">' . $svg_success . round($ta->percentage_flat, 2) . '%</span>';
                                                                        } else {
                                                                            $svg_line = '<span class="badge badge-light-warning fs-base">' . $svg_neutro . round($ta->percentage_flat, 2) . '%</span>';
                                                                        }
                                                                        ?>
                                                                        <?php echo $svg_line; ?>
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-gray-600 fw-bold fs-6"><?php echo $ta->flat_loads_picking_0; ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if (floatval($ta->percentage_flat_picking) < 0) {
                                                                            $svg_percentage_flat_picking = '<span class="badge badge-light-danger fs-base">' . $svg_danger . round($ta->percentage_flat_picking, 2) . '%</span>';
                                                                        } else if (floatval($ta->percentage_flat_picking) > 0) {
                                                                            $svg_percentage_flat_picking = '<span class="badge badge-light-success fs-base">' . $svg_success . round($ta->percentage_flat_picking, 2) . '%</span>';
                                                                        } else {
                                                                            $svg_percentage_flat_picking = '<span class="badge badge-light-warning fs-base">' . $svg_neutro . round($ta->percentage_flat_picking, 2) . '%</span>';
                                                                        }
                                                                        ?>
                                                                        <?php echo $svg_percentage_flat_picking; ?>
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-gray-600 fw-bold fs-6"><?php echo $ta->flat_loads_dropping_0; ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if (floatval($ta->percentage_flat_dropping) < 0) {
                                                                            $svg_flat_loads_dropping = '<span class="badge badge-light-danger fs-base">' . $svg_danger . round($ta->percentage_flat_dropping, 2) . '%</span>';
                                                                        } else if (floatval($ta->percentage_flat_dropping) > 0) {
                                                                            $svg_flat_loads_dropping = '<span class="badge badge-light-success fs-base">' . $svg_success . round($ta->percentage_flat_dropping, 2) . '%</span>';
                                                                        } else {
                                                                            $svg_flat_loads_dropping = '<span class="badge badge-light-warning fs-base">' . $svg_neutro . round($ta->percentage_flat_dropping, 2) . '%</span>';
                                                                        }
                                                                        ?>
                                                                        <?php echo $svg_flat_loads_dropping; ?>
                                                                    </td>

                                                                </tr>


                                                                <tr>
                                                                    <td>
                                                                        <span class="text-gray-800 fw-bold mb-1 fs-6">Power Only</span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-gray-600 fw-bold fs-6"><?php echo $ta->power_loads_0; ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if (floatval($ta->percentage_power) < 0) {
                                                                            $svg_line = '<span class="badge badge-light-danger fs-base">' . $svg_danger . round($ta->percentage_power, 2) . '%</span>';
                                                                        } else if (floatval($ta->percentage_power) > 0) {
                                                                            $svg_line = '<span class="badge badge-light-success fs-base">' . $svg_success . round($ta->percentage_power, 2) . '%</span>';
                                                                        } else {
                                                                            $svg_line = '<span class="badge badge-light-warning fs-base">' . $svg_neutro . round($ta->percentage_power, 2) . '%</span>';
                                                                        }
                                                                        ?>
                                                                        <?php echo $svg_line; ?>
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-gray-600 fw-bold fs-6"><?php echo $ta->power_loads_picking_0; ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if (floatval($ta->percentage_power_picking) < 0) {
                                                                            $svg_percentage_power_picking = '<span class="badge badge-light-danger fs-base">' . $svg_danger . round($ta->percentage_power_picking, 2) . '%</span>';
                                                                        } else if (floatval($ta->percentage_power_picking) > 0) {
                                                                            $svg_percentage_power_picking = '<span class="badge badge-light-success fs-base">' . $svg_success . round($ta->percentage_power_picking, 2) . '%</span>';
                                                                        } else {
                                                                            $svg_percentage_power_picking = '<span class="badge badge-light-warning fs-base">' . $svg_neutro . round($ta->percentage_power_picking, 2) . '%</span>';
                                                                        }
                                                                        ?>
                                                                        <?php echo $svg_percentage_power_picking; ?>
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-gray-600 fw-bold fs-6"><?php echo $ta->power_loads_dropping_0; ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if (floatval($ta->percentage_power_dropping) < 0) {
                                                                            $svg_power_loads_dropping = '<span class="badge badge-light-danger fs-base">' . $svg_danger . round($ta->percentage_power_dropping, 2) . '%</span>';
                                                                        } else if (floatval($ta->percentage_power_dropping) > 0) {
                                                                            $svg_power_loads_dropping = '<span class="badge badge-light-success fs-base">' . $svg_success . round($ta->percentage_power_dropping, 2) . '%</span>';
                                                                        } else {
                                                                            $svg_power_loads_dropping = '<span class="badge badge-light-warning fs-base">' . $svg_neutro . round($ta->percentage_power_dropping, 2) . '%</span>';
                                                                        }
                                                                        ?>
                                                                        <?php echo $svg_power_loads_dropping; ?>
                                                                    </td>

                                                                </tr>


                                                                <tr>
                                                                    <td>
                                                                        <span class="text-gray-800 fw-bold mb-1 fs-6">Heavy Haul</span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-gray-600 fw-bold fs-6"><?php echo $ta->heavy_loads_0; ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if (floatval($ta->percentage_heavy) < 0) {
                                                                            $svg_line = '<span class="badge badge-light-danger fs-base">' . $svg_danger . round($ta->percentage_heavy, 2) . '%</span>';
                                                                        } else if (floatval($ta->percentage_heavy) > 0) {
                                                                            $svg_line = '<span class="badge badge-light-success fs-base">' . $svg_success . round($ta->percentage_heavy, 2) . '%</span>';
                                                                        } else {
                                                                            $svg_line = '<span class="badge badge-light-warning fs-base">' . $svg_neutro . round($ta->percentage_heavy, 2) . '%</span>';
                                                                        }
                                                                        ?>
                                                                        <?php echo $svg_line; ?>
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-gray-600 fw-bold fs-6"><?php echo $ta->heavy_loads_picking_0; ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if (floatval($ta->percentage_picking_heavy) < 0) {
                                                                            $svg_percentage_heavy_picking = '<span class="badge badge-light-danger fs-base">' . $svg_danger . round($ta->percentage_picking_heavy, 2) . '%</span>';
                                                                        } else if (floatval($ta->percentage_picking_heavy) > 0) {
                                                                            $svg_percentage_heavy_picking = '<span class="badge badge-light-success fs-base">' . $svg_success . round($ta->percentage_picking_heavy, 2) . '%</span>';
                                                                        } else {
                                                                            $svg_percentage_heavy_picking = '<span class="badge badge-light-warning fs-base">' . $svg_neutro . round($ta->percentage_picking_heavy, 2) . '%</span>';
                                                                        }
                                                                        ?>
                                                                        <?php echo $svg_percentage_heavy_picking; ?>
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-gray-600 fw-bold fs-6"><?php echo $ta->heavy_loads_dropping_0; ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if (floatval($ta->percentage_dropping_heavy) < 0) {
                                                                            $svg_heavy_loads_dropping = '<span class="badge badge-light-danger fs-base">' . $svg_danger . round($ta->percentage_dropping_heavy, 2) . '%</span>';
                                                                        } else if (floatval($ta->percentage_dropping_heavy) > 0) {
                                                                            $svg_heavy_loads_dropping = '<span class="badge badge-light-success fs-base">' . $svg_success . round($ta->percentage_dropping_heavy, 2) . '%</span>';
                                                                        } else {
                                                                            $svg_heavy_loads_dropping = '<span class="badge badge-light-warning fs-base">' . $svg_neutro . round($ta->percentage_dropping_heavy, 2) . '%</span>';
                                                                        }
                                                                        ?>
                                                                        <?php echo $svg_heavy_loads_dropping; ?>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>
                                                    </div>
                                                    <!--end::Table-->
                                                </div>
                                                <!--end: Card Body-->
                                            </div>
                                        </div>
                                        <!--end::Tables widget 14-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->

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
                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
                <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
            </svg>
        </span>
        <!--end::Svg Icon-->
    </div>
    <!--end::Scrolltop-->



    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <script src="assets/js/lanerunner.js"></script>
    <!--end::Global Javascript Bundle-->



    <!--begin::Custom Javascript(used by this page)-->
    <script src="assets/js/widgets.bundle.js"></script>
    <script src="assets/js/custom/widgets.js"></script>

    <script>
        $(document).ready(function() {
            $('.van').addClass('hidden');
            $('.flat').addClass('hidden');
        })

        $("#price_change_alert_selector").on('change', function() {
            if ($(this).val() === "reefer") {
                $('.reefer').removeClass('hidden');
                $('.van').addClass('hidden');
                $('.flat').addClass('hidden');
            }
            if ($(this).val() === "van") {
                $('.reefer').addClass('hidden');
                $('.van').removeClass('hidden');
                $('.flat').addClass('hidden');
            }
            if ($(this).val() === "flat") {
                $('.reefer').addClass('hidden');
                $('.van').addClass('hidden');
                $('.flat').removeClass('hidden');
            }
        })


        $(".news_div_class").on('click', function() {
            var cual = $(this).attr('data-news')
            $("#expanded_news_section").html($("#desarrollo_noticia_" + cual).val())
            $("#expanded_news_modal").modal('show')
        })

        // gggexpanded_news_section


        $("#equipment_hot").on('change', function() {
            var cual = $(this).val()
            if (cual === "reefer") {
                $("#reefer_hot_lanes").css('display', 'table')
                $("#flat_hot_lanes").css('display', 'none')
                $("#van_hot_lanes").css('display', 'none')
            }
            if (cual === "flat") {
                $("#reefer_hot_lanes").css('display', 'none')
                $("#flat_hot_lanes").css('display', 'table')
                $("#van_hot_lanes").css('display', 'none')
            }
            if (cual === "van") {
                $("#reefer_hot_lanes").css('display', 'none')
                $("#flat_hot_lanes").css('display', 'none')
                $("#van_hot_lanes").css('display', 'table')
            }

        })


        $("#equipment_low").on('change', function() {
            var cual = $(this).val()
            if (cual === "reefer") {
                $("#reefer_cold_lanes").css('display', 'table')
                $("#flat_cold_lanes").css('display', 'none')
                $("#van_cold_lanes").css('display', 'none')
            }
            if (cual === "flat") {
                $("#reefer_cold_lanes").css('display', 'none')
                $("#flat_cold_lanes").css('display', 'table')
                $("#van_cold_lanes").css('display', 'none')
            }
            if (cual === "van") {
                $("#reefer_cold_lanes").css('display', 'none')
                $("#flat_cold_lanes").css('display', 'none')
                $("#van_cold_lanes").css('display', 'table')
            }

        })





        $("#flier_div").on('click', function() {
            $("#modal_flyer").modal('show')
        })

        $(document).on('click', function(e) {
            if ($(e.target).data('toggle') !== 'popover' && !$(e.target).parents().is('.popover.show')) {
                $('[data-bs-toggle="popover"]').popover('hide');
            }
        });

        var inactivityTimeLimit = 600000;
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
        $(document).ready(function() {
            startInactivityTimer();
        });
        $(document).on("mousemove keypress mousedown touchstart", function() {
            resetInactivityTimer();
        });
    </script>

</body>
<!--end::Body-->

</html>