<?php
include("includes/forms.php");
include("includes/session.php");


if(!isset($_SESSION["report_date"])){
    header("location:generate_day_end_report");
}else{

    $report_date = $_SESSION["report_date"];


    $find_the_total_for_the_day_query = $connect->prepare("
    SELECT SUM(amount) AS total_amount_for_the_time 
    FROM (
        SELECT DISTINCT code, amount, transaction
        FROM vehicle_entry 
        WHERE date = ? 
    ) AS distinct_entries");
$find_the_total_for_the_day_query->execute([$report_date]);

    while($row=$find_the_total_for_the_day_query->fetch(PDO::FETCH_ASSOC)){
        $total_amount_for_the_time = $row["total_amount_for_the_time"];
    }



}

?>
<html lang="en">

<head>

    <?php
    
    include("includes/meta.php");
    ?>

    <!-- vendor css -->
    <link href="lib/%40fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="lib/jqvmap/jqvmap.min.css" rel="stylesheet">

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="assets/css/dashforge.css">
    <link rel="stylesheet" href="assets/css/dashforge.dashboard.css">

    <script src="assets/buttons.dataTables.min.css"></script>
    <script src="assets/jquery.dataTables.min.css"></script>
    <link rel="stylesheet" href="assets/css/loader.css">


    <script src="assets/jquery.min.js"></script>

    <!-- jQuery UI library -->
    <link rel="stylesheet" href="assets/jquery-ui.css">
    <script src="assets/jquery-ui.min.js"></script>

</head>

<body>
 
            <div class="container pd-x-0">
                <div class="row row-xs">
                    <div class="col-lg-8 col-xl-12">
                        <div class="card">
                            <div class="card-header bd-b-0 pd-t-20 pd-lg-t-25 pd-l-20 pd-lg-l-25 d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                            </div><!-- card-header -->
                            <div class="row" style="margin-left:1%">

                               
                            </div>
                            <div class="card-body pd-lg-25">
                                <div class="tx-center">
                                    <img src="images/login.png" width="10%">
                                    <hr>
                                    <h3><b>Cashier Report for <?php echo $report_date." Generated at ".$current_date." ".$current_time;?></b></h3>
                                </div>
                                <center>
                                    
                                    <hr>
                                </center>
                                <?php
                                $find_cashiers_for_the_day = $connect->prepare("SELECT DISTINCT(cashier) FROM vehicle_entry WHERE date=?");
                                $find_cashiers_for_the_day->execute([$report_date]);
                                while($row=$find_cashiers_for_the_day->fetch(PDO::FETCH_ASSOC)){
                                    $cashier = $row["cashier"];

                                    $find_cashier_details = $connect->prepare("SELECT * FROM users WHERE username=?");
                                    $find_cashier_details->execute([$cashier]);
                                    while($row=$find_cashier_details->fetch(PDO::FETCH_ASSOC)){
                                        $cashier_name = $row["name"];
                                        $cashier_phone = $row["phone"];
                                    }
                                
                                ?>
                                <div class="row align-items-sm-end">
                                   <b>Cashier Name : <?php echo $cashier_name."  |  ";?></b><br>
                                   <b>Cashier Employee Number : <?php echo $cashier_phone;?></b>
                                </div>
                                <?php
                                }
                                ?>
                                
                            </div>
                            
                        </div><!-- card-body -->
                        <b></b>
                        
                        <div class="card">
                            <div class="card-header bd-b-0 pd-t-20 pd-lg-t-25 pd-l-20 pd-lg-l-25 d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                                <h4><b>Total Amount Collected : <?php echo format_money($total_amount_for_the_time);?></b></h4>
                                
                            </div><!-- card-header -->
                            <div class="card-header bd-b-0 pd-t-20 pd-lg-t-25 pd-l-20 pd-lg-l-25 d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                             
                                <h4><b>Totals Per Category for the Day Statistics</b></h4>
                            </div><!-- card-header -->
                            
                            <div class="card-body pd-lg-25">
                                <div class="row align-items-sm-end">
                                    <div class="col-lg-7 col-xl-12">
                                        <div data-label="Example" class="df-example demo-table col-md-12">
                                            <br>
                                            <table id="example1" class="table table-hover table-bordered">
                                                <thead class="thead-gray-100">
                                                    <tr>
                                                        <th class="wd-20p">Category</th>
                                                        <th class="wd-30p">Totals Vehicles</th>
                                                        <th class="wd-25p">Total Amount</th>
                                                    
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    $find_all_catregories = $connect->prepare("SELECT * FROM categories");
                                                    $find_all_catregories->execute();
                                                    while($row=$find_all_catregories->fetch(PDO::FETCH_ASSOC)){
                                                        $category_name = $row["name"];
                                                        $category_code = $row["code"];

                                                      

                                                        $find_total_vehicles_per_category = $connect->prepare("
                                                            SELECT 
                                                            COUNT(*) AS total_vehicles, 
                                                            SUM(amount) AS total_amount 
                                                            FROM (
                                                                SELECT DISTINCT code, amount, transaction 
                                                                FROM vehicle_entry 
                                                                WHERE date = ? 
                                                                AND vehicle IN (
                                                                    SELECT plate 
                                                                    FROM vehicles 
                                                                    WHERE category = ?
                                                                )
                                                            ) AS distinct_entries
                                                        ");
                                                        $find_total_vehicles_per_category->execute([ $report_date, $category_code]);

                                                        while($row=$find_total_vehicles_per_category->fetch(PDO::FETCH_ASSOC)){
                                                            $total_vehicles = $row["total_vehicles"];
                                                            $total_amount = $row["total_amount"];
                                                        }
                                                        
                                                 
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $category_name;?></td>
                                                        <td><?php echo $total_vehicles;?></td>
                                                        <td><?php echo format_money($total_amount);?></td>
                                                     
                                                    </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>


                                        </div><!-- df-example -->
                                    </div>
                                </div>
                            </div>
                        </div><!-- card-body -->


                        <div class="card">
                            <div class="card-header bd-b-0 pd-t-20 pd-lg-t-25 pd-l-20 pd-lg-l-25 d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                                <h4><b>Vehicle Entry Report</b></h4>
                                
                            </div><!-- card-header -->
                            
                            <div class="card-body pd-lg-25">
                                <div class="row align-items-sm-end">
                                    <div class="col-lg-7 col-xl-12">
                                        <div data-label="Example" class="df-example demo-table col-md-12">
                                            <br>
                                            <table id="example1" class="table table-hover table-bordered">
                                                <thead class="thead-gray-100">
                                                    <tr>
                                                        <th class="wd-20p">Receipt Number</th>
                                                        <th class="wd-30p">vehicle</th>
                                                        <th class="wd-30p">Name</th>
                                                        <th class="wd-30p">Category</th>
                                                        <th class="wd-25p">Amount</th>
                                                        <th class="wd-25p">Entrance Time</th>
                                                        <th class="wd-25p">Cashier</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $find_all_vehicle_entry = $connect->prepare("SELECT DISTINCT code, amount, vehicle, entrance_time, cashier FROM vehicle_entry WHERE date=? ORDER BY entrance_time");
                                                    $find_all_vehicle_entry->execute([$report_date]);
                                                    while($row=$find_all_vehicle_entry->fetch(PDO::FETCH_ASSOC)){
                                                        $ve_id = $row["id"];
                                                        $ve_transaction_code = $row["transaction_code"];
                                                        $ve_category = $row["category"];
                                                        $ve_amount = $row["amount"];
                                                        $ve_date = $row["date"];
                                                        $ve_user = $row["user"];
                                                        $ve_code = $row["code"];
                                                        $ve_entrance_time = $row["entrance_time"];
                                                        $ve_vehicle = $row["vehicle"];
                                                        $ve_cashier = $row["cashier"];

                                                        $find_vehicle_details = $connect->prepare("SELECT * FROM vehicles WHERE plate=?");
                                                        $find_vehicle_details->execute([$ve_vehicle]);
                                                        while($row=$find_vehicle_details->fetch(PDO::FETCH_ASSOC)){
                                                            $ve_vehicle_name = $row["driver"];
                                                            $ve_vehicle_category = $row["category"];
                                                        }

                                                        $find_the_category_details = $connect->prepare("SELECT * FROM categories WHERE code=?");
                                                        $find_the_category_details->execute([$ve_vehicle_category]);
                                                        while($row=$find_the_category_details->fetch(PDO::FETCH_ASSOC)){
                                                            $ve_vehicle_category_name = $row["name"];
                                                        }
                                                   
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $ve_code;?></td>
                                                        <td><?php echo $ve_vehicle;?></td>
                                                        <td><?php echo $ve_vehicle_name;?></td>
                                                        <td><?php echo $ve_vehicle_category_name;?></td>
                                                        <td><?php echo format_money($ve_amount);?></td>
                                                        <td><?php echo $ve_entrance_time;?></td>
                                                        <td><?php echo $ve_cashier;?></td>
                                                    </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>


                                        </div><!-- df-example -->
                                    </div>
                                </div>
                            </div>
                        </div><!-- card-body -->

                        <div class="card">
                            <div class="card-header bd-b-0 pd-t-20 pd-lg-t-25 pd-l-20 pd-lg-l-25 d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                                <h4><b>Executive Vehicle Entry Report</b></h4>
                                
                            </div><!-- card-header -->
                            
                            <div class="card-body pd-lg-25">
                                <div class="row align-items-sm-end">
                                    <div class="col-lg-7 col-xl-12">
                                        <div data-label="Example" class="df-example demo-table col-md-12">
                                            <br>
                                            <table id="example1" class="table table-hover table-bordered">
                                                <thead class="thead-gray-100">
                                                    <tr>
                                                        <th class="wd-20p">Receipt Number</th>
                                                        <th class="wd-30p">vehicle</th>
                                                        <th class="wd-30p">Name</th>
                                                        <th class="wd-30p">Category</th>
                                                        <th class="wd-25p">Amount</th>
                                                        <th class="wd-25p">Entrance Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $find_all_vehicle_entry = $connect->prepare("SELECT DISTINCT code, vehicle, entrance_time FROM vehicle_entry WHERE date=? AND amount=?");
                                                    $stat_amount = 0;
                                                    $find_all_vehicle_entry->execute([$report_date,$stat_amount]);
                                                    while($row=$find_all_vehicle_entry->fetch(PDO::FETCH_ASSOC)){
                                                        $ve_id = $row["id"];
                                                        $ve_transaction_code = $row["transaction_code"];
                                                        $ve_category = $row["category"];
                                                        $ve_amount = $row["amount"];
                                                        $ve_date = $row["date"];
                                                        $ve_user = $row["user"];
                                                        $ve_code = $row["code"];
                                                        $ve_entrance_time = $row["entrance_time"];
                                                        $ve_vehicle = $row["vehicle"];

                                                        $find_vehicle_details = $connect->prepare("SELECT * FROM vehicles WHERE plate=?");
                                                        $find_vehicle_details->execute([$ve_vehicle]);
                                                        while($row=$find_vehicle_details->fetch(PDO::FETCH_ASSOC)){
                                                            $ve_vehicle_name = $row["driver"];
                                                            $ve_vehicle_category = $row["category"];
                                                        }

                                                        $find_the_category_details = $connect->prepare("SELECT * FROM categories WHERE code=?");
                                                        $find_the_category_details->execute([$ve_vehicle_category]);
                                                        while($row=$find_the_category_details->fetch(PDO::FETCH_ASSOC)){
                                                            $ve_vehicle_category_name = $row["name"];
                                                        }
                                                   
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $ve_code;?></td>
                                                        <td><?php echo $ve_vehicle;?></td>
                                                        <td><?php echo $ve_vehicle_name;?></td>
                                                        <td><?php echo $ve_vehicle_category_name;?></td>
                                                        <td><?php echo format_money($ve_amount);?></td>
                                                        <td><?php echo $ve_entrance_time;?></td>
                                                    </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>


                                        </div><!-- df-example -->
                                    </div>
                                </div>
                            </div>
                        </div><!-- card-body -->

                        <div class="card">
                            <div class="card-header bd-b-0 pd-t-20 pd-lg-t-25 pd-l-20 pd-lg-l-25 d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                                <h4><b>Void transactions</b></h4>
                                
                            </div><!-- card-header -->
                            
                            <div class="card-body pd-lg-25">
                                <div class="row align-items-sm-end">
                                    <div class="col-lg-7 col-xl-12">
                                        <div data-label="Example" class="df-example demo-table col-md-12">
                                            <br>
                                            <table id="example1" class="table table-hover table-bordered">
                                                <thead class="thead-gray-100">
                                                    <tr>
                                                        <th class="wd-20p">Receipt Number</th>
                                                        <th class="wd-30p">Category</th>
                                                        <th class="wd-25p">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    $find_all_void_transactions_query = $connect->prepare("SELECT * FROM reported_faults WHERE date=?");
                                                    $find_all_void_transactions_query->execute([$report_date]);
                                                    while($row=$find_all_void_transactions_query->fetch(PDO::FETCH_ASSOC)){
                                                        //SELECT `id`, `transaction_code`, `category`, `amount`, `date`, `user`, `vehicle` FROM `reported_faults` WHERE 1
                                                        $vo_id = $row["id"];
                                                        $vo_transaction_code = $row["transaction_code"];
                                                        $vo_category = $row["category"];
                                                        $vo_amount = $row["amount"];
                                                        $vo_date = $row["date"];
                                                        $vo_user = $row["user"];
                    
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $vo_transaction_code;?></td>
                                                        <td><?php echo $vo_category;?></td>
                                                        <td><?php echo format_money($vo_amount);?></td>
                                                     
                                                    </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>


                                        </div><!-- df-example -->
                                    </div>
                                </div>
                            </div>
                        </div><!-- card-body -->
                        
                    </div><!-- card -->
                </div>
            </div><!-- row -->
       
    


    <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/hopscotch.min.js"></script>
    <srcipt src="assets/js/hopscotch.script.js"></srcipt>
    <script src="lib/feather-icons/feather.min.js"></script>
    <script src="lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="lib/chart.js/Chart.bundle.min.js"></script>
    <script src="lib/jquery.flot/jquery.flot.js"></script>
    <script src="lib/jquery.flot/jquery.flot.stack.js"></script>
    <script src="lib/jquery.flot/jquery.flot.resize.js"></script>
    <script src="lib/cleave.js/cleave.min.js"></script>
    <script src="lib/cleave.js/addons/cleave-phone.us.js"></script>

    <script src="assets/js/dashforge.js"></script>
    <script src="assets/js/dashforge.aside.js"></script>
    <script src="assets/js/dashforge.sampledata.js"></script>

    <!-- append theme customizer -->
    <script src="lib/js-cookie/js.cookie.js"></script>
    <script src="assets/js/dashforge.settings.js"></script>

    <script src="lib/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="lib/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
    <script src="lib/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script>
    <script src="lib/select2/js/select2.min.js"></script>



    <script src="assets/dataTables.buttons.min.js"></script>
    <script src="assets/jszip.min.js"></script>
    <script src="assets/pdfmake.min.js"></script>
    <script src="assets/vfs_fonts.js"></script>
    <script src="assets/buttons.html5.min.js"></script>



    <script>
        function register_employee_show_loader() {
            if ($('#emp_fullname').val() != '' && $('#emp_email').val() != '' && $('#emp_position').val() != '')
                $('#loader').show();
        }
    </script>
    
    

    
    <script>
        function register_reviewer_show_loader() {
            if ($('#emp_reviewer_name').val() != '' && $('#emp_reviewer_email').val() != '' && $('#reviewer_account_type').val() != '')
                $('#loader').show();
        }
    </script>
    
    <script>
        function remove_reviewer_show_loader() {
            if ($('#re_reviewer').val() != '')
                $('#loader').show();
        }
    </script>

    <script>
        function notify_all_reviewers_show_loader() {
            $('#loader').show();
        }
    </script>
   
    
    <script>
        $(function() {
            'use strict'

            $('#example1').DataTable({
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                },
                ordering: false,
                pageLength: 100000,
               
            });

            $('#example2').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                }
            });

            $('#example3').DataTable({
                'ajax': '../assets/data/datatable-arrays.txt',
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                }
            });

            $('#example4').DataTable({
                'ajax': '../assets/data/datatable-objects.txt',
                "columns": [{
                        "data": "name"
                    },
                    {
                        "data": "position"
                    },
                    {
                        "data": "office"
                    },
                    {
                        "data": "extn"
                    },
                    {
                        "data": "salary"
                    }
                ],
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                }
            });

            // Select2
            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity
            });

        });
    </script>

    <script>
        $(function() {
            'use strict'

            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <script>
        //disable right mouse click
        $(function() {
            $(this).bind("contextmenu", function(e) {
                e.preventDefault();
            });
        });
    </script>
    <script>
        var cleave = new Cleave('#inputPhoneNumber', {
            phone: true,
            phoneRegionCode: 'US'
        });
    </script>


    <script>
        var cleaveC = new Cleave('#inputDate', {
            date: true,
            datePattern: ['Y', 'm', 'd']
        });

        var cleaveD = new Cleave('#inputDate2', {
            date: true,
            datePattern: ['m', 'y']
        });
    </script>
    <script>
        var cleaveI = new Cleave('#employee_id', {
            delimiters: ['-', ' ', ' ', ' ', ' '],
            blocks: [2, 7, 1, 2, 3, 1]
        });
    </script>

    <script>
        // Show the loader when the page starts loading
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('loader').style.display = 'block';
        });

        // Hide the loader when the page finishes loading
        window.addEventListener("load", function() {
            document.getElementById('loader').style.display = 'none';
        });
    </script>
</body>

</html>