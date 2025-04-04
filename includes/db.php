<?php
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
$dbname = "cpcs";
$username = "root";
$password = "";



$connect = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
$connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);




?>