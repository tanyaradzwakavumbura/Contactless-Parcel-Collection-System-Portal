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

        /* Style for selected options */
        /* Style for selected options */
        .select2-container--default .select2-selection--multiple .select2-selection__choice[aria-selected=true] {
            background-color: #5368FA;
            /* Change this to your desired color */
            color: #fff;
            /* Change this to your desired text color */
        }

        /* Style for the dropdown */
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #5368FA;
            /* Change this to your desired color */
            color: #fff;
            /* Change this to your desired text color */
        }

        /* Style for the displayed selected items (tags) */
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #5368FA;
            /* Change this to your desired color */
            color: #fff;
            /* Change this to your desired text color */
        }
    </style>
    
     <script src="assets/jquery.min.js"></script>

    <!-- jQuery UI library -->
    <link rel="stylesheet" href="assets/jquery-ui.css">
    <script src="assets/jquery-ui.min.js"></script>
    
    <script type="text/javascript">
        $(function() {
            $('#user_fullname').autocomplete({
                source: 'includes/methods/all_users.php'
            });
        });
    </script>
    
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
                                <li class="breadcrumb-item active" aria-current="page">Add A New Parcel</li>
                            </ol>
                        </nav>
                        <h4 class="mg-b-0 tx-spacing--1">Add New Parcel</h4>
                    </div>
                    <div class="d-none d-md-block">
                       
                        <a href="view_all_cells.php" class="btn btn-sm pd-x-15 btn-warning btn-uppercase mg-l-5"><i data-feather="book" class="wd-10 mg-r-5"></i>View All Pending Parcels</a>

                        <a href="record_new_cell.php" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="book" class="wd-10 mg-r-5"></i> View All Intransit Parcels</a>
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
                                           
                                            <input type="text" name="parcel_code" value="<?php echo calculateParcelCode($connect);?>" hidden>
                                            <h5>Sender Information</h5>
                                            <hr>

                                            <div class="form-group">
                                                <label class="d-block">Parcel Size</label>
                                                <select style="border-color:#7CB74B; border-width:1px; border-radius:10px" class="form-control" id="parcel_size" name="parcel_size" required>
                                                    <option value="" disabled selected>Select Parcel Size</option>
                                                    <option value="Small">Small</option>
                                                    <option value="Medium">Medium</option>
                                                    <option value="Large">Large</option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="d-block">Parcel Sent to Province</label>
                                                <select style="border-color:#7CB74B; border-width:1px; border-radius:10px" class="form-control" id="parcel_sent_to_province" name="parcel_sent_to_province" required>
                                                    <option value="" disabled selected>Select Province</option>
                                                    <option value="Harare">Harare</option>
                                                    <option value="Bulawayo">Bulawayo</option>
                                                    <option value="Manicaland">Manicaland</option>
                                                    <option value="Mashonaland Central">Mashonaland Central</option>
                                                    <option value="Mashonaland East">Mashonaland East</option>
                                                    <option value="Mashonaland West">Mashonaland West</option>
                                                    <option value="Masvingo">Masvingo</option>
                                                    <option value="Matabeleland North">Matabeleland North</option>
                                                    <option value="Matabeleland South">Matabeleland South</option>
                                                    <option value="Midlands">Midlands</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="d-block">Assigned Locker : <small>Auto Assignment</small></label>
                                                <input type="text" style="border-color:#7CB74B; border-width:1px; border-radius:10px" class="form-control" id="assigned_locker" name="assigned_locker" required readonly>
                                            </div>

                                            <div class="form-group">
                                                <label class="d-block">Sender Phone Number : <small>263777777777</small></label>
                                                <input type="text" style="border-color:#7CB74B; border-width:1px; border-radius:10px" class="form-control" id="sender_phone_number" name="sender_phone_number" required value="263">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="d-block">Sender Address</label>
                                                <textarea style="border-color:#7CB74B; border-width:1px; border-radius:10px" class="form-control" id="sender_address" name="sender_address" required placeholder="Sender Address....." rows=2></textarea>
                                            </div>

                                            <h5>Receiver Information</h5>
                                            <hr>

                                            <div class="form-group">
                                                <label class="d-block">Receiver Fullname</label>
                                                <input type="text" style="border-color:#7CB74B; border-width:1px; border-radius:10px" class="form-control" id="receiver_fullname" name="receiver_fullname" required placeholder="Enter Receiver Fullname">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="d-block">Receiver ID Number (<small>xx-xxxxxxxPxx</small>)</label>
                                                <input type="text" style="border-color:#7CB74B; border-width:1px; border-radius:10px" class="form-control" id="receiver_id_number" name="receiver_id_number" required placeholder="Enter Receiver ID Number" pattern="\d{2}-\d{7}[A-Z]\d{2}" title="ID Number must be in the format 63-2116374P85">
                                            </div>

                                            <div class="form-group">
                                                <label class="d-block">Receiver Phone Number</label>
                                                <input type="text" style="border-color:#7CB74B; border-width:1px; border-radius:10px" class="form-control" id="receiver_phone_number" name="receiver_phone_number" required value="263">
                                            </div>

                                            <div class="form-group">
                                                <label class="d-block">Receiver Address</label>
                                                <textarea style="border-color:#7CB74B; border-width:1px; border-radius:10px" class="form-control" id="receiver_address" name="receiver_address" required placeholder="Receiver Address....." rows=2></textarea>
                                            </div>
                                            
                                            
                    
                                            
                                          
                                            <button type="submit" onclick="record_new_parcel_show_loader()" class="btn btn-primary" name="record_new_parcel">Record New Parcel</button>
                                            
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
        document.addEventListener("DOMContentLoaded", function () {
    const parcelSize = document.getElementById("parcel_size");
    const parcelProvince = document.getElementById("parcel_sent_to_province");
    const assignedLocker = document.getElementById("assigned_locker");

    function fetchAssignedLocker() {
        const size = parcelSize.value;
        const province = parcelProvince.value;

        if (size && province) {
            // Send AJAX request to PHP script
            fetch("includes/get_locker.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `parcel_size=${size}&parcel_sent_to_province=${province}`
            })


            .then(response => response.text())
            .then(data => {
                assignedLocker.value = data || "No locker available : Pending Assignment";

                console.log(data);
            })
            .catch(error => console.error("Error fetching locker:", error));
        } else {
            assignedLocker.value = ""; // Clear the input if selections are missing
        }
    }

    // Add event listeners to trigger AJAX on selection change
    parcelSize.addEventListener("change", fetchAssignedLocker);
    parcelProvince.addEventListener("change", fetchAssignedLocker);
});

    </script>
   
    
    <script>
        function record_new_department_show_loader() {
            if ($('#parcel_size').val() != '' || $('#parcel_sent_to_province').val() != '' || $('#sender_phone_number').val() != '' || $('#sender_address').val() != '' || $('#receiver_fullname').val() != '' || $('#receiver_id_number').val() != '' || $('#receiver_phone_number').val() != '' || $('#receiver_address').val() != '') {
                $('#loader').show();
        }
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