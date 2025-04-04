<?php
/*----------------------------------------------------------------------------------------------------------------------------

                                            DATABASE CONNECTION CODE
----------------------------------------------------------------------------------------------------------------------------*/
include("../db.php");

$searchTerm = $_GET['term'];
$stat = "active";

//SELECT `id`, `code`, `plate`, `category`, `driver`, `status`, `date` FROM `vehicles` WHERE 1

$find_all_debt_accounts = $connect->prepare("SELECT * FROM vehicles WHERE status=? AND plate LIKE '%".$searchTerm."%' LIMIT 5");
$the_year = date("Y");
$find_all_debt_accounts->execute([$stat]);
while($row=$find_all_debt_accounts->fetch(PDO::FETCH_ASSOC)){
   $data[] = $row["plate"]; 
}

echo json_encode($data);


?>
