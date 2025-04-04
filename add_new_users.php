<?php
include("includes/forms.php");
include("includes/session.php");
if($role != "admin"){
    header("location:dashboard.php");
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

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="assets/css/dashforge.css">
    <link rel="stylesheet" href="assets/css/dashforge.dashboard.css">
    
      <!-- jQuery library -->
    <script src="assets/jquery.min.js"></script>

    <!-- jQuery UI library -->
    <link rel="stylesheet" href="assets/jquery-ui.css">
    <script src="assets/jquery-ui.min.js"></script>
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

        <div class="content-body">
            <div class="container pd-x-0">
                <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                    <div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Register A New User</li>
                            </ol>
                        </nav>
                        <h4 class="mg-b-0 tx-spacing--1">Register A New User</h4>
                    </div>
                    <div class="d-none d-md-block">
                        <a href="dashboard" class="btn btn-sm pd-x-15 btn-warning btn-uppercase mg-l-5"><i data-feather="home" class="wd-10 mg-r-5"></i>Dashboard</a>
                        
                        <a href="settings" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="settings" class="wd-10 mg-r-5"></i> Account Settings</a>
                    </div>
                </div>

                <div class="row row-xs">
                    <div class="col-lg-8 col-xl-12">
                        <div class="card">
                            <div class="card-header bd-b-0 pd-t-20 pd-lg-t-25 pd-l-20 pd-lg-l-25 d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">

                            </div><!-- card-header -->
                            <div class="card-body pd-lg-25">
                                <div class="row align-items-sm-end">
                                    <div class="col-lg-7 col-xl-8">

                                        <form action="" method="POST">
                                            <?php
                                            include("includes/alert.php");
                                            ?>
                                            
                                            <div class="form-group">
                                                <label class="d-block">Fullname</label> 
                                                <input class="form-control" style="border-color:#7CB74B; border-width:1px; border-radius:10px" type="text" name="p_name" id="p_name" placeholder="Enter the Person 's Fullname" required>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="d-block">Email Address</label> 
                                                <input class="form-control" style="border-color:#7CB74B; border-width:1px; border-radius:10px" type="email" name="p_email" id="p_email" placeholder="Enter Person Email Address" required>
                                            </div>
                                           
                                            <div class="form-group">
                                                <label class="d-block">Account Type</label> 
                                                <select class="form-control" style="border-color:#7CB74B; border-width:1px; border-radius:10px" name="p_account" required>
                                                    <option value="">Choose Option</option>
                                                    <option value="admin">System Administrator</option>
                                                    <option value="transporter">Transporter</option>
                                                    <option value="normal_user">Normal User</option>
                                                </select> 
                                            </div>
                                
                                            <div class="form-group">
                                                <label class="d-block">Password</label> 
                                                <input class="form-control" style="border-color:#7CB74B; border-width:1px; border-radius:10px" type="text" name="p_password" id="p_password" placeholder="Enter Person 's Password" required value="password" readonly>
                                            </div>
                                            
                                            
                                    
                                            <button type="submit" class="btn btn-primary" name="register_new_user">Register New User</button>
                                           
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div><!-- card-body -->
                    </div><!-- card -->
                </div>
            </div><!-- row -->
        </div><!-- container -->
    </div>

    
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
    <script>
      $(function(){
        'use strict'

        $('#datepicker1').datepicker();

        $('#datepicker2').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true
        });

        $('#datepicker3').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          changeMonth: true,
          changeYear: true
        });

        $('#datepicker4').datepicker({ dateFormat: 'yy-mm-dd' });

        $('#datepicker5').datepicker({
          showButtonPanel: true
        });

        $('#datepicker6').datepicker({
          numberOfMonths: 2
        });

        var dateFormat = 'yy-mm-dd', 
        from = $('#dateFrom')
        .datepicker({
          defaultDate: '+1w',
          numberOfMonths: 2
        })
        .on('change', function() {
          to.datepicker('option','minDate', getDate( this ) );
        }),
        to = $('#dateTo').datepicker({
          defaultDate: '+1w',
          numberOfMonths: 2
        })
        .on('change', function() {
          from.datepicker('option','maxDate', getDate( this ) );
        });

        function getDate( element ) {
          var date;
          try {
            date = $.datepicker.parseDate( dateFormat, element.value );
          } catch( error ) {
            date = null;
          }

          return date;
        }


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
    <?php include("includes/no_click.php");?>
</body>

</html>