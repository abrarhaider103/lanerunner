<?php
error_reporting(1);
include("login_check.php");
include("config.php");
include("assets/php/quote_class.php");
include("assets/php/svg_class.php");


function roundToNearestMultipleOf50($number)
{
    return round($number / 50) * 50;
}

$ui = $_SESSION['customer']->customer_id;

$sql = "select * from rate_change_alert WHERE user_id = $ui;";
$lanes_abs = $quote->getThisAll($sql);

?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <?php include("includes/head.php"); ?>
    <style>
        .hidden {
            display: none;
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

                                <!--begin::Row-->
                                <div class="row g-5 g-xl-10">
                                    <!--begin::Col-->
                                    <div class="col-md-12">
                                        <!--begin::Engage widget 1-->


                                        <!--begin::Row-->
                                        <div class="row g-5 g-xl-10">
                                            <!--begin::Col price change alert -->
                                            <div class="col">
                                                <!--begin::List widget 25-->
                                                <div class="price-change">
                                                    <div class="card card-flush h-lg-100">
                                                        <!--begin::Header-->
                                                        <div class="card-header pt-7 justify-content-between">
                                                            <!--begin::Title-->
                                                            <h3 class="card-title align-items-start flex-column">
                                                                <span class="card-label fw-bold text-gray-800">RATE CHANGE ALERTS</span>
                                                                <span class="text-gray-400 mt-1 fw-semibold fs-6">Your rate notification alerts are here</span>
                                                            </h3>
                                                            <!--end::Title-->
                                                            <i class="bi bi-question-circle" style="cursor:pointer" data-bs-toggle="popover" data-bs-placement="top" title="PRICE CHANGE ALERTS" data-bs-content="The Rate Change Alerts  help shippers, brokers and carriers stay up-to-date with changes in pricing for different lanes. This section utilizes data analysis tools to track changes in rates over time and provides real-time updates on any price fluctuations. By using this feature, subscribers can make informed decisions about when to book shipments and which carriers to work with based on current market conditions. Additionally, this feature can help identify emerging trends in the market and potentially forecast future rate changes. "></i>
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
                                                                                <th class="text-center">Lane</th>
                                                                                <th class="text-center">Direct Rate</th>
                                                                                <th class="text-center">Broker Rate</th>
                                                                                <th class="text-center">24hr</th>
                                                                                <th class="text-center">Destination Email</th>
                                                                                <th class="text-center">Action</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody>

                                                                            <?php
                                                                            /*
                                                                             [destination_email] => gutibs@gmail.com
                                                                                [condition_met] => 1
                                                                                [email_sent] => 1
                                                                                                */

                                                                            foreach ($lanes_abs as $la) {
                                                                                if ((int)$la->condition_met === 1) {
                                                                                    $tr_bck = "table-danger";
                                                                                } else {
                                                                                    $tr_bck = "";
                                                                                }
                                                                            ?>
                                                                                <tr class="text-center <?php echo $tr_bck; ?>">
                                                                                    <td>
                                                                                        <?php echo $la->fantasy_name; ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <span class="text-gray-800 fw-bold me-3 d-block">$ <?php echo number_format($la->direct_rate); ?></span>
                                                                                    </td>
                                                                                    <td><span class="text-gray-800 fw-bold me-3 d-block">$<?php echo number_format($la->broker_rate); ?></span></td>
                                                                                    <td class="text-center">+ - $<?php echo $la->price_fluctuation; ?></td>
                                                                                    <td>
                                                                                        <?php echo $la->destination_email; ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class="bi bi-trash-fill text-danger fs-3 elimina_alert" data-id="<?php echo $la->alert_id; ?>"></i>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php
                                                                            }
                                                                            ?>

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <!--end::Table Price Change Alerts-->



                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                </div>
                                                <!--end::LIst widget 25-->
                                            </div>
                                            <!--end::Col price change alert -->

                                        </div>
                                        <!--end::Row-->
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            $(".elimina_alert").on('click', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, proceed',
                    cancelButtonText: 'No, cancel'
                }).then((result) => {
                    if (result.value) {
                        var cual = $(this).data('id')

                        $.ajax({
                            url: 'delete_alert.php?alert=' + cual,
                            type: 'GET',
                            success: function(response) {
                                // console.log(response)
                                // Handle the successful response
                                window.location.reload()
                            },
                            error: function(xhr, status, error) {
                                // Handle the error
                                console.log(error);
                            }
                        });
                    }
                });

            })











            $('tr.van').addClass('hidden');
            $('tr.flat').addClass('hidden');
        })

        $("#price_change_alert_selector").on('change', function() {
            if ($(this).val() === "reefer") {
                $('tr.reefer').removeClass('hidden');
                $('tr.van').addClass('hidden');
                $('tr.flat').addClass('hidden');
            }
            if ($(this).val() === "van") {
                $('tr.reefer').addClass('hidden');
                $('tr.van').removeClass('hidden');
                $('tr.flat').addClass('hidden');
            }
            if ($(this).val() === "flat") {
                $('tr.reefer').addClass('hidden');
                $('tr.van').addClass('hidden');
                $('tr.flat').removeClass('hidden');
            }
        })


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
            $(".selTheme").click(function() {
                location.reload();
            });

            startInactivityTimer();
        });
        $(document).on("mousemove keypress mousedown touchstart", function() {
            resetInactivityTimer();
        });
    </script>


</body>
<!--end::Body-->

</html>