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
    <link href="lib/select2/css/select2.min.css" rel="stylesheet">


    <script src="assets/jquery.min.js"></script>

    <!-- jQuery UI library -->
    <link rel="stylesheet" href="assets/jquery-ui.css">
    <script src="assets/jquery-ui.min.js"></script>
    
    <script type="text/javascript">
        $(function() {
            $('#vehicle_code').autocomplete({
                source: 'includes/methods/vehicles.php'
            });
        });
    </script>

<script type="text/javascript">
        $(function() {
            $('#vehicle_code_exit').autocomplete({
                source: 'includes/methods/exit_vehicles.php'
            });
        });
    </script>

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
                                <li class="breadcrumb-item active" aria-current="page">ZIMPOST CPCS Portal</li>
                            </ol>
                        </nav>
                        <h4 class="mg-b-0 tx-spacing--1">Welcome to ZIMPOST Contactless Parcel Collection System Portal</h4>

                    </div>
                </div>
                <?php
                switch($role){
                    case "admin":
                        include("includes/dashboards/admin.php");
                        break;
                        
                    case "transporter":
                        include("includes/dashboards/transporter.php");
                        break;
                        
                    case "normal_user":
                        include("includes/dashboards/normal_user.php");
                        break;
                }
                ?>


            </div><!-- container -->
        </div>
    </div>


   
    <script src="chartjs/chart.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
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
    <script src="lib/select2/js/select2.min.js"></script>

    <script src="assets/js/dashforge.js"></script>
    <script src="assets/js/loader.js"></script>


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
            placeholder: 'Search for a vehicle',
            allowClear: true,
            escapeMarkup: function (markup) { return markup; },
            language: {
          noResults: function() {

          return `
              <button class="btn btn-primary btn-lg mb-4" onclick="registerVehicle()">Register Vehicle</button>
            `;
          }
        },
        })
