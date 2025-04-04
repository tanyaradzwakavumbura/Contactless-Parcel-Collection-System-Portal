<?php

include("db.php");

try {

    // Get data from AJAX request
    $parcel_size = $_POST['parcel_size'] ?? '';
    $parcel_province = $_POST['parcel_sent_to_province'] ?? '';

    // Prepare and execute SQL query
    if (!empty($parcel_size) && !empty($parcel_province)) {
        $sql = "SELECT code FROM lockers 
                WHERE size = :parcel_size AND location = :parcel_province AND status = 1
                LIMIT 1";

        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':parcel_size', $parcel_size, PDO::PARAM_STR);
        $stmt->bindParam(':parcel_province', $parcel_province, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            echo $row['code']; // Return locker name
        } else {
            echo "No available locker"; // If no matching locker found
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
