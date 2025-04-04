<?php
include("includes/forms.php");
include("includes/session.php");
if($role != "cell"){
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
    
    <style>
        .btn-custom {
            width: 45%;
            height: 150px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 1.2em;
            padding: 20px;
        }
        .btn-custom img {
            margin-bottom: 10px;
            width: 40px;
            height: 40px;
        }

        .select2-container .select2-selection--single {
            height: calc(2.25rem + 2px) !important;
            padding: 0.375rem 1rem !important;
            border-color: #7CB74B !important;
            border-width: 1px !important;
            border-radius: 10px !important;
            display: flex !important;
            align-items: center !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: calc(1.5em + 0.75rem + 2px) !important;
            color: #6c757d !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(2.25rem + 2px) !important;
            right: 10px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__clear {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
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
                                <li class="breadcrumb-item active" aria-current="page">Record New Cell Meeting</li>
                            </ol>
                        </nav>
                        <h4 class="mg-b-0 tx-spacing--1">Record New Cell Meeting</h4>
                    </div>
                    <div class="d-none d-md-block">
                       
                        <a href="view_all_cells.php" class="btn btn-sm pd-x-15 btn-warning btn-uppercase mg-l-5"><i data-feather="book" class="wd-10 mg-r-5"></i>View All Cells</a>

                        <a href="record_a_new_department.php" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="book" class="wd-10 mg-r-5"></i> Record New Department</a>
                    </div>
                </div>

                <div class="row row-xs">
                    <div class="col-lg-8 col-xl-12">
                        <div class="card">
                            <div class="card-header bd-b-0 pd-t-20 pd-lg-t-25 pd-l-20 pd-lg-l-25 d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">

                            </div><!-- card-header -->
                            <div class="card-body pd-lg-25">
                                <div class="row align-items-sm-end">
                                    <div class="col-lg-12 col-xl-12">

                                        <form action="" method="POST" enctype="multipart/form-data">
                                            <?php
                                            include("includes/alert.php");
                                            ?>
                                            <input type="text" name="cell_meeting_code" value="<?php echo calculateCellMeetingCode($connect);?>" hidden>

                                            <div class="form-group">
                                                <label class="d-block">Cell Meeting Date</label>
                                                <input type="date" style="border-color:#7CB74B; border-width:1px; border-radius:10px" class="form-control" id="cell_meeting_date" name="cell_meeting_date" required>
                                            </div>
                                          
                                            <div class="form-group">
                                                <label class="d-block">Cell Meeting Name</label>
                                                <input type="text" style="border-color:#7CB74B; border-width:1px; border-radius:10px" class="form-control" id="cell_meeting_name" name="cell_meeting_name" placeholder="Enter Cell Meeting Name" required>
                                            </div>
                                         
                                            
                                            <div class="form-group">
                                                <label class="d-block">Total Offering ($)</label>
                                                <input type="number" step="any" style="border-color:#7CB74B; border-width:1px; border-radius:10px" class="form-control" id="cell_meeting_offering_amount" name="cell_meeting_offering_amount" placeholder="Enter Cell Offering Total Amount in USD" required>
                                            </div>

                                           
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5>Cell Meeting Attendance Form</h5>
                                                </div>
                                                <div class="card-block row">
                                                    <div class="col-sm-12 col-lg-12 col-xl-12">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead class="table-primary">
                                                                    <tr>
                                                                        <th scope="col">Cell Member</th>
                                                                        <th scope="col" width="10px">*</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="appending_div">

                                                                    <div class="">
                                                                        <tr class="">
                                                                            <td>
                                                                                <select class="form-control select2" style="border-color:#767F9B; border-width:2px; border-radius:6px" name="cell_member1" id="cell_member1">
                                                                                    <option value="">Choose Member</option>
                                                                                    <?php
                                                                                    $find_all_members_query = $connect->prepare("SELECT * FROM members");
                                                                                    $find_all_members_query->execute();
                                                                                    while($row=$find_all_members_query->fetch(PDO::FETCH_ASSOC)){
                                                                                        $m_fullname = $row["fullname"];
                                                                                        $m_code = $row["code"];
                                                                                        ?>
                                                                                        <option value="<?php echo $m_code;?>"><?php echo $m_fullname;?></option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </td>
                                                                            
                                                                            <td>
                                                                                <button class="btn btn-primary btn-xs add" type="button" style="cursor: pointer;">+</button>
                                                                            </td>
                                                                        </tr>


                                                                    </div>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card">
                                                <div class="card-header">
                                                    <h5>Cell Convert Attendance Form</h5>
                                                </div>
                                                <div class="card-block row">
                                                    <div class="col-sm-12 col-lg-12 col-xl-12">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead class="table-primary">
                                                                    <tr>
                                                                        <th scope="col">Cell Convert</th>
                                                                        <th scope="col" width="10px">*</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="appending_div_cell_convert">

                                                                    <div class="">
                                                                        <tr class="">
                                                                            <td>
                                                                                <select class="form-control select2" style="border-color:#767F9B; border-width:2px; border-radius:6px" name="cell_convert1" id="cell_convert1">
                                                                                    <option value="">Choose Member</option>
                                                                                    <?php
                                                                                    $find_all_members_query = $connect->prepare("SELECT * FROM members");
                                                                                    $find_all_members_query->execute();
                                                                                    while($row=$find_all_members_query->fetch(PDO::FETCH_ASSOC)){
                                                                                        $m_fullname = $row["fullname"];
                                                                                        $m_code = $row["code"];
                                                                                        ?>
                                                                                        <option value="<?php echo $m_code;?>"><?php echo $m_fullname;?></option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </td>
                                                                            
                                                                            <td>
                                                                                <button class="btn btn-primary btn-xs add_convert" type="button" style="cursor: pointer;">+</button>
                                                                            </td>
                                                                        </tr>


                                                                    </div>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                       

                                          
                                          
                                        <center>
                                        <button type="submit"  class="btn btn-primary tx-center" name="record_new_cell_meeting">Record New Cell Meeting</button>
                                        </center>
                                            
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
        var a;
        $(document).ready(function() {
            a = 2;
            $(document).on('click', '.add', function() {

            var field = '<tr class=""><td><select class="form-control select2" style="border-color:#767F9B; border-width:2px; border-radius:6px" name="cell_member' + a + '" id="cell_member' + a + '"><option value="">Choose Member</option><?php echo addslashes($find_all_members_query = $connect->prepare("SELECT * FROM members")); $find_all_members_query->execute(); while($row=$find_all_members_query->fetch(PDO::FETCH_ASSOC)){ $m_fullname = $row["fullname"]; $m_code = $row["code"]; ?><option value="<?php echo $m_code;?>"><?php echo $m_fullname;?></option><?php } ?></select></td><td><button class="btn btn-primary btn-xs add" type="button" style="cursor: pointer;">+</button> <button class="btn btn-danger btn-xs remove" type="button" style="cursor: pointer;">-</button></td></tr>';
            $('.appending_div').append(field);
            $('.select2').select2({
                placeholder: 'Choose one',
                searchInputPlaceholder: 'Search options'
            });
            a++;
            });

            $(document).on('click', '.remove', function() {
                $(this).closest('tr').remove();
            });
        })
    </script>


<script>
        var b;
        $(document).ready(function() {
            b = 2;
            $(document).on('click', '.add_convert', function() {

            var field = '<tr class=""><td><select class="form-control select2" style="border-color:#767F9B; border-width:2px; border-radius:6px" name="cell_convert' + b + '" id="cell_convert' + b + '"><option value="">Choose Member</option><?php echo addslashes($find_all_members_query = $connect->prepare("SELECT * FROM members")); $find_all_members_query->execute(); while($row=$find_all_members_query->fetch(PDO::FETCH_ASSOC)){ $m_fullname = $row["fullname"]; $m_code = $row["code"]; ?><option value="<?php echo $m_code;?>"><?php echo $m_fullname;?></option><?php } ?></select></td><td><button class="btn btn-primary btn-xs add_convert" type="button" style="cursor: pointer;">+</button> <button class="btn btn-danger btn-xs remove_convert" type="button" style="cursor: pointer;">-</button></td></tr>';
            $('.appending_div_cell_convert').append(field);
            $('.select2').select2({
                placeholder: 'Choose one',
                searchInputPlaceholder: 'Search options'
            });
            b++;
            });

            $(document).on('click', '.remove_convert', function() {
                $(this).closest('tr').remove();
            });
        })
    </script>



    <script>
        function record_new_cell_show_loader() {
            if ($('#cell_name').val() != '' && $('#cell_address').val() != '')
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

            // Basic with search
            $('.select3').select2({
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
    <?php // include("includes/no_click.php");?>
</body>

</html>