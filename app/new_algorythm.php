<?php
include("login_check.php");
include("config.php");
include("assets/php/quote_class.php");
include("assets/php/svg_class.php");

$sql = "SELECT region_id, region_name FROM master_regions";
$re = $quote->getThisAll($sql);

$regions = '';
foreach ($re as $v) {
    $regions .= '"' . $v->region_name . '", ';
}
$regions = substr($regions, 0, -2);

$ci = $_SESSION['customer']->customer_id;


$sql = 'SELECT population, CONCAT(city,", ",state_id) as city FROM uscities order by population DESC';
$all_c = $quote->getThisAll($sql);

?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <?php include("includes/head.php"); ?>

    <link rel="stylesheet" href="assets/css/jquery.typeahead.min.css">
    <link href="assets/apex.css" rel="stylesheet" type="text/css" />


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <style>
        .history-records:hover {
            /*border-radius: 4px;*/
            border-top: 1px solid grey;
            border-bottom: 1px solid grey !important;
            /*box-shadow: 0px 9px 4px -6px grey;*/
            background-color: var(--kt-highlight-tr);
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
                                <!-- the content -->


                                <div class="row g-5 g-xl-10">
                                    <!--begin::Col-->
                                    <div class="col">
                                        <!--begin::List widget 10-->
                                        <div class="card card-flush h-lg-100">
                                            <!--begin::Header-->

                                            <div class="row">
                                                <div class="card-header pt-7">
                                                    <div class="col-12">
                                                        <!--begin::Title-->
                                                        <h3 class="card-title">
                                                            <span class="card-label fw-bold text-gray-800">Search #</span>
                                                        </h3>
                                                        <!--end::Title-->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="card-header pt-7">
                                                    <div class="col-12">
                                                        <div class="typeahead__container">
                                                            <label for="exampleFormControlInput1" class="required form-label">Origin</label>
                                                            <div class="typeahead__field">
                                                                <div class="typeahead__query">
                                                                    <input class="form-control form-control-solid js-typeahead-country_v1" id="origin" placeholder="Search" autocomplete="off">
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mt-2">
                                                        <div class="typeahead__container">
                                                            <label for="exampleFormControlInput1" class="required form-label">Destination</label>
                                                            <div class="typeahead__field">
                                                                <div class="typeahead__query">
                                                                    <input class="form-control form-control-solid js-typeahead-country_v1" id="destination" placeholder="Search" autocomplete="off">
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-10">
                                                            <label for="exampleFormControlInput1" class="required form-label">Equipment</label>
                                                            <select class="form-select" id="equipment">
                                                                <option value="">Select</option>
                                                                <option value="reefer" selected>Reefer</option>
                                                                <option disabled value="van">Van</option>
                                                                <option disabled value="flat">Flatbed</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-10 text-end">
                                                            <button type="button" role="button" class="btn btn-primary" id="search_btn">Search</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Header-->

                                        </div>
                                    </div>
                                    <!-- end col -->





                                </div>

                                <div class="row g-5" id="res_div">

                                </div>

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
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="assets/plugins/custom/vis-timeline/vis-timeline.bundle.js"></script>

    <!--end::Vendors Javascript-->


    <!--begin::Custom Javascript(used by this page)-->
    <script src="assets/js/widgets.bundle.js"></script>
    <script src="assets/js/custom/widgets.js"></script>
    <script src="assets/js/jquery.typeahead.min.js"></script>


    <!--end::Javascript-->




    <script type="text/javascript">
       

        $("#search_btn").on('click', function() {

            var origin_1 = $("#origin").val()
            var destination_1 = $("#destination").val()
            var equipment_1 = $("#equipment").val()

            if (origin_1 !== '' && destination_1 !== '' && equipment_1 !== '') {
                send_rate_request(origin_1, destination_1, equipment_1, 1)
            }
        })








        function send_rate_request(origin, destination, equipment, col) {

            var data = {
                origin: origin,
                destination: destination,
                equipment: equipment
            }

            $.ajax({
                url: 'ajax/make_quote_2.php',
                //dataType: 'json',
                type: 'POST',
                data: data,
                success: function(data) {

                    $("#res_div").html(data)
                    console.log(data)
               








                },
                error: function() {
                    alert('Error loading data!');
                }
            });




        }




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


    </script>


</body>
<!--end::Body-->

</html>