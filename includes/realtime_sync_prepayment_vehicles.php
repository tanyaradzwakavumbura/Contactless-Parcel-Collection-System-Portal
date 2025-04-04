<?php

/*-----------------------------------------------------------------------------------------------------------------------------
                                           CURRENT DATE AND TIME CODE
----------------------------------------------------------------------------------------------------------------------------*/
// Use constants for values that won't change during script execution
define('CURRENT_DATETIME', date('Y-m-d H:i:s'));
define('CURRENT_DATE', date('Y-m-d'));
define('CURRENT_TIME', date('H:i'));
define('CURRENT_YEAR', date('Y'));

require_once('db.php');

try {
    // Connection String for Online Database
    $connect_online = new PDO(
        "mysql:host=$online_host;dbname=$online_dbname",
        $online_username,
        $online_password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Begin transaction on online database
    $connect_online->beginTransaction();

    // 1. First get all records from both tables in offline database
    $offline_prepayments = $connect->query("
        SELECT id, code, amount, amount_left, status, date 
        FROM prepayments
    ")->fetchAll(PDO::FETCH_ASSOC);

    $offline_prepayment_vehicles = $connect->query("
        SELECT id, prepayment, vehicle, date 
        FROM prepayment_vehicles
    ")->fetchAll(PDO::FETCH_ASSOC);

    // 2. Get all records from both tables in online database
    $online_prepayments = $connect_online->query("
        SELECT id, code, amount, amount_left, status, date 
        FROM prepayments
    ")->fetchAll(PDO::FETCH_ASSOC);

    $online_prepayment_vehicles = $connect_online->query("
        SELECT id, prepayment, vehicle, date 
        FROM prepayment_vehicles
    ")->fetchAll(PDO::FETCH_ASSOC);

    // Create maps for both tables
    $offline_prepayments_map = array_column($offline_prepayments, null, 'code');
    $online_prepayments_map = array_column($online_prepayments, null, 'code');
    
    // For prepayment_vehicles, we'll use a composite key of prepayment+vehicle
    $offline_vehicles_map = [];
    $online_vehicles_map = [];
    
    foreach ($offline_prepayment_vehicles as $record) {
        $key = $record['prepayment'] . '_' . $record['vehicle'];
        $offline_vehicles_map[$key] = $record;
    }
    
    foreach ($online_prepayment_vehicles as $record) {
        $key = $record['prepayment'] . '_' . $record['vehicle'];
        $online_vehicles_map[$key] = $record;
    }

    // Prepare statements for prepayment_vehicles table
    $insert_vehicle_stmt = $connect_online->prepare("
        INSERT INTO prepayment_vehicles (prepayment, vehicle, date) 
        VALUES (:prepayment, :vehicle, :date)
    ");

    $update_vehicle_stmt = $connect_online->prepare("
        UPDATE prepayment_vehicles 
        SET date = :date
        WHERE prepayment = :prepayment AND vehicle = :vehicle
    ");

    $delete_vehicle_stmt = $connect_online->prepare("
        DELETE FROM prepayment_vehicles 
        WHERE prepayment = :prepayment AND vehicle = :vehicle
    ");

    // Prepare statements for online database
    $insert_stmt = $connect_online->prepare("
        INSERT INTO prepayments (code, amount, amount_left, status, date) 
        VALUES (:code, :amount, :amount_left, :status, :date)
    ");

    $update_stmt = $connect_online->prepare("
        UPDATE prepayments 
        SET amount = :amount, 
            amount_left = :amount_left, 
            status = :status, 
            date = :date
        WHERE code = :code
    ");

    $delete_stmt = $connect_online->prepare("
        DELETE FROM prepayments WHERE code = :code
    ");

    $insert_count = 0;
    $update_count = 0;
    $delete_count = 0;
    $vehicle_insert_count = 0;
    $vehicle_update_count = 0;
    $vehicle_delete_count = 0;

    // Sync prepayment_vehicles
    foreach ($offline_prepayment_vehicles as $offline_record) {
        $key = $offline_record['prepayment'] . '_' . $offline_record['vehicle'];
        
        if (!isset($online_vehicles_map[$key])) {
            // New record - Insert
            $insert_vehicle_stmt->execute([
                'prepayment' => $offline_record['prepayment'],
                'vehicle' => $offline_record['vehicle'],
                'date' => $offline_record['date']
            ]);
            $vehicle_insert_count++;
        } else {
            // Existing record - Check if update needed
            $online_record = $online_vehicles_map[$key];
            
            if ($offline_record['date'] != $online_record['date']) {
                // Update online record
                $update_vehicle_stmt->execute([
                    'prepayment' => $offline_record['prepayment'],
                    'vehicle' => $offline_record['vehicle'],
                    'date' => $offline_record['date']
                ]);
                $vehicle_update_count++;
            }
        }
    }

    // Process deletions for prepayment_vehicles
    foreach ($online_vehicles_map as $key => $online_record) {
        if (!isset($offline_vehicles_map[$key])) {
            // Record exists online but not offline - Delete it
            $delete_vehicle_stmt->execute([
                'prepayment' => $online_record['prepayment'],
                'vehicle' => $online_record['vehicle']
            ]);
            $vehicle_delete_count++;
        }
    }

    // Process each offline record for inserts and updates to online
    foreach ($offline_prepayments as $offline_record) {
        if (!isset($online_prepayments_map[$offline_record['code']])) {
            // New record - Insert to online
            $insert_stmt->execute([
                'code' => $offline_record['code'],
                'amount' => $offline_record['amount'],
                'amount_left' => $offline_record['amount_left'],
                'status' => $offline_record['status'],
                'date' => $offline_record['date']
            ]);
            $insert_count++;
        } else {
            // Existing record - Check if update needed
            $online_record = $online_prepayments_map[$offline_record['code']];
            
            if ($offline_record['amount'] != $online_record['amount'] ||
                $offline_record['amount_left'] != $online_record['amount_left'] ||
                $offline_record['status'] != $online_record['status'] ||
                $offline_record['date'] != $online_record['date']) {
                
                // Update online record
                $update_stmt->execute([
                    'code' => $offline_record['code'],
                    'amount' => $offline_record['amount'],
                    'amount_left' => $offline_record['amount_left'],
                    'status' => $offline_record['status'],
                    'date' => $offline_record['date']
                ]);
                $update_count++;
            }
        }
    }

    // Process deletions - check for records in online that don't exist in offline
    foreach ($online_prepayments_map as $code => $online_record) {
        if (!isset($offline_prepayments_map[$code])) {
            // Record exists online but not offline - Delete it
            $delete_stmt->execute(['code' => $code]);
            $delete_count++;
        }
    }

    // Commit all changes to online database
    $connect_online->commit();
    echo "Synchronization completed successfully.\n";
    echo "Prepayments - Inserted: $insert_count, Updated: $update_count, Deleted: $delete_count records.\n";
    echo "Prepayment Vehicles - Inserted: $vehicle_insert_count, Updated: $vehicle_update_count, Deleted: $vehicle_delete_count records.";

} catch (PDOException $e) {
    if (isset($connect_online) && $connect_online->inTransaction()) {
        $connect_online->rollBack();
    }
    error_log("Error in realtime_sync_prepayments.php: " . $e->getMessage());
    echo "An error occurred during synchronization: " . $e->getMessage();
}
?>