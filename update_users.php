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

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="assets/css/dashforge.css">
    <link rel="stylesheet" href="assets/css/dashforge.dashboard.css">

    <!-- jQuery library -->
    <script src="assets/jquery.min.js"></script>

    <!-- jQuery UI library -->
    <link rel="stylesheet" href="assets/jquery-ui.css">
    <script src="assets/jquery-ui.min.js"></script>
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
                                <li class="breadcrumb-item active" aria-current="page">Update Access Accounts</li>
                            </ol>
                        </nav>
                        <h4 class="mg-b-0 tx-spacing--1">Update User Access Accounts</h4>
                    </div>
                    <div class="d-none d-md-block">
                        <a href="dashboard" class="btn btn-sm pd-x-15 btn-warning btn-uppercase mg-l-5"><i data-feather="home" class="wd-10 mg-r-5"></i>Dashboard</a>

                        <a href="settings" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="settings" class="wd-10 mg-r-5"></i> Account Settings</a>
                    </div>
                </div>

                <div class="row row-xs">
                    <div class="col-lg-8 col-xl-12">
                        <div class="card">
                            <div class="card-header bd-b-0 pd-t-20 pd-lg-t-25 pd-l-20 pd-lg-l-25 d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">

                            </div><!-- card-header -->
                            <div class="card-body pd-lg-25">
                                <div class="row align-items-sm-end">
                                    <div class="col-lg-7 col-xl-12">
                                        <div data-label="Example" class="df-example demo-table">
                                            <table id="example1" class="table table-hover table-bordered">
                                                <thead class="thead-gray-100">
                                                    <tr>
                                                        <th class="wd-25p">Name</th>
                                                        <th class="wd-20p">Main Job</th>
                                                        <th class="wd-20p">Username</th>
                                                        <th class="wd-20p">Account</th>
                                                        <th class="wd-15p">Option</th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $find_user_accounts = $connect->prepare("SELECT * FROM users WHERE username !=?");
                                                    $find_user_accounts->execute([$user]);
                                                    while($row=$find_user_accounts->fetch(PDO::FETCH_ASSOC)){
                                                        $a_type = $row["role"];
                                                        $a_username = $row["username"];
                                                        $a_main_job = $row["main_job"];
                                                        $a_name = $row["name"];
                                                        $a_surname = $row["surname"];
                                                        $a_phone = $row["phone"];
                                                        $a_id = $row["id"];
                                                        
                                                        if($a_type == "admin"){
                                                            $acca = "Admin Account";
                                                            $the_tag = "badge badge-danger";
                                                        }elseif($a_type == "transporter"){
                                                            $acca = "Transporter";
                                                            $the_tag = "badge badge-primary";
                                                        }elseif($a_type == "normal_user"){
                                                            $acca = "Normal User";
                                                            $the_tag = "badge badge-warning";
                                                        }elseif($a_type == "partnership"){
                                                            $acca = "Partnership";
                                                            $the_tag = "badge badge-info";
                                                        }elseif($a_type == "church_administration"){
                                                            $acca = "Church Administration";
                                                            $the_tag = "badge badge-success";
                                                        }
                                                    ?>


                                                    <tr>
                                                        <td><?php echo $a_name." ".$a_surname;?></td>
                                                        <td><?php echo "Access";?></td>
                                                        <td><?php echo $a_username;?></td>
                                                        <td>
                                                            <span class="<?php echo $the_tag;?>"><?php echo $acca;?></span>
                                                        </td>

                                                        <td>
                                                            <div class="mg-l-35">
                                                                <div class="dropdown">
                                                                    <button class="btn btn-secondary btn-xs dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        Options
                                                                    </button>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                                        <a href="#update_user<?php echo $a_id;?>" class="dropdown-item" data-toggle="modal">Update User</a>
                                                                        <?php
                                                                        if(isset($_POST["delete_user"])){
                                                                            $the_id = $_POST["the_id"];
                                                                            $delete_query = $connect->prepare("DELETE FROM users WHERE id=?");
                                                                            $delete_query->execute([$the_id]);
                                                                            echo "<script type='text/javascript'>window.location.href='update_users'</script>";
                                                                        }
                                                                        ?>
                                                                        <form method="POST">
                                                                            <input type="text" hidden name="the_id" value="<?php echo $a_id;?>">
                                                                            <button class="dropdown-item" type="submit" name="delete_user">Delete User</button>
                                                                        </form>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!--Modals-->
                                                    <div class="modal fade" id="update_user<?php echo $a_id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                            <div class="modal-content tx-14">
                                                                <div class="modal-header">
                                                                    <h6 class="modal-title" id="exampleModalLabel4">Update User Details for <?php echo $a_name." ".$a_surname;?></h6>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="POST">
                                                                        <div data-label="Example" class="df-example demo-forms">
                                                                            <input type="text" hidden name="c_id" value="<?php echo $a_id;?>">

                                                                            <div class="row row-sm">
                                                                                <div class="col-sm-12">
                                                                                    <label class="d-block">New Password</label>
                                                                                    <input id="c_password" type="text" name="c_password" style="border-color:#7CB74B; border-width:1px; border-radius:10px" class="form-control" required placeholder="Change the Person ' Password">
                                                                                    <br>
                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button onclick="update_users_show_loader()" type="submit" name="update_person_details" class="btn btn-primary">Update User Details</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--End Modals-->
                                                    <?php
                }
                ?>
                                                    <!--End New Employee-->

                                                </tbody>
                                            </table>
                                        </div><!-- df-example -->
                                    </div>

                                </div>
                            </div>
                        </div><!-- card-body -->
                    </div><!-- card -->
                </div>




            </div><!-- row -->
        </div><!-- container -->
    </div>
    </div>



    <script src="lib/jqueryui/jquery-ui.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="lib/feather-icons/feather.min.js"></script>
    <script src="lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <script src="assets/js/dashforge.js"></script>
    <script src="assets/js/dashforge.aside.js"></script>
    <script src="assets/js/dashforge.sampledata.js"></script>


    <!-- append theme customizer -->
    <script src="lib/js-cookie/js.cookie.js"></script>
    <script src="assets/js/dashforge.settings.js"></script>


    <script src="lib/prismjs/prism.js"></script>
    <script src="lib/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="lib/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
    <script src="lib/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script>
    <script src="lib/select2/js/select2.min.js"></script>
    
     <script>
        function update_users_show_loader() {
            if ($('#c_password').val() != '')
                $('#loader').show();
        }
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
                placeholder: 'Select Year To View Enrolled Students',
                searchInputPlaceholder: 'Select Year'
            });

            // Disable search
            $('.select2-no-search').select2({
                minimumResultsForSearch: Infinity,
                placeholder: 'Choose School'
            });

            // Clearable selection
            $('.select2-clear').select2({
                minimumResultsForSearch: Infinity,
                placeholder: 'Choose School',
                allowClear: true
            });

            // Limit selection
            $('.select2-limit').select2({
                minimumResultsForSearch: Infinity,
                placeholder: 'Choose School',
                maximumSelectionLength: 2
            });

        });
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