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
    <link rel="stylesheet" href="assets/css/loader.css">
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>


    <style>
    .white-text {
        color: white !important;
    }

    .ui-datepicker {
        z-index: 1051 !important;
        /* Ensure date picker appears above the modal */
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
                                <li class="breadcrumb-item active" aria-current="page">PerformSoft HR Toolkit </li>
                            </ol>
                        </nav>

                        <h4 class="mg-b-0 tx-spacing--1">Welcome to HR Toolkit Dashboard</h4>

                    </div>
                    <div class="d-none d-md-block">
                       
                        <a href="#change_period" data-toggle="modal"
                            class="btn btn-sm pd-x-15 btn-warning btn-uppercase mg-l-5"><i data-feather="calendar"
                                class="wd-10 mg-r-5"></i> Change Period</a>

                        <button onclick="generateReport()"
                            class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="loader"
                                class="wd-10 mg-r-5"></i> Download Company Report</button>

                    </div>
                </div>
                
                <div id="report-content">
                    <div class="row row-xs">
                        <div class="container mt-4">
                          
                         

                         
                     
                            <div class="page-break"></div>
                            <section class="text-center mt-5">
                                <h2 class="h2 text-dark fw-bold text-uppercase">End of Report</h2>
                                <p class="lead">This concludes the report. Thank you for reviewing.</p>
                            </section>

                            <footer class="text-center mt-4">
                                <p class="text-muted">&copy; <?php echo date("Y");?> HR Toolkit Report | Performsoft PVT LTd</p>
                            </footer>


                        </div>


                        <br>

                    </div><!-- row -->
                </div>

                <div class="modal fade" id="new_client" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel6"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content tx-14">
                            <form method="POST">
                                <div class="modal-header bg-primary text-white">
                                    <h6 class="modal-title" id="exampleModalLabel6" style="color: white !important;">
                                        Welcome to HR
                                        Toolkik : Powered by PerformSoft</h6>
                                    <button type="button" class="close text-white" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <input type="text" name="the_client" value="<?php echo $client_code;?>" hidden>


                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active text-center" id="kpis" role="tabpanel"
                                            aria-labelledby="kpis-tab">
                                            <p><strong><?php echo $client_name; ?></strong></p>
                                            <p>You have selected <strong><?php echo $count_all_client_kpis;?></strong>
                                                Key Performance
                                                Indicators. Your total monthly cost is going to be
                                                <strong><?php echo format_money($total_client_cost);?></strong> per
                                                month
                                            </p>
                                        </div>

                                    </div>
                                </div>

                                <div class="modal-footer justify-content-center">
                                    <button type="submit" name="done_with_onboarding_thank_you"
                                        class="btn btn-primary tx-13">
                                        <i class="fas fa-thumbs-up"></i> Thank You
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- container -->
        </div>
    </div>


    <script src="lib/jquery/jquery.min.js"></script>
    <script src="chartjs/chart.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script src="lib/feather-icons/feather.min.js"></script>
    <script src="lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="lib/jquery.flot/jquery.flot.js"></script>
    <script src="lib/jquery.flot/jquery.flot.stack.js"></script>
    <script src="lib/jquery.flot/jquery.flot.resize.js"></script>

    <script src="lib/jqvmap/jquery.vmap.min.js"></script>
    <script src="lib/jqvmap/maps/jquery.vmap.usa.js"></script>

    <script src="assets/js/dashforge.js"></script>
    <script src="assets/js/dashforge.aside.js"></script>
    <script src="assets/js/dashforge.sampledata.js"></script>

    <!-- append theme customizer -->
    <script src="lib/js-cookie/js.cookie.js"></script>
    <script src="assets/js/dashboard-one.js"></script>
    <script src="assets/js/dashforge.settings.js"></script>

    <script src="assets/js/dashforge.js"></script>
    <script src="assets/js/loader.js"></script>
 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>





    

    <script>
    function generateReport() {
    // Show loader
    document.getElementById('loader').style.display = 'block';

    // Select the element to convert to PDF
    const element = document.getElementById('report-content');

    // Configure the PDF options
    const opt = {
        margin: [0.5, 0.5, 0.5, 0.5],
        filename: "<?php echo $client_name.' Company Report '.$current_datetime; ?>.pdf",
        image: { type: 'jpeg', quality: 1 },
        html2canvas: { scale: 2, useCORS: true, allowTaint: false },
        jsPDF: { unit: 'in', format: 'a4', orientation: 'landscape' },
        pagebreak: { mode: ['avoid-all', 'css', 'legacy'], before: '.page-break', after: '.page-break' }
    };

    function addPageNumbers(pdf) {
        const totalPages = pdf.internal.getNumberOfPages();
        for (let i = 1; i <= totalPages; i++) {
            pdf.setPage(i);
            pdf.setFontSize(10);
            pdf.text(`Page ${i} of ${totalPages}`, pdf.internal.pageSize.width / 2, pdf.internal.pageSize.height - 0.5, { align: 'center' });
        }
    }

    html2pdf()
        .set(opt)
        .from(element)
        .toPdf()f
        .get('pdf')
        .then(function(pdf) {
            addPageNumbers(pdf);
        })
        .save()
        .then(() => {
            // Hide loader when PDF is saved
            document.getElementById('loader').style.display = 'none';
        });
}

window.onload = function() {
    const sections = document.querySelectorAll('.section');
    sections.forEach((section, index) => {
        if (index < sections.length - 1) {
            section.classList.add('page-break');
        }
    });
};

    </script>


    </script>
    <!-- Modals -->
    <script>
    $(function() {
        'use strict'

        // Convert the date string to a Date object
        function parseDateString(dateString) {
            var parts = dateString.split('-');
            return new Date(parts[0], parts[1] - 1, parts[2]);
        }

        var minDate = parseDateString("2024-01-01");
        var maxDate = parseDateString("<?php echo $current_date;?>");

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

        $('#datepicker4').datepicker();

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
                numberOfMonths: 2,
                minDate: minDate,
                maxDate: maxDate
            })
            .on('change', function() {
                to.datepicker('option', 'minDate', getDate(this));
            }),
            to = $('#dateTo').datepicker({
                defaultDate: '+1w',
                numberOfMonths: 2,
                minDate: minDate,
                maxDate: maxDate
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

    <?php
   include("includes/change_period_modal.php")
   ?>

</body>

</html>