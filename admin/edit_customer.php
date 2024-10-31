<?php
include("loginCheck.php");
include("../config.php");
include("adminClass.php");
extract($_GET);

$customer = $adm->getThisCustomer($cId);
$getAllTeam = $adm->getAllTeams();

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
                                                Edit Customer
                                            </div>
                                            <div class="card-body">
                                                <form method="post" action="ajax/customer.php">
                                                    <input type="hidden" value="update_customer" name="form_type">
                                                    <input type="hidden" value="<?php echo $cId?>" name="cid">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="userName">First name</label>
                                                                <input type="text" class="form-control" id="firstName"  value="<?php echo $customer->customer_firstName?>"  name="firstName">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="userName">Last name</label>
                                                                <input type="text" class="form-control" id="lastName"  value="<?php echo $customer->customer_lastName?>"  name="lastName">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Mobile Number</label>
                                                                <input type="text" class="form-control" value="<?php echo $customer->customer_phone?>" name="mobile_number">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Email address</label>
                                                                <input type="email" class="form-control" value="<?php echo $customer->customer_email?>" name="email">
                                                            </div>
                                                        </div>
                                                    </div>
                                                      <div class="row">
                                                         <!-- <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="fullName">Full name</label>
                                                                <input type="text" class="form-control" name="fullName">
                                                            </div>
                                                          </div>  -->
                                                        </div>
                                                        <div class="row">
                                                           <div class="col-lg-6">
                                                              <label for="fullName">Password</label>
                                                               <div class="input-group input-group-merge">
                                                                    <input type="password" id="password" class="form-control"  name="password" placeholder="Enter your password">
                                                                    <div class="input-group-append" data-password="false">
                                                                        <div class="input-group-text">
                                                                            <span class="password-eye"></span>
                                                                     </div>
                                                                 </div>
                                                            </div>
                                                         </div>
                                                      
                                                         <div class="col-lg-6">
                                                            <div class="form-group">
                                                                 <label for="fullName">Associated team</label>
                                                                    <select name="team_id" class="form-control">
                                                                        <option value="">Solo</option>
                                                                        <?php foreach($getAllTeam as $teams){?>
                                                                        <option <?php echo  $teams->id==$customer->team_id?'selected':''?> value="<?php echo  $teams->id?>"><?php echo  $teams->name?></option>
                                                                        <?php }?>
                                                                 </select>
                                                            </div>
                                                          </div> 
                                                      
                                                     
                                                     <div class="col-lg-6">
                                                      <div class="form-group">
                                                        <label for="fullName">Status</label>
                                                        <select name="customer_active" class="form-control">
                                                            <option <?php echo $customer->customer_active==1?'selected':''?> value="1">Active</option>
                                                            <option <?php echo $customer->customer_active==2?'selected':''?> value="2">Deactive</option>
                                                        </select>
                                                     </div>
                                                                        </div>
                                                     <div class="col-lg-6">
                                                      <div class="form-group">               
                                                    <button type="submit" class="btn btn-primary mt-xl-3">Submit</button>
                                                        </div></div>
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
        $( document ).ready(function() {

            $('#firstName').on('keyup', function() {
              $('#password').val($(this).val());
            
            });
        });
        </script>
</body>

</html>