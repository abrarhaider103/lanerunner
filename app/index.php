<!DOCTYPE html>
<!--
https://www.codehim.com/text-input/jquery-password-strength-meter-with-bootstrap/
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
						<a href="https://app.lanerunner.com/" class="py-9 pt-lg-20">
							<img alt="Logo" src="assets/media/logos/default.png" class="h-50px h-lg-80px" />
						</a>
						<!--end::Logo-->
						<!--begin::Title-->
						<h1 class="d-none d-lg-block fw-bold text-black-70 fs-2qx pb-5 pb-md-10">Welcome to LaneRunner</h1>
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
						<form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="post" action="login_do.php">
							<!--begin::Heading-->
							<div class="text-center mb-10">
								<!--begin::Title-->
								<h1 class="text-dark mb-3">Log in</h1>
								<!--end::Title-->
								<!--begin::Description-->
								<p class="d-none d-lg-block fw-semibold fs-2 text-black-50">to continue to your account</p>
								<!--end::Description-->
							</div>
							<!--begin::Heading-->
							<!--begin::Input group-->
							<div class="fv-row mb-3">
								<!--begin::Label-->
								<label class="form-label fs-6 fw-bold text-dark">Email</label>
								<!--end::Label-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid" type="text" id="customer_email" name="customer_email" autocomplete="off" />
								<!--end::Input-->
							</div>
							<!--end::Input group-->

							<!--begin::Input group-->
							<div class="fv-row mb-3">
								<div class="form-check">
									<input type="checkbox" class="form-check-input" id="dropdownCheck">
									<label class="form-check-label text-dark" for="dropdownCheck">Remember me</label>
								</div>
							</div>
							<!--end::Input group-->

							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Wrapper-->
								<div class="d-flex flex-stack mb-2">
									<!--begin::Label-->
									<label class="form-label fw-bold text-dark fs-6 mb-0">Password</label>
									<!--end::Label-->
									<!--begin::Link-->
									<a href="authentication/sign-in/password-reset.php" class="link-primary fs-6 fw-bold">Reset Password</a>
									<!--end::Link-->
								</div>
								<!--end::Wrapper-->
								<!--begin::Input wrapper-->
								<div class="position-relative mb-3">
									<input class="form-control form-control-lg form-control-solid" type="password" placeholder="" id="customer_password" name="customer_password" />
									<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2">
										<i class="bi bi-eye-slash fs-2" id="togglePassword"></i>
										<i class="bi bi-eye fs-2 d-none"></i>
									</span>
								</div>
								<!--end::Input wrapper-->
							</div>
							<!--end::Input group-->
							<!--begin::Actions-->
							<div class="text-center">
								<!--begin::Submit button-->
								<button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
									<span class="indicator-label">LOG IN</span>
									<span class="indicator-progress">Please wait...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								</button>
								<!--end::Submit button-->

							</div>
							<!--end::Actions-->
							<div class="d-flex flex-center flex-wrap fs-6 p-5 pb-0">
								<!--begin::Links-->
								<div class="d-flex fw-semibold fs-6">
									<p class="text-black">By continuing you agree to our
										<!--a href="legal/terms.php" class="text-hover-primary px-1" target="_blank">Terms and conditions</a-->
										<a href="https://lanerunner.com/terms-of-service" class="text-hover-primary px-1" data-bs-toggle="" data-bs-target="" target="_blank">Terms of Service</a>
									</p>
								</div>
								<div class="d-flex fw-semibold fs-6">
									<p class="text-black">Don't have an account? <a href="https://lanerunner.com/subscription/" class="text-hover-primary px-1" data-bs-toggle="" data-bs-target="" target="_blank">Sign Up Here</a>
									</p>
								</div>
								<div class="d-flex fw-semibold fs-6">
									<p class="text-black">Need Help? <a href="https://lanerunner.com/contact-us" class="text-hover-primary px-1" data-bs-toggle="" data-bs-target="" target="_blank">Contact Us</a>
									</p>
								</div>
								<!--end::Links-->
							</div>
						</form>
						<!--end::Form-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Content-->
				<!--begin::Footer-->
				<div class="d-flex flex-center flex-wrap p-5 pb-0">
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
		<!--end::Authentication - Sign-in-->
	</div>
	<!--end::Root-->


	<!--begin::Modals-->
	<!--begin::Modal - Terms and conditions-->
	<div class="modal fade" id="kt_modal_terms" tabindex="-1" aria-hidden="true">
		<!--begin::Modal header-->
		<div class="modal-dialog modal-dialog-centered mw-650px">
			<!--begin::Modal content-->
			<div class="modal-content">
				<!--begin::Modal header-->
				<div class="modal-header flex-stack">
					<!--begin::Title-->
					<h2>Terms and Conditions</h2>
					<!--end::Title-->
					<!--begin::Close-->
					<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
						<span class="svg-icon svg-icon-1">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
								<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
							</svg>
						</span>
						<!--end::Svg Icon-->
					</div>
					<!--end::Close-->
				</div>
				<!--begin::Modal header-->
				<!--begin::Modal body-->
				<div class="modal-body scroll-y pt-10 pb-15 px-lg-17">
					<!--begin::Options-->
					<div data-kt-element="options">
						<!--begin::Notice-->
						<p class="text-muted fs-5 fw-semibold mb-10">Text.</p>
						<!--end::Notice-->
						<!--begin::Action-->
						<button class="btn btn-primary w-100" data-bs-dismiss="modal">Continue</button>
						<!--end::Action-->
					</div>
					<!--end::Options-->
				</div>
				<!--begin::Modal body-->
			</div>
			<!--end::Modal content-->
		</div>
		<!--end::Modal header-->
	</div>
	<!--end::Modal - Terms and conditions-->
	<!--end::Modals -->



	<!--begin::Javascript-->
	<script>
		var hostUrl = "assets/";
	</script>
	<!--begin::Global Javascript Bundle(used by all pages)-->
	<script src="assets/plugins/global/plugins.bundle.js"></script>
	<script src="assets/js/scripts.bundle.js"></script>
	<!--end::Global Javascript Bundle-->


	<script>
		<?php
		if (isset($_GET['e']) && $_GET['e'] === "1") {
		?>
			Swal.fire({
				html: "<b>Error: Authentication Failed.</b>" +
                    "<br>Sorry, the username or password you entered is incorrect. " +
                    "Make sure you've entered your username and password correctly." +
                    "<br><br>If you've forgotten your password, <a href='authentication/sign-in/password-reset.php'>click here</a> to reset it. "+
                    "For further assistance, please <a href='mailto:support@lanerunner.com'>contact support</a>.",
				icon: "error",
				buttonsStyling: !1,
				confirmButtonText: "Ok, got it!",
				customClass: {
					confirmButton: "btn btn-primary btn-active"
				},
			});
		<?php
		}

        if (isset($_GET['e']) && $_GET['e'] === "2") { ?>
        Swal.fire({
            html: "<b>Error: Inactive User.</b>" +
                "<br><br>Your account has been disabled. <br><br>" +
                "For further assistance, please <a href='mailto:support@lanerunner.com'>contact support</a>.",
            icon: "error",
            buttonsStyling: !1,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary btn-active"
            },
        });
        <?php
        }
		?>


		const togglePassword = document.querySelector('#togglePassword');

		const password = document.querySelector('#customer_password');

		togglePassword.addEventListener('click', () => {
			// Toggle the type attribute using  getAttribure() method
			const type = password
				.getAttribute('type') === 'password' ?
				'text' : 'password';
			password.setAttribute('type', type);
			// Toggle the eye and bi-eye icon
			this.classList.toggle('bi-eye-slash');
		});


		$('#kt_sign_in_form').on('submit', function() {
			if ($('#dropdownCheck').is(':checked')) {
				// save username and password
				localStorage.setItem('userName', $('#customer_email').val());
				localStorage.setItem('customer_password', $('#customer_password').val());
				localStorage.setItem('checkBoxValidation', 1);
			} else {
				localStorage.removeItem('checkBoxValidation');
				localStorage.removeItem('userName');
				localStorage.removeItem('customer_password');
			}
			//Other form functions
		});

		$(document).ready(function() {
			if (localStorage.getItem('checkBoxValidation') !== null) {
				$('#customer_email').val(localStorage.getItem('userName'))
				$('#customer_password').val(localStorage.getItem('customer_password'))
				$('#dropdownCheck').prop('checked', true);

			}

		})
	</script>

	<!--end::Custom Javascript-->
	<!-- end::Javascript -->

	<!--end::Body-->

</body>

</html>