<?php
include("loginCheck.php");
include("../config.php");
include("adminClass.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo SITE_TITLE; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" href="http://lanerunner.com/app/images/new/Favicon.png">

    <!-- third party css -->
    <link href="assets/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

    <!-- App css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app-creative.min.css" rel="stylesheet" type="text/css" id="light-style" />
    <link href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" id="light-style" />
    <link rel="stylesheet" href="../app/assets/css/jquery.typeahead.min.css">
</head>

<body class="loading" data-layout="topnav" data-layout-config='{"layoutBoxed":false,"darkMode":false,"showRightSidebarOnStart": false}'>

<!-- Begin page -->
<div class="wrapper">

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">
            <!-- Topbar Start -->
            <?php include("topBar.php"); ?>
            <!-- end Topbar -->




            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <form class="form-inline" method="post" action="process_bot_data.php" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="file" accept=".csv" class="form-control form-control-light" name="bot_data">
                                        </div>
                                    </div>
                                    <button class="btn btn-info ml-2">
                                        <i class="mdi mdi-autorenew"></i>
                                    </button>
                                </form>
                            </div>
                            <h4 class="page-title">Upload file</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->



            <!-- container -->

        </div>
        <!-- content -->

        <!-- Footer Start -->
        <?php include("footer.php"); ?>
        <!-- end Footer -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->










</div>
<!-- END wrapper -->



<!-- bundle -->
<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.min.js"></script>

<!-- third party js -->

<script src="../app/assets/js/jquery.typeahead.min.js"></script>


</body>

</html>