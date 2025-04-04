<?php
include("includes/forms.php");
include("includes/session.php");
//$_SESSION["monthly_year_report"] = $choose_year;
if(!isset($_SESSION["monthly_year_report"])){
    header("location:monthly_statistics_generator_search");
}else{
    $the_year = $_SESSION["monthly_year_report"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    include("includes/meta.php");
    ?>

    <!-- vendor css -->
    <link href="lib/%40fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="lib/jqvmap/jqvmap.min.css" rel="stylesheet">
    <link href="lib/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="lib/select2/css/select2.min.css" rel="stylesheet">
    <link href="lib/typicons.font/typicons.css" rel="stylesheet">

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="assets/css/dashforge.css">
    <link rel="stylesheet" href="assets/css/dashforge.dashboard.css">
    
    <!-- DashForge CSS -->
    <link rel="stylesheet" href="assets/css/dashforge.css">
    <link rel="stylesheet" href="assets/css/dashforge.dashboard.css">
    <script src="assets/buttons.dataTables.min.css"></script>
    <script src="assets/jquery.dataTables.min.css"></script>

    <style>
        body {
            background-color: white;
        }

        #loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            /* Set the background color to white with some transparency */
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #loader img {
            width: 100px;
            /* Adjust the size of the loader image as needed */
            height: 100px;
        }
    </style>
</head>

<body>
<div id="loader">
        <!-- Loader content (e.g., spinning icon or animation) goes here -->
        <img src="images/Infinity-1s-200px.gif">
    </div>
    <?php
      include("includes/aside.php");
      ?>

    <div class="content ht-100v pd-0">
        <?php
        include("includes/header.php");
        ?>

        <div class="content content-components">
            <div class="container ">
                <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                    <div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Monthly Year Statistics for <?php echo $the_year;?></li>
                            </ol>
                        </nav>
                        <h4 class="mg-b-0 tx-spacing--1">Monthly Year Statistics for <?php echo $the_year;?></h4>
                    </div>
                    <?php
                    if($role != "ceo"){
                        ?>
<!--
                    <div class="d-none d-md-block">
                        <a href="add_new_business_unit.php" class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="user" class="wd-10 mg-r-5"></i>Update Bus Pricing</a>
                        <a href="monthly_bus_statistics.php" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="user" class="wd-10 mg-r-5"></i> Monthly Bus Statistics</a>
                    </div>
-->
                    <?php
                    }
                    ?>
                </div>
                <hr>
                <div class="row col-12">
                    <div data-label="Example" class="df-example demo-table col-md-12">
                        <br>
                        <table id="example1" class="table table-hover table-bordered">
                            <thead class="thead-gray-100">
                                <tr>
                                    <th class="wd-15p">Date</th>
                                    <th class="wd-10p">Vehicles</th>
                                    <th class="wd-10p">Total</th>
                                    <?php
                                    $zero = 0;
                                    $find_vehicle_categories = $connect->prepare("SELECT * FROM categories WHERE cost !=?");
                                    $find_vehicle_categories->execute([$zero]);
                                    while($row=$find_vehicle_categories->fetch(PDO::FETCH_ASSOC)){
                                        $ve_cat_name = $row["name"];
                                        $ve_cat_code = $row["code"];
                                        ?>
                                    <th class="wd-15"><?php echo $ve_cat_name;?></th>
                                        <?php
                                    }
                                    ?>

                                    <th class="wd-15">Prepayments</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $find_months = $connect->prepare("SELECT DISTINCT MONTH(date) as month FROM vehicle_entry WHERE YEAR(date) = ? ORDER BY month DESC");
                                $find_months->execute([$the_year]);
                                while($row=$find_months->fetch(PDO::FETCH_ASSOC)){
                                    $the_month = $row["month"];
                                    
                                    $monthName = DateTime::createFromFormat('m', $the_month)->format('F');

                                    $closed = "closed";
                                    $find_all_vehicles = $connect->prepare("SELECT DISTINCT code, transaction FROM vehicle_entry WHERE MONTH(date)=? AND YEAR(date)=?");
                                    $find_all_vehicles->execute([$the_month,$the_year]);
                                    $count_all_found_vehicles = $find_all_vehicles->rowCount();

                                    $total_costs = 0;
                                    while($row=$find_all_vehicles->fetch(PDO::FETCH_ASSOC)){
                                        $the_found_transaction_code = $row["transaction"];

                                        $find_all_trans_details = $connect->prepare("SELECT * FROM transactions WHERE code=?");
                                        $find_all_trans_details->execute([$the_found_transaction_code]);
                                        while($row=$find_all_trans_details->fetch(PDO::FETCH_ASSOC)){
                                            $the_total_amount = $row['amount'];
                                        }

                                        $total_costs = $total_costs + $the_total_amount;
                                    }
                                    
                                    $pre_desc = "Prepayment";
                                    $find_prepayments_query = $connect->prepare("SELECT SUM(amount) AS total_month_amount_prepayment FROM transactions WHERE description=? AND MONTH(date)=? AND YEAR(date)=?");
                                    $find_prepayments_query->execute([$pre_desc,$the_month,$the_year]);
                                    while($row=$find_prepayments_query->fetch(PDO::FETCH_ASSOC)){
                                        $total_month_amount_prepayment = $row["total_month_amount_prepayment"];
                                    }

                                    
                                
                                    
                                ?>
                            
                                <tr>
                                    <td>
                                        <?php
                                        echo $monthName." ".$the_year;
                                        ?>
                                    </td>
                                    <td>
                                       <?php echo $count_all_found_vehicles;?>
                                    </td>
                                    <td>
                                       <?php echo format_money($total_costs);?>
                                    </td>

                                    <?php
                                    $zero = 0;
                                    $find_vehicle_categories = $connect->prepare("SELECT * FROM categories WHERE cost !=?");
                                    $find_vehicle_categories->execute([$zero]);
                                    while($row=$find_vehicle_categories->fetch(PDO::FETCH_ASSOC)){
                                        $ve_cat_name = $row["name"];
                                        $ve_cat_code = $row["code"];

                                        $the_amount = 0;
                                        
                                        $stat = "closed";
                                        $find_vehicle_details = $connect->prepare("SELECT DISTINCT code, transaction FROM vehicle_entry WHERE YEAR(date)=? AND MONTH(date)=? AND vehicle IN (SELECT plate FROM vehicles WHERE category=?)");
                                        $find_vehicle_details->execute([$the_year,$the_month,$ve_cat_code]);
                                        while($row=$find_vehicle_details->fetch(PDO::FETCH_ASSOC)){
                                            $the_vehicle_transaction_code = $row['transaction'];

                                            $find_transaction_details = $connect->prepare("SELECT * FROM transactions WHERE code=?");
                                            $find_transaction_details->execute([$the_vehicle_transaction_code]);
                                            while($row=$find_transaction_details->fetch(PDO::FETCH_ASSOC)){
                                                $the_transaction_cost = $row["amount"];
                                            }

                                            $the_amount = $the_amount + $the_transaction_cost;
                                        }
                                        ?>
                                    <td><?php echo format_money($the_amount);?></td>
                                        <?php
                                    }
                                    ?>
                                   <td><?php echo format_money($total_month_amount_prepayment);?></td>

                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>


                    </div><!-- df-example -->
                </div><!-- row -->

            </div><!-- container -->
        </div>
    </div>

    <script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="lib/feather-icons/feather.min.js"></script>
    <script src="lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="lib/jquery.flot/jquery.flot.js"></script>
    <script src="lib/jquery.flot/jquery.flot.stack.js"></script>
    <script src="lib/jquery.flot/jquery.flot.resize.js"></script>
    <script src="lib/chart.js/Chart.bundle.min.js"></script>
    <script src="lib/jqvmap/jquery.vmap.min.js"></script>
    <script src="lib/jqvmap/maps/jquery.vmap.usa.js"></script>

    <script src="assets/js/dashforge.js"></script>
    <script src="assets/js/dashforge.aside.js"></script>
    <script src="assets/js/dashforge.sampledata.js"></script>

    <!-- append theme customizer -->
    <script src="lib/js-cookie/js.cookie.js"></script>
    <script src="assets/js/dashboard-one.js"></script>
    <script src="assets/js/dashforge.settings.js"></script>
    <!--      -->


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
        $(function() {
            'use strict'

            $('#example1').DataTable({
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                },
                ordering: false,
                pageLength: 5000000,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

             $('#example2').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ Equipment Uptime/Page',
                },
                ordering: false,
                pageLength: 1000
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

            $('#modal6').on('show.bs.modal', function(event) {

                var animation = $(event.relatedTarget).data('animation');
                $(this).addClass(animation);
            })

            // hide modal with effect
            $('#modal6').on('hidden.bs.modal', function(e) {
                $(this).removeClass(function(index, className) {
                    return (className.match(/(^|\s)effect-\S+/g) || []).join(' ');
                });
            });

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