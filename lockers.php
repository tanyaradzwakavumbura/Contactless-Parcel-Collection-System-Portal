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
                                <li class="breadcrumb-item active" aria-current="page">View All Lockers</li>
                            </ol>
                        </nav>
                        <h4 class="mg-b-0 tx-spacing--1">View All Lockers</h4>
                         
                    </div>
                    <div class="d-none d-md-block">
                        
                            <a href="#add_new_locker_modal" class="btn btn-sm pd-x-15 btn-primary btn-uppercase" data-toggle="modal"><i data-feather="book" class="wd-10 mg-r-5"></i>Add New Locker</a>
                     
                    </div>
                </div>
                <hr>
                <div class="row col-12">
                    <div data-label="Example" class="df-example demo-table col-md-12">
                        <br>
                        <table id="example1" class="table table-hover table-bordered">
                            <thead class="thead-gray-100">
                                <tr>
                                    <th class="wd-10p">Locker Code</th>
                                    <th class="wd-20p">Locker Size</th>
                                    <th class="wd-20p">Location</th>
                                    <th class="wd-20p">Status</th>
                                    <th class="wd-10p">Option</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                $find_all_lockers = $connect->prepare("SELECT * FROM lockers");
                                $find_all_lockers->execute();
                                while($row=$find_all_lockers->fetch(PDO::FETCH_ASSOC)){
                                    $locker_code = $row['code'];
                                    $locker_size = $row['size'];
                                    $locker_location = $row['location'];
                                    $locker_status = $row['status'];
                                    $locker_id = $row['id'];

                                    $find_assigned_parcel = $connect->prepare("SELECT * FROM parcels WHERE locker=?");
                                    $find_assigned_parcel->execute([$locker_code]);
                                    $assigned_parcel = $find_assigned_parcel->rowCount();
                                    if($assigned_parcel == 0){
                                        $al = "Available";
                                        $tag = "badge badge-success";
                                    }else{
                                        while($row=$find_assigned_parcel->fetch(PDO::FETCH_ASSOC)){
                                            $assigned_parcel_status = $row['status'];
                                        }

                                        if($assigned_parcel_status == "Collected"){
                                            $al = "Available";
                                            $tag = "badge badge-success";
                                        }else if($assigned_parcel_status == "Pending"){
                                            $al = "Assigned";
                                            $tag = "badge badge-danger";
                                        }else if($assigned_parcel_status == "In Transit"){
                                            $al = "In Transit";
                                            $tag = "badge badge-warning";
                                        }
                                        
                                    }
    
                              
                               ?>
                                <tr>
                                    <td>
                                        <?php
                                        echo $locker_code;
                                        ?>
                                    </td>
                                   
                                    <td><?php echo $locker_size;?></td>
                                    <td><?php echo $locker_location;?></td>
                                    <td><span class="<?php echo $tag;?>"><?php echo $al;?></span></td>
                                   
                                    
                                    <td>
                                        <div class="">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-xs dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Options
                                                </button>

                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                   <!-- <a href="#update_locker<?php echo $locker_id;?>" class="dropdown-item" data-toggle="modal">Update Locker Details</a>-->
                                                
                                                    <form method="post">
                                                        <input type="text" name="c_id" value="<?php echo $locker_id;?>" hidden>
                                                    <?php
                                                    if($role == "admin"){
                                                    ?>
                                                        
                                                        <button type="submit" name="delete_locker" class="dropdown-item">Delete Locker</button>
                                                        
                                                        
                                                   
                                                    <?php
                                                    }
                                                    ?>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                   
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

    <!--Modals-->
   
    
  
    <div class="modal fade" id="add_new_locker_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel6" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <form method="POST">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel6">Record New Locker Details</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                    
                        <div class="form-group">
                            <label class="d-block">Locker Code</label>
                            <input type="text" class="form-control" name="locker_code" id="locker_code" style="border-color:#7CB74B; border-width:1px; border-radius:10px" required placeholder="Locker Code" value="<?php echo calculateLockerCode($connect);?>" readonly>
                        </div>
                        
                        
                        <div class="form-group">
                            <label class="d-block">Locker Size</label>
                            <select class="form-control" name="locker_size" id="locker_size" style="border-color:#7CB74B; border-width:1px; border-radius:10px" required>
                                <option value="">Choose Size</option>
                                <option value="Small">Small</option>
                                <option value="Medium">Medium</option>
                                <option value="Large">Large</option>
                            </select>
                        </div>
                       
                        <div class="form-group">
                            <label class="d-block">Locker Location</label>
                            <select class="form-control" name="locker_location" id="locker_location" style="border-color:#7CB74B; border-width:1px; border-radius:10px" required>
                                <option value="">Choose Province</option>
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
                        
                       
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="record_new_locker" onclick="record_new_locker_show_loader()" class="btn btn-primary tx-13">Record New Locker</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
 
    <!--End Modals-->

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