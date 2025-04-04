<?php
/*-----------------------------------------------------------------------------------------------------------------------------
                                           EMAIL API PHPMAILER CODE
----------------------------------------------------------------------------------------------------------------------------*/
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception;

require '../assets/mailer/src/Exception.php';
require '../assets/mailer/src/PHPMailer.php';
require '../assets/mailer/src/SMTP.php';

$mail = new PHPMailer; 
 
$mail->isSMTP();                      // Set mailer to use SMTP 
$mail->Host = 'smtp.hostinger.com';       // Specify main and backup SMTP servers 
$mail->SMTPAuth = true;               // Enable SMTP authentication 
$mail->Username = 'admin@hopebiblecollege.com';   // SMTP username 
$mail->Password = 'Hope@2023';   // SMTP password 
$mail->SMTPSecure = 'ssl';            // Enable TLS encryption, `ssl` also accepted 
$mail->Port = 465;

// Sender info 
$mail->setFrom('admin@hopebiblecollege.com', 'Hope Bible College Portal'); 
$mail->addReplyTo('admin@hopebiblecollege.com', 'Hope Bible College Portal');

$mail->isHTML(true);
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


$find_all_users = $connect->prepare("SELECT * FROM users");
$find_all_users->execute();
while($row=$find_all_users->fetch(PDO::FETCH_ASSOC)){
    $user_email = $row["email"];
    $user_username = $row["username"];
    $user_name = $row["name"];
    $user_surname = $row["surname"];
    
    
    if($user_email != ""){
        //Send Email to User
        $mail->addAddress($user_email); 
                                                    
        $mail->Subject = 'Hope Bible College New Portal'; 
 
        // Mail body content 
        $bodyContent = "<p>Hi there $user_name $user_surname<br>We are proud to announce that we have upgraded the Hope Bible Portal and website and have generated a Registration Number for you, please keep it safe</p><br><br>";
                        
                        
        $bodyContent .= "Your account has successfully been created for you<br>";
        $bodyContent .= "Registration Number : <b>$user_username</b><br>";
        $bodyContent .= "Username : <b>$user_username</b><br>";
        $bodyContent .= "Password : <b>password</b><br>";
                        

        $bodyContent .= "<a href='https://hopebiblecollege.com/portal/index'>Click Here to login to the HBC Portal</a>";
                                                
        $mail->Body  = $bodyContent;
                                                    
        $mail->send();
        //Clear Cache
        $mail->clearAllRecipients( );
        //End Send Email to User
    }
}
?>