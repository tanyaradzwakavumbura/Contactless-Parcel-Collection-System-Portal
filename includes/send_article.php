<?php
/*----------------------------------------------------------------------------------------------------------------------------

                                            DATABASE CONNECTION CODE
----------------------------------------------------------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------------------------------------------------------

                                            DATABASE CONNECTION CODE
----------------------------------------------------------------------------------------------------------------------------*/
ini_set('session.cookie_httponly',true);
session_start();
if(isset($_SESSION["last_ip"]) == false){
    $_SESSION["last_ip"] = $_SERVER["REMOTE_ADDR"];
}
if($_SESSION["last_ip"] != $_SERVER["REMOTE_ADDR"]){
    session_unset();
    session_destroy();
}
date_default_timezone_set("Africa/Harare");

$host = "localhost";
$dbname = "hopebiblecollege";
$username = "root";
$password = "";


$connect = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
$connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$user = $_SESSION["hopeuser"];

/*-----------------------------------------------------------------------------------------------------------------------------
                                           CURRENT DATE AND TIME CODE
----------------------------------------------------------------------------------------------------------------------------*/
$current_datetime = date("Y-m-d H:i:s"); 
$current_date = date("Y-m-d"); 
$current_time = date("H:i:s"); 

//hope_user
$article_name = $_POST["article_name"];
$article = $_POST["article"];
//Article Image
$article_images = array("1","2","3","4","5","6");
$rand_image = array_rand($article_images);

$add_to_db = $connect->prepare("INSERT INTO articles (article_name,article,created_by,article_image,date) VALUES (?,?,?,?,?)");
$add_to_db->execute([$article_name,$article,$user,$rand_image,$current_date]);
echo 1;
?>
