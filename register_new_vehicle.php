<?php
include("includes/forms.php");
include("includes/session.php");
if ($role == "company") {
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
    
    <!-- Select2 CSS -->
    <link href="lib/select2/css/select2.min.css" rel="stylesheet">

    <!-- jQuery UI library -->
    <link rel="stylesheet" href="assets/jquery-ui.css">
    <script src="assets/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="assets/css/loader.css">
   
    
     <script src="assets/jquery.min.js"></script>

    <!-- jQuery UI library -->
    <link rel="stylesheet" href="assets/jquery-ui.css">
    <script src="assets/jquery-ui.min.js"></script>
    
    
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
                                <li class="breadcrumb-item active" aria-current="page">Register New Vehicle</li>
                            </ol>
                        </nav>
                        <h4 class="mg-b-0 tx-spacing--1">Register New Vehicle</h4>
                    </div>
                    <div class="d-none d-md-block">
                       
                        <a href="view_all_vehicles" class="btn btn-sm pd-x-15 btn-warning btn-uppercase mg-l-5"><i data-feather="book" class="wd-10 mg-r-5"></i>View All Vehicles</a>

                        <a href="manage_categories.php" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="book" class="wd-10 mg-r-5"></i> Manage Vehicle Categories</a>
                        
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

                                        <form action="" method="POST" enctype="multipart/form-data">
                                            <?php
                                            include("includes/alert.php");
                                            ?>
                                           
                                            <input type="text" name="vehicle_code" value="<?php echo calculateVehicleCode($connect);?>" hidden>
                                           
                                            <div class="form-group">
                                                <label class="d-block">Choose Vehicle Category</label>
                                                <select class="form-control" style="border-color:#7CB74B; border-width:1px; border-radius:10px" name="vehicle_category" id="vehicle_category" required>
                                                    <option value="">Choose Vehicle Category</option>
                                                    <?php
                                                    $find_cats = $connect->prepare("SELECT * FROM categories");
                                                    $find_cats->execute();
                                                    while($row=$find_cats->fetch(PDO::FETCH_ASSOC)){
                                                        $cats_code = $row["code"];
                                                        $cats_name = $row["name"];
                                                        $cats_cost = $row["cost"];
                                                        $cats_minutes = $row["minutes"];
                                                        ?>
                                                    <option value="<?php echo $cats_code;?>"><?php echo $cats_name;?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label class="d-block">Vehicle License Plate</label>
                                                <input type="text" style="border-color:#7CB74B; border-width:1px; border-radius:10px" class="form-control" id="vehicle_license_plate" name="vehicle_license_plate" placeholder="Enter Vehicle License Plate" required>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="d-block">Vehicle Driver Name</label>
                                                <input type="text" style="border-color:#7CB74B; border-width:1px; border-radius:10px" class="form-control" id="vehicle_driver_name" name="vehicle_driver_name" placeholder="Enter Vehicle Driver Fullname" required>
                                            </div>
                    
                                              
                                            <button type="submit" onclick="register_new_vehicle_show_loader()" class="btn btn-primary" name="add_new_vehicle">Register New Vehicle</button>

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
    
    <!-- Select2 JS -->
    <script src="lib/select2/js/select2.min.js"></script>

    <!-- append theme customizer -->
    <script src="lib/js-cookie/js.cookie.js"></script>
    <script src="assets/js/dashboard-one.js"></script>
    <script src="assets/js/dashforge.settings.js"></script>
    
    
   
     
    <script>
        function register_new_vehicle_show_loader() {
            if ($('#vehicle_category').val() != '' && $('#vehicle_license_plate').val() != '' && $('#vehicle_driver_name').val() != '')
                $('#loader').show();
        }
    </script>
    
      <script>
        // Adding placeholder for search input
        (function($) {

            'use strict'

            var Defaults = $.fn.select2.amd.require('select2/defaults');

            $.extend(Defaults.defaults, {
                searchInputPlaceholder: ''
            });

            var SearchDropdown = $.fn.select2.amd.require('select2/dropdown/search');

            var _renderSearchDropdown = SearchDropdown.prototype.render;

            SearchDropdown.prototype.render = function(decorated) {

                // invoke parent method
                var $rendered = _renderSearchDropdown.apply(this, Array.prototype.slice.apply(arguments));

                this.$search.attr('placeholder', this.options.get('searchInputPlaceholder'));

                return $rendered;
            };

        })(window.jQuery);


        $(function() {
            'use strict'

            // Basic with search
            $('.select2').select2({
                placeholder: 'Choose one',
                searchInputPlaceholder: 'Search options'
            });

            // Disable search
            $('.select2-no-search').select2({
                minimumResultsForSearch: Infinity,
                placeholder: 'Choose one'
            });

            // Clearable selection
            $('.select2-clear').select2({
                minimumResultsForSearch: Infinity,
                placeholder: 'Choose one',
                allowClear: true
            });

            // Limit selection
            $('.select2-limit').select2({
                minimumResultsForSearch: Infinity,
                placeholder: 'Choose one',
                maximumSelectionLength: 2
            });

        });
    </script>
    
    <script>
        $(function() { 
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

            $('#datepicker4').datepicker({
                dateFormat: 'yy-mm-dd'
            });

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
                    to.datepicker('option', 'minDate', getDate(this));
                }),
                to = $('#dateTo').datepicker({
                    defaultDate: '+1w',
                    numberOfMonths: 2
                })
                .on('change', function() {
                    from.datepicker('option', 'maxDate', getDate(this));
                });

            function getDate(element) {
                var date;
                try {
                    date = $.datepicker.parseDate(dateFormat, element.value);
                } catch (error) {
                    date = null;
                }

                return date;
            }


        });
    </script>
     <script>
        // Adding placeholder for search input
        (function($) {

            'use strict'

            var Defaults = $.fn.select2.amd.require('select2/defaults');

            $.extend(Defaults.defaults, {
                searchInputPlaceholder: ''
            });

            var SearchDropdown = $.fn.select2.amd.require('select2/dropdown/search');

            var _renderSearchDropdown = SearchDropdown.prototype.render;

            SearchDropdown.prototype.render = function(decorated) {

                // invoke parent method
                var $rendered = _renderSearchDropdown.apply(this, Array.prototype.slice.apply(arguments));

                this.$search.attr('placeholder', this.options.get('searchInputPlaceholder'));

                return $rendered;
            };

        })(window.jQuery);


        $(function() {
            'use strict'

            // Basic with search
            $('.select2').select2({
                placeholder: 'Choose one',
                searchInputPlaceholder: 'Search options'
            });

            // Disable search
            $('.select2-no-search').select2({
                minimumResultsForSearch: Infinity,
                placeholder: 'Choose one'
            });

            // Clearable selection
            $('.select2-clear').select2({
                minimumResultsForSearch: Infinity,
                placeholder: 'Choose one',
                allowClear: true
            });

            // Limit selection
            $('.select2-limit').select2({
                minimumResultsForSearch: Infinity,
                placeholder: 'Choose one',
                maximumSelectionLength: 2
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
    
    <script type="text/javascript">
        setInterval(function() {
            ///Local Gweru
            $.ajax({
                type: "GET",
                url: "includes/methods/fingerprint_blob.php",
                dataType: "html",
                success: function(response) {
                    $("#fingerprint_blob").val(response);
                    console.log(response);
                }
            });
        }, 1000);
    </script>
    <?php include("includes/no_click.php");?>
</body>

</html>