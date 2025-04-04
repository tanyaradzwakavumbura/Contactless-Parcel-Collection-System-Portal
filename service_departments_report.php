<?php
include("includes/forms.php");
include("includes/session.php");

$find_all_service_departments = $connect->prepare("SELECT * FROM departments");
$find_all_service_departments->execute();
$count_all_service_departments = $find_all_service_departments->rowCount();
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

    <!-- jQuery library -->
    <script src="assets/jquery.min.js"></script>

    <!-- jQuery UI library -->
    <link rel="stylesheet" href="assets/jquery-ui.css">
    <script src="assets/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="assets/css/loader.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>


    
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
                                <li class="breadcrumb-item active" aria-current="page">Service Departments Report</li>
                            </ol>
                        </nav>
                        <h4 class="mg-b-0 tx-spacing--1">Service Departments Report</h4>
                      
                    </div>
                    <div class="d-none d-md-block">

                        <a href="search_partnership_report.php"
                            class="btn btn-sm pd-x-15 btn-warning btn-uppercase mg-l-5"><i data-feather="book"
                                class="wd-10 mg-r-5"></i>Partnership Reports</a>

                        <button onclick="generateReport()"
                            class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="download"
                                class="wd-10 mg-r-5"></i> Download PDF Report</button>
                    </div>
                </div>
             
                <div id="report-content">
                    <div class="row row-xs">
                        <div class="container mt-4">
                            <header class="text-center mb-4">
                                <h2 class="display-6">Service Departments Report</h2>
                                <p class="lead mb-0">Total Departments: <?php echo $count_all_service_departments;?></p>
                            </header>

                          
                            <div class="col-lg-12 col-xl-12">
                                <br>
                                <div class="table-responsive">
                                                <table class="table table-striped mg-b-0 table-bordered table-hover">
                                                    <thead class="thead-primary">
                                                        <tr>
                                                            <th scope="col">Departments</th>
                                                            <th scope="col">Total Members</th>
                                                           
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      <?php
                                                      $find_all_service_departments = $connect->prepare("SELECT * FROM departments");
                                                      $find_all_service_departments->execute();
                                                      while($row=$find_all_service_departments->fetch(PDO::FETCH_ASSOC)){
                                                        $service_department_name = $row["name"];
                                                        $service_department_code = $row["code"];

                                                        $find_members_in_department = $connect->prepare("SELECT * FROM members WHERE service_department = ?");
                                                        $find_members_in_department->execute([$service_department_code]);
                                                        $count_members_in_department = $find_members_in_department->rowCount();
                                                     
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $service_department_name;?></td>
                                                            <td><?php echo $count_members_in_department;?></td>
                                                           
                                                        </tr>
                                                        <?php
                                                      }
                                                      ?>
                                                    </tbody>
                                                </table>
                                            </div><!-- table-responsive -->
                               
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div><!-- row -->
        </div><!-- container -->
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


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


    <?php // include("includes/no_click.php");?>

    <script>
    function generateReport() {
        document.getElementById('loader').style.display = 'block';
        // Choose the element that your content will be rendered to
        const element = document.getElementById('report-content');

        // PDF generation options
        const opt = {
            margin: [0.5, 0, 0.5, 0], // Top, right, bottom, left
            filename: "Service Departments Report.pdf",
            image: {
                type: 'jpeg',
                quality: 0.5
            }, // High-quality image rendering
            html2canvas: {
                scale: 2
            }, // High resolution for better clarity
            jsPDF: {
                unit: 'in',
                format: 'letter',
                orientation: 'landscape'
            },
            pagebreak: {
                mode: ['css', 'legacy'], // Avoid breaking containers
                avoid: '.no-break', // Prevent breaks within elements with these classes
                before: '.page-break', // Page break before elements with this class
            },
        };

        // Generate and save the PDF with page numbers
        html2pdf()
            .set(opt)
            .from(element)
            .toPdf()
            .get('pdf')
            .then(function(pdf) {
                let totalPages = pdf.internal.getNumberOfPages();

                // Add page numbers to all pages
                const pageWidth = pdf.internal.pageSize.getWidth();
                for (let i = 1; i <= totalPages; i++) {
                    pdf.setPage(i);
                    pdf.setFontSize(8); // Smaller font size
                    pdf.text(
                        `Page ${i} of ${totalPages}`, // Page number text
                        pageWidth - 0.5, // 0.5 inches from the right edge
                        0.5, // 0.5 inches from the top
                        {
                            align: 'right'
                        }
                    );
                }
            })
            .save()
            .finally(function() {
                document.getElementById('loader').style.display = 'none';
            });
    }
    </script>

</body>

</html>