
<?php
/*-----------------------------------------------------------------------------------------------------------------------------
                                           EMAIL API PHPMAILER CODE
----------------------------------------------------------------------------------------------------------------------------*/
require_once __DIR__ . '/../assets_two/vendor/autoload.php';

$basic  = new \Vonage\Client\Credentials\Basic("6bcb73b6", "I78Kj8xFjrzOrMeS");
$client = new \Vonage\Client($basic);

/*----------------------------------------------------------------------------------------------------------------------------

                                            DATABASE CONNECTION CODE
----------------------------------------------------------------------------------------------------------------------------*/
include("db.php");

/*----------------------------------------------------------------------------------------------------------------------------

                                              SYSTEM FUNCTIONS
----------------------------------------------------------------------------------------------------------------------------*/ 
include("functions.php");



/*-----------------------------------------------------------------------------------------------------------------------------
                                           CURRENT DATE AND TIME CODE
----------------------------------------------------------------------------------------------------------------------------*/
$current_datetime = date("Y-m-d H:i:s"); 
$current_date = date("Y-m-d"); 
$current_time = date("H:i");
$current_year = date("Y");

/*-----------------------------------------------------------------------------------------------------------------------------
                                           TRANSACTION  CODES
----------------------------------------------------------------------------------------------------------------------------*/
$transaction_create = "CREATE";
$transaction_delete = "DELETE";
$transaction_update = "UPDATE";
$transaction_login = "LOGIN";
/*----------------------------------------------------------------------------------------------------------------------------

                                            ACCOUNT DETAILS CODE
----------------------------------------------------------------------------------------------------------------------------*/
if(isset($_SESSION["kwekwe_rank"])){
    $user = $_SESSION["kwekwe_rank"];
    
    $find_user = $connect->prepare("SELECT * FROM users WHERE username=?");
    $find_user->execute([$user]);
    while($row=$find_user->fetch(PDO::FETCH_ASSOC)){
        $name = $row["name"];
        $surname = $row["surname"];
        $phone = $row["phone"];
        $email = $row["email"];
        $department = $row["department"];
        $role = $row["role"];
        $main_job = $row["main_job"];

        if($role == "cell"){
            $find_cell_details = $connect->prepare("SELECT * FROM cells WHERE cell_leader IN (SELECT code FROM members WHERE email=?)");
            $find_cell_details->execute([$user]);
            while($row=$find_cell_details->fetch(PDO::FETCH_ASSOC)){
                $cell_code = $row["code"];
                $cell_name = $row["name"];
            }
        }
        
    
    }  
    
    
    //Account Statistics 
  
    if($role == "admin"){
    

        //Total Full Members
        $find_total_full_members_query = $connect->prepare("SELECT * FROM members WHERE member_status=?");
        $m_status = "member";
        $find_total_full_members_query->execute([$m_status]);
        $count_total_full_members = $find_total_full_members_query->rowCount();

        //Total First Time Members
        $find_total_first_time_members_query = $connect->prepare("SELECT * FROM members WHERE member_status=?");
        $m_status_2 = "first_timer";
        $find_total_first_time_members_query->execute([$m_status_2]);
        $count_total_first_timers_members = $find_total_first_time_members_query->rowCOunt();

        //Total Baptized Members
        $find_total_baptized_members = $connect->prepare("SELECT * FROM members WHERE member_status=? AND baptism_status=?");
        $b_status = "Yes";
        $find_total_baptized_members->execute([$m_status,$b_status]);
        $count_all_baptized_members = $find_total_baptized_members->rowCount();

        //Total FOundation School Members
        $find_total_foundation_members = $connect->prepare("SELECT * FROM members WHERE member_status=? AND foundation_school=?");
        $find_total_foundation_members->execute([$m_status,$b_status]);
        $count_total_foundation_members = $find_total_foundation_members->rowCount();

        //Total Cells
        $find_total_cells = $connect->prepare("SELECT * FROM cells");
        $find_total_cells->execute();
        $count_total_cells = $find_total_cells->rowCOunt();

        //Service Department
        $find_total_service_departments = $connect->prepare("SELECT * FROM departments");
        $find_total_service_departments->execute();
        $count_total_service_departments = $find_total_service_departments->rowCount();
  
        //Members without Cells
        $find_all_members_without_cells_query = $connect->prepare("SELECT * FROM members WHERE cell_group=?");
        $no_cell = "No-Cell";
        $find_all_members_without_cells_query->execute([$no_cell]);
        $count_total_members_without_cells = $find_all_members_without_cells_query->rowCount();


        //Members without Service Departments
        $find_total_members_without_departments = $connect->prepare("SELECT * FROM members WHERE service_department=?");
        $no_department = "No-Department";
        $find_total_members_without_departments->execute([$no_department]);
        $count_total_members_without_departments = $find_total_members_without_departments->rowCOunt();

        //Male Members
        $find_total_male_members_query = $connect->prepare("SELECT * FROM members WHERE gender=? AND member_status=?");
        $m_male = "Male";
        $find_total_male_members_query->execute([$m_male,$m_status]);
        $count_total_male_members = $find_total_male_members_query->rowCount();

        //Female Members
        $find_total_female_members_query = $connect->prepare("SELECT * FROM members WHERE gender=? AND member_status=?");
        $m_female = "Female";
        $find_total_female_members_query->execute([$m_female,$m_status]);
        $count_total_female_members = $find_total_female_members_query->rowCount(); 
    
        //FInd All Active Projects
        $stat = "";
        $find_all_active_projects = $connect->prepare("SELECT * FROM projects WHERE status=?");
        $find_all_active_projects->execute([$stat]);
        $count_all_active_projects = $find_all_active_projects->rowCount();

    }elseif($role == "cell"){
        //Total Full Members
        $find_total_full_members_query = $connect->prepare("SELECT * FROM members WHERE member_status=? AND cell_group=?");
        $m_status = "member";
        $find_total_full_members_query->execute([$m_status,$cell_code]);
        $count_total_full_members = $find_total_full_members_query->rowCount();

        //Total Cell Converts
        $find_total_cell_converts_query = $connect->prepare("SELECT * FRom members WHERE cell_group=? AND member_status=?");
        $con = "convert";
        $find_total_cell_converts_query->execute([$cell_code,$con]);
        $count_total_cell_converts = $find_total_cell_converts_query->rowCount();
      
    }elseif($role == "foundation_school"){
        //Total Classes 

        //Members who have done Foundation School 

        //Graduated Members 

        //Pending Members 

        //Members who haven't started yet
    }
}

