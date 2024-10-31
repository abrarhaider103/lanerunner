<?php
include("../config.php");
include("registration_class.php");

$rp->storeFormValues($_POST);
$customer = $rp->reset_pass();

if($customer === 1){
    $mensaje = "Password has been reset";
    $link = "<a class='btn btn-success' href='index.php'>Click here to login.</a>";
}
if($customer === 2){
    $mensaje = "There has been a problem, please contact admin.";
    $link = "";
}
if($customer === 3){
    $mensaje = "Passwords provided don't match, please check";
    $link = "";
}

?>


<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Good - Bootstrap 5 HTML Asp.Net Core, Blazor, Django & Flask Admin Dashboard Template
Purchase: https://themes.getbootstrap.com/product/good-bootstrap-5-admin-dashboard-template
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
<!--begin::Head-->

<head>
    <?php include("includes/head.php"); ?>
</head>
<!--end::Head-->
<!--begin::Body-->

<body data-kt-name="good" id="kt_body" class="auth-bg app-blank">
<!--begin::Theme mode setup on page load --- modified function to show login light  -->
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
        if (localStorage.getItem("data-theme-mode") === "system") {
            localStorage.setItem("data-theme-imode", localStorage.getItem("data-theme-mode"));
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            localStorage.setItem("data-theme-mode", defaultThemeMode);
        }
        //document.documentElement.setAttribute("data-theme", themeMode);

        document.documentElement.setAttribute('data-theme', 'light');
        localStorage.setItem("data-theme-i", themeMode);
    }
</script>
<!--end::Theme mode setup on page load-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Aside-->
        <div class="d-flex flex-column flex-lg-row-auto bg-secondary w-xl-600px positon-xl-relative aside-header">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
                <!--begin::Header-->
                <div class="d-flex flex-row-fluid flex-center flex-column text-center p-5 p-lg-20">
                    <!--begin::Logo-->
                    <a href="index.php" class="py-9 pt-lg-20">
                        <img alt="Logo" src="assets/media/logos/default.png" class="h-50px h-lg-80px"/>
                    </a>
                    <!--end::Logo-->
                    <!--begin::Title-->
                    <h1 class="d-none d-lg-block fw-bold text-black-70 fs-2qx pb-5 pb-md-10">Welcome to Lanerunner.</h1>
                    <!--end::Title-->
                    <!--begin::Description-->
                    <!--p class="d-none d-lg-block fw-semibold fs-2 text-black-50">Real-Time spot market rates at your fingertips...</p-->
                    <!--end::Description-->
                </div>
                <!--end::Header-->
                <!--begin::Illustration-->
                <!--div class="d-none d-lg-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-200px min-h-lg-350px mb-20"
                    style="background-image: url(assets/media/illustrations/sketchy-1/2.png)"></div-->
                <!--end::Illustration-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--begin::Aside-->
        <!--begin::Body-->
        <div class="d-flex flex-column flex-lg-row-fluid py-10">
            <!--begin::Content-->
            <div class="d-flex flex-center flex-column flex-column-fluid">
                <!--begin::Wrapper-->
                <div class="w-lg-500px p-10 p-lg-15 mx-auto">
                    <!--begin::Form-->

                        <!--begin::Heading-->
                        <div class="text-center mb-10">
                            <!--begin::Title-->
                            <h1 class="text-dark mb-3"><?php echo $mensaje; ?></h1>
                            <!--end::Title-->
                            <!--begin::Description-->
                            <p class="d-none d-lg-block fw-semibold fs-2 text-black-50"><?php echo $link; ?></p>
                            <!--end::Description-->
                        </div>
                        <!--begin::Heading-->

                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
            <!--begin::Footer-->
            <div class="d-flex flex-center flex-wrap p-5 pb-0">
                <!--begin::Links-->
                <div class=" d-flex d-block">
                    <p class="fw-semibold small text-black">Copyright © 2024 lanerunner. All rights reserved.</p>
                    <a href="legal/privacy.php" class="text-muted text-hover-primary fw-semibold small px-1"
                       target="_blank">Privacy Policy</a>
                </div>
                <!--end::Links-->
            </div>
            <!--end::Footer-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Authentication - Sign-in-->
</div>
<!--end::Root-->


</body>

</html>

