<?php
include("loginCheck.php");
include("../config.php");
include("adminClass.php");

if(@$_GET['team_id'])
{
    $getAllCustomer = $adm->getCustomerByTeamid($_GET['team_id']);
}else{
$getAllCustomer = $adm->getAllCustomer();
}

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
                                            <div class="align-items-centre card-header d-flex justify-content-between py-3">
                                                Customers
                                                <a href="add_customer.php" class="btn btn-primary mt-lg-n2">Add
                                             </a>
                                            </div>
                                            
                                            <div class="card-body">
                                            
                                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Register Date</th>
                                                <th>Source</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>


                                        <tbody>
                            <?php
                                    foreach($getAllCustomer as $v){
                                        if($v->customer_active==1)
                                         { $active='Active';  }else{ $active='Deactive';}
                                         if($v->name!=null)
                                         { $teamname=$v->name;  
                                        }else{ $teamname='Solo';}
                                        echo <<<AAA
                                        <tr>
                                            <td>$v->customer_firstName</td>
                                            <td>$v->customer_lastName</td>
                                            <td>$v->customer_email</td>
                                            <td>$v->customer_phone</td>
                                            <td>$v->customer_registered_on</td>
                                            <td class="text-capitalize">$v->source</td>
                                            <td>$teamname</td>
                                            <td>$active</td>
                                            <td><a class="btn btn-warning" href="edit_customer.php?cId=$v->customer_id">Edit</a>-
                                            <a class="btn btn-warning btn_delete_user" id="btn_delete_user" data-id="$v->customer_id" >Delete</a></td>
                                        </tr>

                                    AAA;        
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
            <?php 
            // include("footer.php"); 
            ?>
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

    <script src="assets/js/vendor/jquery.dataTables.min.js"></script>
    <script src="assets/js/vendor/dataTables.bootstrap4.js"></script>
    <script src="assets/js/vendor/dataTables.responsive.min.js"></script>
    <script src="assets/js/vendor/responsive.bootstrap4.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        $(document).ready(function(){
            "use strict";
            $("#basic-datatable").DataTable({keys:!0,language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},
            drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")}});
            var a=$("#datatable-buttons").DataTable({lengthChange:!1,buttons:["copy","print"],language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")}});$("#selection-datatable").DataTable({select:{style:"multi"},language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")}}),a.buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"),$("#alternative-page-datatable").DataTable({pagingType:"full_numbers",drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")}}),$("#scroll-vertical-datatable").DataTable({scrollY:"350px",scrollCollapse:!0,paging:!1,language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")}}),$("#scroll-horizontal-datatable").DataTable({scrollX:!0,language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")}}),$("#complex-header-datatable").DataTable({language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},columnDefs:[{visible:!1,targets:-1}]}),$("#row-callback-datatable").DataTable({language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},createdRow:function(a,i,e){15e4<+i[5].replace(/[\$,]/g,"")&&$("td",a).eq(5).addClass("text-danger")}}),$("#state-saving-datatable").DataTable({stateSave:!0,language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")}})});

            


            $(".btn_delete_user").on('click', function(e) {
                e.preventDefault();
                console.log('ss');
                let tid = $(this).attr('data-id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "ajax/customer.php?type=cdelete&type=cdelete&cid=" + tid;
                    }
                })

            });
        </script>
</body>

</html>