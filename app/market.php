<?php
error_reporting(0);
include("login_check.php");
include("config.php");
include("assets/php/quote_class.php");;


$sql = "SELECT * FROM market_conditions_data WHERE id = 1";
$este = $quote->getThis1($sql);

$texto = $este->market_conditions_text;

?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <?php include("includes/head.php"); ?>

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet" type="text/css">
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
                                <div class="col-12 ql-editor" id="texto_market">
                                   <?php echo urldecode($texto); ?>
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

    const textoMarketDiv = document.getElementById("texto_market");

    // Find all <p> tags inside the div
    const paragraphsInsideTextoMarket = textoMarketDiv.querySelectorAll("p");

    // Iterate through each <p> tag to find and add the class to images
    paragraphsInsideTextoMarket.forEach((paragraph) => {
        const imagesInsideParagraph = paragraph.querySelectorAll("img");
        imagesInsideParagraph.forEach((img) => {
            img.classList.add("img-fluid");
        });
    });

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