<?php
session_start();
require_once("../db.php");

$find_all_vehicles_query = $connect->prepare("SELECT * FROM vehicles WHERE status=? AND plate IN (SELECT vehicle FROM vehicle_entry WHERE status=?)");
$stat_found = "active";
$another_stat = "open";
$find_all_vehicles_query->execute([$stat_found, $another_stat]);

$vehicles = [];
while($row = $find_all_vehicles_query->fetch(PDO::FETCH_ASSOC)){
    $vehicles[] = [
        'plate' => $row["plate"],
        'text' => $row["plate"]
    ];
}

header('Content-Type: application/json');
echo json_encode($vehicles);
?> 