// Your logic to handle vehicle registration
$('#record_unregistered_vehicle').modal('show');
$('#new_vehicle_plate').val(searchText);
//alert('Register Vehicle button clicked! Search text: ' + searchText);
}


      $(function(){
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
            placeholder: 'Search for a vehicle',
            allowClear: true,
            escapeMarkup: function (markup) { return markup; },
            language: {
          noResults: function() {

          return `
              <button class="btn btn-primary mb-4" onclick="registerVehicle()">Register Vehicle</button>
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
        function checkConnectivity(url = "https://www.google.com") {
            return fetch(url, { mode: 'no-cors' })
                .then(() => true)
                .catch(() => false);
        }

        function runUrl(urls) {
            setInterval(async () => {
                const isConnected = await checkConnectivity();
                if (isConnected) {
                    urls.forEach(url => {
                        fetch(url, { mode: 'no-cors' })
                            .then(() => {
                                console.log(`URL checked at ${new Date().toLocaleTimeString()}: ${url}`);
                            })
                            .catch(error => {
                                console.error(`Failed to reach URL ${url}: ${error}`);
                            });
                    });
                } else {
                    console.log("No Internet connection.");
                }
            }, 30000); // 30 seconds
        }


      //  runUrl(urlsToCheck);
    </script>

<script>
function updateVehicleList() {
    $.ajax({
        url: 'includes/ajax/get_vehicles.php',
        method: 'GET',
        success: function(data) {
            let select = $('#vehicle_plate_exit');
            let currentValue = select.val();
            
            select.empty();
            select.append('<option value="">Choose Vehicle</option>');
            
            data.forEach(function(vehicle) {
                select.append(`<option value="${vehicle.plate}">${vehicle.plate}</option>`);
            });
            
            // Restore previous selection if it still exists
            if (currentValue && data.some(v => v.plate === currentValue)) {
                select.val(currentValue);
            }
            
            // If using Select2, refresh it
            select.trigger('change');
        },
        error: function(xhr, status, error) {
            console.error('Error fetching vehicles:', error);
        }
    });
}

// Update list every 5 seconds
$(document).ready(function() {
    updateVehicleList();
    setInterval(updateVehicleList, 5000);
});
</script>
    
    <script>
    document.getElementById('open_boomgate_entrance').addEventListener('click', function() {
        document.getElementById('vehicle_code').setAttribute('required', 'required');
    });

    document.getElementById('close_boomgate_entrance').addEventListener('click', function() {
        document.getElementById('vehicle_code').removeAttribute('required');
    });
</script>

<script>
        function updateDateTime() {
            var dateTimeElement = document.getElementById('datetime');
            var now = new Date();
            var dateTimeString = now.toLocaleString();
            dateTimeElement.textContent = dateTimeString;
        }

        // Update the date and time every second
        setInterval(updateDateTime, 1000);

        // Initial update
        updateDateTime();
    </script>


<script>
        $(function() {
            'use strict'

            var ctx1 = document.getElementById('chartBar1').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: [
                        '12/01/2025', '19/01/2025'
                    ],

                    datasets: [
                        {
                        data: [
                            56, 70
                        ],
                        backgroundColor: '#13687f',
                        label: 'Total Member Attendance'
                    },
                    {
                        data: [
                            45.45, 50.45
                        ],
                        backgroundColor: '#65e0e0',
                        label: 'Total Amount Collected ($USD)'
                    },
                    {
                        data: [
                            45, 60
                        ],
                        backgroundColor: '#b5ac63',
                        label: 'First Timers'
                    }

                ]


                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: true,
                        labels: {
                            display: true
                        }
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            barPercentage: 0.5
                        }],
                        yAxes: [{
                            gridLines: {
                                color: '#ebeef3'
                            },
                            ticks: {
                                fontColor: '#8392a5',
                                fontSize: 10,
                                min: 0,

                            }
                        }]
                    }
                }
            });


            /** PIE CHART **/
            var datapie = {

            labels: ['Male Members', 'Female Members'],
            datasets: [{
                data: [<?php echo $count_total_male_members?>,<?php echo $count_total_female_members;?>],
                backgroundColor: ['#7ebcff', '#5368FA', '#7ee5e5', '#fdbd88']
                }]
            };

            var optionpie = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false,
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            };

            // For a pie chart
            var ctx2 = document.getElementById('chartDonut');
            var myDonutChart = new Chart(ctx2, {
                type: 'doughnut',
                data: datapie,
                options: optionpie
            });


            $.plot('#flotChart1', [{
                data: df1,
                color: '#c0ccda',
                lines: {
                    fill: true,
                    fillColor: '#f5f6fa'
                }
            }, {
                data: df3,
                color: '#0168fa',
                lines: {
                    fill: true,
                    fillColor: '#d1e6fa'
                }
            }], {
                series: {
                    shadowSize: 0,
                    lines: {
                        show: true,
                        lineWidth: 1.5
                    }
                },
                grid: {
                    borderWidth: 0,
                    labelMargin: 0
                },
                yaxis: {
                    show: false,
                    max: 65
                },
                xaxis: {
                    show: false,
                    min: 40,
                    max: 100
                }
            });


            $.plot('#flotChart2', [{
                data: df2,
                color: '#66a4fb',
                lines: {
                    show: true,
                    lineWidth: 1.5,
                    fill: .03
                }
            }, {
                data: df1,
                color: '#00cccc',
                lines: {
                    show: true,
                    lineWidth: 1.5,
                    fill: true,
                    fillColor: '#fff'
                }
            }, {
                data: df3,
                color: '#e3e7ed',
                bars: {
                    show: true,
                    lineWidth: 0,
                    barWidth: .5,
                    fill: 1
                }
            }], {
                series: {
                    shadowSize: 0
                },
                grid: {
                    aboveData: true,
                    color: '#e5e9f2',
                    borderWidth: {
                        top: 0,
                        right: 1,
                        bottom: 1,
                        left: 1
                    },
                    labelMargin: 0
                },
                yaxis: {
                    show: false,
                    min: 0,
                    max: 100
                },
                xaxis: {
                    show: true,
                    min: 40,
                    max: 80,
                    ticks: 6,
                    tickColor: 'rgba(0,0,0,0.04)'
                }
            });

            var df3data1 = [
                [0, 12],
                [1, 10],
                [2, 7],
                [3, 11],
                [4, 15],
                [5, 20],
                [6, 22],
                [7, 19],
                [8, 18],
                [9, 20],
                [10, 17],
                [11, 19],
                [12, 18],
                [13, 14],
                [14, 9]
            ];
            var df3data2 = [
                [0, 0],
                [1, 0],
                [2, 0],
                [3, 2],
                [4, 5],
                [5, 2],
                [6, 12],
                [7, 15],
                [8, 10],
                [9, 8],
                [10, 10],
                [11, 7],
                [12, 2],
                [13, 4],
                [14, 0]
            ];
            var df3data3 = [
                [0, 2],
                [1, 1],
                [2, 2],
                [3, 4],
                [4, 2],
                [5, 1],
                [6, 0],
                [7, 0],
                [8, 5],
                [9, 2],
                [10, 8],
                [11, 6],
                [12, 9],
                [13, 2],
                [14, 0]
            ];
            var df3data4 = [
                [0, 0],
                [1, 5],
                [2, 2],
                [3, 0],
                [4, 2],
                [5, 7],
                [6, 10],
                [7, 12],
                [8, 8],
                [9, 6],
                [10, 4],
                [11, 2],
                [12, 0],
                [13, 0],
                [14, 0]
            ];

            var flotChartOption1 = {
                series: {
                    shadowSize: 0,
                    bars: {
                        show: true,
                        lineWidth: 0,
                        barWidth: .5,
                        fill: 1
                    }
                },
                grid: {
                    aboveData: true,
                    color: '#e5e9f2',
                    borderWidth: 0,
                    labelMargin: 0
                },
                yaxis: {
                    show: false,
                    min: 0,
                    max: 25
                },
                xaxis: {
                    show: false
                }
            };

            $.plot('#flotChart3', [{
                data: df3data1,
                color: '#e5e9f2'
            }, {
                data: df3data2,
                color: '#66a4fb'
            }], flotChartOption1);


            $.plot('#flotChart4', [{
                data: df3data1,
                color: '#e5e9f2'
            }, {
                data: df3data3,
                color: '#7ee5e5'
            }], flotChartOption1);

            $.plot('#flotChart5', [{
                data: df3data1,
                color: '#e5e9f2'
            }, {
                data: df3data4,
                color: '#f77eb9'
            }], flotChartOption1);

        })
    </script>

</body>

</html>