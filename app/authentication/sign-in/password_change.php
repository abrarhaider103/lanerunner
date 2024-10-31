<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <base href="../../"/>
    <?php include("../../includes/head.php"); ?>
</head>
<!--end::Head-->
<!--begin::Body-->
<body data-kt-name="good" id="kt_body" class="auth-bg app-blank">
<!--begin::Theme mode setup on page load-->
<script>var defaultThemeMode = "light";
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
    }</script>
<!--end::Theme mode setup on page load-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Authentication - Password reset -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">

        <!--begin::Aside-->
        <div class="d-flex flex-column flex-lg-row-auto bg-secondary w-xl-600px positon-xl-relative aside-header">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
                <!--begin::Header-->
                <div class="d-flex flex-row-fluid flex-center flex-column text-center p-5 p-lg-20">
                    <!--begin::Logo-->
                    <a href="https://lanerunner.com/" class="py-9 pt-lg-20">
                        <img alt="Logo" src="assets/media/logos/default.png" class="h-50px h-lg-80px"/>
                    </a>
                    <!--end::Logo-->
                    <!--begin::Title-->
                    <h1 class="d-none d-lg-block fw-bold text-black-70 fs-2qx pb-5 pb-md-10">Welcome to LaneRunner</h1>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Illustration>
                <div class="d-none d-lg-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-200px min-h-lg-350px mb-20"
                    style="background-image: url(assets/media/illustrations/sketchy-1/2.png)"></div>
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
                    <form class="form w-100" method="post" id="recupera_pass" action="authentication/sign-in/reset_pass.php">
                        <!--begin::Heading-->
                        <div class="text-center mb-10">
                            <!--begin::Title-->
                            <h1 class="text-dark mb-3">Change Password ?</h1>
                            <!--end::Title-->
                            <!--begin::Link-->
                            <div class="text-gray-400 fw-semibold fs-4">Enter your email to reset your password.</div>
                            <!--end::Link-->
                        </div>
                        <!--begin::Heading-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <label class="form-label fw-bold text-gray-900 fs-6">Email</label>
                            <input class="form-control form-control-solid" id="email_add" type="email" placeholder=""
                                   name="email"
                                   autocomplete="off"/>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                            <button id="send_form"
                                    class="btn btn-lg btn-primary fw-bold me-4">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <a href="../../settings.php" class="btn btn-lg btn-light-primary fw-bold">Cancel</a>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
            <!--begin::Footer-->
            <div class="d-flex flex-center flex-wrap fs-6 p-5 pb-0">
                <!--begin::Links-->
                <div class=" d-flex d-block">
                <p class="fw-semibold small text-black">© 2024 LaneRunner Inc.</p>
						<a href="https://lanerunner.com/privacy-policy" class="text-hover-primary fw-semibold small px-1" target="_blank">Privacy Policy</a>
                </div>
                <!--end::Links-->
            </div>
            <!--end::Footer-->
        </div>
        <!--end::Body-->

    </div>
    <!--end::Authentication - Password reset-->
</div>
<!--end::Root-->
<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="assets/plugins/global/plugins.bundle.js"></script>
<script src="assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Custom Javascript(used by this page)-->
<script>
    $(document).ready(function () {

        $("#send_form").on('click', function (e) {

            e.preventDefault()

            function isValidEmail(email) {
                // Regular expression for a valid email address
                var emailRegex = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;

                // Test the email against the regex pattern
                return emailRegex.test(email);
            }

            var email = $("#email_add").val()

            if (email.trim() === "") {
                Swal.fire({
                    text: "Sorry, the email address is blank, please try again.",
                    icon: "error",
                    confirmButtonText: "Ok, got it!",
                    customClass: {confirmButton: "btn btn-primary"},
                });
                return false
            }
            if (isValidEmail(email)) {
                $(this).submit()
            } else {
                Swal.fire({
                    text: "Sorry, the email address is not valid, please try again.",
                    icon: "error",
                    confirmButtonText: "Ok, got it!",
                    customClass: {confirmButton: "btn btn-primary"},
                });
                return false
            }

            $("#recupera_pass").submit();
        })
    })

</script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>