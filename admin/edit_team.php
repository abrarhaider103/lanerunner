<?php
include("loginCheck.php");
include("../config.php");
include("adminClass.php");
extract($_GET);

$team = $adm->getThisTeam($tid);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>
        <?php echo SITE_TITLE; ?>
    </title>
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
                                    <div class="col-lg-3">&nbsp;</div>
                                    <div class="col-lg-6 ">
                                        <div class="card">
                                            <div class="card-header">
                                                Edit Team
                                            </div>
                                            <div class="card-body">
                                                <form method="post" action="ajax/customer.php">
                                                <input type="hidden" value="update_team" name="form_type">
                                                    <input type="hidden" name="tid" value="<?php echo $tid; ?>">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="userName">Team name</label>
                                                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $team->name; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                    <div class="col-lg-6">
                                                      <div class="form-group">
                                                        <label for="">Status</label>
                                                        <select name="is_active" class="form-control">
                                                            <option <?php echo $team->is_active==1?'selected':''?> value="1">Active</option>
                                                            <option <?php echo $team->is_active==2?'selected':''?> value="2">Deactive</option>
                                                        </select>
                                                     </div>
                                                    </div>
                                                    <div class="row">
                                                    <div class="col-lg-6">
                                                    <button type="submit" class="btn btn-primary mt-lg-3">Submit</button>
                                                    </div>
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


    <!-- bundle -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>

    <script>
        // $(document).ready(function() {
        //     $('#userName').on('keyup', function() {
        //         $('#password').val($(this).val());
        //     });

        // });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        $(document).ready(function() {


            // $("#btn_delete_user").on('click', function() {
            //     let quien = $(this).attr('data-id');

            //     Swal.fire({
            //         title: 'Are you sure?',
            //         text: "You won't be able to revert this!",
            //         icon: 'warning',
            //         showCancelButton: true,
            //         confirmButtonColor: '#3085d6',
            //         cancelButtonColor: '#d33',
            //         confirmButtonText: 'Yes, delete it!'
            //     }).then((result) => {
            //         if (result.isConfirmed) {
            //             window.location.href = "laner_edit_delete.php?uId=" + quien;
            //         }
            //     })

            // });
        });
    </script>
</body>

</html>