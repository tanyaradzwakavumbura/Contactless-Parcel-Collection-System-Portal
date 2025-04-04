<?php
include("includes/forms.php");
if(isset($_SESSION["kwekwe_rank"])){
    header("location:dashboard");
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

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="assets/css/dashforge.css">
    <link rel="stylesheet" href="assets/css/dashforge.auth.css">

</head>

<body>
    <header class="navbar navbar-header navbar-header-fixed">
        <a href="#" id="mainMenuOpen" class="burger-menu"><i data-feather="menu"></i></a>
        <div class="navbar-brand">
           <a href="index" class="df-logo">ZIMPOST&#160;<span>CPCS</span></a>
        </div><!-- navbar-brand -->
        <div id="navbarMenu" class="navbar-menu-wrapper">
            <div class="navbar-menu-header">
                <a href="index" class="df-logo">ZIMPOST&#160;<span>CPCS</span></a>
                <a id="mainMenuClose" href="#"><i data-feather="x"></i></a>
            </div><!-- navbar-menu-header -->
            <ul class="nav navbar-menu">
                <li class="nav-label pd-l-20 pd-lg-l-25 d-lg-none">Main Navigation</li>
            </ul>
        </div><!-- navbar-menu-wrapper -->
        <div class="navbar-right">
<!--            <a href="canteen_access_form" class="btn btn-buy"><i data-feather="airplay"></i> <span>Create Account</span></a>-->
        </div><!-- navbar-right -->
    </header><!-- navbar -->

    <div class="content content-fixed content-auth">
        <div class="container">
            <div class="media align-items-stretch justify-content-center ht-100p pos-relative">
                <div class="media-body align-items-center d-none d-lg-flex">
                    <div class="mx-wd-600">
                        <img src="images/login.png" class="img-fluid" alt="">
                    </div>

                </div><!-- media-body -->
                <br><br>
                <form method="POST">
                    <div class="sign-wrapper mg-lg-l-50 mg-xl-l-60">
                        <div class="wd-100p">
                            <h3 class="tx-color-01 mg-b-5">Sign In</h3>
                            <p class="tx-color-03 tx-16 mg-b-40">Welcome back! Please login to continue to ZIMPOST Contactless Parcel Collection System Portal</p>

                            <?php
                            include("includes/alert.php");
                            ?>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" required name="username" class="form-control" placeholder="Enter your Username">
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between mg-b-5">
                                    <label class="mg-b-0-f">Password</label>
                                </div>
                                <div class="input-group mg-b-10">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <div class="custom-control custom-checkbox pd-l-15">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1" onclick="MyFunction()">
                                                <script>
                                                    function MyFunction() {
                                                        var x = document.getElementById("password");
                                                        if (x.type === "password") {
                                                            x.type = "text";
                                                        } else {
                                                            x.type = "password";
                                                        }
                                                    }
                                                </script>
                                                <label class="custom-control-label" for="customCheck1"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="password" name="password" id="password" class="form-control" aria-label="Text input with checkbox" placeholder="Enter your password">
                                </div>
                            </div>
                            <button type="submit" name="login" class="btn btn-brand-02 btn-block">Login</button>

                        </div>
                    </div><!-- sign-wrapper -->
                </form>
            </div><!-- media -->
        </div><!-- container -->
    </div><!-- content -->

    <?php
      include("includes/footer.php");
      ?>

    <script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="lib/feather-icons/feather.min.js"></script>
    <script src="lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <script src="assets/js/dashforge.js"></script>

    <!-- append theme customizer -->
    <script src="lib/js-cookie/js.cookie.js"></script>
    <script src="assets/js/dashforge.settings.js"></script>
</body>

</html>