/*----------------------------------------------------------------------------------------------------------------------------

                                            LOGIN PAGE CODE
----------------------------------------------------------------------------------------------------------------------------*/
if(isset($_POST["login"])){
    
    $message = "";
    $alert = "";
    $span = "";
    
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    try{
        
        $check_user = $connect->prepare("SELECT * FROM users WHERE username=? AND password=?");
        $check_user->execute([$username,md5($password)]);
        $count_users = $check_user->rowCount();

        if($count_users == 1){

            
        
            $_SESSION["kwekwe_rank"] = $username;
            header("location:dashboard");
            
        }else{
           $message = "<center>Username & or Password is Incorrect</center>";
           $alert = "alert alert-danger alert-dismissible fade show";
        }
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}
/*----------------------------------------------------------------------------------------------------------------------------
                                            UPDATE SECURITY PAGE CODE
----------------------------------------------------------------------------------------------------------------------------*/
elseif(isset($_POST["update_security"])){
    $message = "";
    $alert = "";
    $span = "";
    
    $cpass = $_POST["cpass"];
    $npass = $_POST["npass"];
    try{
        
        $find_user = $connect->prepare("SELECT * FROM users WHERE username=?");
        $find_user->execute([$user]);
        while($row=$find_user->fetch(PDO::FETCH_ASSOC)){
            $current_password = $row["password"];
        }
        
        if($current_password == md5($cpass)){
            $change_pass = $connect->prepare("UPDATE users SET password=? WHERE username=?");
            $change_pass->execute([md5($npass),$user]);

            //Add Transaction to Audit Log
            $the_table = "users";
            $the_value = "Update Account Security : $user";

            // Call the function to add the transaction to the audit log
            addToAuditLog($connect, $transaction_update, $the_table, $user, $the_value);
            
            //Password Change Done
            $message = "<center><b>Password successfully changed</b></center>";
            $alert = "alert alert-success alert-dismissible fade show";
            $span = "";
        }else{
            $message = "<center>Current Password is incorrect</center>";
            $alert = "alert alert-danger alert-dismissible fade show";
            $span = ""; 
        }
        
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}
/*----------------------------------------------------------------------------------------------------------------------------

                                        FORGOT PASSWORD CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["forgot_password"])){
    $message = "";
    $alert = "";
    $span = "";
    
    
    $current_user = $_POST["current_user"];
    
    try{
        
        $check_user = $connect->prepare("SELECT * FROM users WHERE username=?");
        $check_user->execute([$current_user]);
        $count_users = $check_user->rowCount();
        
        if($count_users == 1){
            //Change Password
            $new_password = "password";
            $update = $connect->prepare("UPDATE users SET password=? WHERE username=?");
            $update->execute([md5($new_password),$current_user]);
            $message = $current_user;
            //Send Email to User
            //Send Email to Head of Departments
            $mail->addAddress($current_user); 
                                                    
            $mail->Subject = 'MIL Extensions : Account Password Reset'; 
 
            // Mail body content 
            $bodyContent = "<p>Hi there, your MIL Extensions System password for the username <b>$current_user</b> has been successfully changed to <b>$new_password</b> , please login and change it as soon as possible.</p><br>";

                                                
            $mail->Body  = $bodyContent;
                                                    
            $mail->send();
            //Clear Cache
            $mail->clearAllRecipients( );
            //Send Email to Head of Department

            //Add Transaction to Audit Log
            $the_table = "users";
            $the_value = "Forgot Password : $current_user";

            // Call the function to add the transaction to the audit log
            addToAuditLog($connect, $transaction_update, $the_table, $current_user, $the_value);
            
            $message = "<center>Password successfully changed, please check your email for the new password</center>";
           $alert = "alert alert-success alert-dismissible fade show";
          
        }else{
            
        }

    }catch(PDOException $error){
        $message = $error->getMessage();
        
    }
} 

/*----------------------------------------------------------------------------------------------------------------------------

                                           ADD NEW LOCKER CODE
----------------------------------------------------------------------------------------------------------------------------*/ 
elseif(isset($_POST["record_new_locker"])){
    $message = "";
    $alert = "";
    $span = "";
    
    
    $locker_code = $_POST["locker_code"];
    $locker_size = $_POST["locker_size"];
    $locker_location = $_POST["locker_location"];

  
    
    try{ 

        $add_locker = $connect->prepare("INSERT INTO lockers (code, size, location, date) VALUES (?, ?, ?, ?)");
        $add_locker->execute([$locker_code, $locker_size, $locker_location, $current_date]);

        echo "<script type='text/javascript'>window.location.href='lockers'</script>";
        
    
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}

/*----------------------------------------------------------------------------------------------------------------------------

                                           DELETE LOCKER CODE
----------------------------------------------------------------------------------------------------------------------------*/ 
elseif(isset($_POST["delete_locker"])){
    $message = "";
    $alert = "";
    $span = "";
    
    $c_id = $_POST["c_id"];
    
    try{ 

        $delete_locker = $connect->prepare("DELETE FROM lockers WHERE id=?");
        $delete_locker->execute([$c_id]);

        echo "<script type='text/javascript'>window.location.href='lockers'</script>";
        
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}

/*----------------------------------------------------------------------------------------------------------------------------

                                           ADD NEW PARCEL CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["record_new_parcel"])){
    $message = "";
    $alert = "";
    $span = "";
    
   
    
    $parcel_code = $_POST["parcel_code"];
    $parcel_size = $_POST["parcel_size"];
    $parcel_sent_to_province = $_POST["parcel_sent_to_province"];
    $assigned_locker = $_POST["assigned_locker"];
    $sender_phone_number = $_POST["sender_phone_number"];
    $sender_address = $_POST["sender_address"];
    $receiver_fullname = $_POST["receiver_fullname"];
    $receiver_id_number = $_POST["receiver_id_number"];
    $receiver_phone_number = $_POST["receiver_phone_number"];
    $receiver_address = $_POST["receiver_address"];
    $parcel_status = "Pending";

    
    try{ 


        //Add New Parcel
        $add_query = $connect->prepare("INSERT INTO parcels (code, size, province, locker, sender_phone, sender_address, receiver_fullname, receiver_phone, receiver_address, status, date, time, sender) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $add_query->execute([$parcel_code, $parcel_size, $parcel_sent_to_province, $assigned_locker, $sender_phone_number, $sender_address, $receiver_fullname, $receiver_phone_number, $receiver_address, $parcel_status, $current_date, $current_time, $user]);

        //$basic  = new \Vonage\Client\Credentials\Basic("6bcb73b6", "I78Kj8xFjrzOrMeS");
       // $client = new \Vonage\Client($basic);


         $message = "<center>Parcel Successfully Added</center>";
         $alert = "alert alert-success alert-dismissible fade show";

    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}

/*----------------------------------------------------------------------------------------------------------------------------

                                           ADD NEW MEMBER IN THE DATABASE CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["record_new_member"])){
    $message = "";
    $alert = "";
    $span = "";
    
   
    
    $member_code = $_POST["member_code"];
    $m_full_name = $_POST["m_full_name"];
    $m_phone_number = $_POST["m_phone_number"];
    $m_email = $_POST["m_email"];
    $m_address = $_POST["m_address"];
    $m_kingschat_handle = $_POST["m_kingschat_handle"];
    $m_foundation_school_status = $_POST["m_foundation_school_status"];
    $m_baptsim_status = $_POST["m_baptsim_status"];
    $m_cell_group = $_POST["m_cell_group"];
    $m_service_department = $_POST["m_service_department"];
    $m_member_status = $_POST["m_member_status"];
    $m_gender = $_POST["m_gender"];

    
    try{ 

        if($role == "admin"){
        
            $check_data = $connect->prepare("SELECT * FROM members WHERE fullname=? AND phone_number=? AND email=?");
            $check_data->execute([$m_full_name,$m_phone_number,$m_email]);
            $count_found_members = $check_data->rowCount();

            if($count_found_members == 0){
                //Add New Member
                $add_new_member_query = $connect->prepare("INSERT INTO members (code, fullname, phone_number, email, address, kingschat_handle, foundation_school, baptism_status, cell_group, service_department, member_status, date, gender) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $add_new_member_query->execute([$member_code,$m_full_name,$m_phone_number,$m_email,$m_address,$m_kingschat_handle,$m_foundation_school_status,$m_baptsim_status,$m_cell_group,$m_service_department,$m_member_status,$current_date,$m_gender]);

                $message = "<center>Member successfully registered</center>";
                $alert = "alert alert-success alert-dismissible fade show";
            }else{
                //Error
                $message = "<center>Member is already in the database</center>";
                $alert = "alert alert-danger alert-dismissible fade show";
            }
        }elseif($role == "cell"){
            $check_data = $connect->prepare("SELECT * FROM members WHERE fullname=? AND phone_number=?");
            $check_data->execute([$m_full_name,$m_phone_number,]);
            $count_found_members = $check_data->rowCount();

            if($count_found_members == 0){
                //Add New Member
                $add_new_member_query = $connect->prepare("INSERT INTO members (code, fullname, phone_number, cell_group, member_status, date, gender) VALUES (?,?,?,?,?,?,?)");
                $add_new_member_query->execute([$member_code,$m_full_name,$m_phone_number,$m_cell_group,$m_member_status,$current_date,$m_gender]);

                $message = "<center>Cell Convert successfully registered</center>";
                $alert = "alert alert-success alert-dismissible fade show";
            }else{
                //Error
                $message = "<center>Member is already in the database</center>";
                $alert = "alert alert-danger alert-dismissible fade show";
            }
        }
    
       
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
} 
/*----------------------------------------------------------------------------------------------------------------------------

                                           ADD NEW PROJECT IN THE DATABASE CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["record_new_project"])){
    $message = "";
    $alert = "";
    $span = "";
    
   
    
    $project_code = $_POST["project_code"];
    $project_name = $_POST["project_name"];
    $project_desc = $_POST["project_desc"];
    $project_target = $_POST["project_target"];
    
    $stat = "";
    
    try{
        
        $check_projects_query = $connect->prepare("SELECT * FROM projects WHERE name=? AND description=? AND amount=? AND status=?");
        $check_projects_query->execute([$project_name,$project_desc,$project_target,$stat]);
        $count_found_projets = $check_projects_query->rowCount();

        if($count_found_projets == 0){
            //Add New Project
            //INSERT INTO `projects`(`id`, `code`, `name`, `description`, `amount`, `date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]')
            $add_project_query = $connect->prepare("INSERT INTO projects (code, name, description, amount, date) VALUES (?,?,?,?,?)");
            $add_project_query->execute([$project_code,$project_name,$project_desc,$project_target,$current_date]);


            $message = "<center>Project successfully registered</center>";
            $alert = "alert alert-success alert-dismissible fade show";
        }else{
            //Error
            $message = "<center>Project is already in the database</center>";
            $alert = "alert alert-danger alert-dismissible fade show";
        }
    
       
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
} 

/*----------------------------------------------------------------------------------------------------------------------------

                                           ADD NEW CELL MEETING IN THE DATABASE CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["record_new_cell_meeting"])){
    $message = "";
    $alert = "";
    $span = "";
    
   
    
    $cell_meeting_code = $_POST["cell_meeting_code"];
    $cell_meeting_date = $_POST["cell_meeting_date"];
    $cell_meeting_name = $_POST["cell_meeting_name"];
    $cell_meeting_offering_amount = $_POST["cell_meeting_offering_amount"];

    $cell_meeting_date = date("Y-m-d", strtotime($cell_meeting_date));

    $cell_member1 = $_POST["cell_member1"];

    
    try{

        $check_cell_meetings_query = $connect->prepare("SELECT * FROM cell_meetings WHERE cell=? AND meeting=? AND offerings=? AND date=?");
        $check_cell_meetings_query->execute([$cell_code,$cell_meeting_name,$cell_meeting_offering_amount,$cell_meeting_date]);
        $count_found_meetings = $check_cell_meetings_query->rowCount();

        if($count_found_meetings == 0){
            //Add Meeting
            $add_meeting_query = $connect->prepare("INSERT INTO cell_meetings (code, cell, meeting, offerings, date) VALUES (?,?,?,?,?)");
            $add_meeting_query->execute([$cell_meeting_code,$cell_code,$cell_meeting_name,$cell_meeting_offering_amount,$cell_meeting_date]);

            //Add First Data
            $add_first_data_query = $connect->prepare("INSERT INTO cell_meeting_members (code, member) VALUES (?,?)");
            $add_first_data_query->execute([$cell_meeting_code,$cell_member1]);

            for ($i = 1; $i <= 1000; $i++) {

                $cell_member = $_POST["cell_member".$i];

                if($cell_member == ""){
                    break;
                }else{
                    //Add First Data
                    $add_first_data_query = $connect->prepare("INSERT INTO cell_meeting_members (code, member) VALUES (?,?)");
                    $add_first_data_query->execute([$cell_meeting_code,$cell_member]);
                }
            }

            for ($a = 1; $a <= 1000; $a++) {

                $cell_convert = $_POST["cell_convert".$a];

                if($cell_convert == ""){
                    break;
                }else{
                    //Add First Data
                    $add_first_data_query = $connect->prepare("INSERT INTO cell_meeting_convert_members (code, member) VALUES (?,?)");
                    $add_first_data_query->execute([$cell_meeting_code,$cell_convert]);
                }
            }

            $find_members_in_meeting_query = $connect->prepare("SELECT * FROM cell_meeting_members WHERE code=?");
            $find_members_in_meeting_query->execute([$cell_meeting_code]);
            $count_found_members_in_meeting = $find_members_in_meeting_query->rowCount();

            $find_total_members_in_cell_query = $connect->prepare("SELECT * FROM members WHERE cell_group=?");
            $find_total_members_in_cell_query->execute([$cell_code]);
            $count_total_members_in_cell = $find_total_members_in_cell_query->rowCount();

            $percentage_attendance = ($count_total_members_in_cell > 0) ? ($count_found_members_in_meeting / $count_total_members_in_cell) * 100  : 0;

            $update_query = $connect->prepare("UPDATE cell_meetings SET attendance=? WHERE code=?");
            $update_query->execute([$percentage_attendance,$cell_meeting_code]);

            $message = "<center>Cell Meeting was successfully recorded</center>";
            $alert = "alert alert-success alert-dismissible fade show";
        }else{
            $message = "<center>Cell Meeting already added</center>";
            $alert = "alert alert-danger alert-dismissible fade show";
        }
        
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
} 
/*----------------------------------------------------------------------------------------------------------------------------

                                           RECORD CELL MEETING FIRST TIMER IN THE DATABASE CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["record_cell_meeting_first_timer"])){
    $message = "";
    $alert = "";
    $span = "";
    
   
    
    $the_cell_meeting = $_POST["the_cell_meeting"];

    $the_new_member_code = $_POST["the_new_member_code"];

    $the_cell_code = $_POST["the_cell_code"];
    
    $cell_meeting_member_fullname = $_POST["cell_meeting_member_fullname"];
    $cell_meeting_member_phone_number = $_POST["cell_meeting_member_phone_number"];
    $cell_meeting_member_gender = $_POST["cell_meeting_member_gender"];

    $the_member_status = "first_timer";

    $the_service_department = "No-Department";

    try{

        $check_member_details = $connect->prepare("SELECT * FROM members WHERE fullname=? AND phone_number=? AND gender=?");
        $check_member_details->execute([$cell_meeting_member_fullname,$cell_meeting_member_phone_number,$cell_meeting_member_gender]);
        $count_found_member_details = $check_member_details->rowCount();

        if($count_found_member_details == 0){
            //Add New Member
            $add_new_member_query = $connect->prepare("INSERT INTO members (code, fullname, phone_number, cell_group, member_status, date, gender, service_department) VALUES (?,?,?,?,?,?,?,?)");
            $add_new_member_query->execute([$the_new_member_code,$cell_meeting_member_fullname,$cell_meeting_member_phone_number,$the_cell_code,$the_member_status,$current_date,$cell_meeting_member_gender,$the_service_department]);

           
            $add_to_meeting_query = $connect->prepare("INSERT INTO cell_meeting_first_timers (code, member) VALUES (?,?)");
            $add_to_meeting_query->execute([$the_cell_meeting,$the_new_member_code]);

            echo "<script type='text/javascript'>window.location.href='view_all_cell_meetings'</script>";
        }else{
            echo "<script type='text/javascript'>window.location.href='view_all_cell_meetings'</script>";
        }
            

    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}
 
/*----------------------------------------------------------------------------------------------------------------------------

                                           VIEW CELL MEETING DETAILS CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["view_cell_meeting_details"])){
    $message = "";
    $alert = "";
    $span = "";
    
   
    
    $c_code = $_POST["c_code"];

    

    try{

        $_SESSION["cell_meeting"] = $c_code;

        echo "<script type='text/javascript'>window.location.href='cell_meeting_report'</script>";

    }catch(PDOException $error){
        $message = $error->getMessage();
    }
} 
/*----------------------------------------------------------------------------------------------------------------------------

                                           ADD NEW FOUNDATION SCHOOL CLASS IN THE DATABASE CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["record_new_foundation_school_class"])){
    $message = "";
    $alert = "";
    $span = "";
    
   
    
    $class_code = $_POST["class_code"];
    $f_class_name = $_POST["f_class_name"];
    $f_class_teacher = $_POST["f_class_teacher"];
    $f_student1 = $_POST["f_student1"];
    $f_stat = "Active";

   
    
    try{

        $check_class = $connect->prepare("SELECT * FROM classes WHERE name=?");
        $check_class->execute([$f_class_name]);
        $count_found_classes = $check_class->rowCount();

        if($count_found_classes == 0){
            //Add New Class
            $add_class_query = $connect->prepare("INSERT INTO classes (code, name, teacher, date) VALUES (?,?,?,?)");
            $add_class_query->execute([$class_code,$f_class_name,$f_class_teacher,$current_date]);

            //Add the remaining students to the Class
            for ($i = 1; $i <= 1000; $i++) {

                $f_student = $_POST["f_student".$i];

                if($f_student == ""){
                    break;
                }else{
                    //Add First Data
                    $add_first_student_to_class_query = $connect->prepare("INSERT INTO class_students (class, student, status, date_started) VALUES (?,?,?,?)");
                    $add_first_student_to_class_query->execute([$class_code,$f_student,$f_stat,$current_date]);
                }
            }

            $message = "<center>Class successfully created and students added to class</center>";
            $alert = "alert alert-success alert-dismissible fade show";

        }else{
            //Error
            $message = "<center>Foundation School Class already added</center>";
            $alert = "alert alert-danger alert-dismissible fade show";
        }

    }catch(PDOException $error){
        $message = $error->getMessage();
    }
} 
/*----------------------------------------------------------------------------------------------------------------------------

                                           RECORD NEW MEMBER CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["register_member_and_record_attendance"])){
    $message = "";
    $alert = "";
    $span = "";
   
    $member_code = $_POST["member_code"];
    $m_full_name = $_POST["m_full_name"];
    $m_phone_number = $_POST["m_phone_number"];
    $m_email = $_POST["m_email"];
    $m_address = $_POST["m_address"];
    $m_gender = $_POST["m_gender"];
    $m_kingschat_handle = $_POST["m_kingschat_handle"];
    $m_cell_group = $_POST["m_cell_group"];
    $m_service_department = $_POST["m_service_department"];
    $m_member_status = $_POST["m_member_status"];
    $member_dob = $_POST["member_dob"];
    $f_stat = "Active";

    
    try{

        $check_data = $connect->prepare("SELECT * FROM members WHERE fullname=?");
        $check_data->execute([$m_full_name]);
        $count_found_data = $check_data->rowCount();

        if($count_found_data == 0){
            //Add New Member
            $add_query = $connect->prepare("INSERT INTO members (code, fullname, phone_number, email, address, kingschat_handle, cell_group, service_department, member_status, gender, date, dob) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
            $add_query->execute([$member_code,$m_full_name,$m_phone_number,$m_email,$m_address,$m_kingschat_handle,$m_cell_group,$m_service_department,$m_member_status,$m_gender,$current_date,$member_dob]);

            $register_attendance_query = $connect->prepare("INSERT INTO member_attendance (date, member) VALUES (?,?)");
            $register_attendance_query->execute([$current_date,$member_code]);

             //Alert
             $message = "<center>Successfully registered and attendance registered</center>";
             $alert = "alert alert-primary alert-dismissible fade show";
        }else{

            //Alert
            $message = "<center>Member already in the System Database</center>";
            $alert = "alert alert-danger alert-dismissible fade show";
        }

    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}  

/*----------------------------------------------------------------------------------------------------------------------------

                                            RECORD ATTENDANCE CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["record_service_attendance"])){
    $message = "";
    $alert = "";
    $span = "";
   
    $member = $_POST["member"];
   
    $f_stat = "Active";

    
    try{

        $check_data = $connect->prepare("SELECT * FROM member_attendance WHERE date=? AND member=?");
        $check_data->execute([$current_date,$member]);
        $count_found_data = $check_data->rowCount();

        if($count_found_data == 0){

            $add_query = $connect->prepare("INSERT INTO member_attendance (date, member) VALUES (?,?)");
            $add_query->execute([$current_date,$member]);

            $check_attendance_for_other_days = $connect->prepare("SELECT * FROM member_attendance WHERE member=?");
            $check_attendance_for_other_days->execute([$member]);
            $count_attendance_for_other_days = $check_attendance_for_other_days->rowCount();

            if($count_attendance_for_other_days > 3){
                $stat = "member";
                $update_query = $connect->prepare("UPDATE members SET member_status=? WHERE code=?");
                $update_query->execute([$stat,$member]);
            }

            //Alert
            $message = "<center>Successfully registered attendance</center>";
            $alert = "alert alert-primary alert-dismissible fade show";
        }else{
            //Alert
            $message = "<center>Attendance is already captured </center>";
            $alert = "alert alert-danger alert-dismissible fade show";
        }
       
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}   
/*----------------------------------------------------------------------------------------------------------------------------

                                           RECORD GENERAL PARTNERSHIP CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["record_general_partnership"])){
    $message = "";
    $alert = "";
    $span = "";
    
    
    
    $service_general_partnership = $_POST["service_general_partnership"];
    $service_date = $_POST["service_date"];
 
    
    try{  

        $part_name = "general";

        $add_query = $connect->prepare("INSERT INTO member_attendance_partnership_transactions (date, amount, name) VALUES (?,?,?)");
        $add_query->execute([$service_date,$service_general_partnership,$part_name]);

        echo "<script type='text/javascript'>window.location.href='service_attendance_records'</script>";
       
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
} 
/*----------------------------------------------------------------------------------------------------------------------------

                                           RECORD OTHER PARTNERSHIP CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["record_other_partnerships_for_the_service"])){
    $message = "";
    $alert = "";
    $span = "";
    
    
    
    $service_date = $_POST["service_date"];
    
    try{  
        $_SESSION["service_date"] = $service_date;

        echo "<script type='text/javascript'>window.location.href='record_other_partnerships'</script>";
       
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}
/*----------------------------------------------------------------------------------------------------------------------------

                                            RECORD OTHER PARTNERSHIPS CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["record_other_partnerships"])){
    $message = "";
    $alert = "";
    $span = "";
   
    $service_date = $_POST["service_date"];
   
    
    try{

        for ($i = 1; $i < 100; $i++) {
           $member = $_POST["member".$i];
           $partnership = $_POST["partnership".$i];
           $partnership_amount = $_POST["partnership_amount".$i];

           if($member == "" || $partnership == "" || $partnership_amount == ""){
                break;
           }else{
                //Add Query 
                $add_query = $connect->prepare("INSERT INTO member_attendance_partnership_transactions (date, amount, name, member) VALUES (?,?,?,?)");
                $add_query->execute([$service_date,$partnership_amount,$partnership,$member]);
           }
        }

        echo "<script type='text/javascript'>window.location.href='service_attendance_records'</script>";
        
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}

/*----------------------------------------------------------------------------------------------------------------------------

                                            OPEN SERVICE REPORT CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["open_service_report"])){
    $message = "";
    $alert = "";
    $span = "";
   
    $service_date = $_POST["service_date"];
   
    
    try{

        $_SESSION["service_date"] = $service_date;

        echo "<script type='text/javascript'>window.location.href='service_report'</script>";
        
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}

/*----------------------------------------------------------------------------------------------------------------------------

                                            OPEN SERVICE ATTENDANCE REPORT CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["open_attendance_report"])){
    $message = "";
    $alert = "";
    $span = "";
   
    $service_date = $_POST["service_date"];
   
    
    try{

        $_SESSION["service_date"] = $service_date;

        echo "<script type='text/javascript'>window.location.href='service_attendance_report'</script>";
        
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}

/*----------------------------------------------------------------------------------------------------------------------------

                                            OPEN SERVICE PARTNERSHIP REPORT CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["open_partnership_report"])){
    $message = "";
    $alert = "";
    $span = "";
   
    $service_date = $_POST["service_date"];
   
    
    try{

        $_SESSION["service_date"] = $service_date;

        echo "<script type='text/javascript'>window.location.href='service_partnership_report'</script>";
        
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}

/*----------------------------------------------------------------------------------------------------------------------------

                                            OPEN PARTNERSHIP REPORT CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["generate_partnership_report"])){
    $message = "";
    $alert = "";
    $span = "";

   
    $partnership = $_POST["partnership"];
    $partnership_year = $_POST["partnership_year"];
   
    
    try{

        $_SESSION["partnership"] = $partnership;

        $_SESSION["partnership_year"] = $partnership_year;

        echo "<script type='text/javascript'>window.location.href='partnership_report'</script>";
        
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}
/*----------------------------------------------------------------------------------------------------------------------------

                                            OPEN SERVICE REPORT CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["generate_service_attendance_report"])){
    $message = "";
    $alert = "";
    $span = "";

    $service_date = $_POST["service_date"];

    $service_date = date("Y-m-d", strtotime($service_date));
   
    
    try{

        $_SESSION["service_date"] = $service_date;

        echo "<script type='text/javascript'>window.location.href='service_report'</script>";
        
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}
/*----------------------------------------------------------------------------------------------------------------------------

                                            OPEN CELL REPORT CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["generate_cell_report"])){
    $message = "";
    $alert = "";
    $span = "";

   
    $cell_year = $_POST["cell_year"];
    $cell_month = $_POST["cell_month"];
   
    
    try{

        $_SESSION["cell_year"] = $cell_year;

        $_SESSION["cell_month"] = $cell_month;

        echo "<script type='text/javascript'>window.location.href='cell_report'</script>";
        
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}
/*----------------------------------------------------------------------------------------------------------------------------

                                           ADD NEW VEHICLE CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["add_new_vehicle"])){
    $message = "";
    $alert = "";
    $span = "";
    
    
    
    $vehicle_code = $_POST["vehicle_code"];
    $vehicle_category = $_POST["vehicle_category"];
    $vehicle_license_plate = $_POST["vehicle_license_plate"];
    $vehicle_driver_name = $_POST["vehicle_driver_name"];
    $vehicle_stat = "active";
   
    
    try{  
        
        $check_vehicle_data = $connect->prepare("SELECT * FROM vehicles WHERE plate=?");
        $check_vehicle_data->execute([$vehicle_license_plate]);
        $count_vehicle_data = $check_vehicle_data->rowCount();
      
        
        if($count_vehicle_data == 0){
            //Add New Vehicle
            $add_data = $connect->prepare("INSERT INTO vehicles (code, plate, category, driver, status, date.last_modified) VALUES (?,?,?,?,?,?,NOW())");
            $add_data->execute([$vehicle_code,$vehicle_license_plate,$vehicle_category,$vehicle_driver_name,$vehicle_stat,$current_date]);
            
            $message = "<center>Vehicle successfully registered</center>";
            $alert = "alert alert-success alert-dismissible fade show";
        }else{
            $message = "<center>Vehicle Already in the System Database</center>";
            $alert = "alert alert-danger alert-dismissible fade show";
        }
        
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}

/*----------------------------------------------------------------------------------------------------------------------------

                                           UPDATE VEHICLE DETAILS CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["update_vehicle_details"])){
    $message = "";
    $alert = "";
    $span = "";
    
    
    
    $the_id = $_POST["the_id"];
    $the_code = $_POST["the_code"];
    $u_vehicle_plate = $_POST["u_vehicle_plate"];
    $u_vehicle_driver = $_POST["u_vehicle_driver"];
  
    
    try{  
    
        //UPDATE `vehicles` SET `id`='[value-1]',`code`='[value-2]',`plate`='[value-3]',`category`='[value-4]',`driver`='[value-5]',`status`='[value-6]',`date`='[value-7]' WHERE 1
        $update_query = $connect->prepare("UPDATE vehicles SET plate=?, driver=?, last_modified=NOW() WHERE id=?");
        $update_query->execute([$u_vehicle_plate,$u_vehicle_driver,$the_id]);
       
    
        echo "<script type='text/javascript'>window.location.href='view_all_vehicles'</script>";
       
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
} 
/*----------------------------------------------------------------------------------------------------------------------------

                                           DELETE VEHICLE CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["delete_vehicle"])){
    $message = "";
    $alert = "";
    $span = "";
    
    
    
    $c_id = $_POST["c_id"];
 
    
    try{  
        
        //DELETE FROM `vehicles` WHERE 0
        $del_query = $connect->prepare("DELETE FROM vehicles WHERE id=?");
        $del_query->execute([$c_id]);

       
        echo "<script type='text/javascript'>window.location.href='view_all_vehicles'</script>";
       
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}

/*----------------------------------------------------------------------------------------------------------------------------

                                            RECORD NEW PREPAYMENT TRANSACTION CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["record_prepayment_transaction"])){
    $message = "";
    $alert = "";
    $span = "";

    
    $prepayment_code = $_POST["prepayment_code"];
    $prepayment_amount = $_POST["prepayment_amount"];
    $prepayment_vehicles = $_POST["prepayment_vehicles"];

    $transaction_code = calculateTransactionCode($connect);

    $transaction_description = "Prepayment";
    
   
   
    try{ 
        
        //INSERT INTO `prepayments`(`id`, `code`, `amount`, `date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]')
        $record_payment_query = $connect->prepare("INSERT INTO prepayments (code, amount, date, amount_left) VALUES (?,?,?,?)");
        $record_payment_query->execute([$prepayment_code,$prepayment_amount,$current_date,$prepayment_amount]);


        foreach($_POST["prepayment_vehicles"] as  $vehicle){
                
            //INSERT INTO `prepayment_vehicles`(`id`, `prepayment`, `vehicle`, `date`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]')
            $add_vehicle = $connect->prepare("INSERT INTO prepayment_vehicles (prepayment, vehicle, date) VALUES (?,?,?)");
            $add_vehicle->execute([$prepayment_code,$vehicle,$current_date]);

        }

        //Record Transaction
        //INSERT INTO `transactions`(`id`, `code`, `description`, `amount`, `date`, `link`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]')
        $add_transaction_query = $connect->prepare("INSERT INTO transactions (code, description, amount, date, link) VALUES (?,?,?,?,?)");
        $add_transaction_query->execute([$transaction_code,$transaction_description,$prepayment_amount,$current_date,$prepayment_code]);
        
        $message = "<center>Prepayment Transaction successfully added in the System</center>";
        $alert = "alert alert-success alert-dismissible fade show";
        
        
      
       
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}
/*----------------------------------------------------------------------------------------------------------------------------

                                            DELETE PREPAYMENT DETAILS CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["delete_prepayment"])){
    $message = "";
    $alert = "";
    $span = "";
    
    
    $the_code = $_POST["the_code"];
    
    try{  

        //DELETE FROM `prepayments` WHERE 0
        $del_one = $connect->prepare("DELETE FROM prepayments WHERE code=?");
        $del_one->execute([$the_code]);

        //DELETE FROM `prepayment_vehicles` WHERE 0
        $del_two = $connect->prepare("DELETE FROM prepayment_vehicles WHERE prepayment=?");
        $del_two->execute([$the_code]);

        //DELETE FROM `transactions` WHERE 0
        $del_three = $connect->prepare("DELETE FROM transactions WHERE link=?");
        $del_three->execute([$the_code]);
        
      
        echo "<script type='text/javascript'>window.location.href='view_all_prepayments'</script>";
        
    
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}
/*----------------------------------------------------------------------------------------------------------------------------

                                            RECORD NEW VEHICLE ENTRY - ENTRANCE CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["open_boomgate_entrance"])){
    $message = "";
    $alert = "";
    $span = "";

    
    $vehicle_entry_code = $_POST["vehicle_entry_code"];
    $vehicle_plate = $_POST["vehicle_plate"];
    $vehicle_trans_code = $_POST["trans_code"];

    $vehicle_entrance_status = "open";

   
    try{ 
        
        $check_vehicle_entry = $connect->prepare("SELECT * FROM vehicle_entry WHERE vehicle=? AND status=?");
        $check_vehicle_entry->execute([$vehicle_plate,$vehicle_entrance_status]);
        $count_vehicle_entry_data = $check_vehicle_entry->rowCount();
        
        //if($count_vehicle_entry_data == 0){

    
            //SELECT `id`, `code`, `plate`, `category`, `driver`, `status`, `date` FROM `vehicles` WHERE 1
            $find_vehicles = $connect->prepare("SELECT * FROM vehicles WHERE plate=?");
            $find_vehicles->execute([$vehicle_plate]);
            $count_found_vehicle = $find_vehicles->rowCount();

            if($count_found_vehicle == 1){
                
                while($row=$find_vehicles->fetch(PDO::FETCH_ASSOC)){
                    $vehicle_category = $row["category"];
                    $vehicle_code = $row["code"];
                }

                $find_vehicle_category_details_query = $connect->prepare("SELECT * FROM categories WHERE code=?");
                $find_vehicle_category_details_query->execute([$vehicle_category]);
                while($row=$find_vehicle_category_details_query->fetch(PDO::FETCH_ASSOC)){
                    $vehicle_category_amount = $row["cost"];
                    $vehicle_category_minutes = $row["minutes"];
                }
                
              
                
                //Record Vehicle Entry in the System
                $add_query = $connect->prepare("INSERT INTO vehicle_entry (code, vehicle, entrance_time, status, date, time, amount, transaction) VALUES (?,?,?,?,?,?,?,?)");
                $add_query->execute([$vehicle_entry_code,$vehicle_plate,$current_time,$vehicle_entrance_status,$current_date,$current_time,$vehicle_category_amount,$vehicle_trans_code]);


                $check_vehicle_in_prepayment_query = $connect->prepare("SELECT * FROM prepayments WHERE code IN (SELECT prepayment FROM prepayment_vehicles WHERE vehicle=?)");
                $check_vehicle_in_prepayment_query->execute([$vehicle_code]);
                $count_found_vehicle_in_prepayment = $check_vehicle_in_prepayment_query->rowCount();

                if($count_found_vehicle_in_prepayment == 0){
                    //Record the Transaction in the Database
                    $stat = "VEHICLE";
                    $record_transaction_query = $connect->prepare("INSERT INTO transactions (code, description, amount, date, link) VALUES (?,?,?,?,?)");
                    $record_transaction_query->execute([$vehicle_trans_code,$stat,$vehicle_category_amount,$current_date,$vehicle_code]);
                }else{
                    //Record Prepayment Payment Here
                    while($row=$check_vehicle_in_prepayment_query->fetch(PDO::FETCH_ASSOC)){
                        //SELECT `id`, `code`, `amount`, `amount_left`, `status`, `date` FROM `prepayments` WHERE 1
                        $pre_code = $row["code"];
                        $pre_amount = $row["amount"];
                        $pre_amount_left = $row["amount_left"];

                        if($pre_amount_left < $vehicle_category_amount){
                            $pre_balance = $vehicle_category_amount - $pre_amount_left; 
                            $my_message = "You have to pay an extra ".format_money($pre_balance)." Transaction has been recorded";

                            $new_balance = 0;

                            $update_prepayments_query = $connect->prepare("UPDATE prepayments SET amount_left=? WHERE code=?");
                            $update_prepayments_query->execute([$new_balance,$pre_code]);

                        }elseif($pre_amount_left > $vehicle_category_amount){
                            $new_balance = $pre_amount_left - $vehicle_category_amount;

                            $update_prepayments_query = $connect->prepare("UPDATE prepayments SET amount_left=? WHERE code=?");
                            $update_prepayments_query->execute([$new_balance,$pre_code]);
                        }

                        //Record Transaction 
                        $stat = "Deducted";
                        $record_transaction_query = $connect->prepare("INSERT INTO transactions (code, description, amount, date, link) VALUES (?,?,?,?,?)");
                        $record_transaction_query->execute([$vehicle_trans_code,$stat,$vehicle_category_amount,$current_date,$pre_code]);

                    }
                }

                //Record Transaction in the Database

                
                //Update JSON FOR ENTRY
                $filePath = '../includes/methods/entrance/boom.json';

                $newContent = 'open';

                // Write the new content to the file
                file_put_contents($filePath, $newContent);

                //Print the Receipt for that Bus 
                /* Variables (Replace with actual data as needed) */
                $receiptNumber = "$vehicle_trans_code"; // Replace with actual receipt number
                $plateNumber = "$vehicle_plate"; // Replace with actual plate number
                $checkInTime = date('H:i:s'); // Replace with actual check-in time
                $allowedDuration = $vehicle_category_minutes; // Allowed duration in hours
                

                // Example check-out time (3 hours later); replace with actual check-out time
                $checkOutTime = date('H:i:s', strtotime('+'.($vehicle_category_minutes - 30).' minutes'));

                // Calculate total stay duration in hours
                $checkInTimestamp = strtotime($checkInTime);
                $checkOutTimestamp = strtotime($checkOutTime);
             

                /* Header */
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("*********************************\n");
                $printer -> text("   Kwekwe City Council - Bus Rank   \n");
                $printer -> text("      P.O Box 115. Kwekwe         \n");
                $printer -> text("    Tel: 055 – 25 – 22301/7      \n");
                $printer -> text("*********************************\n");
                $printer -> text("\n");
                $printer -> text("Receipt No: $receiptNumber\n");
                $printer -> text("Date: " . date('Y-m-d H:i:s') . "\n");
                $printer -> text("\n");

                /* Bus Details */
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text("Plate Number: $plateNumber\n");
                $printer -> text("Check-in Time: $checkInTime\n");
                $printer -> text("Check-out Time: $checkOutTime\n");
                $printer -> text("-------------------------------\n");
                $printer -> text("Allowed Duration: ".$vehicle_category_minutes - 30 ." minutes\n");
                $printer -> text("-------------------------------\n");
                $printer -> text("\n");

                /* Fees */
                $printer -> text("Fee Description      Amount\n");
                $printer -> text("-------------------------------\n");
                $printer -> text("Parking Fee         ".format_money($vehicle_category_amount)."\n");
                $printer -> text("-------------------------------\n");


                /* Total */
                $totalAmount = 10.00 + $overtimeFee ;
                $printer -> setJustification(Printer::JUSTIFY_RIGHT);
                $printer -> text("Total              " . format_money($vehicle_category_amount) . "\n");

                /* Footer */
               $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("\n");
                /* Bold disclaimer */
              $printer -> setEmphasis(true);
                $printer -> text("Disclaimer: Overstaying will carry an additional cost.\n");
                $printer -> setEmphasis(false);
                $printer -> text("\n");
                $printer -> text("Thank you for your payment!\n");
                $printer -> text("Safe travels!\n");
                $printer -> text("\n");
                $printer -> text("*********************************\n");
                $printer -> text("Powered by Cyberselp Incorporation\n");
                $printer -> text("Email: info@cyberselp.com\n");
                $printer -> text("*********************************\n");

                /* Cut the receipt */
                $printer -> cut();
                
                /* Close printer */
                $printer -> close();
                //End Print Receipt for that bus*/

                $message = "<center>Vehicle Entrance Recorded Successfully</center>";
                $alert = "alert alert-success alert-dismissible fade show";
            }else{
                $message = "<center>Vehicle not found in the System Database</center>";
                $alert = "alert alert-warning alert-dismissible fade show"; 
            }
            
      //  }else{
            
          //  $message = "<center>Vehicle is still inside the Rank</center>";
          //  $alert = "alert alert-danger alert-dismissible fade show"; 
       // }
            
       
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}

// the_vehicle_code, the_vehicle_entry_code, the_transaction_code, new_vehicle_plate, new_vehicle_category,  
/*----------------------------------------------------------------------------------------------------------------------------

                                            RECORD UNREGISTERED VEHICLE AND RECORD PAYMENT - ENTRANCE CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["record_unregistered_vehicle_and_record_payment"])){
    $message = "";
    $alert = "";
    $span = "";

    $the_vehicle_code = $_POST["the_vehicle_code"];
    $the_vehicle_entry_code = $_POST["the_vehicle_entry_code"];
    $the_transaction_code = $_POST["the_transaction_code"];
    $new_vehicle_plate = strtoupper($_POST["new_vehicle_plate"]);
    $new_vehicle_category = $_POST["new_vehicle_category"];
    $new_vehicle_driver = "Driver";


    $vehicle_entrance_status = "open";
    $vehicle_status_stat = "active";

   
    try{ 

        $check_vehicle_database = $connect->prepare("SELECT * FROM vehicles WHERE plate=?");
        $check_vehicle_database->execute([$new_vehicle_plate]);
        $count_found_vehicle_database = $check_vehicle_database->rowCount();

        if($count_found_vehicle_database == 0){
            //Add Vehicle Entry
            $add_vehicle_query = $connect->prepare("INSERT INTO vehicles (code, plate, category, driver, status, date, last_modified) VALUES (?,?,?,?,?,?,NOW())");
            $add_vehicle_query->execute([$the_vehicle_code,$new_vehicle_plate,$new_vehicle_category,$new_vehicle_driver,$vehicle_status_stat,$current_date]);

            $check_vehicle_entry = $connect->prepare("SELECT * FROM vehicle_entry WHERE vehicle=? AND status=?");
            $check_vehicle_entry->execute([$new_vehicle_plate,$vehicle_entrance_status]);
            $count_vehicle_entry_data = $check_vehicle_entry->rowCount();

            if($count_vehicle_entry_data == 0){
                //Add Vehicle Entry
                $find_vehicles = $connect->prepare("SELECT * FROM vehicles WHERE plate=?");
                $find_vehicles->execute([$new_vehicle_plate]);
                $count_found_vehicle = $find_vehicles->rowCount();

                if($count_found_vehicle == 1){
                    while($row=$find_vehicles->fetch(PDO::FETCH_ASSOC)){
                        $vehicle_category = $row["category"];
                        $vehicle_code = $row["code"];
                    }

                    $find_vehicle_category_details_query = $connect->prepare("SELECT * FROM categories WHERE code=?");
                    $find_vehicle_category_details_query->execute([$vehicle_category]);
                    while($row=$find_vehicle_category_details_query->fetch(PDO::FETCH_ASSOC)){
                        $vehicle_category_amount = $row["cost"];
                        $vehicle_category_minutes = $row["minutes"];
                    }

                    $add_query = $connect->prepare("INSERT INTO vehicle_entry (code, vehicle, entrance_time, status, date, time, amount, transaction) VALUES (?,?,?,?,?,?,?,?)");
                    $add_query->execute([$the_vehicle_entry_code,$new_vehicle_plate,$current_time,$vehicle_entrance_status,$current_date,$current_time,$vehicle_category_amount,$the_transaction_code]);

                    $check_vehicle_in_prepayment_query = $connect->prepare("SELECT * FROM prepayments WHERE code IN (SELECT prepayment FROM prepayment_vehicles WHERE vehicle=?)");
                    $check_vehicle_in_prepayment_query->execute([$the_vehicle_code]);
                    $count_found_vehicle_in_prepayment = $check_vehicle_in_prepayment_query->rowCount();

                    if($count_found_vehicle_in_prepayment == 0){
                        //Record the Transaction in the Database
                        $stat = "VEHICLE";
                        $record_transaction_query = $connect->prepare("INSERT INTO transactions (code, description, amount, date, link) VALUES (?,?,?,?,?)");
                        $record_transaction_query->execute([$the_transaction_code,$stat,$vehicle_category_amount,$current_date,$the_vehicle_code]);
                    }else{
                        //Record Prepayment Payment Here
                        while($row=$check_vehicle_in_prepayment_query->fetch(PDO::FETCH_ASSOC)){
                        //SELECT `id`, `code`, `amount`, `amount_left`, `status`, `date` FROM `prepayments` WHERE 1
                        $pre_code = $row["code"];
                        $pre_amount = $row["amount"];
                        $pre_amount_left = $row["amount_left"];

                        if($pre_amount_left < $vehicle_category_amount){
                            $pre_balance = $vehicle_category_amount - $pre_amount_left; 
                            $my_message = "You have to pay an extra ".format_money($pre_balance)." Transaction has been recorded";

                            $new_balance = 0;

                            $update_prepayments_query = $connect->prepare("UPDATE prepayments SET amount_left=? WHERE code=?");
                            $update_prepayments_query->execute([$new_balance,$pre_code]);

                        }elseif($pre_amount_left > $vehicle_category_amount){
                            $new_balance = $pre_amount_left - $vehicle_category_amount;

                            $update_prepayments_query = $connect->prepare("UPDATE prepayments SET amount_left=? WHERE code=?");
                            $update_prepayments_query->execute([$new_balance,$pre_code]);
                        }

                        //Record Transaction 
                        $stat = "Deducted";
                        $record_transaction_query = $connect->prepare("INSERT INTO transactions (code, description, amount, date, link) VALUES (?,?,?,?,?)");
                        $record_transaction_query->execute([$the_transaction_code,$stat,$vehicle_category_amount,$current_date,$pre_code]);

                    }
                }

                //Update JSON FOR ENTRY
                $filePath = '../includes/methods/entrance/boom.json';
                    
                $newContent = 'open';

                // Write the new content to the file
                file_put_contents($filePath, $newContent);

                //Print the Receipt for that Bus 
                /* Variables (Replace with actual data as needed) */
                $receiptNumber = "$the_transaction_code"; // Replace with actual receipt number
                $plateNumber = "$new_vehicle_plate"; // Replace with actual plate number
                $checkInTime = date('H:i:s'); // Replace with actual check-in time
                $allowedDuration = $vehicle_category_minutes; // Allowed duration in hours
                

                // Example check-out time (3 hours later); replace with actual check-out time
                $checkOutTime = date('H:i:s', strtotime('+'.($vehicle_category_minutes - 30).' minutes'));

                // Calculate total stay duration in hours
                $checkInTimestamp = strtotime($checkInTime);
                $checkOutTimestamp = strtotime($checkOutTime);
             

                /* Header */
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("*********************************\n");
                $printer -> text("   Kwekwe City Council - Bus Rank   \n");
                $printer -> text("      P.O Box 115. Kwekwe         \n");
                $printer -> text("    Tel: 055 – 25 – 22301/7      \n");
                $printer -> text("*********************************\n");
                $printer -> text("\n");
                $printer -> text("Receipt No: $receiptNumber\n");
                $printer -> text("Date: " . date('Y-m-d H:i:s') . "\n");
                $printer -> text("\n");

                /* Bus Details */
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text("Plate Number: $plateNumber\n");
                $printer -> text("Check-in Time: $checkInTime\n");
                $printer -> text("Check-out Time: $checkOutTime\n");
                $printer -> text("-------------------------------\n");
                $printer -> text("Allowed Duration: ".$vehicle_category_minutes - 30 ." minutes\n");
                $printer -> text("-------------------------------\n");
                $printer -> text("\n");

                /* Fees */
                $printer -> text("Fee Description      Amount\n");
                $printer -> text("-------------------------------\n");
                $printer -> text("Parking Fee         ".format_money($vehicle_category_amount)."\n");
                $printer -> text("-------------------------------\n");


                /* Total */
                $totalAmount = 10.00 + $overtimeFee ;
                $printer -> setJustification(Printer::JUSTIFY_RIGHT);
                $printer -> text("Total              " . format_money($vehicle_category_amount) . "\n");

                /* Footer */
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("\n");
                /* Bold disclaimer */
                $printer -> setEmphasis(true);
                $printer -> text("Disclaimer: Overstaying will carry an additional cost.\n");
                $printer -> setEmphasis(false);
                $printer -> text("\n");
                $printer -> text("Thank you for your payment!\n");
                $printer -> text("Safe travels!\n");
                $printer -> text("\n");
                $printer -> text("*********************************\n");
                $printer -> text("Powered by Cyberselp Incorporation\n");
                $printer -> text("Email: info@cyberselp.com\n");
                $printer -> text("*********************************\n");

                /* Cut the receipt */
                $printer -> cut();
                
                /* Close printer */
                $printer -> close();
                //End Print Receipt for that bus

                $message = "<center>Vehicle Entrance Recorded Successfully</center>";
                $alert = "alert alert-success alert-dismissible fade show";


                }
            }
        }else{
            
            //SELECT `id`, `code`, `plate`, `category`, `driver`, `status`, `date`, `last_modified` FROM `vehicles` WHERE 1
            $find_vehicle_details = $connect->prepare("SELECT * FROM vehicles WHERE plate=?");
            $find_vehicle_details->execute([$new_vehicle_plate]);
            while($row=$find_vehicle_details->fetch(PDO::FETCH_ASSOC)){
                $ve_code = $row["code"];
                $ve_plate = $row["plate"];
                $ve_category = $row["category"];
                $ve_driver = $row["driver"];
                
                //SELECT `id`, `code`, `name`, `cost`, `minutes`, `date` FROM `categories` WHERE 1
                
                $find_ve_category_details = $connect->prepare("SELECT * FROM categories WHERE code=?");
                $find_ve_category_details->execute([$ve_category]);
                while($row=$find_ve_category_details->fetch(PDO::FETCH_ASSOC)){
                    $ve_cat_name = $row["name"];
                    $ve_cat_cost = $row["cost"];
                    $ve_cat_minutes = $row["minutes"];
                }
            }
            
            //Record Ticket
            
            //Record to Vehicle Entry 
            $stat = "open";
            $add_vehicle_entry_query = $connect->prepare("INSERT INTO vehicle_entry (code, vehicle, entrance_time, status, date, time, transaction, amount) VALUES (?,?,?,?,?,?,?,?)");
            $add_vehicle_entry_query->execute([$the_vehicle_entry_code,$new_vehicle_plate,$current_time,$stat,$current_date,$current_time,$the_transaction_code,$ve_cat_cost]);
            
            //Record Transaction for Vehicle
            $the_stat = "VEHICLE";
            $record_transaction_query = $connect->prepare("INSERT INTO transactions (code, description, amount, date, link) VALUES (?,?,?,?,?)");
            $record_transaction_query->execute([$the_transaction_code,$the_stat,$ve_cat_cost,$current_date,$the_vehicle_entry_code]);
            
            //Open Boomgate
            //Update JSON FOR ENTRY
            $filePath = '../includes/methods/entrance/boom.json';
                    
            $newContent = 'open';

            // Write the new content to the file
            file_put_contents($filePath, $newContent);
            
            //Record Ticket
            //Print the Receipt for that Bus 
                /* Variables (Replace with actual data as needed) */
                $receiptNumber = "$the_transaction_code"; // Replace with actual receipt number
                $plateNumber = "$new_vehicle_plate"; // Replace with actual plate number
                $checkInTime = date('H:i:s'); // Replace with actual check-in time
                $allowedDuration = $ve_cat_minutes; // Allowed duration in hours
                

                // Example check-out time (3 hours later); replace with actual check-out time
                $checkOutTime = date('H:i:s', strtotime('+'.($ve_cat_minutes - 30).' minutes'));

                // Calculate total stay duration in hours
                $checkInTimestamp = strtotime($checkInTime);
                $checkOutTimestamp = strtotime($checkOutTime);
             

                /* Header */
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("*********************************\n");
                $printer -> text("   Kwekwe City Council - Bus Rank   \n");
                $printer -> text("      P.O Box 115. Kwekwe         \n");
                $printer -> text("    Tel: 055 – 25 – 22301/7      \n");
                $printer -> text("*********************************\n");
                $printer -> text("\n");
                $printer -> text("Receipt No: $receiptNumber\n");
                $printer -> text("Date: " . date('Y-m-d H:i:s') . "\n");
                $printer -> text("\n");

                /* Bus Details */
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text("Plate Number: $plateNumber\n");
                $printer -> text("Check-in Time: $checkInTime\n");
                $printer -> text("Check-out Time: $checkOutTime\n");
                $printer -> text("-------------------------------\n");
                $printer -> text("Allowed Duration: ".$ve_cat_minutes - 30 ." minutes\n");
                $printer -> text("-------------------------------\n");
                $printer -> text("\n");

                /* Fees */
                $printer -> text("Fee Description      Amount\n");
                $printer -> text("-------------------------------\n");
                $printer -> text("Parking Fee         ".format_money($ve_cat_cost)."\n");
                $printer -> text("-------------------------------\n");


                /* Total */
                $totalAmount = 10.00 + $overtimeFee ;
                $printer -> setJustification(Printer::JUSTIFY_RIGHT);
                $printer -> text("Total              " . format_money($ve_cat_cost) . "\n");

                /* Footer */
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("\n");
                /* Bold disclaimer */
                $printer -> setEmphasis(true);
                $printer -> text("Disclaimer: Overstaying will carry an additional cost.\n");
                $printer -> setEmphasis(false);
                $printer -> text("\n");
                $printer -> text("Thank you for your payment!\n");
                $printer -> text("Safe travels!\n");
                $printer -> text("\n");
                $printer -> text("*********************************\n");
                $printer -> text("Powered by Cyberselp Incorporation\n");
                $printer -> text("Email: info@cyberselp.com\n");
                $printer -> text("*********************************\n");

                /* Cut the receipt */
                $printer -> cut();
                
                /* Close printer */
                $printer -> close();
                //End Print Receipt for that bus
            //Record Ticket
            


            $message = "<center>Vehicle Recorded and Transaction Recorded</center>";
            $alert = "alert alert-warning alert-dismissible fade show";
        }
        
       
    }catch(Exception $error){
      die($error->getMessage());
        $message = $error->getMessage();
    }
}
/*----------------------------------------------------------------------------------------------------------------------------

                                            RECORD NEW VEHICLE ENTRY - ENTRANCE CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["close_boomgate_entrance"])){
    $message = "";
    $alert = "";
    $span = "";

   
    try{ 

        //Update JSON FOR ENTRY
        $filePath = '../includes/methods/entrance/boom.json';

        $newContent = 'close';

        // Write the new content to the file
        file_put_contents($filePath, $newContent);

        $message = "<center>Boomgate Successfully Closed</center>";
        $alert = "alert alert-warning alert-dismissible fade show";
    
       
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}

/*----------------------------------------------------------------------------------------------------------------------------

                                            CHECK VEHICLE AT BOOMGATE EXIT CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["check_vehicle_exit"])){
    $message = "";
    $alert = "";
    $span = "";
    
    
    $the_vehicle_plate_code = $_POST["vehicle_plate"];
    $stat = "open";
  
    
    try{ 
        
        $find_vehicle_plate_details = $connect->prepare("SELECT * FROM vehicle_entry WHERE vehicle=? AND status=?");
        $find_vehicle_plate_details->execute([$the_vehicle_plate_code,$stat]);
        $count_found_vehicle_entries = $find_vehicle_plate_details->rowCount();

        while($row=$find_vehicle_plate_details->fetch(PDO::FETCH_ASSOC)){
            $the_entry_code = $row["code"];
        }


        if($count_found_vehicle_entries == 1){
            $_SESSION["entry_code"] = $the_entry_code;
        }else{
            echo "<script type='text/javascript'>window.location.href='dashboard'</script>";
        }

        echo "<script type='text/javascript'>window.location.href='dashboard'</script>";
        
    
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}
//
/*----------------------------------------------------------------------------------------------------------------------------

                                            CANCEL BOOM SESSION CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["cancel_boom_session"])){
    $message = "";
    $alert = "";
    $span = "";
    

    try{ 
        
        unset($_SESSION['entry_code']);
    
        echo "<script type='text/javascript'>window.location.href='dashboard'</script>";
        
    
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}
/*----------------------------------------------------------------------------------------------------------------------------

                                            RECORD EXIT PAYMENT AND OPEN BOOMGATE CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["record_exit_payment_and_open_boomgate"])){
    $message = "";
    $alert = "";
    $span = "";
    
    
    $entry_code = $_POST["entry_code"];
    $exit_time = $_POST["exit_time"];
    $vehicle_amount_to_be_paid = $_POST["vehicle_amount_to_be_paid"];
    $vehicle_amount_due = $_POST["vehicle_amount_due"];
    $vehicle_minutes = $_POST["vehicle_minutes"];
    $vehicle_code = $_POST["vehicle_code"];
    $trans_code = $_POST["trans_code"];
    $the_current_status = "open";
    $new_status = "closed";
    $prepayment_status = $_POST["prepayment_status"];
    $amount_left_on_the_prepayment = $_POST["amount_left_on_the_prepayment"];

    try{  

        $check_vehicle_entry_query = $connect->prepare("SELECT * FROM vehicle_entry WHERE code=? AND status=?");
        $check_vehicle_entry_query->execute([$entry_code,$the_current_status]);
        $count_found_data = $check_vehicle_entry_query->rowCount();

        if($count_found_data == 0){
            //Already Done
        }else{
            //Update Vehicle Entry
            $update_query = $connect->prepare("UPDATE vehicle_entry SET exit_time=?, status=?, minutes=?, transaction=? WHERE code=?");
            $update_query->execute([$exit_time,$new_status,$vehicle_minutes,$trans_code,$entry_code]);

            

            $_SESSION["vehicle_entry_done"] = $entry_code;

            //Update JSON FOR ENTRY
            $filePath = '../includes/methods/exit/boom.json';

            $newContent = 'open';

            // Write the new content to the file
            file_put_contents($filePath, $newContent);

        }


        
        echo "<script type='text/javascript'>window.location.href='dashboard'</script>";
        
    
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
/*----------------------------------------------------------------------------------------------------------------------------

                                            CHECK OVERTIME FOOR BUS CODE
----------------------------------------------------------------------------------------------------------------------------*/ 
}elseif(isset($_POST["check_overtime_for_bus"])){
    $message = "";
    $alert = "";
    $span = "";
    
    
    $vehicle_plate = $_POST["vehicle_plate"];
    $stat = "open";

    try{  
        $check_overtime_for_bus = $connect->prepare("SELECT * FROM vehicle_entry WHERE vehicle=? AND status=? ORDER BY id DESC LIMIT 1");
        $check_overtime_for_bus->execute([$vehicle_plate,$stat]);
        $count_found_data = $check_overtime_for_bus->rowCount();

        if($count_found_data == 1){
            
            while($row=$check_overtime_for_bus->fetch(PDO::FETCH_ASSOC)){
                //SELECT `id`, `code`, `vehicle`, `entrance_time`, `exit_time`, `status`, `date`, `time`, `minutes`, `transaction`, `amount` FROM `vehicle_entry` WHERE 1
                $en_code = $row["code"];
                $en_entrance_time = $row["entrance_time"];
                $en_exit_time = $row["exit_time"];
                $en_transaction = $row["transaction"];
                $en_amount = $row["amount"];

                $_SESSION["en_code"] = $en_code;

                echo "<script type='text/javascript'>window.location.href='dashboard'</script>";

        }
    }else{
        //
        echo "<script type='text/javascript'>window.location.href='dashboard'</script>";
    }
///
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}
/*----------------------------------------------------------------------------------------------------------------------------

                                            RECORD OVERTIME PAYMENT FOR BUS CODE
----------------------------------------------------------------------------------------------------------------------------*/ 
elseif(isset($_POST["record_overtime_for_vehicle"])){
    $message = "";
    $alert = "";
    $span = "";

    $entry_code = $_POST["entry_code"];
    $entry_cost = $_POST["entry_cost"];
    $entry_transaction = $_POST["entry_transaction"];
   

    try{ 
        $find_vehicle_plate_details = $connect->prepare("SELECT * FROM vehicle_entry WHERE code=?");
        $find_vehicle_plate_details->execute([$entry_code]);
        while($row=$find_vehicle_plate_details->fetch(PDO::FETCH_ASSOC)){
            $the_vehicle_plate = $row["vehicle"];
            $the_vehicle_category_amount = $row["amount"];
        }
       

        $amount_to_be_paid =  $entry_cost - $the_vehicle_category_amount;
        
        $update_query = $connect->prepare("UPDATE vehicle_entry SET amount=? WHERE code=?");
        $update_query->execute([$entry_cost,$entry_code]);


        $update_transaction_query = $connect->prepare("UPDATE transactions SET amount=? WHERE code=?");
        $update_transaction_query->execute([$entry_cost,$entry_transaction]);

        //Print Receipt
        //Print the Receipt for that Bus 
        /* Variables (Replace with actual data as needed) */
        $receiptNumber = "$entry_transaction"; // Replace with actual receipt number
        $plateNumber = "$the_vehicle_plate"; // Replace with actual plate number
        $checkInTime = date('H:i:s'); // Replace with actual check-in time
        $allowedDuration = $vehicle_category_minutes; // Allowed duration in hours
        

        // Example check-out time (3 hours later); replace with actual check-out time
        $checkOutTime = date('H:i:s', strtotime('+'.($vehicle_category_minutes - 30).' minutes'));

        // Calculate total stay duration in hours
        $checkInTimestamp = strtotime($checkInTime);
        $checkOutTimestamp = strtotime($checkOutTime);
     

        /* Header */
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("*********************************\n");
        $printer -> text("   Kwekwe City Council - Bus Rank   \n");
        $printer -> text("      P.O Box 115. Kwekwe         \n");
        $printer -> text("    Tel: 055 – 25 – 22301/7      \n");
        $printer -> text("*********************************\n");
        $printer -> text("\n");
        $printer -> text("Receipt No: $entry_transaction\n");
        $printer -> text("Date: " . date('Y-m-d H:i:s') . "\n");
        $printer -> text("\n");

        /* Bus Details */
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> text("Plate Number: $plateNumber\n");
        
        $printer -> text("-------------------------------\n");
        $printer -> text("Overtime Parking Fee:\n");
        $printer -> text("-------------------------------\n");
        $printer -> text("\n");

        /* Fees */
        $printer -> text("Fee Description      Amount\n");
        $printer -> text("-------------------------------\n");
        $printer -> text("Overtime Parking Fee         ".format_money($amount_to_be_paid)."\n");
        $printer -> text("-------------------------------\n");


        /* Total */
        $totalAmount = 10.00 + $overtimeFee ;
        $printer -> setJustification(Printer::JUSTIFY_RIGHT);
        $printer -> text("Total              " . format_money($amount_to_be_paid) . "\n");

        /* Footer */
       $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("\n");
        /* Bold disclaimer */
       $printer -> setEmphasis(true);
        $printer -> text("Disclaimer: Overstaying will carry an additional cost.\n");
        $printer -> setEmphasis(false);
        $printer -> text("\n");
        $printer -> text("Thank you for your payment!\n");
        $printer -> text("Safe travels!\n");
        $printer -> text("\n");
        $printer -> text("*********************************\n");
        $printer -> text("Powered by Cyberselp Incorporation\n");
        $printer -> text("Email: info@cyberselp.com\n");
        $printer -> text("*********************************\n");

        /* Cut the receipt */
        $printer -> cut();
                
        /* Close printer */
        $printer -> close();
        //End Print Receipt for that bus
        //End Print Receipt

        unset($_SESSION['en_code']);

       echo "<script type='text/javascript'>window.location.href='dashboard'</script>";
///
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}
//
/*----------------------------------------------------------------------------------------------------------------------------

                                            CANCEL OVERTIME PAYMENT FOR BUS CODE
----------------------------------------------------------------------------------------------------------------------------*/ 
elseif(isset($_POST["record_overtime_for_vehicle_cancel"])){
    $message = "";
    $alert = "";
    $span = "";

   

    try{ 
        

        unset($_SESSION['en_code']);

       echo "<script type='text/javascript'>window.location.href='dashboard'</script>";
///
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}
/*----------------------------------------------------------------------------------------------------------------------------

                                            CANCEL OVERTIME PAYMENT FOR BUS CODE
----------------------------------------------------------------------------------------------------------------------------*/ 
elseif(isset($_POST["deactivate_vehicle"])){
    $message = "";
    $alert = "";
    $span = "";

   

    try{ 

        $c_id = $_POST["c_id"];

        $update_query = $connect->prepare("UPDATE vehicles SET status=? WHERE id=?");
        $update_query->execute(["deactivated",$c_id]);
        

       echo "<script type='text/javascript'>window.location.href='view_all_vehicles'</script>";
///
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}
/*----------------------------------------------------------------------------------------------------------------------------

                                            CANCEL OVERTIME PAYMENT FOR BUS CODE
----------------------------------------------------------------------------------------------------------------------------*/ 
elseif(isset($_POST["activate_vehicle"])){
    $message = "";
    $alert = "";
    $span = "";

   

    try{ 

        $c_id = $_POST["c_id"];

        $update_query = $connect->prepare("UPDATE vehicles SET status=? WHERE id=?");
        $update_query->execute(["active",$c_id]);
        

       echo "<script type='text/javascript'>window.location.href='view_all_vehicles'</script>";
///
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}
/*----------------------------------------------------------------------------------------------------------------------------

                                            CLOSE BOOMGATE EXIT CODE
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["close_boomgate_exit"])){
    $message = "";
    $alert = "";
    $span = "";

   
    try{ 

        //Update JSON FOR ENTRY
        $filePath = '../includes/methods/exit/boom.json';

        $newContent = 'close';

        // Write the new content to the file
        file_put_contents($filePath, $newContent);

        unset($_SESSION['entry_code']);

        unset($_SESSION['vehicle_entry_done']);

        echo "<script type='text/javascript'>window.location.href='dashboard'</script>";

    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}

/*----------------------------------------------------------------------------------------------------------------------------

                                           GENERATE MONTHLY REPORT CODE
----------------------------------------------------------------------------------------------------------------------------*/ 
elseif (isset($_POST["generate_monthly_report"])) {
    $message = "";
    $alert = "";
    $span = "";


    $choose_year = $_POST["choose_year"];

    try {
        
        $_SESSION["monthly_year_report"] = $choose_year;
        

        echo "<script type='text/javascript'>window.location.href='monthly_statistics'</script>";
    } catch (PDOException $error) {
        $message = $error->getMessage();
    }
}
/*----------------------------------------------------------------------------------------------------------------------------

                                           GENERATE DAILY PERIOD  REPORT CODE
----------------------------------------------------------------------------------------------------------------------------*/ 
elseif (isset($_POST["generate_daily_report"])) {
    $message = "";
    $alert = "";
    $span = "";


    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];

    try {
        
        // Convert start date
        $start_date_formatted = date('Y-m-d', strtotime($start_date));

        // Convert end date
        $end_date_formatted = date('Y-m-d', strtotime($end_date));
        
        $_SESSION["daily_start_date"] = $start_date_formatted;
        $_SESSION["daily_end_date"] = $end_date_formatted;
        
        
        echo "<script type='text/javascript'>window.location.href='daily_statistics'</script>";
        
    } catch (PDOException $error) {
        $message = $error->getMessage();
    }
}
/*----------------------------------------------------------------------------------------------------------------------------

                                           GENERATE DAILY HORLY PERIOD  REPORT CODE
----------------------------------------------------------------------------------------------------------------------------*/ 
elseif (isset($_POST["generate_daily_hourly_report"])) {
    $message = "";
    $alert = "";
    $span = "";


    $the_date = $_POST["the_date"];
   
    try {
        
        // Convert start date
        $the_date = date('Y-m-d', strtotime($the_date));

       
        $_SESSION["daily_hourly_report"] = $the_date;
       
        
        echo "<script type='text/javascript'>window.location.href='daily_hourly_statistics'</script>";
        
    } catch (PDOException $error) {
        $message = $error->getMessage();
    }
}
/*----------------------------------------------------------------------------------------------------------------------------

                                    REGISTER A NEW USER IN THE SYSTEM
----------------------------------------------------------------------------------------------------------------------------*/  
elseif(isset($_POST["register_new_user"])){
    $message = "";
    $alert = "";
    $span = "";
    
    
    $p_name = $_POST["p_name"];
    $p_email = $_POST["p_email"];
    $p_password = $_POST["p_password"];
    $p_account = $_POST["p_account"];
    $p_main_job = "SA Zone D";
    
    try{ 
        
        //SELECT `id`, `username`, `password`, `name`, `phone`, `role`, `main_job`, `last_login_date`, `creation_date`, `modification_date` FROM `users` WHERE 1
        $check_user = $connect->prepare("SELECT * FROM users WHERE username=?");
        $check_user->execute([$p_email]);
        $count_the_user = $check_user->rowCount();
        
        if($count_the_user == 0){
            //Add New User
            $add_user_query = $connect->prepare("INSERT INTO users (username, password, name, role, main_job) VALUES (?,?,?,?,?)");
            $add_user_query->execute([$p_email,md5($p_password),$p_name,$p_account,$p_main_job]);

        
            $message = "<center><b>User successfully registered in the system</b></center>";
            $alert = "alert alert-success alert-dismissible fade show";
        }else{
            $message = "<center>Account Creation failed, check your details and try again, user might already have an account</center>";
            $alert = "alert alert-danger alert-dismissible fade show";
        }
        
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
}

/*----------------------------------------------------------------------------------------------------------------------------

                                    UPDATE USER ACCOUNTS IN THE SYSTEM
----------------------------------------------------------------------------------------------------------------------------*/ 
elseif(isset($_POST["update_person_details"])){
    $c_id = $_POST["c_id"];
    $c_password = $_POST["c_password"];
    
    $update_accounts = $connect->prepare("UPDATE users SET password=? WHERE id=?");
    $update_accounts->execute([md5($c_password),$c_id]);
    
    echo "<script type='text/javascript'>window.location.href='update_users'</script>";
    
    
}

/*----------------------------------------------------------------------------------------------------------------------------

                                    PRINT DAY END REPORT FOR BUS SYSTEM
----------------------------------------------------------------------------------------------------------------------------*/ 
elseif(isset($_POST["print_day_end_report_for_bus"])){
    
    $report_date = $current_date;
    
    //SELECT `id`, `code`, `description`, `amount`, `date`, `link` FROM `transactions` WHERE 1
    $find_total_amount_for_the_day = $connect->prepare("SELECT SUM(amount) AS total_amount_for_the_day FROM transactions WHERE date=?");
    $find_total_amount_for_the_day->execute([$report_date]);
    while($row=$find_total_amount_for_the_day->fetch(PDO::FETCH_ASSOC)){
       $total_amount_for_the_day = $row["total_amount_for_the_day"];
        
       $total_amount_for_the_day = format_money($total_amount_for_the_day);
    }
    
    
             

    /* Header */
    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    $printer -> text("*********************************\n");
    $printer -> text("   Kwekwe City Council - Bus Rank   \n");
    $printer -> text("      P.O Box 115. Kwekwe         \n");
    $printer -> text("    Tel: 055 – 25 – 22301/7      \n");
    $printer -> text("*********************************\n");
    $printer -> text("\n");
    $printer -> text("Day End Report\n");
    $printer -> text("Date: " . date('Y-m-d') . "\n");
    $printer -> text("\n");
    $printer -> text("\n");
    $printer -> text("-------------------------------\n");
    $printer -> text("Total Amount : $total_amount_for_the_day\n");
    $printer -> text("-------------------------------\n");
    $printer -> text("\n");
    $printer -> text("\n");
    

    /* Bus Details */
    $printer -> setJustification(Printer::JUSTIFY_LEFT);
    $printer -> text("-------------------------------\n");
    $printer -> text("Details Per Category\n");
    $printer -> text("-------------------------------\n");
    
    $find_all_categories = $connect->prepare("SELECT * FROM categories");
    $find_all_categories->execute();
    while($row=$find_all_categories->fetch(PDO::FETCH_ASSOC)){
        $ve_cat_code = $row["code"];
        $ve_cat_name = $row["name"];
        
        $find_total_amounts_for_categories_query = $connect->prepare("SELECT SUM(amount) AS total_category_amount FROM transactions WHERE link IN (SELECT code FROM vehicles WHERE category=?) AND date=?");
        $find_total_amounts_for_categories_query->execute([$ve_cat_code,$report_date]);
        while($row=$find_total_amounts_for_categories_query->fetch(PDO::FETCH_ASSOC)){
            $total_category_amount = $row["total_category_amount"];
            
            $total_category_amount = format_money($total_category_amount);
        }
        
        $printer -> text("$ve_cat_name  | Amount : $total_category_amount\n");
    }
    
    /* Bus Details */
    $printer -> setJustification(Printer::JUSTIFY_LEFT);
    $printer -> text("-------------------------------\n");
    $printer -> text("Total Vehicles Per Category\n");
    $printer -> text("-------------------------------\n");
    
    $find_all_categories = $connect->prepare("SELECT * FROM categories");
    $find_all_categories->execute();
    while($row=$find_all_categories->fetch(PDO::FETCH_ASSOC)){
        $ve_cat_code = $row["code"];
        $ve_cat_name = $row["name"];
        
        $find_total_amounts_for_categories_query = $connect->prepare("SELECT * FROM transactions WHERE link IN (SELECT code FROM vehicles WHERE category=?) AND date=?");
        $find_total_amounts_for_categories_query->execute([$ve_cat_code,$report_date]);
        $count_of_vehicles_per_category = $find_total_amounts_for_categories_query->rowCount();
        
        $printer -> text("$ve_cat_name  || : $count_of_vehicles_per_category\n");
    }
    
    $printer -> text("\n");
    $printer -> text("\n");
    /* Bus Details */
    $printer -> setJustification(Printer::JUSTIFY_LEFT);
    $printer -> text("-------------------------------\n");
    $printer -> text("Error Tickets\n");
    $printer -> text("-------------------------------\n");
    $printer -> text("Total Error Tickets :.............\n");
    $printer -> text("-------------------------------\n");
    $printer -> text("\n");
    $printer -> text("-------------------------------\n");
    $printer -> text("Any Comments Write Below\n");
    $printer -> text("-------------------------------\n");
    $printer -> text("\n");
    $printer -> text("\n");
    $printer -> text("\n");
    $printer -> text("\n");
    $printer -> text("\n");
    $printer -> text("\n");
    $printer -> text("-------------------------------\n");
    $printer -> text("Checked by : ________________\n");
    $printer -> text("-------------------------------\n");
    $printer -> text("-------------------------------\n");
    $printer -> text("Signature : ________________\n");
    $printer -> text("-------------------------------\n");
    $printer -> text("\n");
    $printer -> text("-------------------------------\n");
    $printer -> text("Approved by : ________________\n");
    $printer -> text("-------------------------------\n");
    $printer -> text("-------------------------------\n");
    $printer -> text("Signature : ________________\n");
    $printer -> text("-------------------------------\n");
    
    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    $printer -> text("*********************************\n");
    $printer -> text("Powered by Cyberselp Incorporation\n");
    $printer -> text("Email: info@cyberselp.com\n");
    $printer -> text("*********************************\n");
    
    
    

                /* Cut the receipt */
                $printer -> cut();
                
                /* Close printer */
                $printer -> close();
                //End Print Receipt for that bus*/
    
    echo "<script type='text/javascript'>window.location.href='dashboard'</script>";
    
    
}
/*----------------------------------------------------------------------------------------------------------------------------

                                    PRINT DAY END REPORT FOR BUS SYSTEM
----------------------------------------------------------------------------------------------------------------------------*/ 
elseif(isset($_POST["check_and_open_for_vehicles_who_still_have_minutes"])){
    
    $message = "";
    $alert = "";
    $span = "";
    
    
    $new_vehicle_plate = strtoupper($_POST["new_vehicle_plate"]);
    
    
    try{ 
        
        //SELECT `id`, `code`, `vehicle`, `entrance_time`, `exit_time`, `status`, `date`, `time`, `minutes`, `transaction`, `amount` FROM `vehicle_entry` WHERE 1
        $find_vehicle_entry_query = $connect->prepare("SELECT * FROM vehicle_entry WHERE vehicle=? AND date=? ORDER BY id DESC LIMIT 1");
        $find_vehicle_entry_query->execute([$new_vehicle_plate,$current_date]);
        $count_found_vehicle_entries = $find_vehicle_entry_query->rowCount();
        
        if($count_found_vehicle_entries == 1){
            while($row=$find_vehicle_entry_query->fetch(PDO::FETCH_ASSOC)){
                $ve_entrance_time = $row["entrance_time"];
                $ve_vehicle = $row["vehicle"];
            }
            
            $find_ve_details_query = $connect->prepare("SELECT * FROM vehicles WHERE plate=?");
            $find_ve_details_query->execute([$ve_vehicle]);
            while($row=$find_ve_details_query->FETCH(PDO::FETCH_ASSOC)){
                $ve_category = $row["category"];
            }
            
            $find_ve_category_details_query = $connect->prepare("SELECT * FROM categories WHERE code=?");
            $find_ve_category_details_query->execute([$ve_category]);
            while($row=$find_ve_category_details_query->fetch(PDO::FETCH_ASSOC)){
                $ve_cat_minutes = $row["minutes"];
            }
            
            
            $total_minutes_for_vehicle = calculateMinutesToTargetTime($ve_entrance_time);
            
            if($total_minutes_for_vehicle < $ve_cat_minutes){
                //Allow Open
                //Update JSON FOR ENTRY
                $filePath = '../includes/methods/entrance/boom.json';

                $newContent = 'open';

                // Write the new content to the file
                file_put_contents($filePath, $newContent);
                
                $message = "<center>Boomgate is Open</center>";
                $alert = "alert alert-primary alert-dismissible fade show"; 
                
            }else{
               $message = "<center>Vehicle has exceeded its time in the rank : $total_minutes_for_vehicle minutes</center>";
                $alert = "alert alert-danger alert-dismissible fade show"; 
            }
                
        }else{
            $message = "<center>Vehicle not found</center>";
            $alert = "alert alert-danger alert-dismissible fade show";   
        }
     
        
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
    
}

/*----------------------------------------------------------------------------------------------------------------------------

                                    RECORD AND ACTION FAULT ERROR IN THE SYSTEM
----------------------------------------------------------------------------------------------------------------------------*/ 
elseif(isset($_POST["record_and_action_fault_error"])){
    
    $message = "";
    $alert = "";
    $span = "";

    $ve_transaction_code = $_POST["ve_transaction_code"];
    $ve_fault_category = $_POST["ve_fault_category"];
    
    try{
        
        $check_transaction = $connect->prepare("SELECT * FROM vehicle_entry WHERE code=?");
        $check_transaction->execute([$ve_transaction_code]);
        $count_transactions = $check_transaction->rowCount();

        if($count_transactions == 1){

            while($row=$check_transaction->fetch(PDO::FETCH_ASSOC)){
                //SELECT `id`, `code`, `vehicle`, `entrance_time`, `exit_time`, `status`, `date`, `time`, `minutes`, `transaction`, `amount` FROM `vehicle_entry` WHERE 1
                $ve_en_id = $row["id"];
                $ve_en_code = $row["code"];
                $ve_en_vehicle = $row["vehicle"];
                $ve_en_entrance_time = $row["entrance_time"];
                $ve_en_amount = $row["amount"];
                $ve_en_transaction = $row["transaction"];
            }

            $record_fault_error_query = $connect->prepare("INSERT INTO reported_faults (transaction_code, category, amount, date, user, vehicle) VALUES (?,?,?,?,?,?)");
            $record_fault_error_query->execute([$ve_transaction_code,$ve_fault_category,$ve_en_amount,$current_date,$user,$ve_en_vehicle]);

            //Delete Vehicle Entry
            //$delete_vehicle_entry_query = $connect->prepare("DELETE FROM vehicle_entry WHERE code=?");
            //$delete_vehicle_entry_query->execute([$ve_transaction_code]);

            //Delete Transaction 
            //$delete_transaction_query = $connect->prepare("DELETE FROM `transactions` WHERE code=?");
            //$delete_transaction_query->execute([$ve_en_transaction]);

            if($ve_fault_category == "new_vehicle"){
                //Remove Vehicle 
               // $delete_vehicle_query = $connect->prepare("DELETE FROM `vehicles` WHERE plate=?");
               // $delete_vehicle_query->execute([$ve_en_vehicle]);
            }

            $message = "<center>Vehicle Fault successfully Reported and will be actioned by your Supervisor</center>";
            $alert = "alert alert-danger alert-dismissible fade show";   
        }

    
            
        
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
    
}

/*----------------------------------------------------------------------------------------------------------------------------

                                    GENERATE THE CASHIER REPORT IN THE SYSTEM
----------------------------------------------------------------------------------------------------------------------------*/ 
elseif(isset($_POST["generate_cashup_report_for_cashier"])){
    
    $message = "";
    $alert = "";
    $span = "";

    $cashier_reporter = $_POST["cashier_reporter"];
  
    try{

        $_SESSION["cashup_report"] = $cashier_reporter;
        
        
        echo "<script type='text/javascript'>window.location.href='cashup_report_for_employee_for_the_day'</script>";
    

    
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
    
}
/*----------------------------------------------------------------------------------------------------------------------------

                                    GENERATE THE DAY END  REPORT FOR THE OTHER DAYS IN THE SYSTEM
----------------------------------------------------------------------------------------------------------------------------*/ 
elseif(isset($_POST["generate_cashup_report_for_the_otherday"])){
    
    $message = "";
    $alert = "";
    $span = "";

    $report_date = $_POST["report_date"];
  
    try{

        $_SESSION["report_date"] = $report_date;
        
        
        echo "<script type='text/javascript'>window.location.href='cashup_report_for_employee_for_the_other_day'</script>";
    

    
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
    
}
/*----------------------------------------------------------------------------------------------------------------------------

                                    ACTION CASHUP REPORT FOR CASHIER IN THE SYSTEM
----------------------------------------------------------------------------------------------------------------------------*/ 
elseif(isset($_POST["action_void_transaction"])){
    
    $message = "";
    $alert = "";
    $span = "";

    $the_id = $_POST["the_id"];
  
    try{

        $find_void_transactions_query = $connect->prepare("SELECT * FROM reported_faults WHERE id=?");
        $find_void_transactions_query->execute([$the_id]);
        while($row=$find_void_transactions_query->fetch(PDO::FETCH_ASSOC)){
            //SELECT `id`, `transaction_code`, `category`, `amount`, `date`, `user`, `vehicle` FROM `reported_faults` WHERE 1
            $vo_transaction_code = $row["transaction_code"];
            $vo_category = $row["category"];
            $vo_amount = $row["amount"];
            $vo_date = $row["date"];
            $vo_user = $row["user"];
            $vo_vehicle = $row["vehicle"];
        }

        $find_ve_entry_query = $connect->prepare("SELECT * FROM vehicle_entry WHERE code=?");
        $find_ve_entry_query->execute([$vo_transaction_code]);
        while($row=$find_ve_entry_query->fetch(PDO::FETCH_ASSOC)){
            $ve_en_transaction = $row["transaction"];
        }

        $delete_transaction_query = $connect->prepare("DELETE FROM transactions WHERE code=?");
        $delete_transaction_query->execute([$ve_en_transaction]);

        $delete_vehicle_entry_query = $connect->prepare("DELETE FROM vehicle_entry WHERE code=?");
        $delete_vehicle_entry_query->execute([$vo_transaction_code]);

        $update_void_transaction_query = $connect->prepare("UPDATE reported_faults SET status='actioned' WHERE id=?");
        $update_void_transaction_query->execute([$the_id]);

        if($vo_category == "new_vehicle"){
            //Remove Vehicle 
           $delete_vehicle_query = $connect->prepare("DELETE FROM `vehicles` WHERE plate=?");
           $delete_vehicle_query->execute([$ve_en_vehicle]);
        }   
        
        
        echo "<script type='text/javascript'>window.location.href='void_transactions'</script>";
    

    
    }catch(PDOException $error){
        $message = $error->getMessage();
    }
    
}
?>