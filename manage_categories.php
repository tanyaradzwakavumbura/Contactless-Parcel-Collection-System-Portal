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
                                <li class="breadcrumb-item active" aria-current="page">Manage Vehicle Categories</li>
                            </ol>
                        </nav>
                        <h4 class="mg-b-0 tx-spacing--1">Manage Vehicle Categories</h4>
                    </div>
                    <div class="d-none d-md-block">
                        
<!--                        <a href="manage_questions" class="btn btn-sm pd-x-15 btn-primary btn-uppercase"><i data-feather="book" class="wd-10 mg-r-5"></i>Manage Questions</a>-->
                    
                         <a href="#add_new_category" class="btn btn-sm pd-x-15 btn-warning btn-uppercase" data-toggle="modal"><i data-feather="bookmark" class="wd-10 mg-r-5"></i>Register New Category</a>
                        
                    </div>
                </div>
                <hr>
                <div class="row col-12">
                    <div data-label="Example" class="df-example demo-table col-md-12">
                        <br>
                        <table id="example1" class="table table-hover table-bordered">
                            <thead class="thead-gray-100">
                                <tr>
                                    <th class="wd-10p">Code</th>
                                    <th class="wd-20p">Name</th>
                                    <th class="wd-20p">Cost</th>
                                    <th class="wd-20p">Minutes</th>
                                    <th class="wd-20p">Vehicles</th>
                                    <th class="wd-10p">Option</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                
                              
                                $find_data = $connect->prepare("SELECT * FROM categories");
                                $find_data->execute();
                                while($row=$find_data->fetch(PDO::FETCH_ASSOC)){
                                    $c_id = $row["id"];
                                    $c_code = $row["code"];
                                    $c_name = $row["name"];
                                    $c_date = $row["date"];
                                    $c_cost = $row["cost"];
                                    $c_minutes = $row["minutes"];


                                    $find_all_vehicles = $connect->prepare("SELECT * FROM vehicles WHERE category=?");
                                    $find_all_vehicles->execute([$c_code]);
                                    $count_all_vehicles = $find_all_vehicles->rowCount();
                              
                                   
                               ?>
                                <tr>
                                    <td>
                                        <?php
                                        echo $c_code;
                                        ?>
                                    </td>
                                    <td><?php echo $c_name;?></td>
                                    <td><?php echo format_money($c_cost);?></td>
                                    <td><?php echo $c_minutes;?></td>
                                    <td><?php echo $count_all_vehicles;?></td>
                                   
                                    
                                    <td>
                                        <div class="">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-xs dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Options
                                                </button>

                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a href="#category<?php echo $c_id;?>" class="dropdown-item" data-toggle="modal">Update Category</a>
                                                 
                                                    <form method="post">
                                                        <input type="text" name="c_id" value="<?php echo $c_id;?>" hidden>
                                                        <button type="submit" name="delete_category" class="dropdown-item">Delete Category</button>
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
    <div class="modal fade" id="add_new_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel6" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <form method="POST">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel6">Register New Category</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>


                    <div class="modal-body">
                        <input type="text" name="cat_code" value="<?php echo calculateCategoryCode($connect);?>" hidden>
           
                        <div class="form-group">
                            <label class="d-block">Category Name</label>
                            <input type="text" class="form-control" name="category_name" id="category_name" style="border-color:#7CB74B; border-width:1px; border-radius:10px" required placeholder="Enter Category Full Name">
                        </div>
                        
                        <div class="form-group">
                            <label class="d-block">Category Cost (USD)</label>
                            <input type="number" step="any" class="form-control" name="category_cost" id="category_cost" style="border-color:#7CB74B; border-width:1px; border-radius:10px" required placeholder="Enter Category Cost (USD)">
                        </div>
                        
                        <div class="form-group">
                            <label class="d-block">Category Cost is for how many minutes</label>
                            <input type="number" step="any" class="form-control" name="category_minutes" id="category_minutes" style="border-color:#7CB74B; border-width:1px; border-radius:10px" required placeholder="Enter Category Minutes">
                        </div>
                        
                     
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="add_new_category" onclick="add_category_show_loader()" class="btn btn-primary tx-13">Add New Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <?php
    $find_data = $connect->prepare("SELECT * FROM categories");
    $find_data->execute();
    while($row=$find_data->fetch(PDO::FETCH_ASSOC)){
        $c_id = $row["id"];
        $c_code = $row["code"];
        $c_name = $row["name"];
        $c_date = $row["date"];
        $c_cost = $row["cost"];
        $c_minutes = $row["minutes"];

    ?>
    <div class="modal fade" id="category<?php echo $c_id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel6" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-14">
                <form method="POST">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel6">Update Category Details</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <input type="text" hidden name="the_id" value="<?php echo $c_id;?>">
                    <input type="text" hidden name="the_code" value="<?php echo $c_code;?>">

                    <div class="modal-body">
           
                        <div class="form-group">
                            <label class="d-block">Category Name</label>
                            <input type="text" class="form-control" name="u_cat_name" id="u_cat_name" style="border-color:#7CB74B; border-width:1px; border-radius:10px" required placeholder="Update Category Name" value="<?php echo $c_name;?>">
                        </div>
                        
                        
                        <div class="form-group">
                            <label class="d-block">Category Cost (USD)</label>
                            <input type="number" step="any" class="form-control" name="u_cat_cost" id="u_cat_cost" style="border-color:#7CB74B; border-width:1px; border-radius:10px" required placeholder="Update Category Cost" value="<?php echo $c_cost;?>">
                        </div>
                        
                        <div class="form-group">
                            <label class="d-block">Category Minutes</label>
                            <input type="number" step="any" class="form-control" name="u_cat_minutes" id="u_cat_minutes" style="border-color:#7CB74B; border-width:1px; border-radius:10px" required placeholder="Update Category Minutes" value="<?php echo $c_minutes;?>">
                        </div>
                       
    
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="update_category_details" onclick="update_category_show_loader()" class="btn btn-primary tx-13">Update Category Details</button>
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
        function add_category_show_loader() {
            if ($('#category_name').val() != '' && $('#category_cost').val() != '' && $('#category_minutes').val() != '')
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