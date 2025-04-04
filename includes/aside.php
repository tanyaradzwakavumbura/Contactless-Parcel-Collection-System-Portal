<?php  
    $currentPage = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); 
    $show = "";
    $active = ""; 
?> 
<aside class="aside aside-fixed">
     <div class="aside-header">
         <a href="dashboard" class="aside-logo">ZIMPOST&#160; <span>Portal</span></a>
         <a href="#" class="aside-menu-link">
             <i data-feather="menu"></i>
             <i data-feather="x"></i>
         </a>
     </div>
     <div class="aside-body">
         <div class="aside-loggedin">
             <div class="d-flex align-items-center justify-content-start">
                 <a href="#" class="avatar"><img src="images/avatar.svg" class="rounded-circle" alt=""></a>
                 <div class="aside-alert-link">
                     <a href="logout" data-toggle="tooltip" title="Sign out"><i data-feather="log-out"></i></a>
                 </div>
             </div>
             <div class="aside-loggedin-user">
                 <a href="#loggedinMenu" class="d-flex align-items-center justify-content-between mg-b-2" data-toggle="collapse">
                     <h6 class="tx-semibold mg-b-0"><?php echo $name." ".$surname;?></h6>
                     <i data-feather="chevron-down"></i>
                 </a>
                 <p class="tx-color-03 tx-12 mg-b-0"><?php echo "Account";?></p>
             </div>
             <div class="collapse" id="loggedinMenu">
                 <ul class="nav nav-aside mg-b-0">
                     <li class="nav-item"><a href="settings" class="nav-link"><i data-feather="settings"></i> <span>Account Settings</span></a></li>
                     <li class="nav-item"><a href="logout" class="nav-link"><i data-feather="log-out"></i> <span>Sign Out</span></a></li>
                 </ul>
             </div>
         </div><!-- aside-loggedin -->
         <ul class="nav nav-aside">
             <li class="nav-label">Dashboard</li>
             <li class="nav-item <?php echo $show;?>"><a href="dashboard" class="nav-link"><i data-feather="home"></i> <span>Home</span></a></li>

             <?php
            switch($role){
                case "admin":
                    include("includes/navbars/admin.php");
                    break;
                    
                case "transporter":
                    include("includes/navbars/transporter.php");
                    break;
                    
                case "normal_user":
                    include("includes/navbars/normal_user.php");
                    break;

               
            }
            ?>


         </ul>
     </div>
 </aside>