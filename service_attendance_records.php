<?php
include("includes/forms.php");
include("includes/session.php");
if($role != "admin"){
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
                                <li class="breadcrumb-item active" aria-current="page">View All Service Attendance Records</li>
                            </ol>
                        </nav>
                        <h4 class="mg-b-0 tx-spacing--1">View All Service Attendance Records</h4>
                    </div>
                    <div class="d-none d-md-block">
                        
                        <a href="service_attendance_form.php" class="btn btn-sm pd-x-15 btn-primary btn-uppercase"><i data-feather="user" class="wd-10 mg-r-5"></i>Service Attendance Record</a>
                    
                        <a href="record_a_new_department.php" class="btn btn-sm pd-x-15 btn-warning btn-uppercase"><i data-feather="user" class="wd-10 mg-r-5"></i>Record New Department</a>
            
                    </div>
                </div>
                <hr>
                <div class="row col-12">
                    <div data-label="Example" class="df-example demo-table col-md-12">
                        <br>
                        <table id="example1" class="table table-hover table-bordered">
                            <thead class="thead-gray-100">
                                <tr>
                                    <th class="wd-15p">Date</th>
                                    <th class="wd-20p">Full Members</th>
                                    <th class="wd-20p">First Timers</th>
                                    <th class="wd-20p">Total Partnership</th>
                                    <th class="wd-10p">Option</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $find_data = $connect->prepare("SELECT DISTINCT(date) FROM member_attendance ORDER BY date LIMIT 100");
                                $find_data->execute();
                                while($row=$find_data->fetch(PDO::FETCH_ASSOC)){
                                    $m_date = $row["date"];

                                    $s = "";
                                    //$find_total_attendance_query = $connect->prepare("SELECT DISTINCT(member) FROM member_attendance WHERE date=? AND member !=?");
                                    //$find_total_attendance_query->execute([$service_date,$s]);

                                    $find_m_full_members = $connect->prepare("SELECT DISTINCT(member) FROM member_attendance WHERE member !=? AND member IN (SELECT code FROM members WHERE member_status=?) AND date=?");
                                    $m_member = "member";
                                    $find_m_full_members->execute([$s,$m_member,$m_date]);
                                    $count_all_m_full_members = $find_m_full_members->rowCount();

                                    $find_m_first_time_members = $connect->prepare("SELECT DISTINCT(member) FROM member_attendance WHERE member !=? AND member IN (SELECT code FROM members WHERE member_status=?) AND date=?");
                                    $m_first_timer = "first_timer";
                                    $find_m_first_time_members->execute([$s,$m_first_timer,$m_date]);
                                    $count_m_first_timers = $find_m_first_time_members->rowCount();

                                    $find_total_partnership_query = $connect->prepare("SELECT SUM(amount) AS total_amount FROM member_attendance_partnership_transactions WHERE date=?");
                                    $find_total_partnership_query->execute([$m_date]);
                                    while($row=$find_total_partnership_query->fetch(PDO::FETCH_ASSOC)){
                                        $total_partnership = $row["total_amount"];
                                    }
                               ?>
                                <tr>
                            
                                    <td><?php echo format_date($m_date);?></td>
                                    <td><?php echo $count_all_m_full_members;?></td>
                                    <td><?php echo $count_m_first_timers;?></td>
                                   
                                    <td><?php echo format_money($total_partnership);?></td>
                                    
                                    
                                    <td>
                                        <div class="">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-xs dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Options
                                                </button>

                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                
                                                    <form method="post">
                                                        <input type="text" name="service_date" value="<?php echo $m_date;?>" hidden>
                                                        
                                                        <a href="#record_general_offering<?php echo $m_date;?>" class="dropdown-item" data-toggle="modal">Record General Offering</a>
            

                                                        <button type="submit" name="record_other_partnerships_for_the_service" class="dropdown-item">Record Other Partnerships</button>
                                                        
                                                        <button type="submit" name="open_service_report" class="dropdown-item">Open Full Service Report</button>

                                                        <button type="submit" name="open_attendance_report" class="dropdown-item">Open Attendance Report</button>

                                                        <button type="submit" name="open_partnership_report" class="dropdown-item">Open Partnership Report</button>
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
                                $find_data = $connect->prepare("SELECT DISTINCT(date) FROM member_attendance ORDER BY date LIMIT 100");
                                $find_data->execute();
                                while($row=$find_data->fetch(PDO::FETCH_ASSOC)){
                                    $m_date = $row["date"];

                                    $find_m_full_members = $connect->prepare("SELECT * FROM member_attendance WHERE member IN (SELECT code FROM members WHERE member_status=?)");
                                    $m_member = "member";
                                    $find_m_full_members->execute([$m_member]);
                                    $count_all_m_full_members = $find_m_full_members->rowCount();

                                    $find_m_first_time_members = $connect->prepare("SELECT * FROM member_attendance WHERE member IN (SELECT code FROM members WHERE member_status=?)");
                                    $m_first_timer = "first_timer";
                                    $find_m_first_time_members->execute([$m_first_timer]);
                                    $count_m_first_timers = $find_m_first_time_members->rowCount();

                                    $find_total_partnership_query = $connect->prepare("SELECT SUM(amount) AS total_amount FROM member_attendance_partnership_transactions WHERE date=?");
                                    $find_total_partnership_query->execute([$m_date]);
                                    while($row=$find_total_partnership_query->fetch(PDO::FETCH_ASSOC)){
                                        $total_partnership = $row["total_amount"];
                                    }
                               ?>
<div class="modal fade" id="record_general_offering<?php echo $m_date;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel6" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <form method="POST">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel6">Record General Partnership for <?php echo format_date($m_date);?></h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <input type="text" hidden name="service_date" value="<?php echo $m_date;?>">
                  
                    <div class="modal-body">
                    
                        <div class="form-group">
                            <label class="d-block">General Partnership Total Amount ($)</label>
                            <input type="number" step="any" class="form-control" name="service_general_partnership" id="service_general_partnership" style="border-color:#7CB74B; border-width:1px; border-radius:10px" required placeholder="Enter total general partnership amount">
                        </div>
                    
                       
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="record_general_partnership" onclick="record_general_partnership_show_loader()" class="btn btn-primary tx-13">Record General Partnership</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
                               <?php
                                }
                               ?>
    <!--Modals-->
   
    

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
        function update_consultant_show_loader() {
            if ($('#u_consultant_name').val() != '')
                $('#loader').show();
        }
    </script>
    
    
     <script>
        function activate_consultant_show_loader() {
                $('#loader').show();
        }
    </script>
    
    <script>
        function deactivate_consultant_show_loader() {
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