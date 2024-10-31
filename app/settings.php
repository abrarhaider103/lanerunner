<?php
error_reporting(0);
include("login_check.php");
include("config.php");
include("../class/class_customer.php");


$user = $customer->traer_este_customer();



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
                                
                                <?php /*
                                    <!--begin::Row-->
                                    <div class="row gy-5 g-xl-10">
                                        <!--begin::Col-->
                                        <div class="col-xl-12 col-xxl-8 mb-5 mb-xl-10">
                                            <!--begin::Layout-->
                                            <div class="flex-md-row-fluid ms-lg-12">
                                                <!--begin::Overview-->
                                                <div class="card mb-5 mb-xl-10" id="kt_account_settings_overview" data-kt-scroll-offset="{default: 100, md: 125}">
                                                    <!--begin::Card header-->
                                                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_overview">
                                                        <div class="card-title">
                                                            <h3 class="fw-bold m-0">Overview</h3>
                                                        </div>
                                                    </div>
                                                    <!--end::Card header-->
                                                    <!--begin::Content-->
                                                    <div id="kt_account_settings_overview" class="collapse show">
                                                        <!--begin::Card body-->
                                                        <div class="card-body border-top p-9">
                                                            <div class="d-flex align-items-start flex-wrap">
                                                                <div class="d-flex flex-wrap">
                                                                    <!--begin::Avatar-->
                                                                    <div class="symbol symbol-125px mb-7 me-7 position-relative">
                                                                        <img src="assets/media/avatars/300-1.jpg" alt="image" />
                                                                    </div>
                                                                    <!--end::Avatar-->
                                                                    <!--begin::Profile-->
                                                                    <div class="d-flex flex-column">
                                                                        <div class="fs-2 fw-bold mb-1"><?php echo $_SESSION['customer']->customer_firstName;?></div>
                                                                        <a href="#" class="text-gray-400 text-hover-primary fs-6 fw-semibold mb-5"><?php echo $_SESSION['customer']->customer_email;?></a>
                                                                        <div class="badge badge-light-success text-success fw-bold fs-7 me-auto mb-3 px-4 py-3">Default</div>
                                                                    </div>
                                                                    <!--end::Profile-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--end::Card body-->
                                                    </div>
                                                    <!--end::Content-->
                                                </div>
                                                <!--end::Overview-->
                                            </div>
                                            <!--end::Layout-->
                                        </div>
										<!--end::Col-->
                                    </div>
									<!--end::Row-->
                                */?>


                                    <!--begin::Row-->
                                    <div class="row gy-5 g-xl-10">
                                        <!--begin::Col-->
                                        <div class="col-xl-12 col-xxl-8 mb-5 mb-xl-10">
                                            <!--begin::Layout-->
                                            <div class="flex-md-row-fluid ms-lg-12">
                                                <!--begin::List widget 10-->
                                                <div class="card card-flush h-lg-100">
                                                    <!--begin::Header-->
                                                    <div class="card-header pt-7 d-block bg-light">
                                                        <!--begin::Title-->
                                                        <div class="card-title">
                                                            <h3 class="fw-bold m-0">Overview</h3>
                                                        </div>                                                        
                                                        <!--end::Title-->
                                                        <!--begin::Separator-->
                                                        <div class="separator separator-bordered my-6"></div>
                                                        <!--end::Separator-->
                                                        <!--begin::Content-->
                                                        <div id="kt_account_settings_overview" class="collapse show">                                                        
                                                            <div class="">
                                                                <div class="d-flex flex-wrap">
                                                                    <!--begin::Avatar-->
                                                                    <div class="symbol symbol-125px mb-7 me-7 position-relative">
                                                               <!--         <img src="assets/media/avatars/300-1.jpg" alt="image" /> -->
                                                                    </div>
                                                                    <!--end::Avatar-->
                                                                    <!--begin::Profile-->
                                                                    <div class="d-flex flex-column">
                                                                        <div class="fs-2 fw-bold mb-1"><?php echo $_SESSION['customer']->customer_firstName . ' ' . $_SESSION['customer']->customer_lastName ;?></div>
                                                                        <a href="#" class="text-gray-400 text-hover-primary fs-6 fw-semibold mb-5"><?php echo $_SESSION['customer']->customer_email;?></a>
                                                                        <!-- <div class="badge badge-light-success text-success fw-bold fs-7 me-auto mb-3 px-4 py-3">Default</div> -->
                                                                    </div>
                                                                    <!--end::Profile-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--end::Content-->
                                                    </div>
                                                    <!--end::Header-->
                                                    <!--begin::Body-->
                                                    <div class="card-body">

                                                        <!--begin::Nav-->
                                                        <ul class="nav nav-pills nav-pills-custom row position-relative mx-0 mb-9">
                                                            <!--begin::Item-->
                                                            <li class="nav-item col-6 mx-0 p-0">
                                                                <!--begin::Link-->
                                                                <a class="nav-link active d-flex justify-content-center w-100 border-0 h-100" data-bs-toggle="pill" href="#kt_list_widget_10_tab_1">
                                                                    <!--begin::Subtitle-->
                                                                    <span class="nav-text text-gray-800 fw-bold fs-6 mb-3">My Profile</span>
                                                                    <!--end::Subtitle-->
                                                                    <!--begin::Bullet-->
                                                                    <span class="bullet-custom position-absolute z-index-2 bottom-0 w-100 h-4px bg-primary rounded"></span>
                                                                    <!--end::Bullet-->
                                                                </a>
                                                                <!--end::Link-->
                                                            </li>
                                                            <!--end::Item-->
                                                            <?php /*
                                                            <!--begin::Item-->
                                                            <li class="nav-item col-4 mx-0 px-0">
                                                                <!--begin::Link-->
                                                                <a class="nav-link d-flex justify-content-center w-100 border-0 h-100" data-bs-toggle="pill" href="#kt_list_widget_10_tab_2">
                                                                    <!--begin::Subtitle-->
                                                                    <span class="nav-text text-gray-800 fw-bold fs-6 mb-3">My Alarms</span>
                                                                    <!--end::Subtitle-->
                                                                    <!--begin::Bullet-->
                                                                    <span class="bullet-custom position-absolute z-index-2 bottom-0 w-100 h-4px bg-primary rounded"></span>
                                                                    <!--end::Bullet-->
                                                                </a>
                                                                <!--end::Link-->
                                                            </li>
                                                            <!--end::Item-->
                                                            */?>
                                                            <!--begin::Item-->
                                                            
                                                            <li class="nav-item col-6 mx-0 px-0">
                                                                <a class="nav-link d-flex justify-content-center w-100 border-0 h-100" data-bs-toggle="pill" href="#kt_list_widget_10_tab_3">
                                                                    <span class="nav-text text-gray-800 fw-bold fs-6 mb-3">My Subscription</span>
                                                                    <span class="bullet-custom position-absolute z-index-2 bottom-0 w-100 h-4px bg-primary rounded"></span>
                                                                </a>
                                                            </li>
                                                            
                                                            <!--end::Item-->
                                                            <!--begin::Bullet-->
                                                            <span class="position-absolute z-index-1 bottom-0 w-100 h-4px bg-light rounded"></span>
                                                            <!--end::Bullet-->
                                                        </ul>
                                                        <!--end::Nav-->

                                                        <!--begin::Tab Content-->
                                                        <div class="tab-content">

                                                            <!--begin::Tap pane ------ My Profile  ------->
                                                            <div class="tab-pane fade show active" id="kt_list_widget_10_tab_1">
                                                                <!--begin::Item-->
                                                                <div class="m-0">
                                                                    <!--begin::Basic info-->                                                
                                                                    <h3 class="fw-bold m-0">Profile Details</h3>                                                      
                                                                        <!--begin::Content-->
                                                                        <div id="kt_account_settings_profile_details" class="collapse show">
                                                                            <!--begin::Form-->
                                                                            <form id="kt_account_profile_details_form" class="form">
                                                                                <!--begin::Card body-->
                                                                                <div class="card-body border-top p-9">
                                                                                    <!--begin::Input group-->
                                                                                    
                                                                                    <!--begin::Input group-->
                                                                                    <div class="row mb-6">
                                                                                        <!--begin::Label-->
                                                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">First Name</label>
                                                                                        <!--end::Label-->
                                                                                        <!--begin::Col-->                                                                            
                                                                                        <div class="col-lg-8 fv-row">
                                                                                            <input type="text" id="firstName" name="firstName" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="First Name" value="<?php echo $_SESSION['customer']->customer_firstName;?>" />
                                                                                        </div>                                                                            
                                                                                        <!--end::Col-->
                                                                                    </div>
                                                                                    <!--end::Input group-->
                                                                                    <!--begin::Input group-->
                                                                                    <div class="row mb-6">
                                                                                        <!--begin::Label-->
                                                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Last Name</label>
                                                                                        <!--end::Label-->
                                                                                        <!--begin::Col-->                                                                            
                                                                                        <div class="col-lg-8 fv-row">
                                                                                            <input type="text" id="lastName" name="lastName" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Last Name" value="<?php echo $_SESSION['customer']->customer_lastName;?>" />
                                                                                        </div>                                                                            
                                                                                        <!--end::Col-->
                                                                                    </div>
                                                                                    <!--end::Input group-->
                                                                                    <!--begin::Input group-->
                                                                                    <div class="row mb-6">
                                                                                        <!--begin::Label-->
                                                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                                                            <span class="required">Contact Phone</span>
                                                                                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Phone number must be active"></i>
                                                                                        </label>
                                                                                        <!--end::Label-->
                                                                                        <!--begin::Col-->
                                                                                        <div class="col-lg-8 fv-row">
                                                                                            <!--input type="tel" name="phone" class="form-control form-control-lg form-control-solid" placeholder="Phone number" value="044 3276 454 935" /-->
                                                                                            <input type="tel" id="phone" name="phone" class="form-control form-control-lg form-control-solid" placeholder="Phone number" value="<?php echo $user->customer_phone;?>" />
                                                                                        </div>
                                                                                        <!--end::Col-->
                                                                                    </div>
                                                                                    <!--end::Input group-->
                                                                                    <!--begin::Input group-->
                                                                                    <div class="row mb-6">
                                                                                        <!--begin::Label-->
                                                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Email</label>
                                                                                        <!--end::Label-->
                                                                                        <!--begin::Col-->
                                                                                        <div class="col-lg-8 fv-row">
                                                                                            <input type="email" id="email" name="email" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Email" value="<?php echo $_SESSION['customer']->customer_email;?>" />
                                                                                        </div>
                                                                                        <!--end::Col-->
                                                                                    </div>
                                                                                    <!--end::Input group-->

                                                                                    <!--begin::Input group-->
                                                                                    <div class="row mb-6">
                                                                                        <!--begin::Label-->
                                                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Password</label>
                                                                                        <!--end::Label-->
                                                                                        <!--begin::Col-->
                                                                                        <div class="col-lg-8 fv-row">
                                                                                            <!--
                                                                                            <div class="input-group">
                                                                                            <input type="password" id="password" name="password" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Password" value="<?php echo $user->pass;?>" >
                                                                                                <div class="input-group-append">
                                                                                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility()"><i class="bi bi-eye-fill"></i></button>
                                                                                                </div>
                                                                                            </div>
                                                                                            -->
                                                                                            <button type="button" role="button" class="btn btn-secondary" id="change_password_btn">Change Password</button>
                                                                                        </div>
                                                                                        <!--end::Col-->
                                                                                    </div>
                                                                                    <!--end::Input group-->
                                                                                </div>
                                                                                <!--end::Card body-->
                                                                                <!--begin::Actions-->
                                                                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                                                    <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save Changes</button>
                                                                                </div>
                                                                                <!--end::Actions-->
                                                                            </form>
                                                                            <!--end::Form-->
                                                                        </div>
                                                                        <!--end::Content-->                                                                    
                                                                    <!--end::Basic info-->                                                                  
                                                                </div>
                                                                <!--end::Item-->
                                                            </div>
                                                            <!--end::Tap pane-->


                                                            <!--begin::Tap pane ------ My Subscriptions  ------->
                                                            <div class="tab-pane fade" id="kt_list_widget_10_tab_3">
                                                                <!--begin::Item-->
                                                                <div class="m-0">
                                                                    <!--begin::Wrapper-->
                                                                    <div class="d-flex align-items-sm-center mb-5">
                                                                        <h3 class="fw-bold m-0">Subscriptions</h3>    
                                                                        </div>                                                  
                                                                        <!--begin::Content-->
                                                                            <div class="card-body border-top p-9">
                                                                                <h3> To Cancel Your Subscription Please Contact </br> <a href="mailto:support@lanerunner.com"><span class="text-primary">support@lanerunner.com</span></a>.</h3>
                                                                            </div>
                                                                        <!--?php
                                                                            if((int)$user->is_solo === 1){
                                                                                echo '
                                                                                <div class="card-body border-top p-9">
                                                                                you are using a soloer plan
                                                                                </div>';
                                                                            } else {
                                                                                echo '
                                                                                <div class="card-body border-top p-9">
                                                                            <h3> User Accounts are not allowed to access this page. <br><br>Please contact your account administrator or call support at 970 673 5526 for assistance.
                                                                                </h3>
                                                                                </div>';
                                                                            }
                                                                        ?-->

                                                                              
                                                                        <!--end::Content--> 
                                                                   
                                                                    <!--end::Wrapper-->
                                                                </div>
                                                                <!--end::Item-->
                                                            </div>
                                                            <!--end::Tap pane-->
                                                        </div>
                                                        <!--end::Tab Content-->
                                                    </div>
                                                    <!--end: Card Body-->
                                                </div>
                                                <!--end::List widget 10-->

                                            </div>   
                                            <!--end::Layout-->
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
    <script>var hostUrl = "assets/";</script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <script src="assets/js/lanerunner.js"></script>
    <!--end::Global Javascript Bundle-->

    <!--begin::Vendors Javascript(used by this page)-->
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Vendors Javascript-->

    <!--begin::Custom Javascript(used by this page)-->
    <script src="assets/js/custom/account/settings/signin-methods.js"></script>
    <script src="assets/js/custom/account/settings/profile-details.js"></script>
    <script src="assets/js/custom/account/settings/deactivate-account.js"></script>
    <script src="assets/js/widgets.bundle.js"></script>
    <script src="assets/js/custom/widgets.js"></script>
    <script src="assets/js/custom/apps/chat/chat.js"></script>
    <script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->


    <script>




        $(document).ready(function() {

        $("#change_password_btn").on('click', function(){
            Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to proceed?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                    // The user clicked "Yes", perform the action here
                    location.href='../authentication/sign-in/password_change.php'
                } else {
                    // The user clicked "No" or closed the dialog

                }
            });
        })



            $('#kt_account_profile_details_submit').click(function(e) {
                e.preventDefault();

                var firstName = $('#firstName').val();
                var lastName = $('#lastName').val();
                var phone = $('#phone').val();


                if (firstName.trim() === '' || lastName.trim() === '' || phone.trim() === '' ) {
                    Swal.fire("Oops...", "Something went wrong.  Please fill in all fields", "error");
                    return;
                }

                $.ajax({
                url: 'settings_save.php',
                data: $('#kt_account_profile_details_form').serialize(),
                type: 'POST',
                success: function(data) {
                    console.log(data);
                    Swal.fire({
                                    title: 'Thanks!',
                                    text: 'Your information has been saved.',
                                    icon: 'success',
                                    customClass: {
                                                    confirmButton: 'custom-button-class'
                                                 }
                                });
                },
                error: function(data) {
                    Swal.fire("Oops...", "Something went wrong :(", "error");
                }
                });
            });
        });
    </script>

</body>
<!--end::Body-->

</html>