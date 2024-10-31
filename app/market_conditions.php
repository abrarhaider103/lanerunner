<?php
include("login_check.php");
include("config.php");
include("assets/php/quote_class.php");

$sql = "SELECT a.inbound_flat, b.region_name, b.coordinates FROM inbound_map_data a JOIN master_regions b ON a.region_id = b.region_id WHERE b.canada= 0 ORDER BY b.region_name";
$pol_inbound_flat = $quote->getThisAll($sql);


$sql = "SELECT a.inbound_reefer, b.region_name, b.coordinates FROM inbound_map_data a JOIN master_regions b ON a.region_id = b.region_id WHERE b.canada= 0 ORDER BY b.region_name";
$pol_inbound_reefer = $quote->getThisAll($sql);

$sql = "SELECT a.inbound_van, b.region_name, b.coordinates FROM inbound_map_data a JOIN master_regions b ON a.region_id = b.region_id WHERE b.canada= 0 ORDER BY b.region_name";
$pol_inbound_van = $quote->getThisAll($sql);


$sql = "SELECT a.outbound_flat, b.region_name, b.coordinates FROM inbound_map_data a JOIN master_regions b ON a.region_id = b.region_id WHERE b.canada= 0 ORDER BY b.region_name";
$pol_outbound_flat = $quote->getThisAll($sql);


$sql = "SELECT a.outbound_reefer, b.region_name, b.coordinates FROM inbound_map_data a JOIN master_regions b ON a.region_id = b.region_id WHERE b.canada= 0 ORDER BY b.region_name";
$pol_outbound_reefer = $quote->getThisAll($sql);

$sql = "SELECT a.outbound_van, b.region_name, b.coordinates FROM inbound_map_data a JOIN master_regions b ON a.region_id = b.region_id WHERE b.canada= 0 ORDER BY b.region_name";
$pol_outbound_van = $quote->getThisAll($sql);

