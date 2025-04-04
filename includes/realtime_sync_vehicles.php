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
    $offline_records = $connect->query("SELECT id, code, plate, category, driver, status, date FROM vehicles")->fetchAll(PDO::FETCH_ASSOC);

    // 2. Get all records from online database
    $online_records = $connect_online->query("SELECT id, code, plate, category, driver, status, date FROM vehicles")->fetchAll(PDO::FETCH_ASSOC);

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
        INSERT INTO vehicles (code, plate, category, driver, status, date) 
        VALUES (:code, :plate, :category, :driver, :status, :date)
    ");

    $update_stmt = $connect_online->prepare("
        UPDATE vehicles 
        SET plate = :plate, category = :category, driver = :driver, 
            status = :status, date = :date
        WHERE code = :code
    ");

    $delete_stmt = $connect_online->prepare("
        DELETE FROM vehicles WHERE code = :code
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
                'plate' => $offline_record['plate'],
                'category' => $offline_record['category'],
                'driver' => $offline_record['driver'],
                'status' => $offline_record['status'],
                'date' => $offline_record['date']
            ]);
            $insert_count++;
        } else {
            // Existing record - Check if update needed
            $online_record = $online_map[$offline_record['code']];
            
            if ($offline_record['plate'] != $online_record['plate'] ||
                $offline_record['category'] != $online_record['category'] ||
                $offline_record['driver'] != $online_record['driver'] ||
                $offline_record['status'] != $online_record['status']) {
                
                // Update online record
                $update_stmt->execute([
                    'code' => $offline_record['code'],
                    'plate' => $offline_record['plate'],
                    'category' => $offline_record['category'],
                    'driver' => $offline_record['driver'],
                    'status' => $offline_record['status'],
                    'date' => $offline_record['date']
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
    error_log("Error in realtime_sync_vehicles.php: " . $e->getMessage());
    echo "An error occurred during synchronization: " . $e->getMessage();
}
?>