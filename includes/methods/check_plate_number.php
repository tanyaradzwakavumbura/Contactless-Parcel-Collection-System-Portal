<?php
/*----------------------------------------------------------------------------------------------------------------------------

                                            DATABASE CONNECTION CODE
----------------------------------------------------------------------------------------------------------------------------*/
include("../db.php");

$searchTerm = $_POST['plate_number'];
$stat = "active";

$check_plate_number = $connect->prepare("SELECT * FROM vehicles WHERE plate=?");
$check_plate_number->execute([$searchTerm]);
$count_found_plate_numbers = $check_plate_number->rowCount();

if($count_found_plate_numbers > 0){
   echo json_encode(['available' => false]);
}else{
   echo json_encode(['available' => true]);
}



?>
