<?php
include("includes/forms.php");
if(isset($_SESSION["procurement"])){
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
            <a href="index" class="df-logo">360&#176;&#160;<span>Feedback</span></a>
        </div><!-- navbar-brand -->
        <div id="navbarMenu" class="navbar-menu-wrapper">
            <div class="navbar-menu-header">
                <a href="index" class="df-logo">360&#176;&#160;<span>Feedback</span></a>
                <a id="mainMenuClose" href="#"><i data-feather="x"></i></a>
            </div><!-- navbar-menu-header -->
            <ul class="nav navbar-menu">
                <li class="nav-label pd-l-20 pd-lg-l-25 d-lg-none">Main Navigation</li>
            </ul>
        </div><!-- navbar-menu-wrapper -->
        <div class="navbar-right">
            <a href="index" class="btn btn-buy"><i data-feather="airplay"></i> <span>Back to Login</span></a>
        </div><!-- navbar-right -->
    </header><!-- navbar -->

    <form method="POST">

        <div class="content content-fixed content-auth-alt">

            <div class="container d-flex justify-content-center ht-100p">

                <div class="mx-wd-300 wd-sm-450 ht-100p d-flex flex-column align-items-center justify-content-center">
                    <div class="wd-80p wd-sm-300 mg-b-15"><img src="images/login.png" class="img-fluid" alt=""></div>
                    <h4 class="tx-20 tx-sm-24">Reset your password</h4>
                    <p class="tx-color-03 mg-b-30 tx-center"> Enter your <b>email</b> and we will send you a new password to your email</p>
                    <?php include("includes/alert.php");?>
                    <div class="wd-100p d-flex flex-column flex-sm-row mg-b-40">
                        <input type="text" name="current_user" class="form-control wd-sm-250 flex-fill" placeholder="Enter your account email">
                        <button type="submit" name="forgot_password" class="btn btn-brand-02 mg-sm-l-10 mg-t-10 mg-sm-t-0">Reset Password</button>
                    </div>
                </div>
            </div><!-- container -->
        </div><!-- content -->
    </form>
    <footer class="footer">
        <div>
            <span>&copy; <?php echo date("Y")." 360 Degree Feedback 1.0";?></span>
            <span>Powered by PerformSoft</span>
        </div>

    </footer>

    <script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="lib/feather-icons/feather.min.js"></script>
    <script src="lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <script src="assets/js/dashforge.js"></script>

    <!-- append theme customizer -->
    <script src="lib/js-cookie/js.cookie.js"></script>
    <script src="assets/js/dashforge.settings.js"></script>
    <script>
        $(function() {
            'use script'

            window.darkMode = function() {
                $('.btn-white').addClass('btn-dark').removeClass('btn-white');
            }

            window.lightMode = function() {
                $('.btn-dark').addClass('btn-white').removeClass('btn-dark');
            }

            var hasMode = Cookies.get('df-mode');
            if (hasMode === 'dark') {
                darkMode();
            } else {
                lightMode();
            }
        })
    </script>
</body>


</html>