<?php
if(isset($_COOKIE["user"])){
    $user = $_COOKIE["user"];
    $get_details = $connect->prepare("SELECT * FROM users WHERE email=?");
    $get_details->execute([$user]);
    while($row=$get_details->fetch(PDO::FETCH_ASSOC)){
        $account = $row["account"];
        $name = $row["name"];
        $surname = $row["surname"];
        $phone = $row["phone"];
        $avatar = $row["avatar"];
        
        
    }
    
    //Find All Your Projects
    $find_projects = $connect->prepare("SELECT * FROM user_projects WHERE username=?");
    $find_projects->execute([$user]);
    $count_projects = $find_projects->rowCount();

}elseif(isset($_COOKIE["admin"])){
    $user = $_COOKIE["admin"];
    $get_details = $connect->prepare("SELECT * FROM users WHERE email=?");
    $get_details->execute([$user]);
    while($row=$get_details->fetch(PDO::FETCH_ASSOC)){
        $account = $row["account"];
        $name = $row["name"];
        $surname = $row["surname"];
        $phone = $row["phone"];
        $avatar = $row["avatar"];     
    }
    //All Users or Investers on KurimaOnline
    $find_all_users = $connect->prepare("SELECT * FROM users WHERE account=?");
    $acc = "user";
    $find_all_users->execute([$acc]);
    $count_all_users = $find_all_users->rowCount();
    
    //All Ongoing projects on KurimaOnline
    $find_all_projects = $connect->prepare("SELECT * FROM projects WHERE status=?");
    $live = "live";
    $find_all_projects->execute([$live]);
    $count_live_projects = $find_all_projects->rowCount();
    
    
}

//All Ongoing projects on KurimaOnline
$find_all_projects = $connect->prepare("SELECT * FROM projects WHERE status=?");
$live = "live";
$find_all_projects->execute([$live]);
$count_live_projects = $find_all_projects->rowCount();
?>