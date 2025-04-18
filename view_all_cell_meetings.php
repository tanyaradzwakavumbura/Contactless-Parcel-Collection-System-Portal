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
                                <li class="breadcrumb-item active" aria-current="page">View All Cell Meetings</li>
                            </ol>
                        </nav>
                        <h4 class="mg-b-0 tx-spacing--1">View All Cell Meetings</h4>
                    </div>
                    <div class="d-none d-md-block">
                        <a href="record_new_cell_meeting.php" class="btn btn-sm pd-x-15 btn-primary btn-uppercase"><i data-feather="book" class="wd-10 mg-r-5"></i>Record New Meetings</a>
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
                                    <th>Meeting</th>
                                    <th>Attendance</th>
                                    <th>Offerings</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $find_all_cell_meetings = $connect->prepare("SELECT * FROM cell_meetings WHERE cell=?");
                                $find_all_cell_meetings->execute([$cell_code]);
                                while($row=$find_all_cell_meetings->fetch(PDO::FETCH_ASSOC)){
                                    $m_meeting  = $row["meeting"];
                                    $m_code = $row["code"];
                                    $m_offerings = $row["offerings"];
                                    $m_attendance = $row["attendance"];
                                    $m_date = $row["date"];
                                
                                    $meeting_people = 0;

                                    $find_total_cell_meeting_members = $connect->prepare("SELECT * FROM cell_meeting_members WHERE code=?");
                                    $find_total_cell_meeting_members->execute([$m_code]);
                                    $meeting_people = $find_total_cell_meeting_members->rowCount();
                            
                                    $find_total_cell_meeting_converts = $connect->prepare("SELECT * FROM cell_meeting_convert_members WHERE code=?");
                                    $find_total_cell_meeting_converts->execute([$m_code]);
                                    $meeting_people += $find_total_cell_meeting_converts->rowCount();
                            
                                    $find_total_cell_meeting_first_timers = $connect->prepare("SELECT * FROM cell_meeting_first_timers WHERE code=?");
                                    $find_total_cell_meeting_first_timers->execute([$m_code]);
                                    $meeting_people += $find_total_cell_meeting_first_timers->rowCount();
                               ?>
                                <tr>
                                    <td><?php echo format_date($m_date);?></td>
                                    <td>
                                        <?php
                                        echo $m_meeting;
                                        ?>
                                    </td>
                                    <td><?php echo $meeting_people;?></td>
                                    <td><?php echo format_money($m_offerings);?></td>
                                    <td>
                                        <div class="">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-xs dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Options
                                                </button>

                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a href="#add_cell_meeting_first_timer<?php echo $m_code;?>" class="dropdown-item" data-toggle="modal">Record Cell Meeting First TImer</a>
                                                
                                                    <form method="post">
                                                        <input type="text" name="c_code" value="<?php echo $m_code;?>" hidden>
                                                        <button type="submit" name="view_cell_meeting_details" class="dropdown-item"> View Details</button>
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
   
    
    <?php
    $find_all_cell_meetings = $connect->prepare("SELECT * FROM cell_meetings WHERE cell=?");
    $find_all_cell_meetings->execute([$cell_code]);
    while($row=$find_all_cell_meetings->fetch(PDO::FETCH_ASSOC)){
        $m_meeting  = $row["meeting"];
        $m_code = $row["code"];
        $m_offerings = $row["offerings"];
        $m_attendance = $row["attendance"];
        $m_date = $row["date"];

        

       
                                
    ?>
    <div class="modal fade" id="add_cell_meeting_first_timer<?php echo $m_code;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel6" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <form method="POST">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel6">Record New Cell First Timer</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <input type="text" hidden name="the_cell_meeting" value="<?php echo $m_code;?>">

                    <input type="text" hidden name="the_new_member_code" value="<?php echo calculateMemberCode($connect);?>">

                    <input type="text" hidden name="the_cell_code" value="<?php echo $cell_code;?>">
                    
                    <div class="modal-body">
                    
                        <div class="form-group">
                            <label class="d-block">Full Name</label>
                            <input type="text" class="form-control" name="cell_meeting_member_fullname" id="cell_meeting_member_fullname" style="border-color:#7CB74B; border-width:1px; border-radius:10px" required placeholder="Enter Full Name">
                        </div>

                        <div class="form-group">
                            <label class="d-block">Phone Number</label>
                            <input type="text" class="form-control" name="cell_meeting_member_phone_number" id="cell_meeting_member_phone_number" style="border-color:#7CB74B; border-width:1px; border-radius:10px" required placeholder="Enter Phone Number">
                        </div>

                        <div class="form-group">
                            <label class="d-block">Gender</label>
                            <select name="cell_meeting_member_gender" id="cell_meeting_member_gender" class="form-control" style="border-color:#7CB74B; border-width:1px; border-radius:10px" required>
                                <option value="">Choose Gender</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                        
                       
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="record_cell_meeting_first_timer" onclick="record_cell_meeting_first_timer_show_loader()" class="btn btn-primary tx-13">Record Cell Meeting First Timer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
 
    <?php
    }
    ?>
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
        function record_cell_meeting_first_timer_show_loader() {
             if ($('#cell_meeting_member_fullname').val() != '' && $('#cell_meeting_member_phone_number').val() != '' && $('#cell_meeting_member_gender').val() != '')
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