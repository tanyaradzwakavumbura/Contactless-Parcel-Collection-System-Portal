<?php
include("includes/forms.php");
include("includes/session.php");
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
                                <li class="breadcrumb-item active" aria-current="page">Monthly Report Generator</li>
                            </ol>
                        </nav>
                        <h4 class="mg-b-0 tx-spacing--1">Date Period Report Generator</h4>
                    </div>
                    
                    <div class="d-none d-md-block">
                        <a href="monthly_statistics_generator_search.php" class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="user" class="wd-10 mg-r-5"></i>Monthly Statistics</a>
                        <a href="yearly_statistics.php" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="user" class="wd-10 mg-r-5"></i> Yearly Statistics</a>
                    </div>

                </div>
                <hr>
                <div class="row col-12">
                    <div class="col-lg-7 col-xl-12">

                        <form action="" method="POST">
                            <?php
                            include("includes/alert.php");
                            ?>

                            <center><img src="images/login.png" width="20%"></center><br>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label class="d-block">Choose Starting Date</label>
                                    <input type="date" class="form-control" style="border-color:#767F9B; border-width:1px; border-radius:10px" name="start_date" required> 
                                </div>
                                
                                <div class="form-group col-6">
                                    <label class="d-block">Choose End Date</label>
                                    <input type="date" class="form-control" style="border-color:#767F9B; border-width:1px; border-radius:10px" name="end_date" required> 
                                </div>
                            </div>
                            <br>
                            <center>
                                <button type="submit" class="btn btn-primary" name="generate_daily_report">Generate Daily Report</button>
                            </center>

                            
                        </form>
                    </div>
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
                ordering: true,
                pageLength: 10,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                order: [
                    [4, 'desc']
                ] // Order by the first column in descending order
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