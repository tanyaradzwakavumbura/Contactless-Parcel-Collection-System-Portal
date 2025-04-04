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
                        <?php
                        if($role == "admin"){
                            ?>
                            <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View All Converts</li>
                            </ol>
                        </nav>
                        <h4 class="mg-b-0 tx-spacing--1">View All Converts</h4>
                            <?php
                        }elseif($role == "cell"){
                            ?>
                            <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View All Cell Converts</li>
                            </ol>
                        </nav>
                        <h4 class="mg-b-0 tx-spacing--1">View All Cell Converts : <?php echo $cell_name;?></h4>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="d-none d-md-block">
                        
                        <?php
                        if($role == "admin"){
                            ?>
                            <a href="record_new_member.php" class="btn btn-sm pd-x-15 btn-primary btn-uppercase"><i data-feather="book" class="wd-10 mg-r-5"></i>Register New Member</a>
                        
                        <a href="view_all_first_time_members.php" class="btn btn-sm pd-x-15 btn-warning btn-uppercase"><i data-feather="book" class="wd-10 mg-r-5"></i>Manage First Time Members</a>
                            <?php
                        }elseif($role == "cell"){
                            ?>
                            <a href="record_new_member.php" class="btn btn-sm pd-x-15 btn-primary btn-uppercase"><i data-feather="book" class="wd-10 mg-r-5"></i>Register Cell Convert</a>
                        
                            <?php
                        }
                        ?>
                    
                        
                    </div>
                </div>
                <hr>
                <div class="row col-12">
                    <div data-label="Example" class="df-example demo-table col-md-12">
                        <br>
                        <table id="example1" class="table table-hover table-bordered">
                            <thead class="thead-gray-100">
                                <tr>
                                    <th>Date</th>
                                    <th>Full Name</th>
                                    <th>Phone</th>
                                    <th>Cell</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                               
                               
                               if($role == "admin"){
                                    $find_all_full_time_members = $connect->prepare("SELECT * FROM members WHERE member_status=?");
                                    $m_status = "convert";
                                    $find_all_full_time_members->execute([$m_status]);
                               }elseif($role == "cell"){
                                    $find_all_full_time_members = $connect->prepare("SELECT * FROM members WHERE member_status=? AND cell_group=?");
                                    $m_status = "convert";
                                    $find_all_full_time_members->execute([$m_status,$cell_code]);
                               }
                               
                               
                              
                               
                                while($row=$find_all_full_time_members->fetch(PDO::FETCH_ASSOC)){
                                    $m_fullname = $row["fullname"];
                                    $m_phone_number = $row["phone_number"];
                                    $m_cell_group = $row["cell_group"];
                                    $m_service_department = $row["service_department"];
                                    $m_email = $row["email"];
                                    $m_code = $row["code"];
                                    $m_address = $row["address"];
                                    $m_kingchat_handle = $row["kingchat_handle"];
                                    $m_foundation_school = $row["foundation_school"];
                                    $m_baptism_status = $row["baptism_status"];
                                    $m_date = $row["date"];
                                    $m_member_status = $row["member_status"];
                                    
                                    $find_cell_query = $connect->prepare("SELECT * FROM cells WHERE code=?");
                                    $find_cell_query->execute([$m_cell_group]);
                                    while($row=$find_cell_query->fetch(PDO::FETCH_ASSOC)){
                                        $m_cell_name = $row["name"];
                                    }
                                 
                               ?>
                                <tr>
                                    <td><?php echo format_date($m_date);?></td>
                                    <td>
                                        <?php
                                        echo $m_fullname;
                                        ?>
                                    </td>
                                    <td><?php echo $m_phone_number;?></td>
                                    <td><?php echo $m_cell_name;?></td>
                                   
                                    
                                    <td>
                                        <div class="">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-xs dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Options
                                                </button>

                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a href="#category<?php echo $ve_id;?>" class="dropdown-item" data-toggle="modal">Update Member Details</a>
                                                    
                                                    <a href="#category<?php echo $ve_id;?>" class="dropdown-item" data-toggle="modal">Record Transaction</a>
                                                    <form method="post">
                                                        <input type="text" name="c_id" value="<?php echo $ve_id;?>" hidden>
                                                    <?php
                                                    if($role == "admin"){
                                                    ?>
                                                    
                                                        <button type="submit" name="delete_vehicle" class="dropdown-item"> View All Transactions</button>
                                                        
                                                        <button type="submit" name="delete_vehicle" class="dropdown-item">Deactivate Member</button>
                                                        
                                                       
                                                   
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
   
    
  
    <div class="modal fade" id="category<?php echo $ve_id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel6" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <form method="POST">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel6">Update Vehicle Details</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <input type="text" hidden name="the_id" value="<?php echo $ve_id;?>">
                    <input type="text" hidden name="the_code" value="<?php echo $ve_code;?>">

                    <div class="modal-body">
                    
                        <div class="form-group">
                            <label class="d-block">Vehicle Plate Number</label>
                            <input type="text" class="form-control" name="u_vehicle_plate" id="u_vehicle_plate" style="border-color:#7CB74B; border-width:1px; border-radius:10px" required placeholder="Update Vehicle Plate" value="<?php echo $ve_plate;?>">
                        </div>
                        
                        
                        <div class="form-group">
                            <label class="d-block">Vehicle Driver Fullname</label>
                            <input type="text" class="form-control" name="u_vehicle_driver" id="u_vehicle_driver" style="border-color:#7CB74B; border-width:1px; border-radius:10px" required placeholder="Update Vehicle Driver Fullname" value="<?php echo $ve_driver;?>">
                        </div>
                        
                       
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="update_vehicle_details" onclick="update_vehicle_details_show_loader()" class="btn btn-primary tx-13">Update Vehicle Details</button>
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