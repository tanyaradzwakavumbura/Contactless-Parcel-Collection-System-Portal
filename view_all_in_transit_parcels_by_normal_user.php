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

    <!-- jQuery library -->
    <script src="assets/jquery.min.js"></script>

    <!-- jQuery UI library -->
    <link rel="stylesheet" href="assets/jquery-ui.css">
    <script src="assets/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="assets/css/loader.css">
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
                                <li class="breadcrumb-item active" aria-current="page">View All In-Trasnit Parcels</li>
                            </ol>
                        </nav>
                        <h4 class="mg-b-0 tx-spacing--1">View All In-Transit Parcels</h4>
                           
                    </div>
                    <div class="d-none d-md-block">
                        <a href="view_pending_parcels_normal_user" class="btn btn-sm pd-x-15 btn-primary btn-uppercase"><i data-feather="book" class="wd-10 mg-r-5"></i>Pending Parcels</a>
                        
                        <a href="view_all_delivered_parcels_normal_user" class="btn btn-sm pd-x-15 btn-warning btn-uppercase"><i data-feather="book" class="wd-10 mg-r-5"></i>Delivered Parcels</a>
                        
                    </div>
                </div>
                <hr>
                <div class="row col-12">
                    <div data-label="Example" class="df-example demo-table col-md-12">
                        <br>
                        <table id="example1" class="table table-hover table-bordered">
                            <thead class="thead-gray-100">
                                <tr>
                                    <th class="wd-10p">Parcel Code</th>
                                    <th class="wd-20p">Province</th>
                                    <th class="wd-20p">Locker</th>
                                    <th class="wd-20p">Receiver Name</th>
                                    <th class="wd-20p">Receiver Phone</th>
                                   
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                               
                               
                               if($role == "normal_user"){
                                    $find_all_in_transit_parcels = $connect->prepare("SELECT * FROM parcels WHERE sender=? AND status=?");
                                    $statp = "InTransit";
                                    $find_all_in_transit_parcels->execute([$user,$statp]);

                               }else{
                                    $find_all_full_time_members = $connect->prepare("SELECT * FROM members WHERE member_status=? AND cell_group=?");
                                    $m_status = "member";
                                    $find_all_full_time_members->execute([$m_status,$cell_code]);
                               }
                               
                               
                              
                               
                                while($row=$find_all_in_transit_parcels->fetch(PDO::FETCH_ASSOC)){
                                    //SELECT `id`, `code`, `size`, `province`, `locker`, `sender_phone`, `sender_address`, `receiver_fullname`, `receiver_phone`, `receiver_address`, `status`, `date`, `time`, `sender`, `transporter` FROM `parcels` WHERE 1
                                    $par_id = $row["id"];
                                    $par_code = $row["code"];
                                    $par_province = $row["province"];
                                    $par_locker = $row["locker"];
                                    $par_receiver_fullname = $row["receiver_fullname"];
                                    $par_receiver_phone = $row["receiver_phone"];

                                 
                               ?>
                                <tr>
                                    <td>
                                        <?php
                                        echo $par_code;
                                        ?>
                                    </td>
                                    <td><?php echo $par_province;?></td>
                                    <td><?php echo $par_locker;?></td>
                                    <td><?php echo $par_receiver_fullname;?></td>
                                    <td><?php echo $par_receiver_phone;?></td>
                                 
                                   
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


   
    <script>
        function update_vehicle_details_show_loader() {
            if ($('#u_vehicle_plate').val() != '' && $('#u_vehicle_driver').val() != '' && $('#category_minutes').val() != '')
                $('#loader').show();
        }
    </script>
    
    
     <script>
        function update_category_show_loader() {
             if ($('#u_cat_name').val() != '' && $('#u_cat_cost').val() != '' && $('#u_cat_minutes').val() != '')
                $('#loader').show();
        }
    </script>
    
    

    
  
    <script>
        $(function() {
            'use strict'

            $('#example1').DataTable({
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                }
            });

            $('#example2').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                }
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
                    lengthMenu: '_MENU_ items/page',
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