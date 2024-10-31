<?php
include("loginCheck.php");
include("../config.php");
include("adminClass.php");

$sql ="SELECT * FROM states";
$states = $adm->getThisAll($sql);

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title><?php echo SITE_TITLE; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/favicon.ico">

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
                                    <h6>RATIO</h6>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="card">
                            <div class="card-header">
                                <a href="https://www.dat.com/industry-trends/trendlines/reefer/demand-and-capacity" target="_blank" class="btn btn-warning">Open reference page in new window</a>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4">&nbsp;</div>    
                                    <div class="col-lg-4">
                                        <form method="post" action="dat_ratio_save.php">
                                        <?php
                                        foreach($states as $v){
                                        echo <<<AAA
                                            <div class="form-group">
                                            <label>$v->code / $v->name</label>
                                            <input type="text" name="state-$v->id" required class="form-control" />    
                                            </div>
   
AAA;                                            
                                        }
                                        
                                        
                                        ?>
                                            <button class="btn btn-success btn-block">Save</button>
                                            </form>
                                    </div>
                                </div>
                            </div>
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

        <script src="assets/js/vendor/jquery.dataTables.min.js"></script>
        <script src="assets/js/vendor/dataTables.bootstrap4.js"></script>
        <script src="assets/js/vendor/dataTables.responsive.min.js"></script>
        <script src="assets/js/vendor/responsive.bootstrap4.min.js"></script>

        <script>

            $(document).ready(function () {
                "use strict";
                $("#basic-datatable").DataTable({keys: !0, language: {paginate: {previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>"}},
                    drawCallback: function () {
                        $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                    }});
                var a = $("#datatable-buttons").DataTable({lengthChange: !1, buttons: ["copy", "print"], language: {paginate: {previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>"}}, drawCallback: function () {
                        $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                    }});
                $("#selection-datatable").DataTable({select: {style: "multi"}, language: {paginate: {previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>"}}, drawCallback: function () {
                        $(".dataTables_paginate > .pagination").addClass("pagination-rounded")}}), a.buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"), $("#alternative-page-datatable").DataTable({pagingType: "full_numbers", drawCallback: function () {
                        $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                    }}), $("#scroll-vertical-datatable").DataTable({scrollY: "350px", scrollCollapse: !0, paging: !1, language: {paginate: {previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>"}}, drawCallback: function () {
                        $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                    }}), $("#scroll-horizontal-datatable").DataTable({scrollX: !0, language: {paginate: {previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>"}}, drawCallback: function () {
                        $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                    }}), $("#complex-header-datatable").DataTable({language: {paginate: {previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>"}}, drawCallback: function () {
                        $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                    }, columnDefs: [{visible: !1, targets: -1}]}), $("#row-callback-datatable").DataTable({language: {paginate: {previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>"}}, drawCallback: function () {
                        $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                    }, createdRow: function (a, i, e) {
                        15e4 < +i[5].replace(/[\$,]/g, "") && $("td", a).eq(5).addClass("text-danger")
                    }}), $("#state-saving-datatable").DataTable({stateSave: !0, language: {paginate: {previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>"}}, drawCallback: function () {
                        $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                    }})
            });


        </script>
    </body>

</html>