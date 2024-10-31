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
?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <?php include("includes/head.php"); ?>
</head>
<!--end::Head-->
<!--begin::Body-->

<body data-kt-name="good" id="kt_app_body" data-kt-app-layout="light-sidebar" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" class="app-default">
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

                                <!--begin::Row-->
                                <div class="row g-5 g-xl-10">
                                    <!--begin::Col-->
                                    <div class="col-md-12">
                                        <!--begin::Engage widget 1-->
                                        <div class="card card-flush h-lg-100">
                                            <!--begin::Header-->
                                            <div class="card-header">
                                                <div class="row">
                                                    <div class="card-title">
                                                        <select class="form-select form-select-sm text-muted" id="mmi_equipment_selector" data-dropdown-css-class="w-150px" data-control="select2" data-hide-search="true">
                                                            <option value="reefer" selected>Reefer</option>
                                                            <option value="van">Van</option>
                                                            <option value="flat">Flatbed</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Body-->
                                            <div class="card-body pt-1">
                                                <!--begin::Top gainers-->
                                                <div class="mb-1">
                                                    <!--begin::Title-->
                                                    <h3 class="fw-semibold text-gray-800 lh-lg">
                                                        TOP GAINERS
                                                    </h3>

                                                    <!--end::Title-->
                                                    <!--begin::Chart Gainers-->
                                                    <div class="card card-bordered">
                                                        <div class="card-body">
                                                            <div id="kt_apexcharts_1" style="height: 350px;"></div>
                                                        </div>
                                                    </div>
                                                    <!--end::Chart Gainers-->
                                                </div>
                                                <!--end::Top gainers-->

                                                <!--begin::Top decliners-->
                                                <div class="mb-1">
                                                    <!--begin::Title-->
                                                    <h3 class="fw-semibold text-gray-800 lh-lg">
                                                        TOP DECLINERS
                                                    </h3>
                                                    <!--end::Title-->
                                                    <!--begin::Chart Decliners-->
                                                    <div class="card card-bordered">
                                                        <div class="card-body">
                                                            <div id="kt_apexcharts_2" style="height: 350px;"></div>
                                                        </div>
                                                    </div>
                                                    <!--end::Chart Decliners-->
                                                </div>
                                                <!--end::Top decliners-->
                                            </div>
                                            <!--end::Body-->
                                        </div>
                                        <!--end::Engage widget 1-->
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



    <?php
    $dato_nombre = '';
    $dato_porcentaje = '';
    $dato_nombre_abajo = '';
    $dato_porcentaje_abajo = '';



    foreach ($reefer_hot_lanes as $c => $v) {
        $dato_nombre .= "'" . $v->fantasy_name . "', ";
        $dato_porcentaje_reefer .= $v->magnitude . ", ";
    }


    foreach ($reefer_cold_lanes as $c => $v) {
        $dato_nombre_abajo .= "'" . $v->fantasy_name . "', ";
        $dato_porcentaje_abajo_reefer .= abs($v->magnitude) . ", ";
    }

    foreach ($van_hot_lanes as $c => $v) {
        //  $dato_nombre .= "'" . $v->fantasy_name . "', ";
        $dato_porcentaje_van .= $v->magnitude . ", ";
    }


    foreach ($van_cold_lanes as $c => $v) {
        //   $dato_nombre_abajo .= "'" . $v->fantasy_name . "', ";
        $dato_porcentaje_abajo_van .= abs($v->magnitude) . ", ";
    }


    foreach ($flat_hot_lanes as $c => $v) {
        //  $dato_nombre .= "'" . $v->fantasy_name . "', ";
        $dato_porcentaje_flat .= $v->magnitude . ", ";
    }


    foreach ($flat_cold_lanes as $c => $v) {
        //  $dato_nombre_abajo .= "'" . $v->fantasy_name . "', ";
        $dato_porcentaje_abajo_flat .= abs($v->magnitude) . ", ";
    }
    ?>


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
        function startCharts() {
            var element = document.getElementById('kt_apexcharts_1');
            var height = parseInt(KTUtil.css(element, 'height'));

            var element2 = document.getElementById('kt_apexcharts_2');
            var height2 = parseInt(KTUtil.css(element2, 'height'));

            var labelColor = KTUtil.getCssVariableValue('--kt-gray-800');
            var borderColor = KTUtil.getCssVariableValue('--kt-gray-200');
            var baseColor = KTUtil.getCssVariableValue('--kt-success');
            var secondaryColor = KTUtil.getCssVariableValue('--kt-danger');

            //if (!element) { return; }

            //gainers
            var options = {
                series: [{
                    name: '% Moving',
                    data: [<?php echo $dato_porcentaje_reefer; ?>]
                }],
                chart: {
                    fontFamily: 'inherit',
                    type: 'bar',
                    height: height,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        columnWidth: ['30%'],
                        endingShape: 'rounded'
                    },
                },
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: [<?php echo $dato_nombre; ?>],
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: labelColor,
                            fontSize: '12px'
                        }
                    }
                },
                fill: {
                    opacity: 1
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
                        formatter: function(val) {
                            return val + ' %'
                        }
                    }
                },
                colors: [baseColor, secondaryColor],
                grid: {
                    borderColor: borderColor,
                    strokeDashArray: 4,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    }
                }
            };
            var chart = new ApexCharts(element, options);
            chart.render();





            //decliners
            var options2 = {
                series: [{
                    name: '% moving',
                    data: [<?php echo $dato_porcentaje_abajo_reefer; ?>]
                }],
                chart: {
                    fontFamily: 'inherit',
                    type: 'bar',
                    height: height,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        columnWidth: ['30%'],
                        endingShape: 'rounded'
                    },
                },
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: [<?php echo $dato_nombre_abajo; ?>],
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: labelColor,
                            fontSize: '12px'
                        }
                    }
                },
                fill: {
                    opacity: 1
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
                        formatter: function(val) {
                            return val + ' %'
                        }
                    }
                },
                colors: [secondaryColor],
                grid: {
                    borderColor: borderColor,
                    strokeDashArray: 4,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    }
                }
            };
            var chart2 = new ApexCharts(element2, options2);
            chart2.render();


            $("#mmi_equipment_selector").on('change', function() {
                var cual = $(this).val()
                if (cual === "reefer") {
                    chart.updateSeries([{
                        data: [<?php echo $dato_porcentaje_reefer; ?>]
                    }])
                    chart2.updateSeries([{
                        data: [<?php echo $dato_porcentaje_abajo_reefer; ?>]
                    }])
                }

                if (cual === "van") {
                    chart.updateSeries([{
                        data: [<?php echo $dato_porcentaje_van; ?>]
                    }])
                    chart2.updateSeries([{
                        data: [<?php echo $dato_porcentaje_abajo_van; ?>]
                    }])
                }

                if (cual === "flat") {
                    chart.updateSeries([{
                        data: [<?php echo $dato_porcentaje_flat; ?>]
                    }])
                    chart2.updateSeries([{
                        data: [<?php echo $dato_porcentaje_abajo_flat; ?>]
                    }])
                }

            })

        }


        /*
                $("#mmi_equipment_selector").on('change', function() {
                    var cual = $(this).val()
                    if (cual === "reefer") {
                        chart.updateSeries([{
                            data: [<?php echo $dato_porcentaje_reefer; ?>]
                        }])
                        chart2.updateSeries([{
                            data: [<?php echo $dato_porcentaje_abajo_reefer; ?>]
                        }])
                    }

                    if (cual === "van") {
                        chart.updateSeries([{
                            data: [<?php echo $dato_porcentaje_van; ?>]
                        }])
                        chart2.updateSeries([{
                            data: [<?php echo $dato_porcentaje_abajo_van; ?>]
                        }])
                    }

                    if (cual === "flat") {
                        chart.updateSeries([{
                            data: [<?php echo $dato_porcentaje; ?>]
                        }])
                        chart2.updateSeries([{
                            data: [<?php echo $dato_porcentaje_abajo; ?>]
                        }])
                    }

                })
        */

        var inactivityTimeLimit = 3600000;
        var inactivityTimer;

        function startInactivityTimer() {
            console.log('entra')
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
            $(".selTheme").click(function() {
                location.reload();
            });
            startCharts();
            startInactivityTimer();
        });
        $(document).on("mousemove keypress mousedown touchstart", function() {
            resetInactivityTimer();
        });
    </script>


</body>
<!--end::Body-->

</html>