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

    // 1. First get all records from offline database (source of truth)
    $offline_records = $connect->query("
        SELECT id, code, vehicle, entrance_time, exit_time, status, date, time, minutes, transaction, amount 
        FROM vehicle_entry
    ")->fetchAll(PDO::FETCH_ASSOC);

    // 2. Get all records from online database
    $online_records = $connect_online->query("
        SELECT id, code, vehicle, entrance_time, exit_time, status, date, time, minutes, transaction, amount 
        FROM vehicle_entry
    ")->fetchAll(PDO::FETCH_ASSOC);

    // Create associative arrays for easier comparison
    $offline_map = [];
    $online_map = [];
    
    foreach ($offline_records as $record) {
        $offline_map[$record['code']] = $record;
    }
    
    foreach ($online_records as $record) {
        $online_map[$record['code']] = $record;
    }

    // Prepare statements for online database
    $insert_stmt = $connect_online->prepare("
        INSERT INTO vehicle_entry (code, vehicle, entrance_time, exit_time, status, date, time, minutes, transaction, amount) 
        VALUES (:code, :vehicle, :entrance_time, :exit_time, :status, :date, :time, :minutes, :transaction, :amount)
    ");

    $update_stmt = $connect_online->prepare("
        UPDATE vehicle_entry 
        SET vehicle = :vehicle, 
            entrance_time = :entrance_time, 
            exit_time = :exit_time, 
            status = :status, 
            date = :date, 
            time = :time, 
            minutes = :minutes, 
            transaction = :transaction, 
            amount = :amount
        WHERE code = :code
    ");

    $delete_stmt = $connect_online->prepare("
        DELETE FROM vehicle_entry WHERE code = :code
    ");

    $insert_count = 0;
    $update_count = 0;
    $delete_count = 0;

    // Process each offline record for inserts and updates to online
    foreach ($offline_records as $offline_record) {
        if (!isset($online_map[$offline_record['code']])) {
            // New record - Insert to online
            $insert_stmt->execute([
                'code' => $offline_record['code'],
                'vehicle' => $offline_record['vehicle'],
                'entrance_time' => $offline_record['entrance_time'],
                'exit_time' => $offline_record['exit_time'],
                'status' => $offline_record['status'],
                'date' => $offline_record['date'],
                'time' => $offline_record['time'],
                'minutes' => $offline_record['minutes'],
                'transaction' => $offline_record['transaction'],
                'amount' => $offline_record['amount']
            ]);
            $insert_count++;
        } else {
            // Existing record - Check if update needed
            $online_record = $online_map[$offline_record['code']];
            
            if ($offline_record['vehicle'] != $online_record['vehicle'] ||
                $offline_record['entrance_time'] != $online_record['entrance_time'] ||
                $offline_record['exit_time'] != $online_record['exit_time'] ||
                $offline_record['status'] != $online_record['status'] ||
                $offline_record['date'] != $online_record['date'] ||
                $offline_record['time'] != $online_record['time'] ||
                $offline_record['minutes'] != $online_record['minutes'] ||
                $offline_record['transaction'] != $online_record['transaction'] ||
                $offline_record['amount'] != $online_record['amount']) {
                
                // Update online record
                $update_stmt->execute([
                    'code' => $offline_record['code'],
                    'vehicle' => $offline_record['vehicle'],
                    'entrance_time' => $offline_record['entrance_time'],
                    'exit_time' => $offline_record['exit_time'],
                    'status' => $offline_record['status'],
                    'date' => $offline_record['date'],
                    'time' => $offline_record['time'],
                    'minutes' => $offline_record['minutes'],
                    'transaction' => $offline_record['transaction'],
                    'amount' => $offline_record['amount']
                ]);
                $update_count++;
            }
        }
    }

    // Process deletions - check for records in online that don't exist in offline
    foreach ($online_map as $code => $online_record) {
        if (!isset($offline_map[$code])) {
            // Record exists online but not offline - Delete it
            $delete_stmt->execute(['code' => $code]);
            $delete_count++;
        }
    }

    // Commit all changes to online database
    $connect_online->commit();
    echo "Synchronization completed successfully. Inserted: $insert_count, Updated: $update_count, Deleted: $delete_count records.";

} catch (PDOException $e) {
    if (isset($connect_online) && $connect_online->inTransaction()) {
        $connect_online->rollBack();
    }
    error_log("Error in realtime_sync_vehicle_entry.php: " . $e->getMessage());
    echo "An error occurred during synchronization: " . $e->getMessage();
}
?>