<?php
include("loginCheck.php");
include("../config.php");
include("adminClass.php");

$sql = "SELECT lane_id, fantasy_name FROM lanes WHERE 1";
$all = $adm->getThisAll($sql);


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
    <link href="../assets/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

    <!-- App css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app-creative.min.css" rel="stylesheet" type="text/css" id="light-style" />
    <link href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" id="light-style" />
    <link rel="stylesheet" href="assets/jquery.typeahead.min.css">
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
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-light" id="dash-daterange">
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-info border-info text-white">
                                                        <i class="mdi mdi-calendar-range font-13"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript: void(0);" class="btn btn-info ml-2">
                                            <i class="mdi mdi-autorenew"></i>
                                        </a>
                                    </form>
                                </div>
                                <h4 class="page-title">Dashboard</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-stripped" id="tabla">
                                    <thead>
                                        <tr>
                                            <th>Origin</th>
                                            <th>Destination</th>
                                            <th>Currently assigned to</th>
                                            <th>Assign to SM/SO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($all as $v) {
                                            /*
                                            (
            [lane_id] => 4
            [fantasy_name] => Akron, OH - Atlanta, GA (new)
            */
                                            $cit = explode(" - ", $v->fantasy_name);
                                            $origin = $cit[0];
                                            $destination = $cit[1];
                                            $lane_id = $v->lane_id;

                                            $sql = "SELECT email FROM laners a JOIN lanes_assigned b ON a.laner_id = b.laner_id WHERE b.lane_id = $lane_id";
                                            $rm = $adm->getThis1($sql);
                                            if ($rm) {
                                                $email = $rm->email;
                                            } else {
                                                $email = '';
                                            }
                                            echo "<tr>
                                                <td>$origin</td>
                                                <td>$destination</td>
                                                <td>$email</td>
                                                <td><button class='btn btn-success assign_btn' data-id='$lane_id'>Assign to SM/SO</button></td>";
                                        }
                                        ?>
                                    </tbody>


                                </table>
                            </div>
                        </div>


                    </div>







                </div>
            </div>
            <!-- container -->


            <!-- content -->

            <!-- Footer Start -->
            <?php include("footer.php"); ?>
            <!-- end Footer -->
        </div>
    </div>
    </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->



    <!-- END wrapper -->



    <!-- bundle -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>

    <!-- third party js -->

    <!-- third party js ends -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js'></script>
    <script src='//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js'></script>

    <script src="assets/jquery.typeahead.min.js"></script>

    <script>
        $(document).ready(function() {
            //   $("#results_div").hide()

            $('#tabla').DataTable();

        })

        $(".assign_btn").on('click', function() {
            const lane = $(this).data('id')



            $.ajax({
                url: 'ajax/change_lange_assignment.php',
                method: 'POST',
                data: {
                    lane: lane
                },
                success: function(response) {
                    console.log(response)

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Handle any errors that occur during the request
                    console.log(textStatus, errorThrown);
                }
            });

        })
    </script>

</body>

</html>