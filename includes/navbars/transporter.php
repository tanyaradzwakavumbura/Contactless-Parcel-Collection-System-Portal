<?php  
    $currentPage = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); 
    $show = "";
    $active = ""; 
  ?>

<li class="nav-label mg-t-25">ZIMPOST Portal</li>



<li class="nav-item <?php echo $active;?> <?php echo $show;?>">
    <a href="view_all_pending_parceles_transporter" class="nav-link"><i data-feather="bookmark"></i> <span>Pending Parcels</span></a>
</li>

<li class="nav-item <?php echo $active;?> <?php echo $show;?>">
    <a href="view_all_in_transit_parcels_by_transporter" class="nav-link"><i data-feather="bookmark"></i> <span>In-Transit Parcels</span></a>
</li>

<li class="nav-item <?php echo $active;?> <?php echo $show;?>">
    <a href="view_all_delivered_parcels_transporter" class="nav-link"><i data-feather="bookmark"></i> <span>Delivered Parcels</span></a>
</li>


<li class="nav-label mg-t-25">Advanced</li>




<?php
if($currentPage == "profile.php" || $currentPage == "settings.php" || $currentPage == "rating_settings.php" || $currentPage == "restock_management_settings.php" || $currentPage == "meal_times_management.php" || $currentPage == "payment_modes_management.php" || $currentPage == "suppliers_list.php" || $currentPage == "expenses_categories.php" || $currentPage == "subjects_management.php" || $currentPage == "performance_grading_management.php" || $currentPage == "activate_student_term_results.php"){
    $show = "show";
    $active = "active";
}else{
    $show = "";
    $active = "";
}
?>
<li class="nav-item with-sub <?php echo $active;?> <?php echo $show;?>">
    <a href="#" class="nav-link"><i data-feather="settings"></i> <span>System Settings</span></a>
    <ul>
        <li><a href="settings">Account Settings</a></li>
    </ul>
</li>
 
