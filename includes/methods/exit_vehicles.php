<?php
/*----------------------------------------------------------------------------------------------------------------------------

                                            DATABASE CONNECTION CODE
----------------------------------------------------------------------------------------------------------------------------*/
include("../db.php");

$searchTerm = $_GET['term'];
$stat = "open";

//SELECT `id`, `code`, `plate`, `category`, `driver`, `status`, `date` FROM `vehicles` WHERE 1

$find_all_debt_accounts = $connect->prepare("SELECT * FROM vehicle_entry WHERE status=? AND vehicle LIKE '%".$searchTerm."%' LIMIT 5");
$the_year = date("Y");
$find_all_debt_accounts->execute([$stat]);
while($row=$find_all_debt_accounts->fetch(PDO::FETCH_ASSOC)){
   $data[] = $row["vehicle"]; 
}

echo json_encode($data);


?>
