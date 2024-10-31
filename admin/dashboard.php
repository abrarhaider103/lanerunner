<?php
include("loginCheck.php");
include("../config.php");
include("adminClass.php");

$sql = "SELECT * FROM master_regions WHERE 1";

$pol = $adm->getThisAll($sql);

$sql = "SELECT * FROM load_counts WHERE 1";
$ta = $adm->getThis1($sql);


/*
$sql = "SELECT a.*, b.region_name FROM inbound_map_data a JOIN master_regions b ON a.region_id = b.region_id WHERE b.canada= 0 ORDER BY b.region_name";
$regions = $adm->get_this_all($sql);
*/


$sql = "SELECT region_id, region_name FROM master_regions ORDER BY region_name";
$re = $adm->getThisAll($sql);

$regions = '';
foreach ($re as $v) {
    $regions .= '<option value="' . $v->region_id . '">' . $v->region_name . '</option>';
}


$sql = 'SELECT population, CONCAT(city,", ",state_id) as city FROM uscities order by population DESC';
$all_c = $adm->getThisAll($sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo SITE_TITLE; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <!--link rel="shortcut icon" href="http://lanerunner.com/app/images/new/Favicon.png"-->
    <link rel="shortcut icon" href="../app/assets/media/logos/favicon.ico" />

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



                    <div class="row">
                        <div class="col-xl-5 col-lg-6">

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card widget-flat">
                                        <div class="card-body">
                                            <div class="float-right">
                                                <i class="mdi mdi-account-multiple widget-icon bg-success-lighten text-success"></i>
                                            </div>
                                            <h5 class="text-muted font-weight-normal mt-0" title="Number of Customers">Customers</h5>
                                            <h3 class="mt-3 mb-3">0</h3>
                                            <p class="mb-0 text-muted">
                                                <!--
                                                    <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i> 5.27%</span>
                                                    <span class="text-nowrap">Since last month</span>  
-->
                                            </p>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->



                            </div>


                        </div>

                    </div>


                    <div class="row">
                        <div class="col-6">
                            <div class="table table-responsive">
                                <form method="post" action="save_load_counts.php">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th colspan="3">Load Counts Table Data</th>
                                            </tr>
                                            <tr>
                                                <th>Equipment</th>
                                                <th>Available Loads</th>
                                                <th># LOADS PICKING</th>
                                                <th># LOADS DROPPING</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Van</td>
                                                <td><input type="text" name="van_loads_0" class="form-control" value="<?php echo $ta->van_loads_0; ?>"></td>
                                                <td><input type="text" name="van_loads_picking_0" class="form-control" value="<?php echo $ta->van_loads_picking_0; ?>"></td>
                                                <td><input type="text" name="van_loads_dropping_0" class="form-control" value="<?php echo $ta->van_loads_dropping_0; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>reefer</td>
                                                <td><input type="text" name="reefer_loads_0" class="form-control" value="<?php echo $ta->reefer_loads_0; ?>"></td>
                                                <td><input type="text" name="reefer_loads_picking_0" class="form-control" value="<?php echo $ta->reefer_loads_picking_0; ?>"></td>
                                                <td><input type="text" name="reefer_loads_dropping_0" class="form-control" value="<?php echo $ta->reefer_loads_dropping_0; ?>"></td </tr>
                                            <tr>
                                                <td>Flatbed</td>
                                                <td><input type="text" name="flat_loads_0" class="form-control" value="<?php echo $ta->flat_loads_0; ?>"></td>
                                                <td><input type="text" name="flat_loads_picking_0" class="form-control" value="<?php echo $ta->flat_loads_picking_0; ?>"></td>
                                                <td><input type="text" name="flat_loads_dropping_0" class="form-control" value="<?php echo $ta->flat_loads_dropping_0; ?>"></td </tr>
                                            <tr>
                                                <td>Power Only</td>
                                                <td><input type="text" name="power_loads_0" class="form-control" value="<?php echo $ta->power_loads_0; ?>"></td>
                                                <td><input type="text" name="power_loads_picking_0" class="form-control" value="<?php echo $ta->power_loads_picking_0; ?>"></td>
                                                <td><input type="text" name="power_loads_dropping_0" class="form-control" value="<?php echo $ta->power_loads_dropping_0; ?>"></td </tr>
                                            <tr>
                                                <td>Heavy Haul</td>
                                                <td><input type="text" name="heavy_loads_0" class="form-control" value="<?php echo $ta->heavy_loads_0; ?>"></td>
                                                <td><input type="text" name="heavy_loads_picking_0" class="form-control" value="<?php echo $ta->heavy_loads_picking_0; ?>"></td>
                                                <td><input type="text" name="heavy_loads_dropping_0" class="form-control" value="<?php echo $ta->heavy_loads_dropping_0; ?>"></td </tr>
                                            <tr>
                                                <td colspan="3"><button class="btn btn-success">Save</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                        <div class="col-6">
                            <div id="calendar"></div>
                        </div>
                    </div>



                    <?php

                    $sql = "SELECT * FROM rates_table";
                    $sr = $adm->getThis1($sql);


                    ?>
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="table table-responsive">
                                <form method="post" action="save_fuel_changes.php">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th colspan="5"> Summary Rates Table Data</th>
                                            </tr>
                                            <tr>
                                                <th> Equipment </th>
                                                <th> National Spot Market Rates </th>
                                                <th> National Contract Rates </th>
                                                <th> National Fuel Surcharges </th>
                                                <th> National Diesel Fuel Avg </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Reefer</td>
                                                <td><input type="text" name="spot_market_rate" class="form-control" value="<?php echo $sr->spot_market_rate; ?>"></td>
                                                <td><input type="text" name="contract_rate" class="form-control" value="<?php echo $sr->contract_rate; ?>"></td>
                                                <td><input type="text" name="fuel_surcharge" class="form-control" value="<?php echo $sr->fuel_surcharge; ?>"></td>
                                                <td><input type="text" name="diesel_fuel_avg" class="form-control" value="<?php echo $sr->diesel_fuel_avg; ?>"></td>
                                                <td colspan="3"><button class="btn btn-success">Save</button></td>
                                            </tr>
                                            <tr>
                                                <td>Van</td>
                                                <td><input type="text" name="spot_market_rate_van" class="form-control" value="<?php echo $sr->spot_market_rate_van; ?>"></td>
                                                <td><input type="text" name="contract_rate_van" class="form-control" value="<?php echo $sr->contract_rate_van; ?>"></td>
                                                <td><input type="text" name="fuel_surcharge_van" class="form-control" value="<?php echo $sr->fuel_surcharge_van; ?>"></td>
                                                <td><input type="text" name="diesel_fuel_avg_van" class="form-control" value="<?php echo $sr->diesel_fuel_avg_van; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Flat</td>
                                                <td><input type="text" name="spot_market_rate_flat" class="form-control" value="<?php echo $sr->spot_market_rate_flat; ?>"></td>
                                                <td><input type="text" name="contract_rate_flat" class="form-control" value="<?php echo $sr->contract_rate_flat; ?>"></td>
                                                <td><input type="text" name="fuel_surcharge_flat" class="form-control" value="<?php echo $sr->fuel_surcharge_flat; ?>"></td>
                                                <td><input type="text" name="diesel_fuel_avg_flat" class="form-control" value="<?php echo $sr->diesel_fuel_avg_flat; ?>"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>

                    </div>


                    <div class="row mt-2">
                        <div class="col-">
                            <!--
                                 [region_id] => 30
            [region_name] => Lincoln, ME
            [fill_color] => 
-->
                            <!--
                            <div class="table table-responsive" style="width: ;100%">
                                <table class="table table-responsive table-stripped" id="">
                                    
                                    <tr>
                                        <td></td>
                                        <td colspan="3" style="text-align:center">Inbound</td>
                                        <td colspan="3" style="text-align:center">Outbound</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Region Name</td>
                                        <td>Flat</td>
                                        <td>Reefer</td>
                                        <td>Van</td>
                                        <td>Flat</td>
                                        <td>Reefer</td>
                                        <td>Van</td>
                                        <td>Save</td>
                                    </tr>
                                    <?php
                                    foreach ($regions as $v) {
                                    ?>


                                        <tr>
                                            <form method="post" action="save_inbound_map.php">
                                                <td><?php echo $v->region_name; ?><input type="hidden" name="region" value="<?php echo $v->region_id; ?>"></td>
                                                <td>
                                                    <select  name="in_fl_col" class="form-select">
                                                        <option value="loose" <?php if ($v->inbound_flat === "loose") {
                                                                                    echo " selected ";
                                                                                } ?> >Loose Capacity</option>
                                                        <option value="tight" <?php if ($v->inbound_flat === "tight") {
                                                                                    echo " selected ";
                                                                                } ?>>Tight Capacity</option>
                                                        <option value="neutral" <?php if ($v->inbound_flat === "neutral") {
                                                                                    echo " selected ";
                                                                                } ?>>Neutral Capacity</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select  name="in_re_col" class="form-select">
                                                        <option value="loose" <?php if ($v->inbound_reefer === "loose") {
                                                                                    echo " selected ";
                                                                                } ?> >Loose Capacity</option>
                                                        <option value="tight" <?php if ($v->inbound_reefer === "tight") {
                                                                                    echo " selected ";
                                                                                } ?>>Tight Capacity</option>
                                                        <option value="neutral" <?php if ($v->inbound_reefer === "neutral") {
                                                                                    echo " selected ";
                                                                                } ?>>Neutral Capacity</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select  name="in_va_col" class="form-select">
                                                        <option value="loose" <?php if ($v->inbound_van === "loose") {
                                                                                    echo " selected ";
                                                                                } ?> >Loose Capacity</option>
                                                        <option value="tight" <?php if ($v->inbound_van === "tight") {
                                                                                    echo " selected ";
                                                                                } ?>>Tight Capacity</option>
                                                        <option value="neutral" <?php if ($v->inbound_van === "neutral") {
                                                                                    echo " selected ";
                                                                                } ?>>Neutral Capacity</option>
                                                    </select>
                                                </td>




                                                <td>
                                                    <select  name="ou_fl_col" class="form-select">
                                                        <option value="loose" <?php if ($v->outbound_flat === "loose") {
                                                                                    echo " selected ";
                                                                                } ?> >Loose Capacity</option>
                                                        <option value="tight" <?php if ($v->outbound_flat === "tight") {
                                                                                    echo " selected ";
                                                                                } ?>>Tight Capacity</option>
                                                        <option value="neutral" <?php if ($v->outbound_flat === "neutral") {
                                                                                    echo " selected ";
                                                                                } ?>>Neutral Capacity</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select  name="ou_re_col" class="form-select">
                                                        <option value="loose" <?php if ($v->outbound_reefer === "loose") {
                                                                                    echo " selected ";
                                                                                } ?> >Loose Capacity</option>
                                                        <option value="tight" <?php if ($v->outbound_reefer === "tight") {
                                                                                    echo " selected ";
                                                                                } ?>>Tight Capacity</option>
                                                        <option value="neutral" <?php if ($v->outbound_reefer === "neutral") {
                                                                                    echo " selected ";
                                                                                } ?>>Neutral Capacity</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select  name="ou_va_col" class="form-select">
                                                        <option value="loose" <?php if ($v->outbound_van === "loose") {
                                                                                    echo " selected ";
                                                                                } ?> >Loose Capacity</option>
                                                        <option value="tight" <?php if ($v->outbound_van === "tight") {
                                                                                    echo " selected ";
                                                                                } ?>>Tight Capacity</option>
                                                        <option value="neutral" <?php if ($v->outbound_van === "neutral") {
                                                                                    echo " selected ";
                                                                                } ?>>Neutral Capacity</option>
                                                    </select>
                                                </td>
                                                <td><button class="btn btn-success save_color">Save</button></td>
                                            </form>
                                        </tr>

                                    <?php

                                    }
                                    ?>
                                </table>
                            </div>
                                -->
                        </div>
                    </div>

                    <!-- Full width modal -->

                    <div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-full-width">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="fullWidthModalLabel">Regions Map</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body" id="malditoModal">
                                    <div id="modal_map" style="min-height: 650px;"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>

                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->


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






        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add news to timeline</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6 form-group">
                                <label>From</label>
                                <input type="date" id="new_date" class="form-control">
                            </div>
                            <div class="col-12 form-group">
                                <label>Title</label>
                                <input type="text" id="new_title" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 form-group">
                                <textarea id="news_text" class="form-control" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="save_new_timeline_btn">Save changes</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal" id="editModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit news from the timeline</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6 form-group">
                                <label>From</label>
                                <input type="date" id="edit_new_date" class="form-control">
                            </div>
                            <div class="col-12 form-group">
                                <label>Title</label>
                                <input type="text" id="edit_new_title" class="form-control">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 form-group">
                                <textarea id="edit_news_text" class="form-control" rows="10"></textarea>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="edit_new_id" class="form-control">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="edit_new_timeline_btn">Save changes</button>
                        <button type="button" class="btn btn-danger" id="delete_new_timeline_btn">DELETE</button>
                    </div>
                </div>
            </div>
        </div>






    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar -->
    <?php include("rightBar.php"); ?>
    <!-- /Right-bar -->



    <!-- bundle -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>

    <!-- third party js -->

    <!-- third party js ends -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js'></script>
    <script src='//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js'></script>

    <script src="../app/assets/js/jquery.typeahead.min.js"></script>

    <script>
        /*
        $('.js-typeahead-country_v1').typeahead({
            offset: true,
            input: '.js-typeahead-country_v1',
            hint: true,
            source: {
                data: [
                    <?php
                    foreach ($all_c as $v) {
                    ?> "<?php echo $v->city; ?>",
                    <?php
                    }

                    ?>
                ]
            },
            callback: {
                onInit: function(node) {
                    console.log('Typeahead Initiated on ' + node.selector);
                }
            }
        });
*/
        $(document).ready(function() {

            let table = new DataTable('#regions_table');


            $("#save_new_timeline_btn").on('click', function() {
                var data = {
                    new_date: $("#new_date").val(),
                    new_title: $("#new_title").val(),
                    new_text: $("#news_text").val()
                };

                $.ajax({
                    type: "POST",
                    url: "ajax/save_new_news.php",
                    data: data,
                    success: function(response) {
                        //success code here
                        //console.log(response)
                        window.location.reload()
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        //error code here
                    }
                });
            });

            $("#edit_new_timeline_btn").on('click', function() {


                var data = {
                    new_date: $("#edit_new_date").val(),
                    new_title: $("#edit_new_title").val(),
                    new_text: $("#edit_news_text").val(),
                    new_id: $("#edit_new_id").val()
                };

                $.ajax({
                    type: "POST",
                    url: "ajax/edit_new_news.php",
                    data: data,
                    success: function(response) {
                        //success code here
                        //console.log(response)
                        //console.log(response)
                        window.location.reload()
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        //error code here
                        console.log(textStatus)
                    }
                });
            });

            $("#delete_new_timeline_btn").on('click', function() {
                var data = {
                    new_id: $("#edit_new_id").val()
                };

                $.ajax({
                    type: "POST",
                    url: "ajax/delete_new_news.php",
                    data: data,
                    success: function(response) {
                        //success code here
                        //console.log(response)
                        window.location.reload()
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        //error code here
                    }
                });
            });

        });



        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: false
                },
                events: 'ajax/traer_eventos_calendario.php',

                eventClick: function(info) {
                    console.log(info.event.extendedProps)
                    // console.log('Event: ' + info.event.extendedProps.evento_id);
                    //   window.location.href = 'proyectosActividadDetalle.php?actividad_id=' + info.event.extendedProps.evento_id
                    // console.log(info.event.extendedProps.id)

                    $("#edit_new_date").val(info.event.extendedProps.news_date)
                    $("#edit_new_title").val(info.event.title)
                    $("#edit_news_text").val(info.event.extendedProps.edit_news_text)
                    $("#edit_new_id").val(info.event.id)
                    $("#editModal").modal('show')
                },
                dateClick: function(info) {
                    $("#new_date").val(info.dateStr)

                    $("#myModal").modal('show')
                }
            });

            calendar.render();
        });
    </script>

</body>

</html>