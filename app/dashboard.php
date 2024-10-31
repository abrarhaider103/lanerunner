<?php
error_reporting(0);
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
        /* #flier_div {
            background-image: url("imgs/flier.jpg");
            background-size: cover;
            background-position: center center;
            cursor: pointer;
            border-radius: 10px;
            min-height: 250px;
        } */

        /* #lifetime_div{
            background-image: url("imgs/lifetime.jpg");
            background-size: cover;
            background-position: center center;
            cursor: pointer;
            border-radius: 10px;
            min-height: 250px;
        } */

        table tbody tr:hover {
            border-radius: 4px;
            border-top: 1px solid grey;
            border-bottom: 1px solid grey !important;
            box-shadow: 0px 9px 4px -6px grey;
            background-color: var(--kt-highlight-tr);
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







        #banner {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #00827B;
            color: white;
            text-align: center;
            z-index: 1000;
            overflow: hidden;
            white-space: nowrap;
        }

        /* Style for the scrolling text */
        .scrolling-text {
            display: block;
        }
        .set-dashboard-img-1 {
    width: 100%;
    border-radius: 15px;
}
        /* Keyframes for scrolling animation */
        @keyframes scroll-left {
            0% {
                transform: translateX(100%);
            }
            100% {
                transform: translateX(-100%);
            }
        }
        @media only screen and (min-width: 320px) and (max-width: 529px) {
            .select2-container--open .select2-dropdown {
    left: -40px;
            }
            .nav-stretch {
    flex-wrap: wrap;
    justify-content: start !important;
    gap: 5px;
}
.load-counts-1{
    margin-bottom: 1.2rem;
}
        }
