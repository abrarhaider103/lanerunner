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
    <!-- App css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app-creative.min.css" rel="stylesheet" type="text/css" id="light-style" />
    <link href="assets/css/app-creative-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />
</head>
<body class="loading" data-layout="topnav" data-layout-config='{"layoutBoxed":false,"darkMode":false,"showRightSidebarOnStart": true}'>
    <!-- Begin page -->
    <div class="wrapper">
        <div class="content-page">
            <div class="content">
                <!-- Topbar Start -->
                <?php include("topBar.php"); ?>
                <!-- end Topbar -->
                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="row">&nbsp;</div>
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="row">
                                    <div class="col-lg-3">&nbsp;</div>
                                    <div class="col-lg-6 ">
                                        <div class="card">
                                            <div class="card-header">
                                                New Team
                                            </div>
                                            <div class="card-body">
                                                <div class="float-right mt-xl-n5 p-2">
                                             <a href="teamlist.php" class="mt-lg-n2">Back
                                             </a></div>
                                                <form method="post" action="ajax/customer.php">
                                                    <input type="hidden" value="insert_team" name="form_type">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="userName">Team name</label>
                                                                <input type="text" class="form-control" id="name"   name="name">
                                                            </div>
                                                        </div>
                                                    
                                                      <div class="col-lg-6">
                                                    <button type="submit" class="btn btn-primary mt-lg-3">Submit</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                </div>
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


    <!-- Right Sidebar -->
    <?php include("rightBar.php"); ?>
    <!-- /Right-bar -->

    <!-- bundle -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>

    <script>
       
        </script>
</body>

</html>