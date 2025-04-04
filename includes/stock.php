<?php

$host = "localhost";
$dbname = "procurement";
$username = "root";
$password = "";

$connect = new PDO("mysql:host=$host;port=3308;dbname=$dbname",$username,$password);
$connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);


$searchTerm = $_GET['term'];
$find_tags = $connect->prepare("SELECT * FROM stock WHERE product LIKE '%".$searchTerm."%' ");
$find_tags->execute();
while($row=$find_tags->fetch(PDO::FETCH_ASSOC)){
    $data[] = $row["product"];
}

echo json_encode($data);

?>