@media only screen and (min-width: 375px) and (max-width: 424px) {}
@media only screen and (min-width: 414px) and (max-width: 425px) {}
@media only screen and (min-width: 425px) and (max-width: 529px) {
}
@media only screen and (min-width: 530px) and (max-width: 767px) {
    .select2-container--open .select2-dropdown {
    left: -40px;
            }
            .load-counts-1{
    margin-bottom: 1.2rem;
}
}
@media only screen and (min-width:768px) and (max-width: 991px) {
    .select2-container--open .select2-dropdown {
    left: -40px;
            }
            .load-counts-1{
    margin-bottom: 1.2rem;
}
}
@media only screen and (min-width:992px) and (max-width: 1199px) {
    .select2-container--open .select2-dropdown {
    left: -20px;
}
.load-counts-1{
    margin-bottom: 1.2rem;
}
}
@media only screen and (min-width:1260px) and (max-width: 1365px) {}
@media only screen and (min-width:1366px) and (max-width: 1439px) {
}
@media only screen and (min-width: 1440px) and (max-width: 1599px) {}
@media only screen and (min-width: 1600px) and (max-width: 1800px) {}
@media only screen and (min-width: 1680px) and (max-width: 1919px){}
@media only screen and (min-width: 1920px) and (max-width: 2100px) {}
@media only screen and (min-width: 2560px) {
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
            if (localStorage.getItem("data-theme-imode") !== null || localStorage.getItem("data-theme-i") !== null) {
                localStorage.setItem("data-theme-mode", localStorage.getItem("data-theme-imode"));
                localStorage.setItem("data-theme", localStorage.getItem("data-theme-i"));
                localStorage.removeItem("data-theme-imode");
                localStorage.removeItem("data-theme-i");
            }

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
                                                    <!--begin::Toolbar-->
                                                    <div class="card-toolbardd">
                                                        <select class="form-select form-select-sm text-muted w-auto" id="summary" data-dropdown-css-class="w-150px" data-control="select2" data-hide-search="true">
                                                            <option value="reefer" selected>Reefer</option>
                                                            <option value="van">Van</option>
                                                            <option value="flat">Flatbed</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Toolbar-->
                                                </div>
                                                <!--end::Heading-->
                                                <!--begin::Body-->
                                                <div class="card-body" data-theme="light">

                                                    <!--begin::Summary-->                                                   
                                                    <div class="" id="reefer_summary">
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
                                                                            <span class="text-dark fs-7">&nbsp;&nbsp;($<?php echo round(($sr->spot_market_rate_diff / 100), 2); ?>)</span>
                                                                            <!--end::Number-->
                                                                        </div>
                                                                        <div class="d-flex flex-center">
                                                                            <!--begin::Desc-->
                                                                            <?php
                                                                            //segun el % dibuja en verde, amarillo o rojo
                                                                            if ($sr->spot_market_rate_perc < "0") { //red
                                                                                $svg_icon = "danger";
                                                                                $svg_file = "arr065";
                                                                                $svg_textcolor = "danger";
                                                                            } else if ($sr->spot_market_rate_perc > "0") { //green
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
                                                                            <span class="badge badge-light-<?php echo $svg_icon; ?> fs-6 <?php echo $svg_textcolor; ?>">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/<?php echo $svg_file; ?>.svg-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/' . $svg_file . '.svg', 'svg-icon-2 svg-icon-' . $svg_textcolor . ' ms-n1');
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
                                                                            <span class="text-dark fs-7">&nbsp;&nbsp;($<?php echo round(($sr->contract_rate_diff / 100), 2); ?>)</span>
                                                                            <!--end::Number-->
                                                                        </div>
                                                                        <div class="d-flex flex-center">
                                                                            <!--begin::Desc-->
                                                                            <?php
                                                                            //segun el % dibuja en verde, amarillo o rojo
                                                                            if ($sr->contract_rate_perc < 0) { //red
                                                                                $svg_icon = "danger";
                                                                                $svg_file = "arr065";
                                                                                $svg_textcolor = "danger";
                                                                            } else if ($sr->contract_rate_perc > 0) { //green
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
                                                                            <span class="badge badge-light-<?php echo $svg_icon; ?> fs-6 <?php echo $svg_textcolor; ?>">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/<?php echo $svg_file; ?>.svg-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/' . $svg_file . '.svg', 'svg-icon-2 svg-icon-' . $svg_textcolor . ' ms-n1');
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
                                                                            <span class="text-dark fs-7">&nbsp;&nbsp;($<?php echo round(($sr->fuel_surcharge_diff / 100), 2); ?>)</span>
                                                                            <!--end::Number-->
                                                                        </div>
                                                                        <div class="d-flex flex-center">
                                                                            <!--begin::Desc-->
                                                                            <?php
                                                                            //segun el % dibuja en verde, amarillo o rojo
                                                                            if ($sr->fuel_surcharge_perc < "0") { //red
                                                                                $svg_icon = "danger";
                                                                                $svg_file = "arr065";
                                                                                $svg_textcolor = "danger";
                                                                            } else if ($sr->fuel_surcharge_perc > "0") { //green
                                                                                $svg_icon = "success";
                                                                                $svg_file = "arr066";
                                                                                $svg_textcolor = "seccess";
                                                                            } else { // yellow
                                                                                $svg_icon = "warning";
                                                                                $svg_file = "arr090";
                                                                                $svg_textcolor = "text-gray-700";
                                                                            }
                                                                            ?>
                                                                            <!--begin::Label-->
                                                                            <span class="badge badge-light-<?php echo $svg_icon; ?> fs-6 <?php echo $svg_textcolor; ?>">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/<?php echo $svg_file; ?>.svg-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/' . $svg_file . '.svg', 'svg-icon-2 svg-icon-' . $svg_textcolor . ' ms-n1');
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
                                                                            <span class="text-dark fs-7">&nbsp;&nbsp;($<?php echo round(($sr->diesel_fuel_diff / 100), 2); ?>)</span>
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
                                                                                $svg_textcolor = "danger";
                                                                            } else if ($sr->diesel_fuel_avg_perc > "0") { //green
                                                                                $svg_icon = "success";
                                                                                $svg_file = "arr066";
                                                                                $svg_text = round($sr->diesel_fuel_avg_perc, 2) . '%';
                                                                                $svg_textcolor = "success";
                                                                            } else { // yellow
                                                                                $svg_icon = "warning";
                                                                                $svg_file = "arr090";
                                                                                $svg_text = '<span class="text-gray-500 fw-semibold">' . $sr->diesel_fuel_avg_perc . ' %</span>';
                                                                                $svg_textcolor = "text-gray-700";
                                                                            }
                                                                            ?>
                                                                            <!--begin::Label-->
                                                                            <span class="badge badge-light-<?php echo $svg_icon; ?> fs-6 <?php echo $svg_textcolor; ?>">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/<?php echo $svg_file; ?>.svg-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/' . $svg_file . '.svg', 'svg-icon-2 svg-icon-' . $svg_textcolor . ' ms-n1');
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
                                                    </div>
                                                    <!--end::Title-->

                                                    <!--/********** van summary ******************************************/-->
                                                    <!--begin::Summary-->                                                   
                                                    <div class="" id="van_summary" style="display:none">
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
                                                                            <span class="text-gray-700 fw-bolder fs-2qx lh-1 ls-n1 mb-1">$<?php echo $sr->spot_market_rate_van; ?></span>
                                                                            <span class="text-dark fs-7">&nbsp;&nbsp;($<?php echo round(($sr->spot_market_rate_diff_van / 100), 2); ?>)</span>
                                                                            <!--end::Number-->
                                                                        </div>
                                                                        <div class="d-flex flex-center">
                                                                            <!--begin::Desc-->
                                                                            <?php
                                                                            //segun el % dibuja en verde, amarillo o rojo
                                                                            if ($sr->spot_market_rate_perc_van < "0") { //red
                                                                                $svg_icon = "danger";
                                                                                $svg_file = "arr065";
                                                                                $svg_textcolor = "danger";
                                                                            } else if ($sr->spot_market_rate_perc_van > "0") { //green
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
                                                                            <span class="badge badge-light-<?php echo $svg_icon; ?> fs-6 <?php echo $svg_textcolor; ?>">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/<?php echo $svg_file; ?>.svg-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/' . $svg_file . '.svg', 'svg-icon-2 svg-icon-' . $svg_textcolor . ' ms-n1');
                                                                                ?>
                                                                                <?php echo round($sr->spot_market_rate_perc_van, 2); ?>
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
                                                                            <span class="text-gray-700 fw-bolder fs-2qx lh-1 ls-n1 mb-1">$<?php echo $sr->contract_rate_van; ?></span>
                                                                            <span class="text-dark fs-7">&nbsp;&nbsp;($<?php echo round(($sr->contract_rate_diff_van / 100), 2); ?>)</span>
                                                                            <!--end::Number-->
                                                                        </div>
                                                                        <div class="d-flex flex-center">
                                                                            <!--begin::Desc-->
                                                                            <?php
                                                                            //segun el % dibuja en verde, amarillo o rojo
                                                                            if ($sr->contract_rate_perc_van < 0) { //red
                                                                                $svg_icon = "danger";
                                                                                $svg_file = "arr065";
                                                                                $svg_textcolor = "danger";
                                                                            } else if ($sr->contract_rate_perc_van > 0) { //green
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
                                                                            <span class="badge badge-light-<?php echo $svg_icon; ?> fs-6 <?php echo $svg_textcolor; ?>">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/<?php echo $svg_file; ?>.svg-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/' . $svg_file . '.svg', 'svg-icon-2 svg-icon-' . $svg_textcolor . ' ms-n1');
                                                                                ?>
                                                                                <?php echo round($sr->contract_rate_perc_van, 2); ?>
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
                                                                            <span class="text-gray-700 fw-bolder fs-2qx lh-1 ls-n1 mb-1">$<?php echo $sr->fuel_surcharge_van; ?></span>
                                                                            <span class="text-dark fs-7">&nbsp;&nbsp;($<?php echo round(($sr->fuel_surcharge_diff_van / 100), 2); ?>)</span>
                                                                            <!--end::Number-->
                                                                        </div>
                                                                        <div class="d-flex flex-center">
                                                                            <!--begin::Desc-->
                                                                            <?php
                                                                            //segun el % dibuja en verde, amarillo o rojo
                                                                            if ($sr->fuel_surcharge_perc_van < "0") { //red
                                                                                $svg_icon = "danger";
                                                                                $svg_file = "arr065";
                                                                                $svg_textcolor = "danger";
                                                                            } else if ($sr->fuel_surcharge_perc_van > "0") { //green
                                                                                $svg_icon = "success";
                                                                                $svg_file = "arr066";
                                                                                $svg_textcolor = "seccess";
                                                                            } else { // yellow
                                                                                $svg_icon = "warning";
                                                                                $svg_file = "arr090";
                                                                                $svg_textcolor = "text-gray-700";
                                                                            }
                                                                            ?>
                                                                            <!--begin::Label-->
                                                                            <span class="badge badge-light-<?php echo $svg_icon; ?> fs-6 <?php echo $svg_textcolor; ?>">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/<?php echo $svg_file; ?>.svg-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/' . $svg_file . '.svg', 'svg-icon-2 svg-icon-' . $svg_textcolor . ' ms-n1');
                                                                                ?>
                                                                                <?php echo round($sr->fuel_surcharge_perc_van, 2); ?>
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
                                                                            <span class="text-gray-700 fw-bolder fs-2qx lh-1 ls-n1 mb-1">$<?php echo $sr->diesel_fuel_avg_van; ?></span>
                                                                            <span class="text-dark fs-7">&nbsp;&nbsp;($<?php echo round(($sr->diesel_fuel_diff_van / 100), 2); ?>)</span>
                                                                            <!--end::Number-->
                                                                        </div>
                                                                        <div class="d-flex flex-center">
                                                                            <!--begin::Desc-->
                                                                            <?php
                                                                            //segun el % dibuja en verde, amarillo o rojo
                                                                            if ($sr->diesel_fuel_avg_perc_van < "0") { //red
                                                                                $svg_icon = "danger";
                                                                                $svg_file = "arr065";
                                                                                $svg_text = round($sr->diesel_fuel_avg_perc_van, 2) . '%';
                                                                                $svg_textcolor = "danger";
                                                                            } else if ($sr->diesel_fuel_avg_perc_van > "0") { //green
                                                                                $svg_icon = "success";
                                                                                $svg_file = "arr066";
                                                                                $svg_text = round($sr->diesel_fuel_avg_perc_van, 2) . '%';
                                                                                $svg_textcolor = "success";
                                                                            } else { // yellow
                                                                                $svg_icon = "warning";
                                                                                $svg_file = "arr090";
                                                                                $svg_text = '<span class="text-gray-500 fw-semibold">' . $sr->diesel_fuel_avg_perc_van . ' %</span>';
                                                                                $svg_textcolor = "text-gray-700";
                                                                            }
                                                                            ?>
                                                                            <!--begin::Label-->
                                                                            <span class="badge badge-light-<?php echo $svg_icon; ?> fs-6 <?php echo $svg_textcolor; ?>">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/<?php echo $svg_file; ?>.svg-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/' . $svg_file . '.svg', 'svg-icon-2 svg-icon-' . $svg_textcolor . ' ms-n1');
                                                                                ?>
                                                                                <?php echo round($sr->diesel_fuel_avg_perc_van, 2); ?>
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
                                                    </div>
                                                    <!--end::Title-->


                                                    <!--/********** flat summary ******************************************/-->
                                                    <!--begin::Summary-->                                                   
                                                    <div class="" id="flat_summary" style="display:none">
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
                                                                            <span class="text-gray-700 fw-bolder fs-2qx lh-1 ls-n1 mb-1">$<?php echo $sr->spot_market_rate_flat; ?></span>
                                                                            <span class="text-dark fs-7">&nbsp;&nbsp;($<?php echo round(($sr->spot_market_rate_diff_flat / 100), 2); ?>)</span>
                                                                            <!--end::Number-->
                                                                        </div>
                                                                        <div class="d-flex flex-center">
                                                                            <!--begin::Desc-->
                                                                            <?php
                                                                            //segun el % dibuja en verde, amarillo o rojo
                                                                            if ($sr->spot_market_rate_perc_flat < "0") { //red
                                                                                $svg_icon = "danger";
                                                                                $svg_file = "arr065";
                                                                                $svg_textcolor = "danger";
                                                                            } else if ($sr->spot_market_rate_perc_flat > "0") { //green
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
                                                                            <span class="badge badge-light-<?php echo $svg_icon; ?> fs-6 <?php echo $svg_textcolor; ?>">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/<?php echo $svg_file; ?>.svg-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/' . $svg_file . '.svg', 'svg-icon-2 svg-icon-' . $svg_textcolor . ' ms-n1');
                                                                                ?>
                                                                                <?php echo round($sr->spot_market_rate_perc_flat, 2); ?>
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
                                                                            <span class="text-gray-700 fw-bolder fs-2qx lh-1 ls-n1 mb-1">$<?php echo $sr->contract_rate_flat; ?></span>
                                                                            <span class="text-dark fs-7">&nbsp;&nbsp;($<?php echo round(($sr->contract_rate_diff_flat / 100), 2); ?>)</span>
                                                                            <!--end::Number-->
                                                                        </div>
                                                                        <div class="d-flex flex-center">
                                                                            <!--begin::Desc-->
                                                                            <?php
                                                                            //segun el % dibuja en verde, amarillo o rojo
                                                                            if ($sr->contract_rate_perc_flat < 0) { //red
                                                                                $svg_icon = "danger";
                                                                                $svg_file = "arr065";
                                                                                $svg_textcolor = "danger";
                                                                            } else if ($sr->contract_rate_perc_flat > 0) { //green
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
                                                                            <span class="badge badge-light-<?php echo $svg_icon; ?> fs-6 <?php echo $svg_textcolor; ?>">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/<?php echo $svg_file; ?>.svg-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/' . $svg_file . '.svg', 'svg-icon-2 svg-icon-' . $svg_textcolor . ' ms-n1');
                                                                                ?>
                                                                                <?php echo round($sr->contract_rate_perc_flat, 2); ?>
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
                                                                            <span class="text-gray-700 fw-bolder fs-2qx lh-1 ls-n1 mb-1">$<?php echo $sr->fuel_surcharge_flat; ?></span>
                                                                            <span class="text-dark fs-7">&nbsp;&nbsp;($<?php echo round(($sr->fuel_surcharge_diff_flat / 100), 2); ?>)</span>
                                                                            <!--end::Number-->
                                                                        </div>
                                                                        <div class="d-flex flex-center">
                                                                            <!--begin::Desc-->
                                                                            <?php
                                                                            //segun el % dibuja en verde, amarillo o rojo
                                                                            if ($sr->fuel_surcharge_perc_flat < "0") { //red
                                                                                $svg_icon = "danger";
                                                                                $svg_file = "arr065";
                                                                                $svg_textcolor = "danger";
                                                                            } else if ($sr->fuel_surcharge_perc_flat > "0") { //green
                                                                                $svg_icon = "success";
                                                                                $svg_file = "arr066";
                                                                                $svg_textcolor = "seccess";
                                                                            } else { // yellow
                                                                                $svg_icon = "warning";
                                                                                $svg_file = "arr090";
                                                                                $svg_textcolor = "text-gray-700";
                                                                            }
                                                                            ?>
                                                                            <!--begin::Label-->
                                                                            <span class="badge badge-light-<?php echo $svg_icon; ?> fs-6 <?php echo $svg_textcolor; ?>">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/<?php echo $svg_file; ?>.svg-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/' . $svg_file . '.svg', 'svg-icon-2 svg-icon-' . $svg_textcolor . ' ms-n1');
                                                                                ?>
                                                                                <?php echo round($sr->fuel_surcharge_perc_flat, 2); ?>
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
                                                                            <span class="text-gray-700 fw-bolder fs-2qx lh-1 ls-n1 mb-1">$<?php echo $sr->diesel_fuel_avg_flat; ?></span>
                                                                            <span class="text-dark fs-7">&nbsp;&nbsp;($<?php echo round(($sr->diesel_fuel_diff_flat / 100), 2); ?>)</span>
                                                                            <!--end::Number-->
                                                                        </div>
                                                                        <div class="d-flex flex-center">
                                                                            <!--begin::Desc-->
                                                                            <?php
                                                                            //segun el % dibuja en verde, amarillo o rojo
                                                                            if ($sr->diesel_fuel_avg_perc_flat < "0") { //red
                                                                                $svg_icon = "danger";
                                                                                $svg_file = "arr065";
                                                                                $svg_text = round($sr->diesel_fuel_avg_perc_flat, 2) . '%';
                                                                                $svg_textcolor = "danger";
                                                                            } else if ($sr->diesel_fuel_avg_perc_flat > "0") { //green
                                                                                $svg_icon = "success";
                                                                                $svg_file = "arr066";
                                                                                $svg_text = round($sr->diesel_fuel_avg_perc_flat, 2) . '%';
                                                                                $svg_textcolor = "success";
                                                                            } else { // yellow
                                                                                $svg_icon = "warning";
                                                                                $svg_file = "arr090";
                                                                                $svg_text = '<span class="text-gray-500 fw-semibold">' . $sr->diesel_fuel_avg_perc_flat . ' %</span>';
                                                                                $svg_textcolor = "text-gray-700";
                                                                            }
                                                                            ?>
                                                                            <!--begin::Label-->
                                                                            <span class="badge badge-light-<?php echo $svg_icon; ?> fs-6 <?php echo $svg_textcolor; ?>">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/<?php echo $svg_file; ?>.svg-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/' . $svg_file . '.svg', 'svg-icon-2 svg-icon-' . $svg_textcolor . ' ms-n1');
                                                                                ?>
                                                                                <?php echo round($sr->diesel_fuel_avg_perc_flat, 2); ?>
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
                                                    </div>
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

                                                <div class="card-header mb-2">
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

                                                <?php $sql = "SELECT * FROM `high_and_low_revenue_lanes_data` where valuesHL='high'";
                                                        $data = $quote->getThisAll($sql);
                                                $highValueData = [];
                                                foreach ($data as $value) {
                                                    // Decode the URL encoded string in 'high_revenue_text'
                                                    $decodedText = urldecode($value->high_revenue_text);
                                                    $highValueData[$value->lane] = $decodedText;
                                                    // Output the decoded text
                                                    // echo $decodedText . "<br>";
                                                }
                                                ?>
                                                <!--begin::Body-->
                                                <div class="card-body pt-0">

                                                    <div class="table-responsive">
                                                        <table class="table table-row-dashed table-row-gray-300 small w-100 gx-5" id="reefer_hot_lanes">
                                                            <thead>
                                                                <tr><th><?= $highValueData['reefer'];?></th></tr>
                                                                <tr class="fw-bold small text-gray-800 bg-light d-none">
                                                                    <th width="40%">Lane</th>
                                                                    <th width="20%">Direct Rate</th>
                                                                    <th width="20%">Broker Rate</th>
                                                                    <th width="20%" class="text-center">24hr</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="d-none">
                                                                <?php

                                                                function roundToNearestMultipleOf50($number)
                                                                {
                                                                    return round($number / 50) * 50;
                                                                }

                                                                foreach ($reefer_hot_lanes as $c => $v) {

                                                                    if ($v->driving_distance === "0") {
                                                                        $v->driving_distance = $quote->get_driving_distaance($v->lane_id);
                                                                    }


                                                                    $equipment = 'reefer';

                                                                    $directRate = $v->new_value;

                                                                    if ($directRate >= 0 && $directRate <= 1200) {
                                                                        $fairValueBrokerRate = $directRate + 200;
                                                                    } elseif ($directRate >= 1201 && $directRate <= 2000) {
                                                                        $fairValueBrokerRate = $directRate + 250;
                                                                    } elseif ($directRate >= 2001 && $directRate <= 3600) {
                                                                        $fairValueBrokerRate = $directRate + 300;
                                                                    } elseif ($directRate >= 3601 && $directRate <= 5000) {
                                                                        $fairValueBrokerRate = $directRate + 350;
                                                                    } elseif ($directRate >= 5001 && $directRate <= 6500) {
                                                                        $fairValueBrokerRate = $directRate + 400;
                                                                    } elseif ($directRate >= 6501 && $directRate <= 7800) {
                                                                        $fairValueBrokerRate = $directRate + 450;
                                                                    } elseif ($directRate >= 7801 && $directRate <= 9000) {
                                                                        $fairValueBrokerRate = $directRate + 500;
                                                                    } elseif ($directRate >= 9001 && $directRate <= 10200) {
                                                                        $fairValueBrokerRate = $directRate + 550;
                                                                    } elseif ($directRate >= 10201 && $directRate <= 11500) {
                                                                        $fairValueBrokerRate = $directRate + 600;
                                                                    } else {
                                                                        $fairValueBrokerRate = $directRate + 700;
                                                                    }

                                                                    if ($equipment === "van") {
                                                                        $fairValueBrokerRate = $fairValueBrokerRate - 50;
                                                                    }
                                                                    if ($equipment === "flat") {
                                                                        $fairValueBrokerRate = $fairValueBrokerRate + 50;
                                                                    }
                                                                    $rpm_shipper = round(($fairValueBrokerRate / $v->driving_distance), 2);
                                                                    $rpm = round(($directRate / $v->driving_distance), 2);

                                                                    $valor_actual = $directRate;

                                                                    $directRate = "$" . number_format(roundToNearestMultipleOf50($directRate), 2);
                                                                    $fairValueBrokerRate = "$" . number_format(roundToNearestMultipleOf50($fairValueBrokerRate), 2);

                                                                ?>
                                                                    <tr>
                                                                        <td>
                                                                            <a href="rate_engine.php?sec=<?php echo $v->lane_id; ?>&eq=1" class="text-primary fw-bold"><?php echo $v->fantasy_name; ?></a>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo round($v->driving_distance, 2); ?> Mi</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-gray-800 fw-bold me-3 d-block"><?php echo $directRate; ?></span>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo "$" . $rpm; ?> RPM</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-gray-800 fw-bold me-3 d-block"><?php echo $fairValueBrokerRate; ?></span>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo "$" . $rpm_shipper; ?> RPM</span>
                                                                        </td>

                                                                        <td>
                                                                            <!--begin::Label-->
                                                                            <span class="badge badge-light-success fs-base">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg flechaarribaverde-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/arr066.svg', 'svg-icon- svg-icon-success ms-');
                                                                                ?>
                                                                                <?php echo round($v->magnitude, 2); ?> %
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
                                                                <tr><th><?= $highValueData['flatbed'];?></th></tr>
                                                                <tr class="fw-bold small text-gray-800 bg-light d-none">
                                                                    <th width="40%">Lane</th>
                                                                    <th width="20%">Direct Rate</th>
                                                                    <th width="20%">Broker Rate</th>
                                                                    <th width="20%" class="text-center">24hr</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="d-none">
                                                                <?php
                                                                foreach ($flat_hot_lanes as $c => $v) {
                                                                    if ($v->driving_distance === "0") {
                                                                        $v->driving_distance = $quote->get_driving_distaance($v->lane_id);
                                                                    }


                                                                    $equipment = 'flat';
                                                                    $directRate = $v->new_value;
                                                                    if ($directRate >= 0 && $directRate <= 1200) {
                                                                        $fairValueBrokerRate = $directRate + 200;
                                                                    } elseif ($directRate >= 1201 && $directRate <= 2000) {
                                                                        $fairValueBrokerRate = $directRate + 250;
                                                                    } elseif ($directRate >= 2001 && $directRate <= 3600) {
                                                                        $fairValueBrokerRate = $directRate + 300;
                                                                    } elseif ($directRate >= 3601 && $directRate <= 5000) {
                                                                        $fairValueBrokerRate = $directRate + 350;
                                                                    } elseif ($directRate >= 5001 && $directRate <= 6500) {
                                                                        $fairValueBrokerRate = $directRate + 400;
                                                                    } elseif ($directRate >= 6501 && $directRate <= 7800) {
                                                                        $fairValueBrokerRate = $directRate + 450;
                                                                    } elseif ($directRate >= 7801 && $directRate <= 9000) {
                                                                        $fairValueBrokerRate = $directRate + 500;
                                                                    } elseif ($directRate >= 9001 && $directRate <= 10200) {
                                                                        $fairValueBrokerRate = $directRate + 550;
                                                                    } elseif ($directRate >= 10201 && $directRate <= 11500) {
                                                                        $fairValueBrokerRate = $directRate + 600;
                                                                    } else {
                                                                        $fairValueBrokerRate = $directRate + 700;
                                                                    }

                                                                    if ($equipment === "van") {
                                                                        $fairValueBrokerRate = $fairValueBrokerRate - 50;
                                                                    }
                                                                    if ($equipment === "flat") {
                                                                        $fairValueBrokerRate = $fairValueBrokerRate + 50;
                                                                    }
                                                                    $rpm_shipper = round(($fairValueBrokerRate / $v->driving_distance), 2);
                                                                    $rpm = round(($directRate / $v->driving_distance), 2);
                                                                    $valor_actual = $directRate;
                                                                    $directRate = "$" . number_format(roundToNearestMultipleOf50($directRate), 2);
                                                                    $fairValueBrokerRate = "$" . number_format(roundToNearestMultipleOf50($fairValueBrokerRate), 2);


                                                                ?>
                                                                    <tr>
                                                                        <td>
                                                                            <a href="rate_engine.php?sec=<?php echo $v->lane_id; ?>&eq=1" class="text-primary fw-bold"><?php echo $v->fantasy_name; ?></a>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo round($v->driving_distance, 2); ?> Mi</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-gray-800 fw-bold me-3 d-block"><?php echo $directRate; ?></span>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo "$" . $rpm; ?> RPM</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-gray-800 fw-bold me-3 d-block"><?php echo $fairValueBrokerRate; ?></span>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo "$" . $rpm_shipper; ?> RPM</span>
                                                                        </td>

                                                                        <td>
                                                                            <!--begin::Label-->
                                                                            <span class="badge badge-light-success fs-base">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg flechaarribaverde-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/arr066.svg', 'svg-icon- svg-icon-success ms-');
                                                                                ?>
                                                                                <?php echo round($v->magnitude, 2); ?> %
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
                                                                <tr><th><?= $highValueData['van'];?></th></tr>
                                                                <tr class="fw-bold small text-gray-800 bg-light d-none">
                                                                    <th width="40%">Lane</th>
                                                                    <th width="20%">Direct Rate</th>
                                                                    <th width="20%">Broker Rate</th>
                                                                    <th width="20%" class="text-center">24hr</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="d-none">
                                                                <?php
                                                                foreach ($van_hot_lanes as $c => $v) {
                                                                    if ($v->driving_distance === "0") {
                                                                        $v->driving_distance = $quote->get_driving_distaance($v->lane_id);
                                                                    }


                                                                    $equipment = 'van';
                                                                    $directRate = $v->new_value;
                                                                    if ($directRate >= 0 && $directRate <= 1200) {
                                                                        $fairValueBrokerRate = $directRate + 200;
                                                                    } elseif ($directRate >= 1201 && $directRate <= 2000) {
                                                                        $fairValueBrokerRate = $directRate + 250;
                                                                    } elseif ($directRate >= 2001 && $directRate <= 3600) {
                                                                        $fairValueBrokerRate = $directRate + 300;
                                                                    } elseif ($directRate >= 3601 && $directRate <= 5000) {
                                                                        $fairValueBrokerRate = $directRate + 350;
                                                                    } elseif ($directRate >= 5001 && $directRate <= 6500) {
                                                                        $fairValueBrokerRate = $directRate + 400;
                                                                    } elseif ($directRate >= 6501 && $directRate <= 7800) {
                                                                        $fairValueBrokerRate = $directRate + 450;
                                                                    } elseif ($directRate >= 7801 && $directRate <= 9000) {
                                                                        $fairValueBrokerRate = $directRate + 500;
                                                                    } elseif ($directRate >= 9001 && $directRate <= 10200) {
                                                                        $fairValueBrokerRate = $directRate + 550;
                                                                    } elseif ($directRate >= 10201 && $directRate <= 11500) {
                                                                        $fairValueBrokerRate = $directRate + 600;
                                                                    } else {
                                                                        $fairValueBrokerRate = $directRate + 700;
                                                                    }

                                                                    if ($equipment === "van") {
                                                                        $fairValueBrokerRate = $fairValueBrokerRate - 50;
                                                                    }
                                                                    if ($equipment === "flat") {
                                                                        $fairValueBrokerRate = $fairValueBrokerRate + 50;
                                                                    }
                                                                    $rpm_shipper = round(($fairValueBrokerRate / $v->driving_distance), 2);
                                                                    $rpm = round(($directRate / $v->driving_distance), 2);
                                                                    $valor_actual = $directRate;
                                                                    $directRate = "$" . number_format(roundToNearestMultipleOf50($directRate), 2);
                                                                    $fairValueBrokerRate = "$" . number_format(roundToNearestMultipleOf50($fairValueBrokerRate), 2);

                                                                ?>
                                                                    <tr>
                                                                        <td>
                                                                            <a href="rate_engine.php?sec=<?php echo $v->lane_id; ?>&eq=1" class="text-primary fw-bold"><?php echo $v->fantasy_name; ?></a>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo round($v->driving_distance, 2); ?> Mi</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-gray-800 fw-bold me-3 d-block"><?php echo $directRate; ?></span>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo "$" . $rpm; ?> RPM</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-gray-800 fw-bold me-3 d-block"><?php echo $fairValueBrokerRate; ?></span>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo "$" . $rpm_shipper; ?> RPM</span>
                                                                        </td>

                                                                        <td>
                                                                            <!--begin::Label-->
                                                                            <span class="badge badge-light-success fs-base">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg flechaarribaverde-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/arr066.svg', 'svg-icon- svg-icon-success ms-');
                                                                                ?>
                                                                                <?php echo round($v->magnitude, 2); ?> %
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
                                                </div>
                                                <!--end::Body-->

                                                <!--<img src="<?= BASE_URL ?>images/1.png" alt="" class="set-dashboard-img-1">-->

                                            </div>
                                        </div>
                                        <!--end::LIst widget 8-->
                                    </div>
                                    <!--end::Col-->


                                    <!--begin::Col cold lanes-->
                                    <div class="col-xl-6 mb-5 mb-xl-10">
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

                                                <div class="card-header mb-2">
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
                                                <?php $sql = "SELECT * FROM `high_and_low_revenue_lanes_data` where valuesHL='low'";
                                                        $data = $quote->getThisAll($sql);
                                                $highValueData = [];
                                                foreach ($data as $value) {
                                                    // Decode the URL encoded string in 'high_revenue_text'
                                                    $decodedText = urldecode($value->high_revenue_text);
                                                    $highValueData[$value->lane] = $decodedText;
                                                    // Output the decoded text
                                                    // echo $decodedText . "<br>";
                                                }
                                                ?>
                                                <!--begin::Body-->
                                                <div class="card-body pt-0">

                                                    <!--begin::Table Cold Lanes-->
                                                    <div class="table-responsive">
                                                        <table class="table table-row-dashed table-row-gray-300 small w-100" id="reefer_cold_lanes">
                                                            <thead>
                                                                <tr><th><?= $highValueData['reefer'];?></th></tr>
                                                                <tr class="fw-bold small text-gray-800 bg-light d-none">
                                                                    <th width="40%">Lane</th>
                                                                    <th width="20%">Direct Rate</th>
                                                                    <th width="20%">Broker Rate</th>
                                                                    <th width="20%" class="text-center">24hr</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="d-none">
                                                                <?php
                                                                foreach ($reefer_cold_lanes as $c => $v) {
                                                                    if ($v->driving_distance === "0") {
                                                                        $v->driving_distance = $quote->get_driving_distaance($v->lane_id);
                                                                    }

                                                                    $equipment = 'reefer';
                                                                    $directRate = $v->new_value;
                                                                    if ($directRate >= 0 && $directRate <= 1200) {
                                                                        $fairValueBrokerRate = $directRate + 200;
                                                                    } elseif ($directRate >= 1201 && $directRate <= 2000) {
                                                                        $fairValueBrokerRate = $directRate + 250;
                                                                    } elseif ($directRate >= 2001 && $directRate <= 3600) {
                                                                        $fairValueBrokerRate = $directRate + 300;
                                                                    } elseif ($directRate >= 3601 && $directRate <= 5000) {
                                                                        $fairValueBrokerRate = $directRate + 350;
                                                                    } elseif ($directRate >= 5001 && $directRate <= 6500) {
                                                                        $fairValueBrokerRate = $directRate + 400;
                                                                    } elseif ($directRate >= 6501 && $directRate <= 7800) {
                                                                        $fairValueBrokerRate = $directRate + 450;
                                                                    } elseif ($directRate >= 7801 && $directRate <= 9000) {
                                                                        $fairValueBrokerRate = $directRate + 500;
                                                                    } elseif ($directRate >= 9001 && $directRate <= 10200) {
                                                                        $fairValueBrokerRate = $directRate + 550;
                                                                    } elseif ($directRate >= 10201 && $directRate <= 11500) {
                                                                        $fairValueBrokerRate = $directRate + 600;
                                                                    } else {
                                                                        $fairValueBrokerRate = $directRate + 700;
                                                                    }

                                                                    if ($equipment === "van") {
                                                                        $fairValueBrokerRate = $fairValueBrokerRate - 50;
                                                                    }
                                                                    if ($equipment === "flat") {
                                                                        $fairValueBrokerRate = $fairValueBrokerRate + 50;
                                                                    }
                                                                    $rpm_shipper = round(($fairValueBrokerRate / $v->driving_distance), 2);
                                                                    $rpm = round(($directRate / $v->driving_distance), 2);
                                                                    $valor_actual = $directRate;
                                                                    $directRate = "$" . number_format(roundToNearestMultipleOf50($directRate), 2);
                                                                    $fairValueBrokerRate = "$" . number_format(roundToNearestMultipleOf50($fairValueBrokerRate), 2);


                                                                ?>
                                                                    <tr>
                                                                        <td>
                                                                            <a href="rate_engine.php?sec=<?php echo $v->lane_id; ?>&eq=1" class="text-primary fw-bold"><?php echo $v->fantasy_name; ?></a>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo round($v->driving_distance, 2); ?> Mi</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-gray-800 fw-bold me-3 d-block"><?php echo $directRate; ?></span>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo "$" . $rpm; ?> RPM</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-gray-800 fw-bold me-3 d-block"><?php echo $fairValueBrokerRate; ?></span>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo "$" . $rpm_shipper; ?> RPM</span>
                                                                        </td>
                                                                        <td>
                                                                            <!--begin::Label-->
                                                                            <span class="badge badge-light-danger fs-base">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg flechaarribaverde-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/arr065.svg', 'svg-icon- svg-icon-danger ms-');
                                                                                ?>
                                                                                <?php echo round($v->magnitude, 2); ?> %
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
                                                                <tr><th><?= $highValueData['flatbed'];?></th></tr>
                                                                <tr class="fw-bold small text-gray-800 bg-light d-none">
                                                                    <th width="40%">Lane</th>
                                                                    <th width="20%">Direct Rate</th>
                                                                    <th width="20%">Broker Rate</th>
                                                                    <th width="20%" class="text-center">24hr</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="d-none">
                                                                <?php
                                                                foreach ($flat_cold_lanes as $c => $v) {
                                                                    if ($v->driving_distance === "0") {
                                                                        $v->driving_distance = $quote->get_driving_distaance($v->lane_id);
                                                                    }

                                                                    $equipment = 'flat';
                                                                    $directRate = $v->new_value;
                                                                    if ($directRate >= 0 && $directRate <= 1200) {
                                                                        $fairValueBrokerRate = $directRate + 200;
                                                                    } elseif ($directRate >= 1201 && $directRate <= 2000) {
                                                                        $fairValueBrokerRate = $directRate + 250;
                                                                    } elseif ($directRate >= 2001 && $directRate <= 3600) {
                                                                        $fairValueBrokerRate = $directRate + 300;
                                                                    } elseif ($directRate >= 3601 && $directRate <= 5000) {
                                                                        $fairValueBrokerRate = $directRate + 350;
                                                                    } elseif ($directRate >= 5001 && $directRate <= 6500) {
                                                                        $fairValueBrokerRate = $directRate + 400;
                                                                    } elseif ($directRate >= 6501 && $directRate <= 7800) {
                                                                        $fairValueBrokerRate = $directRate + 450;
                                                                    } elseif ($directRate >= 7801 && $directRate <= 9000) {
                                                                        $fairValueBrokerRate = $directRate + 500;
                                                                    } elseif ($directRate >= 9001 && $directRate <= 10200) {
                                                                        $fairValueBrokerRate = $directRate + 550;
                                                                    } elseif ($directRate >= 10201 && $directRate <= 11500) {
                                                                        $fairValueBrokerRate = $directRate + 600;
                                                                    } else {
                                                                        $fairValueBrokerRate = $directRate + 700;
                                                                    }

                                                                    if ($equipment === "van") {
                                                                        $fairValueBrokerRate = $fairValueBrokerRate - 50;
                                                                    }
                                                                    if ($equipment === "flat") {
                                                                        $fairValueBrokerRate = $fairValueBrokerRate + 50;
                                                                    }
                                                                    $rpm_shipper = round(($fairValueBrokerRate / $v->driving_distance), 2);
                                                                    $rpm = round(($directRate / $v->driving_distance), 2);
                                                                    $valor_actual = $directRate;
                                                                    $directRate = "$" . number_format(roundToNearestMultipleOf50($directRate), 2);
                                                                    $fairValueBrokerRate = "$" . number_format(roundToNearestMultipleOf50($fairValueBrokerRate), 2);

                                                                ?>
                                                                    <tr>
                                                                        <td>
                                                                            <a href="rate_engine.php?sec=<?php echo $v->lane_id; ?>&eq=1" class="text-primary fw-bold"><?php echo $v->fantasy_name; ?></a>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo round($v->driving_distance, 2); ?> Mi</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-gray-800 fw-bold me-3 d-block"><?php echo $directRate; ?></span>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo "$" . $rpm; ?> RPM</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-gray-800 fw-bold me-3 d-block"><?php echo $fairValueBrokerRate; ?></span>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo "$" . $rpm_shipper; ?> RPM</span>
                                                                        </td>
                                                                        <td>
                                                                            <!--begin::Label-->
                                                                            <span class="badge badge-light-danger fs-base">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg flechaarribaverde-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/arr065.svg', 'svg-icon- svg-icon-danger ms-');
                                                                                ?>
                                                                                <?php echo round($v->magnitude, 2); ?> %
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
                                                                <tr><th><?= $highValueData['van'];?></th></tr>
                                                                <tr class="fw-bold small text-gray-800 bg-light d-none">
                                                                    <th width="40%">Lane</th>
                                                                    <th width="20%">Direct Rate</th>
                                                                    <th width="20%">Broker Rate</th>
                                                                    <th width="20%" class="text-center">24hr</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="d-none">
                                                                <?php
                                                                foreach ($van_cold_lanes as $c => $v) {
                                                                    if ($v->driving_distance === "0") {
                                                                        $v->driving_distance = $quote->get_driving_distaance($v->lane_id);
                                                                    }

                                                                    $equipment = 'van';
                                                                    $directRate = $v->new_value;
                                                                    if ($directRate >= 0 && $directRate <= 1200) {
                                                                        $fairValueBrokerRate = $directRate + 200;
                                                                    } elseif ($directRate >= 1201 && $directRate <= 2000) {
                                                                        $fairValueBrokerRate = $directRate + 250;
                                                                    } elseif ($directRate >= 2001 && $directRate <= 3600) {
                                                                        $fairValueBrokerRate = $directRate + 300;
                                                                    } elseif ($directRate >= 3601 && $directRate <= 5000) {
                                                                        $fairValueBrokerRate = $directRate + 350;
                                                                    } elseif ($directRate >= 5001 && $directRate <= 6500) {
                                                                        $fairValueBrokerRate = $directRate + 400;
                                                                    } elseif ($directRate >= 6501 && $directRate <= 7800) {
                                                                        $fairValueBrokerRate = $directRate + 450;
                                                                    } elseif ($directRate >= 7801 && $directRate <= 9000) {
                                                                        $fairValueBrokerRate = $directRate + 500;
                                                                    } elseif ($directRate >= 9001 && $directRate <= 10200) {
                                                                        $fairValueBrokerRate = $directRate + 550;
                                                                    } elseif ($directRate >= 10201 && $directRate <= 11500) {
                                                                        $fairValueBrokerRate = $directRate + 600;
                                                                    } else {
                                                                        $fairValueBrokerRate = $directRate + 700;
                                                                    }

                                                                    if ($equipment === "van") {
                                                                        $fairValueBrokerRate = $fairValueBrokerRate - 50;
                                                                    }
                                                                    if ($equipment === "flat") {
                                                                        $fairValueBrokerRate = $fairValueBrokerRate + 50;
                                                                    }
                                                                    $rpm_shipper = round(($fairValueBrokerRate / $v->driving_distance), 2);
                                                                    $rpm = round(($directRate / $v->driving_distance), 2);
                                                                    $valor_actual = $directRate;
                                                                    $directRate = "$" . number_format(roundToNearestMultipleOf50($directRate), 2);
                                                                    $fairValueBrokerRate = "$" . number_format(roundToNearestMultipleOf50($fairValueBrokerRate), 2);

                                                                ?>
                                                                    <tr>
                                                                        <td>
                                                                            <a href="rate_engine.php?sec=<?php echo $v->lane_id; ?>&eq=1" class="text-primary fw-bold"><?php echo $v->fantasy_name; ?></a>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo round($v->driving_distance, 2); ?> Mi</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-gray-800 fw-bold me-3 d-block"><?php echo $directRate; ?></span>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo "$" . $rpm; ?> RPM</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-gray-800 fw-bold me-3 d-block"><?php echo $fairValueBrokerRate; ?></span>
                                                                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0"><?php echo "$" . $rpm_shipper; ?> RPM</span>
                                                                        </td>
                                                                        <td>
                                                                            <!--begin::Label-->
                                                                            <span class="badge badge-light-danger fs-base">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg flechaarribaverde-->
                                                                                <?php
                                                                                echo getSvgIcon('assets/media/icons/duotune/arrows/arr065.svg', 'svg-icon- svg-icon-danger ms-');
                                                                                ?>
                                                                                <?php echo round($v->magnitude, 2); ?> %
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
                                                <!--<img src="<?= BASE_URL ?>images/2.png" alt="" class="set-dashboard-img-1">-->
                                            </div>
                                        </div>
                                        <!--end::LIst widget 8-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->


                                <!--begin::Row-->
                                <div class="row g-5 g-xl-10">
                                    <!--begin::Col-->
                                    <div class="col-xl-12 mb-xl-10">
                                        <!--begin::Tables widget 14-->
                                        <div class="load-counts load-counts-1">
                                            <div class="card card-flush h-md-100">
                                                <!--begin::Header-->
                                                <div class="card-header pt-7 justify-content-between d-none">
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
                                                <div class="card-body pt-5 d-none">
                                                    <!--begin::Table container-->
                                                    <div class="table-responsive">
                                                        <!--begin::Table-->
                                                        <table class="table table-row-dashed align-middle gs-2 gy-3 gx-3 my-0 w-100">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <tr class="fs-7 fw-bold text-gray-800 border-bottom-0 pb-3 bg-light">
                                                                    <th>ITEM</th>
                                                                    <th>AVAILABLE LOADS</th>
                                                                    <th>24hr</th>
                                                                    <th># LOADS PICKING</th>
                                                                    <th>24hr</th>
                                                                    <th># LOADS DROPPING</th>
                                                                    <th>24hr</th>
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
                                                                            $svg_line = '<span class="badge badge-light-warning fs-base text-gray-700">' . $svg_neutro . round($ta->percentage_van, 2) . '%</span>';
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
                                                                            $svg_percentage_van_picking = '<span class="badge badge-light-warning fs-base text-gray-700">' . $svg_neutro . round($ta->percentage_van_picking, 2) . '%</span>';
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
                                                                            $svg_van_loads_dropping = '<span class="badge badge-light-warning fs-base text-gray-700">' . $svg_neutro . round($ta->percentage_van_dropping, 2) . '%</span>';
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
                                                                            $svg_line = '<span class="badge badge-light-warning fs-base text-gray-700">' . $svg_neutro . round($ta->percentage_reefer, 2) . '%</span>';
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
                                                                            $svg_percentage_reefer_picking = '<span class="badge badge-light-warning fs-base text-gray-700">' . $svg_neutro . round($ta->percentage_reefer_picking, 2) . '%</span>';
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
                                                                            $svg_reefer_loads_dropping = '<span class="badge badge-light-warning fs-base text-gray-700">' . $svg_neutro . round($ta->percentage_reefer_dropping, 2) . '%</span>';
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
                                                                            $svg_line = '<span class="badge badge-light-warning fs-base text-gray-700">' . $svg_neutro . round($ta->percentage_flat, 2) . '%</span>';
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
                                                                            $svg_percentage_flat_picking = '<span class="badge badge-light-warning fs-base text-gray-700">' . $svg_neutro . round($ta->percentage_flat_picking, 2) . '%</span>';
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
                                                                            $svg_flat_loads_dropping = '<span class="badge badge-light-warning fs-base text-gray-700">' . $svg_neutro . round($ta->percentage_flat_dropping, 2) . '%</span>';
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
                                                                            $svg_line = '<span class="badge badge-light-warning fs-base text-gray-700">' . $svg_neutro . round($ta->percentage_power, 2) . '%</span>';
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
                                                                            $svg_percentage_power_picking = '<span class="badge badge-light-warning fs-base text-gray-700">' . $svg_neutro . round($ta->percentage_power_picking, 2) . '%</span>';
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
                                                                            $svg_power_loads_dropping = '<span class="badge badge-light-warning fs-base text-gray-700">' . $svg_neutro . round($ta->percentage_power_dropping, 2) . '%</span>';
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
                                                                            $svg_line = '<span class="badge badge-light-warning fs-base text-gray-700">' . $svg_neutro . round($ta->percentage_heavy, 2) . '%</span>';
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
                                                                            $svg_percentage_heavy_picking = '<span class="badge badge-light-warning fs-base text-gray-700">' . $svg_neutro . round($ta->percentage_picking_heavy, 2) . '%</span>';
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
                                                                            $svg_heavy_loads_dropping = '<span class="badge badge-light-warning fs-base text-gray-700">' . $svg_neutro . round($ta->percentage_dropping_heavy, 2) . '%</span>';
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

                                                <img src="<?= BASE_URL ?>images/NewFeatures.png" alt="" class="set-dashboard-img-1">

                                            </div>
                                        </div>
                                        <!--end::Tables widget 14-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->

                                <!--begin::Row-->
                                <div class="row g-5 g-xl-10">
                                    <!--begin::Col price change alert -->
                                    <div class="col-xl-6 mb-xl-10">
                                        <!--begin::List widget 25-->
                                        <!--begin::Engage widget 1-->
                                        <div class="new-features h-100">
                                            <div class="card h-100">
                                                <!--begin::Body-->
                                                <div class="card-body card-stretch" id="flier_div">
                                                    <?php 
                                                        $sql = "select * from app_and_membership_mockup where 1";
                                                        $res = $quote->getThisAll($sql);
                                                        $mockupData = [];
                                                        foreach($res as $value){
                                                        $decodedText = urldecode($value->texto);
                                                        $mockupData[$value->types] = $decodedText;
                                                        }
                                                        echo $mockupData['mob_app'];
                                                    ?>
                                                    <!--img src="imgs/flier.jpg" style="width:100%; height:100%"-->
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                        </div>
                                        <!--end::LIst widget 25-->
                                    </div>
                                    <!--end::Col price change alert -->


                                    <!--begin::Col-->
                                    <div class="col-xl-6 mb-5 mb-xl-10">
                                        <!--begin::Engage widget 1-->
                                        <div class="new-features h-100">
                                            <div class="card h-100">
                                                <!--begin::Body-->
                                                <div class="card-body card-stretch" id="lifetime_div">
                                                    <!--img src="imgs/flier.jpg" style="width:100%; height:100%"-->
                                                    <?php
                                                    echo $mockupData['mem'];
                                                    ?>
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                        </div>
                                        <!--end::Engage widget 1-->
                                    </div>
                                    <!--end::Col-->

                                    <div class="modal fade" tabindex="-1" id="modal_flyer">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <img class="img-fluid d-none d-md-block" src="imgs/flier.jpg">
                                                    <img class="img-fluid d-md-none d-sm-block" src="imgs/fliermob.jpg">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" tabindex="-1" id="modal_lifetime">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <img class="img-fluid d-none d-md-block" src="imgs/lifetime.jpg">
                                                    <img class="img-fluid d-md-none d-sm-block" src="imgs/lifetime.jpg">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

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


        $("#summary").on('change', function() {
            var cual = $(this).val()
            if (cual === "reefer") {
                $("#reefer_summary").css('display', 'table')
                $("#flat_summary").css('display', 'none')
                $("#van_summary").css('display', 'none')
            }
            if (cual === "flat") {
                $("#reefer_summary").css('display', 'none')
                $("#flat_summary").css('display', 'table')
                $("#van_summary").css('display', 'none')
            }
            if (cual === "van") {
                $("#reefer_summary").css('display', 'none')
                $("#flat_summary").css('display', 'none')
                $("#van_summary").css('display', 'table')
            }

        })


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





        // $("#flier_div").on('click', function() {
        //     $("#modal_flyer").modal('show')
        // })

        // $("#lifetime_div").on('click', function() {
        //     $("#modal_lifetime").modal('show')
        // })

        $(document).on('click', function(e) {
            if ($(e.target).data('toggle') !== 'popover' && !$(e.target).parents().is('.popover.show')) {
                $('[data-bs-toggle="popover"]').popover('hide');
            }
        });


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
        $(document).ready(function() {
            startInactivityTimer();
        });
        $(document).on("mousemove keypress mousedown touchstart", function() {
            resetInactivityTimer();
        });


        /*
                // Set timeout variables.
        var timoutWarning = 3600000;
        var timoutNow = 60000; // Warning has been shown, give the user 1 minute to interact
        var logoutUrl = 'log_out.php'; // URL to logout page.

        var warningTimer;
        var timeoutTimer;

        // Start warning timer.
        function StartWarningTimer() {
            warningTimer = setTimeout("IdleWarning()", timoutWarning);
        }

        // Reset timers.
        function ResetTimeOutTimer() {
            clearTimeout(timeoutTimer);
            StartWarningTimer();
            $("#timeout").dialog('close');
        }

        // Show idle timeout warning dialog.
        function IdleWarning() {
            clearTimeout(warningTimer);
            timeoutTimer = setTimeout("IdleTimeout()", timoutNow);
            $("#timeout").dialog({
                modal: true
            });
            // Add code in the #timeout element to call ResetTimeOutTimer() if
            // the "Stay Logged In" button is clicked
        }

        // Logout the user.
        function IdleTimeout() {
            window.location = logoutUrl;
        }
        */
    </script>

</body>
<!--end::Body-->

</html>