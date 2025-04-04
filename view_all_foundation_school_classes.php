<?php
include("includes/forms.php");
include("includes/session.php");
if($role != "foundation_school"){
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
                                <li class="breadcrumb-item active" aria-current="page">View All Foundation School Classses</li>
                            </ol>
                        </nav>
                        <h4 class="mg-b-0 tx-spacing--1">View All Foundation School Classes</h4>
                    </div>
                    <div class="d-none d-md-block">
                        
                        <a href="record_new_foundation_school_class" class="btn btn-sm pd-x-15 btn-primary btn-uppercase"><i data-feather="user" class="wd-10 mg-r-5"></i>Record New Class</a>
                    
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
                                    <th>Name</th>
                                    <th>Teacher</th>
                                    <th>Start Date</th>
                                    <th>Students</th>
                                    <th>Progress</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                //SELECT `id`, `code`, `name`, `teacher`, `date`, `status` FROM `classes` WHERE 1
                                $find_data = $connect->prepare("SELECT * FROM classes");
                                $find_data->execute();
                                while($row=$find_data->fetch(PDO::FETCH_ASSOC)){
                                    $c_code = $row["code"];
                                    $c_id = $row["id"];
                                    $c_name = $row["name"];
                                    $c_teacher = $row["teacher"];
                                    $c_date = $row["date"];
                                    $c_status = $row["status"];

                                    if($c_status == ""){
                                        $c_badge = "badge-danger";
                                        $C_badge_text = "Started";
                                    }

                                    $find_classes_students = $connect->prepare("SELECT * FROM class_students WHERE class=?");
                                    $find_classes_students->execute([$c_code]);
                                    $count_class_students = $find_classes_students->rowCount();
                               
                               ?>
                                <tr>
                            
                                    <td><?php echo $c_name;?></td>
                                    <td><?php echo $c_teacher;?></td>
                                    <td><?php echo format_date($c_date);?></td>
                                    <td><?php echo $count_class_students;?></td>
                                    <td>
                                        <span class="badge <?php echo $c_badge;?>"><?php echo $C_badge_text;?></span>
                                    </td>
                                    
                                    
                                    <td>
                                        <div class="">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-xs dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Options
                                                </button>

                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                
                                                    <form method="post">
                                                        <input type="text" name="the_code" value="<?php echo $cell_code;?>" hidden>
                                                        
                                                        <button type="submit" name="delete_prepayment" class="dropdown-item">Update Cell Details</button>

                                                        <button type="submit" name="delete_prepayment" class="dropdown-item">View Cell Members</button>

                                                        <button type="submit" name="delete_prepayment" class="dropdown-item">Delete Cell Account</button>
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