<?php
include("loginCheck.php");
include("../config.php");
include("adminClass.php");

$all_lanes = $adm->get_all_lanes();

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

    <link href="assets/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/vendor/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
</head>

<body class="loading" data-layout="topnav" data-layout-config='{"layoutBoxed":false,"darkMode":false,"showRightSidebarOnStart": true}'>
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
                    <div class="row">&nbsp;</div>
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="row">
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-header">
                                                All Lanes
                                            </div>
                                            <div class="card-body">
                                                <form method="post" action="regions_assigned_assign_save.php" id="form_regions">
                                                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                                        <thead>
                                                            <tr>
                                                                <th>Fantasy Name</th>
                                                                <th>Origin</th>
                                                                <th>Destination</th>
                                                                <th>Current Price</th>
                                                                <th>View Details</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                           
                                                            $eus = "";
                                                            foreach ($all_lanes as $v) {

                                                                echo '<tr>
            <td>' . $v->fantasy_name . '</td>
            <td>' . $v->origin . '</td>
            <td>' . $v->destination . '</td>
            <td>' . $v->lane_cost . '</td>
            <td><a class="btn btn-success" href="lane_details.php?lane_id=' . $v->lane_id . '">View</a></td>
            </tr>';
                                                            }
                                                            ?>


                                                        </tbody>
                                                    </table>



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


    <!-- bundle -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/vendor/jquery.dataTables.min.js"></script>
    <script src="assets/js/vendor/dataTables.bootstrap4.js"></script>
    <script src="assets/js/vendor/dataTables.responsive.min.js"></script>
    <script src="assets/js/vendor/responsive.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            
            $("#basic-datatable").DataTable({
  "pageLength": 25
});     

        });
    </script>
</body>

</html>