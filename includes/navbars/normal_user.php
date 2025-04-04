<?php  
    $currentPage = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); 
    $show = "";
    $active = ""; 
  ?>

<li class="nav-label mg-t-25">ZIMPOST Portal</li>
<?php
if($currentPage == "lockers.php" || $currentPage == "service_attendance_records.php" || $currentPage == "record_other_partnerships.php" || $currentPage == "service_report.php" || $currentPage == "service_attendance_report.php" || $currentPage == "service_partnership_report.php"){
    $show = "show";
    $active = "active";
}else{
    $show = "";
    $active = "";
}
?>
<li class="nav-item  <?php echo $active;?> <?php echo $show;?>">
    <a href="lockers" class="nav-link"><i data-feather="bookmark"></i> <span>Lockers Management</span></a>
    
</li>
<?php
if($currentPage == "record_new_member.php" || $currentPage == "view_all_full_members.php" || $currentPage == "view_all_first_time_members.php"){
    $show = "show";
    $active = "active";
}else{
    $show = "";
    $active = "";
}
?>
<li class="nav-item with-sub  <?php echo $active;?> <?php echo $show;?>">
    <a href="#" class="nav-link"><i data-feather="bookmark"></i> <span>Parcels Management</span></a>
    <ul>
        <li><a href="lockers">Pending Parcels</a></li>
        <li><a href="lockers">Overdue Parcels</a></li>
        <li><a href="lockers">Waiting List</a></li>
    </ul>
</li>


<?php
if($currentPage == "search_partnership_report.php" || $currentPage == "partnership_report.php" || $currentPage == "full_members_report.php" || $currentPage == "first_timer_members_report.php" || $currentPage == "new_convert_report.php" || $currentPage == "search_service_attendance_report.php" || $currentPage == "service_report.php" || $currentPage == "search_cell_report.php" || $currentPage == "cell_report.php" || $currentPage == "search_partnership_report.php" || $currentPage == "service_departments_report.php" || $currentPage == "cell_meeting_report.php"){
    $show = "show";
    $active = "active";
}else{
    $show = "";
    $active = "";
}
?>
<li class="nav-item with-sub  <?php echo $active;?> <?php echo $show;?>">
    <a href="#" class="nav-link"><i data-feather="bookmark"></i> <span>Statistics & Reports</span></a>
    <ul>
        <li><a href="full_members_report">Coming Soon</a></li>
  
    </ul>
</li>




<li class="nav-label mg-t-25">Advanced</li>


<?php
if($currentPage == "add_new_users.php" || $currentPage == "update_users.php"){
    $show = "show";
    $active = "active";
}else{
    $show = "";
    $active = "";
}
?>
<li class="nav-item with-sub <?php echo $active;?> <?php echo $show;?>">
    <a href="#" class="nav-link"><i data-feather="user"></i> <span>Access Management</span></a>
    <ul>
        <li><a href="add_new_users">Add New Users</a></li>
        <li><a href="update_users.php">Update Users</a></li>
    </ul>
</li>


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
 
