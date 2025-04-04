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
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Service Attendance Form</li>
                            </ol>
                        </nav>

                    </div>
                    <div class="d-none d-md-block">

                        <a href="dashboard.php" class="btn btn-sm pd-x-15 btn-warning btn-uppercase mg-l-5"><i
                                data-feather="book" class="wd-10 mg-r-5"></i>Back to Dashboard</a>

                    </div>
                </div>

                <div class="row row-xs">
                    <div class="col-lg-8 col-xl-12">
                        <div class="card">
                            <div
                                class="card-header bd-b-0 pd-t-20 pd-lg-t-25 pd-l-20 pd-lg-l-25 d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">

                            </div><!-- card-header -->
                            <div class="card-body pd-lg-25">
                                <div class="row align-items-sm-end">
                                    <div class="col-lg-12 col-xl-12">
                                        <center>
                                            <img src="images/login.png" width="20%" alt="">
                                            <h4>Service Attendance Form for <?php echo format_date($current_date);?>
                                            </h4>
                                        </center>

                                        <form action="" method="POST" enctype="multipart/form-data">
                                            <?php
                                            include("includes/alert.php");
                                            ?>

                                            <input type="text" name="member_code"
                                                value="<?php echo calculateMemberCode($connect);?>" hidden>

                                            <div class="form-group">

                                                <select name="member" id="new_member_name"
                                                    class="form-control form-control-lg select2"
                                                    style="width: 100%; font-size: 1.2rem; padding: 10px; border-color: #7CB74B; border-width: 1px; border-radius: 10px;">
                                                    <option value="">Choose Member</option>
                                                    <?php
                                                    $find_all_members = $connect->prepare("SELECT * FROM members");
                                                    $find_all_members->execute([]);
                                                    while($row=$find_all_members->fetch(PDO::FETCH_ASSOC)){
                                                        $m_code = $row["code"];
                                                        $m_fullname = $row["fullname"];

                                                        ?>
                                                    <option value="<?php echo $m_code;?>"><?php echo $m_fullname;?>
                                                    </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                           

                                            <center>
                                                <button type="submit" onclick="record_service_attendance_show_loader()"
                                                    class="btn btn-primary" name="record_service_attendance"
                                                    style="font-size: 1.5rem; padding: 15px 30px; border-radius: 20px;">Record
                                                    Attendance</button>
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
    function update_member_details_show_loader() {
        if ($('#member_name').val() != '' && $('#m_phone_number').val() != '' && $('#m_email').val() != '' && $(
                '#m_address').val() != '' && $('#m_kingschat_handle').val() != '' && $('#m_gender')
            .val() != '' && $('#m_member_status').val() != '' && $('#m_cell_group').val() != '' && $(
                '#m_service_department').val() != '')
            $('#loader').show();
    }
    </script>


<script>
    function record_service_attendance_show_loader() {
        if ($('#member').val() != '')
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


    let searchText = '';

    function registerVehicle() {
        $('.select2').select2().trigger("select2:close");
        $('.select2').select2({
            placeholder: 'Search for a Member',
            allowClear: true,
            escapeMarkup: function(markup) {
                return markup;
            },
            language: {
                noResults: function() {

                    return `
              <center><button class="btn btn-primary btn-lg mb-4" onclick="registerVehicle()">Register New Member</button></center>
            `;
                }
            },
        })
        // Your logic to handle vehicle registration
        $('#record_unregistered_vehicle').modal('show');
        $('#member_name').val(searchText);
        //alert('Register Vehicle button clicked! Search text: ' + searchText);
    }


    $(function() {
        'use strict'

        // Basic with search
        $('.select2').select2({
            placeholder: 'Choose one',
            searchInputPlaceholder: 'Search options',
            allowClear: true,
            width: '100%' // Ensure the width matches the form-control
        });

        // Disable search
        $('.select2-no-search').select2({
            minimumResultsForSearch: Infinity,
            placeholder: 'Choose one',

        });



        $('.select2').select2({
            placeholder: 'Search for a Member',
            allowClear: true,
            escapeMarkup: function(markup) {
                return markup;
            },
            language: {
                noResults: function() {

                    return `
              <center<button class="btn btn-primary mb-4" onclick="registerVehicle()">Register New Member</button></center>
            `;
                }
            },
        })





        // Capture the search text
        $('.select2').on('select2:open', function() {
            $('.select2-search__field').on('input', function() {
                searchText = $(this).val();
            });
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

    <?php //include("includes/no_click.php");?>
</body>

<!-- Modals -->
<div class="modal fade" id="record_unregistered_vehicle" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel6" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content tx-14">
            <form method="POST">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel6">Record New Member</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <input type="text" name="member_code" value="<?php echo calculateMemberCode($connect);?>" hidden>

                    <div class="form-group">
                        <label class="d-block">Full Name</label>
                        <input type="text" style="border-color:#7CB74B; border-width:1px; border-radius:10px"
                            class="form-control" id="member_name" name="m_full_name"
                            placeholder="Enter Member Full Name" required>
                    </div>
                    
                     <div class="form-group">
                        <label class="d-block">Date of Birth</label>
                        <input type="date" style="border-color:#7CB74B; border-width:1px; border-radius:10px"
                            class="form-control" id="member_dob" name="member_dob"
                            placeholder="Enter Member Full Name" required>
                    </div>
                   
                    <div class="form-group">
                        <label class="d-block">Phone Number</label>
                        <input type="text" style="border-color:#7CB74B; border-width:1px; border-radius:10px"
                            class="form-control" id="m_phone_number" name="m_phone_number"
                            placeholder="Enter Phone Number starting with country code eg +263 776 504 919" required>
                    </div>

                    <div class="form-group">
                        <label class="d-block">Email Address</label>
                        <input type="email" style="border-color:#7CB74B; border-width:1px; border-radius:10px"
                            class="form-control" id="m_email" name="m_email" placeholder="Enter Member Email Address"
                            required>
                    </div>

                    <div class="form-group">
                        <label class="d-block">Physical Address</label>
                        <input type="text" style="border-color:#7CB74B; border-width:1px; border-radius:10px"
                            class="form-control" id="m_address" name="m_address"
                            placeholder="Enter Member Location Address" required>
                    </div>

                    <div class="form-group">
                        <label class="d-block">Gender</label>
                        <select name="m_gender" id="m_gender" class="form-control" required
                            style="border-color:#7CB74B; border-width:1px; border-radius:10px">
                            <option value="">Choose Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="d-block">KingsChat Handle</label>
                        <input type="text" style="border-color:#7CB74B; border-width:1px; border-radius:10px"
                            class="form-control" id="m_kingschat_handle" name="m_kingschat_handle"
                            placeholder="Enter Member Kingschat Handle">
                    </div>

                   <!-- <div class="form-group">
                        <label class="d-block">Foundation School Status</label>
                        <select name="m_foundation_school_status" id="m_foundation_school_status" class="form-control"
                            required style="border-color:#7CB74B; border-width:1px; border-radius:10px">
                            <option value="">Choose Foundation School Status</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>-->

                   <!-- <div class="form-group">
                        <label class="d-block">Baptism Status</label>
                        <select name="m_baptsim_status" id="m_baptsim_status" class="form-control" required
                            style="border-color:#7CB74B; border-width:1px; border-radius:10px">
                            <option value="">Choose Baptism Status</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>-->
                  
                    <div class="form-group">
                        <label class="d-block">Name of Cell Group</label>
                        <select name="m_cell_group" id="m_cell_group" class="form-control" required
                            style="border-color:#7CB74B; border-width:1px; border-radius:10px">
                            <option value="">Choose Cell</option>
                            <?php
                            $find_all_departments = $connect->prepare("SELECT * FROM cells");
                            $find_all_departments->execute();
                            while($row=$find_all_departments->fetch(PDO::FETCH_ASSOC)){
                                $cell_code = $row["code"];
                                $cell_name = $row["name"];
                            ?>
                            <option value="<?php echo $cell_code;?>"><?php echo $cell_name;?></option>
                            <?php
                            }
                            ?>
                            <option value="No-Cell">No Cell</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="d-block">Service Department</label>
                        <select name="m_service_department" id="m_service_department" class="form-control" required
                            style="border-color:#7CB74B; border-width:1px; border-radius:10px">
                            <option value="">Choose Service Department</option>
                            <?php
                            $find_all_departments = $connect->prepare("SELECT * FROM departments");
                            $find_all_departments->execute();
                            while($row=$find_all_departments->fetch(PDO::FETCH_ASSOC)){
                                $dep_code = $row["code"];
                                $dep_name = $row["name"];
                            ?>
                            <option value="<?php echo $dep_code;?>"><?php echo $dep_name;?></option>
                            <?php
                            }
                            ?>
                            <option value="No-Department">No Department</option>
                        </select>
                    </div>
                   
                    <div class="form-group">
                        <label class="d-block">Membership Status</label>
                        <select name="m_member_status" id="m_member_status" class="form-control" required
                            style="border-color:#7CB74B; border-width:1px; border-radius:10px">
                            <option value="">Choose Membership Status</option>
                            <option value="first_timer">First Timer</option>
                            <option value="member">Full Member</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">

                    <button type="submit" name="register_member_and_record_attendance"
                        onclick="update_member_details_show_loader()" class="btn btn-primary tx-13">Register
                        Member</button>
                       
                </div>
            </form>
        </div>
    </div>
</div>

</html>