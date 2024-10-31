<?php

require_once('../config.php');
include("../class/class_customer.php");

$customer->storeFormValues($_POST);

$asignada = $customer->allocate_license();

//echo json_encode($asignada);

if ($asignada['error']==0) {
    header("Location:../app/index.php");
} else {
/*
"error" => 1,"message" => "Email is not registered."
"error" => 1,"message" => "Invalid credentials."
"error" => 1,"message" => "License already assigned."
"error" => 1,"message" => "Personal email already registered."
"error" => 1,"message" => "Failed inserting record."
*/
    ?>
    <!DOCTYPE html>
    <html lang="en">

        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
            <title>LaneRunner</title>
            <meta name="description" content="We are a team of professionals in logistics, software, and digital marketing transforming the way the transportation industry establishes spot market rates.">
            <!-- Fav Icon -->
            <link rel="icon" href="../images/resource/favicon.ico" type="image/x-icon">
            <!-- Google Fonts -->
            <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,300i,400,400i,500,500i,700,700i&display=swap" rel="stylesheet">
            <!-- Stylesheets -->
            <link href="../css/font-awesome-all.css" rel="stylesheet">
            <link href="../css/flaticon.css" rel="stylesheet">
            <link href="../css/owl.css" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            <link href="../css/jquery.fancybox.min.css" rel="stylesheet">
            <link href="../css/animate.css" rel="stylesheet">
            <link href="../css/imagebg.css" rel="stylesheet">
            <link href="../css/style.css" rel="stylesheet">
            <link href="../css/responsive.css" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css" rel="stylesheet">
        </head>

        <!-- page wrapper -->
        <body class="boxed_wrapper">

            <!-- preloader -->
            <div class="preloader"></div>
            <!-- preloader -->

            <!-- main header -->
            <header class="main-header home-alternate">
                <div class="outer-container">
                    <div class="container">
                        <div class="main-box clearfix">
                            <div class="logo-box pull-left">
                                <figure class="logo"><a href="index"><img src="../images/lanerunner-logo.png" alt=""></a>
                                </figure>
                            </div>
                            <div class="menu-area pull-right">
                                <!--Mobile Navigation Toggler-->
                                <div class="mobile-nav-toggler">
                                    <i class="icon-bar"></i>
                                    <i class="icon-bar"></i>
                                    <i class="icon-bar"></i>
                                </div>
                                <nav class="main-menu navbar-expand-md navbar-light">
                                    <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
                                        <ul class="navigation clearfix">
                                            <li><a href="../">Home</a></li>
                                            <li><a href="../about-us">About Us</a></li>
                                            <li><a href="../features">Features</a></li>
                                            <li><a href="../contact-us">Contact</a></li>
                                            <li><a class="menu-theme-btn-two" href="../sign-up">Sign Up</a></li>
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

                <!--sticky Header-->
                <div class="sticky-header">
                    <div class="container clearfix">
                        <figure class="logo-box"><a href="../index.html"><img src="../images/small-logo.png" alt=""></a></figure>
                        <div class="menu-area">
                            <nav class="main-menu clearfix">
                                <!--Keep This Empty / Menu will come through Javascript-->
                            </nav>
                        </div>
                    </div>
                </div>
            </header>
            <!-- main-header end -->

            <!-- Mobile Menu  -->
            <div class="mobile-menu">
                <div class="menu-backdrop"></div>
                <div class="close-btn"><i class="fas fa-times"></i></div>
                <nav class="menu-box">
                    <div class="nav-logo"><a href="../index"><img src="../images/logo.png" alt="" title=""></a></div>
                    <div class="menu-outer">
                        <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                    </div>
                    <div class="contact-info">
                        <h4>Contact Info</h4>
                        <ul>
                            <li>NDSU Research and Technology</li>
                            <li><a href="tel:+17012051374">(701) 205-1374</a></li>
                            <li><a href="mailto:info@lanerunner.com">info@lanerunner.com</a></li>
                        </ul>
                    </div>
                    <div class="social-links">
                        <ul class="clearfix">
                            <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                            <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                            <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                            <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                            <li><a href="#"><span class="fab fa-youtube"></span></a></li>
                        </ul>
                    </div>
                </nav>
            </div><!-- End Mobile Menu -->
            <!-- esto quedaria siempre para arriba -->


            <!-- Subscription - validation error -->
            <section class="our-history">
                <div class="container">
                    <div class="row">
                        <div class="col content-column">
                            <div id="content_block_53">
                                <div class="content-box wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">
                                    <div class="sec-title">
                                        <h2>Subscription - Validation error</h2>
                                    </div>
                                    <div class="row">
                                        <div class="col">

                                            <h1>We are sorry... something went wrong:</h1>
                                            <p>
                                                <?php echo $asignada['message']; ?>
                                                <br />
                                                If you have any questions, please email: info@lanerunner.com
                                                <br />
                                                <a href="./index.html">HOME</a>.
                                            </p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
            <!-- Subscription - validation error -->

            <!-- main-footer -->
            <footer class="main-footer style-five style-six">
                <div class="anim-icons">
                    <div class="icon icon-1"><img src="../images/icons/pattern-21.png" alt=""></div>
                </div>
                <div class="image-layer" style="background-color: #ffffff;"></div>
                <div class="container">
                    <div class="footer-top">
                        <div class="widget-section">
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-12 footer-column">
                                    <div class="about-widget footer-widget">
                                        <figure class="footer-logo"><a href="../index"><img src="../images/lanerunner-logo.png" alt=""></a></figure>
                                        <div class="apps-download">
                                            <h3>Download the App</h3>
                                            <div class="download-btn">
                                                <a href="#" class="app-store-btn">
                                                    <i class="fab fa-apple"></i>
                                                    <span>Coming soon to the</span>
                                                    App Store
                                                </a>
                                                <a href="https://play.google.com/store/apps/details?id=com.app.lanerunner" target="_blank" class="google-play-btn">
                                                    <i class="fab fa-android"></i>
                                                    <span>Available now on</span>
                                                    Google Play
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6 col-sm-12 footer-column">
                                    <div class="links-widget footer-widget">
                                        <h4 class="widget-title">Quick Links</h4>
                                        <div class="widget-content">
                                            <ul class="list clearfix">
                                                <li><a href="../about-us">About Us</a></li>
                                                <li><a href="../features">Features</a></li>
                                                <li><a href="../contact-us">Contact Us</a></li>
                                                <li><a href="../sign-up">Sign Up</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 footer-column">
                                    <div class="contact-widget footer-widget">
                                        <h4 class="widget-title">Contact Us</h4>
                                        <div class="widget-content">
                                            <ul class="contact-info clearfix">
                                                <li><i class="fas fa-map-marker-alt"></i> NDSU Research and Technology</li>
                                                <li><i class="fas fa-phone"></i><a href="tel:+17012051374">(701) 205-1374</a></li>
                                                <li><i class="fas fa-envelope"></i><a href="mailto:info@lanerunner.com">info@lanerunner.com</a></li>
                                            </ul>
                                        </div>
                                        <ul class="social-links clearfix">
                                <li><a href="https://www.facebook.com/lanerunnerapp/" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="https://twitter.com/lanerunnerapp" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="https://www.youtube.com/channel/UCvU-lxjQn_KDRzQ-hUn1P_Q" target="_blank"><i class="fab fa-youtube"></i></a></li>
                                <li><a href="https://www.linkedin.com/in/lanerunner" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                            </ul>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 footer-column">
                                    <div class="links-widget footer-widget">
                                        <h4 class="widget-title">Quick Facts</h4>
                                        <div class="widget-content">
                                            <ul class="list clearfix">
                                                <li>Established 2020</li>
                                                <li>Accurate</li>
                                                <li>Instant Savings</a></li>
                                                <li>First to Market</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="footer-bottom clearfix">
                        <ul class="footer-nav pull-right">
                            <li><a href="../terms-of-service">Terms of Service</a></li>
                            <li><a href="../privacy-policy">Privacy Policy</a></li>
                            <li><a href="../investors">Investors</a></li>
                        </ul>
                    </div>
                </div>
                <div class="copyright"><span id="year"></span> &copy; <a href="#">LaneRunner Inc.</a> V2.8. All Rights Reserved.</div>
            </footer>
            <!-- main-footer end -->

            <!--Scroll to top-->
            <button class="scroll-top scroll-to-target" data-target="html">
                <span class="fa fa-arrow-up"></span>
            </button>
            <script type="text/javascript">
_linkedin_partner_id = "6170834";
window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];
window._linkedin_data_partner_ids.push(_linkedin_partner_id);
</script><script type="text/javascript">
(function(l) {
if (!l){window.lintrk = function(a,b){window.lintrk.q.push([a,b])};
window.lintrk.q=[]}
var s = document.getElementsByTagName("script")[0];
var b = document.createElement("script");
b.type = "text/javascript";b.async = true;
b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js";
s.parentNode.insertBefore(b, s);})(window.lintrk);
</script>
<noscript>
<img height="1" width="1" style="display:none;" alt="" src="https://px.ads.linkedin.com/collect/?pid=6170834&fmt=gif" />
</noscript>
            <!-- jequery plugins -->
            <script src="../js/jquery.js"></script>
            <script src="../js/popper.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
            <script src="../js/owl.js"></script>
            <script src="../js/wow.js"></script>
            <script src="../js/validation.js"></script>
            <script src="../js/jquery.fancybox.js"></script>
            <script src="../js/appear.js"></script>
            <script src="../js/scrollbar.js"></script>
            <script src="../js/tilt.jquery.js"></script>
            <!-- main-js -->
            <script src="../js/script.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        </body><!-- End of .page_wrapper -->

    </html>


<?php
}
