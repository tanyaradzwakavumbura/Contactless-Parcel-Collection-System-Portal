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
                  <li class="breadcrumb-item active" aria-current="page">Update Account Settings</li>
                </ol>
              </nav>
              <h4 class="mg-b-0 tx-spacing--1">Update Account Settings</h4>
            </div>
            <div class="d-none d-md-block">
                <a href="dashboard" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="home" class="wd-10 mg-r-5"></i> Dashboard</a>
            
            </div>
          </div>

          <div class="row row-xs">
            <div class="col-lg-8 col-xl-12">
              <div class="card">
                <div class="card-header bd-b-0 pd-t-20 pd-lg-t-25 pd-l-20 pd-lg-l-25 d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                  
                </div><!-- card-header -->
                <div class="card-body pd-lg-25">
                  <div class="row align-items-sm-end">
                    <div class="col-lg-7 col-xl-8">
                         <form action="" method="POST">
                            <?php
                            if(isset($message))
                            {
                                ?>
                            <div class="<?php echo $alert;?>" role="alert">
                                <strong><?php echo $message;?></strong> 
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                            <?php
                            }
                            ?>
                            
                             <div class="form-group">
                                 <label class="d-block">Current Password</label>
                                 <input type="text" class="form-control" style="border-color:#7CB74B; border-width:1px; border-radius:10px" name="cpass" placeholder="Enter your current password"  required>
                             </div>
                             <div class="form-group">
                                 <label class="d-block">New Password</label>
                                 <input type="text" style="border-color:#7CB74B; border-width:1px; border-radius:10px" class="form-control" name="npass" placeholder="Enter a new password">
                             </div> 
                             
                             <button class="btn btn-primary" type="submit" name="update_security">Update Password</button>
           
                    </form>
                        
                    </div>
                   
                    </div>
                  </div>
                </div><!-- card-body -->
              </div><!-- card -->
            </div>
            
           
            
           
          </div><!-- row -->
        </div><!-- container -->
    </div>
    <script src="../ckeditor5_3/build/ckeditor.js"></script>
    <script>
        var myEditor;
        ClassicEditor
            .create(document.querySelector('.editor'), {

                toolbar: {
                    items: [
                        'exportPdf',
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        '|',
                        'indent',
                        'outdent',
                        '|',
                        'imageUpload',
                        'blockQuote',
                        'insertTable',
                        'mediaEmbed',
                        'code',
                        'specialCharacters',
                        'MathType',
                        'ChemType',
                        'undo',
                        'redo'
                    ]
                },
                language: 'en',
                image: {
                    toolbar: [
                        'imageTextAlternative',
                        'imageStyle:full',
                        'imageStyle:side'
                    ]
                },
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells',
                        'tableCellProperties',
                        'tableProperties'
                    ]
                },
                licenseKey: '',

            })
            .then(editor => {
                window.editor = editor;

                myEditor = editor;




            })
            .catch(error => {
                console.error('Oops, something gone wrong!');
                console.error('Please, report the following error in the https://github.com/ckeditor/ckeditor5 with the build id and the error stack trace:');
                console.warn('Build id: ie31kjir3qey-rvhd74r7mgzi');
                console.error(error);
            });
    </script>
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
    <?php include("includes/no_click.php");?>
</body>

</html>