?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <?php include("includes/head.php"); ?>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
    <style>
        .custom-tooltip {
            background-color: #ffffff;
            border: 1px solid #cccccc;
            border-radius: 5px;
            padding: 10px;
            font-size: 20px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.3);
            text-align: center
        }
    </style>

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


                                <!--begin::Col-->
                                <div class="col-xl-12 mb-xl-12">
                                    <!--begin::List widget 10-->
                                    <div class="card card-flush h-lg-100">
                                        <!--begin::Body-->
                                        <div id="" style="">
                                            <div class="card-body">
                                                <ul class="nav nav-tabs flex-nowrap text-nowrap">
                                                    <li class="nav-item">
                                                        <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0 active" data-bs-toggle="tab" href="#kt_list_widget_10_tab_1">Inbound</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0 mapa2" data-bs-toggle="tab" href="#kt_list_widget_10_tab_2">Outbound</a>
                                                    </li>

                                                </ul>


                                                <div class="tab-content">
                                                    <div class="tab-pane fade show active" id="kt_list_widget_10_tab_1">
                                                        <div class="m-0">
                                                            <!--begin::Wrapper-->
                                                            <div class="row mt-5">
                                                                <div class="col-1">
                                                                    <select class="form-select form-select-sm text-muted" name="inbound_selector" id="inbound_selector" data-dropdown-css-class="w-150px" data-control="select2" data-hide-search="true">
                                                                        <option value="reefer" selected>Reefer</option>
                                                                        <option value="van">Van</option>
                                                                        <option value="flat">Flatbed</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">
                                                                <div id="map" style="height: 650px;"></div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="tab-pane fade" id="kt_list_widget_10_tab_2">
                                                        <div class="m-0">
                                                            <!--begin::Wrapper-->
                                                            <div class="row mt-2">
                                                                <div class="col-1">
                                                                    <select class="form-select form-select-sm text-muted" name="outbound_selector" id="outbound_selector" data-dropdown-css-class="w-150px" data-control="select2" data-hide-search="true">
                                                                        <option value="reefer" selected>Reefer</option>
                                                                        <option value="van">Van</option>
                                                                        <option value="flat">Flatbed</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div id="map2" style="height: 650px;"></div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
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
    <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>


    <script>
        const map = L.map('map', {
            dragging: false,
            scrollWheelZoom: false,
            zoomControl: false,
            keyboard: {
                pan: false
            }
        }).setView([39.8354, -94.5795], 5.2);

        const tiles = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/toner-lite/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var inbound_flat_pol = L.layerGroup([
            <?php
            foreach ($pol_inbound_flat as $c => $v) {
                if ($v->inbound_flat === "tight") {
                    $v->inbound_flat_color = "#FF0000";
                }
                if ($v->inbound_flat === "neutral") {
                    $v->inbound_flat_color = "#FFFF00";
                }
                if ($v->inbound_flat === "loose") {
                    $v->inbound_flat_color = "#229954";
                }

                echo "L.polygon([";
                $poly = explode("/", $v->coordinates);
                array_pop($poly);
                foreach ($poly as $coord) {
                    $p = explode(",", $coord);
                    $lat = $p[1];
                    $lng = $p[0];
                    $coord = $lat . ", " . $lng;
                    echo "[" . $coord . "],";
                }
                echo "], {
                    name: '" . $v->region_name . "',
                    value: '" . ucfirst($v->inbound_flat) . " Capacity',
                    fillOpacity: 0.65, 
                    fillColor: '" . $v->inbound_flat_color . "',
                    color: '" . $v->inbound_flat_color . "'}),";
            }


            ?>
        ]).addTo(map);
        inbound_flat_pol.eachLayer(function(layer) {
            layer.bindTooltip(layer.options.name + '<br>' + layer.options.value, {
                opacity: 1,
                className: 'custom-tooltip'
            });
        });



        var inbound_reefer_pol = L.layerGroup([
            <?php
            foreach ($pol_inbound_reefer as $c => $v) {
                if ($v->inbound_reefer === "tight") {
                    $v->inbound_reefer_color = "#FF0000";
                }
                if ($v->inbound_reefer === "neutral") {
                    $v->inbound_reefer_color = "#FFFF00";
                }
                if ($v->inbound_reefer === "loose") {
                    $v->inbound_reefer_color = "#229954";
                }

                echo "L.polygon([";
                $poly = explode("/", $v->coordinates);
                array_pop($poly);
                foreach ($poly as $coord) {
                    $p = explode(",", $coord);
                    $lat = $p[1];
                    $lng = $p[0];
                    $coord = $lat . ", " . $lng;
                    echo "[" . $coord . "],";
                }
                echo "], {
                    name: '" . $v->region_name . "',
                    value: '" . ucfirst($v->inbound_reefer) . " Capacity',
                    fillOpacity: 0.65, 
                    fillColor: '" . $v->inbound_reefer_color . "',
                    color: '" . $v->inbound_reefer_color . "'}),";
            }


            ?>
        ]);
        inbound_reefer_pol.eachLayer(function(layer) {
            layer.bindTooltip(layer.options.name + '<br>' + layer.options.value, {
                opacity: 1,
                className: 'custom-tooltip'
            });
        });


        var inbound_van_pol = L.layerGroup([
            <?php
            foreach ($pol_inbound_van as $c => $v) {
                if ($v->inbound_van === "tight") {
                    $v->inbound_van_color = "#FF0000";
                }
                if ($v->inbound_van === "neutral") {
                    $v->inbound_van_color = "#FFFF00";
                }
                if ($v->inbound_van === "loose") {
                    $v->inbound_van_color = "#229954";
                }

                echo "L.polygon([";
                $poly = explode("/", $v->coordinates);
                array_pop($poly);
                foreach ($poly as $coord) {
                    $p = explode(",", $coord);
                    $lat = $p[1];
                    $lng = $p[0];
                    $coord = $lat . ", " . $lng;
                    echo "[" . $coord . "],";
                }
                echo "], {
                    name: '" . $v->region_name . "',
                    value: '" . ucfirst($v->inbound_van) . " Capacity',
                    fillOpacity: 0.65, 
                    fillColor: '" . $v->inbound_van_color . "',
                    color: '" . $v->inbound_van_color . "'}),";
            }


            ?>
        ]);
        inbound_van_pol.eachLayer(function(layer) {
            layer.bindTooltip(layer.options.name + '<br>' + layer.options.value, {
                opacity: 1,
                className: 'custom-tooltip'
            });
        });

        $('#inbound_selector').on('change', function() {
            var selectedOption = $(this).val();
            if (selectedOption === "flat") {
                inbound_flat_pol.eachLayer(function(layer) {
                    layer.addTo(map);
                });
                inbound_reefer_pol.eachLayer(function(layer) {
                    layer.removeFrom(map);
                });
                inbound_van_pol.eachLayer(function(layer) {
                    layer.removeFrom(map);
                });
            }
            if (selectedOption === "reefer") {
                inbound_flat_pol.eachLayer(function(layer) {
                    layer.removeFrom(map);
                });
                inbound_reefer_pol.eachLayer(function(layer) {
                    layer.addTo(map);
                });
                inbound_van_pol.eachLayer(function(layer) {
                    layer.removeFrom(map);
                });
            }
            if (selectedOption === "van") {
                inbound_flat_pol.eachLayer(function(layer) {
                    layer.removeFrom(map);
                });
                inbound_reefer_pol.eachLayer(function(layer) {
                    layer.removeFrom(map);
                });
                inbound_van_pol.eachLayer(function(layer) {
                    layer.addTo(map);
                });
            }

        });

        /// el otro mapa ///

        const map2 = L.map('map2', {
            dragging: false,
            scrollWheelZoom: false,
            zoomControl: false,
            keyboard: {
                pan: false
            }
        }).setView([39.8354, -94.5795], 5.2);

        const tiles2 = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/toner-lite/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map2);

        var outbound_flat_pol = L.layerGroup([
            <?php
            foreach ($pol_outbound_flat as $c => $v) {
                if ($v->outbound_flat === "tight") {
                    $v->outbound_flat_color = "#FF0000";
                }
                if ($v->outbound_flat === "neutral") {
                    $v->outbound_flat_color = "#FFFF00";
                }
                if ($v->outbound_flat === "loose") {
                    $v->outbound_flat_color = "#229954";
                }

                echo "L.polygon([";
                $poly = explode("/", $v->coordinates);
                array_pop($poly);
                foreach ($poly as $coord) {
                    $p = explode(",", $coord);
                    $lat = $p[1];
                    $lng = $p[0];
                    $coord = $lat . ", " . $lng;
                    echo "[" . $coord . "],";
                }
                echo "], {
                    name: '" . $v->region_name . "',
                    value: '" . ucfirst($v->outbound_flat) . " Capacity',
                    fillOpacity: 0.65, 
                    fillColor: '" . $v->outbound_flat_color . "',
                    color: '" . $v->outbound_flat_color . "'}),";
            }


            ?>
        ]).addTo(map2);
        outbound_flat_pol.eachLayer(function(layer) {
            layer.bindTooltip(layer.options.name + '<br>' + layer.options.value, {
                opacity: 1,
                className: 'custom-tooltip'
            });
        });



        var outbound_reefer_pol = L.layerGroup([
            <?php
            foreach ($pol_outbound_reefer as $c => $v) {
                if ($v->outbound_reefer === "tight") {
                    $v->outbound_reefer_color = "#FF0000";
                }
                if ($v->outbound_reefer === "neutral") {
                    $v->outbound_reefer_color = "#FFFF00";
                }
                if ($v->outbound_reefer === "loose") {
                    $v->outbound_reefer_color = "#229954";
                }

                echo "L.polygon([";
                $poly = explode("/", $v->coordinates);
                array_pop($poly);
                foreach ($poly as $coord) {
                    $p = explode(",", $coord);
                    $lat = $p[1];
                    $lng = $p[0];
                    $coord = $lat . ", " . $lng;
                    echo "[" . $coord . "],";
                }
                echo "], {
                    name: '" . $v->region_name . "',
                    value: '" . ucfirst($v->outbound_reefer) . " Capacity',
                    fillOpacity: 0.65, 
                    fillColor: '" . $v->outbound_reefer_color . "',
                    color: '" . $v->outbound_reefer_color . "'}),";
            }


            ?>
        ]);
        outbound_reefer_pol.eachLayer(function(layer) {
            layer.bindTooltip(layer.options.name + '<br>' + layer.options.value, {
                opacity: 1,
                className: 'custom-tooltip'
            });
        });


        var outbound_van_pol = L.layerGroup([
            <?php
            foreach ($pol_outbound_van as $c => $v) {
                if ($v->outbound_van === "tight") {
                    $v->outbound_van_color = "#FF0000";
                }
                if ($v->outbound_van === "neutral") {
                    $v->outbound_van_color = "#FFFF00";
                }
                if ($v->outbound_van === "loose") {
                    $v->outbound_van_color = "#229954";
                }

                echo "L.polygon([";
                $poly = explode("/", $v->coordinates);
                array_pop($poly);
                foreach ($poly as $coord) {
                    $p = explode(",", $coord);
                    $lat = $p[1];
                    $lng = $p[0];
                    $coord = $lat . ", " . $lng;
                    echo "[" . $coord . "],";
                }
                echo "], {
                    name: '" . $v->region_name . "',
                    value: '" . ucfirst($v->outbound_van) . " Capacity',
                    fillOpacity: 0.65, 
                    fillColor: '" . $v->outbound_van_color . "',
                    color: '" . $v->outbound_van_color . "'}),";
            }


            ?>
        ]);
        outbound_van_pol.eachLayer(function(layer) {
            layer.bindTooltip(layer.options.name + '<br>' + layer.options.value, {
                opacity: 1,
                className: 'custom-tooltip'
            });
        });

        $('#outbound_selector').on('change', function() {
            var selectedOption = $(this).val();
            if (selectedOption === "flat") {
                outbound_flat_pol.eachLayer(function(layer) {
                    layer.addTo(map2);
                });
                outbound_reefer_pol.eachLayer(function(layer) {
                    layer.removeFrom(map2);
                });
                outbound_van_pol.eachLayer(function(layer) {
                    layer.removeFrom(map2);
                });
            }
            if (selectedOption === "reefer") {
                outbound_flat_pol.eachLayer(function(layer) {
                    layer.removeFrom(map2);
                });
                outbound_reefer_pol.eachLayer(function(layer) {
                    layer.addTo(map2);
                });
                outbound_van_pol.eachLayer(function(layer) {
                    layer.removeFrom(map2);
                });
            }
            if (selectedOption === "van") {
                outbound_flat_pol.eachLayer(function(layer) {
                    layer.removeFrom(map2);
                });
                outbound_reefer_pol.eachLayer(function(layer) {
                    layer.removeFrom(map2);
                });
                outbound_van_pol.eachLayer(function(layer) {
                    layer.addTo(map2);
                });
            }

        });

        /// el otro mapa ///


        var height = document.getElementById('kt_app_content_container').offsetHeight;
        document.getElementById('map').style.height = height + "px";
        document.getElementById('map2').style.height = height + "px";


        $(".mapa2").on('click', function() {
            map2.invalidateSize();
        })





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
            startInactivityTimer();
        });
        $(document).on("mousemove keypress mousedown touchstart", function() {
            resetInactivityTimer();
        });
    </script>

</body>
<!--end::Body-->

</html>